<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $info['name'];?> -- Pix, <?php echo $lang->line('beta_share_text');?></title>
    <link href="/public/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/public/css/bootstrap-responsive.css" rel="stylesheet">
</head>
<body>

  <?php if($is_iframe!==1):?>
  <div class="container" style="max-width: 530px;">
    <div class="masthead">
      <ul class="nav nav-pills pull-right">
        <li <?php echo ($page_tag=='index')?'class="active"':'';?> ><a href="<?php echo _dfUrl();?>"><?php echo $lang->line('beta_share_nav');?></a></li>
        <li <?php echo ($page_tag=='createworld')?'class="active"':'';?> ><a href="<?php echo _dfUrl('pix','createWorld');?>"><?php echo $lang->line('beta_create_nav');?></a></li>
        <li <?php echo ($page_tag=='advice')?'class="active"':'';?> ><a href="<?php echo _dfUrl('pix','advice');?>"><?php echo $lang->line('beta_advice_nav');?></a></li>
      </ul>
      <h3 class="muted">Pix</h3>
    </div>
    <hr>
  </div>
  <?php endif;?>

  <div class="container" style="max-width: 530px;">
    <?php if($info['type']==2):?>
    <img style="width:300px;height:300px;" src="<?php echo _createGIFPath($info['thumb_name']);?>">
    <?php endif;?>
    <?php if($info['type']==1):?>
    <img style="width:300px;height:300px;" src="<?php echo _createPNGPath($info['thumb_name']);?>">
    <?php endif;?>
  </div>

  <?php if($lang_type==1):?>
  <div class="container" style="max-width: 530px;">
    <div style="margin:10px 0;">
      <a class="bshareDiv" href="http://www.bshare.cn/share">分享按钮</a><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#uuid=7a163fd0-5019-4713-8a94-32e169a70221&style=2&textcolor=#000000&bgcolor=none&bp=sinaminiblog,qzone,douban,weixin,renren,qqim&text=分享"></script>
      <script type="text/javascript">
        bShare.addEntry({
            title: "<?php echo $info['name'];?>",
            url: "<?php echo ( _dfUrl('pix','genius',array('id='.$info['id'])) );?>",
            summary: "<?php echo $lang->line('beta_share_text');?>",
            pic: "<?php echo base_url( _createPNGPath($info['thumb_name']) );?>"
        });
      </script>
    </div>
    <div>
      <div id="disqus_thread"></div>
      <script>
      var disqus_config = function () {
        this.page.url = '<?php echo ( _dfUrl('pix','genius',array('id='.$info['id'])) );?>';
        this.page.identifier = '<?php echo $info['id'];?>';
      };
      (function() { // DON'T EDIT BELOW THIS LINE
      var d = document, s = d.createElement('script');
      s.src = 'https://pixpix.disqus.com/embed.js';
      s.setAttribute('data-timestamp', +new Date());
      (d.head || d.body).appendChild(s);
      })();
      </script>
      <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    </div>
  </div>
  <?php endif;?>

  <?php if($lang_type==2):?>
  <div class="container" style="max-width: 530px;">
    <div style="margin:10px 0;">
      <a class="bshareDiv" href="http://www.bshare.cn/share">分享按钮</a><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#uuid=7a163fd0-5019-4713-8a94-32e169a70221&style=2&textcolor=#000000&bgcolor=none&bp=twitter,facebook,reddit,delicious,myspace,tumblr&text=分享"></script>
      <script type="text/javascript">
        bShare.addEntry({
            title: "<?php echo $info['name'];?>",
            url: "<?php echo ( _dfUrl('pix','genius',array('id='.$info['id'])) );?>",
            summary: "<?php echo $lang->line('beta_share_text');?>",
            pic: "<?php echo base_url( _createPNGPath($info['thumb_name']) );?>"
        });
      </script>
    </div>
    <div id="disqus_thread"></div>
    <script type="text/javascript">
        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
        var disqus_shortname = 'pixpix'; // required: replace example with your forum shortname

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
  </div>
  <?php endif;?>

  <script type="text/javascript" src="/public/js/json2.js"></script>
  <script type="text/javascript" src="/public/js/jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="/public/js/plat_canvas.js"></script>
  <?php if(ENVIRONMENT == 'production'):?>
    <div style="display:none;"><script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1253462527'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "v1.cnzz.com/stat.php%3Fid%3D1253462527' type='text/javascript'%3E%3C/script%3E"));</script></div>
  <?php endif;?>
</body>
</html>
