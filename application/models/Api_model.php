<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model {
    function fetch_all()
    {
        $this->db->order_by('id','DESC');
        return $this->db->get('name');
    }

    function insert_api($data)
    {   
        $this->db->insert('name',$data);
    }

    function fetch_single_user($user_id)
    {
        $this->db->where('id', $user_id);
        $query = $this->db->get('name'); 
        return $query->result_array();
    }

    function update_api($user_id, $data)
    {
        $this->db->where('id', $user_id);
        $this->db->update('name', $data);
    }
}
