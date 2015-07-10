<section class="page-content">
	<div class="container">
    	<div class="row">
        	<?php /* <h2 class="title-accent">I Want To</h2> */ ?>
        	<div class="col-3">
            	<div class="box">
                	<div class="box-icon">
                    	<img src="images/websites/repair.png" />
                    </div>
                    <div class="box-body">
                    	<p class="title" style="color:#6d6d6d"><b>Repair My Equipment</b></p>
                        <p class="description">We repair Apple products, iPhone, iPad, iPod, Macbook, all laptop brand and model.</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
            	<div class="box">
                	<div class="box-icon">
                    	<img src="images/websites/Pricing-128.png" />
                    </div>
                	<div class="box-body">
                    	<p class="title" style="color:#6d6d6d"><b>Know The Price</b></p>
                        <p class="description">Service fee from $50 not including parts. <a href="<?php echo Yii::app()->baseUrl.'/know-the-price.html'?>">More</a>.</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
            	<div class="box">
                	<div class="box-icon">
                    	<img src="images/websites/icon_location.png" />
                    </div>
                	<div class="box-body">
                    	<p class="title" style="color:#6d6d6d"><b>Know The Location</b></p>
                        <p class="description">We are just 5 minute walk from Braddell MRT. <br> <a href="<?php echo Yii::app()->baseUrl.'/maps.html'?>">Exact location</a>.</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
            	<div class="box">
                	<div class="box-icon">
                    	<img src="images/websites/time_icon.png" />
                    </div>
                	<div class="box-body">
                    	<p class="title" style="color:#6d6d6d"><b>The Repair Time</b></p>
                        <p class="description">Repair time within 3 working days. Express service available.<a href="<?php echo Yii::app()->baseUrl?>/contact-us.html">Contact us.</a></p>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</section>
<section class="page-content" style="background:#1a75bb" id="contactForm">
	<div class="container">
        <div class="row">
        	<div class="col-3 reponsive-none">
            	<p class="request-quote-home">REQUEST <br>A FREE <br>QUOTE</p>
            </div>
            <div class="col-7">
            	<div class="form-request">
                    <h3 class="title-accent form-request-none" style="font-size: 20px; margin-top: 20px;">REQUEST A FREE QUOTE</h3>
                    <form action="<?php echo Yii::app()->baseUrl?>/contacts.html" method="post">
                    <?php if(Yii::app()->user->hasFlash('mss')) echo Yii::app()->user->getFlash('mss');?>
                    <?php if(Yii::app()->user->hasFlash('errContact')) $errors = Yii::app()->user->getFlash('errContact');?>
                	<?php if(Yii::app()->user->hasFlash('valueContact')) $values = Yii::app()->user->getFlash('valueContact');?>
                    <div class="col-6">
                    	<div class="controls">
	                    	<input type="text" style="<?php echo isset($errors['fullname'])?'border:1px solid red':''?>" placeholder="Name" value="<?php echo isset($values['fullname'])?$values['fullname']:''?>" name="Contact[fullname]" />
                            <textarea style="<?php echo isset($errors['message'])?'border:1px solid red':''?>" placeholder="Service Requirement" name="Contact[description]"><?php echo isset($values['description'])?$values['description']:''?></textarea>
                        </div>
                    </div>
                	<div class="col-6">
                    	<div class="controls">
    	                	<input style="<?php echo isset($errors['phone'])?'border:1px solid red':''?>" type="text" placeholder="Contact No" value="<?php echo isset($values['phone'])?$values['phone']:''?>" name="Contact[phone]" />
	                        <input style="<?php echo isset($errors['email'])?'border:1px solid red':''?>" type="text" placeholder="Email" value="<?php echo isset($values['email'])?$values['email']:''?>" name="Contact[email]" />
                            <input type="submit" value="SUBMIT YOUR REQUEST" />
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
<section class="page-content" id="quick-stats">
	<div class="container">
        <div class="row">
        	<h3 class="title-accent" style="font-size: 20px; color:#6d6d6d">DEVICES WE HAVE RESCUED LAST YEAR</h3>
        	<div class="col-4">
            	<div class="box">
                	<div class="box-icon">
                    	<img src="images/websites/mobile-icon.png" />
                    </div>
                	<div class="box-body">
                    	<p class="numeric text-large-green" data-number="<?php echo isset($this->configs['nuumber-mobile'])?$this->configs['nuumber-mobile']:0 ?>">0</p>
                    </div>
                </div>
            </div>
        	<div class="col-4">
            	<div class="box">
                	<div class="box-icon">
                    	<img src="images/websites/phalet.png" />
                    </div>
                	<div class="box-body">
                    	<p class="numeric text-large-green" data-number="<?php echo isset($this->configs['number-tablets'])?$this->configs['number-tablets']:0 ?>">0</p>
                    </div>
                </div>
            </div>
            <div class="col-4">
            	<div class="box">
                	<div class="box-icon">
                    	<img src="images/websites/laptop-1.png" />
                    </div>
                	<div class="box-body">
                    	<p class="numeric text-large-green" data-number="<?php echo isset($this->configs['number-laptop'])?$this->configs['number-laptop']:0 ?>">0</p>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</section>
<section class="page-content" id="repairCodeForm" style="background:#444444">
	<div class="container">
        <div class="row">
        	<div class="col-3 reponsive-none">
            	<p class="request-quote-home"><img src="images/websites/form-icon.png" /></p>
            </div>
            <div class="col-5">
            	<div class="form-repair-code">
	            	<p style="color:#fff; margin-bottom:10px">Check repair status. Enter repair code.</p>
                    <form method="post" action="<?php echo Yii::app()->baseUrl.'/checkDevice.html'?>">
                        <textarea name="serial-number-check"></textarea>
                        <input type="submit" value="check" />
                    </form>
                </div>
            </div>
            <div class="col-2">&nbsp;</div>
            <div class="clearfix"></div>
        </div>
    </div>
</section>
<section class="page-content" id="contactUs">
	<div class="container">
        <div class="row">
        	<div class="col-7">
            	<div class="maps">
            	<?php if($this->configs['maps']) echo $this->configs['maps'];?>
                </div>
            </div>
            <div class="col-5">
            	<div class="info-contact">
	            	<p style="color:#6d6d6d; font-size:20px; margin-bottom:15px">CONTACT US</p>
                    <ul class="contacts-info-list">
                        <li>
                            <i class="fa fa-map-marker"></i>
                            <div class="info-item" style="line-height:22px; color:#6d6d6d">
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
                <div class="col-12">
                    <div class="fb-page" data-href="https://www.facebook.com/pages/Itech-Vision/100152426983810" data-width="100%" data-height="300" data-small-header="true" data-adapt-container-width="false" data-hide-cover="true" data-show-facepile="true" data-show-posts="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/pages/Itech-Vision/100152426983810"><a href="https://www.facebook.com/pages/Itech-Vision/100152426983810">Itech Vision</a></blockquote></div></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</section>