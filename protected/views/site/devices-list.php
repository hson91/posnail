<div class="breadcrumb"><span class="first-char">R</span>epair Status</div>
<section class="page-content" style="padding-top: 0;">
	<div class="container">
        <div class="row">
        	<div class="col-12" style="margin-top: 0; padding: 0 20px;">
                   <table class="repair-devices" cellpadding="0" cellspacing="0">
                    <tr class="reponsiveNone" style="height:30px; line-height: 30px; background: #56A8D8;">
                        <td style="width: 40px;">No</td>
                        <td style="width: 190px;">Repair Code (S/N)</td>
                        <td style="width: 150px;">Status</td>
                        <td style="text-align: center">Comments</td>
                    </tr>
                    <?php if(!empty($models)){
                        $i = 1;
                        foreach($models as $r){
                    ?>
                    <tr style="border-bottom: 1px solid #fbd6bb;">
                        <td class="reponsiveNone"><?php echo $i;?></td>
                        <td style="font-weight: 900; font-size: 18px;"><?php echo $r['device_serial'];?></td>
                        <td style="color: <?php echo (is_numeric($r['status']))?Yii::app()->params['colorStatusDevice'][$r['status']]:'#fff;background:red; height:100%';?>;">
                                            <?php echo (is_numeric($r['status']))?Yii::app()->params['statusdevice'][$r['status']]:$r['status'];?></td>
                        <td style="text-align: left; padding-left:10px" class="description"><?php echo $r['comments'];?></td>
                    </tr>
                    <?php  $i++;    
                        }
                    }?>
                   </table>
            </div>
          <div class="clearfix"></div>
         </div>
    </div>
</section>