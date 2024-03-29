<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_api extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    function index()
    {
        $this->load->view('api_view');
    }

    function action()
    {
        if($this->input->post('data_action'))
        {
            $data_action = $this->input->post('data_action');
        
            if($data_action == 'fetch_all')
            {
                $api_url = base_url().'api';
                
                $client = curl_init($api_url);
              
                curl_setopt($client,CURLOPT_RETURNTRANSFER, true);
                
                $response = curl_exec($client);
                
                curl_close($client);
            
                $result = json_decode($response);
                
                $output = '';

                if(count($result) > 0)
                {
                    foreach($result as $row)
                    {
                        $output .= '
                        <tr>
                            <td>'.$row->first_name.'</td>
                            <td>'.$row->last_name.'</td>
                            <td class="text-center"><button type="button" class="btn btn-primary" name="edit" id="'.$row->id.'">Edit</button></td>
                            <td class="text-center"><button type="button" class="btn btn-warning" name="delete" id="'.$row->id.'">Delete</button></td>
                        </tr>
                        ';
                    }
                }
                else
                {
                    $output .= '
                        <tr>
                            <td colspan="4" align="center">No Data Found!</td>
                        </tr>
                    ';
                }
                echo $output;
            }

            if($data_action == 'Insert')
            {
                $api_url = base_url().'api/insert';
            }

            $form_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name')
            ); 
            
            $client = curl_init($api_url);
            curl_setopt($client,CURLOPT_POST, true);
            curl_setopt($client,CURLOPT_POSTFIELDS, $form_data);
            curl_setopt($client,CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($client);
                
            curl_close($client);

            echo $response;
        }
    }
}
