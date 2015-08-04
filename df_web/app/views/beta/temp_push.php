<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Pix</title>
    <link href="/public/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/public/css/bootstrap-responsive.css" rel="stylesheet">
</head>
<body>

  <div class="container">
    <ul class="thumbnails">
      <?php foreach($all as $k=>$v):?>
      <li style="width:90px;float:left;">
        <a href="#pixShow" class="thumbnail t_a" title="<?php echo $v['name'];?>" data-toggle="modal">
          <?php if($v['type']==2):?>
            <img class="gif_show" data-id="<?php echo $v['id'];?>" src="<?php echo _createGIFPath($v['thumb_name']);?>" alt="<?php echo $v['name'];?>">
          <?php endif;?>
          <?php if($v['type']==1):?>
            <img class="pic_show" data-id="<?php echo $v['id'];?>" src="<?php echo _createPNGPath($v['thumb_name']);?>" alt="<?php echo $v['name'];?>">
          <?php endif;?>
        </a>
      </li>
      <?php endforeach;?>
    </ul>
    
    <ul class="pager">
      <?php 
      if($page!=1):
        $prev_page = $page - 1;
      ?>
        <li><a href="<?php echo site_url('/pix/temp/'.$prev_page );?>">&laquo;&nbsp;Prev</a></li>
      <?php endif;?>
      <?php 
      if($page!=$last_page):
        $next_page = $page + 1;
      ?>
        <li><a href="<?php echo site_url('/pix/temp/'.$next_page );?>">Next&nbsp;&raquo;</a></li>
      <?php endif;?>
    </ul>
  </div>

  <script type="text/javascript" src="/public/js/json2.js"></script>
  <script type="text/javascript" src="/public/js/jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="/public/js/plat_canvas.js"></script>

  <script type="text/javascript">
  $(function(){
    $('img').click(function(){
      var id = $(this).attr('data-id');
      $.get('<?php echo _dfUrl("api","temp_push");?>/'+id,function(res){
        console.log(res);
      });
      alert('push success');
    });
  })
  </script>

  <?php if(ENVIRONMENT == 'production'):?>
    <div style="display:none;"><script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1253462527'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "v1.cnzz.com/stat.php%3Fid%3D1253462527' type='text/javascript'%3E%3C/script%3E"));</script></div>
  <?php endif;?>
</body>
</html>