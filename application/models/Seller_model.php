<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seller_model extends CI_Model
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
	function _delete($tb,$data) {
        if (is_array($data)){
            $this->db->where($data);
            if($this->db->update($tb,['is_deleted'=>'DELETED'])){
                return true;
            }
        }
        else{
            $this->db->where('id',$data);
            if($this->db->update($tb,['is_deleted'=>'DELETED'])){
                return true;
            }
        }
        return false;
    }

	function getData($tb,$data=0,$order=null,$order_by=null,$limit=null,$start=null) {

		if ($order!=null) {
			if ($order_by!=null) {
				$this->db->order_by($order_by,$order);
			}
			else{
				$this->db->order_by('id',$order);
			}
		}
	
		if ($limit!=null) {
			$this->db->limit($limit, $start);
		}
	
		if ($data==0 or $data==null) {
			return $this->db->get($tb)->result();
		}
		if (@$data['search']) {
			$search = $data['search'];
			unset($data['search']);
		}
		return $this->db->get_where($tb,$data)->result();
	}
	
	
	public function getAllSellers()
    {
        $this->db
        ->select('t1.*,t2.name as state_name,t3.name as city_name')
        ->from('consumers t1')
		->join('states t2','t2.id=t1.state','left')
		->join('cities t3','t3.id=t1.city','left')
		->join('consumers_company t4','t4.consumer_id=t1.id','left')
		->where('t1.is_deleted','NOT_DELETED')
		->group_by('t1.id');
		if(@$_GET['search']){ 
			$this->db->group_start();
			$this->db->like('t1.contact_person', $_GET['search']);
			$this->db->or_like('t1.mobile', $_GET['search']);
			$this->db->or_like('t1.alternet_mobile', $_GET['search']);
			$this->db->or_like('t4.gst', $_GET['search']);
			$this->db->or_like('t4.company_name', $_GET['search']);
			$this->db->group_end();
			}
		if(@$_GET['status'])
		{
			$this->db->where('t1.status',$_GET['status']);
		}
		if(@$_GET['state'])
		{
			$this->db->where('t1.state',$_GET['state']);
		}
		if(@$_GET['city'])
		{
			$this->db->where('t1.city',$_GET['city']);
		}
		return $this->db->get()->result();
    }

	public function getSellers($id)
    {
        $this->db
        ->select('t1.*,t2.name as state_name,t3.name as city_name')
        ->from('consumers t1')
		->join('states t2','t2.id=t1.state','left')
		->join('cities t3','t3.id=t1.city','left')
		->where(['t1.is_deleted'=>'NOT_DELETED','t1.id'=>$id]);
		return $this->db->get()->row_array();
    }
	

	public function get_cities_by_state($state_id) {
        $this->db->where('state_id', $state_id);
        $query = $this->db->get('cities');
        return $query->result();
    }
	public function getWithdrawals()
	{
		$start_date = $this->input->get('start_date') ?: date('Y-m-d');
		$end_date = $this->input->get('end_date') ?: date('Y-m-d');
	
		if ($this->input->get('consumer_id')) {
			$this->db->select('t1.*')
					 ->from('consumers_withdrawals t1')
					 ->where('DATE(t1.request_date) >=', $start_date)
					 ->where('DATE(t1.request_date) <=', $end_date)
					 ->where('t1.consumer_id', $this->input->get('consumer_id'));
					 if ($this->input->get('status')) {
                      $this->db->where('t1.status', $this->input->get('status'));
					 }
	
			return $this->db->get()->result();
		} else {
			return [];
		}
	}
	
	public function calculate_total_rupee($start_date, $end_date) {
        $this->db->select_sum('amount');
        $this->db->from('consumers_withdrawals');
		$this->db->where('DATE(request_date) >=', $start_date);
		$this->db->where('DATE(request_date) <=', $end_date);
        $query = $this->db->get();

        return $query->row()->amount;
    }
	public function get_parent_category($id)
	{
		$query = $this->db->get_where('categories', ['consumer_id'=>$id,'is_deleted' => 'NOT_DELETED', 'parent' => '0', 'active' => '1']);
		return $query->result();
	}
	public function check_product_name_exists($product_name) {
        $this->db->where('name', $product_name);
		$this->db->where('is_deleted','NOT_DELETED');
        $query = $this->db->get('products'); // Replace 'products' with your table name

        return $query->num_rows() > 0;
    }

	public function get_parent_id()
	{
		$query = $this->db->get_where('categories');
		return $query->row();
	}

	public function fetch_sub_categories($consumer_id,$parent_id)
	{
		$data = $this->db->get_where('categories',['consumer_id'=>$consumer_id,'parent' => $parent_id , 'is_deleted' => 'NOT_DELETED'])->result();
		echo "<option value=''>Select Sub Category</option>";
		foreach($data as $val)
		{
			echo "<option value='" . $val->id . "'>" . $val->name . "</option>";
		}
	}

	public function fetch_categories($consumer_id,$parent_id)
	{
		$data = $this->db->get_where('categories',['consumer_id'=>$consumer_id,'parent' => $parent_id , 'is_deleted' => 'NOT_DELETED'])->result();
		echo "<option value=''>Select  Category</option>";
		foreach($data as $val)
		{
			echo "<option value='" . $val->id . "'>" . $val->name . "</option>";
		}
	}

	  //Category
	  public function add_category($data)
	  {
		  $config['file_name'] = rand(10000, 10000000000);
		  $config['upload_path'] = UPLOAD_PATH . 'category/';
		  $config['allowed_types'] = 'jpg|jpeg|png|webp|svg';
		  $config['max_size'] = 200; // Max size in KB (200KB)
		  $this->load->library('upload', $config);
		  $this->upload->initialize($config);
	  
		  // Set default image paths
		  $default_image = "default.webp"; 
		  $default_thumbnail = "default_thumb.webp"; 
	  
		  if (!empty($_FILES['icon']['name'])) {
			  if ($_FILES['icon']['size'] <= 204800) { // 200KB in bytes
				  // Upload images
				  $_FILES['icons']['name'] = $_FILES['icon']['name'];
				  $_FILES['icons']['type'] = $_FILES['icon']['type'];
				  $_FILES['icons']['tmp_name'] = $_FILES['icon']['tmp_name'];
				  $_FILES['icons']['size'] = $_FILES['icon']['size'];
				  $_FILES['icons']['error'] = $_FILES['icon']['error'];
	  
				  if ($this->upload->do_upload('icons')) {
					  $image_data = $this->upload->data();
					  $new_file_name = rand(10000, 10000000000) . '.' . $image_data['file_ext'];
	  
					  if ($_FILES['icons']['type'] == 'image/webp') {
						  $img = imagecreatefromwebp(UPLOAD_PATH . 'category/' . $image_data['file_name']);
						  imagewebp($img, UPLOAD_PATH . 'category/thumbnail/' . $new_file_name, 80);
						  imagedestroy($img);
					  } else {
						  $config2 = array(
							  'image_library' => 'gd2',
							  'source_image' => UPLOAD_PATH . 'category/' . $image_data['file_name'],
							  'maintain_ratio' => true,
							  'width' => 400,
							  'height' => 500,
							  'new_image' => UPLOAD_PATH . 'category/thumbnail/' . $new_file_name,
						  );
						  $this->load->library('image_lib');
						  $this->image_lib->initialize($config2);
						  $this->image_lib->resize();
						  $this->image_lib->clear();
					  }
					  $fileName = "category/" . $new_file_name;
					  $fileName2 = "category/thumbnail/" . $new_file_name;
				  } else {
					return (object) ['res' => 'error', 'msg' => 'Image upload failed.'];
				  }
			  } else {
				return (object) ['res' => 'error', 'msg' => 'File size exceeds the maximum limit of 200 KB.'];
			  }
		  } else {
			  if (!empty($default_image) && !empty($default_thumbnail)) {
				  $fileName ="category/" . $default_image;
				  $fileName2 = "category/thumbnail/" . $default_thumbnail;
			  } else {
				return (object) ['res' => 'error', 'msg' => 'Default image not found.'];
			  }
		  }
	  
		  $data['icon'] = $fileName;
		  $data['thumbnail'] = $fileName2;
	  
		  if ($this->db->insert('categories', $data)) {
			  $insert_id = $this->db->insert_id();
			  return (object) ['res' => 'success', 'id' => $insert_id, 'msg' => 'Category added successfully.'];
		  } else {
			return (object) ['res' => 'error', 'msg' => 'Category insertion failed.'];
		  }
	  }
	  
	  
	  
	  
	  public function edit_category($data,$id)
	  {
		  $config['file_name'] = rand(10000, 10000000000);
		  $config['upload_path'] = UPLOAD_PATH.'category/';
		  $config['allowed_types'] = 'jpg|jpeg|png|webp|svg';
		  $config['max_size'] = 200; // Max size in KB (200KB)
		  $this->load->library('upload', $config);
		  $this->upload->initialize($config);
  
		   // Set default image paths
		   $default_image = "default.webp"; 
		   $default_thumbnail = "default_thumb.webp"; 

		  if (!empty($_FILES['icon']['name'])) {
			  //upload images
			  $_FILES['icons']['name'] = $_FILES['icon']['name'];
			  $_FILES['icons']['type'] = $_FILES['icon']['type'];
			  $_FILES['icons']['tmp_name'] = $_FILES['icon']['tmp_name'];
			  $_FILES['icons']['size'] = $_FILES['icon']['size'];
			  $_FILES['icons']['error'] = $_FILES['icon']['error'];
  
			  if ($this->upload->do_upload('icons')) {
		  
				  $image_data = $this->upload->data();
				  
				  if($_FILES['icons']['type']=='image/webp')
				  {
						  $img =  imagecreatefromwebp(UPLOAD_PATH.'category/'. $image_data['file_name']);
						  imagepalettetotruecolor($img);
						  imagewebp($img, UPLOAD_PATH.'category/thumbnail/'. $image_data['file_name']);
						  imagedestroy($img);
				  }
				  else
				  {
						  
						  $config2 = array(
							  'image_library' => 'gd2', //get original image
							  'source_image' =>   UPLOAD_PATH.'category/'. $image_data['file_name'],
							  'width' => 640,
							  'height' => 360,
							  'new_image' =>  UPLOAD_PATH.'category/thumbnail/'. $image_data['file_name'],
		  
						  );
						  $this->load->library('image_lib');
						  $this->image_lib->initialize($config2);
						  $this->image_lib->resize();
						  $this->image_lib->clear();
				  }
				  $fileName = "category/" . $image_data['file_name'];
				  $fileName2 = "category/thumbnail/" . $image_data['file_name'];
			  }
			  $data['icon'] = $fileName;
			  $data['thumbnail'] = $fileName2;
			  
  
			  if (!empty($fileName) && !empty($fileName2))    
			  {
				  $data1['cat_images'] = $this->seller_model->get_row_data1('categories','id',$id);
				  $cat_image = @ltrim($data1['cat_images']->icon, '/');
				  $cat_thumb = @ltrim($data1['cat_images']->thumbnail, '/');
				  if(is_file(DELETE_PATH.$cat_image))
				  {
					  unlink(DELETE_PATH.$cat_image);
				  }
				  if(is_file(DELETE_PATH.$cat_thumb))
				  {
					  unlink(DELETE_PATH.$cat_thumb); 
				  }
			  }
		  }
  
			  return $this->db->where('id', $id)->update('categories', $data);  
	  }

	  public function add_product($data)
	  {
		  $imageCount = count($_FILES['img']['name']);
		  if (!empty($imageCount)) {
			  
			  for ($i = 0; $i < $imageCount; $i++) {
				  
				  $config['file_name'] = date('Ymd') . rand(1000, 1000000);
				  $config['upload_path'] = UPLOAD_PATH.'product/';
				  $config['allowed_types'] = 'jpg|jpeg|png|gif|webp|svg';
				  $config['max_size'] = 100; // Max size in KB (200KB)
				  $this->load->library('upload', $config);
				  $this->upload->initialize($config);
				  $_FILES['imgs']['name'] = $_FILES['img']['name'][$i];
				  $_FILES['imgs']['type'] = $_FILES['img']['type'][$i];
				  $_FILES['imgs']['tmp_name'] = $_FILES['img']['tmp_name'][$i];
				  $_FILES['imgs']['size'] = $_FILES['img']['size'][$i];
				  $_FILES['imgs']['error'] = $_FILES['img']['error'][$i];

				   // Set default image paths
				$default_image = "default.webp"; 
				$default_thumbnail = "default_thumb.webp"; 

				if ($_FILES['img']['size'][$i] <= 102400) {
				  if ($this->upload->do_upload('imgs')) {
				   
					  $imageData = $this->upload->data();
					   if($_FILES['imgs']['type']=='image/webp')
						  {
								  $img =  imagecreatefromwebp(UPLOAD_PATH.'product/'. $imageData['file_name']);
								  imagewebp($img, UPLOAD_PATH.'product/thumbnail/'. $imageData['file_name'],80);
								  imagedestroy($img);
						  }
						  else
						  {
							  $config2 = array(
								  'image_library' => 'gd2', //get original image
								  'source_image' =>   UPLOAD_PATH.'product/'. $imageData['file_name'],
								  'width' => 640,
								  'height' => 360,
								  'new_image' =>  UPLOAD_PATH.'product/thumbnail/'. $imageData['file_name'],
							  );
							  $this->load->library('image_lib');
							  $this->image_lib->initialize($config2);
							  $this->image_lib->resize();
							  $this->image_lib->clear();
						  }
  
					  $images[] = "product/" . $imageData['file_name'];
					  $images2[] = "product/thumbnail/" . $imageData['file_name'];
				  }else{
					return (object) ['res' => 'error', 'msg' => 'Image upload failed.'];
				  }
			  }else{
				return (object) ['res' => 'error', 'msg' => 'File size exceeds the maximum limit of 100 KB.'];
			  }
			}
		  }
		  else {
			if (!empty($default_image) && !empty($default_thumbnail)) {
				$images[] ="product/" . $default_image;
				$images2[] = "product/thumbnail/" . $default_thumbnail;
			} else {
			  return (object) ['res' => 'error', 'msg' => 'Default image not found.'];
			}
		}
		  if (!empty($images))
		  {     
			  $this->db->insert('products', $data);
			  $insert_id = $this->db->insert_id();
			  $seq=1;foreach (array_combine($images, $images2) as $file => $file2) {
					  $file_data = array(
						  'pic' => $file,
						  'thumbnail' => $file2,
						  'product_id' => $insert_id,
						  'seq'=>$seq,
						  'alt'=>$file
					  );
					  $this->db->insert('product_pics', $file_data);
					  $seq++;
				  }
  
		  }
  
		  if ($insert_id) {
			return (object) ['res' => 'success', 'id' => $insert_id, 'msg' => 'Product added successfully.'];
		  } else {
			return (object) ['res' => 'error', 'msg' => 'Product  upload failed.'];
		  }
	  }

	  public function edit_product($data,$id)
	  {

		$imageCount = count($_FILES['img']['name']);
		if (!empty($imageCount)) {
			
			for ($i = 0; $i < $imageCount; $i++) {
				
				$config['file_name'] = date('Ymd') . rand(1000, 1000000);
				$config['upload_path'] = UPLOAD_PATH.'product/';
				$config['allowed_types'] = 'jpg|jpeg|png|gif|webp|svg';
				$config['max_size'] = 100; // Max size in KB (200KB)
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$_FILES['imgs']['name'] = $_FILES['img']['name'][$i];
				$_FILES['imgs']['type'] = $_FILES['img']['type'][$i];
				$_FILES['imgs']['tmp_name'] = $_FILES['img']['tmp_name'][$i];
				$_FILES['imgs']['size'] = $_FILES['img']['size'][$i];
				$_FILES['imgs']['error'] = $_FILES['img']['error'][$i];

				 // Set default image paths
			  $default_image = "default.webp"; 
			  $default_thumbnail = "default_thumb.webp"; 

			  if ($_FILES['img']['size'][$i] <= 102400) {
				if ($this->upload->do_upload('imgs')) {
				 
					$imageData = $this->upload->data();
					 if($_FILES['imgs']['type']=='image/webp')
						{
								$img =  imagecreatefromwebp(UPLOAD_PATH.'product/'. $imageData['file_name']);
								imagewebp($img, UPLOAD_PATH.'product/thumbnail/'. $imageData['file_name'],80);
								imagedestroy($img);
						}
						else
						{
							$config2 = array(
								'image_library' => 'gd2', //get original image
								'source_image' =>   UPLOAD_PATH.'product/'. $imageData['file_name'],
								'width' => 640,
								'height' => 360,
								'new_image' =>  UPLOAD_PATH.'product/thumbnail/'. $imageData['file_name'],
							);
							$this->load->library('image_lib');
							$this->image_lib->initialize($config2);
							$this->image_lib->resize();
							$this->image_lib->clear();
						}

					$images[] = "product/" . $imageData['file_name'];
					$images2[] = "product/thumbnail/" . $imageData['file_name'];
				}
			}
		  }
		}
		if (!empty($images))
		{     
			$this->db->delete('product_pics', array('product_id' => $id)); 
			$seq=1;foreach (array_combine($images, $images2) as $file => $file2) {
					$file_data = array(
						'pic' => $file,
						'thumbnail' => $file2,
						'product_id' => $id,
						'seq'=>$seq,
						'alt'=>$file
					);
					$this->db->insert('product_pics', $file_data);
					$seq++;
				}

		}
		  return $this->db->where('id', $id)->update('products', $data); 
	  }

	  public function add_cat_pro_map($data_cat_id){
        $this->db->insert('cat_pro_maps', $data_cat_id);
        return $this->db->insert_id();
    }
	  
	  public function get_all_categories($consumer_id)
	  {
		  $this->db->order_by('seq','ASC')->where(['consumer_id' => $consumer_id, 'is_deleted' => 'NOT_DELETED', 'parent' => '0']);
		  
		 if (isset($_GET['parent_cat']) && !empty($_GET['parent_cat'])) {
			$this->db->group_start();
			$this->db->like('id', $_GET['parent_cat']);
			$this->db->where('is_deleted','NOT_DELETED');
			$this->db->group_end();
		  }
		  
		  if (isset($_GET['search']) && !empty($_GET['search'])) {
			  $this->db->group_start();
			  $this->db->like('name', $_GET['search']);
			  $this->db->where('is_deleted','NOT_DELETED');
			  $this->db->group_end();
		  }
	  
		  return $this->db->get('categories')->result();
	  }
	  

	  public function get_categories($consumer_id)
	  {
		  $this->db->order_by('seq','asc')->where(['consumer_id'=>$consumer_id,'is_deleted' => 'NOT_DELETED']);
		  if (isset($_GET['sub_cat']) && !empty($_GET['sub_cat'])) {
			$this->db->group_start();
			$this->db->like('id', $_GET['sub_cat']);
			$this->db->or_like('parent', $_GET['sub_cat']);
			$this->db->where('is_deleted','NOT_DELETED');
			$this->db->group_end();
		  }
		  
		  if (isset($_GET['search']) && !empty($_GET['search'])) {
			  $this->db->group_start();
			  $this->db->like('name', $_GET['search']);
			   $this->db->where('is_deleted','NOT_DELETED');
			  $this->db->group_end();
		  }
		  return $this->db->get('categories')->result();
	  }

	  public function category($id)
	  {
		  $query = $this->db
		  ->select('t1.*,t2.id as subcat_id,t2.name as subcat_name,t2.parent as subcat_is_parent')
		  ->from('categories t1')
		  ->join('categories t2', 't1.parent = t2.id AND t2.parent!=0','left')        
		  ->where(['t1.is_deleted' => 'NOT_DELETED','t1.id'=>$id])
		  ->get();
		  return $query->row();
	  }



	  public function product($product_id){
		$this->db
        ->select('t1.*,t2.pic,t2.thumbnail,t2.id as cover_id,t3.title as qty_unit,t4.title as price_unit')
        ->from('products t1')
        ->join('product_pics t2', 't2.product_id = t1.id','left')
		->join('min_order_qty_types t3', 't3.id = t1.min_order_type','left')
		->join('min_order_qty_types t4', 't4.id = t1.price_type','left')
        ->where(['t1.is_deleted' => 'NOT_DELETED','t1.id'=>$product_id])
		->group_by('t1.id');
		return $this->db->get()->row();
	  }
	  public function get_cat_pro_map($id)
	  {
		  $query = $this->db
		  ->select('t1.*,t2.*')
		  ->from('cat_pro_maps t1')
		  ->join('categories t2', 't2.id = t1.cat_id','left')
		  ->where(['t1.pro_id'=>$id])
		  ->get();
		  return $query->result();
	  }
	
	  public function get_all_products($product_id,$consumer_id)
	  {
		$this->db
        ->select('t1.*,t2.pic,t2.thumbnail,t2.id as cover_id')
        ->from('products t1')
        ->join('product_pics t2', 't2.product_id = t1.id','left')
        ->where(['t1.is_deleted' => 'NOT_DELETED','t1.consumer_id'=>$consumer_id])
        ->order_by('t1.seq','desc')
		->group_by('t1.id');
		  if (!empty($product_id)) {
            $this->db->where_in('t1.id',$product_id);
            $this->db->where('t1.is_deleted','NOT_DELETED');    
		}
		  if (isset($_GET['search']) && !empty($_GET['search'])) {
			  $this->db->group_start();
			  $this->db->like('t1.name', $_GET['search']);
			  $this->db->or_like('t1.keywords', $_GET['search']);
			  $this->db->where('t1.is_deleted','NOT_DELETED');
			  $this->db->group_end();
		  }
	  
		  return $this->db->get()->result();
	  }

	  public function getWalletByDateRange($consumer_id, $startDate = null, $endDate = null)
	  {
		  $this->db
			  ->select('t1.*')
			  ->from('consumer_wallet t1')
			  ->where('t1.consumer_id', $consumer_id)
			  ->order_by('t1.date', 'desc');
	  
		  // Apply date range filters if provided
		  if ($startDate && $endDate) {
			  $this->db->where('t1.date >=', $startDate);
			  $this->db->where('t1.date <=', $endDate);
		  }
	  
		  // Apply search filter if provided
		  if (isset($_GET['search']) && !empty($_GET['search'])) {
			  $this->db->group_start();
			  $this->db->like('t1.transaction_head', $_GET['search']);
			  $this->db->group_end();
		  }
	  
		  return $this->db->get()->result();
	  }
	  


	  
	  
	  

}
