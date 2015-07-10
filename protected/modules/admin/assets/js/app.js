$(document).ready(function(){
    /* Profile Main */
    var profileFirstClick = true;
    $('.user-action .nav-user').click(function(){
        if(profileFirstClick){
            $('.profiles').slideDown(400); 
            profileFirstClick = false;
        }else{
            $('.profiles').slideUp(400);
            profileFirstClick = true;
        }
    });
    
    $('.content').click(function(){
        if(profileFirstClick == false){
            profileFirstClick = true;
            $('.profiles').slideUp(400);
        }
        $('.colors').slideUp(400);
    });
    
    
    $('#gototop').click(function(){
        $('html, body').animate({scrollTop : 0},400);
        return false;
    });
    $('.btn-menu').click(function(){
        $('.left').slideToggle(500);
    });
    $(window).resize(function(){
        if($(window).width() > 760){
            $('.left').css('display','block');
        }else{
            $('.left').css('display','none');
        }
    })
    $("#User_i_shopping").change(function(){
        $("#storeselect").find("#User_i_store_id").remove();
        $("#storeselect").find("#btnAddStore").remove();
        var option = '';
        if(this.value == 1){
            $.ajax({
                type:'get',
                url: url + '/user/listStore/' , 
                success:function(data){
                    $("#storeselect").append(data);
                    option = '<option value="3">Store Admin</option></option>';
                    $("#User_i_user_role").html(option);
                },
            });  
        }else{
            option = '<option value="1"><option value="2">System Manager</option>';
            $("#User_i_user_role").html(option);
        }
    });
    $('.login-authorized').click(function(){
        var confirmDiv = '<div class="authorConfirm" id="authorConfirm"><div style="display:table-row;vertical-align: middle"><div style="display: table-cell;vertical-align: middle;"><div class="confirm-content"><img src="/posnail/images/loader.gif" ><h3>Dou you want to login as user of store ?</h3><div data-href="'+this.href+'" id="btnReturnOK">OK</div><div id="btnReturnCANCEL">CANCEL</div></div></div></div></div>';
        $('body').find('#authorConfirm').remove();
        $('body').append(confirmDiv);
        return false;
    });
    $('body').on('click','#btnReturnOK',function(){
        $('.confirm-content h3').remove();
        $('.confirm-content div').remove();
        $('.confirm-content img').css('z-index',100).css('display','inline-block')
        setTimeout(window.location = $(this).attr('data-href'),5000);
        return true;
    });
    $('body').on('click','#btnReturnCANCEL',function(){
        $('body').find('#authorConfirm').remove();
        return false;
        //return true;
    });
    $('#form-popup-add-user').submit(function(){
        $.ajax({
           type:'post',
           url: $(this).attr('action'),
           data:$(this).serialize(),
           beforeSend:function(){
                $('#form-popup-user .loadding').css('display','block').css('z-index','1004');
           },
           success:function(data){
                $('#form-popup-user .loadding').css('display','none').css('z-index','-1');
                var objResult = JSON.parse(data);
                if(objResult.username != "undefined"){
                    $('#messUsername').text(objResult.username);
                }
                if(objResult.email != "undefined"){
                    $('#messEmail').text(objResult.email);
                }
                console.log(objResult.option);
                if(objResult.message != "undefined" && objResult.option != "undefined"){
                    $("#User_s_id").find('option').removeAttr('selected');
                    $('#form-popup-user').prepend(objResult.message);
                    $("#User_s_id").append(objResult.option);
                    $("#User_s_id").trigger("chosen:updated");
                }
           },
        });
       return false; 
    });
    
    $('#form-popup-add-type-service').submit(function(){
        $.ajax({
           type:'post',
           url: $(this).attr('action'),
           data:$(this).serialize(),
           beforeSend:function(){
                $('#form-popup-serice-type .loadding').css('display','block').css('z-index','1004');
           },
           success:function(data){
                $('#form-popup-serice-type .loadding').css('display','none').css('z-index','-1');
                var objResult = JSON.parse(data);
                if(objResult.message != "undefined" && objResult.option != "undefined"){
                    $("#Service_s_service_type_id").find('option').removeAttr('selected');
                    $('#form-popup-serice-type').prepend(objResult.message);
                    $("#Service_s_service_type_id").append(objResult.option);
                    $("#Service_s_service_type_id").trigger("chosen:updated");
                }
           },
        });
       return false; 
    });
    /**
    /* Change color 
    var bgColor = '#57B484';
    var borderColor = '#67BD90';
    var activeColor = '#39865E';
    $('#picker').farbtastic(function(color){
        bgColor = color;
        $('.left, .left ul li a, .home-item a, .bnt-form, .message-show, .filter-external input[type="button"]').css({'background':bgColor});
        $('.header, .profiles').css({'border-bottom':'2px solid '+bgColor});
        $('.footer').css({'border-top':'2px solid '+bgColor});
        $('.action a i, .head i, .filter-external a.download').css({'color':bgColor});
        $('.table table thead tr').css({'border-bottom':'1px solid '+bgColor});
        $('.pagination ul li.active a').css({'background':bgColor, 'border':'1px solid '+bgColor});
        $('.left ul li.active a').css({'background':activeColor});
        $('.left ul li a,  .home-item a').hover(function(){
            $(this).css({'background':activeColor});
        }, function(){
            if(!$(this).parent().hasClass('active')){
                $(this).css({'background':bgColor});
            }
        });
        setCookie('bgColor', bgColor, 1000);
    });
    $('#picker-2').farbtastic(function(color){
        borderColor = color;
        $('.left ul li').css({'border-bottom':'1px solid '+borderColor});
        setCookie('borderColor', borderColor, 1000);   
    });
    $('#picker-3').farbtastic(function(color){
        activeColor = color;
        $('.left ul li.active a').css({'background':activeColor});
        $('.left ul li a,  .home-item a').hover(function(){
            $(this).css({'background':activeColor});
        }, function(){
            if(!$(this).parent().hasClass('active')){
                $(this).css({'background':bgColor});
            }
        });
        setCookie('activeColor', activeColor, 1000);   
    }); 
    $('#show-colors').click(function(){
        $('.colors').slideDown(400);
        $('.profiles').slideUp(400);
        return false; 
    });
    */
});

function checkCode(value,_imc,_t){
    _imc = _imc||'messCode';
    _t = _t||'';
    var arr = value.split('|');
    if(arr[2] === arr[0]){
        $('#messCode').html('<span class="fa" style="color:#1AD20D; font-size:18px" title="Mã không thay d?i">&#xf00c; </span><span style="color:blue">Mã không thay d?i</span>');
    }else{
        $.ajax({
            type:'post',
            data:{
                code:   arr[0],
                typeData:_t,
            },
            url: url + '/' + arr[1] + '/checkCode/' , 
            success:function(data){
                var arrData = data.split('|');
                $('#'+_imc).html(arrData[0]);
            },
        });    
    }   
}
function setCookie(c_name,value,exdays)
{
    var exdate=new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString()) + "; path=/";
    document.cookie=c_name + "=" + c_value;
}
function getCookie(c_name)
{
    var c_value = document.cookie;
    var c_start = c_value.indexOf(" " + c_name + "=");
    if (c_start == -1)
    {
        c_start = c_value.indexOf(c_name + "=");
    }
    if (c_start == -1)
    {
        c_value = null;
    }
    else
    {
        c_start = c_value.indexOf("=", c_start) + 1;
        var c_end = c_value.indexOf(";", c_start);
        if (c_end == -1)
        {
            c_end = c_value.length;
        }
        c_value = unescape(c_value.substring(c_start,c_end));
    }
    return c_value;
}