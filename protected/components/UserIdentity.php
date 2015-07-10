<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    const ERROR_ACCOUNT_LOCK_LIMIT = 3;
    const ERROR_ACCOUNT_LOCK_UNLIMIT = 4;
    const ERROR_ACCOUNT_NOT_ACTIVE = 5;
    private $_id;
    public $_usernameFirst;
    public $_passwordFirst;
    public $_linkFirst;
    public $_flagLoginStore;
    public $_actionFirst;
    
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
	   /*Get User By Username */
        $user = User::model()->findByAttributes(array(
                's_username' => $this->username,'i_flag_deleted' => 0));

        
        if ($user === null) {
            /* User not exist */
            $this->errorCode = 'Username Incorrect';
        } else {
            $passwordVerify = $user->passwordVerify($this->password);
            if( $passwordVerify == true ){
                /* If Account active and enable */
                if( $user->i_active == 1 ){
                    if( $user->i_disable == 0 ){
                        $this->_id = $user->id;
                        $lastLogin = $user->i_login_closest;
                        $user->i_login_closest = time();
                        @$user->save();
                        $auth = Yii::app()->authManager;
                        
                        if (!$auth->isAssigned($user->role->alias, $this->_id)) {
                            if ($auth->assign($user->role->alias, $this->_id)) {
                                Yii::app()->authManager->save();
                            }
                        }
                        $this->setState('userID', $user->id);
                        $this->setState('role', $user->role->alias);
                        $this->setState('level', $user->role->level);
                        $this->setState('parts', $user->role->parts);
                        //$_SESSION['ckeditor']['role'] = $user->role->alias;
                        //$_SESSION['ckeditor']['username'] = $user->s_username;
                        $this->setState('fullname', $user->s_fullname != '' ? $user->s_fullname : $user->s_username);
                        
                        $this->setState('username', $user->s_username);
                        $this->setState('password', $user->s_password);
                        $this->setState('storeID', $user->s_store_id);
                        $this->setState('params', $user->s_params);
                        $this->setState('email', $user->s_email);
                        $this->setState('visited', $lastLogin);
                        $this->errorCode = self::ERROR_NONE;  
                    }else{
                        if($user-> i_lock > 0){
                            /* Lock User time limit */
                            if($user-> i_lock < time()){
                                $user-> i_lock = 0;
                                $user-> i_disable = 0;
                                $user->save();
                                $this->authenticate();
                            }else{
                                $this->errorCode = 'Your account has been locked to '.date('Y-m-d H:i:s',$user-> i_lock);
                            }
                        }else{
                            /* Lock User time unlimit */
                            $this->errorCode = 'Your account has been disabled';
                        }
                    } 
                }else{
                    /* User not activated  */
                    $this->errorCode = 'Your account is not activated';
                }
            }else{
                //Tracking login
                //
                $this->errorCode = 'Password Incorrect';
                
            }
        }
		return $this->errorCode;
	}
    
    public function authenticateWithRole()
	{
	   /*Get User By Username */
        $user = User::model()->findByAttributes(array(
                's_username' => $this->username,
                's_password' => $this->password,
                'i_flag_deleted' => 0));

        
        if ($user === null) {
            return false;
        } else {
                $this->_id = $user->id;
                $lastLogin = $user->i_login_closest;
                $user->i_login_closest = time();
                @$user->save();
                $auth = Yii::app()->authManager;
                
                if (!$auth->isAssigned($user->role->alias, $this->_id)) {
                    if ($auth->assign($user->role->alias, $this->_id)) {
                        Yii::app()->authManager->save();
                    }
                }
                Yii::app()->user->clearStates();
                $this->setState('usernameFirst', $this->_usernameFirst);
                $this->setState('passwordFirst', $this->_passwordFirst);
                $this->setState('fagLoginStore', $this->_flagLoginStore);
                $this->setState('actionFirst', $this->_actionFirst);
                $this->setState('linkFirst', $this->_linkFirst);
                $this->setState('userID', $user->id);
                $this->setState('role', $user->role->alias);
                $this->setState('level', $user->role->level);
                $this->setState('parts', $user->role->parts);
                //$_SESSION['ckeditor']['role'] = $user->role->alias;
                //$_SESSION['ckeditor']['username'] = $user->s_username;
                $this->setState('fullname', $user->s_fullname != '' ? $user->s_fullname : $user->s_username);
                $this->setState('username', $user->s_username);
                $this->setState('password', $user->s_password);
                $this->setState('storeID', $user->s_store_id);
                $this->setState('params', $user->s_params);
                $this->setState('email', $user->s_email);
                $this->setState('visited', $lastLogin);
        }
		return true;
	}
    
    public function getId(){
        return $this->_id;
    }
}