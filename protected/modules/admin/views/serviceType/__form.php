<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array(
        'enctype'=>'multipart/form-data'
    )
)); 
?>
	<div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'s_name',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'s_name',array('size'=>50,'maxlength'=>50,'class'=>'txt-form')); ?>
            <?php echo $form->error($model,'s_name', array('class'=>'error')); ?>
        </div>
	</div>
    
    <div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'s_alias',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'s_alias',array('size'=>60,'maxlength'=>255,'class'=>'txt-form','style' =>'cursor:not-allowed','readonly' => 'readonly')); ?>
		    <?php echo $form->error($model,'s_alias', array('class'=>'error')); ?>
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
            <?php echo $form->labelEx($model,'s_summary',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'s_summary',array('size'=>60,'maxlength'=>255,'class'=>'txt-form')); ?>
		    <?php echo $form->error($model,'s_summary', array('class'=>'error')); ?>
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
<?php 
	$this->widget('ext.alias.Alias', array(
		'model'=>$model,
        'source' =>'s_name',
        'target' =>'s_alias',
	));   
?>