<div class="action">
    <?php //echo CHtml::link('<i>&#xf234;</i>Create Order', array('add')); ?>
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
            'name'=>'s_order_code',
            'value' => 'Chtml::link($data->s_order_code,array("order/detail","alias" => $data->pk_s_id),array("class"=>"link"))',
            'type'=>'raw',
            'htmlOptions'=>array('class'=>'ct'),
        ),
        array(
            'name' => 's_customer_name',
            'value' => '($data->customer() != null)?Chtml::link($data->s_customer_name,array("customer/detail","alias" => $data->customer()->pk_s_id),array("class"=>"link")):$data->s_customer_name',
            'type'=>'raw',
            'htmlOptions'=>array('class'=>'ct'),
        ),
        array(
            'name' => 'Phone number',
            'value' => '$data->s_customer_hand_phone." - ". $data->s_customer_home_phone',
            'type' => 'raw',
            'filter' => false,
            'htmlOptions'=>array('class'=>'ct'),
        ),
        array(
            'name'=>'i_total_service',
            'type'=>'raw',
            'filter' => false,
            'htmlOptions'=>array('class'=>'ct'),
        ),
        array(
            'name'=>'s_total_money',
            'type'=>'raw',
            'filter' => false,
            'htmlOptions'=>array('class'=>'ct'),
        ),
        array(
            'name' => 'i_status',
            'type' => 'raw',
            'value' => 'Yii::app()->params["order.status"][$data->i_status]',
            'filter' => false,
            'htmlOptions'=>array('class'=>'ct','style'=>'width:110px; padding:1px 2px;'),
        ),
        array(
            'name' => 'i_created_date',
            'type' => 'raw',
            'value' => 'date("Y-m-d H:i:s",$data->i_created_date)',
            'filter' => false,
            'htmlOptions'=>array('class'=>'ct'),
        ),
        array(
			'class'=>'CButtonColumn',
            'template'=>'{edit}{delete}',
            'buttons' => array(
                'edit'=>array(
                    'label'=>'<i>&#xf040;</i> EDIT',
                    'imageUrl' => false,
                    'url' => 'array("order/edit","id" => $data->id)',
                    'options'=>array( 'title'=>'Edit','class'=>'btnAction1'),
                    'visible' => '(Yii::app()->user->userID != $data->id)'
                ),
                'delete'=>array(
                    'label'=>'<i>&#xf235;</i> DEL',
                    'imageUrl' => false,
                    'options'=>array( 'title'=>'Delete','class'=>'btnAction2'),
                    'visible' => '(Yii::app()->user->userID != $data->id)'
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
));
 ?>
 <script>
   $(function(){ 
        $('.link').popup({
            height:500,
        });
   });
 </script>