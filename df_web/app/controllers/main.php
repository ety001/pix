<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	//初始化
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$data['tpl_name'] = 'index';
		$data['footer_js'] = array('index.js');
		_viewerCreator($data,'main');
	}

	public function login() {
		echo 'login';
	}

	public function checklogin() {
		echo 'checklogin';
	}

	public function canvas() {
		$this->load->model('plat_model','plat');
	}

	public function test() {
		$this->load->model('plat_model','plat');
		$data['all'] = $this->plat->getList();
		$data['tpl_name'] = 'test';
		//$data['footer_js'] = array('test.js');
		_viewerCreator($data,'test');
	}

	public function recover() {
		$this->load->model('plat_model', 'plat');
		$all = $this->plat->getAll();
		foreach ($all as $k => $v) {
			if($v['type']==1){
				_outputBase64PNG($v['base64info'], $v['thumb_name']);
			} else {
				$info = json_decode($v['base64info'], true);
				_outputBase64Gif($info, $v['thumb_name']);
			}
		}
	}


}