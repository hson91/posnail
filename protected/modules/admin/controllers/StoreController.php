<?php
class StoreController extends AController
{
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
                ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array('class' => 'CViewAction', ),
            'upload' => 'application.controllers.upload.UploadFileAction',
            );
    }
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array('accessControl', // perform access control for CRUD operations
                //'postOnly + delete', // we only allow deletion via POST request
            );
    }

    public function accessRules()
    {
        return array(
            array(
                'allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index','login','logout','detail','create','update','status','delete'),
                'roles' => array('admin','manager'),
            ),
            array(
                'allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('logout','detail','update','status'),
                'roles' => array('storeadmin','storemanager'),
            ),
            array(
                'deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    function f_logout(){
        $roleAssigned = Yii::app()->authManager->getRoles(Yii::app()->user->id);
 
        if (!empty($roleAssigned)) { //checks that there are assigned roles
            $auth = Yii::app()->authManager; //initializes the authManager
            foreach ($roleAssigned as $n => $role) {
                if ($auth->revoke($n, Yii::app()->user->id)) //remove each assigned role for this user
                Yii::app()->authManager->save(); //again always save the result
            }
        }
    }
    public function actionLogin($id){
        //$data_array = null;
        //$data = base64_decode(base64_decode($_POST['data']));
        //$data_array = json_encode($data);
        //$username = ($data_array['_u'])?$data_array['_u']:null;
        //$password = ($data_array['_p'])?$data_array['_p']:null;
        $store = $this->loadModel($id);
        $storeManager = $store->userManager();
        if($storeManager != null){
            $model= new LoginForm;
            $model->username = $storeManager->s_username;
            $model->password = $storeManager->s_password;
            $model->linkFirst = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:null;
            $model->actionFirst = 'admin';
            $model->usernameFirst = Yii::app()->user->username;
            $model->passwordFirst = Yii::app()->user->password;
            $model->flagStoreLogin = 1;
            $this->f_logout();
    		if($model->loginWithRole()) {
			     $this->redirect(array('store/detail','id' => $id));
			}else{
			     $this->redirect(array('site/index'));
			}
        }
    }
    public function actionLogout()
	{
	    $actionFirst = Yii::app()->user->actionFirst;
        if($actionFirst == 'admin'){
            $linkFirst = Yii::app()->user->linkFirst;
            $username = Yii::app()->user->usernameFirst;
            $password = Yii::app()->user->passwordFirst;
            $this->f_logout();
            $model= new LoginForm;
            $model->username = $username;
            $model->password = $password;
            $model->linkFirst = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:null;
            $model->actionFirst = null;
            $model->usernameFirst = null;
            $model->passwordFirst = null;
            $model->flagStoreLogin = null;
    		if($model->loginWithRole()) {
    		      if($linkFirst != null){
    		          $this->redirect($linkFirst);
    		      }else{
    		          $this->redirect(array('store/index'));
    		      }
    		}else{
    		     $this->redirect(array('site/login'));
    		}
        }
        $this->redirect(Yii::app()->baseUrl.'/admin/site/logout');
	}
    public function actionIndex()
    {
        $this->pageTitle = "Store Management";
        $model = new Store('search');
        $model->unsetAttributes();
        if (isset($_GET['Store']))
            $model->attributes = $_GET['Store'];
        $this->render($this->view.'index', array('model' => $model));
    }
    public function actionDetail($id){
        $service = new Service('search');
        $customer = new Customer('search');
        $employee = new User('search');
        $model = $this->loadModel($id);
        $this->render($this->view.'detail',array('model' => $model,'customer' => $customer,'employee'=>$employee,'service' => $service));
    }
    public function actionCreate()
    {
        //$this->breadcrumbs = array($this->ID.' Manager'=>array('index'),'Create'=>array('create'));
        $this->pageTitle = "ADD STORE";
        $model = new Store;
        if (isset($_POST['Store'])) {
            $userID = ($_POST['Store']['UserID'] != '')?$_POST['Store']['UserID']:'-1';
            $model->attributes = $_POST['Store'];
            $model->i_status = '0';
            $model->pk_s_id = '-1';
            $model->i_flag_sync = 1;
            $flagSave = false;
            $image = CUploadedFile::getInstance($model,'s_image_server');
            if ($image != null) {
                $model->s_image_server = sha1(time()).date("dmHi").'.'.$image->extensionName;
                if($image->saveAs(Yii::app()->basePath.'/../data/store/'.$model->s_image_server)){
                    $imgthumb = Yii::app()->phpThumb->create(Yii::app()->basePath.'/../data/store/'.$model->s_image_server);
                    $imgthumb->resize(240,240);
                    $imgthumb->save(Yii::app()->basePath.'/../data/store/240x240_'.$model->s_image_server);
                    $imgthumb->resize(120,120);
                    $imgthumb->save(Yii::app()->basePath.'/../data/store/120x120_'.$model->s_image_server);
                    $model->i_sync_image = 1;
                }else{
                    $model->addError('s_image_server','Upload image fail');
                }
            }
            if (count($model->errors) == 0) {
                if ($model->save()) {
                    $flagSave = true;
                    $model->pk_s_id = 'SV'.$model->id;
                    $model->i_status = $model->setStatus();
                    if($model->save()){
                        $flagSave = true;
                        $user = User::model()->find('pk_s_id = :pk_s_id AND i_shopping = 1 AND i_manager = 1 AND s_store_id IS NULL',array('pk_s_id' => $userID));
                        if($user != null){
                            $user->s_store_id = $model->pk_s_id ;
                            $user->save();
                        }
                    }else{
                        $flagSave = false;
                        @unlink(Yii::app()->basePath.'/../data/store/'.$model->s_image_server);
                        @unlink(Yii::app()->basePath.'/../data/store/240x240_'.$model->s_image_server);
                        @unlink(Yii::app()->basePath.'/../data/store/120x120_'.$model->s_image_server);
                        $model->delete();
                    }
                }
            }
            if($flagSave == true){
                $this->redirect(array('index'));
            }
        }
        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($id)
    {
        set_time_limit(0);
        $this->pageTitle = "EDIT STORE";
        $model = $this->loadModel($id);
        if (isset($_POST['Store'])) {
            $userID = ($_POST['Store']['UserID'] != '')?$_POST['Store']['UserID']:'-1';
            $model->attributes = $_POST['Store'];
            $flagSave = false;
            $flagSchangeImage = false;
            $image = CUploadedFile::getInstance($model,'s_image_server');
            if ($image != null) {
                if($model->s_image_server == ''){
                    $model->s_image_server = sha1(time()).date("dmHi").'.'.$image->extensionName;
                }
                if($image->saveAs(Yii::app()->basePath.'/../data/store/'.$model->s_image_server)){
                    $imgthumb = Yii::app()->phpThumb->create(Yii::app()->basePath.'/../data/store/'.$model->s_image_server);
                    $imgthumb->resize(240,240);
                    $imgthumb->save(Yii::app()->basePath.'/../data/store/240x240_'.$model->s_image_server);
                    $imgthumb->resize(120,120);
                    $imgthumb->save(Yii::app()->basePath.'/../data/store/120x120_'.$model->s_image_server);
                    $model->i_sync_image = 1;
                    $flagSchangeImage = true;
                }else{
                    $model->addError('s_image_server','Upload image fail');
                }
            }
            $model->i_status = $model->setStatus();
            if (count($model->errors) == 0) {
                $model->i_flag_sync = 1;
                if ($model->save()) {
                    $flagSave = true;
                    $user = User::model()->find('pk_s_id = :pk_s_id AND i_shopping = 1 AND i_manager = 1 AND s_store_id IS NULL',array('pk_s_id' => $userID));
                    if($user != null){
                        $user->s_store_id = $model->pk_s_id ;
                        $user->save();
                    }
                }elseif($flagSchangeImage == true){
                    $flagSave = false;
                    @unlink(Yii::app()->basePath.'/../data/store/'.$model->s_image_server);
                    @unlink(Yii::app()->basePath.'/../data/store/240x240_'.$model->s_image_server);
                    @unlink(Yii::app()->basePath.'/../data/store/120x120_'.$model->s_image_server);
                }
            }
            if($flagSave == true){
                $this->redirect(array('index'));
            }
        }
        $this->render('create', array('model' => $model));
    }

    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        $model->i_flag_deleted = 1;
        $model->i_disable = 1;
        $model->i_status = '-1';
        $model->i_flag_sync = 1;
        $model->save();
        if(Yii::app()->request->isAjaxRequest){
            echo "Delete store with { ID: ".$model->pk_s_id.' and Store name: '.$model->s_name. ' } Success';
            Yii::app()->end();
        }
        $this->redirect(array('index'));
    }
    public function loadModel($id)
    {
        $model = Store::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
}