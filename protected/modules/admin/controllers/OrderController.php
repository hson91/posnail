<?php

class OrderController extends AController
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
                'actions' => array('index','detail','create','edit','editDetail','status','delete'),
                'roles' => array('admin','manager'),
            ),
            array(
                'allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index','detail','create','edit','editDetail','status','delete'),
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
        $this->breadcrumbs = array($this->ID.' Manager'=>array('index'));
        $this->pageTitle = "List of Order";
        $model = new Order('search');
        $model->unsetAttributes();
        if(isset($_GET['Order']))
            $model->attributes = $_GET['Order'];
            
        $this->render($this->view.'index',array(
            'model' => $model
        ));
        
	}
    
    public function actionDetail($alias){
        $model = $this->loadModelByPKID($alias);
        $this->pageTitle = 'Detail Order Code : '.$model->s_order_code;
        $details = $this->loadOrderDetailByOrder($model->pk_s_id,$model->s_store_id);
        if(Yii::app()->request->isAjaxRequest){
            $this->renderPartial($this->view.'_detail', array('model'=>$model,'details' => $details));
        }else{
            $this->render($this->view.'detail', array('model'=>$model,'details' => $details));
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
    public function actionAdd(){
        $model = new Order;
		$this->render('create',array(
			'model'=>$model
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
                if($image->saveAs(Yii::app()->basePath.'/../data/users/'.$model->s_image_server)){
                    $imgthumb = Yii::app()->phpThumb->create(Yii::app()->basePath.'/../data/users/'.$model->s_image_server);
                    $imgthumb->resize(240,240);
                    $imgthumb->save(Yii::app()->basePath.'/../data/users/240x240_'.$model->s_image_server);
                    $imgthumb->resize(120,120);
                    $imgthumb->save(Yii::app()->basePath.'/../data/users/120x120_'.$model->s_image_server);
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
    public function actionEditDetail($id){
        
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
		$this->loadModel($id)->delete();
	}
    public function loadOrderDetailByID($id)
	{
		$model = OrderDetail::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
    public function loadOrderDetailByOrder($orderID,$storeID){
        $models = OrderDetail::model()->findAll('s_order_id = :s_order_id and s_store_id = :s_store_id',array(':s_order_id' =>$orderID,':s_store_id' => $storeID));
		return $models;
    }
    public function loadModelByPKID($id)
	{
		$model = Order::model()->find('pk_s_id = :pk_s_id',array(':pk_s_id' => $id));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
    public function loadModel($id)
	{
		$model = Order::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
 }