<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Createworld extends CI_Controller {

    //初始化
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $user_id = 1;
        $this->load->model('plat_model','plat');
        $pic = $this->plat->getList(1,$user_id,10);
        $data['pic'] = $pic;

        $data['tpl_name'] = 'createworld/index';
        $data['header_css'] = array('Color.Picker.Classic.css');
        $data['footer_js'] = array('Color.Space.js', 'Color.Picker.Classic.js', 'add.js');
        _viewerCreator($data,'createworld');
    }

}