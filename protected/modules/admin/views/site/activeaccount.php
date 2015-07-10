<form class="form-horizontal">
    <div class="alert">
    <?php if(isset($errors)): foreach($errors as $error):?>
        <?php echo $error.' <br />';?>
    <?php endforeach;endif;?>
    </div>
    <input type="hidden" name="TOKEN_ID" value="" />
    <input type="hidden" name="TOKEN_CODE" value="" />
    <h3>Enter the code you received in your confirmation email</h3>
    <div class="input">
        <span class="icon">&#xf023;</span>
        <input type="text" name="USER_CODE_ACTIVE" value="" class="input-large span10" placeholder="Enter code" />
	</div>
	<div class="input submit" style="margin-bottom: 0;">	
		<input type="submit" value="SUBMIT" />
	</div>
</form>
<a href="<?php echo Yii::app()->baseUrl?>/admin/site/login" class="forget" title="Forget password">Login System</a>