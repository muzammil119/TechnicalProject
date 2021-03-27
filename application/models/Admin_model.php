<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Admin_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }


    function get_company_list(){
        $this->db->select('*');
        $this->db->from('company_details');        
        $query=$this->db->get();
        return $query->result();
    }

    function get_company_by_id($userID){
        $this->db->select('*');
        $this->db->from('company_details');
        $this->db->where('id', $userID);
        $query=$this->db->get();
        return $query->row_array();
    }
    function get_employee_by_id($userID){
        $this->db->select('*');
        $this->db->from('employee_details');
        $this->db->where('employee_id', $userID);
        $query=$this->db->get();
        return $query->row_array();
    }

    function validate_email($postData){
        $this->db->where('email', $postData['email']);        
        $this->db->from('company_details');
        $query=$this->db->get();

        if ($query->num_rows() == 0)
            return true;
        else
            return false;
    }
    function validate_email_employee($postData){
        $this->db->where('email', $postData['email']);        
        $this->db->from('employee_details');
        $query=$this->db->get();

        if ($query->num_rows() == 0)
            return true;
        else
            return false;
    }

    function insert_company($postData, $sess_id){

        $validate = $this->validate_email($postData);

        if($validate){            
            $data = array(
                'email' => $postData['email'],
                'name' => $postData['name'],
                'logo' => $postData['company_logo'],
                'website' => $postData['website'],
                'created_date' => date('Y\-m\-d\ H:i:s A'),
                'created_by_id' => $sess_id
            );
            $this->db->insert('company_details', $data);
            $module = "Company Management";          
            
            return array('status' => 'success', 'message' => '');

        }else{
            return array('status' => 'exist', 'message' => '');
        }

    }

    function update_company_details($postData, $sess_id){

        $oldData = $this->get_company_by_id($postData['id']);
        if($oldData['email'] == $postData['email'])
             $validate = true;
         else
             $validate = $this->validate_email($postData);
        if($validate){
            $data = array(
                'email' => $postData['email'],
                'name' => $postData['name'],
                'logo' => $postData['logo'],
                'website' => $postData['website'],
                'created_date' => date('Y\-m\-d\ H:i:s A'),
                'created_by_id' => $sess_id
            );
            $this->db->where('id', $postData['id']);
            $this->db->update('company_details', $data);
            return array('status' => 'success');
        }else{
            return array('status' => 'exist');
        }

    }

    function get_employee_datatable(){
        $this->db->select('employee_id,first_name,last_name,employee_details.email,employee_details.created_date,company_id,company_details.name');
        $this->db->from('employee_details');  
        $this->db->JOIN('company_details', 'employee_details.company_id = company_details.id', 'LEFT');       
        $query=$this->db->get();
        
        return $query->result();
    }
    function get_role_list(){
        $this->db->select('*');
        $this->db->from('employee_details');        
        $this->db->where_in('status',1);
        $query=$this->db->get();
        
        return $query->result();
    }
    function insert_employee($postData, $sess_id){
        $validate = $this->validate_email_employee($postData);
        if($validate){            
            $data = array(
                'first_name' => $postData['first_name'],
                'last_name' => $postData['last_name'],
                'email' => $postData['email'],
                'company_id' => $postData['company_id'],              
                'created_by_id' => $sess_id,             
                'created_date' => date('Y\-m\-d\ H:i:s A'),
            );
            $this->db->insert('employee_details', $data);         
            
            return array('status' => 'success', 'message' => '');

        }else{
            return array('status' => 'exist', 'message' => '');
        }      

    }
    function update_employee_details($postData, $sess_id){

       $oldData = $this->get_employee_by_id($postData['id']);
        if($oldData['email'] == $postData['email'])
             $validate = true;
         else
             $validate = $this->validate_email_employee($postData);
        if($validate){
            $data = array(
                'first_name' => $postData['first_name'],
                'last_name' => $postData['last_name'],
                'email' => $postData['email'],
                'company_id' => $postData['company_id'],              
                'created_by_id' => $sess_id,             
                'created_date' => date('Y\-m\-d\ H:i:s A'),
            );
            $this->db->where('employee_id', $postData['id']);
            $this->db->update('employee_details', $data);
            return array('status' => 'success');
        }else{
            return array('status' => 'exist');
        }
        

    }
   
    function delete_company($email,$id)
    {
       $this->db->where('id', $id);
       $this->db->delete('company_details'); 
       return array('status' => 'success', 'message' => '');
    }
    function delete_employee($email,$id)
    {
       $this->db->where('employee_id', $id);
       $this->db->delete('employee_details'); 
       return array('status' => 'success', 'message' => '');
    }

    function reset_user_password($email,$id){

        $password = $this->generate_password();
        $data = array(
            'password' => md5($password),
        );
        $this->db->where('user_id', $id);
        $this->db->update('user', $data);

        $message = "Your account password has been reset.<br><br>Email: ".$email."<br>Tempolary password: ".$password."<br>Please change your password after login.<br><br> you can login at ".base_url().".";
        $subject = "Password Reset";
        $this->send_email($message,$subject,$email);

        $module = "User Management";
        $activity = "reset user ".$email."`s password";
        $this->insert_log($activity, $module);
        return array('status' => 'success', 'message' => '');

    }
    function get_company_list_emp(){
        $this->db->select('name,id');
        $this->db->from('company_details');        
        $query=$this->db->get();
        return $query->result();
    }
    function generate_password(){
        $chars = "abcdefghjkmnopqrstuvwxyzABCDEFGHJKMNOPQRSTUVWXYZ023456789!@#$%^&*()_=";
        $password = substr( str_shuffle( $chars ), 0, 10 );

        return $password;
    }



    

}

/* End of file */
