    <div class="container">
      <ul class="thumbnails">
        <?php foreach($data['all'] as $k=>$v):?>
        <li class="span1 text-center" style="overflow:hidden;">
          <a href="#" class="thumbnail">
            <img src="<?php echo $v['base64info'];?>" alt="<?php echo $v['name'];?>">
          </a>
          <p><?php echo $v['name'];?></p>
        </li>
        <?php endforeach;?>
      </ul>
    </div>