<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
class Master extends Main {

    public function index()
    {
		$data['title'] = 'ACL';
		$data['contant'] = 'admin/master/master_data';
		$data['user']=$user         = $this->checkLogin();
        $menu_id = $this->uri->segment(2);
        $data['menu_id'] = $menu_id;
		$role_id = $user->user_role;
        $data['sub_menus'] = $this->Admin_model->get_submenu_data($menu_id,$role_id);
		$data['menu_url'] = $this->uri->segment(1);
        $data['breadcrumb']    = generate_breadcrumb($data['menu_url']);
		$this->template($data);
       
    }

	public function remote($type,$id=null,$column='name')
    {
        if ($type=='daily_items_master') {
            $tb = 'daily_items_master';
        }
        elseif ($type=='features') {
            $tb ='features_master';
        }elseif($type=='package'){
			$tb ='package_master';
		}elseif($type=='timings')
		{
			$tb ='booking_timings';
		}elseif($type=='transporter')
		{
			$tb ='transporter';
		}
        
        else{

        }
        $this->db->where($column,$_GET[$column]);
        if($id!=NULL){
            $this->db->where('id != ',$id)->where('is_deleted','NOT_DELETED');
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

	public function day_remote($type,$id=null,$column='name')
    {
      if($type=='timings')
		{
			$tb ='booking_timings';
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
	public function daily_items($action=null,$p1=null,$p2=null,$p3=null)
    {
        $user         = $this->checkLogin();
        switch ($action) {
            case null:
				$data['title'] = 'Daily Items Master';
				$data['contant'] = 'admin/master/rate/daily_items/index';
				$data['user']=$user         = $this->checkLogin();
				$data['menu_url'] = $this->uri->segment(1);
				$data['breadcrumb']    = generate_breadcrumb($data['menu_url']);
                $data['new_url']        = base_url().'daily-items-master/create';
				$data['scripts'] = [
				'admin/master/rate/daily_items/index',
				];	
				$this->template($data);
                break;
				case 'get_daily_items':
					$items = $this->Master_model->get_daily_items();
					$data = array();
					$i = 1;
					foreach ($items as $item) {
						$status = ($item->active == 1)
							? '<div class="badge badge-light-success">Active</div>'
							: '<div class="badge badge-light-danger">Not Active</div>';
						$status = '<span class="changeStatus" data-toggle="change-status" value="' . ($item->active == 1 ? 0 : 1) . '" data="' . $item->id . ',daily_items_master,id,active" title="Click to change status">' . $status . '</span>';
				
						$action = '<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#showModal" data-whatever="Update Daily Items (' . $item->title . ')" data-url="' . base_url() . 'daily-items-master/create/' . $item->id . '">
							<i class="fa fa-edit new-font-icon text-primary"></i>
							</a>
							<a href="javascript:void(0)" class="ms-3" data-kt-daily-items-table-filter="delete_row" url="' . base_url() . 'daily-items-master/delete/' . $item->id . '" title="Delete Daily Items">
							<i class="fa fa-trash new-font-icon text-primary"></i>
							</a>';
				
						$data[] = array(
							$i,
							$item->title,
							$item->description,
							$status,
							$action,
							$item->id,
						);
						$i++;
					}
				
					echo json_encode(array('data' => $data));
					break;
					
                case 'create':
                    $data['remote']             = base_url().'master-data/remote/daily_items_master/';
                    $data['action_url']         = base_url().'daily-items-master/save';
                    $page                       = 'admin/master/rate/daily_items/create';
                    if ($p1!=null) {
                        $data['remote']             = base_url().'master-data/remote/daily_items_master/'.$p1;
                        $data['action_url']     = base_url().'daily-items-master/save/'.$p1;
                        $data['value']          = $this->Master_model->getRow('daily_items_master',['id'=>$p1]);
                        $page                   = 'admin/master/rate/daily_items/update';
                    }
                    $this->load->view($page, $data);
                    break;
               
                    case 'save':
                        $id = $p1;
                        $return['res'] = 'error';
                        $return['msg'] = 'Not Saved!';

                        if ($this->input->server('REQUEST_METHOD')=='POST') {
                            if ($id!=null) {
                                $data = array(
                                  'title'     => $this->input->post('title'),
                                    'description'     => $this->input->post('description'),
                                    );
                                if($this->Master_model->Update('daily_items_master',$data,['id'=>$id])){
									logs($user->id,$id,'EDIT','Edit Daily Items Master');
                                    $return['res'] = 'success';
                                    $return['msg'] = 'Updates Daily Items Master.';
                                }
                            }
                            else{
                                $data = array(
                                    'title'     => $this->input->post('title'),
                                    'description'     => $this->input->post('description'),
                                    );
                                if ($id=$this->Master_model->Save('daily_items_master',$data)) {
									logs($user->id,$id,'ADD','Add Daily Items Master');
                                    $return['res'] = 'success';
                                    $return['msg'] = 'Add Daily Items Master.';
                                }
                            }
                        }
                        echo json_encode($return);
                        break;
                        case 'delete':
                            if($this->Master_model->_delete('daily_items_master',['id'=>$p1]))
                            {
								logs($user->id,$p1,'DELETE','Delete Daily Items Master');
                                $return['res'] = 'success';
                                $return['msg'] = 'Delete Daily Items Master.';
                            }
                            echo json_encode($return);
                  break; 
				 case 'delete_selected':
					if (!$this->input->is_ajax_request()) {
						exit('No direct script access allowed');
					}
					$ids = $this->input->post('ids');
				
					if (!empty($ids)) {
						foreach ($ids as $id) {
						 $this->Master_model->_delete('daily_items_master',['id'=>$id]);
						 logs($user->id,$id,'DELETE','Delete Daily Items Master');
						}
						echo json_encode(array('res' => 'success', 'msg' => 'Selected daily items master deleted successfully.'));
					} else {
						echo json_encode(array('res' => 'error', 'msg' => 'Selected daily items master not deleted .'));
					}
			   break;		
        }
    }

	public function daily_rates($action=null,$p1=null,$p2=null,$p3=null)
    {
        $user         = $this->checkLogin();
        switch ($action) {
            case null:
				$data['title'] = 'Daily Items Rates';
				$data['contant'] = 'admin/master/rate/daily_rates/index';
				$data['user']=$user         = $this->checkLogin();
				$data['menu_url'] = $this->uri->segment(1);
				$data['breadcrumb']    = generate_breadcrumb($data['menu_url']);
                $data['new_url']        = base_url().'daily-items-rates/create';
				$data['scripts'] = [
				'admin/master/rate/daily_rates/index',
				];	
				$this->template($data);
                break;
				case 'get_daily_rates':
					$items = $this->Master_model->get_daily_rates();
					$data = array();
					$i = 1;
					foreach ($items as $item) {
						$status = ($item->active == 1)
							? '<div class="badge badge-light-success">Active</div>'
							: '<div class="badge badge-light-danger">Not Active</div>';
						$status = '<span class="changeStatus" data-toggle="change-status" value="' . ($item->active == 1 ? 0 : 1) . '" data="' . $item->id . ',daily_items_rates,id,active" title="Click to change status">' . $status . '</span>';
				
						$action = '<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#showModal" data-whatever="Update Daily Items  Rates(' . $item->title . ')" data-url="' . base_url() . 'daily-items-rates/create/' . $item->id . '">
							<i class="fa fa-edit new-font-icon text-primary"></i>
							</a>
							<a href="javascript:void(0)" class="ms-3" data-kt-daily-items-table-filter="delete_row" url="' . base_url() . 'daily-items-rates/delete/' . $item->id . '" title="Delete Daily Items Rates">
							<i class="fa fa-trash new-font-icon text-primary"></i>
							</a>';
				     if($item->consumer_id=='0')
					 {
						$particulers = "Admin";
					 }else{
						$particulers = $item->contact_person;
					 }
						$data[] = array(
							$i,
							$item->title,
							$particulers,
							$item->rate,
							$item->type_title,
							$status,
							$action,
							$item->id,
						);
						$i++;
					}
				
					echo json_encode(array('data' => $data));
					break;
					
                case 'create':
                    $data['remote']             = base_url().'master-data/remote/daily_rates/';
                    $data['action_url']         = base_url().'daily-items-rates/save';
                    $page                       = 'admin/master/rate/daily_rates/create';
					$data['daily_items_master'] = $this->Master_model->getData('daily_items_master',['is_deleted'=>'NOT_DELETED','active'=>'1']);
					$data['min_order_qty_types'] = $this->Master_model->getData('min_order_qty_types',['is_deleted'=>'NOT_DELETED','active'=>'1']);
                    if ($p1!=null) {
                        $data['remote']             = base_url().'master-data/remote/daily_rates/'.$p1;
                        $data['action_url']     = base_url().'daily-items-rates/save/'.$p1;
                        $data['value']          = $this->Master_model->getRow('daily_items_rates',['id'=>$p1]);
                        $page                   = 'admin/master/rate/daily_rates/update';
                    }
                    $this->load->view($page, $data);
                    break;
               
                    case 'save':
                        $id = $p1;
                        $return['res'] = 'error';
                        $return['msg'] = 'Not Saved!';

                        if ($this->input->server('REQUEST_METHOD')=='POST') {
                            if ($id!=null) {
                                $data = array(
                                  'consumer_id'     => '0',
                                  'daily_item_master_id'     => $this->input->post('daily_item_master_id'),
								  'rate'     => $this->input->post('rate'),
								  'rate_type'     => $this->input->post('rate_type'),
                                    );
                                if($this->Master_model->Update('daily_items_rates',$data,['id'=>$id])){
									logs($user->id,$id,'EDIT','Edit Daily Items Rates');
                                    $return['res'] = 'success';
                                    $return['msg'] = 'Updates Daily Items Rates.';
                                }
                            }
                            else{
                                $data = array(
                                   'consumer_id'     => '0',
                                  'daily_item_master_id'     => $this->input->post('daily_item_master_id'),
								  'rate'     => $this->input->post('rate'),
								  'rate_type'     => $this->input->post('rate_type'),
                                    );
                                if ($id=$this->Master_model->Save('daily_items_rates',$data)) {
									logs($user->id,$id,'ADD','Add Daily Items Rates');
                                    $return['res'] = 'success';
                                    $return['msg'] = 'Add Daily Items Rates.';
                                }
                            }
                        }
                        echo json_encode($return);
                        break;
                        case 'delete':
                            if($this->Master_model->_delete('daily_items_rates',['id'=>$p1]))
                            {
								logs($user->id,$p1,'DELETE','Delete Daily Items Rates');
                                $return['res'] = 'success';
                                $return['msg'] = 'Delete Daily Items Rates.';
                            }
                            echo json_encode($return);
                  break; 
				 case 'delete_selected':
					if (!$this->input->is_ajax_request()) {
						exit('No direct script access allowed');
					}
					$ids = $this->input->post('ids');
				
					if (!empty($ids)) {
						foreach ($ids as $id) {
						 $this->Master_model->_delete('daily_items_rates',['id'=>$id]);
						 logs($user->id,$id,'DELETE','Delete Daily Items Rates');
						}
						echo json_encode(array('res' => 'success', 'msg' => 'Selected daily items rates deleted successfully.'));
					} else {
						echo json_encode(array('res' => 'error', 'msg' => 'Selected daily items rates not deleted .'));
					}
			   break;		
        }
    }

	public function features($action=null,$p1=null,$p2=null,$p3=null)
    {
        $user         = $this->checkLogin();
        switch ($action) {
            case null:
				$data['title'] = 'Features';
				$data['contant'] = 'admin/master/features/index';
				$data['user']=$user         = $this->checkLogin();
				$data['menu_url'] = $this->uri->segment(1);
				$data['breadcrumb']    = generate_breadcrumb($data['menu_url']);
                $data['new_url']        = base_url().'features-master/create';
				$data['scripts'] = [
				'admin/master/features/index',
				];	
				$this->template($data);
                break;
				case 'get_features':
					$features = $this->Master_model->get_features();
					$data = array();
					$i = 1;
					foreach ($features as $feature) {
						$status = ($feature->active == 1)
							? '<div class="badge badge-light-success">Active</div>'
							: '<div class="badge badge-light-danger">Not Active</div>';
						$status = '<span class="changeStatus" data-toggle="change-status" value="' . ($feature->active == 1 ? 0 : 1) . '" data="' . $feature->id . ',features_master,id,active" title="Click to change status">' . $status . '</span>';
				
						$action = '<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#showModal" data-whatever="Update feature master (' . $feature->title . ')" data-url="' . base_url() . 'features-master/create/' . $feature->id . '">
							<i class="fa fa-edit new-font-icon text-primary"></i>
							</a>
							<a href="javascript:void(0)" class="ms-3" data-kt-features-table-filter="delete_row" url="' . base_url() . 'features-master/delete/' . $feature->id . '" title="Delete feature master">
							<i class="fa fa-trash new-font-icon text-primary"></i>
							</a>';
						$description = '<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#showModal" data-whatever="Description (' . $feature->title . ')" data-url="' . base_url() . 'features-master/description/' . $feature->id . '">
							<i class="fa-solid new-font-icon fa-envelope-open-text text-primary"></i>
							</a>';
						$data[] = array(
							$i,
							$feature->title,
							$feature->url,
							$description,
							$status,
							$action,
							$feature->id,
						);
						$i++;
					}
				
					echo json_encode(array('data' => $data));
					break;
					
                case 'create':
                    $data['remote']             = base_url().'master-data/remote/features/';
                    $data['action_url']         = base_url().'features-master/save';
                    $page                       = 'admin/master/features/create';
                    if ($p1!=null) {
                        $data['remote']             = base_url().'master-data/remote/features/'.$p1;
                        $data['action_url']     = base_url().'features-master/save/'.$p1;
                        $data['value']          = $this->Master_model->getRow('features_master',['id'=>$p1]);
                        $page                   = 'admin/master/features/update';
                    }
                    $this->load->view($page, $data);
                    break;
               
                    case 'save':
                        $id = $p1;
                        $return['res'] = 'error';
                        $return['msg'] = 'Not Saved!';

                        if ($this->input->server('REQUEST_METHOD')=='POST') {
                            if ($id!=null) {
                                $data = array(
                                  'description'     => $this->input->post('description'),
								  'url'     => $this->input->post('url'),
								  'title'     => $this->input->post('title'),
                                    );
                                if($this->Master_model->Update('features_master',$data,['id'=>$id])){
									logs($user->id,$id,'EDIT','Edit features master');
                                    $return['res'] = 'success';
                                    $return['msg'] = 'Updates features master';
                                }
                            }
                            else{
                                $data = array(
									'description'     => $this->input->post('description'),
									'url'     => $this->input->post('url'),
									'title'     => $this->input->post('title'),
                                    );
                                if ($id=$this->Master_model->Save('features_master',$data)) {
									logs($user->id,$id,'ADD','Add features master');
                                    $return['res'] = 'success';
                                    $return['msg'] = 'Add features master.';
                                }
                            }
                        }
                        echo json_encode($return);
                        break;
                        case 'delete':
                            if($this->Master_model->_delete('features_master',['id'=>$p1]))
                            {
								logs($user->id,$p1,'DELETE','Delete features master');
                                $return['res'] = 'success';
                                $return['msg'] = 'Delete features master.';
                            }
                            echo json_encode($return);
                  break; 
				 case 'delete_selected':
					if (!$this->input->is_ajax_request()) {
						exit('No direct script access allowed');
					}
					$ids = $this->input->post('ids');
				
					if (!empty($ids)) {
						foreach ($ids as $id) {
						 $this->Master_model->_delete('features_master',['id'=>$id]);
						 logs($user->id,$id,'DELETE','Delete features master');
						}
						echo json_encode(array('res' => 'success', 'msg' => 'Selected features master deleted successfully.'));
					} else {
						echo json_encode(array('res' => 'error', 'msg' => 'Selected features master not deleted .'));
					}
			   break;
			   case 'description':
				    $data['title']='Description';
					$data['value']          = $this->Master_model->getRow('features_master',['id'=>$p1]);
					$page                   = 'admin/master/features/description';
				$this->load->view($page, $data);
			break;
        }
    }
	

	public function package($action=null,$p1=null,$p2=null,$p3=null)
    {
        $user         = $this->checkLogin();
        switch ($action) {
            case null:
				$data['title'] = 'Package';
				$data['contant'] = 'admin/master/package/index';
				$data['user']=$user         = $this->checkLogin();
				$data['menu_url'] = $this->uri->segment(1);
				$data['breadcrumb']    = generate_breadcrumb($data['menu_url']);
                $data['new_url']        = base_url().'package-master/create';
				$data['scripts'] = [
				'admin/master/package/index',
				];	
				$this->template($data);
                break;
				case 'get_packages':
					$general_master = $this->Master_model->getRow('general_master',0);
					$packages = $this->Master_model->get_packages();
					$data = array();
					$i = 1;
					foreach ($packages as $package) {
						if ($package->logo != null) {
							$result =  '<img src="' . IMGS_URL . $package->logo . '" class="thumbnail" data-bs-toggle="modal" data-bs-target="#kt_modal_package_thumbnail_'.$package->id.'" style="cursor:pointer"  height="50px" width="50px" >
								 <div class="modal fade" id="kt_modal_package_thumbnail_'.$package->id.'" tabindex="-1" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered mw-650px">
								<div class="modal-content">
									<div class="modal-header">
										<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
											<i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
										</div>
									</div>

									<div class="modal-body text-center scroll-y mx-5 mx-xl-15 my-7">
									<img src="' . IMGS_URL . $package->logo . '"  >
									</div>
								</div>
							</div>
						</div>
							';
						} else {
							$result = '<h1 style="height:50px;width:50px;border-radius:10px;padding-top:4px;font-size:3rem;text-align:center;text-transform:capitalize;background:#7271CF;color:#FFF">' . substr($package->name, 0, 1) . '</h1>';
						}
						$status = ($package->active == 1)
							? '<div class="badge badge-light-success">Active</div>'
							: '<div class="badge badge-light-danger">Not Active</div>';
						$status = '<span class="changeStatus" data-toggle="change-status" value="' . ($package->active == 1 ? 0 : 1) . '" data="' . $package->id . ',package_master,id,active" title="Click to change status">' . $status . '</span>';
				
						$action = '
						<a href="javascript:void(0)"   data-bs-toggle="modal" data-bs-target="#showModal" data-whatever="Map Package Features (' . $package->name . ')" data-url="' . base_url() . 'package-master/package_feature/' . $package->id . '">
						<i class="fa-solid fa-bars new-font-icon text-primary"></i>
							</a>
							<a href="javascript:void(0)" class="ms-3" data-bs-toggle="modal" data-bs-target="#showModal" data-whatever="Update package master (' . $package->name . ')" data-url="' . base_url() . 'package-master/create/' . $package->id . '">
							<i class="fa fa-edit new-font-icon text-primary"></i>
							</a>
							<a href="javascript:void(0)" class="ms-3" data-kt-package-table-filter="delete_row" url="' . base_url() . 'package-master/delete/' . $package->id . '" title="Delete package master">
							<i class="fa fa-trash new-font-icon text-primary"></i>
							</a>';
						$description = '<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#showModal" data-whatever="Description (' . $package->name . ')" data-url="' . base_url() . 'package-master/description/' . $package->id . '">
							<i class="fa-solid new-font-icon fa-envelope-open-text text-primary"></i>
							</a>';
							$indexing='<input type="number" value="'.$package->seq.'" data="'.$package->id.',package_master,id,seq" class="change-indexing" min="0" style="text-align:center;width:50px">';
						$data[] = array(
							$i,
							$result,
							$package->name,
							$general_master->currency.$package->price,
							$package->validity. " days",
							$description,
							$status,
							$indexing,
							$action,
							$package->id,
						);
						$i++;
					}
				
					echo json_encode(array('data' => $data));
					break;
					
                case 'create':
                    $data['remote']             = base_url().'master-data/remote/package/';
                    $data['action_url']         = base_url().'package-master/save';
                    $page                       = 'admin/master/package/create';
                    if ($p1!=null) {
                        $data['remote']             = base_url().'master-data/remote/package/'.$p1;
                        $data['action_url']     = base_url().'package-master/save/'.$p1;
                        $data['value']          = $this->Master_model->getRow('package_master',['id'=>$p1]);
                        $page                   = 'admin/master/package/update';
                    }
                    $this->load->view($page, $data);
                    break;
               
                    case 'save':
                        $id = $p1;
                        $return['res'] = 'error';
                        $return['msg'] = 'Not Saved!';

                        if ($this->input->server('REQUEST_METHOD')=='POST') {
                            if ($id!=null) {
								$config['file_name'] = rand(10000, 10000000000);
								$config['upload_path'] = UPLOAD_PATH.'package/';
								$config['allowed_types'] = 'jpg|jpeg|png|gif|webp|svg';
								$config['max_size'] = 100; // Max size in KB (200KB)
								$this->load->library('upload', $config);
								$this->upload->initialize($config);
								$default_image = "default.webp"; 

								if ($_FILES['logo']['size'] <= 102400) {
								if (!empty($_FILES['logo']['name'])) {
									$_FILES['logos']['name'] = $_FILES['logo']['name'];
									$_FILES['logos']['type'] = $_FILES['logo']['type'];
									$_FILES['logos']['tmp_name'] = $_FILES['logo']['tmp_name'];
									$_FILES['logos']['size'] = $_FILES['logo']['size'];
									$_FILES['logos']['error'] = $_FILES['logo']['error'];
					
									if ($this->upload->do_upload('logos')) {
										$image_data = $this->upload->data();
										$fileName = "package/" . $image_data['file_name'];
									}
									$logoimage = $fileName;
								} else {
									
									$logo = $this->Master_model->getRow('package_master',['id'=>$id]);
									if(!empty($logo)){
									$logoimage =  @$logo->logo;
									}else{
								    $logoimage =  "package/" .$default_image;
									}
								}
							  }else{
								$return['res'] = 'error';
								$return['msg'] = 'File size exceeds the maximum limit of 100 KB.';
							  }
                                $data = array(
                                  'description'     => $this->input->post('description'),
								  'price'     => $this->input->post('price'),
								  'name'     => $this->input->post('name'),
								  'validity'     => $this->input->post('validity'),
								  'seq'     => $this->input->post('seq'),
								  'logo'       =>$logoimage
                                    );
                                if($this->Master_model->Update('package_master',$data,['id'=>$id])){
									logs($user->id,$id,'EDIT','Edit package master');
                                    $return['res'] = 'success';
                                    $return['msg'] = 'Updates package master';
                                }
                            }
                            else{
								$config['file_name'] = rand(10000, 10000000000);
								$config['upload_path'] = UPLOAD_PATH.'package/';
								$config['allowed_types'] = 'jpg|jpeg|png|gif|webp|svg';
								$config['max_size'] = 100;
								$this->load->library('upload', $config);
								$this->upload->initialize($config);
								$default_image = "default.webp"; 

								if ($_FILES['logo']['size'] <= 102400) {
								if (!empty($_FILES['logo']['name'])) {
									$_FILES['logos']['name'] = $_FILES['logo']['name'];
									$_FILES['logos']['type'] = $_FILES['logo']['type'];
									$_FILES['logos']['tmp_name'] = $_FILES['logo']['tmp_name'];
									$_FILES['logos']['size'] = $_FILES['logo']['size'];
									$_FILES['logos']['error'] = $_FILES['logo']['error'];
					
									if ($this->upload->do_upload('logos')) {
										$image_data = $this->upload->data();
										$fileName = "package/" . $image_data['file_name'];
									}
									$logoimage = $fileName;
								} else {
									$logoimage =  "package/" .$default_image;
								}
							  }else{
								$return['res'] = 'error';
								$return['msg'] = 'File size exceeds the maximum limit of 100 KB.';
							  }
                              $data = array(
								'description'     => $this->input->post('description'),
								'price'     => $this->input->post('price'),
								'name'     => $this->input->post('name'),
								'validity'     => $this->input->post('validity'),
								'seq'     => $this->input->post('seq'),
								'logo'       =>$logoimage
								  );
                                if ($id=$this->Master_model->Save('package_master',$data)) {
									logs($user->id,$id,'ADD','Add package master');
                                    $return['res'] = 'success';
                                    $return['msg'] = 'Add package master.';
                                }
                            }
                        }
                        echo json_encode($return);
                        break;
                        case 'delete':
                            if($this->Master_model->_delete('package_master',['id'=>$p1]))
                            {
								logs($user->id,$p1,'DELETE','Delete package master');
                                $return['res'] = 'success';
                                $return['msg'] = 'Delete package master.';
                            }
                            echo json_encode($return);
                  break; 
				 case 'delete_selected':
					if (!$this->input->is_ajax_request()) {
						exit('No direct script access allowed');
					}
					$ids = $this->input->post('ids');
				
					if (!empty($ids)) {
						foreach ($ids as $id) {
						 $this->Master_model->_delete('package_master',['id'=>$id]);
						 logs($user->id,$id,'DELETE','Delete package master');
						}
						echo json_encode(array('res' => 'success', 'msg' => 'Selected package master deleted successfully.'));
					} else {
						echo json_encode(array('res' => 'error', 'msg' => 'Selected package master not deleted .'));
					}
			   break;
			   case 'description':
				    $data['title']='Description';
					$data['value']          = $this->Master_model->getRow('package_master',['id'=>$p1]);
					$page                   = 'admin/master/package/description';
				$this->load->view($page, $data);
			break;
			case 'package_feature':
				$return['res'] = 'error';
				$return['msg'] = 'Not Saved!';
				$saved = 0;
				if ($this->input->server('REQUEST_METHOD')=='POST') {
					$features_id    = $_POST['m_id'];
					$type   	= $_POST['type'];
					$package_id    = $p1;
					$row = $this->acl_model->getRow('features_master',['id'=>$features_id]);
					if($row){
						$check['package_id']   = $package_id;
						$check['features_id'] 	= $features_id;
						$value = 0;
						if ($type=='set'){
							$value = 1;
						}
						 if($_POST['name']!=''){
							$update[$_POST['name']] = $value;
							if($this->acl_model->getRow('package_features',$check)){
								if ($this->acl_model->Update('package_features',$update,$check)) {
									$saved = 1;
									logs($user->id,$package_id,'EDIT','Package Features Mapping');
								}
							}
							else{
								$return['msg'] = 'Package Features Not Mapping!';
							}
						}
						else{
							if ($this->acl_model->Delete('package_features',$check)) {
								$saved = 1;
								logs($user->id,$package_id,'EDIT','Package Features Mapping');
							}
						}
					}
					if ($saved == 1) {
						$return['res'] = 'success';
						$return['msg'] = 'Saved.';
					}                
					echo json_encode($return);                                    
				}
				else{
					$page     = 'admin/master/package/package_feature';
					$data['m_access_url'] =  base_url().'package-master/package_feature/';
					$features   = $this->Master_model->getData('features_master',['active'=>'1','is_deleted'=>'NOT_DELETED']);
					$data['package_id'] = $package_id = $p1;
					if ($features) {
						foreach ($features as $row) {
							$row->checked = '';
							if ($t = $this->acl_model->getRow('package_features',['features_id'=>$row->id,'package_id'=>$package_id])) {
								$row->checked = 'checked';
							}
						}
					}
					$data['features']  = $features;
					$this->load->view($page,$data);
				}
			break;	
        }
    }

	
	public function booking_timings($action=null,$p1=null,$p2=null,$p3=null)
    {
        $user         = $this->checkLogin();
        switch ($action) {
            case null:
				$data['title'] = 'Booking timings';
				$data['contant'] = 'admin/master/booking_timings/index';
				$data['user']=$user         = $this->checkLogin();
				$data['menu_url'] = $this->uri->segment(1);
				$data['breadcrumb']    = generate_breadcrumb($data['menu_url']);
                $data['new_url']        = base_url().'booking-timings/create';
				$data['scripts'] = [
				'admin/master/booking_timings/index',
				];	
				$this->template($data);
                break;
				case 'get_timings':
					$timings = $this->Master_model->get_timings();
					$data = array();
					$i = 1;
					foreach ($timings as $time) {
						
						$action = '<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#showModal" data-whatever="Update booking timings (' .($time->day) . ')" data-url="' . base_url() . 'booking-timings/create/' . $time->id . '">
							<i class="fa fa-edit new-font-icon text-primary"></i>
							</a>';
							$days_full = array(
								'mon' => 'Monday',
								'tue' => 'Tuesday',
								'wed' => 'Wednesday',
								'thu' => 'Thursday',
								'fri' => 'Friday',
								'sat' => 'Saturday',
								'sun' => 'Sunday'
							);

							$data[] = array(
								$i,
								$days_full[$time->day],
								date('h:i A', strtotime($time->open)),
								date('h:i A', strtotime($time->close)), 
								$time->is_closed,
								$action,
								$time->id,
							);

							
						$i++;
					}
				
					echo json_encode(array('data' => $data));
					break;
					
                case 'create':
                    $data['remote']             = base_url().'master-data/day_remote/timings/';
                    $data['action_url']         = base_url().'booking-timings/save';
                    $page                       = 'admin/master/booking_timings/create';
                    if ($p1!=null) {
                        $data['remote']             = base_url().'master-data/day_remote/timings/'.$p1;
                        $data['action_url']     = base_url().'booking-timings/save/'.$p1;
                        $data['value']          = $this->Master_model->getRow('booking_timings',['id'=>$p1]);
                        $page                   = 'admin/master/booking_timings/update';
                    }
                    $this->load->view($page, $data);
                    break;
               
                    case 'save':
                        $id = $p1;
                        $return['res'] = 'error';
                        $return['msg'] = 'Not Saved!';

                        if ($this->input->server('REQUEST_METHOD')=='POST') {
                            if ($id!=null) {
                                $data = array(
                                  'day'     => $this->input->post('day'),
								  'open'     => $this->input->post('open'),
								  'close'     => $this->input->post('close'),
								  'is_closed'     => $this->input->post('is_closed') ? $this->input->post('is_closed') : "OPEN",
                                    );
							 $count = $this->Master_model->Counter('booking_timings', array('id'=>$id));
							 if($count==1){		
                                if($this->Master_model->Update('booking_timings',$data,['day'=>$this->input->post('day')])){
									logs($user->id,$id,'EDIT','Edit booking timings');
                                    $return['res'] = 'success';
                                    $return['msg'] = 'Updates  booking timings ';
                                }
							  }else{
								$return['res'] = 'error';
								$return['msg'] = 'Sorry!. selected day already exist.';
							  } 
                            }
                            else{
                                $data = array(
									'day'     => $this->input->post('day'),
									'open'     => $this->input->post('open'),
									'close'     => $this->input->post('close'),
									'is_closed'     => $this->input->post('is_closed') ? $this->input->post('is_closed') : "OPEN",
                                    );
									$count = $this->Master_model->Counter('booking_timings', array('id'=>$id));
									if($count==0){	
                                if ($id=$this->Master_model->Save('booking_timings',$data)) {
									logs($user->id,$id,'ADD','Add booking timings');
                                    $return['res'] = 'success';
                                    $return['msg'] = 'Add booking timings.';
                                }
							    }else{
								$return['res'] = 'error';
								$return['msg'] = 'Sorry!. selected day already exist.';
							  } 
                            }
                        }
                        echo json_encode($return);
                break;
				case 'delete':
					if($this->Master_model->Delete('booking_timings',['id'=>$p1]))
					{
						logs($user->id,$p1,'DELETE','Delete booking timings');
						$return['res'] = 'success';
						$return['msg'] = 'Delete booking timings.';
					}
					echo json_encode($return);
		  break; 
		 case 'delete_selected':
			if (!$this->input->is_ajax_request()) {
				exit('No direct script access allowed');
			}
			$ids = $this->input->post('ids');
		
			if (!empty($ids)) {
				foreach ($ids as $id) {
				 $this->Master_model->Delete('booking_timings',['id'=>$id]);
				 logs($user->id,$id,'DELETE','Delete booking timings');
				}
				echo json_encode(array('res' => 'success', 'msg' => 'Selected booking timings deleted successfully.'));
			} else {
				echo json_encode(array('res' => 'error', 'msg' => 'Selected booking timings not deleted .'));
			}
	   break;
              
        }
    }


	public function transporter($action=null,$p1=null,$p2=null,$p3=null)
    {
        $user         = $this->checkLogin();
        switch ($action) {
            case null:
				$data['title'] = 'Transporter';
				$data['contant'] = 'admin/master/transporter/index';
				$data['user']=$user         = $this->checkLogin();
				$data['menu_url'] = $this->uri->segment(1);
				$data['breadcrumb']    = generate_breadcrumb($data['menu_url']);
                $data['new_url']        = base_url().'transporter/create';
				$data['scripts'] = [
				'admin/master/transporter/index',
				];	
				$this->template($data);
                break;
				case 'get_transporters':
					$ransporters = $this->Master_model->get_transporters();
					$data = array();
					$i = 1;
					foreach ($ransporters as $value) {
						if ($value->logo != null) {
							$result =  '<img src="' . IMGS_URL . $value->logo . '" class="thumbnail" data-bs-toggle="modal" data-bs-target="#kt_modal_transport_logo_'.$value->id.'" style="cursor:pointer"  height="50px" width="50px" >
								 <div class="modal fade" id="kt_modal_transport_logo_'.$value->id.'" tabindex="-1" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered mw-650px">
								<div class="modal-content">
									<div class="modal-header">
										<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
											<i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
										</div>
									</div>

									<div class="modal-body text-center scroll-y mx-5 mx-xl-15 my-7">
									<img src="' . IMGS_URL . $value->logo . '"  >
									</div>
								</div>
							</div>
						</div>
							';
						} else {
							$result = '<h1 style="height:50px;width:50px;border-radius:10px;padding-top:4px;font-size:3rem;text-align:center;text-transform:capitalize;background:#7271CF;color:#FFF">' . substr($value->name, 0, 1) . '</h1>';
						}
						$status = ($value->active == 1)
							? '<div class="badge badge-light-success">Active</div>'
							: '<div class="badge badge-light-danger">Not Active</div>';
						$status = '<span class="changeStatus" data-toggle="change-status" value="' . ($value->active == 1 ? 0 : 1) . '" data="' . $value->id . ',transporter,id,active" title="Click to change status">' . $status . '</span>';
				
						$action = '
							<a href="javascript:void(0)" class="ms-3" data-bs-toggle="modal" data-bs-target="#showModal" data-whatever="Update Transporter (' . $value->company_name . ')" data-url="' . base_url() . 'transporter/create/' . $value->id . '">
							<i class="fa fa-edit new-font-icon text-primary"></i>
							</a>
							<a href="javascript:void(0)" class="ms-3" data-kt-transporter-table-filter="delete_row" url="' . base_url() . 'transporter/delete/' . $value->id . '" title="Delete Transporter">
							<i class="fa fa-trash new-font-icon text-primary"></i>
							</a>';
						$data[] = array(
							$i,
							$result,
							$value->company_name,
							$value->what_you_provide,
							$value->mobile_number,
							$value->email,
							$value->minimum_load.' '.$value->minimum_load_types,
							$value->building_no.' '.$value->area_street.' '.$value->landmark.'<br>'.$value->state_name.', '.$value->city_name.' - '.$value->pincode,
							$status,
							$action,
							$value->id,
						);
						$i++;
					}
				
					echo json_encode(array('data' => $data));
					break;
					
                case 'create':
                    $data['remote']             = base_url().'master-data/remote/transporter/';
                    $data['action_url']         = base_url().'transporter/save';
                    $page                       = 'admin/master/transporter/create';
					$data['min_order_qty_types']= $this->Master_model->getData('min_order_qty_types',['is_deleted'=>'NOT_DELETED','active'=>'1']);
					$data['states']= $this->Master_model->getData('states',['is_deleted'=>'NOT_DELETED']);
                    if ($p1!=null) {
                        $data['remote']             = base_url().'master-data/remote/transporter/'.$p1;
                        $data['action_url']     = base_url().'transporter/save/'.$p1;
                        $data['value']          = $this->Master_model->getTransporterRow($p1);
                        $page                   = 'admin/master/transporter/update';
                    }
                    $this->load->view($page, $data);
                    break;
               
                    case 'save':
                        $id = $p1;
                        $return['res'] = 'error';
                        $return['msg'] = 'Not Saved!';

                        if ($this->input->server('REQUEST_METHOD')=='POST') {
                            if ($id!=null) {
								$config['file_name'] = rand(10000, 10000000000);
								$config['upload_path'] = UPLOAD_PATH.'transporter/';
								$config['allowed_types'] = 'jpg|jpeg|png|gif|webp|svg';
								$config['max_size'] = 100; // Max size in KB (200KB)
								$this->load->library('upload', $config);
								$this->upload->initialize($config);
								$default_image = "default.webp"; 

								if ($_FILES['logo']['size'] <= 102400) {
								if (!empty($_FILES['logo']['name'])) {
									$_FILES['logos']['name'] = $_FILES['logo']['name'];
									$_FILES['logos']['type'] = $_FILES['logo']['type'];
									$_FILES['logos']['tmp_name'] = $_FILES['logo']['tmp_name'];
									$_FILES['logos']['size'] = $_FILES['logo']['size'];
									$_FILES['logos']['error'] = $_FILES['logo']['error'];
					
									if ($this->upload->do_upload('logos')) {
										$image_data = $this->upload->data();
										$fileName = "transporter/" . $image_data['file_name'];
									}
									$logoimage = $fileName;
								} else {
									
									$logo = $this->Master_model->getRow('transporter',['id'=>$id]);
									if(!empty($logo)){
									$logoimage =  @$logo->logo;
									}else{
								    $logoimage =  "transporter/" .$default_image;
									}
								}
							  }else{
								$return['res'] = 'error';
								$return['msg'] = 'File size exceeds the maximum limit of 100 KB.';
							  }
                                $data = array(
                                  'company_name'     => $this->input->post('company_name'),
								  'what_you_provide'     => $this->input->post('what_you_provide'),
								  'mobile_number'     => $this->input->post('mobile_number'),
								  'email'     => $this->input->post('email'),
								  'minimum_load'     => $this->input->post('minimum_load'),
								  'minimum_load_type'     => $this->input->post('minimum_load_type'),
								  'state'     => $this->input->post('state'),
								  'city'     => $this->input->post('city'),
								  'building_no'     => $this->input->post('building_number'),
								  'area_street'     => $this->input->post('area_street'),
								  'landmark'     => $this->input->post('landmark'),
								  'pincode'     => $this->input->post('pincode'),
								  'logo'       =>$logoimage
                                    );
                                if($this->Master_model->Update('transporter',$data,['id'=>$id])){
									logs($user->id,$id,'EDIT','Edit Transporter');
                                    $return['res'] = 'success';
                                    $return['msg'] = 'Updates Transporter';
                                }
                            }
                            else{
								$config['file_name'] = rand(10000, 10000000000);
								$config['upload_path'] = UPLOAD_PATH.'transporter/';
								$config['allowed_types'] = 'jpg|jpeg|png|gif|webp|svg';
								$config['max_size'] = 100;
								$this->load->library('upload', $config);
								$this->upload->initialize($config);
								$default_image = "default.webp"; 

								if ($_FILES['logo']['size'] <= 102400) {
								if (!empty($_FILES['logo']['name'])) {
									$_FILES['logos']['name'] = $_FILES['logo']['name'];
									$_FILES['logos']['type'] = $_FILES['logo']['type'];
									$_FILES['logos']['tmp_name'] = $_FILES['logo']['tmp_name'];
									$_FILES['logos']['size'] = $_FILES['logo']['size'];
									$_FILES['logos']['error'] = $_FILES['logo']['error'];
					
									if ($this->upload->do_upload('logos')) {
										$image_data = $this->upload->data();
										$fileName = "transporter/" . $image_data['file_name'];
									}
									$logoimage = $fileName;
								} else {
									$logoimage =  "transporter/" .$default_image;
								}
							  }else{
								$return['res'] = 'error';
								$return['msg'] = 'File size exceeds the maximum limit of 100 KB.';
							  }
                              $data = array(
								'company_name'     => $this->input->post('company_name'),
								'what_you_provide'     => $this->input->post('what_you_provide'),
								'mobile_number'     => $this->input->post('mobile_number'),
								'email'     => $this->input->post('email'),
								'minimum_load'     => $this->input->post('minimum_load'),
								'minimum_load_type'     => $this->input->post('minimum_load_type'),
								'state'     => $this->input->post('state'),
								'city'     => $this->input->post('city'),
								'building_no'     => $this->input->post('building_number'),
								'area_street'     => $this->input->post('area_street'),
								'landmark'     => $this->input->post('landmark'),
								'pincode'     => $this->input->post('pincode'),
								'logo'       =>$logoimage
								  );
                                if ($id=$this->Master_model->Save('transporter',$data)) {
									logs($user->id,$id,'ADD','Add Transporter');
                                    $return['res'] = 'success';
                                    $return['msg'] = 'Add Transporter.';
                                }
                            }
                        }
                        echo json_encode($return);
                        break;
                        case 'delete':
                            if($this->Master_model->_delete('transporter',['id'=>$p1]))
                            {
								logs($user->id,$p1,'DELETE','Delete Transporter');
                                $return['res'] = 'success';
                                $return['msg'] = 'Delete Transporter.';
                            }
                            echo json_encode($return);
                  break; 
				 case 'delete_selected':
					if (!$this->input->is_ajax_request()) {
						exit('No direct script access allowed');
					}
					$ids = $this->input->post('ids');
				
					if (!empty($ids)) {
						foreach ($ids as $id) {
						 $this->Master_model->_delete('package_master',['id'=>$id]);
						 logs($user->id,$id,'DELETE','Delete Transporter');
						}
						echo json_encode(array('res' => 'success', 'msg' => 'Selected transporter deleted successfully.'));
					} else {
						echo json_encode(array('res' => 'error', 'msg' => 'Selected transporter not deleted .'));
					}
			   break;
        }
    }

	public function fetch_cities()
    {
        if($this->input->post('state'))
        {
            $state= $this->input->post('state');
            $this->Master_model->fetch_cities($state);
        }
    }


}
