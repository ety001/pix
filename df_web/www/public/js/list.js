$(function(){
    var plat_obj = $('#plat');
    var all_pic_lists;
    var plat = new Plat_Canvas(plat_obj, 2, 12, 16);
    plat.init();
    
    $('#all').change(function(){
        var i = $(this).find('option:selected').val();
        plat.get_one_info(i,function(res){
            if ( res.status === 'OK'){
                plat.fill_all_px(plat._background_color);//clear
                var pic_info = res.data.info;
                var pic_info_json = eval('('+pic_info+')');
                plat.show(pic_info_json);//draw pic
                console.log(plat.get_image());
            }
        });
    });
});