<?php

class ServiceTypeController extends AController
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
                'actions' => array('index','detail','add','addAjax','edit','delete'),
                'roles' => array('admin','manager'),
            ),
            array(
                'allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index','detail','add','addAjax','edit','delete'),
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
        $this->pageTitle = "List of Type Service";
        $model = new ServiceType('search');
        $model->unsetAttributes();
        if(isset($_GET['ServiceType']))
            $model->attributes = $_GET['ServiceType'];
            
        $this->render($this->view.'index',array(
            'model' => $model
        ));
        
	}
    public function actionDetail($alias){
        $model = $this->loadModelByPKID($alias);
        $this->pageTitle = 'List of Service with type: '.$model->s_name;
        $models = Service::model()->findAll('s_service_type_id = :s_service_type_id and s_store_id = :s_store_id',array(':s_service_type_id' => $model->pk_s_id,':s_store_id' => $model->s_store_id));
        if(Yii::app()->request->isAjaxRequest){
            $this->renderPartial($this->view.'detail', array('model'=>$model,'models' => $models));
        }else{
            $this->render($this->view.'detail', array('model'=>$model,'models' => $models));
        }
    }
    public function actionAddAjax(){
        if(!isset(Yii::app()->user->storeID)){
            $data['message'] = '<div class="alert alert-success">Store not found. </div>';
            echo json_encode($data);
            exit;
        }
        $model = new ServiceType;
        $model->s_store_id = Yii::app()->user->storeID;
        if(isset($_POST['ServiceType'])){
            $model->attributes = $_POST['ServiceType'];
            $data = array();
            $mss = '';
            
            if( count($data) == 0 ){
                $model->pk_s_id = '-1';
                $model->i_flag_sync = 1;
                $model->i_flag_deleted = 0;
                $model->i_disable = 0;
                if($model->save()){
                    $model->pk_s_id = 'SV'.$model->id;
                    if($model ->save()){
                        $data['option'] = '<option selected="selected" value ="'.$model->pk_s_id.'">'.$model->s_name.'</option>';
                        $data['message'] = '<div class="alert alert-success">Success! Type Service Created. </div>';
                    }else{
                        $model->delete();
                        $data['message'] = '<div class="alert alert-danger">Error! Please try again later.</div>';
                    }
                }else{
                    $data['message'] = json_encode($model->errors);//'<div class="alert alert-danger">Error! Please try again later2.</div>';
                }
            }
            echo json_encode($data);
        }
    }
    public function actionAdd(){
        $model = new ServiceType;
        if(!isset(Yii::app()->user->storeID)){
            $this->redirect(array('site/index'));
        }
        $this->pageTitle = 'Add Service Type';
        $model->s_store_id = Yii::app()->user->storeID;
        if(isset($_POST['ServiceType']))
		{
			$flagSave = false;
            $model->attributes=$_POST['ServiceType'];
            $model->pk_s_id = '-1';
            $model->i_flag_sync = 1;
            $model->i_flag_deleted = 0;
            $model->i_disable = 0;
            $image = CUploadedFile::getInstance($model,'s_image_server');
            if ($image != null) {
                $model->s_image_server = sha1(time()).date("dmHi").'.'.$image->extensionName;
                if($image->saveAs(Yii::app()->basePath.'/../data/service_type/'.$model->s_image_server)){
                    $imgthumb = Yii::app()->phpThumb->create(Yii::app()->basePath.'/../data/service_type/'.$model->s_image_server);
                    $imgthumb->resize(240,240);
                    $imgthumb->save(Yii::app()->basePath.'/../data/service_type/240x240_'.$model->s_image_server);
                    $imgthumb->resize(120,120);
                    $imgthumb->save(Yii::app()->basePath.'/../data/service_type/120x120_'.$model->s_image_server);
                    $model->i_sync_image = 1;
                }else{
                    $model->addError('s_image_server','Upload image fail');
                }
            }
            if(count($model->errors) == 0){ 
                if($model->save()){
                    $flagSave = true;
                    $pk_s_id = 'SV'.$model->id;
                    $model->pk_s_id = $pk_s_id;
                    if($model->save()){
                        $flagSave = true;
                    }else{
                        $flagSave = false;
                        @unlink(Yii::app()->basePath.'/../data/service_type/'.$model->s_image_server);
                        @unlink(Yii::app()->basePath.'/../data/service_type/240x240_'.$model->s_image_server);
                        @unlink(Yii::app()->basePath.'/../data/service_type/120x120_'.$model->s_image_server);
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
		));
    }
    
    public function actionEdit($id){
        $this->pageTitle = 'Edit Service Type';
        $model = $this->loadModel($id);
        if(isset($_POST['ServiceType'])){
			$flagSave = false;
            $flagChangeImage = false;
            $model->attributes=$_POST['ServiceType'];
            $model->i_flag_sync = 1;
            $image = CUploadedFile::getInstance($model,'s_image_server');
            if ($image != null) {
                if($model->s_image_server == ''){
                    $model->s_image_server = sha1(time()).date("dmHi").'.'.$image->extensionName;
                }
                if($image->saveAs(Yii::app()->basePath.'/../data/service_type/'.$model->s_image_server)){
                    $imgthumb = Yii::app()->phpThumb->create(Yii::app()->basePath.'/../data/service_type/'.$model->s_image_server);
                    $imgthumb->resize(240,240);
                    $imgthumb->save(Yii::app()->basePath.'/../data/service_type/240x240_'.$model->s_image_server);
                    $imgthumb->resize(120,120);
                    $imgthumb->save(Yii::app()->basePath.'/../data/service_type/120x120_'.$model->s_image_server);
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
                    @unlink(Yii::app()->basePath.'/../data/service_type/'.$model->s_image_server);
                    @unlink(Yii::app()->basePath.'/../data/service_type/240x240_'.$model->s_image_server);
                    @unlink(Yii::app()->basePath.'/../data/service_type/120x120_'.$model->s_image_server);
                }
                if($flagSave == true){
                    $this->redirect(array('index'));
                }
                
            }
        }
		$this->render('create',array(
			'model'=> $model,
		));
    }
    public function actionDelete($id){
		$model = $this->loadModel($id);
        $model->i_flag_deleted = 1;
        $model->i_disable = 1;
        $model->i_flag_sync = 1;
        $model->save();
        if(Yii::app()->request->isAjaxRequest){
            echo "Delete type service { ".$model->s_name.' } Success';
            Yii::app()->end();
        }
        $this->redirect(array('index'));
	}
    public function loadModelByPKID($s_pk_id)
	{
		$model = ServiceType::model()->find('pk_s_id = :pk_s_id',array(':pk_s_id'=>$s_pk_id));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
    public function loadModel($id)
	{
		$model = ServiceType::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
 }