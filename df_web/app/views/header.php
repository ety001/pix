<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>豆屏</title>
    <link rel="stylesheet" type="text/css" href="/public/css/global.css">
    <link href="/public/css/bootstrap.min.css" rel="stylesheet">
    <?php echo $header_js;?>
    <?php echo $header_css;?>
</head>
<body>
<div class="container">
  <div class="masthead">
    <ul class="nav nav-pills pull-right">
      <li><a href="#">登录</a></li>
      <li><a href="#">注册</a></li>
    </ul>
    <h2 class="muted">&nbsp;豆&nbsp;屏</h2>
    <div class="navbar">
      <div class="navbar-inner">
        <div class="container">
          <ul class="nav">
            <li <?php echo ($page_tag=='main')?'class="active"':'';?> ><a href="<?php echo _dfUrl();?>">首&nbsp;页</a></li>
            <li <?php echo ($page_tag=='createworld')?'class="active"':'';?> ><a href="<?php echo _dfUrl('createworld');?>">创&nbsp;造</a></li>
            <li <?php echo ($page_tag=='share')?'class="active"':'';?> ><a href="<?php echo _dfUrl('share');?>">分&nbsp;享</a></li>
            <li <?php echo ($page_tag=='shop')?'class="active"':'';?> ><a href="<?php echo _dfUrl('shop');?>">商&nbsp;店</a></li>
            <li><a href="#">关于</a></li>
          </ul>
        </div>
      </div>
    </div><!-- /.navbar -->
  </div>
</div>