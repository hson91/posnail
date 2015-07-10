$(document).ready(function(){
    $('.addtobill').click(function(){
        $('body').css('cursor', 'wait');
        $('.message-show').hide();
        $('.message-show').html('Đang thêm sản phẩm cho đơn hàng...!').fadeIn();
        var currentID = $(this).attr('id');
        $.ajax({
            type:'get',
            url:$(this).attr('href')+'?ajax=1',
            async:true,
            success:function(data){
                console.log(data);
                $('.bill-detail').html(data);
                $('body').css('cursor', 'default');
                $('.message-show').html('Thêm sản phẩm cho đơn hàng thành công!').delay(2000).fadeOut(400);
            },
            error: function(){
                $('.message-show').html('Đã có lỗi khi thêm sản phẩm cho đơn hàng!').delay(2000).fadeOut(400);
            }
        });
        return false;
    });
});