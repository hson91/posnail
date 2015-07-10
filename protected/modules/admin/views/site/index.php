<?php /* <form method="post" id="frmtestdemo" enctype="multipart/form-data" action="<?php echo Yii::app()->baseUrl.'/admin/store/index'?>">
    <input type="file" name="image" />
    <input type="submit" />
</form>

<script>
    $('#frmtestdemo').submit(function(){
        
        var dataform = new FormData($(this)[0]);
        console.log(dataform);
        $.ajax({
            url: $(this).attr('action'),
            type:'post',
            data:dataform,
            success:function(data){
              $('#content-text').text(data);  
            },
            contentType: false,
            processData: false
        });
        return false;
    });
</script>
<div id="content-text"></div> */ ?>