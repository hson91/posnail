<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array(
        'enctype'=>'multipart/form-data'
    )
)); 

$typeAction = isset($typeAccount)?$typeAccount:null;
?>
    
    
    
    <?php if($typeAction == 'system'){?>
    <input type="hidden" name="User[i_shopping]" value="0" />
    <input type="hidden" name="User[i_user_role]" value="2">
    <?php }elseif($typeAction = 'store'){ ?>
    <input type="hidden" name="User[i_user_role]" value="3">
    <div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'s_store_id',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <input type="hidden" name="User[i_shopping]" value="1" />
            <select name="User[s_store_id]"  id="User_s_id"class="sel-form">
                <option>Select Store...</option>
                <?php if($model->s_store_id != null) {?>
                <option selected="selected" value="<?php echo $model->s_store_id?>"><?php echo ($model->store() != null)?$model->store()->s_name:'N/A'?></option>
                <?php } ?>
                <?php foreach($store as $r){?>
                    <option value="<?php echo $r->pk_s_id?>"><?php echo $r->s_name?></option>
                <?php }?>
            </select>
            <script>$("#User_s_id").chosen();</script>
            <a class="btnAddStore" id="btnAddStore"><i>&#xf067;</i>Add Store</a>
		    <?php echo $form->error($model,'i_shopping', array('class'=>'error')); ?>
        </div>
	</div>
    <?php } ?>
    
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
            <?php echo $form->labelEx($model,'i_device_max',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->numberField($model,'i_device_max',array('class'=>'txt-form','style'=>'width:30%')); ?>
		    <?php echo $form->error($model,'i_device_max', array('class'=>'error')); ?>
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