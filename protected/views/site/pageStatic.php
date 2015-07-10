<div class="breadcrumb"><?php echo isset($titleStatic)?$titleStatic:''?></div>
<section class="page-content">
	<div class="container">
        <div class="row dataContent" style="padding:0 15px; margin-bottom: 20px; margin-top: 20px;">
        <?php if($data){
                echo $data;
            }else{
                echo 'Data is updating...';
            }?>
          <div class="clearfix"></div>
         </div>
    </div>
</section>     