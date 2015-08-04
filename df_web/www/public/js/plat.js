var Plat = function(type, canvas_obj, px_width, px_horizontal_num, px_vertical_num){
    this._plat_width    = px_width * px_horizontal_num;
    this._plat_height   = px_width * px_vertical_num;
    this._canvasjqobj   = canvas_obj;
    this._canvasobj     = canvas_obj[0];
    this._ctx2d         = this._canvasobj.getContext('2d');       //2d画笔
    this._px_horizontal_num = px_horizontal_num;
    this._px_vertical_num = px_vertical_num;
    this._px_width      = px_width;

    this.mouse_current_pix_x    = 0;    //鼠标当前所在像素的x坐标
    this.mouse_current_pix_y    = 0;    //鼠标当前所在像素的y坐标

    this._base64info            = {}; //canvas的base64数据
    this._draw_color            = '';   //当前画笔颜色
    this._background_color      = '#000';   //背景色

    this._curt_frame_num        = 1;    //当前帧数
    this._curt_frame_delay      = 100;   //当前帧的显示时间
    this._curt_frame_info       = {};   //当前帧的图片信息
    this._animation_info        = {};   //动画信息

    this._type                  = type?type:1;    //1,pic; 2,animation
};

Plat.prototype.init = function(){
    var ctx             = this._ctx2d;
    var plat_width      = this._plat_width;
    var plat_height     = this._plat_height;

    this._curt_frame_info   = {};
    this._curt_frame_delay  = 100;

    //设置画布宽高
    this._canvasjqobj.attr('width',plat_width+'px');
    this._canvasjqobj.attr('height',plat_height+'px');
    ctx.beginPath();
    ctx.rect(0, 0, plat_width, plat_height);
    ctx.fillStyle = 'black';
    ctx.fill();
}

//设置画笔颜色
Plat.prototype.set_draw_color = function(color){
    this._draw_color = color;
}

//获取画笔颜色
Plat.prototype.get_draw_color = function(){
    return this._draw_color;
}

//设置背景色
Plat.prototype.set_background_color = function(color){
    this._background_color = color;
}

//获取背景色
Plat.prototype.get_background_color = function(){
    return this._background_color;
}

//去掉颜色码中的#
Plat.prototype.remove_special_char = function(color){
    if(color){
        return color.substr(1);
    }
}

//设置当前帧号
Plat.prototype.set_curt_frame_num = function(i){
    if(i>0){
        this._curt_frame_num = i;
    }
}

//获取当前帧号
Plat.prototype.get_curt_frame_num = function(){
    return this._curt_frame_num;
}

//设置当前帧的显示时间
Plat.prototype.set_frame_delay_time = function(delay_time){
    if(!delay_time)return;
    this._curt_frame_delay = parseInt(delay_time);
    this.update_frame();
}

//像素着色私有方法
Plat.prototype._draw_px_color = function(x,y,color){
    if(color==undefined)return;
    var px_width    = this._px_width;
    var start_x     = (x - 1) * px_width;
    var start_y     = (y - 1) * px_width;
    var width       = px_width;
    var height      = px_width;
    var ctx = this._ctx2d;      //画笔
    ctx.beginPath();
    ctx.rect(start_x, start_y, width, height);
    ctx.fillStyle = color;
    ctx.fill();
}

//给像素着色
Plat.prototype.draw_px_color = function(x,y,color,clear){
    if(!x||!y||x>this._px_horizontal_num||y>this._px_vertical_num)return;

    var current_draw_color;
    current_draw_color = color;
    
    //存储当前操作像素的颜色信息
    var i = this.xy2i(x, y);
    if(clear){
        delete this._curt_frame_info[i];
    } else {
        this._curt_frame_info[i] = current_draw_color;
    }
    //更新动画信息数组
    this.update_frame();
    //着色
    this._draw_px_color(x,y,current_draw_color);
}

//鼠标浮动在像素上时给像素着色
Plat.prototype.hover_px_color = function(x,y,color){
    if(!x||!y||x>this._px_horizontal_num||y>this._px_vertical_num)return;

    var current_draw_color;
    current_draw_color = color?color:this.get_draw_color();

    this._draw_px_color(x,y,current_draw_color);
}

//鼠标离开时像素着色
Plat.prototype.clear_px_color = function(x,y){
    if(!x||!y||x>this._px_horizontal_num||y>this._px_vertical_num)return;

    var i = this.xy2i(x, y);
    var current_draw_color = this._curt_frame_info[i]?this._curt_frame_info[i]:this.get_background_color();
    
    this._draw_px_color(x,y,current_draw_color);
}

//把数据库中的图形数据显示出来
Plat.prototype.show = function(pic_info){
    if(!pic_info)return;
    var coordinate;
    for(var i in pic_info){
        coordinate = this.i2xy(i);
        this.draw_px_color(coordinate.x, coordinate.y, pic_info[i]);
    }
}

//获取指定像素的颜色
Plat.prototype.get_px_color = function(x,y){
    var i = this.xy2i(x,y);
    return this._curt_frame_info[i]?this._curt_frame_info[i]:this._background_color;
}

