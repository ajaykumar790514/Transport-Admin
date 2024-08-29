<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct(){
		parent::__construct();
       $this->service_charges = 0;
	//    $this->check_role_menu();
       
    }

	public function template($data)
	{
		$user         = $this->checkLogin();
		$data['menu'] = $this->user_module->get_menu($user);
		$data['parm'] = $this->checkPermission();
		$data['service_charges'] = $this->service_charges;
		if (!isset($data['title'])) { $data['title'] = $data['comp']; }
		if($user->user_role==1)
		{
			$rs=$this->Model->admin_profile_pic($user->id);
			$data['comp'] = $rs->name;
		}else{
		$rs=$this->Model->vendor_profile_pic($user->id);
		$data['comp'] = $rs->contact_person_name;
		}
		if(!empty($rs->photo)){
		$data['logo'] =IMGS_URL.$rs->photo;
		}else{
			$data['logo'] =base_url('images/noimage.jpg');
		}
		
		if (!isset($data['tb_url'])){ $data['tb_url'] = ''; } 
		$data['admin_menus'] = $this->Admin_model->get_role_menu_data($user->user_role);
		$this->load->view('template',$data);
	}

	public function changeStatus($id_column=null)
	{
		$user         = $this->checkLogin();
		if ($this->input->is_ajax_request()) {
			$data = explode(',',$_POST['data']);
			$id = $data[0];
			$tb = $data[1];
			$id_column  = $data[2];
			$val_column  = $data[3];
			$update = array($val_column => $_POST['value'] );
			if ($id_column==null) {
				$cond = [$id_column => $id];
				$column = "";
			}
			else{
				$cond = [$id_column => $id];
				$column = "column='$id_column'";
			}
			$this->Model->Update($tb,$update,$cond);
			$status = $this->Model->getRow($tb,$cond)->$val_column;
			if ($status==1) {
				echo "<span class='changeStatus' onclick='changeStatus(this)' value='0' data='".$id.",".$tb."' ".$column." title='Click for chenage status' ><div class='badge badge-light-success'>Active</div></span>";
				logs($user->id,$id,'CHANGE_STATUS',$tb.'- Active');
			} 
			else{
				echo "<span class='changeStatus' onclick='changeStatus(this)' value='1' data='".$id.",".$tb." ' ".$column." title='Click for chenage status'><div class='badge badge-light-danger'>Not Active</div></span>";
				logs($user->id,$id,'CHANGE_STATUS',$tb.'- Inactive');
			}	
		}
	}

	public function change_status()
	{
		$user         = $this->checkLogin();
		if ($this->input->is_ajax_request()) {
			$data = explode(',',$_POST['data']);
			$id 	= $data[0];
			$tb 	= $data[1];
			$id_column  = $data[2];
			$val_column  = $data[3];
			$update = array($val_column => $_POST['value'] );
			$cond = [$id_column => $id];
			$column = "column='$id_column'";
			
			$this->Model->Update($tb,$update,$cond);
			$status = $this->Model->getRow($tb,$cond)->$val_column;

			if ($status==1) {
				echo "<span class='changeStatus' onclick='changeStatus(this)' value='0' data='".$_POST['data']."' title='Click for chenage status' ><div class='badge badge-light-success'>Active</div></span>";
				logs($user->id,$id,'CHANGE_STATUS',$tb.'- Active');
			} 
			else{
				echo "<span class='changeStatus' onclick='changeStatus(this)' value='1' data='".$_POST['data']."' title='Click for chenage status'><div class='badge badge-light-danger'>Not Active</div></span>";
				logs($user->id,$id,'CHANGE_STATUS',$tb.'- Inactive');
			}	
		}
	}

	function Menu_multiple_delete()
    {
		$user         = $this->checkLogin();
     if($this->input->post('checkbox_value'))
     {
        $id = $this->input->post('checkbox_value');
        $table = $this->input->post('table');
        for($count = 0; $count < count($id); $count++)
        {
            if($table == 'society_master')
            {
                $is_deleted = array('is_deleted' => 'DELETED');
                $this->db->where('socity_id', $id[$count])->update($table, $is_deleted);
            }
            else
            {
                $this->Master_model->delete_data1($table,$id[$count]);
				logs($user->id,$id[$count],'DELETE',$table.'- DELETE');
            }
        }
        
     }
    }

	function multiple_delete()
    {
		$user         = $this->checkLogin();
     if($this->input->post('checkbox_value'))
     {
        $id = $this->input->post('checkbox_value');
        $table = $this->input->post('table');
        for($count = 0; $count < count($id); $count++)
        {
            if($table == 'society_master')
            {
                $is_deleted = array('is_deleted' => 'DELETED');
                $this->db->where('socity_id', $id[$count])->update($table, $is_deleted);
            }
            else
            {
                $this->Master_model->delete_data($table,$id[$count]);
				logs($user->id,$id[$count],'DELETE',$table.'- DELETE');
            }
        }
        
     }
    }
	public function changeIndexing()
	{
		$user         = $this->checkLogin();
		if ($this->input->is_ajax_request()) {
			$data = explode(',',$_POST['data']);
			$id 	= $data[0];
			$tb 	= $data[1];
			$id_column  = $data[2];
			$val_column  = $data[3];
			$update = array($val_column => $_POST['value'] );
			$cond = [$id_column => $id];
			$this->Model->Update($tb,$update,$cond);
			logs($user->id,$id,'SEQ',$tb.'- SEQ');	
		}
	}

	public function changeStatusDispaly()
	{
		if ($this->input->is_ajax_request()) {
			$data = explode(',',$_POST['data']);
			$id = $data[0];
			$tb = $data[1];
			$ex = '';
			$update = array('display' => $_POST['value'] );
			if (@$data[2]) :
				$cond = [ $data[2] => $id];
				$ex = ','.$data[2];
			else:
				$cond = ['id' => $id];
			endif;



			$this->Model->Update($tb,$update,$cond);
			echo $this->db->last_query();
			echo $display = $this->Model->getRow($tb,$cond)->display;

			if ((int)$display==1) {
				echo "string";
				echo "<span class='changeStatusDispaly' value='0' data='".$id.",".$tb.$ex."'><i class='la la-check-circle'></i></span>";


			} 
			else{
				echo "string22";
				echo "<span class='changeStatusDispaly' value='1' data='".$id.",".$tb.$ex." '><i class='icon-close'></i></span>";
			}	
		}
	}



	public function get_states($country_id=101,$selected_id=null)
	{	
		$rows = $this->app_lib->states($country_id);
		foreach ($rows as $key => $value) {
			$selected = ($key == $selected_id) ? 'selected' : '';
			echo optionStatus($key,$value,1,$selected);
		}
		
	}

	public function get_cities($state_id=null,$selected_id=null)
	{
		
		$rows = $this->app_lib->cities($state_id);
		foreach ($rows as $key => $value) {
			$selected = ($key == $selected_id) ? 'selected' : '';
			echo optionStatus($key,$value,1,$selected);
		}
	}

	public function sub_categories($parent)
	{
		if ($parent!=0) {
			$rows = $this->app_lib->categories($parent);
			echo optionStatus('','-- Select --',1);
			foreach ($rows as $key => $value) {
				echo optionStatus($value->id,$value->name,$value->active);
			}
		}
		else{
			echo optionStatus('','-- Select Category First --',1);
		}
	}

	public function getProducts($parent_cat_id=NULL,$sub_cat_id=NULL)
	{
		if (@$parent_cat_id) {
			$rows = $this->app_lib->products($parent_cat_id,$sub_cat_id);
			echo optionStatus('','-- Select --',1);
			foreach ($rows as $key => $value) {
				echo optionStatus($value->id,$value->name,$value->active);
			}
		}
		else{
			echo optionStatus('','-- Select Category First --',1);
		}
	}

	public function product_stock($product_id,$clinic_id=null)
	{	
		if ($clinic_id==null) {
			$main_clinic = $this->app_lib->main_clinic();
			$clinic_id = $main_clinic->id;
		}
		
		$approved_urls[] = base_url('inventory');
		$approved_urls[] = base_url('appointments');
		// echo $_SERVER['HTTP_REFERER'];
		if (in_array($_SERVER['HTTP_REFERER'], $approved_urls)) {
			$query = "SELECT SUM(mtb.qty) as total_qty
						FROM shops_inventory mtb
					INNER JOIN products_subcategory p ON p.id = mtb.product_id
					WHERE p.id = $product_id
					AND p.is_deleted = 'NOT_DELETED'
					AND mtb.is_deleted = 'NOT_DELETED'
					AND mtb.shop_id = $clinic_id";
			$rows = $this->db->query($query)->result();
			echo (@$rows[0]->total_qty) ? $rows[0]->total_qty : 0;
			// echo _prx($rows);
		}
		
	}

	

	public function between_dates($start,$end)
	{
		$dateArray = array();
		$period = new DatePeriod(
			     new DateTime($start),
			     new DateInterval('P1D'),
			     new DateTime($end)
		);
		foreach($period as $date) {                 
		      $dateArray[] = $date->format('Y-m-d'); 
		}

		return $dateArray;
	}

	



	public function checkLogin(){
		$loggedin = false;
		
		if (get_cookie('63a490ed05b42') && get_cookie('63a490ed05b43') && get_cookie('63a490ed05b44')) {
			$user_id = value_encryption(get_cookie('63a490ed05b42'),'decrypt');
			$user_nm = value_encryption(get_cookie('63a490ed05b43'),'decrypt');
			$type    = value_encryption(get_cookie('63a490ed05b44'),'decrypt');
			
			if (is_numeric($user_id)) {
				$check['id'] 	   = $user_id;
				if(!is_numeric($user_nm))
				{
					$check['username'] = $user_nm;
				}else{
					$check['contact'] = $user_nm;
				}
				
				if ($type=='admin') {
					$user = $this->Model->getRow('tb_admin',$check);
					// if(!@$user){
					// 	$user = $this->Model->getRow('clinics',$check);
					// 	$user->status 	= $user->active;
					// 	$user->photo 	= $user->banner;
					// }
				}elseif ($type=='shop') {
					$user = $this->Model->getRow('shops',$check);
					// if(!@$user){
					// 	$user = $this->Model->getRow('clinics',$check);
					// 	$user->status 	= $user->active;
					// 	$user->photo 	= $user->banner;
					// }
				}
				else{
					$user = false;
				}

				if ($user) {
					if ($type=='admin') {
					if ($user->status==1) {
						$user->type = $type;
						$loggedin = true;
					}
				}elseif ($type=='shop') {
					if ($user->isActive==1) {
						$user->type = $type;
						$loggedin = true;
					}
				   }
				}
			}
		}

		if ($loggedin) {
			return $user;
		}
		else{
			delete_cookie('63a490ed05b42');	
		    delete_cookie('63a490ed05b43');	
		    delete_cookie('63a490ed05b44');	
		    redirect(base_url().'login');
		}
	}

	public function checkCookie(){
		$loggedin = false;
		if (get_cookie('63a490ed05b42') && get_cookie('63a490ed05b43') && get_cookie('63a490ed05b44')) {
			$user_id = value_encryption(get_cookie('63a490ed05b42'),'decrypt');
			$user_nm = value_encryption(get_cookie('63a490ed05b43'),'decrypt');
			if (is_numeric($user_id)) {
				$loggedin = true;
			}
		}

		if ($loggedin) {
			return true;
		}
		else{
			delete_cookie('63a490ed05b42');	
		    delete_cookie('63a490ed05b43');	
		    delete_cookie('63a490ed05b44');	
		    redirect(base_url().'login');
		}
	}

	function checkPermission(){
		$add=$update=$delete=1;

		$user=$this->checkLogin();
		$base_url = base_url();
		$current_url = current_url();
		$url=str_replace($base_url, "", $current_url);

		$url= explode('/', $url);
		if (count($url)>1) {
			$url= $url[0].'/'.$url[1];
		}
		else{
			$url = $url[0];
		}
		if($menu_id=$this->Model->getRow('tb_admin_menu', array('url' => $url,'status'=>1 ))){
			$d=array('role_id' => $user->user_role,'menu_id'=> $menu_id->id );
			if($parmission=$this->Model->getRow('tb_role_menus',$d))
			{
				$add=$parmission->add;
				$update=$parmission->update;
				$delete=$parmission->delete;
			}
		}
		$data['add']=$add;
		$data['update']=$update;
		$data['delete']=$delete;
		return $data;
	}

	public function check_role_menu(){
        $user         = $this->checkLogin();
        $admin_role_id = $user->user_role;
        $uri = $this->uri->segment(1);
        $role_menus = $this->Admin_model->all_role_menu_data($admin_role_id);
        $url_array = array();
        if(!empty($role_menus))
        {
            foreach($role_menus as $menus)
            {
                array_push($url_array,$menus->url);
            }
            if(!in_array($uri,$url_array))
            {
                redirect(base_url('logout'));
            }
            
        }
        // else
        // {
        //     redirect(base_url());
        //     exit;
        // }      
    } 

	function gen_Otp($mobile){
		$this->delete_old_otp();
		$otp=rand( 10000 , 99999 );
		$data=$this->Model->getRow('otp',array('mobile'=>$mobile));
		if ($data) {
			$otp=$data->otp;
		}
		else
		{
			$this->send_sms($otp,$mobile);
			$d=array('mobile'=>$mobile,'otp'=>$otp,'time'=>time());
			$this->Model->add('otp',$d);
		}	
	}

	function resend_Otp($mobile){
		$this->delete_old_otp();
		$otp=rand ( 10000 , 99999 );	
		$data=$this->Model->getRow('otp',array('mobile'=>$mobile));
		if ($data) {
			$otp=$data->otp;
		}
		else
		{
			$d=array('mobile'=>$mobile,'otp'=>$otp,'time'=>time());
			$this->Model->add('otp',$d);
		}	
		$this->send_sms($otp,$mobile);
		echo "Resend";
	}

	public function delete_old_otp()
	{
		$data=$this->Model->get('otp');
		foreach ($data as $row) {
			$time =  time()-(int)$row->time;
			if ($time>=900) {
				$this->Model->delete('otp',array('id' => $row->id));
			}
			
		}
	}


	function send_sms($otp,$mob)
	{
	 	file_get_contents("http://techfizone.com/send_sms?mob=".$mob."&otp=".$otp."&id=EasyCareer");
	}

	function send_email($booking_id,$type='booking')
	{	

		$b = $this->Model->getRow('booking',$booking_id);
		// echo prx($b);

		if (@$b->email) {
			$sendOk = true;
		
			if ($type=='booking') {
				$subject  = "New Booking ";
				$bodyHtml = "<p><strong>GUESTS NAME</strong> : ".$b->guest_name." </p>
							<p><strong>BOOKING FOR</strong> : ".date('D, M d, Y',strtotime($b->start_date))." - ".date('D, M d, Y',strtotime($b->end_date))." </p>
							<p><strong>CONFIRMATION CODE</strong> : ".$b->confirmation_code ."</p>
							<p><strong>MOBILE</strong> : ".$b->contact." </p>";
				if (@$b->razorpay_payment_link_id) {
				$bodyHtml .="<a href='https://razorpay.com/payment-link/".$b->razorpay_payment_link_id."'>
				            Click here to pay</a>";				
				}
			}
			elseif ($type=='extend') {
				$subject = "Booking extended ";
				$bodyHtml = "<p><strong>GUESTS NAME</strong> : ".$b->guest_name." </p>
							<p><strong>BOOKING FOR</strong> : ".date('D, M d, Y',strtotime($b->start_date))." - ".date('D, M d, Y',strtotime($b->end_date))." </p>
							<p><strong>MOBILE</strong> : ".$b->contact." </p>";

			}
			elseif ($type=='cancel') {
				$subject = "Booking cancelled ";
				$bodyHtml = "<p><strong>GUESTS NAME</strong> : ".$b->guest_name." </p>
							<p><strong>BOOKING FOR</strong> : ".date('D, M d, Y',strtotime($b->start_date))." - ".date('D, M d, Y',strtotime($b->end_date))." </p>
							<p><strong>MOBILE</strong> : ".$b->contact." </p>";

			}
			else{
				$subject = "Amazon SES test (SMTP interface accessed using PHP)";
				$bodyHtml = '<h1>Email Test</h1>
				            <p>This email was sent through the
				            <a href="https://aws.amazon.com/ses">Amazon SES</a> SMTP
				            interface using the <a href="https://github.com/PHPMailer/PHPMailer">
				            PHPMailer</a> class.</p>';
			}

			$flat = $this->Model->getRow('property',['flat_id'=>$b->flat_id]);
			$propmaster = $this->Model->getRow('propmaster',['id'=>$flat->propid]);

			$bodyHtml .="<br><br><p>".$propmaster->propname."</p><p>".$flat->flat_name."( ".$flat->flat_no." )</p><p>".$propmaster->address."</p><p>".$flat->contact_preson."</p><p>".$flat->contact_preson_mobile."</p>";

       
		}
		// die();


		if (@$sendOk) {
			$postData['to'] 		= $b->email;
			$postData['to'] 		= 'ankitv4087@gmail.com';
			// $postData['to'] 		= 'nitin.deep2008@gmail.com';
			$postData['subject'] 	= $subject;
			$postData['bodyText'] 	= "";
			$postData['bodyHtml'] 	= $bodyHtml;

	        // $postData1 = json_encode($postData);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,base_url()."mail/send");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$postData);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec($ch);
			curl_close ($ch);

		}
	}

	public function _uploadFile($path='',$file_name="file")
	{
		$directory = '../../public/uploads/'.$path.'/';
		if (base_url()=='http://localhost/sites/mrs/') {
			$directory = 'public/uploads/'.$path.'/';
		}
		$config['upload_path']          = $directory;
		$config['allowed_types'] 		= '*';
        $config['remove_spaces']        = TRUE;
        $config['encrypt_name']         = TRUE;
        $config['max_filename']         = 20;
        $this->load->library('upload', $config);
        if($this->upload->do_upload($file_name)){
        	$upload_data = $this->upload->data();
        	return img_base_url().'public/uploads/'.$path.'/'.$upload_data['file_name'];
        }
        return false;
	}
	public function _unlink_file($path,$file_name)
	{
		$directory = '../../public/uploads/'.$path.'/';
		if (base_url()=='http://localhost/sites/mrs/') {
			$directory = 'public/uploads/'.$path.'/';
		}
		unlink($directory.$file_name);
	}


	public function pr($data)
	{
		echo "<pre>";
		print_r($data);
		echo"</pre>";
		die();
	}

	public function test($amount)
	{
		echo "<img src='../../public/uploads/property-images/1617829587.jpg'>";
		$this->load->helper('file');
		$src = "../public/uploads/property-images/1617829587.jpg";  // source folder or file

		

		

		// $dest = "../public/uploads/16178295877.jpg";   // destination folder or file        
		// // echo $string = read_file('../../public/uploads/property-images/1617829587.jpg');
		// copy($src, $dest);
		// echo prx(tax_amount($amount));
	}

	public function check_duplicate($where,$column,$id=null)
	{
		$tb = $this->_get_tb($where);
        $cond[$column] = $_GET[$column];

        if(@$tb) :

            if ($id!=null) { 
            	$this->db->where('id != ',$id);
            }
            $this->db->where($column,$_GET[$column]);
            $row = $this->db->get($tb)->row();           
            echo (@$row) ? 'false' : 'true';
        else:
            echo 'true';
        endif;
	}

	public function _get_tb($type)
    {
        if ($type == 'plan-master') :
            $tb     = 'plan_master';
        elseif($type == 'relation-master') :
            $tb     = 'relation_master';
        elseif($type == 'security-question') :
            $tb     = 'security_question_master';
        elseif($type == 'language-master') :
            $tb     = 'language_master';
        else:
            $tb     = false;
        endif;

       return $tb;
    }

