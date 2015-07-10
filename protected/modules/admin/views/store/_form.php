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
            <?php echo $form->textField($model,'s_name',array('size'=>50,'maxlength'=>100,'class'=>'txt-form')); ?>
            <?php echo $form->error($model,'s_name', array('class'=>'error')); ?>
        </div>
	</div>

    <div class="controls">
        <div class="label">
            <label class="lbl-form">Store Manager</label>
        </div>
        <div class="input">
		    <select name="Store[UserID]" id="User_s_id" class="sel-form" style='width:40%'>
                    <?php if($model->userManager() != null ){?>
                    <option selected="selected" value="<?php echo $model->userManager()->pk_s_id;?>"><?php echo ($model->userManager()->s_fullname != null)?$model->userManager()->s_fullname:$model->userManager()->s_username?></option>
                    <?php } ?>
                <?php foreach($model->getUser() as $user){ ?>
                    <option value="<?php echo $user['pk_s_id'];?>"><?php echo ($user['s_fullname'] != '')?$user['s_fullname']:$user['s_username'];?></option>
                <?php }?>
            </select>
            <script>$("#User_s_id").chosen();</script>
            <a class="btnAddStore" id="btnAddUser"><i>&#xf067;</i>Add Store Manager </a>
            <script>
                $(function(){   
                    $('#btnAddUser').click(function(){
                        $('.bg-popup').css('display','block').css('background','rgba(0,0,0,0.6)').css('z-index','1001');
                        $("#form-popup-user").slideToggle(3000);
                        $("#form-popup-user").css('display','block').css('z-index','1002');
                    });
                    $('.bg-popup').click(function(){
                        if(confirm('Do you want cancel ?')){
                           $(this).css('display','none').css('z-index','-2');
                           $("#form-popup-user").css('display','none').css('z-index','-1');
                           $("#form-popup-user").find('form')[0].reset();   
                        }
                    });
                    $('.btnclosepopup').click(function(){
                        $('.bg-popup').click();
                    })
                });
                </script>
            <?php echo $form->error($model,'s_name', array('class'=>'error')); ?>
        </div>
	</div>
    
    <div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'s_image_server', array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->fileField($model, 's_image_server', array('class'=>'file-form'));?>
            <?php echo $form->error($model,'s_image_server',array('class'=>'error'));?>
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
            <?php echo $form->labelEx($model,'s_summary',array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'s_summary',array('size'=>60,'maxlength'=>255,'class'=>'txt-form')); ?>
		    <?php echo $form->error($model,'s_summary', array('class'=>'error')); ?>
        </div>
	</div>
    <?php /*
    <div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'s_description', array('class'=>'lbl-form')); ?>
        </div>
        <div class="input">
            <?php
                $this->widget('ext.ckeditor.CKEditor', array(
                    'model'=>$model,
                    'attribute'=>'s_description', // model atribute
                    'editorTemplate'=>'full', // Toolbar settings (full, basic, advanced)
                    
                ));
             ?>
            <?php echo $form->error($model,'s_description',array('class'=>'error'));?>
        </div>
    </div> */ ?>
    
    <div class="controls">
        <div class="label">
            <label class="lbl-form">Location</label>
        </div>
        <div class="input">
            <?php echo $form->textField($model,'s_latitude',array('size'=>50,'maxlength'=>20,'class'=>'txt-form','style'=>'width:30%','placeholder' => 'Latitudde')); ?>
            <?php echo $form->textField($model,'s_longitude',array('size'=>50,'maxlength'=>20,'class'=>'txt-form','style'=>'width:30%; margin-left:5px','placeholder' => 'Longitude')); ?>
		    <?php echo $form->error($model,'s_latitude', array('class'=>'error')); ?>
        </div>
	</div>
    
    <div class="controls">
        <div class="label">
            <?php echo $form->labelEx($model,'i_is_trial',array('class'=>'lbl-form')); ?>
        </div>
		<div class="input">
            <?php echo $form->dropDownList($model,'i_is_trial', Yii::app()->params['flag.disable'], array('options' => array($model->i_disable => array('selected' => 'selected')), 'class'=>'sel-form')); ?>
		    <script>
                $('#Store_i_is_trial').change(function(){
                   if($(this).val() == 1){
                        $('#frmTrial').css('display','inline-block');
                        $('#frmTrial').find("#Store_i_trial_from").val('<?php echo date('Y-m-d H:i')?>');
                        $('#frmTrial').find("#Store_i_trial_to").val('<?php echo date('Y-m-d H:i', strtotime('+30 day'))?>');
                   }else{
                        $('#frmTrial').css('display','none');
                        $('#frmTrial').find("#Store_i_trial_from").val(0);
                        $('#frmTrial').find("#Store_i_trial_to").val(0);
                   }
                });
            </script>
            <div id="frmTrial" style="display: none; margin-top: 10px;">
                <label style="padding: 7px; width: 50px" class="label">From: </label>
                <?php echo $form->textField($model,'i_trial_from',array('size'=>50,'maxlength'=>20,'class'=>'txt-form','style'=>'width:30%; margin-left:5px','placeholder' => 'Trial From','value' => ($model->i_trial_from > 0)?data('Y-m-d H:i'):0 )); ?>
                <label style="padding: 7px; width: 35px;" class="label">To: </label>
                <?php echo $form->textField($model,'i_trial_to',array('size'=>50,'maxlength'=>20,'class'=>'txt-form','style'=>'width:30%; margin-left:5px','placeholder' => 'Trial To','value' => ($model->i_trial_to > 0)?data('Y-m-d H:i'):0)); ?>
                <script>
                    jQuery('#Store_i_trial_from').datetimepicker({format:'Y-m-d H:i'});
                    jQuery('#Store_i_trial_to').datetimepicker({format:'Y-m-d H:i'});
                </script>
            </div>
            <?php echo $form->error($model,'i_is_trial', array('class'=>'error')); ?>
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
<div class="form-popup-user" id="form-popup-user" style="display: none;">
    <div style="background: #FFF; width: 100%;padding:30px 15px; border-radius:4px; position: relative;">
        
        <a class="btnclosepopup"><i>&#xf00d;</i></a>
        
        
        <form method="post" action="<?php echo Yii::app()->baseUrl.'/admin/user/addAjax'?>" id="form-popup-add-user">
        <div class="controls">
            <div class="label">
                <label class="lbl-form">Username</label>
            </div>
            <div class="input">
    		    <input name="User[s_username]" size="50" maxlength="50" class="txt-form" oninput='checkCode(this.value + "|user","messUsername","Username")' />
                <label class="notEmpty" id="messUsername"></label>
                <div class="error"></div>
            </div>
    	</div>
        
        <div class="controls">
            <div class="label">
                <label class="lbl-form">Password</label>
            </div>
            <div class="input">
                <input type="password" name="User[s_password]" size="60" maxlength="16" class="txt-form" />
            </div>         
    	</div>
    
    	<div class="controls">
            <div class="label">
                <label class="lbl-form">Fullname</label>
            </div>
            <div class="input">
    		    <input type="text" name="User[s_fullname]" value="" size="60" maxlength="255" class="txt-form" />
                <div class="error"></div>
            </div>
    	</div>
        
        <div class="controls">
            <div class="label">
                <label class="lbl-form">Email</label>
            </div>
            <div class="input">
                <input type="text" name="User[s_email]" value="" size="60" maxlength="255" class="txt-form" oninput='checkCode(this.value + "|user","messEmail","Email")' />
                <label class="notEmpty" id="messEmail"></label>
                <div class="error"></div>
            </div>
    	</div>
        
        <div class="controls">
            <label class="label" style="display: inline-block;"> &nbsp;</label>
            <div class="input">
                <input type="submit" value="Save" class="bnt-form" />
                <input type="reset" value="Cancel" class="bnt-form" style="margin-left:10px" />
            </div>
    	</div>
        </form>
        <div class="loadding"><img src="<?php echo Yii::app()->baseUrl.'/images/loader.gif'?>" ></div>
        <div style="clear: both;"></div>
     </div>
</div>