<div class="action">
    <?php echo CHtml::link('<i>&#xf234;</i>Add User', array('add')); ?>
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
            'name'=>'s_username',
            'value' => 'Chtml::link($data->s_username,array("user/detail","id" => $data->id),array("class"=>"link"))',
            'type'=>'raw',
            'htmlOptions'=>array('class'=>'ct'),
        ),
        array(
            'name' => 's_store_id',
            'value' => '($data->store() != null)?Chtml::link($data->store()->s_name,array("store/detail","id" => $data->store()->id),array("class"=>"link")):"N/A"',
            'type'=>'raw',
            'htmlOptions'=>array('class'=>'ct'),
        ),
        array(
            'name' => 's_tell',
            'htmlOptions'=>array('class'=>'ct'),
        ),
        array(
            'name'=>'s_email',
            'type'=>'raw',
            'htmlOptions'=>array('class'=>'ct'),
        ),
        array(
            'name' => 'status',
            'type' => 'raw',
            'value' => '$data->status()',
            'filter' => false,
            'htmlOptions'=>array('class'=>'ct','style'=>'width:110px; padding:1px 2px;'),
        ),
        array(
            'name' => 'i_login_closest',
            'type' => 'raw',
            'value' => 'date("Y-m-d H:i:s",$data->i_login_closest)',
            'filter' => false,
            'htmlOptions'=>array('class'=>'ct'),
        ),
        array(
			'class'=>'CButtonColumn',
            'template'=>'{edit}{delete}{BEING_LOGGED}',
            'buttons' => array(
                'edit'=>array(
                    'label'=>'<i>&#xf040;</i> EDIT',
                    'imageUrl' => false,
                    'url' => 'array("user/edit","id" => $data->id)',
                    'options'=>array( 'title'=>'Edit','class'=>'btnAction1'),
                    'visible' => '(Yii::app()->user->userID != $data->id)'
                ),
                'delete'=>array(
                    'label'=>'<i>&#xf235;</i> DEL',
                    'imageUrl' => false,
                    'options'=>array( 'title'=>'Delete','class'=>'btnAction2'),
                    'visible' => '(Yii::app()->user->userID != $data->id)'
                ),
                'BEING_LOGGED' => array(
                    'label' => 'BEING LOGGED',
                    'imageUrl' => false,
                    'options'=>array( 'style'=>'cursor:not-allowed; background:#888;width:120px','class'=>'btnAction1'),
                    'visible' => '(Yii::app()->user->userID == $data->id)'
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