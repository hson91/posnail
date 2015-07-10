<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class AController extends CController
{
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array('Dashboard'=>array('site/index'));
    public $view = '';
    public function init(){
        if ( isset(Yii::app()->user->role) && isset(Yii::app()->user->parts) ) {
            if(Yii::app()->user->role == 'normal' || Yii::app()->user->parts == 0){
                $roleAssigned = Yii::app()->authManager->getRoles(Yii::app()->user->id);
 
                if (!empty($roleAssigned)) { //checks that there are assigned roles
                    $auth = Yii::app()->authManager; //initializes the authManager
                    foreach ($roleAssigned as $n => $role) {
                        if ($auth->revoke($n, Yii::app()->user->id)) //remove each assigned role for this user
                        Yii::app()->authManager->save(); //again always save the result
                    }
                }
                Yii::app()->user->logout();
                $this->redirect(Yii::app()->homeUrl);  
                Yii::app()->end();
            }else{
                if(Yii::app()->user->parts == 2){
                    $this->view = '__';
                    $this->layout = 'layoutOfStore';
                }
            }
        }
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
            unset($_GET['pageSize']);
        }
        Yii::app()->clientScript->registerCoreScript('jquery');
        Yii::app()->clientScript->registerCoreScript('jquery.ui');
    }
     public function accessRules()
	{
	   /*
        $accessRules = array();
	    $roles = Roles::model()->findAll();
        foreach($roles as $role){
            $roleActions = RoleActions::model()->findAll('role_id = '.$role->id);
            if($roleActions){
                $item = array('allow');
                $actionSum = array();
                foreach($roleActions as $roleAction){
                    $action = Actions::model()->findByPk($roleAction->action_id);
                    if($action){
                        if($action->parent == 0){
                            if($action->alias == $this->ID){
                                $actions = Actions::model()->findAll('parent = '.$action->id);
                                foreach($actions as $act){
                                    $actionSum[] = $act->alias;
                                }
                            }
                        }else{
                            $actionParent = Actions::model()->find('id = '.$action->parent);
                            if($actionParent && $actionParent->alias == $this->ID){
                                $actionSum[] = $action->alias;
                            }
                        }
                    }
                }
                if(count($actionSum) > 0){
                    $item['actions'] = $actionSum;
                    $item['roles'] = array($role->alias);
                    $accessRules[] = $item;
                }
            }
        }
        $item = array('deny', 'users'=>array('*'));
        $accessRules[] = $item;
        return $accessRules;
        */
        return array();
	}
}