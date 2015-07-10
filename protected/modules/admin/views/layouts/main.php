<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->controller->module->assetsUrl;?>/css/style.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->controller->module->assetsUrl;?>/datetimepicker/jquery.datetimepicker.css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->controller->module->assetsUrl;?>/js/chosen.min.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->controller->module->assetsUrl;?>/popup/css/popup.css" type="text/css" />
    <title><?php echo $this->pageTitle?></title>
    <script type="text/javascript" src="<?php echo Yii::app()->controller->module->assetsUrl;?>/js/app.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->controller->module->assetsUrl;?>/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->controller->module->assetsUrl;?>/datetimepicker/jquery.datetimepicker.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->controller->module->assetsUrl.'/js/chosen.jquery.min.js'?>"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->controller->module->assetsUrl.'/popup/js/jquery.popup.js'?>"></script>
    <script>var url = '<?php echo Yii::app()->baseUrl.'/admin'?>';</script>
</head>
<body>
    <div class="message-show"></div>
    <div class="header">
        <div class="h-left">
            <a href="<?php echo Yii::app()->baseUrl?>/admin">Admin Dashboard</a>
        </div>
        <div class="h-right">
            <button class="btn-menu"> <i class="fa">&#xf0c9;</i></button>
            <div class="user-action">
                <div class="nav-user">
                    <span><?php echo Yii::app()->user->getState('fullname');?></span><i style="font-size: 14px; padding: 0 7px;">&#xf007; &#xf0d7;</i>
                </div>
                <div class="profiles">
                    <div class="profile"><a href="<?php echo Yii::app()->baseUrl?>/admin/site/profiles"><i>&#xf21b;</i>Profile</a></div>
                    <div class="profile"><a href="<?php echo Yii::app()->baseUrl?>/admin/site/profiles"><i>&#xf023;</i>Change Password</a></div>
                    <div class="profile"><a href="<?php echo Yii::app()->baseUrl?>/admin/site/logout"><i>&#xf08b;</i>Logout</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="left">
            <?php
                $cMenu = array();
                $cMenu[] = array('label'=>'<i>&#xf015;</i><span>Dashboard</span>', 'url'=>array('site/index'), 'active'=>$this->ID == 'site');
                $cMenu[] = array('label'=>'<i>&#xf19c;</i><span>Store</span>', 'url'=>array('store/index'), 'active'=>$this->ID == 'store');
                $cMenu[] = array('label'=>'<i>&#xf007;</i><span>Account </span>', 'url'=>array('user/index'), 'active'=>($this->ID == 'user' && $this->action->id == 'index'));
                $cMenu[] = array('label'=>'<i>&#xf023;</i><span>Administrator</span>', 'url'=>array('user/administrator'), 'active'=>($this->ID == 'user' && $this->action->id == 'administrator'));
                //$cMenu[] = array('label'=>'<i>&#xf013;</i><span>Setting </span>', 'url'=>array('configs/index'), 'active'=>$this->ID == 'configs');
            ?>
			<?php $this->widget('zii.widgets.CMenu', array(
				'encodeLabel'=>false,
				'items'=>$cMenu));
			?>
        </div>
        <div class="right">
            <div class="title">
                <?php echo $this->pageTitle?>
            </div>
            <div style="border: 1px solid #dcdcdc; clear: both;">
                <?php echo $content?>
                <div style="clear: both;"></div>
            </div>
        </div>
    </div>
    <div class="footer">
        <span> &copy; KHOI SANG COMPANY </span>
    </div>
    <div class="bg-popup"></div>
</body>
</html>