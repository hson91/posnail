<div class="action">
    <?php echo CHtml::link('<i>&#xf055;</i>Add Store', array('create')); ?>
</div>
<?php
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'data-grid',
	'dataProvider'=>$model->search(),
    'htmlOptions'=>array('class'=>'table tbuser'),
    'summaryText'=>'',
    'filter'=>$model,
    'columns'=>array(
        array(
            'name'=>'No',
            'filter'=>false,
            'value' => '$row + 1',
            'type'=>'raw',
            'htmlOptions'=>array('class'=>'ct id'),
        ),
        array(
            'name'=>'Login As',
            'value' => 'Chtml::link("Login AS",array("store/login","id" => $data->id),array("class"=>"btnAction1 login-authorized","style"=>"width:100%"))',
            'type' => 'raw',
            'filter' => false,
            'htmlOptions'=>array('class'=>'ct'),
        ),
        array(
            'name'=>'manager',
            'value' => '($data->userManager() != null)?Chtml::link($data->userManager()->s_fullname,array("user/detail","alias" => $data->userManager()->pk_s_id),array("class"=>"link detailAccount")):"N/A"',
            'type' => 'raw',
            'filter' => false,
            'htmlOptions'=>array('class'=>'ct'),
        ),
        array(
            'name'=>'s_name',
            'value' => 'Chtml::link($data->s_name,array("store/login","id" => $data->id),array("class"=>"link login-authorized"))',
            'type' => 'raw',
            'htmlOptions'=>array('class'=>'ct'),
        ),
        array(
            'name'=>'s_address',
            'htmlOptions'=>array('class'=>'ct'),
        ),
        array(
            'name'=>'status',
            'value' => 'Yii::app()->params["store.status"][$data->i_status]',
            'filter' => Yii::app()->params["store.status"],
            'htmlOptions'=>array('class'=>'ct'),
        ),
        array(
            'name'=>'Maps',
            'value' => '"<a><div class=\"icon-maps\"><div class=\"maps-hover\"><iframe width=\"300\" height=\"170\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"https://maps.google.com/maps?q=".$data->s_latitude.",".$data->s_longitude."&hl=es;z=14&amp;output=embed\"></iframe><br /></div></div></a>"',
            'type' => 'raw',
            'filter' => false,
            'htmlOptions'=>array('class'=>'ct','style' => 'padding:1px;'),
        ),
        array(
			'class'=>'CButtonColumn',
            'template'=>'{update}{delete}',
            'buttons' => array(
                'update'=>array(
                    'label'=>'<i>&#xf040;</i> EDIT',
                    'imageUrl' => false,
                    'options'=>array( 'title'=>'Edit','class'=>'btnAction1'),
                ),
                'delete'=>array(
                    'label'=>'<i>&#xf235;</i> DEL',
                    'imageUrl' => false,
                    'options'=>array( 'title'=>'Delete','class'=>'btnAction2'),
                ),
            ),
            'htmlOptions'=>array('style'=>'width:123px; padding:1px;'),
		),
	),
    'pager'=>array(
        'cssFile'=>false,
        'class'=>'CLinkPager',
        'firstPageLabel' => 'First',
        'prevPageLabel' => 'Previous',
        'nextPageLabel' => 'Next',
        'lastPageLabel' => 'Last',
        'header'=>'',
        'selectedPageCssClass'=>'active',
    ),
    'pagerCssClass' => 'pagination',
));?>
  <script>
    $(function(){ 
        $('.detailAccount').popup({
            height:500,
        });
   });
 </script>