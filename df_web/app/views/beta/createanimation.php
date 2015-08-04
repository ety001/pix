    <div class="container">
      <ul class="nav nav-pills">
        <li <?php echo ($page_tag=='createworld')?'class="active"':'';?> ><a href="<?php echo _dfUrl('pix','createWorld');?>"><?php echo $data['lang']->line('beta_create_pic');?></a></li>
        <li <?php echo ($page_tag=='createanimation')?'class="active"':'';?> ><a href="<?php echo _dfUrl('pix','createAnimation');?>"><?php echo $data['lang']->line('beta_create_animation');?></a></li>
      </ul>
    </div>

    <div class="container">
      <div class="row">
        <div class="span6">
          <canvas id="plat" data-toggle="popover" data-placement="top" data-content="<?php echo $data['lang']->line('beta_canvas_tip');?>"></canvas>
        </div>
        <div id="picker_dom" class="span5"></div>
        <div class="span5"> 
          <div>
            <div class="tmp_color pull-left"></div>
            <div class="tmp_color pull-left"></div>
            <div class="tmp_color pull-left"></div>
            <div class="tmp_color pull-left"></div>
            <div class="tmp_color pull-left"></div>
            <div class="tmp_color pull-left"></div>
            <div class="tmp_color pull-left"></div>
            <div class="tmp_color pull-left"></div>
            <div class="tmp_color pull-left"></div>
            <div class="tmp_color pull-left"></div>
            <div class="tmp_color pull-left"></div>
            <div class="tmp_color pull-left"></div>
            <div class="tmp_color pull-left"></div>
            <div class="tmp_color pull-left"></div>
            <div class="tmp_color pull-left"></div>
            <div class="tmp_color pull-left"></div>
          </div>         
          <div class="form-inline">
            <label class="input"><?php echo $data['lang']->line('beta_pic_name');?></label>
            <input type="text" class="input-large" id="pic_name">
            <button type="submit" id="submit_pic" class="btn"><?php echo $data['lang']->line('beta_save_btn');?></button>
          </div>
          <p><div id="msg"></div></p>
          <button id="add_frame" class="btn btn-info"><?php echo $data['lang']->line('beta_add_frame');?></button>
          <button id="rm_frame" class="btn btn-info"><?php echo $data['lang']->line('beta_remove_frame');?></button>
          <button id="playpause" class="btn btn-success" text="<?php echo $data['lang']->line('beta_stop');?>"><?php echo $data['lang']->line('beta_start');?></button>
        </div>
      </div>
    </div>

    <div class="container">

      <div class="animations">
        <div class="scroll-wrap clearfix">
          <div class="frame text-center active" frame-id="1">
            <select class="input-block-level" frame-id="1">
              <option value="10">10ms</option>
              <option value="20">20ms</option>
              <option value="50">50ms</option>
              <option value="100" selected="true">100ms</option>
              <option value="200">200ms</option>
              <option value="500">500ms</option>
              <option value="1000">1000ms</option>
              <option value="2000">2000ms</option>
            </select>
            <div class="thumbnail">
              <img src="" frame-id="1">
            </div>
            <span>1</span>
          </div>
        </div>
      </div>
    </div>

    <script type="text/javascript">
      var info;
      <?php if($data['info']):?>
      info = <?php echo $data["info"]["info"];?>;
      <?php endif;?>
    </script>