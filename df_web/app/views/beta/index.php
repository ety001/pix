    <div class="container">
      <ul class="thumbnails">
        <?php foreach($data['all'] as $k=>$v):?>
        <li class="span2">
          <a href="#pixShow" onclick="pixshow('<?php echo $v['id'];?>', '<?php echo $v["type"];?>', '<?php echo _dfUrl("pix","genius",array("id=".$v["id"] , "iframe=1" ));?>','<?php echo $v['name'];?>')" class="thumbnail t_a" title="<?php echo $v['name'];?>" data-toggle="modal">
            <?php if($v['type']==2):?>
            <i class="icon-white icon-play"></i>
            <img class="gif_show" style="display:none;" src="<?php echo _createGIFPath($v['thumb_name']);?>" alt="<?php echo $v['name'];?>">
            <?php endif;?>
            <img class="pic_show" src="<?php echo _createPNGPath($v['thumb_name']);?>" alt="<?php echo $v['name'];?>">
          </a>
        </li>
        <?php endforeach;?>
      </ul>
      
      <ul class="pager">
        <?php 
        if($data['page']!=1):
          $prev_page = $data['page'] - 1;
        ?>
          <li><a href="<?php echo site_url('/pix/index/'.$prev_page );?>">&laquo;&nbsp;<?php echo $data['lang']->line('beta_prev_page');?></a></li>
        <?php endif;?>
        <?php 
        if($data['page']!=$data['last_page']):
          $next_page = $data['page'] + 1;
        ?>
          <li><a href="<?php echo site_url('/pix/index/'.$next_page );?>"><?php echo $data['lang']->line('beta_next_page');?>&nbsp;&raquo;</a></li>
        <?php endif;?>
      </ul>
    </div>

    <div id="pixShow" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="pixShowLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="pixShowLabel" style="display:inline-block;"></h3><button id="edit_btn" class="btn btn-mini btn-info" style="margin-left:20px;" onclick="edit();"><?php echo $data['lang']->line('beta_edit_btn');?></button>
      </div>
      <div class="modal-body" style="max-height:550px;-webkit-overflow-scrolling: touch;overflow:auto;">
        <iframe style="height:540px;width:530px;" frameborder="no" border="0" marginwidth="0" marginheight="0" id="iframe"></iframe>
      </div>
    </div>
