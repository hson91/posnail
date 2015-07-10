<div class="action">
    <?php if($model->i_disable == 1) {?>
    <div class="box-nav" style="background: #5cb85c; line-height: 20px; height:50px; line-height: 27px; width:100px">
        <a href="<?php echo Yii::app()->baseUrl.'/admin/user?User[id]=1'?>" >
            <div class="icon-nav">
                <i>&#xf007;</i>
            </div>
            <div class="title-nav">
                Unlock
            </div>
        </a>
    </div>
    <?php } ?>
    <?php if($model->i_disable == 0){?>
    <div class="box-nav" style="background: #d9534f; line-height: 20px; height:50px; line-height: 27px;">
        <a href="<?php echo Yii::app()->baseUrl.'/admin/configs'?>">
            <div class="icon-nav">
                <i>&#xf013;</i>
            </div>
            <div class="title-nav">
                Lock
            </div>
        </a>
    </div>
    <?php }?>
    <div class="box-nav" style="background: #5cb85c; line-height: 20px; height:50px; line-height: 27px;">
        <a href="<?php echo Yii::app()->baseUrl.'/admin/configs'?>">
            <div class="icon-nav">
                <i>&#xf013;</i>
            </div>
            <div class="title-nav">
                Edit
            </div>
        </a>
    </div>
    <div class="box-nav" style="background: #FF0000; line-height: 20px; height:50px; line-height: 27px;">
        <a href="<?php echo Yii::app()->baseUrl.'/admin/configs'?>">
            <div class="icon-nav">
                <i>&#xf013;</i>
            </div>
            <div class="title-nav">
                Delete
            </div>
        </a>
    </div>
</div>
<div class="table info-order" style="width: 99.5%; overflow: auto; border:1px solid #dcdcdc">
    <div class="col-4">
        <?php if($model->s_image_server == ''){?>
        <div style="max-height: 140px; max-width: 140px; width: 100%; height:88%; position: absolute;; background: #<?php echo sprintf("%06x",rand(0,987654))?>;"></div>
        <?php }else{
            echo CHtml::image(Yii::app()->baseUrl."/data/customer/120x120_".$model->s_image_server);
        }?>
    </div>
    <div class="col-8">
        <label>Code</label>: <?php echo $model->s_code?><br />
        <label>Fullname</label>: <?php echo $model->s_name?><br />
        <label>Address</label>: <?php echo $model->s_address?><br />
        <label>Email</label>: <?php echo $model->s_email?><br />
        <label>Phone number</label>: <?php echo $model->s_hand_phone." - ".$model->s_home_phone?><br />
    </div>
    <div style="clear:both"></div>
</div>