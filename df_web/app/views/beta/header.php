<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Pix</title>
    <link rel="stylesheet" type="text/css" href="/public/css/global.css">
    <link href="/public/css/bootstrap.min.css" rel="stylesheet">
    <?php echo $header_js;?>
    <?php echo $header_css;?>
</head>
<body>
<div class="container">
  <div class="masthead">
    <ul class="nav nav-pills pull-right">
      <li <?php echo ($page_tag=='index')?'class="active"':'';?> ><a href="<?php echo _dfUrl();?>"><?php echo $data['lang']->line('beta_share_nav');?></a></li>
      <li <?php echo ($page_tag=='createworld')?'class="active"':'';?> ><a href="<?php echo _dfUrl('pix','createWorld');?>"><?php echo $data['lang']->line('beta_create_nav');?></a></li>
      <li <?php echo ($page_tag=='advice')?'class="active"':'';?> ><a href="<?php echo _dfUrl('pix','advice');?>"><?php echo $data['lang']->line('beta_advice_nav');?></a></li>
    </ul>
    <h3><a href="<?php echo site_url();?>" class="muted">Pix</a></h3>
  </div>
  <hr>
</div>