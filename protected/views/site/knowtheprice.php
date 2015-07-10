<script src="<?php echo Yii::app()->baseUrl.'/js/lmk.js'?>"></script>
<div class="breadcrumb"><?php echo isset($titleStatic)?$titleStatic:''?></div>
<section class="page-content" id="quick-stats">
	<div class="container lkm">
        <div class="row">
        	<div class="col-4">
            	<div class="box">
                	<div class="box-icon">
                        <a href="#mobilePriceList" class="mobilePriceList">
                    	   <img src="images/websites/price_list_images_iphone.jpg" style="width: 300px;" />
                        </a>
                        <div id="mobilePriceList" class="box-modal mfp-hide">
                            <div class="conten-modal">
                                <?php if(isset($data['priceListMobile']) && $data['priceListMobile'] != null){echo $data['priceListMobile'];}else{echo 'No data';}?>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function(){
                                $('.mobilePriceList').magnificPopup({
                                  type: 'inline',
                                  midClick: true,
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        	<div class="col-4">
            	<div class="box">
                	<div class="box-icon">
                        <a href="#phaletPriceList" class="phaletPriceList">
                    	   <img src="images/websites/price_list_images_ipad.jpg"  style="width: 300px;" />
                        </a>
                        <div id="phaletPriceList" class="box-modal mfp-hide">
                            <div class="conten-modal">
                                <?php if(isset($data['priceListPhalets']) && $data['priceListPhalets'] != null ){echo $data['priceListPhalets'];}else{echo 'No data';}?>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function(){
                                $('.phaletPriceList').magnificPopup({
                                  type: 'inline',
                                  midClick: true,
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
            <div class="col-4">
            	<div class="box">
                	<div class="box-icon">
                        <a href="#laptopPriceList" class="laptopPriceList">
                    	   <img src="images/websites/price_list_images_laptop.jpg"  style="width: 300px;" />
                        </a>
                        <div id="laptopPriceList" class="box-modal mfp-hide">
                            <div class="conten-modal">
                                <?php if(isset($data['priceListLaptop']) && $data['priceListLaptop'] != null){echo $data['priceListLaptop'];}else{echo 'No data';}?>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function(){
                                $('.laptopPriceList').magnificPopup({
                                  type: 'inline',
                                  midClick: true,
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</section>