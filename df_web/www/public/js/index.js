
var plat_obj = $('#plat');
var all_pic_lists = ["1","23","32"];
var i = 0;
var plat = new Plat_Canvas(plat_obj, 4, 24, 16);
plat.init();

show();
setInterval('show()',3000);

function show(){
    plat.get_one_info( all_pic_lists[i] , function(res){
        if ( res.status === 'OK'){
            var info = res.data.info;
            var info = eval('('+info+')');
            plat.init();//clear
            plat.show(info);//draw pic
            if(i>=all_pic_lists.length-1){
                i = 0;
            } else {
                i++;
            }
        }
    });
}