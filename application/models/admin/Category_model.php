<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all($where = NULL)
    {
        if(isset($where))
        {
            $this->db->where($where);
        }
        $query = $this->db->get('categories');
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return FALSE;
    }



    public function get_by_id($category_id)
    {
        return $this->db->where('id',$category_id)->limit(1)->get('categories')->row();
    }

    public function create($data)
    {
        if($this->db->insert('categories',$data))
        {
            return $this->db->insert_id();
        }
        else
        {
            return FALSE;
        }
    }

    public function delete($category_id)
    {
        $this->db->delete('categories', array('id'=>$category_id));
        if($this->db->affected_rows()==0)
        {
            return FALSE;
        }
        return TRUE;
    }

}