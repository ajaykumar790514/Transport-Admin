<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset_password extends CI_Controller {

	public function reset_password()
	{
	 $data['title'] 	= 'Reset Password';
	 $this->load->view('reset-password',$data);
 
	}
	public function reset_send_otp()
{  
    $mobile = $this->input->post('mobile');
    $this->db->delete('tb_admin_otp', array('mobile' => $mobile));
    if (!empty($mobile)) {
        $check_existing_record = $this->Model->mobile_exist($mobile);
        if ($check_existing_record) {
            $otp = mt_rand(100000, 999999);
            $_SESSION['otp'] = $otp;
            $data = array(
                'otp' => $otp,
                'mobile' => $mobile,
            );

            if ($this->Model->updateRow($mobile, $data)) {
                $return['res'] = 'success';
				$return['mobile']=$mobile;
                $return['msg'] = 'OTP sent to your mobile number.';
            } else {
                $return['res'] = 'error';
                $return['msg'] = "OTP could not be generated.";    
            }
        } else {
            $return['res'] = 'error';
            $return['msg'] = "Mobile number does not exist.";
        }
    } else {
        $return['res'] = 'error';
        $return['msg'] = "Mobile number not received.";
    }
    echo json_encode($return);
    return TRUE;
}

public function verify_send_otp()
{
	$otp=$_POST['otp'];
	$mobile=$_POST['mobile_number'];
	
	if(isset($_POST['otp']) && $_POST['otp']!==''){
		  $check_existing_otp = $this->Model->admin_otp_exist($_POST['otp']); 
		  if($check_existing_otp)
		  {
			$return['res'] = 'success';
		    $return['msg'] =  "OTP Correct.....";
			$return['redirect_url'] =  base_url()."new-password/".$this->numbersToAlphabets($mobile);
		  }else{
			$return['res'] = 'error';
		    $return['msg'] =  "OTP Not Correct.....";
		  }
	}else
	{
		$return['res'] = 'error';
		$return['msg'] =  "Mobile number not received.";
	}
	echo json_encode($return);
}
public function numbersToAlphabets($input) {
    $mapping = [
        '0' => 'a',
        '1' => 'b',
        '2' => 'c',
        '3' => 'd',
        '4' => 'e',
        '5' => 'f',
        '6' => 'g',
        '7' => 'h',
        '8' => 'i',
        '9' => 'j'
    ];

    $output = "";
    foreach (str_split($input) as $char) {
        if (isset($mapping[$char])) {
            $output .= $mapping[$char];
        } else {
            $output .= $char; // keep non-digit characters unchanged
        }
    }

    return $output;
}
public function alphabetsToNumbers($input) {
    $mapping = [
        'a' => '0',
        'b' => '1',
        'c' => '2',
        'd' => '3',
        'e' => '4',
        'f' => '5',
        'g' => '6',
        'h' => '7',
        'i' => '8',
        'j' => '9'
    ];

    $output = "";
    foreach (str_split($input) as $char) {
        if (isset($mapping[$char])) {
            $output .= $mapping[$char];
        } else {
            $output .= $char; // keep non-alphabet characters unchanged
        }
    }

    return $output;
}


public function reset_update_pass()
{
	$return['res'] = 'error';
	$return['msg'] =  "Failed";
	$newpassword=$_POST['password'];
	$cpassword=$_POST['confirm-password'];
	$token=$_POST['token'];
	$mobile = $this->alphabetsToNumbers($token);
	if(isset($_POST['password']) && $_POST['password']!==''){
		$data =array(
			'password'=>$this->encryption->encrypt($newpassword),
		);
		if($this->Model->admin_update_password($mobile,$data))
		{
			$return['res'] = 'success';
			$return['msg'] =  "Password Reset successfully Login here...";
			$return['redirect_url'] =  base_url()."login/admin";

		}else
		{
			$return['res'] = 'error';
			$return['msg'] =  "Failed";
		}

	}

	echo json_encode($return);
	return TRUE;
}

public function new_password($token)
	{
	 $data['title'] 	= 'Reset Password';
	 $data['token']=$token;
	 $this->load->view('new-password',$data);
 
	}


}
