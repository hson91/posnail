<?php

class ConfigsController extends AController
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
        $this->pageTitle = "List of Type Confgis";
        $model = new Reference('search');
        $model->unsetAttributes();
        if(isset($_GET['Reference']))
            $model->attributes = $_GET['Reference'];
            
        $this->render($this->view.'index',array(
            'model' => $model
        ));
        
	}
    public function actionDetail($id){
        $model = $this->loadModel($id);
        
        if(isset($_GET['ajax'])){
            $this->renderPartial('_detail', array('model'=>$model));
        }else{
            $this->render('detail', array('model'=>$model));
        }
    }
    public function actionAdd(){
        $model = new Reference;
        if(!isset(Yii::app()->user->storeID)){
            $this->redirect(array('site/index'));
        }
        $this->pageTitle = 'Add Configs';
        $model->s_store_id = Yii::app()->user->storeID;
        if(isset($_POST['Reference']))
		{
			$flagSave = false;
            $model->attributes=$_POST['Reference'];
            $model->i_flag_sync = 1;
            $model->i_flag_deleted = 0;
            $model->i_disable = 0;
            if(count($model->errors) == 0){ 
                if($model->save()){
                    $this->redirect(array('index'));
                } 
            }
        }
		$this->render('create',array(
			'model'=>$model,
		));
    }
    
    public function actionEdit($id){
        $this->pageTitle = 'Edit Configs';
        $model = $this->loadModel($id);
        if(isset($_POST['Reference'])){
			$flagSave = false;
            $model->attributes=$_POST['Reference'];
            $model->i_flag_sync = 1;
            if(count($model->errors) == 0){ 
                if($model->save()){
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
            echo "Delete type configs { ".$model->s_key.' } Success';
            Yii::app()->end();
        }
        $this->redirect(array('index'));
	}
    public function loadModel($id)
	{
		$model = Reference::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
 }