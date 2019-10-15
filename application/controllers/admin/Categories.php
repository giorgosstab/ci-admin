<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->model('admin/category_model');
		$this->load->model('admin/language_model');
		$this->load->model('admin/pack_model');
	}

	public function index()
	{
		echo $this->session->flashdata('message');
		$this->data['languages'] = $this->language_model->get_all();
		$this->data['categories'] = $this->pack_model->get_all_categories_with_languages();
		$this->render('admin/categories/index_view');
	}

	public function create($pack_id = NULL, $language_id = NULL)
	{
		$pack_id = isset($pack_id) ? $pack_id : '0';
		$created_translations = array();
		if($pack_id != '0')
		{
			if($category_translations = $this->category_model->get_all(array('pack_id'=>$pack_id)))
			{
				foreach ($category_translations as $translation)
				{
					$created_translations[] = $translation->language_id;
				}
			}
		}
		$this->data['pack_id'] = $pack_id;
		if($pack_id != '0')
		{
			$pack = $this->pack_model->get_by_id($pack_id);
			$order = $pack->order;
			$parent_id = $pack->parent_id;
		}
		else
		{
			$order = '0';
			$parent_id = '0';
		}
		$this->data['order'] = $order;
		$this->data['parent_id'] = $parent_id;

		$langs = array('0'=>'No language set');
		$default_language = '0';
		if($languages = $this->language_model->get_all())
		{
			foreach($languages as $language)
			{
				if($language->default == '1') $default_language = $language->id;
				if(!in_array($language->id,$created_translations)) $langs[$language->id] = $language->language_name;
			}
		}
		if(isset($language_id)) $default_language = $language_id;
		$categs = array('0'=>'No parent category');
		if($categories  = $this->category_model->get_all(array('language_id'=>$default_language)))
		{
			foreach($categories as $category)
			{
				$categs[$category->pack_id] = $category->name;
			}
		}
		$this->data['languages'] = $langs;
		$this->data['categories'] = $categs;
		$this->data['default_language'] = $default_language;
		$this->form_validation->set_rules('language_id','Language','trim|is_natural|required|exists[languages.id]');
		$this->form_validation->set_rules('parent_id','Parent id','trim|is_natural|required');
		$this->form_validation->set_rules('name','Category name','trim|required');
		$this->form_validation->set_rules('description','Category description','trim');
		$this->form_validation->set_rules('slug','Category slug','trim');
		$this->form_validation->set_rules('order','Order','trim|is_natural|required');
		$this->form_validation->set_rules('pack_id','Category id','trim|is_natural|required');
		if($this->form_validation->run() === FALSE)
		{
			$this->render('admin/categories/create_view');
		}
		else
		{
			$datetime = date('Y-m-d H:i:s');
			$pack_id = $this->input->post('pack_id');
			$language_id = $this->input->post('language_id');
			$parent_id = $this->input->post('parent_id');
			$name = $this->input->post('name');
			$description = $this->input->post('description');
			$slug = (strlen($this->input->post('slug'))>0) ? url_title($this->input->post('slug'),'-',TRUE) : url_title($name,'-',TRUE);
			$order = $this->input->post('order');

			if($pack_id == '0')
			{
				$pack_id = $this->pack_model->create(array(
						'name' => $name,
						'order' => $order,
						'type' => 'category',
						'parent_id' => $parent_id,
						'created_at' => $datetime,
						'created_by' => $this->data['current_user']->id
						)
					);
			}
			$category_id = $this->category_model->create(array(
				'pack_id' => $pack_id,
				'language_id' => $language_id,
				'name' => $name,
				'description' => $description,
				'slug' => $slug
			));
			if($category_id)
			{
				$this->session->set_flashdata('message','Category added successfully');
			}
			redirect('admin/categories','refresh');
		}
	}

	public function edit($category_id = NULL)
	{
		$category_id = isset($category_id) ? $category_id : $this->input->post('category_id');
		$category = $this->category_model->get_by_id($category_id);
		$this->data['category'] = $category;

		$pack = $this->pack_model->get_by_id($category->pack_id);
		$order = $pack->order;
		$parent_id = $pack->parent_id;
		$this->data['order'] = $order;
		$this->data['parent_id'] = $parent_id;

		$translations = $this->category_model->get_all(array('pack_id'=>$category->pack_id));
		$translation_exists = array();
		foreach($translations as $translation)
		{
			$translation_exists[] = $translation->language_id;
		}

		$langs = array();
		if($languages = $this->language_model->get_all())
		{
			foreach($languages as $language)
			{
				if(!in_array($language->id, $translation_exists) || ($language->id == $category->language_id)) $langs[$language->id] = $language->language_name;
			}
		}
		$categs = array('0'=>'No parent category');
		if($categories  = $this->category_model->get_all(array('language_id'=>$category->language_id,'pack_id != '=>$category->pack_id)))
		{
			foreach($categories as $category)
			{
				$categs[$category->pack_id] = $category->name;
			}
		}
		$this->data['languages'] = $langs;
		$this->data['categories'] = $categs;
		$this->data['default_language'] = $category->language_id;
		$this->form_validation->set_rules('language_id','Language','trim|is_natural|required|exists[languages.id]');
		$this->form_validation->set_rules('parent_id','Parent id','trim|is_natural|required');
		$this->form_validation->set_rules('name','Category name','trim|required');
		$this->form_validation->set_rules('description','Category description','trim');
		$this->form_validation->set_rules('slug','Category slug','trim');
		$this->form_validation->set_rules('order','Order','trim|is_natural|required');
		$this->form_validation->set_rules('pack_id','Category id','trim|is_natural|required');
		if($this->form_validation->run() === FALSE)
		{
			$this->render('admin/categories/edit_view');
		}
		else
		{
			$datetime = date('Y-m-d H:i:s');
			$pack_id = $this->input->post('pack_id');
			$language_id = $this->input->post('language_id');
			$parent_id = $this->input->post('parent_id');
			$name = $this->input->post('name');
			$description = $this->input->post('description');
			$slug = (strlen($this->input->post('slug'))>0) ? url_title($this->input->post('slug'),'-',TRUE) : url_title($name,'-',TRUE);
			$order = $this->input->post('order');

			if($this->pack_model->update($pack_id, array('order' => $order,'parent_id' => $parent_id,'updated_at' => $datetime,'updated_by' => $this->data['current_user']->id)))
			{
				$category_id = $this->category_model->create(array(
					'pack_id' => $pack_id,
					'language_id' => $language_id,
					'name' => $name,
					'description' => $description,
					'slug' => $slug
				));
			}

			if($category_id)
			{
				$this->session->set_flashdata('message','Category translation updated successfully');
			}
			redirect('admin/categories','refresh');
		}
	}


	public function edit_pack($pack_id = NULL)
	{
		$pack_id = isset($pack_id) ? $pack_id : $this->input->post('pack_id');
		$pack = $this->pack_model->get_by_id($pack_id);

		$this->data['pack'] = $pack;
		$order = $pack->order;
		$parent_id = $pack->parent_id;
		$this->data['order'] = $order;
		$this->data['parent_id'] = $parent_id;

		$default_language = $this->language_model->get_all(array('default'=>'1'));

		$categs = array('0'=>'No parent category');
		if($categories  = $this->category_model->get_all(array('language_id'=>$default_language->id, 'pack_id != '=>$pack->id)))
		{
			foreach($categories as $category)
			{
				$categs[$category->pack_id] = $category->name;
			}
		}
		$this->data['categories'] = $categs;
		$this->data['default_language'] = $category->language_id;
		$this->form_validation->set_rules('parent_id','Parent id','trim|is_natural|required');
		$this->form_validation->set_rules('name','Category name','trim|required');
		$this->form_validation->set_rules('order','Order','trim|is_natural|required');
		$this->form_validation->set_rules('pack_id','Category id','trim|is_natural|required');
		if($this->form_validation->run() === FALSE)
		{
			$this->render('admin/categories/edit_pack_view');
		}
		else
		{
			$datetime = date('Y-m-d H:i:s');
			$pack_id = $this->input->post('pack_id');
			$parent_id = $this->input->post('parent_id');
			$name = $this->input->post('name');
			$order = $this->input->post('order');

			if($this->pack_model->update($pack_id, array('name' => $name, 'order' => $order,'parent_id' => $parent_id,'updated_at' => $datetime,'updated_by' => $this->data['current_user']->id)))
			{
				$this->session->set_flashdata('message','Category updated successfully');
			}
			redirect('admin/categories','refresh');
		}
	}


	public function delete($id_category)
	{
		if($this->category_model->delete($id_category) === FALSE)
		{
			$this->session->set_flashdata('message','Couldn\' delete category translation');
		}
		else
		{
			$this->session->set_flashdata('message','Category translation deleted successfully');
		}
		redirect('admin/categories','refresh');
	}
	public function delete_pack($id_pack)
	{
		if($this->pack_model->delete($id_pack) === FALSE)
		{
			$this->session->set_flashdata('message','Couldn\' delete category');
		}
		else
		{
			$this->session->set_flashdata('message','Category deleted successfully');
		}
		redirect('admin/categories','refresh');
	}
}