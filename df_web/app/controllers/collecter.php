<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Collecter extends CI_Controller {

    //初始化
    public function __construct() {
        parent::__construct();
        //$this->load->model('plat_model','plat');
    }

    public function index(){
        show_404();
    }

    public function weather(){
        $cityname = urldecode( $this->input->get('city') );
        $this->load->library('weather');
        $result = $this->weather->getData($cityname);
        var_dump($result);
    }
}