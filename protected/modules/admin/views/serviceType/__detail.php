<?php if(Yii::app()->request->isAjaxRequest){
    echo "<h2 class='title' style='text-align:center'>List of Service with type:$model->s_name</h2>";
}?>
<div class="table" style="width: 99.5%; overflow: auto; height: 100%;">
    <table class="items tableInput">
        <thead>
            <tr>
                <th>No.</th>
                <th>Image</th>
                <th>Service Name</th>
                <th>Summary</th>
                <th>Price</th>
                <th>Unit</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($models)){ $i = 1;?>
            <?php foreach($models as $model){ ?>
            <tr>
                <td class="ct"><?php echo $i?></td>
                <td class="ct" style="width: 35px;"><?php if($model->s_image_server == ''){?>
                                <div style="width:35px; height:35px; background: #<?php echo sprintf("%06x",rand(0,987654))?>;"></div>
                                <?php }else{
                                    echo CHtml::image(Yii::app()->baseUrl."/data/customer/120x120_".$model->s_image_server,'',array('style' => 'width:30px'));
                                }?></td>
                <td class="ct"><?php echo $model->s_name?></td>
                <td class="ct"><?php echo $model->s_summary?></td>
                <td class="ct"><?php echo $model->s_price?></td></td>
                <td class="ct"><?php echo $model->s_unit?></td></td>
                <td class="ct" style="width:132px">
                    <?php echo Chtml::link('<i style="color: #FFF;">&#xf040;</i> EDIT', array('service/edit','id' => $model->id),array('style' => 'display: inline-block','class' =>'btnAction2'));?>
                    <?php echo Chtml::link('<i style="color: #FFF;">&#xf235;</i> EDIT', array('service/delete','id' => $model->id),array('style' => 'display: inline-block','class' =>'btnAction1'));?>
                </td>
            </tr>
            <?php } }?>
        </tbody>
    </table>
</div>