<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Plat_model extends CI_Model {
    //初始化数据库
    private $master;
    
    //使用的数据库表
    const TIKTOK_PLAT_PIX_TABLE                   = 'plat_pix';

    const TIKTOK_PLAT_PIX_TABLE_BK                   = 'plat_pix_bk';

    public function __construct() {
        parent::__construct();
        $this->master = $this->load->database('default', true);
    }

    //get pic or animation list
    public function getList($type=0,$user_id=null,$limit=0,$offset=0,$order_by='id desc') {
        if($limit) {
            $this->master->limit($limit, $offset);
        }

        if($user_id!==null) {
            $this->master->where('user_id', $user_id);
        }

        if($type) {
            $this->master->where('type', $type);
        }

        if($order_by) {
            $this->master->order_by($order_by);
        }

        $query = $this->master->get(self::TIKTOK_PLAT_PIX_TABLE);
        $result = $query->result_array();
        return $result;
    }

    //get pic or animation by id
    public function getOneByID($id) {
        if(!$id)return;
        $query = $this->master->order_by('id')->get_where(self::TIKTOK_PLAT_PIX_TABLE, array('id'=>$id) );
        $result = $query->result_array();
        return $result[0];
    }

    //add new pic or animation
    public function addNew($user_id=null, $data) {
        if($user_id===null || !$data )return;
        $input_array    = array(
            'type'  => $data['type'],
            'user_id'   => $user_id,
            'name'  => $data['name'],
            'info'  => $data['info'],
            'thumb_name' => $data['thumb_name'],
            'base64info' => $data['base64info']
        );
        return $this->master->insert(self::TIKTOK_PLAT_PIX_TABLE, $input_array);
    }

    public function getAllNum(){
        return $this->master->count_all(self::TIKTOK_PLAT_PIX_TABLE);
    }

    public function updateOne($data) {
        $this->master->where('id', $data['id']);
        unset($data['id']);
        $this->master->update(self::TIKTOK_PLAT_PIX_TABLE, $data); 
    }

    public function removeOne($conditions) {
        return $this->master->delete(self::TIKTOK_PLAT_PIX_TABLE, $conditions);
    }

    public function getAll(){
        $query = $this->master->get(self::TIKTOK_PLAT_PIX_TABLE);
        $result = $query->result_array();
        return $result;
    }

    //tmp new
    public function getOneByID_tmp($id) {
        if(!$id)return;
        $query = $this->master->order_by('id')->get_where(self::TIKTOK_PLAT_PIX_TABLE_BK, array('id'=>$id) );
        $result = $query->result_array();
        return $result[0];
    }
    //tmp new
    public function getOne_tmp(){
        $query = $this->master->limit(1)->order_by('id')->get_where(self::TIKTOK_PLAT_PIX_TABLE_BK, array('user_id'=>0) );
        $result = $query->result_array();
        return $result[0];
    }
    public function edit_status_tmp($id){
        if(!$id)return;
        $data = array(
               'user_id' => 1
            );
        $this->master->where('id', $id);
        $this->master->update(self::TIKTOK_PLAT_PIX_TABLE_BK, $data);
    }

}