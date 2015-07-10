<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
<link href="<?php echo Yii::app()->baseUrl?>/css/style.css" type="text/css" rel="stylesheet" />
<link href="<?php echo Yii::app()->baseUrl?>/css/awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
<link href="<?php echo Yii::app()->baseUrl?>/css/magnific-popup.css" type="text/css" rel="stylesheet" />
<script src="<?php echo Yii::app()->baseUrl?>/js/jquery-1.11.0.min.js"></script>
<script src="<?php echo Yii::app()->baseUrl?>/js/numeral.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/app.js"></script>
<?php if($this->slides != null){?>
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl?>/vendor/rs-plugin/css/settings.css" media="screen" />
    <script src="<?php echo Yii::app()->baseUrl?>/vendor/rs-plugin/js/jquery.themepunch.plugins.min.js"></script>
	<script src="<?php echo Yii::app()->baseUrl?>/vendor/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>

	<script>
		jQuery(document).ready(function() {
			jQuery('.slider').revolution({
				dottedOverlay:"filled",
				delay:6000,
				startwidth:(window.innerWidth > 1366)?window.innerWidth:1349,
				startheight:(window.innerWidth > 1366)?(window.innerWidth * 450 /1349):450,
				hideThumbs:0,
				fullWidth:"on",
				forceFullWidth:"off",
				hideCaptionAtLimit:480,
				//navigationType: "none",
				soloArrowLeftHOffset:20,
				soloArrowRightHOffset:20,
				navigationType:"bullet",
				//navigationArrows:"solo", // nexttobullets, solo (old name verticalcentered), none
				navigationStyle:"round",  // round, square, navbar, round-old, square-old, navbar-old 
                hideTimerBar:"on",
			});
	   });
	</script>
<?php }?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
 
  ga('create', 'UA-62148712-1', 'auto');
  ga('send', 'pageview');
 
</script>
<script src="<?php echo Yii::app()->baseUrl?>/js/jquery.magnific-popup.js"></script>
<title><?php echo $this->pageTitle?></title>
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="site-wrapper">
	<header class="header">
        <div class="header-top">
        	<div class="container">  
            	<a href="mailto:enquiry@itech.com.sg" style="color: #6d6d6d;"><span class="fa fa-envelope-o"></span></a>&nbsp;
	            <span style="color: #6d6d6d;"><span class="fa fa-phone"></span></span>&nbsp;<span style="color:#6d6d6d">+65 6353 5321</span>
        	</div>
        </div>
        <div class="header-main">
        	<div class="container">
            	<div class="logo">
                	<a href="<?php echo Yii::app()->baseUrl.'/'?>"><img src="images/websites/logo_itech.png" /></a>
                	<div class="button-menu" id="btnMenuBar"><span class="fa fa-bars"></span></div>
                </div>
                <div class="main-nav">
                    <ul class="nav" id="navBarReponsive">
                        <li><a <?php echo ($this->active == '/')?'class="active"':'';?> href="<?php echo Yii::app()->baseUrl?>/">HOME</a></li>
                        <li><a <?php echo ($this->active == 'why-itech')?'class="active"':'';?> href="<?php echo Yii::app()->baseUrl?>/why-itech.html">WHY ITECH</a></li>
                        <li><a <?php echo ($this->active == 'about')?'class="active"':'';?> href="<?php echo Yii::app()->baseUrl?>/about.html">ABOUT US</a></li>
                        <li><a <?php echo ($this->active == 'testimonials')?'class="active"':'';?> href="<?php echo Yii::app()->baseUrl?>/testimonials.html">TESTIMONIALS</a></li>
                       <li><a <?php echo ($this->active == 'liveChat')?'class="active"':'';?> href="<?php echo Yii::app()->baseUrl?>/live-chat.html">LIVE CHAT</a></li>
                        <li><a <?php echo ($this->active == 'contact')?'class="active"':'';?> href="<?php echo Yii::app()->baseUrl?>/contact-us.html">CONTACT US</a></li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </header>
    <?php if($this->slides != null){?>
    <div class="page-content" style="position: relative; overflow: visible;">
        <div class="slider">
            <ul>
                <?php foreach($this->slides as $slide){
                ?>
                <li data-transition="fade" data-slotamount="7" data-masterspeed="1000" data-delay="6000" >
    				<img src="<?php echo Yii::app()->baseUrl?>/images/slides/<?php echo $slide->id?>.jpg" title="<?php echo $slide->title?>" alt="<?php echo $slide->title?>" data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat" />
                </li>
                <?php        
                    }?>
    
    		</ul>
        </div>
    </div>
    <?php }?>
    <?php echo $content;?>
    <footer class="footer">
    	<div class="container">
        	<div class="col-8 coppy-right"><a href="<?php echo Yii::app()->baseUrl.'/privacy-policy.html'?>">Privacy Policy</a> | <a href="<?php echo Yii::app()->baseUrl.'/terms-and-conditions.html'?>">Terms and Conditions</a> | <a style="margin-right: 20px;" target="_blank" href="<?php echo Yii::app()->baseUrl.'/sitemap.html'?>">Sitemap</a> <span style="display: inline-block;">Copyright © 2015 Itech Vision Pte Ltd. All Rights Reserved.</span></div>
            <div class="social">
            	<ul class="col-4- social-links">
                    <?php /* ?>
                    <li><a href="<?php if($this->configs['link-facebook']) echo $this->configs['link-facebook'];?>"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="<?php if($this->configs['link-twitter']) echo $this->configs['link-twitter'];?>"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="<?php if($this->configs['link-google-plus']) echo $this->configs['link-google-plus'];?>"><i class="fa fa-google-plus"></i></a></li>
                    <?php */?>
                </ul>
            </div>
        </div>
    </footer>
</div>
</body>
</html>
