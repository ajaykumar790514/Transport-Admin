<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Acl_model extends CI_Model
{
     function Update($tb,$data,$cond) {

		$this->db->where($cond);

	 	if($this->db->update($tb,$data)) {

	 		return true;

	 	}

	 	return false;

	}
    	function Save($tb,$data){
		if($this->db->insert($tb,$data)){
			return $this->db->insert_id();
		}
		return false; 
	}
	
	

	function Delete($tb,$data) {

		if (is_array($data)){

			$this->db->where($data);

			if($this->db->delete($tb)){

				return true;

			}

		}

		else{

			$this->db->where('id',$data);

			if($this->db->delete($tb)){

				return true;

			}

		}

		return false;

	}
    function getRow($tb,$data=0) {

		if ($data==0) {

			if($data=$this->db->get($tb)->row()){

				return $data;

			}

			else {

				return false;

			}

		}

		elseif(is_array($data)) {

			if($data=$this->db->get_where($tb, $data)){

				return $data->row();

			}

			else {

				return false;

			}

		}

		else {

			if($data=$this->db->get_where($tb,array('id'=>$data))){

				return $data->row();

			}

			else {

				return false;

			}

		}

	}
    public function admin_menu_data($limit=null,$start=null)
    {
        if ($limit!=null) {
            $this->db->limit($limit, $start);
        }
        $this->db
        ->select('t1.*')
        ->from('tb_admin_menu t1'); 
		if(@$_POST['search']){ 
		$this->db->group_start();
		$this->db->like('title', $_POST['search']);
		$this->db->or_like('parent', $_POST['search']);
		$this->db->group_end();
		}
		return $this->db->get()->result();
    }
	public function get_all_admin_menu()
    {
       
        $this->db
        ->select('t1.*')
        ->from('tb_admin_menu t1'); 
		if(@$_POST['search']){ 
		$this->db->group_start();
		$this->db->like('title', $_POST['search']);
		$this->db->or_like('parent', $_POST['search']);
		$this->db->group_end();
		}
		return $this->db->get()->result();
    }
	
    public function users_data($limit=null,$start=null)
    {
        if ($limit!=null) {
            $this->db->limit($limit, $start);
        }
        $this->db
        ->select('t1.*')
        ->from('tb_admin t1')
        ->where('is_deleted','NOT_DELETED');
		if(@$_POST['search']){ 
			$this->db->group_start();
			$this->db->like('name', $_POST['search']);
			$this->db->or_like('email', $_POST['search']);
			$this->db->or_like('mobile', $_POST['search']);
			$this->db->or_like('username', $_POST['search']);
			$this->db->group_end();
			}
		return $this->db->get()->result();
    }
	public function get_all_users()
    {
       
        $this->db
        ->select('t1.*')
        ->from('tb_admin t1')
        ->where('is_deleted','NOT_DELETED');
		if(@$_POST['search']){ 
			$this->db->group_start();
			$this->db->like('name', $_POST['search']);
			$this->db->or_like('email', $_POST['search']);
			$this->db->or_like('mobile', $_POST['search']);
			$this->db->or_like('username', $_POST['search']);
			$this->db->group_end();
			}
		return $this->db->get()->result();
    }

	
    public function user_role_data($limit=null,$start=null)
    {
        if ($limit!=null) {
            $this->db->limit($limit, $start);
        }
        $this->db
        ->select('t1.*')
        ->from('tb_user_role t1')
        ->where('is_deleted','NOT_DELETED');
		if(@$_POST['search']){ 
			$this->db->group_start();
			$this->db->like('name', $_POST['search']);
			$this->db->group_end();
			}
		return $this->db->get()->result();
    }
	public function user_role_new()
    {
      
        $this->db
        ->select('t1.*')
        ->from('tb_user_role t1')
        ->where('is_deleted','NOT_DELETED');
		if(@$_POST['search']){ 
			$this->db->group_start();
			$this->db->like('name', $_POST['search']);
			$this->db->group_end();
			}
		return $this->db->get()->result();
    }
    public function admin_menus()
	{
		// $this->db->order_by('indexing','asc');
		// if ($parent_menu!=00) {
		// 	$this->db->where('parent',$parent_menu);
		// }
			// $this->db->where('parent','0');
		return $this->db->get('tb_admin_menu')->result();
	}
    public function add_user($data)
    {
        $config['file_name'] = rand(10000, 10000000000);
        $config['upload_path'] = UPLOAD_PATH.'admin/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!empty($_FILES['photo']['name'])) {
            //upload images
            $_FILES['photos']['name'] = $_FILES['photo']['name'];
            $_FILES['photos']['type'] = $_FILES['photo']['type'];
            $_FILES['photos']['tmp_name'] = $_FILES['photo']['tmp_name'];
            $_FILES['photos']['size'] = $_FILES['photo']['size'];
            $_FILES['photos']['error'] = $_FILES['photo']['error'];

            if ($this->upload->do_upload('photos')) {
                $image_data = $this->upload->data();
                $fileName = "admin/" . $image_data['file_name'];
            }
            $data['photo'] = $fileName;
        } else {
            $data['photo'] = "";
        }
 
            return $this->db->insert('tb_admin', $data);

    }
    public function edit_user($id,$data)
    {
        $config['file_name'] = rand(10000, 10000000000);
        $config['upload_path'] = UPLOAD_PATH.'admin/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!empty($_FILES['photo']['name'])) {
            //upload images
            $_FILES['photos']['name'] = $_FILES['photo']['name'];
            $_FILES['photos']['type'] = $_FILES['photo']['type'];
            $_FILES['photos']['tmp_name'] = $_FILES['photo']['tmp_name'];
            $_FILES['photos']['size'] = $_FILES['photo']['size'];
            $_FILES['photos']['error'] = $_FILES['photo']['error'];

            if ($this->upload->do_upload('photos')) {
                $image_data = $this->upload->data();
                $fileName = "admin/" . $image_data['file_name'];
            }
            $data['photo'] = $fileName;
            if (!empty($fileName))    
            {
                $data1['user_images'] = $this->acl_model->get_row_data('tb_admin','id',$id);
                $user_image = ltrim($data1['user_images']->photo, '/');
                if(is_file(DELETE_PATH.$user_image))
                {
                    unlink(DELETE_PATH.$user_image);
                }
            }
        } 
        return $this->db->where('id', $id)->update('tb_admin', $data); 

    }
    public function get_user_roles()
	{
		$query = $this->db->get_where('tb_user_role', ['status' => '1','id!=' => '2']);
		return $query->result();
	}


public function fetch_submenu($id)
{
    $data = $this->db->get_where('tb_admin_menu',['parent' => $id , 'status' => '1'])->result();
    echo "<option value=''>Select Sub Menu</option>";
    foreach($data as $val)
    {
        echo "<option value='" . $val->id . "'>" . $val->title . "</option>";
    }
}





}



?>
