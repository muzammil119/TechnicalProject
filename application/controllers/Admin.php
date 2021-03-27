<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Admin extends CI_Controller {

    public function __Construct() {
        parent::__Construct();
        if(!$this->session->userdata('logged_in')) {
            redirect(base_url());
        }

        if($this->session->userdata('role') != 'Admin'){
            redirect(base_url());
        }

        $this->load->model('admin_model');
    }
    

    private function ajax_checking(){
        if (!$this->input->is_ajax_request()) {
            redirect(base_url());
        }
    }

    public function company_list(){
        $sess_data = $this->session->userdata('logged_in');

        $data = array(
            'formTitle' => 'Company Management',
            'title' => 'Company Management',
            'company_list' => $this->admin_model->get_company_list(),
            
        );

        $this->load->view('frame/header_view');
        $this->load->view('frame/sidebar_nav_view');
        $this->load->view('admin/company_list_view', $data);

    }

    function add_company(){
        $this->ajax_checking();
        $sess_id = $this->session->userdata('logged_in');
        $postData = $this->input->post();
        $insert = $this->admin_model->insert_company($postData, $sess_id);
        if($insert['status'] == 'success')
            $this->session->set_flashdata('success', 'User '.$postData['name'].' has been successfully added!');

        echo json_encode($insert);
    }

    function update_company_details(){
        $this->ajax_checking();

        $sess_id = $this->session->userdata('logged_in');
        $postData = $this->input->post();   

        $update = $this->admin_model->update_company_details($postData, $sess_id);
        if($update['status'] == 'success')
            $this->session->set_flashdata('success', 'Company '.$postData['name'].'`s details have been successfully updated!');

        echo json_encode($update);
    }


    function reset_user_password($email,$id){
        $this->ajax_checking();

        $update = $this->admin_model->reset_user_password($email,$id);
        if($update['status'] == 'success')
            $this->session->set_flashdata('success', 'User '.$email.'`s password has been successfully reset!');

        echo json_encode($update);
    }


    function get_activity_log(){
        $this->ajax_checking();
        echo  json_encode( $this->admin_model->get_activity_log() );
    }
    public function employee_list(){

        $data = array(
            'formTitle' => 'Employee Management',
            'title' => 'Employee Management',
            'employee_list' => $this->admin_model->get_employee_datatable(),
            'company_list' => $this->admin_model->get_company_list(),
        );

        $this->load->view('frame/header_view');
        $this->load->view('frame/sidebar_nav_view');
        $this->load->view('admin/employee_list_view', $data);

    }
    function add_employee(){
        $this->ajax_checking();
        $sess_id = $this->session->userdata('logged_in');
        $postData = $this->input->post();
        $insert = $this->admin_model->insert_employee($postData, $sess_id);
        if($insert['status'] == 'success')
            $this->session->set_flashdata('success', 'Employee '.$postData['first_name'].' has been successfully created!');

        echo json_encode($insert);
    }
    function update_employee_details(){
        $this->ajax_checking();
        $sess_id = $this->session->userdata('logged_in');
        $postData = $this->input->post();

        $update = $this->admin_model->update_employee_details($postData, $sess_id);
        if($update['status'] == 'success')
            $this->session->set_flashdata('success', 'Employee '.$postData['first_name'].'`s details have been successfully updated!');

        echo json_encode($update);
    }
    function delete_company($email,$id){
        $this->ajax_checking();

        $update = $this->admin_model->delete_company($email,$id);
        if($update['status'] == 'success')
            $this->session->set_flashdata('success', 'Company '.$email.' has been successfully deleted!');

        echo json_encode($update);
    }
    function deactivate_employee($email,$id){
        $this->ajax_checking();

        $update = $this->admin_model->delete_employee($email,$id);
        if($update['status'] == 'success')
            $this->session->set_flashdata('success', 'Employee '.$email.' has been successfully deleted!');

        echo json_encode($update);
    }
    function upload_logo(){
        
        if($_FILES["company_logo"]["name"] != '')
        {
             $test = explode('.', $_FILES["company_logo"]["name"]);
             $ext = end($test);
             $name = rand(100, 999) . '.' . $ext;
             $location = './uploads/' . $name;  
             move_uploaded_file($_FILES["company_logo"]["tmp_name"], $location);
             echo json_encode(base_url().'/uploads/'.$name);
             
        }
    }

}

/* End of file */
