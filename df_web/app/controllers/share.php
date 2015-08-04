<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Share extends CI_Controller {

    //初始化
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->model('plat_model','plat');
        $all = $this->plat->getList();
        $data['all'] = $all;
        $data['tpl_name'] = 'share/index';
        _viewerCreator($data,'share');
    }
}