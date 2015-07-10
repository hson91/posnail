$(document).ready(function(){
    $('.tbuser').append('<div class="details"></div>');
    $('.detail').click(function(){
        var currentID = $(this).attr('id');
        $.ajax({
            type:'get',
            url:$(this).attr('href')+'?ajax=1',
            success:function(data){
                var width = $('table.items').width();
                var top = $('#'+currentID).offset().top + 23;
                var top2 = $('#'+currentID).position().top + 23;
                $('.details').css({'top':top2 + 'px'}).html(data).fadeIn(400);
                $('.details').prepend('<a id="close">&#xf070;</a>');
                $('.right').height($('.details').height() + top);
                $('#close').click(function(){
                    $('.details').fadeOut(400);
                    $('.right').css('height', 'auto');
                });
            }
        });
        return false;
    });
});