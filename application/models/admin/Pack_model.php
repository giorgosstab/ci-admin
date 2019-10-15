<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pack_model extends CI_Model
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
        $this->db->order_by('language_name','ASC');
        $query = $this->db->get('languages');
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return FALSE;
    }

    public function get_by_id($pack_id)
    {
        return $this->db->where('id',$pack_id)->limit(1)->get('packs')->row();
    }

    public function get_all_categories_with_languages($where = NULL)
    {
        if(isset($where))
        {
            $this->db->where($where);
        }
        $this->db->select('categories.*');
        $this->db->select('packs.id as pack_id, packs.name as pack_name');
        $this->db->select('languages.slug as language_slug');
        $this->db->join('categories','packs.id = categories.pack_id','left');
        $this->db->join('languages','categories.language_id = languages.id','left');
        $this->db->order_by('packs.updated_at DESC, packs.created_at DESC');
        $this->db->order_by('language_slug');
        $query = $this->db->get('packs');
        if($query->num_rows()>0)
        {
            $categories = array();
            foreach($query->result() as $row)
            {
                if(!array_key_exists($row->pack_id, $categories)) {
                    $categories[$row->pack_id] = array('name' => $row->pack_name, 'languages' => array());
                }
                $categories[$row->pack_id]['languages'][$row->language_id] = array('language_slug'=>$row->language_slug,'translation_id'=>$row->id);

            }
            return $categories;
        }
        else
        {
            return FALSE;
        }
    }

    public function create($data)
    {
        if($this->db->insert('packs',$data))
        {
            return $this->db->insert_id();
        }
        else
        {
            return FALSE;
        }
    }

    public function delete($pack_id)
    {
        $this->db->delete('categories', array('pack_id'=>$pack_id));
        $this->db->delete('packs',array('id'=>$pack_id));
        if($this->db->affected_rows()==0)
        {
            return FALSE;
        }
        return TRUE;
    }

    public function update($pack_id, $data)
    {
        $this->db->where('id',$pack_id);
        return $this->db->update('packs',$data);
    }
}