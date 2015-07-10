<div class="action">
    <?php if($model->i_active == 0){?>
    <div class="box-nav" style="background: #5F2A7A; height:50px; line-height: 27px; width:130px">
        <a href="<?php echo Yii::app()->baseUrl.'/admin/customer'?>">
            <div class="icon-nav">
                <i>&#xf0c0;</i>
            </div>
            <div class="title-nav">
                Active
            </div>
        </a>
    </div>
    
    <div class="box-nav" style="background: #5cb85c; line-height: 20px; height:50px; line-height: 27px; width:280px">
        <a href="<?php echo Yii::app()->baseUrl.'/admin/user?User[id]=1'?>" >
            <div class="icon-nav" style="width: auto;">
                <i>&#xf007;</i>
            </div>
            <div class="title-nav" style="width: auto; margin-left: 10px;">
                Resend activation code
            </div>
        </a>
    </div>
    <?php }?>
    <?php if($model->i_active == 1 && $model->i_disable == 1) {?>
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
    <?php if($model->i_active == 1 && $model->i_disable == 0){?>
    <div class="box-nav" style="background: #d9534f; line-height: 20px; height:50px; line-height: 27px; width:100px">
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
    <div class="col-6" style="border-right: 1px solid #dcdcdc;">
        <?php if($model->store() != null){?>
        <label>Store</label>: <?php echo Chtml::link($model->store()->s_name,array("store/login","id" => $model->store()->id),array("class" =>"link login-authorized"))?><br />
        <?php } ?>
        <?php if($model->role != null){?>
        <label>Type Account</label>: <?php echo $model->role->title?><br />
        <?php } ?>
        <label>Username</label>: <?php echo $model->s_username?><br />
        <label>Fullname</label>: <?php echo $model->s_fullname?><br />
        <label>Address</label>: <?php echo $model->s_address?><br />
        <label>Email</label>: <?php echo $model->s_email?><br />
        <label>Phone number</label>: <?php echo $model->s_tell?><br />
    </div>
    <div class="col-6">
        <label>Number of Devices</label>: <?php echo $model->i_device_count?><br />
        <label>Number of Max Device</label>: <?php echo $model->i_device_max;?><br />
        <label>Status</label>: <div style="width: auto; padding:5px 20px; display: inline-block;"><?php echo $model->status();?></div><br />
    </div>
    <div style="clear:both"></div>
</div>
<div class="table" style="width: 99.5%; overflow: auto; height: 100%;">

</div>