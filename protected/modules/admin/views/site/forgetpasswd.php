<form class="form-horizontal" action="<?php echo Yii::app()->createAbsoluteUrl("admin/site/forgetpasswd");?>" method="post">
    
    <div class="alert" style="padding-left: 0;">
    <?php if(isset($errors)): ?>
    <?php  foreach($errors as $error):?>
        <?php echo $error.' <br />';?>
    <?php endforeach;?>
    <?php endif;?>
        <?php echo (Yii::app()->user->hasFlash('mssFPw'))?Yii::app()->user->getFlash('mssFPw'):''?>
    </div>
    <h3 style="float: left; margin-bottom: 10px;">Enter your registered email address!</h3>
	<div class="input">
        <input type="hidden" name="" value="" />
        <span class="icon">&#xf007;</span>
        <input type="email" class="input-large span10" autofocus="on" name="USER_EMAIL" value="<?php echo (isset($_POST['USER_EMAIL']))?$_POST['USER_EMAIL']:''?>" placeholder="Email" />
	</div>
	<div class="input submit" style="margin-bottom: 0;">	
		<input type="submit" value="SUBMIT" />
	</div>
</form>
<a href="<?php echo Yii::app()->baseUrl?>/admin/site/login" class="forget" title="Forget password">Login System</a>