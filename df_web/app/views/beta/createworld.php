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
        </div>
      </div>
    </div>

    <script type="text/javascript">
      var info;
      <?php if($data['info']):?>
      info = <?php echo $data["info"]["info"];?>;
      <?php endif;?>
    </script>