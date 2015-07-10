<?php

class UserController extends AController
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
            'upload'=>'application.controllers.upload.UploadFileAction',
		);
	}
    /**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}
    
    public function accessRules()
	{
        parent::accessRules();
		return array(
			array(
                'allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index','checkCode','listStore','administrator','detail','add','addAjax','edit','status','delete'),
                'roles' => array('admin','manager'),
            ),
            array(
                'allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index','checkCode','detail','add','edit','delete','status'),
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
	public function actionIndex()
	{
        Yii::app()->user->setState('typeAccountCurrent','store');
        $this->pageTitle = "List of Accounts";
        $model = new User('search');
        $model->unsetAttributes();
        if(isset($_GET['User']))
            $model->attributes = $_GET['User'];
            
        $this->render($this->view.'index',array(
            'model' => $model
        ));
        
	}
    
    public function actionAdministrator(){
        Yii::app()->user->setState('typeAccountCurrent','system');
        $this->pageTitle = "List of Account Management";
        $model = new User('search');
        $model->unsetAttributes();
        if(isset($_GET['User']))
            $model->attributes = $_GET['User'];
            
        $this->render($this->view.'administrator',array(
            'model' => $model
        ));
    }
    
    public function actionDetail($alias){
        $model = $this->loadModelByPKID($alias);
        $this->pageTitle = 'Detail Account : '.$model->s_username;
        if(Yii::app()->request->isAjaxRequest){
            $this->renderPartial($this->view.'_detail', array('model'=>$model));
        }else{
            $this->render($this->view.'detail', array('model'=>$model));
        }
    }
    public function actionListStore(){
        $store = Store::model()->findAll();
        $data = '<select id="User_s_store_id" name="User[s_store_id]" class="sel-form" style="margin-left: 10px" ><option>Select store</option>';
        
        foreach($store as $r){
            $data.= "<option value='$r->pk_s_id'>$r->s_name</option>";
        }
        $data .= '</select>';
        $data .= '<a class="btnAddStore" id="btnAddStore"><i>&#xf067;</i>Add Store</a>';
        if(Yii::app()->request->isAjaxRequest){
            echo $data;
        }else{
            return $data;
        }
    }
    public function actionAddAjax(){
        $model = new User;
        if(isset($_POST['User'])){
            $model->attributes = $_POST['User'];
            $data = array();
            $mss = '';
            if($this->actionCheckCode(null,$model->s_username,false,'Username',$mss) == false){
                $data['username'] =  $mss;//'Username already exists please choose another';
            }
            if($this->actionCheckCode(null,$model->s_email,false,'Email',$mss) == false){
                $data['email'] =  $mss;//'Email already exists please choose another';
            }
            if( count($data) == 0 ){
                $model->pk_s_id = '-1';
                $model->i_user_role = 3;
                $model->i_shopping = 1;
                $model->i_manager = 1;
                $model->i_active = 0;
                $model->i_lock = 0;
                $model->i_flag_sync = 1;
                $model->i_flag_deleted = 0;
                $model->i_disable = 0;
                $model->s_code_active = $model->randomString(time().'ABCDEFGHIJKLM'.time().time(),8);
                $model->s_token = sha1(base64_encode($model->s_code_active).time());
                $model->i_time_send_code_active = time() + 86400;
                $model->s_secret_code = $model->secretCode();
                $password =  sha1($model->s_secret_code.sha1($model->s_password.$model->s_secret_code));
                $model->s_password = $password;
                if($model->save()){
                    $model->pk_s_id = 'SV'.$model->id;
                    if($model ->save()){
                        $fullname = ($model->s_fullname != '')?$model->s_fullname:$model->s_username;
                        $data['option'] = '<option selected="selected" value ="'.$model->pk_s_id.'">'.$fullname.'</option>';
                        $data['message'] = '<div class="alert alert-success">Success! Account created. </div>';
                    }else{
                        $model->delete();
                        $data['message'] = '<div class="alert alert-danger">Error! Please try again later1.</div>';
                    }
                }else{
                    $data['message'] = json_encode($model->errors);//'<div class="alert alert-danger">Error! Please try again later2.</div>';
                }
            }
            echo json_encode($data);
        }
    }
    public function actionAdd(){
        $model = new User;
        $store = Store::model()->findAll('i_account_manager = 0');
        $typeAccount = (Yii::app()->user->hasState('typeAccountCurrent'))?Yii::app()->user->getState('typeAccountCurrent'):null;
        $this->pageTitle = ($typeAccount != null)?'Add Account Of '.$typeAccount:'Add Account';
        if(isset(Yii::app()->user->storeID)){
            $model->s_store_id = Yii::app()->user->storeID;
            $store = null;
        }
        if(isset($_POST['User']))
		{
			$flagSave = false;
            $pk_s_id = 0;
            $s_image_server = '';
            $password = '';
            $model->attributes=$_POST['User'];
            $model->pk_s_id = '-1';
            $levelAccount = Yii::app()->user->level;
            $role = Roles::model()->findByPk($model->i_user_role);
            $checkStore = Store::model()->find('pk_s_id = :pk_s_id',array(':pk_s_id'=>$model->s_store_id));
            //var_dump($checkStore);exit;
            $model->i_manager = 0;
            $model->i_device_max = intval($model->i_device_max);
            $model->s_code_active = $model->randomString(time().'ABCDEFGHIJKLM'.time().time(),8);
            $model->s_token = sha1(base64_encode($model->s_code_active).time());
            $model->i_time_send_code_active = time() + 86400;
            $model->s_secret_code = $model->secretCode();
            $model->i_active = 0;
            $model->i_lock = 0;
            $model->i_flag_sync = 1;
            $model->i_flag_deleted = 0;
            $model->i_disable = 0;
            if($model->i_user_role == 3){
                $model->i_manager = 1;
            }
            if($checkStore == null){
                $model->s_store_id = null;
            }else{
                $storeManager = $checkStore->userManager();
                if($storeManager != null){
                    $model->addError('i_user_role','The store has managed. Please select user type other or stores other');
                }
            }
            if($role == null){
                $model->addError('i_user_role','Type not exist');
            }elseif($levelAccount < $role->level){
                $model->addError('i_user_role','Your are not authorized to make this type of account');
            }
            $image = CUploadedFile::getInstance($model,'s_image_server');
            if ($image != null) {
                $model->s_image_server = $model->s_username.date("dmHi").'.'.$image->extensionName;
                if($image->saveAs(Yii::app()->basePath.'/../data/users/'.$model->s_image_server)){
                    $imgthumb = Yii::app()->phpThumb->create(Yii::app()->basePath.'/../data/users/'.$model->s_image_server);
                    $imgthumb->resize(240,240);
                    $imgthumb->save(Yii::app()->basePath.'/../data/users/240x240_'.$model->s_image_server);
                    $imgthumb->resize(120,120);
                    $imgthumb->save(Yii::app()->basePath.'/../data/users/120x120_'.$model->s_image_server);  
                    $model->i_sync_image = 1;
                }else{
                    $model->addError('s_image_server','Upload image fail');
                }
            }
            if(count($model->errors) == 0){ 
                if($model->save()){
                    $flagSave = true;
                    $pk_s_id = 'SV'.$model->id;
                    $password = sha1($model->s_secret_code.sha1($model->s_password.$model->s_secret_code));
                    $model->pk_s_id = $pk_s_id;
                    $model->s_password = $password;
                    if($model->save()){
                        $flagSave = true;
                    }else{
                        $flagSave = false;
                        @unlink(Yii::app()->basePath.'/../data/users/'.$model->s_image_server);
                        @unlink(Yii::app()->basePath.'/../data/users/240x240_'.$model->s_image_server);
                        @unlink(Yii::app()->basePath.'/../data/users/120x120_'.$model->s_image_server);
                        $model->delete();
                    }
                }
                if($flagSave == true){
                    $this->redirect(array('index'));
                }
                
            }
        }
		$this->render('create',array(
			'model'=>$model,
            'store' => $store,
            'typeAccount' => $typeAccount,
		));
    }
    
    public function actionEdit($id){
        $typeAccount = (Yii::app()->user->hasState('typeAccountCurrent'))?Yii::app()->user->getState('typeAccountCurrent'):null;
        $this->pageTitle = ($typeAccount != null)?'Edit Account Of '.$typeAccount:'Edit Account';
        $model = $this->loadModel($id);
        $passwordOld = $model->s_password;
        $storeOld = $model->s_store_id;
        $store = Store::model()->findAll('i_account_manager = 0');
        $model->s_password = 'posNail@2015';
        if(isset($_POST['User'])){
			$flagSave = false;
            $flagChangeImage = false;
            $model->attributes=$_POST['User'];
            $levelAccount = Yii::app()->user->level;
            $role = Roles::model()->findByPk($model->i_user_role);
            if($model->s_store_id != $storeOld){
                $checkStore = Store::model()->find('pk_s_id = :pk_s_id',array(':pk_s_id'=>$model->s_store_id));
                if($checkStore == null){
                    $model->s_store_id = $storeOld;
                    $model->addError('s_store_id','Store invalid');
                }
                $storeManager = $checkStore->userManager();
                if($storeManager != null){
                    $model->addError('i_user_role','The store has managed. Please select user type other or stores other');
                }
            }
            $model->i_manager = 0;
            $model->i_device_max = intval($model->i_device_max);
            $model->i_flag_sync = 1;
            if($model->i_user_role == 3){
                $model->i_manager = 1;
            }
            if($role == null){
                $model->addError('i_user_role','Type not exist');
            }elseif($levelAccount < $role->level){
                $model->addError('i_user_role','Your are not authorized to make this type of account');
            }
            if($model->s_password != '' && $model->s_password != 'posNail@2015' && $model->s_password != $passwordOld){
                $password = sha1($model->s_secret_code.sha1($model->s_password.$model->s_secret_code));
                $model->s_password = $password;
            }else{
                $model->s_password = $passwordOld;
            }
            $image = CUploadedFile::getInstance($model,'s_image_server');
            if ($image != null) {
                if($model->s_image_server == ''){
                    $model->s_image_server = $model->s_username.date("dmHi").'.'.$image->extensionName;
                }
                if($image->saveAs(Yii::app()->basePath.'/../data/users/'.$model->s_image_server)){
                    $imgthumb = Yii::app()->phpThumb->create(Yii::app()->basePath.'/../data/users/'.$model->s_image_server);
                    $imgthumb->resize(240,240);
                    $imgthumb->save(Yii::app()->basePath.'/../data/users/240x240_'.$model->s_image_server);
                    $imgthumb->resize(120,120);
                    $imgthumb->save(Yii::app()->basePath.'/../data/users/120x120_'.$model->s_image_server);
                    $model->i_sync_image = 1;
                    $flagChangeImage = true;   
                }else{
                    $model->addError('s_image_server','Upload image fail');
                }
            }
            if(count($model->errors) == 0){ 
                if($model->save()){
                    $flagSave = true;
                }elseif($flagChangeImage == true){
                    $flagSave = false;
                    @unlink(Yii::app()->basePath.'/../data/users/'.$model->s_image_server);
                    @unlink(Yii::app()->basePath.'/../data/users/240x240_'.$model->s_image_server);
                    @unlink(Yii::app()->basePath.'/../data/users/120x120_'.$model->s_image_server);
                }
                if($flagSave == true){
                    $this->redirect(array('index'));
                }
                
            }
        }
		$this->render('create',array(
			'model'=> $model,
            'store' => $store,
            'typeAccount' => $typeAccount,
		));
    }
    
    public function actionStatus($id = null){
        $data = array();
        $model = $this->loadModel($id);
        if($model->status == 1){
            $model->status = 0;
        }else{
            $model->status = 1;
        }
        $model->save();
        $data['status'] = $model->status;
        echo json_encode($data);
        if(!isset($_GET['ajax'])){
            $this->redirect(array('index'));
        }
    }
    
    public function actionDelete($id){
		$model = $this->loadModel($id);
        $model->i_flag_deleted = 1;
        $model->i_disable = 1;
        $model->i_flag_sync = 1;
        $model->save();
        if(Yii::app()->request->isAjaxRequest){
            echo "Delete account with { Username: ".$model->s_username.' } Success';
            Yii::app()->end();
        }
        $this->redirect(array('index'));
	}
    public function actionCheckCode($codeOld = null,$code =  null,$ajax = true,$dataCheck = 'Username',&$mss = ''){
        if(isset($_POST['code']) || $code != null){
            $alias = isset($_POST['code'])?$_POST['code']:$code;
            if(isset($_POST['typeData']) && $_POST['typeData'] != ''){$dataCheck = $_POST['typeData'];}
            if(isset($_POST['codeOld'])){$codeOld = $_POST['codeOld'];}
            if($codeOld != null && $codeOld == $alias){
                $mss = &$dataCheck.' not change';
                if(Yii::app()->request->isAjaxRequest && $ajax == true){
                    echo '<span class="fa" style="color:#1AD20D; font-size:18px">&#xf00c; </span><span style="color:blue"> '.$mss.'</span>|1';
                    Yii::app()->end();
                }
                return true;
            }
            if(!preg_match('/^[a-z]/',$alias)){
                $mss = $dataCheck.' must be starting with a characters';
                if(Yii::app()->request->isAjaxRequest  && $ajax == true){
                    echo '<span class="fa" style="color:red; font-size:18px">&#xf05c; </span><b style="color:red; font-size:12px"> '.$mss.' </b>|0';;
                    Yii::app()->end();
                }
                return false;
            }
            if(preg_match('/\s/',$alias)){
                    $mss = $dataCheck.' can\'t spaces';
                    if(Yii::app()->request->isAjaxRequest  && $ajax == true){
                        echo '<span class="fa" style="color:red; font-size:18px">&#xf05c; </span><b style="color:red; font-size:12px"> '.$mss.'</b>|0';
                        Yii::app()->end();
                    }
                    return false;
                }
            if($dataCheck == 'Username'){
                if(preg_match('/[^a-zA-Z0-9]/',$alias)){
                    $mss = $dataCheck.' can\'t contains special characters';
                    if(Yii::app()->request->isAjaxRequest  && $ajax == true){
                        echo '<span class="fa" style="color:red; font-size:18px">&#xf05c; </span><b style="color:red; font-size:12px"> '.$mss.' </b>|0';
                        Yii::app()->end();
                    }
                    return false;
                }
                if(!preg_match('/^\w{8,16}$/',$alias)){
                    $mss = $dataCheck.'  must be greater than 8 and less than 16 characters';
                    if(Yii::app()->request->isAjaxRequest  && $ajax == true){
                        echo '<span class="fa" style="color:red; font-size:18px">&#xf05c; </span><b style="color:red; font-size:12px"> '.$mss.'</b>|0';
                        Yii::app()->end();
                    }
                    return false;
                }
                $model = $this->loadModelUsername($alias);    
            }elseif($dataCheck == 'Email'){
                if(!filter_var($alias,FILTER_VALIDATE_EMAIL)){
                    $mss = $dataCheck.' invalid';
                    if(Yii::app()->request->isAjaxRequest  && $ajax == true){
                        echo '<span class="fa" style="color:red; font-size:18px">&#xf05c; </span><b style="color:red; font-size:12px"> '.$mss.'</b>|0';
                        Yii::app()->end();
                    }
                    return false;
                }
                $model = $this->loadModelEmail($alias);
            }
            if($model != null){
                $mss = $dataCheck.' existed';
                if(Yii::app()->request->isAjaxRequest  && $ajax == true){
                    echo '<span class="fa" style="color:red; font-size:18px">&#xf05c; </span><b style="color:red; font-size:12px">'.$mss.' </b>|0';
                    Yii::app()->end();
                }
                return false;
            }else{
                if(Yii::app()->request->isAjaxRequest  && $ajax == true){
                    echo '<span class="fa" style="color:#1AD20D; font-size:18px">&#xf00c; </span><span style="color:blue">'.$dataCheck.' valid</span>|1';
                    Yii::app()->end();
                }
                return true;
            }
        }else{
            $mss = $dataCheck.' can\'n not be blank ';
            if(Yii::app()->request->isAjaxRequest  && $ajax == true){
                    echo '<span class="fa" style="color:red; font-size:18px" title="Code invalid">&#xf05c;</span><b style="color:red">'.$mss.'|0</b>';
                    Yii::app()->end();
                }
        }
        return false;
    }
    public function loadModelUsername($username){
        $model = User::model()->find('s_username = :s_username',array(':s_username' => $username));
		if($model===null)
			return null;
		return $model;
    }
    public function loadModelEmail($email){
        $model = User::model()->find('s_email = :s_email',array(':s_email' => $email));
		if($model===null)
			return null;
		return $model;
    }
    public function loadModelByPKID($id){
        $model = User::model()->find('pk_s_id = :pk_s_id',array(':pk_s_id' => $id));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
    }
    public function loadModel($id)
	{
		$model = User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
 }