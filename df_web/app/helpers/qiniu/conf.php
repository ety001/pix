<?php
global $SDK_VER;

global $QINIU_UP_HOST;
global $QINIU_RS_HOST;
global $QINIU_RSF_HOST;

global $QINIU_ACCESS_KEY;
global $QINIU_SECRET_KEY;

$SDK_VER = "6.1.9";

$QINIU_UP_HOST	= 'http://upload.qiniu.com';
$QINIU_RS_HOST	= 'http://rs.qbox.me';
$QINIU_RSF_HOST	= 'http://rsf.qbox.me';
$QINIU_API_HOST = 'http://api.qiniu.com';
$QINIU_IOVIP_HOST = 'http://iovip.qbox.me';

$QINIU_ACCESS_KEY	= $CI->config->item('qiniu_access_key');
$QINIU_SECRET_KEY	= $CI->config->item('qiniu_secret_key');
