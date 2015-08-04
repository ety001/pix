<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
$CI = &get_instance();

/*ajax result*/
if(!function_exists('_ar')){
    function _ar($data=array(), $flag=TRUE, $is_die=TRUE){
        if($flag === TRUE) {
            echo json_encode(array('status'=>'OK', 'data'=>$data));
        } else {
            echo json_encode(array('status'=>'ERR', 'data'=>$data));
        }
        if ($is_die === TRUE)
        {
            die();
        }
        else
        {
            if(function_exists('fastcgi_finish_request'))
            {
                fastcgi_finish_request();
            }
        }
    }
}

/* create url path */
if(!function_exists('_dfUrl')){
    function _dfUrl($c='',$a='',$params=array()){
        if(!empty($params)){
            $params_string = implode('&', $params);
            $params_string = '?'.$params_string;
        }
        $url = '';
        if($c){
            $url = '/'.$c;
            if($a){
                $url .= '/'.$a;
            }
            if($params_string){
                $url .= '/'.$params_string;
            }
        } else {
            $url = '/';
        }
        return site_url($url);
    }
}

/* viewer creator */
if(!function_exists('_viewerCreator')){
    function _viewerCreator($params,$page_tag='main'){
        global $CI;
        $tpl_name = $params['tpl_name'];
        $header_js = '';
        if($params['header_js']){
            foreach ($params['header_js'] as $k => $v) {
                $header_js .= '<script src="/public/js/'.$v.'"></script>'."\n";
            }
        }
        $data['header_js'] = $header_js;

        $header_css = '';
        if($params['header_css']){
            foreach ($params['header_css'] as $k => $v) {
                $header_css .= '<link rel="stylesheet" type="text/css" href="/public/css/'.$v.'">'."\n";

            }
        }
        $data['header_css'] = $header_css;

        $footer_js = '';
        if($params['footer_js']){
            foreach ($params['footer_js'] as $k => $v) {
                $footer_js .= '<script src="/public/js/'.$v.'"></script>'."\n";
            }
        }
        $data['footer_js'] = $footer_js;

        $data['data'] = $params;
        $data['page_tag'] = $page_tag;

        $CI->load->view('header', $data);
        $CI->load->view($tpl_name, $data);
        $CI->load->view('footer', $data);
    }
}

/* get img from base64 info */
if(!function_exists('_get_img_frm_base64')){
    function _get_img_frm_base64($base64=''){
        if($base64){
            $temp = substr($base64,9);
            $temp = 'data:image/png;base64,' . $temp;
            return $temp;
        }
    }
}

/* beta viewer */
if(!function_exists('_betaViewer')){
    function _betaViewer($params,$page_tag='main'){
        global $CI;
        $tpl_name = $params['tpl_name'];
        $header_js = '';
        if($params['header_js']){
            foreach ($params['header_js'] as $k => $v) {
                $header_js .= '<script src="/public/js/'.$v.'"></script>'."\n";
            }
        }
        $data['header_js'] = $header_js;

        $header_css = '';
        if($params['header_css']){
            foreach ($params['header_css'] as $k => $v) {
                $header_css .= '<link rel="stylesheet" type="text/css" href="/public/css/'.$v.'">'."\n";

            }
        }
        $data['header_css'] = $header_css;

        $footer_js = '';
        if($params['footer_js']){
            foreach ($params['footer_js'] as $k => $v) {
                $footer_js .= '<script src="/public/js/'.$v.'"></script>'."\n";
            }
        }
        $data['footer_js'] = $footer_js;

        $data['data'] = $params;
        $data['page_tag'] = $page_tag;

        $CI->load->view('beta/header', $data);
        $CI->load->view('beta/'.$tpl_name, $data);
        $CI->load->view('beta/footer', $data);
    }
}

/* get language */
if(!function_exists('_getLang')){
    function _getLang(){
        $temp = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $temp1 = explode(';', $temp);
        $result = array();
        foreach ($temp1 as $k => $v) {
            $t = explode(',', $v);
            array_push($result, $t);
        }
        return $result;
    }
}

/* is from outside */
if(!function_exists('_isOutside')){
    function _isOutside(){
        $host = $_SERVER['SERVER_NAME'];
        $referer = $_SERVER['HTTP_REFERER'];
        $url = parse_url($referer);
        if($url['host']==$host){
            return false;
        } else {
            //from outside
            return true;
        }
    }
}

/* output base64 png */
if(!function_exists('_outputBase64PNG')){
    function _outputBase64PNG($info, $filename){
        global $CI;
        $s = base64_decode(str_replace('data:image/png;base64,', '', $info));
        if(!$filename){
            $filename = time().'_'.md5($info);
        }
        $path = $CI->config->item('thumb_path');
        file_put_contents($path.$filename.'.png', $s);
        return $filename;
    }
}

/* output base64 gif */
if(!function_exists('_outputBase64Gif')){
    function _outputBase64Gif($info, $filename){
        //注意$info的第一帧id是1
        global $CI;
        if(!$filename){
            $filename = time().'_'.md5($info[1]['info']);
        }
        $path = $CI->config->item('thumb_path');

        $data = array();
        $delay = array();

        foreach($info as $k=>$v){
            $s = base64_decode(str_replace('data:image/png;base64,', '', $v['info']));
            $data[] = $s;
            $delay[] = $v['delay']/10;
        }
        $CI->load->library('GifCreator');
        $CI->gifcreator->create($data, $delay, 0);
        $content = $CI->gifcreator->getGif();
        file_put_contents($path.$filename.'.gif', $content);
        $s = base64_decode(str_replace('data:image/png;base64,', '', $info[1]['info'] ));
        file_put_contents($path.$filename.'.png', $s);
        return $filename;
    }
}

/* create png path */
if(!function_exists('_createPNGPath')){
    function _createPNGPath($name){
        global $CI;
        $path = str_replace('.', '', $CI->config->item('thumb_path') );
        return $path.$name.'.png';
    }
}

/* create gif path */
if(!function_exists('_createGIFPath')){
    function _createGIFPath($name){
        global $CI;
        $path = str_replace('.', '', $CI->config->item('thumb_path') );
        return $path.$name.'.gif';
    }
}

/* check and create dir */
if(!function_exists('_checkAndCreateDir')){
    function _checkAndCreateDir($path){
        if(!file_exists($path)){
            @mkdir($path);
        }
    }
}
