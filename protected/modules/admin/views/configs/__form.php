<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); 
?>
    <?php echo $form->hiddenField($model,'s_store_id',array('size'=>50,'maxlength'=>50,)); ?>
    <input type="hidden" name="User[i_shopping]" value="1" />
    <div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'i_user_role',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
		    <select name="User[i_user_role]" class="sel-form" >
                <option <?php echo ($model->i_user_role == 4)?'selected="selected"':""?> value="4">Manager</option>
                <option <?php echo ($model->i_user_role == 5)?'selected="selected"':""?> value="5">Normal</option>
            </select>
            <?php echo $form->error($model,'i_user_role', array('class'=>'error')); ?>
        </div>
	</div>
	<div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'s_username',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'s_username',array('size'=>50,'maxlength'=>50,'class'=>'txt-form','oninput'=>'checkCode(this.value + "|'.$this->id.'|'.$model->s_username.'","messUsername","Username")')); ?>
		    <label class="notEmpty" id="messUsername"></label>
            <?php echo $form->error($model,'s_username', array('class'=>'error')); ?>
        </div>
	</div>

	<div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'s_password',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->passwordField($model,'s_password',array('size'=>60,'maxlength'=>16,'class'=>'txt-form')); ?>
		    <?php echo $form->error($model,'s_password', array('class'=>'error')); ?>
        </div>         
	</div>

	<div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'s_fullname',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'s_fullname',array('size'=>60,'maxlength'=>255,'class'=>'txt-form')); ?>
		    <?php echo $form->error($model,'s_fullname', array('class'=>'error')); ?>
        </div>
	</div>

	<div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'s_address',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'s_address',array('size'=>60,'maxlength'=>255,'class'=>'txt-form')); ?>
		    <?php echo $form->error($model,'s_address', array('class'=>'error')); ?>
        </div>
	</div>
    
	<div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'s_email',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'s_email',array('size'=>60,'maxlength'=>255,'class'=>'txt-form','oninput'=>'checkCode(this.value + "|'.$this->id.'|'.$model->s_username.'","messEmail","Email")')); ?>
            <label class="notEmpty" id="messEmail"></label>
		    <?php echo $form->error($model,'s_email', array('class'=>'error')); ?>
        </div>
	</div>

	<div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'s_tell',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'s_tell',array('size'=>50,'maxlength'=>50,'class'=>'txt-form')); ?>
		    <?php echo $form->error($model,'s_tell', array('class'=>'error')); ?>
        </div>
	</div>
    
    <div class="controls">
        <div class="label">
            <?=$form->labelEx($model,'s_image_server', array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?=$form->fileField($model, 's_image_server', array('class'=>'file-form'));?>
            <?=$form->error($model,'s_image_server',array('class'=>'error'));?>
        </div>
    </div>
    
	<div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'i_lock',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->dropDownList($model,'i_lock',Yii::app()->params['lock'],array('options' => array($model->i_lock => array('selected' => 'selected')),'class'=>'sel-form')); ?>
		    <?php echo $form->error($model,'i_lock', array('class'=>'error')); ?>
        </div>
	</div>
	<div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'i_disable',array('class'=>'lbl-form')); ?>
        </div>
		<div class="input">
            <?php echo $form->dropDownList($model,'i_disable', Yii::app()->params['flag.disable'], array('options' => array($model->i_disable => array('selected' => 'selected')), 'class'=>'sel-form')); ?>
		    <?php echo $form->error($model,'i_disable', array('class'=>'error')); ?>
        </div>
	</div>

	<div class="controls">
        <label class="label" style="display: inline-block;"> &nbsp;</label>
        <div class="input">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Save change',array('class'=>'bnt-form')); ?>
            <?php echo CHtml::resetButton('Cancel',array('class'=>'bnt-form','style'=>'margin-left:10px')); ?>
        </div>
	</div>

<?php $this->endWidget(); ?>