<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
class Sellers extends Main {

    public function index()
    {
		$data['title'] = 'Buyers Sellers';
		$data['contant'] = 'admin/buyers-sellers/buyers-sellers-data';
		$data['user']=$user         = $this->checkLogin();
        $menu_id = $this->uri->segment(2);
        $data['menu_id'] = $menu_id;
		$role_id = $user->user_role;
        $data['sub_menus'] = $this->Admin_model->get_submenu_data($menu_id,$role_id);
		$data['menu_url'] = $this->uri->segment(1);
        $data['breadcrumb']    = generate_breadcrumb($data['menu_url']);
		$this->template($data);
       
    }
    public function sellers($action=null,$p1=null,$p2=null,$p3=null)
    {
        $user         = $this->checkLogin();
        switch ($action) {
            case null:
				$data['title'] = 'Sellers';
				$data['contant'] = 'admin/buyers-sellers/sellers/index';
				$data['user']=$user         = $this->checkLogin();
				$data['menu_url'] = $this->uri->segment(1);
				$data['menu_id'] = $this->uri->segment(2);
				$data['breadcrumb']    = generate_breadcrumb($data['menu_url']);
                $data['new_url']        = base_url().'buyers-sellers/create';
				$data['script']         = 'admin/buyers-sellers/sellers/table';
				$data['states']         = $this->Seller_model->getData('states',0);
				$this->template($data);
                break;
				case 'get_seller':
					$sellers = $this->Seller_model->getAllSellers();
					$data = array();
					$i = 1;
					$url = base_url().'sellers/details/';
					$wallet_url = base_url().'sellers/wallet/';
					
					foreach ($sellers as $seller) {
						$status = ($seller->active == 1)
							? '<div class="badge badge-light-success">Active</div>'
							: '<div class="badge badge-light-danger">Not Active</div>';
						$status = '<span class="changeStatus" data-toggle="change-status" value="' . ($seller->active == 1 ? 0 : 1) . '" data="' . $seller->id . ',consumers,id,active" title="Click to change status">' . $status . '</span>';
						  $action = '
							<a target="_blank" href="'.$url.$seller->id.'" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" >
								view
								<i class="ki-duotone ki-right fs-5 ms-1"></i>
							</a>
						';
						if($seller->status=='VERIFIED'){
						$approval_status = '<div class="badge badge-light-success">VERIFIED</div>';
						}elseif($seller->status=='REJECTED'){
						$approval_status = '<div class="badge badge-light-danger">REJECTED</div>
						<br><p class="text-start mt-3">'.$seller->remark.'</p>';
						}else{
						$approval_status = '<div class="badge badge-light-warning">PENDING</div>';
						}
						

						$data[] = array(
							$i,
							$seller->contact_person,
							$seller->mobile,
							$seller->email,
							$approval_status,
							$status,
							$action,
							$seller->id
						);
						$i++;
					}
				
					echo json_encode(array('data' => $data));
				break;
				case 'get_cities':
					$state_id = $this->input->get('state_id');
					if ($state_id) {
						$cities = $this->Seller_model->get_cities_by_state($state_id);
						echo json_encode(['res' => 'success', 'cities' => $cities]);
					} else {
						echo json_encode(['res' => 'error', 'msg' => 'Invalid state ID']);
					}
				break;
			 case 'details':
				$data['title'] = 'Sellers Details';
				$data['contant'] = 'admin/buyers-sellers/sellers/details';
				$data['user']=$user         = $this->checkLogin();
				$data['menu_url'] = $this->uri->segment(1);
				$data['breadcrumb']    = generate_breadcrumb($data['menu_url']);
                $data['new_url']        = base_url().'buyers-sellers/create';
				$data['general_master'] = $this->master_model->getRow('general_master',0);
				$data['scripts'] = [
					'admin/buyers-sellers/sellers/details/transaction-history',
					'admin/buyers-sellers/sellers/details/update-profile',
					'admin/buyers-sellers/sellers/details/company',
					'admin/buyers-sellers/sellers/details/account_status',
					'admin/buyers-sellers/sellers/details/category',
					'admin/buyers-sellers/sellers/details/product',
					'admin/buyers-sellers/sellers/wallet',
				];		
				$data['companies']	    = $this->Seller_model->getData('consumers_company',['consumer_id'=>$p1]);
				$data['categories']	    = $this->Seller_model->getData('categories',['consumer_id'=>$p1,'parent'=>'0','consumer_id'=>$p1,'is_deleted'=>'NOT_DELETED','active'=>'1']);	
				$data['states']         = $this->Seller_model->getData('states',0);
				$data['seller']         = $this->Seller_model->getSellers($p1);
				$data['title2']          = 'Category';
				$data['title3']          = 'Product';
		        $data['new_category_url']        = base_url().'sellers/create_category/'.$p1;
				$data['new_product_url']        = base_url().'sellers/create_product/'.$p1;
				$data['seller_id']      = $p1;
				$this->template($data);
			 break;	
			case 'get_history':
				$general_master = $this->master_model->getRow('general_master',0);
				$sellers = $this->Seller_model->getWithdrawals();
					$data = array();
					$i = 1;
					$url = 'sellers/details/';
					
					foreach ($sellers as $seller) {
						$formatted_date = date('Y-m-d H:i:s', strtotime($seller->request_date));
						$utc_date = new DateTime($formatted_date, new DateTimeZone('UTC'));
						$moment_date = $utc_date->format('d M Y, h:m A');
						if ($seller->status == 'SUCCESS') {
							$batch = '<span class="badge badge-light-success">'.$seller->status.'</span>';
						} elseif ($seller->status == 'PENDING') {
							$batch = '<span class="badge badge-light-warning">'.$seller->status.'</span>';
						} elseif ($seller->status == 'FAILED' || $seller->status == 'REJECTED') {
							$batch = '<span class="badge badge-light-danger">'.$seller->status.'</span>';
						}
						$data[] = array(
							$i,
							$batch,
							$general_master->currency.$seller->amount,
							$moment_date,
						);
					
						$i++;
					}
					echo json_encode(array('data' => $data));
				break;	   
			case 'get_total_rupee':
					$start_date = $this->input->get('start_date');
					$end_date = $this->input->get('end_date');
					$total_rupee = $this->Seller_model->calculate_total_rupee($start_date, $end_date);
					echo json_encode(['total_rupee' => $total_rupee ? $total_rupee : '0.00']);
		  break;		
		  case 'update_profile':
			$response = array('success' => false, 'message' => '');
		
			$mobile_verified = $this->input->post('mobile_verify');
			$alternet_verified = $this->input->post('alternet_mobile_verify');
			$email_verified = $this->input->post('email_verify');
			$consumer_id = $this->input->post('consumer_id');
		
			if ($mobile_verified !== null || $alternet_verified !== null || $email_verified !== null) {
				$data = array();
		
				if ($mobile_verified !== null) {
					$data['mobile_verified'] = $mobile_verified;
				}
				if ($alternet_verified !== null) {
					$data['alternet_verified'] = $alternet_verified;
				}
				if ($email_verified !== null) {
					$data['email_verified'] = $email_verified;
				}
		
				$update = $this->Seller_model->Update('consumers', $data, ['id' => $consumer_id]);
		
				if ($update) {
					$response['success'] = true;
					$messages = array();
					if ($mobile_verified == '1') {
						$messages[] = 'Mobile number verified successfully!';
						logs($user->id,$consumer_id,'CHANGE_STATUS','Consumer Accounts Mobile number verified ');
					}else{
						$messages[] = 'Mobile number not verified ';
						logs($user->id,$consumer_id,'CHANGE_STATUS','Consumer Accounts Mobile number not verified ');
					}
					if ($alternet_verified == '1') {
						$messages[] = 'Alternate mobile number verified successfully!';
						logs($user->id,$consumer_id,'CHANGE_STATUS','Consumer Accounts Alternate mobile number verified');
					}else{
						$messages[] = 'Alternate Mobile number not verified ';
						logs($user->id,$consumer_id,'CHANGE_STATUS','Consumer Alternate Accounts Mobile number not verified ');
					}
					if ($email_verified == '1') {
						$messages[] = 'Email verified successfully!';
						logs($user->id,$consumer_id,'CHANGE_STATUS','Consumer Accounts Email verified');
					}else{
						$messages[] = 'Email not verified ';
						logs($user->id,$consumer_id,'CHANGE_STATUS','Consumer Accounts Email not verified ');
					}
					$response['message'] = implode(' ', $messages);
				} else {
					$response['message'] = 'Failed to update profile. Please try again.';
				}
			} else {
				$response['message'] = 'Please fill all required fields.';
			}
		
			echo json_encode($response);
			break;
		case 'update_company_status':
			$response = array('success' => false, 'message' => '');
		
			$verify_status = $this->input->post('verify_status');
			$remark = $this->input->post('remark');
			$company_id = $this->input->post('company_id');
		
			if ($verify_status !== null) {
				$data = array();
		
				if ($verify_status !== null) {
					$data['status'] = $verify_status;
				}
				if ($remark !== null) {
					$data['remark'] = $remark;
				}
		
				$update = $this->Seller_model->Update('consumers_company', $data, ['id' => $company_id]);
		
				if ($update) {
					$response['success'] = true;
					$messages = array();
					
					   // Define appropriate messages based on status
					   switch ($verify_status) {
						case 'VERIFIED':
							$messages[] = 'Company status updated to VERIFIED successfully!';
							logs($user->id,$company_id,'CHANGE_STATUS','Consumer Company status updated to VERIFIED');
							break;
						case 'REJECTED':
							$messages[] = 'Company status updated to REJECTED successfully!';
							logs($user->id,$company_id,'CHANGE_STATUS','Consumer Company status updated to REJECTED');
							break;
						case 'PENDING':
							$messages[] = 'Company status updated to PENDING successfully!';
							logs($user->id,$company_id,'CHANGE_STATUS','Consumer Company status updated to PENDING');
							break;
						default:
							$messages[] = 'Company status updated successfully!';
							logs($user->id,$company_id,'CHANGE_STATUS','Consumer Company status updated');
							break;
					}
		
					$response['message'] = implode(' ', $messages);
				} else {
					$response['message'] = 'Failed to update company status. Please try again.';
				}
			} else {
				$response['message'] = 'Please change status than click submit button.';
			}
		
			echo json_encode($response);
	    break;		
        case 'update_account_status':
			$response = array('success' => false, 'message' => '');
		
			$verify_status = $this->input->post('account_status');
			$remark = $this->input->post('remark');
			$consumers_id = $this->input->post('seller_id');
		
			if ($verify_status !== null) {
				$data = array();
		
				if ($verify_status !== null) {
					$data['status'] = $verify_status;
				}
				if ($remark !== null) {
					$data['remark'] = $remark;
				}
		
				$update = $this->Seller_model->Update('consumers', $data, ['id' => $consumers_id]);
		
				if ($update) {
					$response['success'] = true;
					$messages = array();
					
					   // Define appropriate messages based on status
					   switch ($verify_status) {
						case 'VERIFIED':
							$messages[] = 'Account status updated to VERIFIED successfully!';
							logs($user->id,$consumers_id,'CHANGE_STATUS','Consumer Accounts  status updated to VERIFIED');
							break;
						case 'REJECTED':
							$messages[] = 'Account status updated to REJECTED successfully!';
							logs($user->id,$consumers_id,'CHANGE_STATUS','Consumer Accounts status updated to REJECTED');
							break;
						case 'PENDING':
							$messages[] = 'Account status updated to PENDING successfully!';
							logs($user->id,$consumers_id,'CHANGE_STATUS','Consumer Accounts  Status updated to PENDING');
							break;
						default:
							$messages[] = 'Account status updated successfully!';
							logs($user->id,$consumers_id,'CHANGE_STATUS','Consumer Accounts Change Status');
							break;
					}
		
					$response['message'] = implode(' ', $messages);
				} else {
					$response['message'] = 'Failed to update company status. Please try again.';
				}
			} else {
				$response['message'] = 'Please change status than click submit button.';
			}
		
			echo json_encode($response);
	    break;	
		case 'create_category':
			$data['seller_id']=$p1;	
			$data['remote']             = base_url().'buyers-sellers/remote/category/';
			$data['action_url']         = base_url().'sellers/save_category/'.$p1;
			$data['user_roles'] = $this->acl_model->get_user_roles();
			$data['parent_cat'] = $this->Seller_model->get_parent_category($p1);
			$data['title'] = 'Add Category';
			$data['contant'] = 'admin/buyers-sellers/sellers/category/create';
			$data['user']=$user         = $this->checkLogin();
			$data['menu_url'] = $this->uri->segment(1);
			$data['breadcrumb']    = generate_breadcrumb($data['menu_url']);
			$data['scripts'] = [
				'admin/buyers-sellers/sellers/details/add_category',
			];		
			$data['companies']	    = $this->Seller_model->getData('consumers_company',['consumer_id'=>$p1]);
			$data['categories']	    = $this->Seller_model->getData('categories',['parent'=>'0','consumer_id'=>$p1,'is_deleted'=>'NOT_DELETED','active'=>'1']);	
			$data['seller']         = $this->Seller_model->getRow('consumers',['id'=>$p1]);
			$data['seller_id']      = $p1;
			if ($p2!=null) {
				$data['scripts'] = [
					'admin/buyers-sellers/sellers/details/edit_category',
				];	
				$data['title'] = 'Edit Category';
				$data['remote']             = base_url().'buyers-sellers/remote/category/'.$p2;
				$data['action_url']     = base_url().'sellers/save_category/'.$p1.'/'.$p2;
				$data['value']          = $this->Seller_model->category($p2);
				$data['contant'] = 'admin/buyers-sellers/sellers/category/update';
			}
			$this->template($data);
		break;	
		case 'save_category':
			$seller_id = $p1;
			$id = $p2;
			$return['res'] = 'error';
			$return['msg'] = 'Not Saved!';
	
			if ($this->input->server('REQUEST_METHOD')=='POST') {
				if ($id!=null) {
					if($this->input->post('parent_id') && !$this->input->post('sub_cat_id'))
					{
						$is_parent = $this->input->post('parent_id');
						 $rs = $this->Seller_model->get_row_data('categories','id',$is_parent);
						 $catname = $rs->name;
						 $convertedName =  $this->url_character_remove($catname).'-'.$this->input->post('url');
					}
					else if($this->input->post('parent_id') && $this->input->post('sub_cat_id'))
					{
						$is_parent = $this->input->post('sub_cat_id');
						  $rs = $this->Seller_model->get_row_data('categories','id',$is_parent);
						 $rs2 = $this->Seller_model->get_row_data('categories','id',$rs->parent);
						 $catname =$rs2->name;
						 $convertedName =  $this->url_character_remove($catname).'-'.$this->input->post('url');
					}
					else
					{
						$is_parent = '0';
						$convertedName = $this->input->post('url');
					}
					$data = array(
						'name'     => $this->input->post('name'),
						'parent'     => $is_parent,
						'seq'     => $this->input->post('seq'),
						'url'=> remove_spaces($convertedName),
						'consumer_id' =>$this->input->post('consumer_id'),
						'active'=>$this->input->post('status'),
						);
						
					if($this->Seller_model->edit_category($data,$id)){
						logs($user->id,$id,'EDIT','Category');
						$return['res'] = 'success';
						$return['msg'] = 'Category edit successfully.';
						$return['url'] = base_url().'sellers/details/'.$p1;
					}
				}
				else{
					if($this->input->post('parent_id') && !$this->input->post('sub_cat_id'))
					{
						 $is_parent = $this->input->post('parent_id');
						 $rs = $this->Seller_model->get_row_data('categories','id',$is_parent);
						 $catname = $rs->name.' '.$this->input->post('name');
						 $convertedName =  $this->url_character_remove($catname);
					}
					else if($this->input->post('parent_id') && $this->input->post('sub_cat_id'))
					{
						 $is_parent = $this->input->post('sub_cat_id');
						 $rs = $this->Seller_model->get_row_data('categories','id',$is_parent);
						 $rs2 = $this->Seller_model->get_row_data('categories','id',$rs->parent);
						 $catname =$rs2->name.' '.$this->input->post('name');
						 $convertedName =  $this->url_character_remove($catname);
					}
					else
					{
						$is_parent = '0';
						 $catname = $this->input->post('name');
						 $convertedName =  $this->url_character_remove($catname);
					}
				   
						 $data = array(
						'parent'     => $is_parent,
						'name'     => $this->input->post('name'),
						'seq'     => $this->input->post('seq'),
						'consumer_id' =>$this->input->post('consumer_id'),
						'url'=>$convertedName,
						'active'=>$this->input->post('status'),
						);
					
						$response = $this->Seller_model->add_category($data);
						if ($response->res === 'success') {
							logs($user->id, $response->id, 'ADD', 'Category');
							$return['res'] = 'success';
							$return['msg'] = $response->msg;
							$return['url'] = base_url() . 'sellers/details/' . $p1;
						} else {
							$return['res'] = 'error';
							$return['msg'] = $response->msg;
						}
				}
			}
			echo json_encode($return);
			break;	
			case 'get_category':
				$consumer_id = @$_GET['consumer_id'];
				$parent_cat = $this->Seller_model->get_all_categories($consumer_id);
				$categories = $this->Seller_model->get_categories($consumer_id);
						$data = array();
						$i = 1;
						foreach ($parent_cat as $value) {
							if($value->parent=="0")
							{
							if ($value->thumbnail != null) {
								$result =  '<img class="thumbnail" data-bs-toggle="modal" data-bs-target="#kt_modal_category_thumbnail_'.$value->id.'" style="cursor:pointer" src="' . IMGS_URL . $value->thumbnail . '" height="50px" width="50px" >
								 <div class="modal fade" id="kt_modal_category_thumbnail_'.$value->id.'" tabindex="-1" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered mw-650px">
									<div class="modal-content">
										<div class="modal-header">
											<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
												<i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
											</div>
										</div>

										<div class="modal-body text-center scroll-y mx-5 mx-xl-15 my-7">
										<img src="' . IMGS_URL . $value->icon . '"  >
										</div>
									</div>
								</div>
							</div>
								';
							}
							$status = ($value->active == 1)
								? '<div class="badge badge-light-success">Active</div>'
								: '<div class="badge badge-light-danger">Not Active</div>';
							$status = '<span class="changeStatus" data-toggle="change-status" value="' . ($value->active == 1 ? 0 : 1) . '" data="' . $value->id . ',categories,id,active" title="Click to change status">' . $status . '</span>';
					
							$action = '<a href="' . base_url() . 'sellers/create_category/'.$consumer_id.'/'. $value->id . '" >
								<i class="fa fa-edit new-font-icon text-primary"></i>
								</a>
								<a href="javascript:void(0)" class="ms-3" data-kt-category-table-filter="delete_row" url="' . base_url() . 'sellers/delete_category/'.$consumer_id.'/'. $value->id . '" title="Delete Category">
								<i class="fa fa-trash new-font-icon text-primary"></i>
							</a>';
							$indexing='<input type="number" value="'.$value->seq.'" data="'.$value->id.',categories,id,seq" class="change-indexing" min="0" style="text-align:center;width:50px">';
							$data[] = array(
								$i++,
								$result,
								$value->name,
								'',
								'',
								$status,
								$indexing,
								$action,
								$value->id,
							);
							foreach($categories as $cat)
							{
							if($cat->parent==$value->id)
							 {
								if ($cat->thumbnail != null) {
									$result =  '<img class="thumbnail" data-bs-toggle="modal" data-bs-target="#kt_modal_category_thumbnail_'.$cat->id.'" style="cursor:pointer" src="' . IMGS_URL . $cat->thumbnail . '" height="50px" width="50px" >
									<div class="modal fade" id="kt_modal_category_thumbnail_'.$cat->id.'" tabindex="-1" aria-hidden="true">
								   <div class="modal-dialog modal-dialog-centered mw-650px">
									   <div class="modal-content">
										   <div class="modal-header">
											   <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
												   <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
											   </div>
										   </div>
   
										   <div class="modal-body text-center scroll-y mx-5 mx-xl-15 my-7">
										   <img src="' . IMGS_URL . $cat->icon . '"  >
										   </div>
									   </div>
								   </div>
							   </div>
								   ';
								}
								$status = ($cat->active == 1)
									? '<div class="badge badge-light-success">Active</div>'
									: '<div class="badge badge-light-danger">Not Active</div>';
								$status = '<span class="changeStatus" data-toggle="change-status" value="' . ($cat->active == 1 ? 0 : 1) . '" data="' . $cat->id . ',categories,id,active" title="Click to change status">' . $status . '</span>';
						
								$action = '<a href="' . base_url() . 'sellers/create_category/'.$consumer_id.'/'. $cat->id . '" >
									<i class="fa fa-edit new-font-icon text-primary"></i>
									</a>
									<a href="javascript:void(0)" class="ms-3" data-kt-category-table-filter="delete_row" url="' . base_url() . 'sellers/delete_category/'.$consumer_id.'/'. $cat->id . '" title="Delete Category">
									<i class="fa fa-trash new-font-icon text-primary"></i>
								</a>';
								$indexing='<input type="number" value="'.$cat->seq.'" data="'.$cat->id.',categories,id,seq" class="change-indexing" min="0" style="text-align:center;width:50px">';
								$data[] = array(
									'',
									$result,
									'',
									$cat->name,
									'',
									$status,
									$indexing,
									$action,
									$cat->id,
								);
								foreach($categories as $subcat)
                                {
                               if($subcat->parent == $cat->id)
                               {
								if ($subcat->thumbnail != null) {
									$result =  '<img class="thumbnail" data-bs-toggle="modal" data-bs-target="#kt_modal_category_thumbnail_'.$subcat->id.'" style="cursor:pointer" src="' . IMGS_URL . $subcat->thumbnail . '" height="50px" width="50px" >
									<div class="modal fade" id="kt_modal_category_thumbnail_'.$subcat->id.'" tabindex="-1" aria-hidden="true">
								   <div class="modal-dialog modal-dialog-centered mw-650px">
									   <div class="modal-content">
										   <div class="modal-header">
											   <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
												   <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
											   </div>
										   </div>
   
										   <div class="modal-body text-center scroll-y mx-5 mx-xl-15 my-7">
										   <img src="' . IMGS_URL . $subcat->icon . '"  >
										   </div>
									   </div>
								   </div>
							   </div>
								   ';
								}
								$status = ($subcat->active == 1)
									? '<div class="badge badge-light-success">Active</div>'
									: '<div class="badge badge-light-danger">Not Active</div>';
								$status = '<span class="changeStatus" data-toggle="change-status" value="' . ($subcat->active == 1 ? 0 : 1) . '" data="' . $subcat->id . ',categories,id,active" title="Click to change status">' . $status . '</span>';
						
								$action = '<a href="' . base_url() . 'sellers/create_category/'.$consumer_id.'/'. $subcat->id . '" >
									<i class="fa fa-edit new-font-icon text-primary"></i>
									</a>
									<a href="javascript:void(0)" class="ms-3" data-kt-category-table-filter="delete_row" url="' . base_url() . 'sellers/delete_category/'.$consumer_id.'/'. $subcat->id . '" title="Delete Category">
									<i class="fa fa-trash new-font-icon text-primary"></i>
								</a>';
								$indexing='<input type="number" value="'.$subcat->seq.'" data="'.$subcat->id.',categories,id,seq" class="change-indexing" min="0" style="text-align:center;width:50px">';
								$data[] = array(
									'',
									$result,
									'',
									'',
									$subcat->name,
									$status,
									$indexing,
									$action,
									$subcat->id,
								);
							   }
							   }
							 }
							}
							
						  }
						}
					
			echo json_encode(array('data' => $data));
		break;	
		case 'delete_category':
			if($this->Seller_model->_delete('categories',$p2))
			{
				logs($user->id,$p2,'DELETE','Category');
				$return['res'] = 'success';
				$return['msg'] = 'Deleted.';
			}
			echo json_encode($return);
		break; 
		case 'delete_selected_category':
			if (!$this->input->is_ajax_request()) {
				exit('No direct script access allowed');
			}
			$ids = $this->input->post('ids');

			if (!empty($ids)) {
				foreach ($ids as $id) {
				$this->Seller_model->_delete('categories',$id);
				logs($user->id,$id,'DELETE','Category');
				}
				echo json_encode(array('res' => 'success', 'msg' => 'Selected categories deleted successfully.'));
			} else {
				echo json_encode(array('res' => 'error', 'msg' => 'Selected category not deleted .'));
			}
	    break;
		case 'create_product':
			$data['seller_id']=$p1;	
			$data['remote']             = base_url().'buyers-sellers/remote/product/';
			$data['action_url']         = base_url().'sellers/save_product/'.$p1;
			$data['user_roles'] = $this->acl_model->get_user_roles();
			$data['parent_cat'] = $this->Seller_model->get_parent_category($p1);
			$data['parent_id'] = $this->Seller_model->get_parent_id();
			$data['units'] = $this->Seller_model->getData('min_order_qty_types',['is_deleted'=>'NOT_DELETED','active'=>'1']);
			$data['categories'] = $this->Seller_model->getData('categories',['consumer_id'=>$p1,'is_deleted'=>'NOT_DELETED','active'=>'1']);
			$data['contant']                      = 'admin/buyers-sellers/sellers/product/create';
			$data['title'] = 'Add Product';
			$data['user']=$user         = $this->checkLogin();
			$data['menu_url'] = $this->uri->segment(1);
			$data['breadcrumb']    = generate_breadcrumb($data['menu_url']);
			$data['scripts'] = [
				'admin/buyers-sellers/sellers/details/add_product',
			];		
			$data['companies']	    = $this->Seller_model->getData('consumers_company',['consumer_id'=>$p1]);
			$data['seller']         = $this->Seller_model->getRow('consumers',['id'=>$p1]);
			$data['seller_id']      = $p1;
			if ($p2!=null) {
				$data['scripts'] = [
					'admin/buyers-sellers/sellers/details/edit_product',
				];	
				$data['cat_pro_map']    = $this->Seller_model->get_cat_pro_map($p2);
				$data['remote']             = base_url().'buyers-sellers/remote/product/'.$p2;
				$data['action_url']     = base_url().'sellers/save_product/'.$p1.'/'.$p2;
				$data['value']          = $this->Seller_model->product($p2);
				$data['contant']                   = 'admin/buyers-sellers/sellers/product/update';
			}
			$this->template($data);
		break;
		case  'check_product_name':
			$product_name = $this->input->post('product_name');
			$exists = $this->Seller_model->check_product_name_exists($product_name);
	
			echo json_encode(['exists' => $exists]);
		break;
		case 'get_product':
			$consumer_id = @$_GET['consumer_id'];
			$pro_id = array();
			if (@$_GET['parent_cat']) {
				$pro_id = array();
				$get_proid = $this->db->get_where('cat_pro_maps',['cat_id' => $_GET['parent_cat']])->result();
				foreach($get_proid as $row){
					$pro_id[] = $row->pro_id;
				}
			}
			if (@$_GET['sub_cat']) {
				$pro_id = array();
				$get_proid = $this->db->get_where('cat_pro_maps',['cat_id' => $_GET['sub_cat']])->result();
				foreach($get_proid as $row){
					$pro_id[] = $row->pro_id;
				}
			}
			if (@$_GET['category']) {
				$pro_id = array();
				$get_proid = $this->db->get_where('cat_pro_maps',['cat_id' => $_GET['category']])->result();
				foreach($get_proid as $row){
					$pro_id[] = $row->pro_id;
				}
			} 
			$products = $this->Seller_model->get_all_products($pro_id,$consumer_id);
					$data = array();
					$i = 1;
					foreach ($products as $value) {
						if ($value->thumbnail != null) {
							$result =  '<img class="thumbnail" data-bs-toggle="modal" data-bs-target="#kt_modal_product_thumbnail_'.$value->id.'" style="cursor:pointer" src="' . IMGS_URL . $value->thumbnail . '" height="50px" width="50px" >
							 <div class="modal fade" id="kt_modal_product_thumbnail_'.$value->id.'" tabindex="-1" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered mw-650px">
								<div class="modal-content">
									<div class="modal-header">
										<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
											<i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
										</div>
									</div>

									<div class="modal-body text-center scroll-y mx-5 mx-xl-15 my-7">
									<img src="' . IMGS_URL . $value->pic . '"  >
									</div>
								</div>
							</div>
						</div>
							';
						}
						$status = ($value->active == 1)
							? '<div class="badge badge-light-success">Active</div>'
							: '<div class="badge badge-light-danger">Not Active</div>';
						$status = '<span class="changeStatus" data-toggle="change-status" value="' . ($value->active == 1 ? 0 : 1) . '" data="' . $value->id . ',products,id,active" title="Click to change status">' . $status . '</span>';
				
						$action = '<a  href="' . base_url() . 'sellers/view_product/'.$consumer_id.'/'. $value->id . '">
							<i class="fa fa-eye new-font-icon text-primary"></i>
							</a>
							<a class="ms-2"  href="' . base_url() . 'sellers/create_product/'.$consumer_id.'/'. $value->id . '">
							<i class="fa fa-edit new-font-icon text-primary"></i>
							</a>
							<a href="javascript:void(0)" class="ms-2" data-kt-product-table-filter="delete_row" url="' . base_url() . 'sellers/delete_product/'.$consumer_id.'/'. $value->id . '" title="Delete Product">
							<i class="fa fa-trash new-font-icon text-primary"></i>
						</a>';
						$indexing='<input type="number" value="'.$value->seq.'" data="'.$value->id.',products,id,seq" class="change-indexing" min="0" style="text-align:center;width:50px">';
						$data[] = array(
							$i++,
							$result,
							$value->name,
							$value->sku,
							$value->min_order_qty,
							$value->price,
							$status,
							$indexing,
							$action,
							$value->id,
						);
					}
				
		echo json_encode(array('data' => $data));
	  break;
	  case 'save_product':
			$id = $p2;
			$return['res'] = 'error';
			$return['msg'] = 'Not Saved!';

			if ($this->input->server('REQUEST_METHOD')=='POST') { 
			  
				 if ($id!=null) {
					if($this->input->post('cat_id')){
					$cat_id = count($this->input->post('cat_id'));
					$this->db->delete('cat_pro_maps', array('pro_id' => $id));
					logs($user->id,$id,'DELETE','Cat Pro Maps');
					$data = array(
							'name'              => $this->input->post('product_name'),
							'keywords'   => $this->input->post('keywords'),
							'sku'      => $this->input->post('product_sku'),
							'description'       => $this->input->post('description'),
							'price'        => $this->input->post('price'),
							'price_type'        => $this->input->post('price_unit'),
							'min_order_qty'        => $this->input->post('qty'),
							'min_order_type'        => $this->input->post('qty_unit'),
							'active'        => $this->input->post('status'),
						);
					if($this->Seller_model->edit_product($data,$id)){
						logs($user->id,$id,'EDIT','Edit Product');
						for ($i=0; $i < $cat_id; $i++) { 
							$data_cat_id = array(
								'pro_id'=>$id,
								'cat_id'=>$this->input->post('cat_id')[$i],
							   
							);
						   $mapid= $this->Seller_model->add_cat_pro_map($data_cat_id);
							$msg = 'Cat Pro Maps'.$id.'-'.$this->input->post('cat_id')[$i];
							logs($user->id,$mapid,'ADD',$msg);
						}
						$return['res'] = 'success';
						$return['msg'] = 'Product edit successfully!.';
						$return['url'] = base_url() . 'sellers/details/' . $p1;

					}
				  }else{
					$return['res'] = 'error';
					$return['msg'] = 'Product not updated because Please select atleast one cateogry.';
				  }
				}
				 else{ 
					if($this->input->post('cat_id')){
					$cat_id = count($this->input->post('cat_id'));
					$data = array(
							'name'              => $this->input->post('product_name'),
							'keywords'   => $this->input->post('keywords'),
							'sku'      => $this->input->post('product_sku'),
							'description'       => $this->input->post('description'),
							'price'        => $this->input->post('price'),
							'price_type'        => $this->input->post('price_unit'),
							'min_order_qty'        => $this->input->post('qty'),
							'min_order_type'        => $this->input->post('qty_unit'),
							'active'        => $this->input->post('status'),
						);

						$response = $this->Seller_model->add_product($data);
						if ($response->res === 'success') {
							for ($i=0; $i < $cat_id; $i++) { 
								$data_cat_id = array(
									'pro_id'=>$response->id,
									'cat_id'=>$this->input->post('cat_id')[$i],
								);
								$mapid=$this->Seller_model->add_cat_pro_map($data_cat_id);
								$msg = 'Cat Pro Maps'.$id.'-'.$this->input->post('cat_id')[$i];
								logs($user->id,$mapid,'ADD',$msg);
							}
							logs($user->id, $response->id, 'ADD', 'Product');
							$return['res'] = 'success';
							$return['msg'] = $response->msg;
							$return['url'] = base_url() . 'sellers/details/' . $p1;
						} else {
							$return['res'] = 'error';
							$return['msg'] = $response->msg;
						}
					   
				}else{
					$return['res'] = 'error';
					$return['msg'] = 'Product not uploaded because Please select atleast one cateogry.';
				}
			   }
			}
			echo json_encode($return);
			break;
			case 'delete_product':
				if($this->Seller_model->_delete('products',$p2))
				{
					logs($user->id,$p2,'DELETE','Product');
					$return['res'] = 'success';
					$return['msg'] = 'Deleted.';
				}
				echo json_encode($return);
			break; 
			case 'delete_selected_product':
				if (!$this->input->is_ajax_request()) {
					exit('No direct script access allowed');
				}
				$ids = $this->input->post('ids');
	
				if (!empty($ids)) {
					foreach ($ids as $id) {
					$this->Seller_model->_delete('products',$id);
					logs($user->id,$id,'DELETE','Product');
					}
					echo json_encode(array('res' => 'success', 'msg' => 'Selected products deleted successfully.'));
				} else {
					echo json_encode(array('res' => 'error', 'msg' => 'Selected products not deleted .'));
				}
			break;

			case 'view_product':
				$data['seller_id']=$p1;	
				$data['user_roles'] = $this->acl_model->get_user_roles();
				$data['parent_cat'] = $this->Seller_model->get_parent_category($p1);
				$data['parent_id'] = $this->Seller_model->get_parent_id();
				$data['units'] = $this->Seller_model->getData('min_order_qty_types',['is_deleted'=>'NOT_DELETED','active'=>'1']);
				$data['categories'] = $this->Seller_model->getData('categories',['consumer_id'=>$p1,'is_deleted'=>'NOT_DELETED','active'=>'1']);
				$data['contant']                      = 'admin/buyers-sellers/sellers/product/view_product';
				$data['title'] = 'View Product';
				$data['user']=$user         = $this->checkLogin();
				$data['menu_url'] = $this->uri->segment(1);
				$data['breadcrumb']    = generate_breadcrumb($data['menu_url']);		
				$data['seller']         = $this->Seller_model->getRow('consumers',['id'=>$p1]);
				$data['seller_id']      = $p1;
				$data['scripts'] = [
					'admin/buyers-sellers/sellers/details/product_status',
				];
				$data['cat_pro_map']    = $this->Seller_model->get_cat_pro_map($p2);
				$data['value']          = $this->Seller_model->product($p2);
				$this->template($data);
			break;	
			case 'update_product_status':
				$response = array('success' => false, 'message' => '');
			
				$verify_status = trim($this->input->post('product_status'));
				$remark = $this->input->post('remark');
				$product_id = $this->input->post('product_id');
			
				if ($verify_status !== null) {
					$data = array();
			
					if (!empty($verify_status)) {
						$data['status'] = $verify_status;
					}
					if ($remark !== null) {
						$data['remark'] = $remark;
					}
			
					$update = $this->Seller_model->Update('products', $data, ['id' => $product_id]);
			
					if ($update) {
						$response['success'] = true;
						$messages = array();
						
						   // Define appropriate messages based on status
						   switch ($verify_status) {
							case 'APPROVED':
								$messages[] = 'Product status updated to APPROVED successfully!';
								logs($user->id,$product_id,'CHANGE_STATUS','Product  status updated to APPROVED');
								break;
							case 'REJECTED':
								$messages[] = 'Product status updated to REJECTED successfully!';
								logs($user->id,$product_id,'CHANGE_STATUS','Product status updated to REJECTED');
								break;
							case 'PENDING':
								$messages[] = 'Product status updated to PENDING successfully!';
								logs($user->id,$product_id,'CHANGE_STATUS','Product  Status updated to PENDING');
								break;
							default:
								$messages[] = 'Product status updated successfully!';
								logs($user->id,$product_id,'CHANGE_STATUS','Product Change Status');
								break;
						}
			
						$response['message'] = implode(' ', $messages);
					} else {
						$response['message'] = 'Failed to update product status. Please try again.';
					}
				} else {
					$response['message'] = 'Please change status than click submit button.';
				}
			
				echo json_encode($response);
			break;
			case 'wallet':	
				$data['user_roles'] = $this->acl_model->get_user_roles();
				$data['contant']                      = 'admin/buyers-sellers/sellers/wallet';
				$data['title'] = 'Consumer Wallet';
				$data['user']=$user         = $this->checkLogin();
				$data['menu_url'] = $this->uri->segment(1);
				$data['menu_id'] = $this->uri->segment(3);
				$data['breadcrumb']    = generate_breadcrumb($data['menu_url']);		
				$data['seller']         = $this->Seller_model->getRow('consumers',['id'=>$p1]);
				$data['seller_id']      = $p1;
				$this->template($data);
		   break;		
		   case 'get_wallet':
			$general_master = $this->master_model->getRow('general_master',0);
			$seller_id = $this->input->get('seller_id');
			$daterange = $this->input->get('daterange');
		
			// Default to current date if no daterange is provided
			if (empty($daterange)) {
				$startDate = date('Y-m-d 00:00:00');
				$endDate = date('Y-m-d 23:59:59');
			} else {
				// Parse the daterange
				list($start, $end) = explode(' - ', $daterange);
				$startDate = date('Y-m-d 00:00:00', strtotime($start));
				$endDate = date('Y-m-d 23:59:59', strtotime($end));
			}
		
			$sellers = $this->Seller_model->getWalletByDateRange($seller_id, $startDate, $endDate);
		
			$data = array();
			$totalCredit = 0;
			$totalDebit = 0;
			$i = 1;
		
			// Loop through sellers and calculate totals
			foreach ($sellers as $seller) {
				$dateTime = new DateTime($seller->date);
				$formattedDate = $dateTime->format('M d, Y');
		
				$data[] = array(
					$i,
					$seller->transaction_head,
					$formattedDate,
					$general_master->currency.number_format($seller->credit, 2),
					$general_master->currency.number_format($seller->debit, 2),
				);
		
				$totalCredit += $seller->credit;
				$totalDebit += $seller->debit;
				$i++;
			}
		
			// Calculate balance
			$balance = $totalCredit - $totalDebit;
			$formattedBalance = number_format(abs($balance), 2);
		
			// Add total and balance rows
			$data[] = array(
				'', 
				'',
				'<span class="fw-bold text-dark">Total</span>',
				'<span class="fw-bold text-dark">'.$general_master->currency.number_format($totalCredit, 2).'</span>', 
				'<span class="fw-bold text-dark">'.$general_master->currency.number_format($totalDebit, 2).'</span>', 
			);
		
			$data[] = array(
				'',
				'',
				'<span class="fw-bold text-dark">Balance</span>',
				'<span class="fw-bold text-dark">'.$general_master->currency.$formattedBalance.'</span>',
				'',
			);
		
			echo json_encode(array('data' => $data));
			break;
		
		
			
        }
    }

  

	public function fetch_sub_categories()
    {
        if($this->input->post('parent_id'))
        {
            $parent_id= $this->input->post('parent_id');
			$consumer_id= $this->input->post('consumer_id');
            $this->Seller_model->fetch_sub_categories($consumer_id,$parent_id);
        }
    }

	public function fetch_categories()
    {
        if($this->input->post('parent_id'))
        {
            $parent_id= $this->input->post('parent_id');
			$consumer_id= $this->input->post('consumer_id');
            $this->Seller_model->fetch_categories($consumer_id,$parent_id);
        }
    }

    public function remote($type,$id=NULL,$column='name')
    {
        if ($type=='category') {
            $tb = 'categories';
        }
        elseif ($type=='user_role') {
            $tb ='tb_user_role';
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

	function url_character_remove($text)
{
    // replace non-alphanumeric characters with -
    $text = preg_replace('/[^a-z0-9]+/i', '-', $text);

    // trim
    $text = trim($text, '-');

    // lowercase
    $text = strtolower($text);

    return $text;
}

    public function fetch_submenu()
    {
        if($this->input->post('parent'))
        {
            $parent= $this->input->post('parent');
            $this->acl_model->fetch_submenu($parent);
        }
    }

}
