<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Weather
{
    private $_api_url;
    private $_appid;
    private $_privatekey;
    private $_typeArr;

    public function __construct($params){
        global $CI;
        $CI->config->load('config');
        $this->_appid = $CI->config->item('weather_appid');
        $this->_privatekey = $CI->config->item('weather_privatekey');
        $this->_api_url = 'http://open.weather.com.cn/data/?';
        $this->_typeArr = array(
            0 => 'index_f',     //基础
            1 => 'index_v',     //常规
            2 => 'forecast_f',  //基础
            3 => 'forecast_v'   //常规
        );
    }

    public function getData($area_name='', $type_id=3, $timestamp){
        if(!$area_name)return;

        global $CI;
        $CI->load->model('weather_model');

        if(!$timestamp){
            $timestamp = time()-24*3600;
        }

        $area_id = $CI->weather_model->getCodeIdByCityName($area_name);
        $url = $this->getApiUrl($area_id, $type_id, $timestamp);
        $result = json_decode( file_get_contents($url), true);
        return $result;
    }

    public function getApiUrl($area_id, $type_id=1, $timestamp){
        $params['areaid'] = $area_id;
        $params['type'] = $this->_typeArr[ $type_id ];
        $params['date'] = date('YmdHi',$timestamp);
        $params['appid'] = $this->_appid;
        $public_key = $this->_api_url . http_build_query($params);
        $key = base64_encode(hash_hmac('sha1', $public_key, $this->_privatekey, true));
        $params['key'] = ($key);
        $params['appid'] = substr($this->_appid,0,6);
        return $this->_api_url . http_build_query($params);
    }
}