$(document).ready(function(){
    $('.statusdevice').click(function(){
        var currentID = $(this).attr('id');
        $('body').css('cursor', 'wait');
        $.ajax({
            type:'get',
            url:$(this).attr('href')+'?ajax=1',
            success:function(data){
               data = data.replace('{"status":"SUCCESS"}','');
                console.log(data);
                $('body').css('cursor', 'default');
                data = $.parseJSON(data);
                if(data['statusDevice'] == 1){
                    $('#'+currentID).html('&#xf0ad;');
                }
                if(data['statusDevice'] == 2){
                    $('#'+currentID).html('&#xf00c;');
                }
                if(data['statusDevice'] == 0){
                    $('#'+currentID).html('&#xf050;');             
                }
                if(typeof(data['update']) != "undefined"){
                    $.fn.yiiGridView.update('data-grid');
                }
            },
        });
        return false; 
    });    
    $('.status').click(function(){
        var currentID = $(this).attr('id');
        $('body').css('cursor', 'wait');
        $.ajax({
            type:'get',
            url:$(this).attr('href')+'?ajax=1',
            success:function(data){
                console.log(data);
                $('body').css('cursor', 'default');
                data = $.parseJSON(data);
                if(data['status'] == 1){
                    $('#'+currentID).html('&#xf06e;');
                }else{
                    $('#'+currentID).html('&#xf070;');
                }
                if(typeof(data['update']) != "undefined"){
                    $.fn.yiiGridView.update('data-grid');
                }
            }
        });
        return false; 
    });
    
    $('.statusVouchers').click(function(){
        var currentID = $(this).attr('id');
        $('body').css('cursor', 'wait');
        $.ajax({
            type:'get',
            url:$(this).attr('href')+'?ajax=1',
            success:function(data){
                console.log(data);
                $('body').css('cursor', 'default');
                data = $.parseJSON(data);
                if(data['status'] == 1){
                    $('#'+currentID).html('&#xf0ad;');
                }else if(data['status'] == 2){
                    $('#'+currentID).html('&#xf00c;');
                }else{
                    $('#'+currentID).html('&#xf064;');
                }
                if(typeof(data['update']) != "undefined"){
                    $.fn.yiiGridView.update('data-grid');
                }
            }
        });
        return false; 
    });
    
    $('.show_home').click(function(){
        var currentID = $(this).attr('id');
        $('body').css('cursor', 'wait');
        $.ajax({
            type:'get',
            url:$(this).attr('href')+'?ajax=1',
            success:function(data){
                console.log(data);
                $('body').css('cursor', 'default');
                data = $.parseJSON(data);
                if(data['show_home'] == 1){
                    $('#'+currentID).html('&#xf06e;');
                }else{
                    $('#'+currentID).html('&#xf070;');
                }
                if(typeof(data['update']) != "undefined"){
                    $.fn.yiiGridView.update('data-grid');
                }
            }
        });
        return false; 
    });
    
    $('.highlight').click(function(){
        var currentID = $(this).attr('id');
        $('body').css('cursor', 'wait');
        $.ajax({
            type:'get',
            url:$(this).attr('href')+'?ajax=1',
            success:function(data){
                console.log(data);
                $('body').css('cursor', 'default');
                data = $.parseJSON(data);
                if(data['highlight'] == 1){
                    $('#'+currentID).html('&#xf06e;');
                }else{
                    $('#'+currentID).html('&#xf070;');
                }
                if(typeof(data['update']) != "undefined"){
                    $.fn.yiiGridView.update('data-grid');
                }
            }
        });
        return false; 
    });
    
    $('.orders').change(function(){
        var orderId = $(this).attr('id');
        orderId = orderId.split('-');
        orderId = orderId[orderId.length - 1];
        var name = $(this).attr('name');
        $('body').css('cursor', 'wait');
        $.ajax({
            type:'post',
            url: url + '/'+name+'/changeorders',
            data: {id : orderId, change: $(this).val() },
            success:function(data){
                $.fn.yiiGridView.update('data-grid');
                $('body').css('cursor', 'default');
            }
        });
    });
    
    $('.product-type').change(function(){
        var id = $(this).attr('id');
        id = id.split('-');
        id = id[id.length - 1];
        $.ajax({
            url : url + '/products/ishighlight',
            type : 'post',
            data: {id: id, highlight: $(this).val()},
            success: function(data){
                console.log(data);
                $('.message-show').html('Cập nhật thành công!').fadeIn().delay(1000).fadeOut(400);
            },
            error: function(){
                alert('Đã xảy ra lỗi, liên hệ với kỹ thuật để giải quyết!');
            }
        });
    })
});