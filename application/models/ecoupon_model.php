<?php
/**
 * Created by PhpStorm.
 * User: putra.liowono
 * Date: 8/31/2016
 * Time: 3:54 PM
 */
class ecoupon_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function select_promo_event(){
        $this->db->distinct();
        $this->db->select('promoEvent');
        $query = $this->db->get('azswd01.BI_Data.dbo.BI_eCouponCode');
        return $query->result_array();
    }

    function select_promo_event_staging(){
        $this->db->distinct();
        $this->db->select('promoEvent');
        $query = $this->db->get('azswd01.BI_Data.dbo.BI_eCouponCode_staging');
        return $query->result_array();
    }

    function promo_event($newPromo){
        $query = $this->db->get_where('azswd01.BI_Data.dbo.BI_eCouponCode',array('promoEvent =' => $newPromo));
        return $query->result_array();
    }

    function promo_event_staging($newPromo){
        $query = $this->db->get_where('azswd01.BI_Data.dbo.BI_eCouponCode_staging',array('promoEvent =' => $newPromo));
        return $query->result_array();
    }

    function select_code($newCode){
        $query = $this->db->get_where('BCOMREADWRITE.DOS2_HO.dbo.bhx_eCouponCode',array('eCouponCode =' => $newCode));
        return $query->result_array();
    }

    function select_code_staging($newCode){
        $query = $this->db->get_where('azswd01.BI_Data.dbo.bhx_eCouponCode_staging',array('eCouponCode =' => $newCode));
        return $query->result_array();
    }

    function insert_code($table,$data){
        $this->db->insert_batch($table, $data);
    }
}
?>