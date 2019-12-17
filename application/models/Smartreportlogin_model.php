<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Smartreportlogin_model extends CI_Model{

  /*function validate($email,$password){
    $this->db->where('user_email',$email);
    $this->db->where('user_password',$password);
    $result = $this->db->get('smartreport_users',1);
    return $result;
  }*/


  public function verifyLogIn($data)
    {
        $user_email = $data['user_email'];
        $user_password = $this->encryptPassword($data['user_password']);

        $this->db->select('su.iduser, su.idhotels, sh.hotels_name, r.roles_name, su.user_name, su.user_email, su.user_password, su.user_level, su.user_status');
        $this->db->from('smartreport_users as su');
        $this->db->join('smartreport_hotels as sh','su.idhotels=sh.idhotels','left');
        $this->db->join('roles as r','r.idroles = su.user_level','left');
        $query = $this->db->where(array('su.user_email' => $user_email));
        $user_data = $query->get()->row();;

        if (count((array)$user_data) > 0) {
            $result = array();
            if ($user_password == $user_data->user_password) {
                if ($user_data->user_status == 0) {
                    $result['validation'] = false;
                    //$result['error'] = 'Your account is suspended! Please contact to Administrator!';
                    $this->session->set_flashdata('account_suspend','message');
                } else {
                    $result['validation'] = true;
                    $result['iduser'] = $user_data->iduser;
                    $result['user_name'] = $user_data->user_name;
                    $result['user_email'] = $user_data->user_email;
                    $result['user_level'] = $user_data->user_level;
                    $result['user_roles'] = $user_data->roles_name;
                    $result['idhotels'] = $user_data->idhotels;
                    $result['hotels_name'] = $user_data->hotels_name;
                    $this->session->set_flashdata('success_login','message');
                    $this->session->set_flashdata('information_update','message');
                }
            } else {
                $result['validation'] = false;
                //$result['error'] = 'Invalid Password!';
                $this->session->set_flashdata('invalid_password','message');
            }

            return $result;
        } else {
            $result['validation'] = false;            
            //$result['error'] = 'Email Address do not exist at the system!';
            $this->session->set_flashdata('invalid_email','message');

            return $result;
        }
    }

    public function encryptPassword($user_password)
    {
        return sha1("$user_password");
    }
}
