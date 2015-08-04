<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop extends CI_Controller {

    //初始化
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['tpl_name'] = 'shop/index';
        _viewerCreator($data,'shop');
    }

}