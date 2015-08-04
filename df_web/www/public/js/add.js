$(function(){
    var ctrl_press = 0;
    var pipe = 0;
    var tmp_color = window.localStorage.tmp_color?window.localStorage.tmp_color.split(','):[];

    $(document).keydown(function(e){ 
        if(e.keyCode==17){
            ctrl_press = 1;
        }
    });
    $(document).keyup(function(e){
        if(e.keyCode==17){
            ctrl_press = 0;
        }
    });

    var plat_obj = $('#plat');
    //初始化显示板
    var plat = new Plat(1, plat_obj, 28, 16, 16);
    plat.init();
    //初始化画笔颜色
    plat.set_draw_color('#ff2600');

    //鼠标操作
    plat_obj.mouseover(function(e){
        //非选中像素边框颜色恢复
        plat.clear_px_color(plat.mouse_current_pix_x, plat.mouse_current_pix_y);
    });
    plat_obj.mousemove(function(e){
        if(pipe==1)return;
        if(ctrl_press==1){
            var pix_xy = plat.click2xy(e.offsetX, e.offsetY);
            plat.draw_px_color(pix_xy.x, pix_xy.y, plat.get_draw_color());
            //存储临时颜色
            set_temp_color(plat.get_draw_color());
            return;
        }
        //获取当前画笔颜色
        var current_draw_color = plat.get_draw_color();
        //获取背景色
        var bg_color = plat.get_background_color();
        //获取当前鼠标相对画布原点的坐标
        var pix_xy = plat.click2xy(e.offsetX, e.offsetY);
        //把鼠标当前位置的像素描边，去掉之前元素的描边
        if(pix_xy.x != plat.mouse_current_pix_x || pix_xy.y != plat.mouse_current_pix_y){
            //非选中像素边框颜色恢复
            plat.clear_px_color(plat.mouse_current_pix_x, plat.mouse_current_pix_y);
            //选中像素显示当前画笔颜色
            plat.hover_px_color(pix_xy.x, pix_xy.y, current_draw_color);
            //赋新的当前鼠标坐标值
            plat.mouse_current_pix_x = pix_xy.x;
            plat.mouse_current_pix_y = pix_xy.y;
        }
    });
    plat_obj.mouseout(function(e){
        var bg_color = plat.get_background_color();
        //非选中像素边框颜色恢复
        plat.clear_px_color(plat.mouse_current_pix_x, plat.mouse_current_pix_y);
        //鼠标移出画布，清空记录鼠标指向像素的坐标值
        plat.mouse_current_pix_x = 0;
        plat.mouse_current_pix_y = 0;
    });
    plat_obj.mousedown(function(){
        ctrl_press = 1;
    });
    plat_obj.mouseup(function(){
        ctrl_press = 0;
    });


    //点击操作
    plat_obj.click(function(e){
        plat_obj.popover('show');

        var pix_xy = plat.click2xy(e.offsetX, e.offsetY);
        if(pipe==1){
            var pipe_color = plat.remove_special_char( plat.get_px_color(pix_xy.x, pix_xy.y) );
            picker.update( pipe_color );
            pipe = 0;
            var temp_obj = document.getElementsByClassName('hexPipeBtnOn');
            temp_obj[0].className = "hexBtnDiv pull-left hexPipeBtn";
            plat_obj.removeClass('hexPipeHover');
        } else {
            plat.draw_px_color(pix_xy.x, pix_xy.y, plat.get_draw_color());
            //存储临时颜色
            set_temp_color(plat.get_draw_color());
        }
    });

    //颜色选择
    var tmp_color_length = tmp_color.length;
    if(tmp_color_length>0){
        var tmp_color_j = 0;
        for(var tmp_color_i = tmp_color_length-1;tmp_color_i>=0;tmp_color_j++,tmp_color_i--){
            $($('.tmp_color')[tmp_color_j]).css('background-color',tmp_color[tmp_color_i]);
        }
    }
    var picker_dom = $('#picker_dom');
    var picker = new Color.Picker({
        color: '#ff2600',
        container: picker_dom[0],
        display: true,
        size: 280,
        callback: function(rgba,state,type){
            var temp_color = Color.Space(rgba, "RGBA>HEX32>STRING").substr(2);
            temp_color = '#' + temp_color;
            plat.set_draw_color( temp_color );
        },
        clearall: function(){
            plat.init();
        },
        fillall: function(){
            plat.fill_all_px( plat.get_draw_color() );
        },
        pipette: function(){
            if(pipe==1){
                pipe = 0;
                this.className = "hexBtnDiv pull-left hexPipeBtn";
                plat_obj.removeClass('hexPipeHover');
            } else {
                pipe = 1;
                this.className = "hexBtnDiv pull-left hexPipeBtnOn";
                plat_obj.addClass('hexPipeHover');
            }
        }
    });

    if(info !== undefined){
        plat.show(info);
    }

    //临时颜色记忆

    var set_temp_color = function(color){
        if($.inArray(color,tmp_color)!==-1)return;
        var obj = $('.tmp_color:first');
        var new_obj = obj.clone(true);
        new_obj.css('background-color',color);
        obj.before(new_obj);
        $('.tmp_color:last').remove();
        tmp_color.push(color);
        if(tmp_color.length>16){
            tmp_color.shift();
        }
        window.localStorage.tmp_color = tmp_color.join(',');
    }
    var get_temp_color = function(){
        var color = $(this).getHexBackgroundColor()?$(this).getHexBackgroundColor():plat.get_background_color();
        plat.set_draw_color( color );
        var picker_color = plat.remove_special_char(color);
        picker.update( picker_color );
    }
    $('.tmp_color').click(get_temp_color);


    //保存pic
    $('#submit_pic').click(function(){
        var pic_name = $('#pic_name').val();
        var user_id = 0;
        if (!pic_name){
            $('#msg').html('名称不能为空').show();
            setTimeout("$('#msg').hide();",2000);
            return false;
        }
        var status = plat.save_info(user_id, pic_name, function(res){
            if(res.status === 'OK'){
                alert('保存成功');
                window.location="/";
            } else {
                $('#msg').html('保存失败').show();
            }
            setTimeout("$('#msg').hide();",2000);
        });
    });

});