//把点击的offset_x和offset_y转化为像素点的x坐标和y坐标
Plat.prototype.click2xy = function(offset_x, offset_y){
    var tmp_offset_x = offset_x - this._plat_border_width;
    var tmp_offset_y = offset_y - this._plat_border_width;

    var px_width = this._px_width;
    var offset_x_int = parseInt(offset_x/px_width);
    var offset_x_remainder = offset_x - offset_x_int*px_width;
    var offset_y_int = parseInt(offset_y/px_width);
    var offset_y_remainder = offset_y - offset_y_int*px_width;
    x = offset_x_int + 1;
    y = offset_y_int + 1;
    return {x:x, y:y};
}

//把点击的offset_x和offset_y转化为像素点的索引
Plat.prototype.click2i = function(offset_x, offset_y){
    var t = this.click2xy(offset_x, offset_y);
    return this.xy2i(t.x, t.y);
}

//填充全部的像素点
Plat.prototype.fill_all_px = function(color){
    var is_clear = color==this.get_background_color() ? true : false;
    for(var i=1;i<=this._px_horizontal_num;i++){
        for(var j=1;j<=this._px_vertical_num;j++){
            this.draw_px_color(i,j,color,is_clear);
        }
    }
}

//横纵坐标转换为序号
Plat.prototype.xy2i = function(x,y){
    if ( x > this._px_horizontal_num || y > this._px_vertical_num || x < 0 || y < 0)return false;
    return parseInt(this._px_horizontal_num*(y-1)+x);
}
//序号转换为横纵坐标
Plat.prototype.i2xy = function(i){
    if ( i < 0 || i > this._px_horizontal_num*this._px_vertical_num )return false;
    var y = Math.ceil(i / this._px_horizontal_num);
    var x = i - this._px_horizontal_num*(y-1);
    var obj = new Object();
    obj.x = x;
    obj.y = y;
    return obj;
}

//获得canvas的base64数据
Plat.prototype.get_data_url = function(){
    return this._canvasobj.toDataURL();
}

//把info数据转成base64格式的图片
Plat.prototype.get_image = function(info){
    if(!info){
        info = this._curt_frame_info;
    }
    var canvas_obj_tmp = $(document.createElement("canvas"));
    var plat_tmp = new Plat(1, canvas_obj_tmp, this._px_width, this._px_horizontal_num, this._px_vertical_num);
    plat_tmp.init();
    plat_tmp.show(info);
    this._base64info[this._curt_frame_num] = plat_tmp.get_data_url();
    return this._base64info[this._curt_frame_num];
}

//初始化动画
Plat.prototype.init_animation = function(info){
    if(!info)return;
    var count = utils.getJsonLength(info);
    for(var i in info){
        this._animation_info[i] = info[i];
        this._base64info[i] = this.get_image(this._animation_info[i]['info']);
    }
    return count;
}

//添加一帧
Plat.prototype.add_frame = function(){
    //保存当前帧信息到动画数组
    this.update_frame();
    //帧号加一
    this._curt_frame_num = this._curt_frame_num+1;
}

//更新当前帧的信息到动画数组
Plat.prototype.update_frame = function(){
    this._animation_info[this._curt_frame_num] = {'delay':this._curt_frame_delay,'info':$.extend({},this._curt_frame_info)};
}

//获取指定帧的信息
Plat.prototype.get_frame = function(frame_id){
    if(!frame_id)return;
    return this._animation_info[frame_id];
}

//删除最后一帧，frame_id 必须传最后一帧id，TODO：可以删除指定帧
Plat.prototype.rm_frame = function(frame_id){
    if(!frame_id)return;
    if(this._curt_frame_num==1)return;
    delete this._animation_info[frame_id];
    this._curt_frame_num = frame_id - 1;
    this._curt_frame_info = $.extend({},this._animation_info[this._curt_frame_num]);
    this._px_storage = $.extend({},this._curt_frame_info['info']);
}

//选中一帧并刷新canvas
Plat.prototype.select_frame = function(frame_id){
    if(frame_id<0)return;
    var info = this._animation_info[frame_id];
    //设置当前帧号
    this.set_curt_frame_num(frame_id);
    //设置当前帧时间
    this.set_frame_delay_time(info.delay);
    //清屏，并且清空_curt_frame_info
    this.fill_all_px(this._background_color);
    if(info!==undefined){
        //显示指定帧信息，并且赋值到_curt_frame_info
        this.show(info.info);
    } else {
        this._curt_frame_info = {};
    }
}

//save pic or animation to server
Plat.prototype.save_info = function(user_id,pic_name,callback){
    if ( !pic_name || !callback ){
        return false;
    }
    if ( this._type == 1 ){//pic
        var info = JSON.stringify( this._curt_frame_info );
        var base64info = this.get_image();
    } else if ( this._type == 2 ) {//animation
        var info = JSON.stringify( this._animation_info );
        var base64info = JSON.stringify( this._base64info );
    }
    var post_data = {type: this._type, user_id:user_id, name:pic_name, info:info, base64info:base64info};
    $.post('/api/add_info', post_data, callback, 'json');
}

//get pic or animation from server
Plat.prototype.get_one_info = function(info_id,callback){
    if ( !info_id ) return false;
    $.post('/api/get_one',{info_id:info_id},callback,'json');
}