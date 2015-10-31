<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Footer extends MX_Controller
{
    function index()
    {
        $data['use_footer']=$this->db_config->get('content','display_footer')==1;
        $data['code']=htmlspecialchars($this->db_config->get('content','footer_html'));
        $this->load->view('footer',$data);
    }


    function save(){
        $html = rawurldecode($this->input->post('html'));
        $enable = $this->input->post('enable');
        $this->db_config->set('content','display_footer', $enable);
        $this->db_config->set('content','footer_html', $html);
        $this->db_config->save();
        echo 'success';
    }

}
