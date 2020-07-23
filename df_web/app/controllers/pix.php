<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pix extends CI_Controller {

    //初始化
    public function __construct() {
        parent::__construct();
        $lang = _getLang();
        if($lang[0][0]=='zh-cn' || $lang[0][0]=='zh-tw'){
            $this->config->set_item('language', 'zh_cn');
            $this->lang_type = 1;
        } else {
            $this->config->set_item('language', 'english');
            $this->lang_type = 2;
        }
        $this->load->model('plat_model','plat');
        $this->lang->load('beta');
    }

    public function index() {
        $page_num = 36;
        $user_id = 0;

        $p = (int)$this->uri->rsegment(3)?$this->uri->rsegment(3):1;
        $offset = ($p-1)*$page_num;

        $all = $this->plat->getList(null, null, $page_num, $offset);
        $data['all'] = $all;
        $data['tpl_name'] = 'index';
        $data['footer_js'] = array('pix_index.js');
        $data['lang_type'] = $this->lang_type;
        $data['page'] = $p;
        $data['last_page'] = ceil( $this->plat->getAllNum()/$page_num );
        $data['lang']   = $this->lang;
        _betaViewer($data,'index');
    }

    public function createWorld() {
        $id = (int)$_GET['id'];
        $data['info'] = $this->plat->getOneByID($id);
        $data['tpl_name'] = 'createworld';
        $data['header_css'] = array('Color.Picker.Classic.css');
        $data['footer_js'] = array('Color.Space.js', 'Color.Picker.Classic.js', 'add.js');
        $data['lang_type'] = $this->lang_type;
        $data['lang']   = $this->lang;
        $data['id']     = $id;
        _betaViewer($data,'createworld');
    }

    public function createAnimation() {
        $id = (int)$_GET['id'];
        $data['info'] = $this->plat->getOneByID($id);
        $data['header_css'] = array('Color.Picker.Classic.css','jquery.jscrollpane.css');
        $data['footer_js'] = array('Color.Space.js', 'Color.Picker.Classic.js', 'jquery.mousewheel.js', 'jquery.jscrollpane.min.js', 'animation.js');
        $data['tpl_name'] = 'createanimation';
        $data['lang_type'] = $this->lang_type;
        $data['lang']   = $this->lang;
        $data['id']     = $id;
        _betaViewer($data,'createanimation');
    }

    public function advice() {
        return redirect('https://akawa.ink/about/');
        $data['tpl_name'] = 'advice';
        $data['lang_type'] = $this->lang_type;
        $data['lang']   = $this->lang;
        _betaViewer($data,'advice');
    }

    public function genius() {
        $id = (int)$_GET['id'];
        $iframe = (int)$_GET['iframe'];
        if(!$id){
            redirect('/', 'refresh');
            return;
        }
        $data['info'] = $this->plat->getOneByID($id);
        $data['lang_type'] = $this->lang_type;
        $data['lang']   = $this->lang;
        $data['is_outside'] = _isOutside();
        $data['is_iframe']  = $iframe;
        $this->load->view('beta/genius',$data);
    }

    public function yuyecaho() {
        $all = $this->plat->getList();
        $data['all'] = $all;
        $this->load->view('beta/yuyecaho',$data);
    }

    public function yuyecaho_del() {
        die();
        return;
        $id = (int)$this->uri->rsegment(3);
        $info = $this->plat->getOneByID($id);
        if($info){
            unlink( '.' . _createPNGPath($info['thumb_name']) );
            unlink( '.' . _createGIFPath($info['thumb_name']) );
            $this->plat->removeOne(array('id'=>$id));
            redirect('/pix/yuyecaho','refresh');
        }
    }

    public function temp(){
        $page_num = 12;
        $user_id = 0;

        $p = (int)$this->uri->rsegment(3)?$this->uri->rsegment(3):1;
        $offset = ($p-1)*$page_num;

        $all = $this->plat->getList(null, null, $page_num, $offset);
        $data['all'] = $all;

        $data['page'] = $p;
        $data['last_page'] = ceil( $this->plat->getAllNum()/$page_num );
        $this->load->view('beta/temp_push',$data);
    }

    public function temp_pull(){
        $this->load->view('beta/temp_pull');
    }

    public function tmp_new(){
        $info = $this->plat->getOne_tmp();
        if($info['type']==1){
            redirect( _dfUrl( 'pix','tmp_createWorld',array('id='.$info['id']) ) );
        }
        if($info['type']==2){
            redirect( _dfUrl( 'pix','tmp_createAnimation',array('id='.$info['id']) ) );
        }
    }

    public function tmp_createWorld() {
        $id = (int)$_GET['id'];
        $data['info'] = $this->plat->getOneByID_tmp($id);
        $data['tpl_name'] = 'createworld_tmp';
        $data['header_css'] = array('Color.Picker.Classic.css');
        $data['footer_js'] = array('Color.Space.js', 'Color.Picker.Classic.js', 'add_tmp.js');
        $data['lang_type'] = $this->lang_type;
        $data['lang']   = $this->lang;
        _betaViewer($data,'createworld_tmp');
    }

    public function tmp_createAnimation() {
        $id = (int)$_GET['id'];
        $data['info'] = $this->plat->getOneByID_tmp($id);
        $data['header_css'] = array('Color.Picker.Classic.css','jquery.jscrollpane.css');
        $data['footer_js'] = array('Color.Space.js', 'Color.Picker.Classic.js', 'jquery.mousewheel.js', 'jquery.jscrollpane.min.js', 'animation_tmp.js');
        $data['tpl_name'] = 'createanimation_tmp';
        $data['lang_type'] = $this->lang_type;
        $data['lang']   = $this->lang;
        _betaViewer($data,'createanimation_tmp');
    }

    public function test() {
        $this->load->view('test');
    }

}
