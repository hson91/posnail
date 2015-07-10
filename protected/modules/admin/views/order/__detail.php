<div class="table info-order" style="width: 99.5%; overflow: auto; border:1px solid #dcdcdc">
    <div class="col-6" style="border-right: 1px solid #dcdcdc;">
        <label>Order Code</label>: <?php echo $model->s_order_code?><br />
        <label>Creator</label>: <?php echo $model->s_user_id?><br />
        <label>Customer Name</label>: <?php echo $model->s_customer_name?><br />
        <label>Customer Addredd</label>: <?php echo $model->s_customer_address?><br />
        <label>Customer Phone number</label>: <?php echo $model->s_customer_hand_phone." - ".$model->s_customer_home_phone;?><br />
        <label>Method</label>: <?php echo Yii::app()->params["order.method"][$model->i_method]?><br />
        <label>Order Status</label>: <?php echo Yii::app()->params["order.status"][$model->i_status]?><br />
        <?php if($model->s_notes != ''){?>
        <label>Notes</label>: <br /><?php echo $model->s_notes?><br />
        <?php }?>
        <label>Created</label>: <?php echo ($model->i_created_date > 0)?date("Y-m-d H:i:s",$model->i_created_date):''?><br />
    </div>
    <div class="col-6">
        <label>Total Service</label>: <?php echo $model->i_total_service?> service<br />
        <label>Total Monney</label>: <?php echo $model->s_total_money?><br />
        <label>Deals</label>: <?php echo $model->s_discount_name?><br />
        <label>Discount</label>: <?php echo $model->f_discount?><br />
        <label>Total Monney After Discount</label>: <?php echo $model->s_total_after_discount;?><br />
    </div>
    <div style="clear:both"></div>
</div>
<div class="table" style="width: 99.5%; overflow: auto; height: 100%;">
    <table class="items tableInput">
        <thead>
            <tr>
                <th>No.</th>
                <th>Service</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Discount</th>
                <th>Total</th>
                <th>Implementers</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($details)){ $i = 1;?>
            <?php foreach($details as $detail){ ?>
            <tr>
                <td class="ct"><?php echo $i?></td>
                <td class="ct"><?php echo $detail->s_service_name?></td>
                <td class="ct"><?php echo $detail->i_qty?></td>
                <td class="ct"><?php echo $detail->s_service_price?></td>
                <td class="ct"><?php echo $detail->f_discount?></td></td>
                <td class="ct"><?php echo $detail->s_total_after_discount?></td></td>
                <td class="ct"><?php echo $detail->s_user_fullname?></td></td>
                <td class="ct" style="width:132px">
                    <a title="Edit" class="btnAction2" href="#" style="display: inline-block;"><i style="color: #FFF;">&#xf040;</i> EDIT</a>
                    <a title="Delete" class="btnAction1" href="#" style="display: inline-block;"><i style="color: #FFF;">&#xf235;</i> DEL</a>
                </td>
            </tr>
            <?php } }?>
        </tbody>
    </table>
</div>