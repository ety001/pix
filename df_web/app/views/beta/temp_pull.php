<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Pix</title>
    <link href="/public/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width,height=device-height,maximum-scale=1.0,user-scalable=no">
    <link href="/public/css/bootstrap-responsive.css" rel="stylesheet">
<style>
.screen{
transform:rotate(90deg);
-webkit-transform:rotate(90deg);
margin:0 auto;
}
</style>
</head>
<body style="background-color:#000;">
  <div class="screen" id="screen" style="display:block;width:452px;height:452px;">
    <img>
  </div>

  <script type="text/javascript" src="/public/js/json2.js"></script>
  <script type="text/javascript" src="/public/js/jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="/public/js/plat_canvas.js"></script>

  <script type="text/javascript">
  var now_id = 0;
  $(function(){
    var hhh = $(window).height();
    var ttt = (hhh - 452 )/2;
    $('.screen').css('margin-top',ttt+"px");
    setInterval(abc,2000);
  })
  function abc(){
    $.get('<?php echo _dfUrl("api","temp_pull");?>',function(res){
      if(res.status=='OK'){
        if(now_id!=res.data.id){
          $('img').attr('src',res.data.img);
          now_id = res.data.id;
        }
      }
    },'json');
  }
  </script>

  <?php if(ENVIRONMENT == 'production'):?>
    <div style="display:none;"><script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1253462527'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "v1.cnzz.com/stat.php%3Fid%3D1253462527' type='text/javascript'%3E%3C/script%3E"));</script></div>
  <?php endif;?>
</body>
</html>