/////by zahid
    public function get_source($id)
	{		
		if ($id == 3) {
			$rows = $this->Model->depo();			
		}else {
			$rows = $this->Model->colliery();
		}		
		echo optionStatus('','-- Select --',1);
		foreach ($rows as $key => $value) {
			// print_r($value->id); die;
			$selected = ($value->id == $selected_id) ? 'selected' : '';
			echo optionStatus($value->id,$value->name,1,$selected);
		}
	}

	public function get_sub_colliery($id)
	{		
		$rows = $this->Model->sub_colliery($id);	
		echo optionStatus('','-- Select --',1);
		foreach ($rows as $key => $value) {
			// print_r($value->id); die;
			$selected = ($value->id == $selected_id) ? 'selected' : '';
			echo optionStatus($value->id,$value->name,1,$selected);
		}
	}

	public function get_destination($id)
	{		
		if ($id == 1) {
			$rows = $this->Model->depo();
			echo optionStatus('','-- Select --',1);
			foreach ($rows as $key => $value) {
				// print_r($value->id); die;
				$selected = ($value->id == $selected_id) ? 'selected' : '';
				echo optionStatus($value->id,$value->name,1,$selected);
			}
		}else if ($id == 4) {
			$rows = $this->Model->siding();
			echo optionStatus('','-- Select --',1);
			foreach ($rows as $key => $value) {
				// print_r($value->id); die;
				$selected = ($value->id == $selected_id) ? 'selected' : '';
				echo optionStatus($value->id,$value->name,1,$selected);
			}
		}else {
			$rows = $this->Model->customers();
			echo optionStatus('','-- Select --',1);
			foreach ($rows as $key => $value) {
				// print_r($value->id); die;
				$selected = ($value->id == $selected_id) ? 'selected' : '';
				echo optionStatus($value->id,$value->name.' ('.$value->contact.')',1,$selected);
			}
		}		
	}

	public function get_customer_address($id)
	{		
		$rows = $this->Model->customers_address($id);		
		echo optionStatus('','-- Select --',1);
		foreach ($rows as $key => $value) {
			// print_r($value->id); die;
			$address = $value->address.' '.$value->state_name.' '.$value->city_name.' '.$value->pincode;
			$selected = ($value->id == $selected_id) ? 'selected' : '';
			echo optionStatus($value->id,$address,1,$selected);
		}
	}

	public function get_customer_gst($id)
	{		
		$rows = $this->Model->customers_by_id($id);		
		foreach ($rows as $key => $value) {
			// print_r($value->id); die;
			echo '<p class="my-1"><strong>GST No.: </strong>'.$value->gst.'</p>';
		}
	}

	public function get_transporter_address($id)
	{	
		if($id){	
			$rows = $this->Model->transporters_by_id($id);		
			foreach ($rows as $key => $value) {
				// print_r($value->id); die;
				echo '<p class="mt-1"><strong>Address: </strong>'.$value->address.'</p>';
				echo '<p class="mt-1"><strong>State: </strong>'.$value->state_name.'</p>';
				echo '<p class="mt-1"><strong>City: </strong>'.$value->city_name.'</p>';
				echo '<p class="mt-1"><strong>Pincode: </strong>'.$value->pincode.'</p>';
			}
		}
	}

}

