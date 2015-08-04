<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Weather_model extends CI_Model {
    //初始化数据库
    private $master;
    
    //使用的数据库表
    const TIKTOK_WEATHER_CITY_CODE_TABLE                   = 'weather_city_code';

    public function __construct() {
        parent::__construct();
        $this->master = $this->load->database('default', true);
    }

    public function getCodeIdByCityName($cityname=''){
        if(!$cityname)return;
        $this->master->like('namecn', $cityname);
        $query = $this->master->get(self::TIKTOK_WEATHER_CITY_CODE_TABLE);
        $result = $query->result_array();
        return $result[0]['areaid'];
    }
}