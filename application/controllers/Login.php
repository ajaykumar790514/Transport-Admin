<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
class Login extends Main {

	public function index($type='admin')
	{	
		if ($this->input->server('REQUEST_METHOD')=='POST') {
			if (!$_POST['username'] or !$_POST['password']) {
				$return['res'] = 'error';
				$return['msg'] = 'Please Enter Username & Password !';
				echo json_encode($return); die();
			}
			
			$check['username'] = $_POST['username'];
			$type = $_POST['type'];
			if (@$_POST['type']=='admin') {
				$user = $this->Model->getRow('tb_admin',$check);
				$user_password = $this->encryption->decrypt(@$user->password);
			}
			else{
				$user = false;
			}
			if ($user) {
				if ($user->status==1) {
					if ($_POST['password']==$user_password) {
						logs($user->id,$user->id,'LOGIN','Admin Login');
						$user = array_encryption($user);
						$type = value_encryption($type,'encrypt');
						set_cookie('63a490ed05b42',$user['id'],8000*24*30);
						set_cookie('63a490ed05b43',$user['username'],8000*24*30);
						set_cookie('63a490ed05b44',$type,8000*24*30);
						$return['res'] = 'success';
						$return['msg'] = 'Login Successful Please Wait Redirecting...';
						$return['redirect_url'] = base_url();
						
					}
					else {
						$return['res'] = 'error';
						$return['msg'] = 'Incorrect Password';
					}
				}
				else {
					$return['res'] = 'error';
					$return['msg'] = 'Account Temporarily Disabled!';
				}
			}
			else {
				$return['res'] = 'error';
				$return['msg'] = 'User Not Found!';
			}
			echo json_encode($return);

		}
		else{
			$data['title'] 	= 'Login';
			$data['type']	=	$type;
			load_view('login',$data);
		}
	}
	public function seller_login($type='seller')
	{
		
		if ($this->input->server('REQUEST_METHOD')=='POST') {

			if (!$_POST['username'] or !$_POST['password']) {
				$return['res'] = 'error';
				$return['msg'] = 'Please Enter Username & Password !';
				echo json_encode($return); die();
			}
			
			$check['contact'] = $_POST['username'];
			$type = $_POST['type'];
			if (@$_POST['type']=='seller') {
				$user = $this->Model->getRow('shops',$check);
				$user_password = $this->encryption->decrypt(@$user->password);
			}
			else{
				$user = false;
			}

			if ($user) {
				if ($user->isActive==1) {
					if ($_POST['password']==$user_password) {
						logs($user->id,$user->id,'LOGIN','Seller Login');
						$user = array_encryption($user);
						$type = value_encryption($type,'encrypt');
						set_cookie('63a490ed05b42',$user['id'],8000*24*30);
						set_cookie('63a490ed05b43',$user['contact'],8000*24*30);
						set_cookie('63a490ed05b44',$type,8000*24*30);
						$return['res'] = 'success';
						$return['msg'] = 'Login Successful Please Wait Redirecting...';
						$return['redirect_url'] = base_url();
					}
					else {
						$return['res'] = 'error';
						$return['msg'] = 'Incorrect Password';
					}
				}
				else {
					$return['res'] = 'error';
					$return['msg'] = 'Account Temporarily Disabled!';
				}
			}
			else {
				$return['res'] = 'error';
				$return['msg'] = 'User Not Found!';
			}
			echo json_encode($return);

		}
		else{
			$data['title'] 	= 'Login';
			$data['type']	=	$type;
			load_view('login',$data);
		}
	}
    public function login_remote($type,$id=null,$column='username')
    {
        if ($type=='shop') {
            $tb = 'shops';
        }
        else{

        }
        $this->db->where($column,$_GET[$column]);
        if($id!=NULL){
            $this->db->where('id != ',$id);
        }
        $count=$this->db->count_all_results($tb);
        if($count>0)
        {
            echo "false";
        }
        else
        {
            echo "true";
        }        
    }
	public function admin_mobile_otp()
	{  
		 
		$mobile=$_POST['mobile'];
		
		$this->db->delete('tb_admin_otp', array('mobile' => $mobile));
		if(isset($_POST['mobile']) && $_POST['mobile']!==''){
			//$check_existing_record = $this->Model->getRows(array('conditions'=>array('contact_number'=>$_POST['mobile'],'active'=>'1')));
			$check_existing_record = $this->Model->admin_mobile_exist($_POST['mobile']);
		   
			if($check_existing_record){
			    $otp=mt_rand(100000, 999999);
				$_SESSION['otp']  = $otp;
				$data =array(
				      'otp'=>$otp,
					  'mobile'=>$_POST['mobile'],
				);

				if($this->Model->adminupdateRow($mobile,$data))
				{
					//code to send the otp to the mobile number will be placed here
					if(TRUE)
					{
						$return['res'] = 'success';
						$return['msg'] = 'Otp Send Your Mobile Number';
					}
					else
					{
						$return['res'] = 'error';
						$return['msg'] = "Message could not be sent.";	
					}
				}
				else
				{
					$return['res'] = 'error';
						$return['msg'] = "Otp could not be generated.";	
				}
			}
			else
			{
				$return['res'] = 'error';
			    $return['msg'] =  "Mobile number does not exist.";
			}
		}
		else
		{
			$return['res'] = 'error';
	    	$return['msg'] =  "Mobile number not received.";
		}
		echo json_encode($return);
		return TRUE;
	}
	public function admin_check_otp()
	{
		$otp=$_POST['otp'];
		if(isset($_POST['otp']) && $_POST['otp']!==''){
			
			  $check_existing_otp = $this->Model->admin_otp_exist($_POST['otp']); 
			  if($check_existing_otp)
			  {
				$return= 1;
			  }else{
				$return= 0;
			  }

		}else
		{
			$return['res'] = 'error';
	    	$return['msg'] =  "Mobile number not received.";
		}
		echo json_encode($return);
		return TRUE;
		
	}
	public function admin_update_pass()
	{
		$newpassword=$_POST['newpassword'];
		$cpassword=$_POST['cpassword'];
		$mobile=$_POST['mobile'];
		if(isset($_POST['newpassword']) && $_POST['newpassword']!==''){
			$data =array(
             'password'=>$this->encryption->encrypt($newpassword),
			);
			if($this->Model->admin_update_password($mobile,$data))
			{
				$return['res'] = 'success';
	    	    $return['msg'] =  "Password Reset successfully";

			}else
			{
				$return['res'] = 'error';
	    	    $return['msg'] =  "Failed";
			}

		}
	
		echo json_encode($return);
		return TRUE;
	}
	public function shop_check_otp()
	{
		$otp=$_POST['otp'];
		if(isset($_POST['otp']) && $_POST['otp']!==''){
			
			  $check_existing_otp = $this->Model->otp_exist($_POST['otp']); 
			  if($check_existing_otp)
			  {
				$return= 1;
			  }else{
				$return= 0;
			  }

		}else
		{
			$return['res'] = 'error';
	    	$return['msg'] =  "Mobile number not received.";
		}
		echo json_encode($return);
		return TRUE;
		
	}

