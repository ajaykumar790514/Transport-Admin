<?php
/**
 * 
 */
class Model extends CI_Model
{
	
	public function admin_menus($parent_menu=00)
	{
		$this->db->order_by('indexing','asc');
		if ($parent_menu!=00) {
			$this->db->where('parent',$parent_menu);
		}
		return $this->db->get('tb_admin_menu')->result();
	}
    // BY AJAY KUMAR
      /*
     *  Select Records From Table
     */
    public function Select($Table, $Fields = '*', $Where = 1)
    {
        /*
         *  Select Fields
         */
        if ($Fields != '*') {
            $this->db->select($Fields);
        }
        /*
         *  IF Found Any Condition
         */
        if ($Where != 1) {
            $this->db->where($Where);
        }
        /*
         * Select Table
         */
        $query = $this->db->get($Table);

        /*
         * Fetch Records
         */

        return $query->result();
    }
   /*
     * Count No Rows in Table
     */
    public function Counter($Table, $Where = 1)
    {
        $rows = $this->Select($Table, '*', $Where);

        return count($rows);
    }

	
	public function vendor_profile_pic($id)
	{
		$this->db->select("mtb.*");
		$this->db->from('vendors mtb');
		$this->db->where(['mtb.is_deleted'=>'NOT_DELETED','id'=>$id]);
		return $this->db->get()->row();
	}
	public function admin_profile_pic($id)
	{
		$this->db->select("mtb.*");
		$this->db->from('tb_admin mtb');
		$this->db->where(['mtb.status'=>'1','id'=>$id]);
		return $this->db->get()->row();
	}


// main functions
	
function Save($tb,$data){
	if($this->db->insert($tb,$data)){
		return $this->db->insert_id();
	}
	return false; 
}
function Save_Batch($tb,$data){
	if($this->db->insert_batch($tb,$data)){
		return $this->db->insert_id();
	}
	return false; 
}

public function save_day($tb, $data=array())
{
	if($this->db->insert($tb,$data)){
		return $this->db->insert_id();
	}
	return false; 
}

function SaveGetId($tb,$data){
	 if($this->db->insert($tb,$data)){
		 return $this->db->insert_id();
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

function Update($tb,$data,$cond) {
	$this->db->where($cond);
	 if($this->db->update($tb,$data)) {
		 return true;
	 }
	 return false;
}
function UpdateData($tb,$data,$cond) {
	$this->db->where('id',$cond);
	 if($this->db->update($tb,$data)) {
		 return true;
	 }
	 return false;
}
function UpdateDate($tb,$data,$cond) {
	$this->db->where('day',$cond);
	 if($this->db->update($tb,$data)) {
		 return true;
	 }
	 return false;
}
function UpdateService($tb,$data,$cond) {
	$this->db->where('services_id',$cond);
	 if($this->db->update($tb,$data)) {
		 return true;
	 }
	 return false;
}
// By ajay Kumar Update Vendor Id wise
function UpdateVendor($tb,$data,$cond) {
	$this->db->where('vendors_id',$cond);
	 if($this->db->update($tb,$data)) {
		 return true;
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
		$this->db->where('id ',$data);
		if($this->db->delete($tb)){
			return true;
		}
	}
	return false;
}

function DeleteDay($tb,$data) {
	
		$this->db->where('day !=',$data);
		if($this->db->delete($tb)){
			return true;
		}
	
	return false;
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

public function mobile_exist($mobile)
	{
		//echo $mobile;die();
		$this->db->select("mtb.*")
		->from('tb_admin mtb')
		->where(['mtb.mobile'=>$mobile, 'mtb.status'=>'1']);
	
		return $this->db->get()->num_rows();
		
	}
	function updateRow($mobile,$data ){
		if($this->db->insert('tb_admin_otp',$data)){
			return $this->db->insert_id();
		}
		return false; 
	}

	public function admin_otp_exist($otp)
	{
		//echo $mobile;die();
		$this->db->select("mtb.*")
		->from('tb_admin_otp mtb')
		->where(['mtb.otp'=>$otp]);
	
		return $this->db->get()->num_rows();
		
	}
	public function admin_update_password($mobile,$data)
	{
		return $this->db->where('mobile', $mobile)->update('tb_admin', $data);
	}

}
