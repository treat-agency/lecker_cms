<?php

class Authentication_model extends CI_Model
{
    function getPW($username)
    {
        $this->db->where('username', $username);
        $this->db->select('pword');
        return $this->db->get('backend_user');
    }

    function getUser($email)
    {
        $this->db->where('email', $email);
        $result = $this->db->get('backend_user');
        return ($result->num_rows() > 0) ? $result->row() : false;
    }

    function setToken($token, $email)
    {
        $data = array(
            'reset_token' => $token,
        );
        $this->db->where('email', $email);
        $this->db->update('backend_user', $data);
    }

    function getUserdataByUsername($username)
    {
        $this->db->where('username', $username);
        return $this->db->get('backend_user');
    }

    function getUserdataByID($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('backend_user');
    }

    function updateUser($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('backend_user', $data);
    }

    function getMenupoints($id)
    {
        $this->db->where('user_id', $id);
        $result = $this->db->get('menupoints');
        return ($result->num_rows() > 0) ? $result->result() : array();
    }

    function checkIP($db, $table, $ip)
    {
        $this->db->db_select($db);
        $this->db->where('ip_address', $ip);
        $result = $this->db->get($table);
        return ($result->num_rows() > 0) ? true : false;
    }
}
