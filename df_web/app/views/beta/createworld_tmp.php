    <div class="container">
      <div class="row">
        <div class="span6">
          <canvas id="plat" data-toggle="popover" data-placement="top" data-content="<?php echo $data['lang']->line('beta_canvas_tip');?>"></canvas>
        </div>
        <div id="picker_dom" class="span5"></div>
        <div class="span5">          
          <div class="form-inline">
            <label class="input"><?php echo $data['lang']->line('beta_pic_name');?></label>
            <input type="text" class="input-large" id="pic_name">
            <button type="submit" id="submit_pic" class="btn"><?php echo $data['lang']->line('beta_save_btn');?></button>
            <button onclick="jump();">JUMP</button>
          </div>
          <p><div id="msg"></div></p>
        </div>
      </div>
    </div>

    <script type="text/javascript">
      var info;
      <?php if($data['info']):?>
      info = <?php echo $data["info"]["info"];?>;
      var idid = <?php echo $data['info']['id'];?>;
      <?php endif;?>
    </script>