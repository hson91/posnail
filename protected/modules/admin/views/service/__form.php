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
            <label class="lbl-form">Type</label>
        </div>
        <div class="input">
            <?php echo $form->dropDownList($model,'s_service_type_id', $model->filterTypeService(), array('options' => array($model->s_service_type_id => array('selected' => 'selected')), 'class'=>'sel-form')); ?>
            <script>$("#Service_s_service_type_id").chosen();</script>
            <a class="btnAddStore" id="btnAddType"><i>&#xf067;</i>Add Type Service </a>
            <script>
                $(function(){   
                    $('#btnAddType').click(function(){
                        $('.bg-popup').css('display','block').css('background','rgba(0,0,0,0.6)').css('z-index','1001').css('transition','0.5s');
                        $("#form-popup-serice-type").slideToggle(1000);
                        $("#form-popup-serice-type").css('display','block').css('z-index','1002');
                    });
                    $('.bg-popup').click(function(){
                        if(confirm('Do you want cancel ?')){
                           $(this).css('display','none').css('z-index','-2');
                           $("#form-popup-serice-type").css('display','none').css('z-index','-1');
                           $("#form-popup-serice-type").find('form')[0].reset();   
                        }
                    });
                    $('.btnclosepopup').click(function(){
                        $('.bg-popup').click();
                    })
                });
                </script>
            <?php echo $form->error($model,'s_service_type_id', array('class'=>'error')); ?>
        </div>
	</div>
    
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
            <?php echo $form->labelEx($model,'s_price',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'s_price',array('size'=>50,'maxlength'=>20,'class'=>'txt-form','style' =>'width:40%')); ?>
            <?php echo $form->error($model,'s_price', array('class'=>'error')); ?>
        </div>
	</div>
    
    <div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'s_unit',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'s_unit',array('size'=>50,'maxlength'=>20,'class'=>'txt-form','style' =>'width:40%')); ?>
            <?php echo $form->error($model,'s_unit', array('class'=>'error')); ?>
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
<div class="form-popup-user" id="form-popup-serice-type" style="display: none;">
    <div style="background: #FFF; width: 100%;padding:30px 15px; border-radius:4px; position: relative;">
        
        <a class="btnclosepopup"><i>&#xf00d;</i></a>
        
        
        <form method="post" action="<?php echo Yii::app()->baseUrl.'/admin/serviceType/addAjax'?>" id="form-popup-add-type-service">
    
    	<div class="controls">
            <div class="label">
                <label class="lbl-form">Name Type</label>
            </div>
            <div class="input">
    		    <input type="text" name="ServiceType[s_name]" id="ServiceTypeName" size="60" maxlength="255" class="txt-form" />
                <input type="text" name="ServiceType[s_alias]" id="ServiceTypeAlias" size="60" maxlength="255" class="txt-form" />
                <div class="error"></div>
            </div>
    	</div>
        <div class="controls">
            <div class="label">
                <label class="lbl-form">Summary</label>
            </div>
            <div class="input">
    		    <input type="text" name="ServiceType[s_summary]" value="" size="60" maxlength="255" class="txt-form" />
                <div class="error"></div>
            </div>
    	</div>
        
        <div class="controls">
            <label class="label" style="display: inline-block;"> &nbsp;</label>
            <div class="input">
                <input type="submit" value="Save" class="bnt-form" />
                <input type="reset" value="Reset" class="bnt-form" style="margin-left:10px" />
            </div>
    	</div>
        </form>
        <div class="loadding"><img src="<?php echo Yii::app()->baseUrl.'/images/loader.gif'?>" ></div>
        <div style="clear: both;"></div>
        <?php 
	   $this->widget('ext.alias.Alias', array(
    		'model'=>null,
            'source' =>'ServiceTypeName',
            'target' =>'ServiceTypeAlias',
    	));   
        ?>
     </div>
</div>