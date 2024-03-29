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

}
