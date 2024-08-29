<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// ### checkbox ###
if (!function_exists('checkbox')) {
    function checkbox($name,$value,$title,$status=1,$checked=null) {
        ($status==0) ? $class ="class='red'" : $class ="";
        return "<label $class ><input type='checkbox' class='switchery' data-size='sm' name='$name' value='$value' $checked  >&nbsp;".$title."</label><br>";

        
    }
}
// ### checkbox ###

// ### options ###
if (!function_exists('option'))
{
    function option($value,$title,$selected='')
    {
        if ($selected==0) {
            return '<option value="'.$value.'" '.$selected.'>'.$title.' ( Not Active )</option>';
        }
        else{
            return '<option value="'.$value.'" '.$selected.'>'.$title.'</option>';
        }
    }
}

if (!function_exists('optionStatus'))
{
    function optionStatus($value,$title,$status=1,$selected='')
    {

        if ($status==0) {
            return '<option value="'.$value.'" '.$selected.' class="red">'.$title.' ( Not Active )</option>';
        }
        else{
            return '<option value="'.$value.'" '.$selected.'>'.$title.'</option>';
        }
    }
}
// ### /options ###



if ( ! function_exists('load_view'))
{
    function load_view($page_name,$data=NULL)
    {
        $CI =& get_instance();
        return $CI->load->view($page_name,$data);
    }
}



function array_encryption($data,$type='encrypt')
{
    $CI =& get_instance();
    $CI->load->library('encryption');

	$return=array();
	foreach ($data as $key => $value) {
		$return[$key] = $CI->encryption->$type($value);
	}
	return $return;
}

function value_encryption($data,$type='decrypt')
{
    $CI =& get_instance();
    $CI->load->library('encryption');
	return $CI->encryption->$type($data);
	
}

function value_encrypt($data,$type='encode')
{
    require_once APPPATH.'libraries/Encrypt.php';
    $encrypt = new CI_Encrypt();
    return $encrypt->$type($data);
}

function title($tb,$id,$id_column='id',$column=null){
    if ($column==null) {
        $column = 'name';
    }

    $CI =& get_instance();
     if($data = $CI->db->get_where($tb,[$id_column=>$id])->row()){
        return $data->$column;
    }
    else{
        return '';
    }      
}

if ( ! function_exists('cancelation_policy'))
{
    function cancelation_policy($prop_id)
    {
        $CI =& get_instance();
        $return = false;
        $query =  "SELECT mtb.* , p.descrption 
                    FROM propertypolicy mtb 
                    LEFT JOIN policy p on mtb.policy_id = p.id
                    WHERE mtb.prop_id = $prop_id AND mtb.policy_type ='cancelation'";
        if($get = $CI->db->query($query)->row()){
            $return = $get->descrption;
        }
        return $return;
    }
}


if ( ! function_exists('tax_rate'))
{
    function tax_rate($amount)
    {
        $CI =& get_instance();
        $return = false;
        $query =  "SELECT * FROM `tax_range` WHERE `from` <= $amount AND `to` >= $amount AND status = 1";
        if($get = $CI->db->query($query)->row()){
            $return = $get->tax_rate;
        }
        return $return;
    }
}


if ( ! function_exists('tax_amount'))
{
    function tax_amount($amount)
    {

        if ($rate = tax_rate($amount)) :

            $amountWithOutTax = ($amount*100)/($rate+100);

            $return['taxRate']      = $rate.' %' ;
            $return['taxAmount']    = _number_format($amount - $amountWithOutTax );
            $return['Amount']       = _number_format($amountWithOutTax);
            $return['TotalAmount']  = _number_format($amount);
        else :
            $return['taxRate']      = '' ;
            $return['taxAmount']    = 0 ;
            $return['Amount']       = _number_format($amount);
            $return['TotalAmount']  = _number_format($amount);
        endif;

        return $return;
    }
}

if ( ! function_exists('_number_format'))
{
    function _number_format($number)
    {
        return number_format($number,2,'.','');
    }
}