	public function shop_update_pass()
	{
		$newpassword=$_POST['newpassword'];
		$cpassword=$_POST['cpassword'];
		$mobile=$_POST['mobile'];
		if(isset($_POST['newpassword']) && $_POST['newpassword']!==''){
			$data =array(
             'password'=>$newpassword,
			);
			if($this->Model->update_password($mobile,$data))
			{
				$return['res'] = 'success';
	    	    $return['msg'] =  "Password forgot successfully";

			}else
			{
				$return['res'] = 'error';
	    	    $return['msg'] =  "Failed";
			}

		}
	
		echo json_encode($return);
		return TRUE;
	}
	
	public function logout()
	{
		$user_id = value_encryption(get_cookie('63a490ed05b42'),'decrypt');
		delete_cookie('63a490ed05b42');	
		delete_cookie('63a490ed05b43');	
		delete_cookie('63a490ed05b44');	
		logs($user_id,$user_id,'LOGOUT','Admin Logout');
		redirect(base_url());
	}
	public function shop_logout()
	{
		$user_id = value_encryption(get_cookie('63a490ed05b42'),'decrypt');
		delete_cookie('63a490ed05b42');	
		delete_cookie('63a490ed05b43');	
		delete_cookie('63a490ed05b44');	
		logs($user_id,$user_id,'LOGOUT','Seller Logout');
		redirect(base_url('shop-login'));
	}


 

	
	
	
}
