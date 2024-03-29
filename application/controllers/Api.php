<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_model');
        $this->load->database();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data = $this->Api_model->fetch_all();
        echo json_encode($data->result_array());
    }

    function Insert()
    {
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');

        if($this->form_validation->run())
        {   
            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name')
            );

            $this->Api_model->insert_api($data);

            $array = array(
                'success'  => true
            );
        }
        else
        {
            $array = array(
                'error'   => true,
                'first_name_error'  => form_error('first_name'),
                'last_name_error'  => form_error('last_name')
            );
        }
        // sends response in json format
        echo json_encode($array);
    }
}
