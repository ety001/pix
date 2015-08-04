
var plat_obj1 = $('<canvas></canvas>');
//初始化显示板
var plat = new Plat_Canvas(plat_obj1, 4, 24, 16);
plat.init();

var length = r.length;
var ii = 1;

function clk(){
    if(ii<length){
        yu(r[ii]);
        ii++;
    }
}

function yu(id){
    $.post('/api/get_one',{info_id:id},function(res){
        if ( res.status === 'OK'){
            plat.fill_all_px(plat._background_color);//clear
            var pic_info = res.data.info;
            var pic_info_json = eval('('+pic_info+')');
            plat.show(pic_info_json);//draw pic
            $('#k_id').val(id);
            $('#k_img').attr('src',plat.get_image());
            updt();
        }
    },'json');
}

function updt(){
    var k_id = $('#k_id').val();
    var k_base64 = $('#k_img').attr('src');
    $.post('/api/test', {k_id:k_id, k_base64:k_base64}, function(res){
        console.log(res);
        clk();
    });
}