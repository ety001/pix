$(function(){
    var ctrl_press = 0;
    var pipe = 0;
    var playpause = 0;
    var tmp_curt_frame_no;
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
    var plat = new Plat(2, plat_obj, 28, 16, 16);
    plat.init();
    //初始化画笔颜色
    plat.set_draw_color('#ff2600');

    //鼠标操作
    plat_obj.mouseover(function(e){
        if(playpause==1)return;
        //非选中像素边框颜色恢复
        plat.clear_px_color(plat.mouse_current_pix_x, plat.mouse_current_pix_y);
    });
    plat_obj.mousemove(function(e){
        if(playpause==1)return;
        if(pipe==1)return;
        if(ctrl_press==1){
            var pix_xy = plat.click2xy(e.offsetX, e.offsetY);
            plat.draw_px_color(pix_xy.x, pix_xy.y, plat.get_draw_color());
            //存储临时颜色
            set_temp_color(plat.get_draw_color());
            //更新时间轴上的缩略图
            $('.active').find('img').attr('src', plat.get_image() );
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
        if(playpause==1)return;
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
        if(playpause==1)return;

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
            //更新时间轴上的缩略图
            $('.active').find('img').attr('src', plat.get_image() );
        }
    });

    //颜色选择
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
            if(playpause==1)return;
            plat.fill_all_px( plat.get_background_color() );
            //更新时间轴上的缩略图
            $('.active').find('img').attr('src', plat.get_image() );
        },
        fillall: function(){
            if(playpause==1)return;
            plat.fill_all_px( plat.get_draw_color() );
            //更新时间轴上的缩略图
            $('.active').find('img').attr('src', plat.get_image() );
        },
        pipette: function(){
            if(playpause==1)return;
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

    //init func
    var init_animation_func = function(info){

        var last_frame_id = plat.init_animation(info);        
        //get first frame
        var init_frame_obj = $('.frame');
        //init first frame
        init_frame_obj.find('img').attr( 'src', plat.get_image( plat.get_frame(1).info ) );
        init_frame_obj.find("select option[value='"+plat.get_frame(1).delay+"']").attr('selected',true);
        init_frame_obj.removeClass('active').remove();
        //init frames from the second frame
        for(var i in info){
            var new_obj = init_frame_obj.clone(true);
            new_obj.find('[frame-id]').attr('frame-id',i);
            new_obj.attr('frame-id', i);
            new_obj.find('span').html(i);
            new_obj.find('img').attr( 'src', plat.get_image( plat.get_frame(i).info ) );
            new_obj.find("select option[value='"+plat.get_frame(i).delay+"']").attr('selected',true);
            //添加克隆出来的一帧到最后一帧的位置
            $('.scroll-wrap').append(new_obj);
        }
        //重新计算宽度
        $('.animations .scroll-wrap').width($('.scroll-wrap').children().length*112);
        $('.animations').jScrollPane({autoReinitialise: true});
        //select the last frame
        plat.select_frame(last_frame_id);
        $('.frame:last').addClass('active');
        $('.animations').data('jsp').scrollToX($('.scroll-wrap').children().length*112);
    }

    if(info !== undefined){
        init_animation_func(info);
    } else {
        $('img[frame-id=1]').attr('src',plat.get_image());
    }

    //临时颜色记忆
    var tmp_color_length = tmp_color.length;
    if(tmp_color_length>0){
        var tmp_color_j = 0;
        for(var tmp_color_i = tmp_color_length-1;tmp_color_i>=0;tmp_color_j++,tmp_color_i--){
            $($('.tmp_color')[tmp_color_j]).css('background-color',tmp_color[tmp_color_i]);
        }
    }
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


    //animation start
    var frame_click = function(){
        if(playpause==1)return;
        $('.frame').each(function(){
            $(this).removeClass('active');
        });
        $(this).addClass('active');
        var frame_id = parseInt( $(this).attr('frame-id') );
        plat.select_frame(frame_id);
    }
    //select frame
    $('.frame').click(frame_click);

    //add frame
    $('#add_frame').click(function(){
        if(playpause==1)return;
        //获取最后一帧
        var obj = $('.scroll-wrap').find('.frame:last');
        //克隆最后一帧
        var new_obj = obj.clone(true);
        //修改克隆出来的帧的相关的参数
        var new_frame_id = parseInt( new_obj.attr('frame-id') ) + 1;
        new_obj.find('[frame-id]').attr('frame-id',new_frame_id);
        new_obj.attr('frame-id', new_frame_id);
        new_obj.find('span').html(new_frame_id);
        $('.scroll-wrap').find('.frame').removeClass('active');
        new_obj.addClass('active');
        plat.add_frame();
        plat.set_frame_delay_time(10);//新添加的帧默认10毫秒

        //添加克隆出来的一帧到最后一帧的位置
        $('.scroll-wrap').append(new_obj);
        //重新计算宽度
        $('.animations .scroll-wrap').width($('.scroll-wrap').children().length*112);
        $('.animations').data('jsp').destroy();
        $('.animations').jScrollPane({autoReinitialise: true});
        $('.animations').data('jsp').scrollToX($('.scroll-wrap').children().length*112);
    });

    //remove frame
    $('#rm_frame').click(function(){
        if(playpause==1)return;
        //删除最后一帧
        var rm_frame_obj = $('.scroll-wrap').find('.frame:last');
        var frame_id = parseInt( rm_frame_obj.attr('frame-id') );
        if(frame_id==1)return;
        rm_frame_obj.remove();
        plat.rm_frame(frame_id);
        //获取最后一帧
        var obj = $('.scroll-wrap').find('.frame:last');
        obj.addClass('active');
    });

    //scroller
    $('.animations').jScrollPane({autoReinitialise: true});
    $('.animations .scroll-wrap').width($('.scroll-wrap').children().length*112);

    //delay time selector
    $('.input-block-level').change(function(){
        var frame_id = parseInt( $(this).attr('frame-id') );
        var delay_time = $(this).children('option:selected').val();
        plat.select_frame(frame_id);
        plat.set_frame_delay_time(delay_time);
    });

    //play and pause
    $('#playpause').click(function(){
        if(plat.get_frame(1) == undefined)return;
        var text_attr = $(this).attr('text');
        var text_html = $(this).html();
        if(playpause==0){
            //start
            $(this).removeClass('btn-success').addClass('btn-danger').attr('text',text_html).html(text_attr);
            tmp_curt_frame_no = plat.get_curt_frame_num();
            playpause = 1;
            frame_action(1);
        } else {
            //stop
            $(this).removeClass('btn-danger').addClass('btn-success').attr('text',text_html).html(text_attr);
            playpause = 0;
        }
    });

    var frame_action = function(curt_frame_no){
        if(playpause==0){
            $('.animation_active').removeClass('animation_active');
            plat.select_frame(tmp_curt_frame_no);
            return;
        }
        if(curt_frame_no>utils.getJsonLength(plat._animation_info) ) {
            curt_frame_no=1;
        }
        setTimeout(function(){
            $('.frame').removeClass('animation_active');
            $('.frame[frame-id='+curt_frame_no+']').addClass('animation_active');
            plat.select_frame(curt_frame_no);
            frame_action(curt_frame_no+1);
        },plat.get_frame(curt_frame_no).delay);
    }

    //保存pic
    $('#submit_pic').click(function(){
        if(playpause==1)return;
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