if ( ! function_exists('img_base_url'))
{
    function img_base_url()
    {
        $CI =& get_instance();
        return $CI->config->config['img_base_url'];
    }
}

if ( ! function_exists('prx'))
{
    function prx($v)
    {
        return '<pre>'.print_r($v, true).'</pre>';
    }
}

if ( ! function_exists('_prx'))
{
    function _prx($v)
    {
        return '<pre>'.print_r($v, true).'</pre>';
    }
}

if (! function_exists('_nf')) {
    function _nf($number)
    {
        return number_format((float)$number, 2, '.', ''); ;
    }
}

if (! function_exists('upload_file')) {
    function upload_file($directory,$filename='file')
    {

        $CI =& get_instance();
        $config['upload_path']          = 'public/uploads/'.$directory.'/';
        $config['allowed_types']        = '*';
        $config['remove_spaces']        = TRUE;
        $config['encrypt_name']         = TRUE;
        $config['max_filename']         = 10;
        $CI->load->library('upload', $config);
        if($CI->upload->do_upload($filename)){
            $upload_data = $CI->upload->data();
            return $directory.'/'.$upload_data['file_name'];
        }
        else{
            // echo _prx(['error' => $CI->upload->display_errors()]);
            return false;
        }
    }
}

if (! function_exists('delete_file')) {
    function delete_file($filename)
    {
        if (@$filename) {
            unlink('public/uploads/'.$filename);
        }
    }
}


if (! function_exists('date_time')) {
    function date_time($date)
    {
        return date('d M Y H:i A',strtotime($date));
    }
}

if (! function_exists('_date')) {
    function _date($date)
    {
        return (@$date) ? date('d M Y',strtotime($date)) : '';
    }
}

function _time($time)
{
    return (@$time) ? date('h:i A',strtotime($time)) : '';
}

function _days_diff($date1,$date2)
{
    $diff = strtotime($date2) - strtotime($date1);
    return round($diff / 86400);
}

if (!function_exists('number_to_word')) {
    function number_to_word($number){
        $no = (int)floor($number);
        $point = (int)round(($number - $no) * 100);
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array('0' => '', '1' => 'one', '2' => 'two',
         '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
         '7' => 'seven', '8' => 'eight', '9' => 'nine',
         '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
         '13' => 'thirteen', '14' => 'fourteen',
         '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
         '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
         '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
         '60' => 'sixty', '70' => 'seventy',
         '80' => 'eighty', '90' => 'ninety');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_1) {
          $divider = ($i == 2) ? 10 : 100;
          $number = floor($no % $divider);
          $no = floor($no / $divider);
          $i += ($divider == 10) ? 1 : 2;
     
     
          if ($number) {
             $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
             $hundred = ($counter == 1 && $str[0]) ? null : null;
             $str [] = ($number < 21) ? $words[$number] .
                 " " . $digits[$counter] . $plural . " " . $hundred
                 :
                 $words[floor($number / 10) * 10]
                 . " " . $words[$number % 10] . " "
                 . $digits[$counter] . $plural . " " . $hundred;
          } else $str[] = null;
       }
       $str = array_reverse($str);
       $result = implode('', $str);
     
     
       if ($point > 20) {
         $points = ($point) ?
           "" . $words[floor($point / 10) * 10] . " " . 
               $words[$point = $point % 10] : ''; 
       } else {
           $points = $words[$point];
       }
       if($points != ''){        
           echo ucwords($result . "Rupees and " . $points . " Paise Only");
       } else {
     
           echo ucwords($result . "Rupees Only");
       }
     
     }


     if (!function_exists('setting')) {
        function setting()
        {
            $CI = &get_instance();
            return $CI->Model->getRow('settings');
        }
    }

    if (!function_exists('currency')) {
        function currency()
        {
            $CI = &get_instance();
            return $CI->Model->getRow('vendors');
        }
    }
    if (!function_exists('log_authentication')) {
    function log_authentication($table, $user,$item,$action,$alias) {
        $CI =& get_instance();
        $CI->load->database();
        $route_name = get_route_name();
        $logdata = array(
          'user_id'=>$user,
          'item_id'=>$item,
          'action'=>$action,
          'url'=>$route_name,
          'alias'=>$alias,
        );
        return $CI->db->insert($table, $logdata);
    }
}

