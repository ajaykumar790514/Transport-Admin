<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[\AllowDynamicProperties]
class master_model extends CI_Model
{
 
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
   // By Ajay Kumar
    public function Counter($Table, $Where = 1)
    {
        $rows = $this->Select($Table, '*', $Where);

        return count($rows);
    }
        function getRow($tb,$data=0) {

        if ($data==0) {
            if($data=$this->db->get($tb)->row()){
                return $data;
            }else {
                return false;
            }
        }elseif(is_array($data)) {
            if($data=$this->db->get_where($tb, $data)){
                return $data->row();
            }else {
                return false;
            }
        }else {
            if($data=$this->db->get_where($tb,array('id'=>$data))){
                return $data->row();
            }else {
                return false;
            }
        }

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
        function Update($tb,$data,$cond) {

        $this->db->where($cond);

        if($this->db->update($tb,$data)) {

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
    function Save($tb,$data){
		if($this->db->insert($tb,$data)){
			return $this->db->insert_id();
		}
		return false; 
	}

	public function get_daily_items()
    {
       
        $this->db
        ->select('t1.*')
        ->from('daily_items_master t1')
        ->where('t1.is_deleted','NOT_DELETED');
		if(@$_GET['search']){ 
			$this->db->group_start();
			$this->db->like('t1.title', $_GET['search']);
			$this->db->group_end();
			}
		return $this->db->get()->result();
    }

	public function get_daily_rates()
    {
       
        $this->db
        ->select('t1.*,t2.title,t3.contact_person,t4.title as type_title')
		->from('daily_items_rates t1')
        ->join('daily_items_master t2','t2.id=t1.daily_item_master_id','left')
		->join('consumers t3','t3.id=t1.consumer_id','left')
		->join('min_order_qty_types t4','t4.id=t1.rate_type','left')
        ->where('t1.is_deleted','NOT_DELETED');
		if(@$_GET['search']){ 
			$this->db->group_start();
			$this->db->like('t2.title', $_GET['search']);
			$this->db->or_like('t1.rate', $_GET['search']);
			$this->db->group_end();
			}
		return $this->db->get()->result();
    }

	public function get_features()
    {
       
        $this->db
        ->select('t1.*')
		->from('features_master t1')
        ->where('t1.is_deleted','NOT_DELETED');
		if(@$_GET['search']){ 
			$this->db->group_start();
			$this->db->like('t1.title', $_GET['search']);
			$this->db->group_end();
			}
		return $this->db->get()->result();
    }

	public function get_packages()
    {
       
        $this->db
        ->select('t1.*')
		->from('package_master t1')
        ->where('t1.is_deleted','NOT_DELETED')
		->order_by('t1.seq','ASC');
		if(@$_GET['search']){ 
			$this->db->group_start();
			$this->db->like('t1.name', $_GET['search']);
			$this->db->group_end();
			}
		return $this->db->get()->result();
    }

	public function get_timings()
	{
		$this->db
			->select('t1.*')
			->from('booking_timings t1')
			->order_by("FIELD(t1.day, 'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun')");
	
		if (@$_GET['search']) {
			$this->db->group_start();
			$this->db->like('t1.day', $_GET['search']);
			$this->db->group_end();
		}
	
		return $this->db->get()->result();
	}
	

	
	public function fetch_cities($state)
	{
		$data = $this->db->get_where('cities',['state_id'=>$state, 'is_deleted' => 'NOT_DELETED'])->result();
		echo "<option value=''>Select City</option>";
		foreach($data as $val)
		{
			echo "<option value='" . $val->id . "'>" . $val->name . "</option>";
		}
	}
	
	
	
	public function getTransporterRow($id)
    {
		$this->db
        ->select('t1.*,t4.title as minimum_load_types,t2.name as state_name,t3.name as city_name')
		->from('transporter t1')
		->join('states t2','t2.id=t1.state','left')
		->join('cities t3','t3.id=t1.city','left')
		->join('min_order_qty_types t4','t4.id=t1.minimum_load_type','left')
        ->where('t1.is_deleted','NOT_DELETED')
		->where('t1.id',$id);
		return $this->db->get()->row();
    }
	public function get_transporters()
    {
		$this->db
        ->select('t1.*,t4.title as minimum_load_types,t2.name as state_name,t3.name as city_name')
		->from('transporter t1')
		->join('states t2','t2.id=t1.state','left')
		->join('cities t3','t3.id=t1.city','left')
		->join('min_order_qty_types t4','t4.id=t1.minimum_load_type','left')
        ->where('t1.is_deleted','NOT_DELETED');
		if(@$_GET['search']){ 
			$this->db->group_start();
			$this->db->like('t1.company_name', $_GET['search']);
			$this->db->or_like('t1.mobile_number', $_GET['search']);
			$this->db->or_like('t1.email', $_GET['search']);
			$this->db->group_end();
			}
		return $this->db->get()->result();
    }

	

	


}

?>
