<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

    //初始化
    public function __construct() {
        parent::__construct();
        $this->load->model('plat_model','plat');
    }

    public function index(){
        show_404();
    }

    //添加新的图片
    public function add_info() {
        $tmp_id = $this->input->post('tmp_id');
        $user_id = (int)$this->input->post('user_id',true);
        $name = $this->input->post('name',true);
        $info = json_decode( htmlspecialchars_decode( $this->input->post('info') ) ,true);
        $type = (int)$this->input->post('type',true);

        $base64info_ori = $this->input->post('base64info', true);
        $new_base64info = str_ireplace('[removed]', '"data:image/png;base64,', $base64info_ori);
die($_POST['base64info']);
        if($type==1){
            $base64info_tmp = $new_base64info;
        } elseif($type==2) {
            $base64info_tmp = json_decode(  $new_base64info , true);
        }
var_dump($base64info_tmp);die();
        if(!$type || !$name || !$info || !$base64info_tmp ) {
            _ar(array('msg'=>'infomation not complete'), false);
        }

        $data['type']   = $type;
        $data['name']   = $name;
        $data['info']   = json_encode($info);
        if($type==1) {
            $base64info = $base64info_tmp;
            $data['thumb_name'] = _outputBase64PNG($base64info);
            $data['base64info'] = $base64info;
        }
        if($type==2) {
            foreach ($base64info_tmp as $k => $v) {
                $base64info[$k]['delay'] = $info[$k]['delay'];
                $base64info[$k]['info'] = $v;
            }
            $data['thumb_name'] = _outputBase64Gif($base64info);
            $data['base64info'] = json_encode($base64info);
        }

        if ( $this->plat->addNew($user_id, $data) ){
            $this->plat->removeOne(array('id'=>$tmp_id));
            _ar(array(), true);
        } else {
            _ar(array('msg'=>'insert information failed'), false);
        }
    }

    //获取指定pic_id的图片
    public function get_one() {
        $info_id = (int)$this->input->post('info_id');
        if(!$info_id) {
            _ar(array(), false);
        }
        $info = $this->plat->getOneByID($info_id);
        _ar($info, true);
    }

    public function temp_push() {
        $id = (int)$this->uri->rsegment(3);
        echo $id;
        file_put_contents('temp_push', $id);
    }

    public function temp_pull() {
        $id = file_get_contents('temp_push');
        if($id){
            //file_put_contents('temp_push', '');
            $info = $this->plat->getOneByID($id);
            if($info['type']==1){
                $info['img'] = _createPNGPath($info['thumb_name']);
            }
            if($info['type']==2){
                $info['img'] = _createGIFPath($info['thumb_name']);
            }
            if($info){
                _ar($info, true);
            } else {
                _ar('', false);
            }
        } else {
            _ar('', false);
        }
    }

    public function update_tmp() {
        $id = (int)$this->uri->rsegment(3);
        if($id){
            $this->plat->edit_status_tmp($id);
        }
    }

}