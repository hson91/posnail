$(document).ready(function(){
    $('body').css('cursor', 'wait');
    $('.message-show').hide();
    $('.message-show').html('Đang cập nhật lại thông tin đơn hàng...!').fadeIn();
    $.ajax({
        type:'get',
        url:url + '/billdetail/addtobill/' + billID,
        async:true,
        success:function(data){
            $('.bill-detail').html(data);
            $('body').css('cursor', 'default');
            $('.message-show').html('Đã cập nhật thông tin đơn hàng thành công!').delay(2000).fadeOut(400);
        },
        error: function(){
            $('.message-show').html('Đã có lỗi!').delay(2000).fadeOut(400);
        }
    });
    return false; 
});