if (!function_exists('get_route_name')) {
    function get_route_name() {
        $CI =& get_instance();
        $uri_string = $CI->uri->uri_string();
       
        // $route_names = $CI->config->item('route_names');
    
        // foreach ($route_names as $route_pattern => $route_name) {
        //     if ($route_pattern === $uri_string) {
        //         return $route_name;
        //     }
        // }
    
        return $uri_string;
    }
}


}


function generate_breadcrumb($url) {
    $CI = &get_instance();
    $menu = $CI->Master_model->getRow('tb_admin_menu', ['url' => $url]);

    $breadcrumb = '<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
            ' . $menu->title . '
        </h1>';
    $breadcrumb .= '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">';
    $breadcrumb .= '<li class="breadcrumb-item text-muted"><a class="text-muted text-hover-primary" href="' . base_url('dashboard') . '">Home</a></li>';
    $breadcrumb .= '<li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>';

    if ($menu->parent == 0) {
        $breadcrumb .= '<li class="breadcrumb-item"><a href="' . base_url($url . '/' . $menu->id) . '">' . $menu->title . '</a></li>';
    } else {
        $parent_menu_item = $CI->Master_model->getRow('tb_admin_menu', ['id' => $menu->parent]);
        $parent_sub_menu_item = $CI->Master_model->getRow('tb_admin_menu', ['id' => $parent_menu_item->parent]);

        if ($parent_sub_menu_item) {
            $breadcrumb .= generate_breadcrumb_item($parent_sub_menu_item);
            $breadcrumb .= '<li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>';
        }

        $breadcrumb .= generate_breadcrumb_item($parent_menu_item);
        $breadcrumb .= '<li class="breadcrumb-item"><span class="bullet bg-gray-500 w-5px h-2px"></span></li>';
        $breadcrumb .= '<li class="breadcrumb-item active"><a href="' . base_url($url . '/' . $menu->id) . '">' . $menu->title . '</a></li>';
    }

    $breadcrumb .= '</ul></div>';
    return $breadcrumb;
}

function generate_breadcrumb_item($menu_item) {
    return '<li class="breadcrumb-item"><a href="' . base_url($menu_item->url . '/' . $menu_item->id) . '">' . $menu_item->title . '</a></li>';
}

if (!function_exists('defaultUser')) {
    function defaultUser($photo_path) {
        if (!empty($photo_path)) {
            return IMGS_URL.$photo_path;
        } else {
            return base_url('assets/media/avatars/300-1.jpg');
        }
    }
}
 
if (!function_exists('insert_consumer_log')) {

    function insert_consumer_log($logData)
    {
        $CI = &get_instance();
        $CI->load->database();
		$CI->load->library('user_agent');
		$route_name = get_route_name();
		$browser = get_browser(null, true);
		$device_brand = isset($browser['browser_name_pattern']) ? $browser['browser_name_pattern'] : 'Unknown';

		$logData['url']=$route_name;
		$logData['device_modal']=$CI->agent->platform();
		$logData['device_brand']=$device_brand;
		$logData['system_name']=php_uname('s');
		$logData['system_version']=php_uname('r');
        $CI->db->insert('consumers_logs', $logData);
        if ($CI->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('logs')) {
	function logs($user,$item,$action,$alias) {
		$table='logs';
		$CI =& get_instance();
		$CI->load->database();
		$route_name = get_route_name();
		$logdata = array(
		  'user_id'=>$user,
		  'item_id'=>$item,
		  'action'=>$action,
		  'url'=>$route_name,
		  'alias'=>$alias,
		);
		return $CI->db->insert($table, $logdata);
	}
}
if ( ! function_exists('remove_spaces')) {
	function remove_spaces($string) {
		return str_replace(' ', '', $string);
	}
}
?>
