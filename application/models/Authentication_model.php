<?php


if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Authentication_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }


    function validate_login($postData){
        $this->db->select('*');
        $this->db->where('email', $postData['email']);
        $this->db->where('password', md5($postData['password']));
        $this->db->where('status', 1);
        $this->db->from('user');
        $query=$this->db->get();
        if ($query->num_rows() == 0)
            return false;
        else
            return $query->result();
    }

    function change_password($postData){
        $this->load->model('admin_model');
        $validate = false;

        $oldData = $this->admin_model->get_user_by_id($this->session->userdata('user_id'));

        if($oldData[0]['password'] == md5($postData['currentPassword']))
            $validate = true;

        if($validate){
            $data = array(
                'password' => md5($postData['newPassword']),
            );
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->update('user', $data);
            return array('status' => 'success', 'message' => '');
        }else{
            return array('status' => 'invalid', 'message' => '');
        }

    }
    function update_user($postData){

        $oldData = $this->get_user_by_id($postData['id']);

        if($oldData[0]['email'] == $postData['email'])
            $validate = true;
        else
            $validate = $this->validate_email($postData);

        if($validate){
            $data = array(
                'email' => $postData['email'],
                'name' => $postData['name'],                
            );
            $this->db->where('user_id', $postData['id']);
            $this->db->update('user', $data);

            
            return array('status' => 'success');
        }else{
            return array('status' => 'exist');
        }

    }
    function get_user_by_id($userID){
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('user_id', $userID);
        $query=$this->db->get();
        return $query->result_array();
    }
    function validate_email($postData){
        $this->db->where('email', $postData['email']);
        $this->db->where('status', 1);
        $this->db->from('user');
        $query=$this->db->get();

        if ($query->num_rows() == 0)
            return true;
        else
            return false;
    }
}

/* End of file  */
