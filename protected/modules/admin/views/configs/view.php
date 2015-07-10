<div class="action">
    <?php echo CHtml::link('<i>&#xf060;</i>Go Back',Yii::app()->baseUrl.'/user',array('class'=>'goback')); ?>
    <h2>THÔNG TIN CHI TIẾT USER</h2>
</div>
<div class="form" style="position: relative;">
    <?php if($model->ImgCode != null){?>
    <div class="" style="position: absolute;right:20px;width: 160px; text-align: left; right:100px">
        <div id="contentPrint">
            <img src="<?php echo Yii::app()->baseUrl.'/data/userCode/'.$model->ImgCode?>" style="width: 160px; border:1px solid #dcdcdc" />
            <p>NV:<?php echo $model->UserFullName;?></p>
        </div>
        <a id="btnPrind" class="bnt-form" style="">Print Card</a>
    </div>
    <?php }?>
	<div class="controls">
        <div class="label">
            <label class="lbl-form">Họ và Tên: </label>
        </div>
        <div class="input">
           <?php echo $model->UserFullName;?>
        </div>
	</div>
	<div class="controls">
        <div class="label">
            <label class="lbl-form">Địa chỉ: </label>
        </div>
        <div class="input">
            <?php echo $model->UserAddress; ?>
        </div>
	</div>
	<div class="controls">
        <div class="label">
            <label class="lbl-form">Email</label>
        </div>
        <div class="input">
            <?php echo $model->UserEmail; ?>
        </div>
	</div>
	<div class="controls">
        <div class="label">
            <label class="lbl-form">Số điện thoại: </label>
        </div>
        <div class="input">
            <?php echo $model->UserTel; ?>
        </div>
	</div>
	<div class="controls">
        <div class="label">
            <label class="lbl-form">Loại Tài Khoản</label>
        </div>
        <div class="input">
            <?php echo $model->UserRules; ?>
        </div>
	</div>
	<div class="controls" id="customizeControls">
        <div class="label">Quyền hạn: </div>
        <div class="input">
            <?php $controls = $model->controls();foreach($controls as $k=>$control):?>
            <div style="margin-bottom: 20px; width: 30%; display: inline-block; vertical-align: top; border: 1px solid #D7D5D5;">
                <label style="display: block; background: #DCDCDC; width: 95%;line-height: 27px; padding:0 5px"><?php echo $k;?></label>
                <div style="padding: 10px; height: 260px;line-height:22px">
                <?php foreach($control as $act){?>
                    <label style="display: inline-block;width:90%; border-bottom:1px solid #F2EDED"><?php echo $act['Action']?></label>
                    <?php echo ($model->Control == 1 || (isset($act['check']) && $act['check'] == 1))?'<span class="fa" style="color:#1AD20D; font-size:18px">&#xf00c; </span>':'<span class="fa" style="color:red; font-size:18px">&#xf05c; </span>'?><br />
                <?php }//endforeach?>
                </div>
            </div>
            <?php endforeach;?>
        </div>
     </div>
	<div class="controls">
        <div class="label">
            <label class="lbl-form">Lần Đăng Nhập Cuối: </label>
        </div>
		<div class="input">
            <?php echo date("d/m/Y H:i:s",$model->UserVisited); ?>
        </div>
	</div>
	<div class="controls">
        <div class="label">
            <label class="lbl-form">Tình trạng: </label>
        </div>
		<div class="input">
            <?php echo Yii::app()->params['status'][$model->Status]; ?>
        </div>
	</div>
	<div class="controls">
        <label class="label" style="display: inline-block;"> &nbsp;</label>
        <div class="input">
            <a href="<?php echo Yii::app()->baseUrl.'/user';?>" class="bnt-form" ><i class="fa">&#xf177; </i> Danh sách</a>
            <a href="<?php echo Yii::app()->baseUrl.'/user/update/'.$model->PkUserID;?>" class="bnt-form" style="margin-left: 5px;" >Chỉnh sửa <i class="fa">&#xf178;</i></a>
        </div>
	</div>
</div>