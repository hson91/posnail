<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
    'htmlOptions'=>array('class'=>'form-horizontal'),
)); ?>
    <div class="alert">
    <?php foreach($model->errors as $error):?>
        <?php echo $error[0].' <br />';?>
    <?php endforeach;?>
    <?php echo (Yii::app()->user->hasFlash('mssFPw'))?Yii::app()->user->getFlash('mssFPw'):''?>
    </div>
	<div class="input">
        <span class="icon">&#xf007;</span>
        <?php echo $form->textField($model,'username', array('class'=>'input-large span10','placeholder'=>'Username')); ?>
	</div>
	<div class="input">
        <span class="icon">&#xf023;</span>
		<?php echo $form->passwordField($model,'password', array('class'=>'input-large span10','placeholder'=>'Password')); ?>
	</div>
	<div class="input submit" style="margin-bottom: 0;">	
		<input type="submit" value="Login" />
	</div>
<?php $this->endWidget(); ?>
<?php echo Chtml::link('I Forgot Password ?',array('site/forgetpasswd'),array('class' => 'forget','title' => 'Forget password'));?>