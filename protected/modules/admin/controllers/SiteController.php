<?php

class SiteController extends AController
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
            'upload'=>'application.modules.admin.controllers.upload.UploadFileAction',
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
		return array(
            array('allow',
                'actions'=>array('login','forgetpasswd','passwordReset','activeaccount'),
                'users'=>array('*'),
            ),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','logout','error','profiles','upload','changepasswd'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
    
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
	    $this->pageTitle = "POSnail";
        $data = array();
        if(Yii::app()->user->parts == 2){
            $service = new Service('search');
            $customer = new Customer('search');
            $employee = new User('search');
            $model = Store::model()->find('pk_s_id = :pk_s_id',array(':pk_s_id' => Yii::app()->user->storeID));
            $data = array('model' => $model,'customer' => $customer,'employee'=>$employee,'service' => $service);
        }
		$this->render($this->view.'index',$data);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	   
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
        $this->layout = 'login';
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()) {
			     $this->redirect(Yii::app()->homeUrl.'admin');
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
    
    /**
	 * Displays the login page
	 */
	public function actionProfiles()
	{
        $this->layout = 'login';
		$model=User::model()->findByPk(Yii::app()->user->id);
		if(isset($_POST['ajax']) && $_POST['ajax']==='profiles-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['update']))
		{
			$model->attributes=$_POST['User'];
            if(count($model->errors) == 0){
                $validate = true;
                $flash = '';
                if ($_POST['new_password'] != '') {
                    $old_password = $_POST['old_password'];
                    $new_password = $_POST['new_password'];
                    $confirm_password = $_POST['confirm_password'];
                    if ($old_password == ''){
                        $flash .= 'Password old can not be blank.<br />';
                        $validate = false;
                    }
                    
                    if ($confirm_password == '') {
                        $flash .= 'Confirm password can not be blank.<br />';
                        $validate = false;
                    }
                    
                    if ($old_password != '' && $new_password != '' && $confirm_password != '') {
                        if ($model->passwordVerify($old_password) == false) {
                            $flash .= 'Password old incorrect.<br />';
                            $validate = false;
                        } else {
                            if ($new_password !== $confirm_password) {
                                $flash .= 'Confirm password incorrect.<br />';
                                $validate = false;
                            }    
                        }
                    }
                    if ($validate) {
                        if ($old_password != $new_password) {
                            $model->password = sha1($model->s_secret_code.sha1($_POST['new_password'].$model->s_secret_code));
                        }
                    }
                }
                $model->i_flag_sync = 1;
                if($validate && $model->save()) {
                    Yii::app()->user->setFlash('profiles','Update profile success!');
                    $this->refresh();
                } else {
                    Yii::app()->user->setFlash('error',$flash);
                }
            }else{
                $flash = '';
                foreach($model->errors as $key => $error){
                    foreach($error as $value){
                        $flash .= $value.'<br/>';
                    }
                }
                Yii::app()->user->setFlash('error',$flash);
            }
		}
		$this->render('profiles',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
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
     
        Yii::app()->user->logout();
    }
	public function actionLogout()
	{
        $this->f_logout();
        $this->redirect(Yii::app()->baseUrl.'/admin/login');
	}
    public function actionPasswordReset($alias){
        $this->layout = 'login';
        $errors = array();
        if($alias == null){
            Yii::app()->user->setFlash('mssFPw','<div class="error">Request invalid.</div>');
            $this->redirect(array("site/forgetpasswd")); 
        }
        $url = urldecode($alias);
        $params = explode('|',$url);
        $token = $params[0];
        if(!isset($params[1]) || filter_var(base64_decode($params[1]),FILTER_VALIDATE_EMAIL) == false){
            Yii::app()->user->setFlash('mssFPw','<div class="error">Request invalid.</div>');
            $this->redirect(array("site/forgetpasswd")); 
        }
        $email = base64_decode($params[1]);
        $user = User::model()->find('s_email = :s_email',array(':s_email' => $email));
        if($user == null){
            Yii::app()->user->setFlash('mssFPw','<div class="error">Request invalid.</div>');
            $this->redirect(array("site/forgetpasswd")); 
        }
        if($user->i_time_send_code_active < time()){
            Yii::app()->user->setFlash('mssFPw','<div class="error">Request has expired. Please try again later.</div>');
            $this->redirect(array("site/forgetpasswd"));
        }
        if($user->s_token != $token ){
            Yii::app()->user->setFlash('mssFPw','<div class="error">Request invalid.</div>');
            $this->redirect(array("site/forgetpasswd"));
        }
        if(isset($_POST['USER'])){
            $model = $_POST['USER'];
            if(sha1($user->s_email) == $model['TOKEN_ID'] && $user->s_token == $model['TOKEN_CODE']){
                $passwd = $model['USER_PASSWD'];
                $passwdcf = $model['USER_PASSWD_CONFIRM'];
                if($passwd != $passwdcf || $passwd == ''){
                    $errors['passwdcf'] = 'Password confirm do not match';
                }
                if(count($errors) == 0){
                    $user->s_password = sha1($user->s_secret_code.sha1($passwd.$user->s_secret_code));
                    $user->s_token = null;
                    $user->i_time_send_code_active = null;
                    if($user->save()){
                        
                        Yii::app()->user->setFlash('mssFPw','<div class="alert-success">Reset password success. Please '.$email.' để được cấp lại mật khẩu</div>');
                        $this->redirect(array("site/logout"));   
                    }else{
                        Yii::app()->user->setFlash('mssFPw','<div class="error">Reset password fail. Please try again later.</div>');
                        $this->redirect(array("site/forgetpasswd"));
                    }
                }
            }else{
                Yii::app()->user->setFlash('mssFPw','<div class="error">Request invalid. Please try again later.</div>');
                $this->redirect(array("site/forgetpasswd"));
            }
        }
        $this->render('changepasswd',array('user' => $user,'errors' => $errors));
    }
    public function actionForgetpasswd(){
        $this->layout = 'login';
        $email = '';
        $errors = array();
        if(isset($_POST['USER_EMAIL'])){
            $email = $_POST['USER_EMAIL'];
            if(filter_var($email,FILTER_VALIDATE_EMAIL) == true){
                $user = User::model()->find('s_email = :s_email',array(':s_email' => $email));
                if($user != null){
                    ##
                    $user->s_token = sha1(base64_encode($user->s_secret_code).time().$user->s_password);;
                    $user->s_code_active = rand(111111,999999);
                    $user->i_time_send_code_active = time()+86400;
                    if($user->save()){
                        $url = $user->s_token."|".base64_encode($user->s_email);
                        $subject="[Reset Password]POSnail";
            			$headers="From: $email \r\n".
            				"Reply-To: $email \r\n".
            				"MIME-Version: 1.0\r\n".
            				"Content-type: text/plain; charset=UTF-8";
                        
                        $body = '<div style="padding:10px; border:1px solid #dcdcdc; line-height: 27px;">
                                    <p>Hi <b>'.$user->s_email.' !</b></p>
                                    <p>Chúng tôi nhận được yêu cầu cần hỗ trợ về việc quên mật khẩu của bạn trên hệ thống <b>POSnail</b> của bạn.</p>
                                     
                                    <p>Nếu đúng là bạn đã gửi yêu cầu này cho chúng tôi. Bạn vui lòng sử dụng liên kết sau để có thể thiết lập lại mật khẩu của bạn.</p>
                                    <p><a href="http://localhost:81/posnail/passwordReset/'.urlencode($url).'">Đặt lại mật khẩu tại đây</a></p>
                                    <p>Hành động này chỉ có hiệu lực 24h kể từ khi bạn gửi yêu cầu. Sau thời gian 24h liên kết sẽ hết hiệu lực và nếu bạn muốn
                                    thực hiện lấy lại mật khẩu, bạn buộc phải gửi lại yêu cầu cho chúng tôi.</p>
                                    Thanks.
                                </div>';
                        Yii::import('ext.yiimail.YiiMailMessage');
                        $message = new YiiMailMessage;
                        $message->setBody($body, 'text/html');
                        $message->subject = $subject;
                        $message->addTo($email);
                        $message->setFrom(array('feedback.posnail@gmail.com' => 'POSnail'));
                        if (Yii::app()->mail->send($message)) {
                            Yii::app()->user->setFlash('mssFPw','<div class="alert-success">Yêu cầu của bạn chúng tôi đã nhận đươc. Xin vui lòng kiểm tra hộp thư '.$email.' để được cấp lại mật khẩu</div>');
                            $this->redirect(array("site/login"));   
                        }else {
                            Yii::app()->user->setFlash('mssFPw','<div class="error">Có lỗi xảy ra khi giải quyết yêu cầu của bạn. Xin lòng thử lại sau trong ít phút.</div>');
                            $this->redirect(array("site/forgetpasswd"));    
                        }
                    }else{
                        Yii::app()->user->setFlash('mssFPw','<div class="error">Có lỗi xảy ra khi giải quyết yêu cầu của bạn. Xin lòng thử lại sau trong ít phút.</div>');
                        $this->redirect(array("site/forgetpasswd")); 
                    }
                    ##
                }else{
                    $errors['email'] = 'Email address is not registered';
                }
            }else{
                $errors['email'] = 'Email address invalid'; 
            }
        }
        $this->render('forgetpasswd',array('email' => $email,'errors' => $errors));
    }
}