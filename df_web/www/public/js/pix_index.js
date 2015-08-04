function pixshow(id, info_type, url, name){
    $('#iframe').attr('src',url);
    $('#pixShowLabel').html(name);
    $('#edit_btn').attr('pix_id',id);
    $('#edit_btn').attr('info_type', info_type);
}

function edit(){
    var id = $('#edit_btn').attr('pix_id');
    var info_type = $('#edit_btn').attr('info_type');
    if(info_type==1){
        location.href = '/pix/createWorld?id='+id;
    } else {
        location.href = '/pix/createAnimation?id='+id;
    }
    
}

$(function(){
    $('.t_a').mouseover(function(){
        if( $(this).children('i')[0] !== undefined ){
            $(this).find('.gif_show').show();
            $(this).find('.pic_show').hide();
            $(this).find('i').hide();
        }
    });
    $('.t_a').mouseout(function(){
        if( $(this).children('i')[0] !== undefined ){
            $(this).find('.gif_show').hide();
            $(this).find('.pic_show').show();
            $(this).find('i').show();
        }
    });
});