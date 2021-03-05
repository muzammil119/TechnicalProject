<?php

    /******************************************
    *      Codeigniter 3 Simple Login         *
    *   Developer  :  rudiliucs1@gmail.com    *
    *        Copyright © 2017 Rudi Liu        *
    *******************************************/

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

    public function user_list(){

        $data = array(
            'formTitle' => 'User Management',
            'title' => 'User Management',
            'users' => $this->admin_model->get_user_list(),
            'roles' => $this->admin_model->get_role_list(),
        );

        $this->load->view('frame/header_view');
        $this->load->view('frame/sidebar_nav_view');
        $this->load->view('admin/user_list', $data);

    }

    function add_user(){
        $this->ajax_checking();

        $postData = $this->input->post();
        $insert = $this->admin_model->insert_user($postData);
        if($insert['status'] == 'success')
            $this->session->set_flashdata('success', 'User '.$postData['email'].' has been successfully created!');

        echo json_encode($insert);
    }

    function update_user_details(){
        $this->ajax_checking();

        $postData = $this->input->post();
       
        $update = $this->admin_model->update_user_details($postData);
        if($update['status'] == 'success')
            $this->session->set_flashdata('success', 'User '.$postData['email'].'`s details have been successfully updated!');

        echo json_encode($update);
    }

    function deactivate_user($email,$id){
        $this->ajax_checking();


        // $url    =  'https://ant.aliceblueonline.com/oauth2/token?client_id=DEMOHY1&client_secret=qhfi6c2AzkM3M6RHjIPmQTo4pCxNWsshxStWRXL74YKA24rsB39Hk3jnibnQ2qIF';
        
        // $api = "KEY GOES HERE";
        // $authurl = "https://ant.aliceblueonline.com/oauth2/token";

        $client_id = "DEMOHY1";
        $client_secret = "qhfi6c2AzkM3M6RHjIPmQTo4pCxNWsshxStWRXL74YKA24rsB39Hk3jnibnQ2qIF";

        // $client_id = '';
        // $client_secret = '';
        $redirect_uri= "http://127.0.0.1/api/oauthapp";
        $authorization_code = 'fuDPe060Br8AS8Ma5_HVR6hnUsUStiPH42YjLogh1DY.hqKEgkA_HDJYNX1nzjl9qRp0rq9x6AAtgIfuP_6E8gY';
        //$url = 'https://ant.aliceblueonline.com/hydrasocket/v2/websocket';

        // $data = array(
        //     'client_id' => $client_id,
        //     'client_secret' => $client_secret,
        //     'redirect_uri' => $redirect_uri,
        //      'code' => $authorization_code
        //  );

        // https://ant.aliceblueonline.com/hydrasocket/v2/websocket?access_token=boAhiWZ16wQu52AST0ggffjBy1taX62knbX4J7BVujM.3XG6rq1_PsCmey6sRVMce6LxWV_upzn5Onnek21JaAs&m="NSE"

        // $options = array(
        //     'http' => array(
        //         'header'  => "Content-type: application/json\r\n",
        //         'method'  => 'POST',
        //         'content' => json_encode($data)
        //     )
        // );
        // // $context  = stream_context_create($options);
        // //$result = file_get_contents($url, false, $context);

        // var_dump($result);
        //$data['access_token'] = $page_access_token;

        

        $url = 'https://ant.aliceblueonline.com/hydrasocket/v2/websocket?access_token=boAhiWZ16wQu52AST0ggffjBy1taX62knbX4J7BVujM.3XG6rq1_PsCmey6sRVMce6LxWV_upzn5Onnek21JaAs&[NSE]';

        if($result)
            $this->session->set_flashdata('success', 'User '.$email.' has been successfully deleted!');

        echo json_encode($update);
    }

    function reset_user_password($email,$id){
        $this->ajax_checking();

        $update = $this->admin_model->reset_user_password($email,$id);
        if($update['status'] == 'success')
            $this->session->set_flashdata('success', 'User '.$email.'`s password has been successfully reset!');

        echo json_encode($update);
    }

    function activity_log(){
        $data = array(
            'formTitle' => 'Activity Log',
            'title' => 'Activity Log',
        );
        $this->load->view('frame/header_view');
        $this->load->view('frame/sidebar_nav_view');
        $this->load->view('admin/activity_log', $data);

    }

    function get_activity_log(){
        $this->ajax_checking();
        echo  json_encode( $this->admin_model->get_activity_log() );
    }
    public function role_list(){

        $data = array(
            'formTitle' => 'Role Management',
            'title' => 'Role Management',
            'users' => $this->admin_model->get_role_datatable(),
        );

        $this->load->view('frame/header_view');
        $this->load->view('frame/sidebar_nav_view');
        $this->load->view('admin/role_list', $data);

    }
    function add_role(){
        $this->ajax_checking();

        $postData = $this->input->post();
        $insert = $this->admin_model->insert_role($postData);
        if($insert['status'] == 'success')
            $this->session->set_flashdata('success', 'User '.$postData['role_name'].' has been successfully created!');

        echo json_encode($insert);
    }
    function update_role_details(){
        $this->ajax_checking();

        $postData = $this->input->post();

        $update = $this->admin_model->update_role_details($postData);
        if($update['status'] == 'success')
            $this->session->set_flashdata('success', 'User '.$postData['role_name'].'`s details have been successfully updated!');

        echo json_encode($update);
    }
    

}

/* End of file */
