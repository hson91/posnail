<div class="action">
    <?php echo CHtml::link('<i>&#xf060;</i>Go Back',Yii::app()->baseUrl.'/user',array('class'=>'goback')); ?>
</div>
<div class="form">
    <?php echo $this->renderPartial($this->view.'form', array('model'=>$model)); ?>
</div>