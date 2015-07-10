<div class="action">
    <?php echo CHtml::link('<i>&#xf234;</i>Add Customer', array('add')); ?>
</div>
<?php 
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'data-grid',
	'dataProvider'=>$model->search(array('store_id' => Yii::app()->user->storeID,'is_shopping' => 1)),
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
            'name'=>'s_image_server',
            'value' => '($data->s_image_server != "")?CHtml::image(Yii::app()->baseUrl."/data/customer/120x120_".$data->s_image_server,"",array("style"=>"width:35px")):"<div style=\"width:35px; height:35px; background:#".sprintf("%06x",rand(0,987654))."; margin:0 auto \"></div>"',
            'filter' => false,
            'type'=>'raw',
            'htmlOptions'=>array('class'=>'ct','style' => 'padding:0'),
        ),
        array(
            'name'=>'s_name',
            'value' => 'Chtml::link($data->s_name,array("customer/detail","alias" => $data->pk_s_id),array("class"=>"link detailCustomer"))',
            'type'=>'raw',
            'htmlOptions'=>array('class'=>'ct'),
        ),
        array(
            'name'=>'s_code',
            'type'=>'raw',
            'filter' => false,
            'htmlOptions'=>array('class'=>'ct'),
        ),
        array(
            'name'=>'s_email',
            'type'=>'raw',
            'filter' => false,
            'htmlOptions'=>array('class'=>'ct'),
        ),
        array(
            'name'=>'Tell',
            'value' => '$data->s_hand_phone. " - ". $data->s_home_phone',
            'type'=>'raw',
            'filter' => false,
            'htmlOptions'=>array('class'=>'ct'),
        ),
        array(
            'name' => 'i_disable',
            'type' => 'raw',
            'value' => 'Yii::app()->params["flag.disable"][$data->i_disable]',
            'filter' => false,
            'htmlOptions'=>array('class'=>'ct','style'=>'width:110px; padding:1px 2px;'),
        ),
        array(
            'name' => 'i_level',
            'type' => 'raw',
            'value' => 'Yii::app()->params["customer.level"][$data->i_level]',
            'filter' => Yii::app()->params["customer.level"],
            'htmlOptions'=>array('class'=>'ct','style'=>'width:110px; padding:1px 2px;'),
        ),
        array(
			'class'=>'CButtonColumn',
            'template'=>'{edit}{delete}',
            'buttons' => array(
                'edit'=>array(
                    'label'=>'<i>&#xf040;</i> EDIT',
                    'imageUrl' => false,
                    'url' => 'array("customer/edit","id" => $data->id)',
                    'options'=>array( 'title'=>'Edit','class'=>'btnAction1'),
                    //'visible' => '(Yii::app()->user->userID != $data->id)'
                ),
                'delete'=>array(
                    'label'=>'<i>&#xf235;</i> DEL',
                    'imageUrl' => false,
                    'options'=>array( 'title'=>'Delete','class'=>'btnAction2'),
                    //'visible' => '(Yii::app()->user->userID != $data->id)'
                )
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
));
 ?>
 <script>
 $(function(){
    $('.detailCustomer').popup({
        height:500,
    });
 });
 </script>