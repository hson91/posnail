<div class="breadcrumb" id="building"><?php echo isset($titleStatic)?$titleStatic:''?></div>
<section class="page-content">
	<div class="container">
        <div class="row">
             <div class="col-6" style="text-align:center">
                    <img src="<?php echo Yii::app()->baseUrl.'/images/websites/building.jpg'?>" style="max-width: 100%;"/>
             </div>
        </div>
    </div>
</section>
<section class="page-content" id="contactUs">
	<div class="container">
        <div class="row">
        	<div class="col-4">
            	<div>
            	<?php if($this->configs['maps']) echo $this->configs['maps'];?>
                </div>
            </div>
            <div class="col-4">
                <div class="col-12">
                    <div class="info-contact">
                        <ul class="contacts-info-list">
                            <li>
                                <i class="fa fa-map-marker"></i>
                                <div class="info-item" style="line-height:22px;color:#6d6d6d">
                                    <?php if($this->configs['address']) echo $this->configs['address'];?>
                                </div>
                            </li>
                            <li>
                                <i class="fa fa-phone"></i>
                                <div class="info-item" style="color:#6d6d6d">
                                    <?php if($this->configs['phone-number']) echo $this->configs['phone-number'];?>
                                </div>
                            </li>
                            <li>
                                <i class="fa fa-envelope"></i>
                                <span class="info-item">
                                    <a href="mailto:<?php if($this->configs['email']) echo $this->configs['email'];?>"><?php if($this->configs['email']) echo $this->configs['email'];?></a>
                                </span>
                            </li>
                            <li>
                                <i class="fa fa-facebook"></i>
                                <div class="info-item">
                                    <?php $facebook = isset($this->configs['link-facebook'])?$this->configs['link-facebook']:'';?>
                                    <?php echo $facebook;?>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-4" style="padding: 10px;">
                   <div class="fb-page" data-width="100%" data-height="300" data-href="https://www.facebook.com/pages/Itech-Vision/100152426983810" data-hide-cover="true" data-show-facepile="true" data-show-posts="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/pages/Itech-Vision/100152426983810"><a href="https://www.facebook.com/pages/Itech-Vision/100152426983810">Itech Vision</a></blockquote></div></div>
                </div>
            <div class="clearfix"></div>
        </div>
    </div>
</section>
<section class="page-content" style="background:#1a75bb;" id="contactForm">
	<div class="container">
        <div class="row">
            <div class="col-12">
            	<div class="form-request">
                    <form action="<?php echo Yii::app()->baseUrl?>/contacts.html" method="post">
                    <?php if(Yii::app()->user->hasFlash('mss')) echo Yii::app()->user->getFlash('mss');?>
                    <?php if(Yii::app()->user->hasFlash('errContact')) $errors = Yii::app()->user->getFlash('errContact');?>
                    <?php if(Yii::app()->user->hasFlash('valueContact')) $values = Yii::app()->user->getFlash('valueContact');
                    ?>
                	<div class="col-6">
                    	<div class="controls">
	                    	<input type="text" style="<?php echo isset($errors['fullname'])?'border:1px solid red':''?>" placeholder="Name" value="<?php echo isset($values['fullname'])?$values['fullname']:''?>" name="Contact[fullname]" />
                            <textarea style="<?php echo isset($errors['message'])?'border:1px solid red':''?>" name="Contact[description]"><?php echo isset($values['description'])?$values['description']:''?></textarea>
                        </div>
                    </div>
                	<div class="col-6">
                    	<div class="controls">
    	                	<input style="<?php echo isset($errors['phone'])?'border:1px solid red':''?>" type="text" placeholder="Contact No" value="<?php echo isset($values['phone'])?$values['phone']:''?>" name="Contact[phone]" />
	                        <input style="<?php echo isset($errors['email'])?'border:1px solid red':''?>" type="text" placeholder="Email" value="<?php echo isset($values['email'])?$values['email']:''?>" name="Contact[email]" />
                            <input type="submit" value="SUBMIT" />
                        </div>
                    </div>
                    </form>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-2">&nbsp;</div>
            <div class="clearfix"></div>
        </div>
    </div>
</section>