<?php if(isset($user)){?>
<form class="form-horizontal" method="post">
    <div class="alert" style="padding-left: 0;">
    <?php if(isset($errors)): foreach($errors as $error):?>
        <?php echo $error.' <br />';?>
    <?php endforeach;endif;?>
    <?php echo (Yii::app()->user->hasFlash('mssFPw'))?Yii::app()->user->getFlash('mssFPw'):''?>
    </div>
    <h3 style="float: left; margin-bottom: 10px;">Please. Enter password new!</h3>
    <input type="hidden" name="USER[TOKEN_ID]" value="<?php echo sha1($user->s_email)?>" />
    <input type="hidden" name="USER[TOKEN_CODE]" value="<?php echo $user->s_token?>" />
    <div class="input">
        <span class="icon">&#xf023;</span>
        <input type="password" name="USER[USER_PASSWD]" value="" class="input-large span10" placeholder="Password" />
	</div>
    <div class="input">
        <span class="icon">&#xf023;</span>
		<input type="password" name="USER[USER_PASSWD_CONFIRM]" value="" class="input-large span10" placeholder="Password Confirm" />
	</div>
	<div class="input submit" style="margin-bottom: 0;">	
		<input type="submit" value="SUBMIT" />
	</div>
</form>
<?php }else{
    $this->redirect(array("site/login"));
}?>
<a href="<?php echo Yii::app()->baseUrl?>/admin/site/login" class="forget" title="Forget password">Login System</a>