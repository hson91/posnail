<div class="action">
    <div class="box-nav" style="background: #337ab7;">
        <a href="<?php echo Yii::app()->baseUrl.'/admin/service'?>">
            <div class="icon-nav">
                <i>&#xf03a;</i>
            </div>
            <div class="title-nav">
                <strong>25</strong><br>
                Service
            </div>
        </a>
    </div>
    <div class="box-nav" style="background: #5F2A7A;">
        <a href="<?php echo Yii::app()->baseUrl.'/admin/customer'?>">
            <div class="icon-nav">
                <i>&#xf0c0;</i>
            </div>
            <div class="title-nav">
                <strong>205</strong><br>
                Customer
            </div>
        </a>
    </div>
    <div class="box-nav" style="background: #f0ad4e;">
        <a href="<?php echo Yii::app()->baseUrl.'/admin/order'?>">
            <div class="icon-nav">
                <i>&#xf15c;</i>
            </div>
            <div class="title-nav">
                <strong>205</strong><br>
                Order
            </div>
        </a>
    </div>
    <div class="box-nav" style="background: #5cb85c;">
        <a href="<?php echo Yii::app()->baseUrl.'/admin/user?User[id]=1'?>" >
            <div class="icon-nav">
                <i>&#xf007;</i>
            </div>
            <div class="title-nav">
                <strong>5</strong><br>
                Employee
            </div>
        </a>
    </div>
    <div class="box-nav" style="background: #d9534f;">
        <a href="<?php echo Yii::app()->baseUrl.'/admin/configs'?>">
            <div class="icon-nav">
                <i>&#xf013;</i>
            </div>
            <div class="title-nav">
                <strong>15</strong><br>
                Configs
            </div>
        </a>
    </div>
</div>
<div class="info-store">
    <div class="col-7">
        <div class="store">
            <div class="title">
                Store Infomation            
            </div>
            <div class="action">
                <?php echo CHtml::link('<i>&#xf044;</i>Edit', array('edit')); ?>
            </div>
            <div class="col-12">
                <label>Name: </label>
                <span><?php echo $model->s_name;?></span>
            </div>
            <div class="col-12">
                <label>Address: </label>
                <span><?php echo $model->s_address;?></span>
            </div>
            <div class="col-12">
                <label>Summary: </label>
                <span><?php echo $model->s_summary;?></span>
            </div>
            <div class="col-12">
                <label>Status: </label>
                <span><?php echo Yii::app()->params["store.status"][$model->i_status]?></span>
            </div>
            <div class="col-12">
                <label style="margin-bottom: 10px;">Maps: </label>
                <iframe width="100%" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=<?php echo $model->s_latitude.','.$model->s_longitude?>&hl=es;z=14&amp;output=embed"></iframe>
            </div>
            <div style="clear: both;"></div>
        </div>
    </div>
    <div class="col-5">
        <div class="service">
            <div class="title">
                List Service            
            </div>
            <?php
                $this->widget('zii.widgets.grid.CGridView', array(
            	'id'=>'data-grid',
            	'dataProvider'=>$service->search(),
                'htmlOptions'=>array('class'=>'table tbuser'),
                'summaryText'=>'',
                'filter'=>$service,
                'columns'=>array(
                    array(
                        'name'=>'No',
                        'filter'=>false,
                        'value' => '$row + 1',
                        'type'=>'raw',
                        'htmlOptions'=>array('class'=>'ct id'),
                    ),
                    array(
                        'name' => 's_service_type_id',
                        'htmlOptions' => array('class' => 'resp-hide'),
                    ),
                    array(
                        'name'=>'s_name',
                        'value' => 'Chtml::link($data->s_name,array("user/detail","id" => $data->id),array("class"=>"link"))',
                        'type' => 'raw',
                        'filter' => false,
                        'htmlOptions'=>array('class'=>'ct'),
                    ),
                    array(
                        'name'=>'s_price',
                        'type' => 'raw',
                        'htmlOptions'=>array('class'=>'ct'),
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
                        'htmlOptions'=>array('style'=>'width:123px; padding:1px;','class'=>'resp-hide'),
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
            <div style="clear: both;"></div>
        </div>
    </div>
    <div class="col-7">
        <div class="customer">
            <div class="title">
                List Customer            
            </div>
            <?php
                $this->widget('zii.widgets.grid.CGridView', array(
            	'id'=>'data-grid',
            	'dataProvider'=>$customer->search(),
                'htmlOptions'=>array('class'=>'table tbuser'),
                'summaryText'=>'',
                'filter'=>$customer,
                'columns'=>array(
                    array(
                        'name'=>'No',
                        'filter'=>false,
                        'value' => '$row + 1',
                        'type'=>'raw',
                        'htmlOptions'=>array('class'=>'ct id'),
                    ),
                    array(
                        'name'=>'s_name',
                        'value' => 'Chtml::link($data->s_name,array("customer/detail","id" => $data->id),array("class"=>"link"))',
                        'type' => 'raw',
                        'filter' => false,
                        'htmlOptions'=>array('class'=>'ct'),
                    ),
                    array(
                        'name'=>'Tel',
                        'value' => '$data->s_home_phone." - ".$data->s_hand_phone',
                        'filter' => false,
                        'type' => 'raw',
                        'htmlOptions'=>array('class'=>'ct'),
                    ),
                    array(
                        'name'=>'s_email',
                        'htmlOptions'=>array('class'=>'ct'),
                    ),
                    array(
                        'name'=>'i_updated',
                        'value' => 'date("Y-m-d H:i:s",$data->i_updated)',
                        'htmlOptions'=>array('class'=>'ct'),
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
            ));
            ?>
            <div style="clear: both;"></div>
        </div>
    </div>
    <div class="col-5">
        <div class="employee">
            <div class="title">
                List Employee            
            </div>
            <?php
                $this->widget('zii.widgets.grid.CGridView', array(
            	'id'=>'data-grid',
            	'dataProvider'=>$employee->search(),
                'htmlOptions'=>array('class'=>'table tbuser'),
                'summaryText'=>'',
                'filter'=>$employee,
                'columns'=>array(
                    array(
                        'name'=>'No',
                        'filter'=>false,
                        'value' => '$row + 1',
                        'type'=>'raw',
                        'htmlOptions'=>array('class'=>'ct id'),
                    ),
                    array(
                        'name'=>'s_fullname',
                        'value' => 'Chtml::link($data->s_fullname,array("user/detail","id" => $data->id),array("class"=>"link"))',
                        'type' => 'raw',
                        'filter' => false,
                        'htmlOptions'=>array('class'=>'ct'),
                    ),
                    array(
                        'name'=>'status',
                        'value' => '$data->status()',
                        'type' =>'raw',
                        'filter' => false,
                        'htmlOptions'=>array('class'=>'ct'),
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
            ));
            ?>
            <div style="clear: both;"></div>
        </div>
    </div>
</div>