<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Main.php');
class ACL extends Main {

    public function index()
    {
		$data['title'] = 'ACL';
		$data['contant'] = 'admin/acl/acl_data';
		$data['user']=$user         = $this->checkLogin();
        $menu_id = $this->uri->segment(2);
        $data['menu_id'] = $menu_id;
		$role_id = $user->user_role;
        $data['sub_menus'] = $this->Admin_model->get_submenu_data($menu_id,$role_id);
		$data['menu_url'] = $this->uri->segment(1);
        $data['breadcrumb']    = generate_breadcrumb($data['menu_url']);
		$this->template($data);
       
    }
    public function admin_menu($action=null,$p1=null,$p2=null,$p3=null)
    {
        $user         = $this->checkLogin();
        switch ($action) {
            case null:
				$data['title'] = 'Admin Menus';
				$data['contant'] = 'admin/acl/admin_menu/index';
				$data['user']=$user         = $this->checkLogin();
				$data['menu_url'] = $this->uri->segment(1);
				$data['breadcrumb']    = generate_breadcrumb($data['menu_url']);
				$data['tb_url']         = base_url().'admin-menu/tb';
                $data['new_url']        = base_url().'admin-menu/create';
				$data['script']         = 'admin/acl/admin_menu/table';
				$this->template($data);
                break;
				case 'get_admin_menu':
					$admin_menu = $this->Acl_model->get_all_admin_menu();
					$data = array();
					$i = 1;
				
					foreach ($admin_menu as $menu) {
						if ($menu->parent == "0") {
							$data[] = $this->format_menu_item($menu, $i, 'ms-0','',$menu->id);
							$i++;
							
							foreach ($admin_menu as $submenu) {
								if ($submenu->parent == $menu->id) {
									$data[] = $this->format_menu_item($submenu, '', 'ms-7','<i class="fa-solid fa-arrow-right"></i>',$submenu->id);
									foreach ($admin_menu as $submenu1) {
										if ($submenu1->parent == $submenu->id) {
											$data[] = $this->format_menu_item($submenu1, '', 'ms-15','<i class="fa-solid fa-arrow-right"></i>',$submenu1->id);
										}
									}
								}
							}
						}
					}
				
					echo json_encode(array('data' => $data));
					break;
                case 'create':
                    $data['remote']             = base_url().'remote/category/';
                    $data['action_url']         = base_url().'admin-menu/save';
                    $data['parent_menus'] = $this->Master_model->get_data1('tb_admin_menu','parent','0');
                    $page                       = 'admin/acl/admin_menu/create';
                    if ($p1!=null) {
                        $data['sub_parent']='';
                        $data['main_parent']='';
                        $data['remote']             = base_url().'remote/category/';
                        $data['action_url']     = base_url().'admin-menu/save/'.$p1;
                        $data['value']          = $this->Acl_model->get_row_data1('tb_admin_menu','id',$p1);
                        if($data['value']->parent!='0')
                        {
                            $menudata1 = $this->db->get_where('tb_admin_menu',['id'=>@$data['value'] ->parent])->row();
                            if(@$menudata1->parent=='0')
                            {
                                $data['main_parent']= $this->db->get_where('tb_admin_menu',['id'=>@$data['value'] ->parent])->row();
                            }else{
                                $data['sub_parent'] = $this->db->get_where('tb_admin_menu',['id'=>@$data['value']->parent])->row();
                                $data['main_parent']= $this->db->get_where('tb_admin_menu',['id'=>@$data['sub_parent'] ->parent])->row();
                            }
                        }
                       
                     
                        $page                   = 'admin/acl/admin_menu/update';
                    }
                    $this->load->view($page, $data);
                    break;
               
                    case 'save':
                        $id = $p1;
                        $return['res'] = 'error';
                        $return['msg'] = 'Not Saved!';

                        if ($this->input->server('REQUEST_METHOD')=='POST') {
                            if ($id!=null) {
                                $parent_id = $this->input->post('parent');
                                $sub_parent_id = $this->input->post('sub_parent');
                                if (!empty($parent_id) && empty($sub_parent_id)) {
                                    $parent = $parent_id;
                                } elseif (!empty($parent_id) && !empty($sub_parent_id)) {
                                    $parent = $sub_parent_id;   
                                } else {
                                    $parent = 0;
                                }
                                $data = array(
                                    'title'     => $this->input->post('title'),
                                    'icon_class'     => $this->input->post('icon_class'),
                                    'parent'     => $parent,
                                    'url'     => $this->input->post('url'),
                                    'indexing'     => $this->input->post('indexing'),
                                    );
                                if($this->Acl_model->edit_data('tb_admin_menu',$id,$data)){
									logs($user->id,$id,'EDIT','Admin Menus Edit ');
                                    $return['res'] = 'success';
                                    $return['msg'] = 'Updated.';
                                }
                            }
                            else{
                                $parent_id = $this->input->post('parent');
                                $sub_parent_id = $this->input->post('sub_parent');
                                if (!empty($parent_id) && empty($sub_parent_id)) {
                                    $parent = $parent_id;
                                } elseif (!empty($parent_id) && !empty($sub_parent_id)) {
                                    $parent = $sub_parent_id;   
                                } else {
                                    $parent = 0;
                                }
                                
                                $data = array(
                                    'title'     => $this->input->post('title'),
                                    'icon_class'     => $this->input->post('icon_class'),
                                    'parent'     => $parent,
                                    'url'     => $this->input->post('url'),
                                    'indexing'     => $this->input->post('indexing'),
                                    );
                                if ($insert_id=$this->Acl_model->add_data('tb_admin_menu',$data)) {
									logs($user->id,$insert_id,'ADD','Admin Menus Add ');
                                    $return['res'] = 'success';
                                    $return['msg'] = 'Saved.';
                                }
                            }
                        }
                        echo json_encode($return);
                        break;
                        case 'delete':
                            if($this->Acl_model->delete_data1('tb_admin_menu',$p1))
                            {
								logs($user->id,$p1,'DELETE','Admin Menus Delete ');
                                $return['res'] = 'success';
                                $return['msg'] = 'Deleted.';
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
						 $this->Acl_model->delete_data1('tb_admin_menu',$id);
						 logs($user->id,$id,'DELETE','Admin Menus Delete ');
						}
						echo json_encode(array('res' => 'success', 'msg' => 'Selected admin menus deleted successfully.'));
					} else {
						echo json_encode(array('res' => 'error', 'msg' => 'Selected admin menus not deleted .'));
					}
			   break;
                
        }
    }

	public function format_menu_item($menu, $index, $class,$icon,$id) {
		$status = ($menu->status == 1)
			? '<div class="badge badge-light-success">Active</div>'
			: '<div class="badge badge-light-danger">Not Active</div>';
		$status = '<span class="changeStatus" data-toggle="change-status" value="' . ($menu->status == 1 ? 0 : 1) . '" data="' . $menu->id . ',tb_admin_menu,id,status" title="Click to change status">' . $status . '</span>';
	
		$action = '<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#showModal" data-whatever="Update User (' . $menu->title . ')" data-url="' . base_url() . 'admin-menu/create/' . $menu->id . '">
			<i class="fa fa-edit text-primary"></i>
			</a>
			<a href="javascript:void(0)" class="ms-3" data-kt-menu-table-filter="delete_row" url="' . base_url() . 'admin-menu/delete/' . $menu->id . '" title="Delete User">
			<i class="fa fa-trash text-primary"></i>
			</a>';
	
		return array(
			$index,
			'<p class="' . $class . '">' .$icon.' '. $menu->title . '</p>',
			$menu->indexing,
			$status,
			$action,
			$id,
		);
	}
	public function users($action=null,$p1=null,$p2=null,$p3=null)
    {
        $user         = $this->checkLogin();
        switch ($action) {
            case null:
				$data['title'] = 'Users';
				$data['contant'] = 'admin/acl/users/index';
				$data['user']=$user         = $this->checkLogin();
				$data['menu_url'] = $this->uri->segment(1);
				$data['breadcrumb']    = generate_breadcrumb($data['menu_url']);
				$data['tb_url']         = base_url().'users/tb';
                $data['new_url']        = base_url().'users/create';
				$data['script']         = 'admin/acl/users/table';
				$this->template($data);
                break;
				case 'get_users':
					$users = $this->Acl_model->get_all_users();
					$data = array();
					$i = 1;
					foreach ($users as $user) {
						if ($user->photo != null) {
							$result =  '<img src="' . IMGS_URL . $user->photo . '" height="100px" width="100px" >';
						} else {
							$result = '<h1 style="height:70px;width:70px;border-radius:10px;padding-top:15px;font-size:3rem;text-align:center;text-transform:capitalize;background:#7271CF;color:#FFF">' . substr($user->name, 0, 1) . '</h1>';
						}
						$status = ($user->status == 1)
							? '<div class="badge badge-light-success">Active</div>'
							: '<div class="badge badge-light-danger">Not Active</div>';
						$status = '<span class="changeStatus" data-toggle="change-status" value="' . ($user->status == 1 ? 0 : 1) . '" data="' . $user->id . ',tb_admin,id,status" title="Click to change status">' . $status . '</span>';
				
						$action = '<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#showModal" data-whatever="Update User (' . $user->name . ')" data-url="' . base_url() . 'users/create/' . $user->id . '">
							<i class="fa fa-edit text-primary"></i>
							</a>
							<a href="javascript:void(0)" class="ms-3" data-kt-customer-table-filter="delete_row" url="' . base_url() . 'users/delete/' . $user->id . '" title="Delete User">
							<i class="fa fa-trash text-primary"></i>
							</a>';
				
						$data[] = array(
							$i,
							$result,
							$user->name,
							$user->username,
							$user->mobile,
							$user->email,
							$status,
							$action,
							$user->id,
						);
						$i++;
					}
				
					echo json_encode(array('data' => $data));
					break;
					
                case 'create':
                    $data['remote']             = base_url().'acl-data/remote/users/';
                    $data['action_url']         = base_url().'users/save';
                    $data['user_roles'] = $this->Acl_model->get_user_roles();
                    $page                       = 'admin/acl/users/create';
                    if ($p1!=null) {
                        $data['remote']             = base_url().'acl-data/remote/users/'.$p1;
                        $data['action_url']     = base_url().'users/save/'.$p1;
                        $data['value']          = $this->Acl_model->get_row_data('tb_admin','id',$p1);
                        $page                   = 'admin/acl/users/update';
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
                                    'username'     => $this->input->post('userName'),
                                    'password'     => $this->encryption->encrypt($this->input->post('password')),
                                    'name'     => $this->input->post('fullName'),
                                    'mobile'     => $this->input->post('contact'),
                                    'email'     => $this->input->post('email'),
                                    'user_role'     => $this->input->post('role_id'),
                                    );
                                if($this->Acl_model->edit_user($id,$data)){
									logs($user->id,$id,'EDIT','Users');
                                    $return['res'] = 'success';
                                    $return['msg'] = 'Updated.';
                                }
                            }
                            else{
                                $data = array(
                                    'username'     => $this->input->post('userName'),
                                    'password'     => $this->encryption->encrypt($this->input->post('password')),
                                    'name'     => $this->input->post('fullName'),
                                    'mobile'     => $this->input->post('contact'),
                                    'email'     => $this->input->post('email'),
                                    'user_role'     => $this->input->post('role_id'),
                                    );
                                if ($this->Acl_model->add_user($data)) {
									logs($user->id,$id,'ADD','Users');
                                    $return['res'] = 'success';
                                    $return['msg'] = 'Saved.';
                                }
                            }
                        }
                        echo json_encode($return);
                        break;
                        case 'delete':
                            if($this->Acl_model->delete_data('tb_admin',$p1))
                            {
								logs($user->id,$p1,'DELETE','Users');
                                $return['res'] = 'success';
                                $return['msg'] = 'Deleted.';
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
						 $this->Acl_model->delete_data('tb_admin',$id);
						 logs($user->id,$id,'DELETE','Users');
						}
						echo json_encode(array('res' => 'success', 'msg' => 'Selected users deleted successfully.'));
					} else {
						echo json_encode(array('res' => 'error', 'msg' => 'Selected users not deleted .'));
					}
			   break;		
        }
    }
    
   
    public function user_role($action=null,$p1=null,$p2=null,$p3=null)
    {
        $user         = $this->checkLogin();
        switch ($action) {
            case null:
				$data['title'] = 'User Role';
				$data['contant'] = 'admin/acl/user_role/index';
				$data['user']=$user         = $this->checkLogin();
				$data['menu_url'] = $this->uri->segment(1);
				$data['breadcrumb']    = generate_breadcrumb($data['menu_url']);
				$data['tb_url']         = base_url().'user-role/tb';
                $data['new_url']        = base_url().'user-role/create';
				$data['script']         = 'admin/acl/user_role/table';
				$this->template($data);
                break;
				case 'get_user_role':
					$userrole = $this->Acl_model->user_role_new();
					$data = array();
					$i = 1;
					$url = 'menu_access/';
					$url1 = 'desc/';
					foreach ($userrole as $user) {
	
						$status = ($user->status == 1)
							? '<div class="badge badge-light-success">Active</div>'
							: '<div class="badge badge-light-danger">Not Active</div>';
						$status = '<span class="changeStatus" data-toggle="change-status" value="' . ($user->status == 1 ? 0 : 1) . '" data="' . $user->id . ',tb_user_role,id,status" title="Click to change status">' . $status . '</span>';
				
						$action = '<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#showModal" data-whatever="Update User (' . $user->name . ')" data-url="' . base_url() . 'user-role/create/' . $user->id . '">
							<i class="fa fa-edit text-primary"></i>
							</a>
							<a href="javascript:void(0)" class="ms-3"data-kt-role-table-filter="delete_row" url="' . base_url() . 'user-role/delete/' . $user->id . '" title="Delete User">
							<i class="fa fa-trash text-primary"></i>
							</a>';
						    $desc = strip_tags( $user->description);
							$desc = substr($desc,0,15);
							$result= $desc; ?>
							<?php if(strlen($user->description) > 15){    
							$result= '.... <button class="btn btn-sm btn-primary btn-xs" data-bs-toggle="modal" data-whatever="Description - "'.$user->name.'" data-url="'.$url1.$user->id.'"  data-bs-target="#showModal">Read More</button>';
							 }
							 $menu = '<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#showModal" data-whatever="Menu Access - "'.$user->name.'" data-url="'.$url.$user->id.'" class="btn btn-primary btn-sm"> Manage </a>';
						$data[] = array(
							$i,
							$user->name,
							$result,
							$menu,
							$status,
							$action,
							$user->id
						);
						$i++;
					}
				
					echo json_encode(array('data' => $data));
					break;
				case 'desc':
					$data['value']          = $this->Acl_model->get_row_data('tb_user_role','id',$p1);
					$page                   = 'admin/acl/user_role/desc';
                    $this->load->view($page, $data);
				break;
                case 'create':
                    $data['remote']             = base_url().'acl-data/remote/user_role/';
                    $data['action_url']         = base_url().'user-role/save';
                    $page                       = 'admin/acl/user_role/create';
                    if ($p1!=null) {
                        $data['remote']             = base_url().'acl-data/remote/user_role/';
                        $data['action_url']     = base_url().'user-role/save/'.$p1;
                        $data['value']          = $this->Acl_model->get_row_data('tb_user_role','id',$p1);
                        $page                   = 'admin/acl/user_role/update';
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
                                    'name'     => $this->input->post('name'),
                                    'description'     => $this->input->post('description'),
                                    );
                                if($this->Acl_model->edit_data('tb_user_role',$id,$data)){
									logs($user->id,$id,'EDIT','Users Role');
                                    $return['res'] = 'success';
                                    $return['msg'] = 'Updated.';
                                }
                            }
                            else{
                                $data = array(
                                    'name'     => $this->input->post('name'),
                                    'description'     => $this->input->post('description'),
                                    );
                                if ($insert_id=$this->Acl_model->add_data('tb_user_role',$data)) {
									logs($user->id,$insert_id,'ADD','Users Role');
                                    $return['res'] = 'success';
                                    $return['msg'] = 'Saved.';
                                }
                            }
                        }
                        echo json_encode($return);
                        break;
                        case 'delete':
                            if($this->Acl_model->delete_data('tb_user_role',$p1))
                            {
								logs($user->id,$p1,'DELETE','Users Role');
                                $return['res'] = 'success';
                                $return['msg'] = 'Deleted.';
                            }
                            echo json_encode($return);
                            break;
                            case 'menu_access':
                                $return['res'] = 'error';
                                $return['msg'] = 'Not Saved!';
                                $saved = 0;
                                if ($this->input->server('REQUEST_METHOD')=='POST') {
                                    $menu_id    = $_POST['m_id'];
                                    $type   	= $_POST['type'];
                                    $user_role    = $p1;
                                    $row = $this->Acl_model->getRow('tb_admin_menu',['id'=>$menu_id]);
                                    if($row){
                                        $check['role_id']   = $user_role;
                                        $check['menu_id'] 	= $menu_id;
                                        $value = 0;
                                        if ($type=='set'){
                                            $value = 1;
                                        }
                                        if ($type=='set' && $_POST['name']=='') {
                                            if($this->Acl_model->getRow('tb_role_menus',$check)){
                                                if ($this->Acl_model->Update('tb_role_menus',$update,$check)) {
                                                    $saved = 1;
													logs($user->id,$user_role,'EDIT','Assign User Role');
                                                }
                                            }
                                            else{
                                                if ($this->Acl_model->Save('tb_role_menus',$check)) {
                                                    $saved = 1;
													logs($user->id,$user_role,'EDIT','Assign User Role');
                                                }
                                            }
                                        }
                                        else if($_POST['name']!=''){
                                            $update[$_POST['name']] = $value;
                                            if($this->Acl_model->getRow('tb_role_menus',$check)){
                                                if ($this->Acl_model->Update('tb_role_menus',$update,$check)) {
                                                    $saved = 1;
													logs($user->id,$user_role,'EDIT','Assign User Role');
                                                }
                                            }
                                            else{
                                                $return['msg'] = 'Menu Not Assigned!';
                                            }
                                        }
                                        else{
                                            if ($this->Acl_model->Delete('tb_role_menus',$check)) {
                                                $saved = 1;
												logs($user->id,$user_role,'EDIT','Assign User Role');
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
                                    $page     = 'admin/acl/user_role/menu_access';
                                    $data['m_access_url'] =  base_url().'user-role/menu_access/';
                                    $menus   = $this->Acl_model->admin_menus();
                                    $data['user_role'] = $user_role = $p1;
                                    if ($menus) {
                                        foreach ($menus as $row) {
                                            $row->checked = '';
                                            $row->c_checked = '';
                                            $row->u_checked = '';
                                            $row->d_checked = '';
                                            if ($t = $this->Acl_model->getRow('tb_role_menus',['menu_id'=>$row->id,'role_id'=>$user_role])) {
                                                $row->checked = 'checked';
                                            }
                                            if (@$t->add==1) {
                                                $row->c_checked = 'checked';
                                            }
                                            if (@$t->update==1) {
                                                $row->u_checked = 'checked';
                                            }
                                            if (@$t->delete==1) {
                                                $row->d_checked = 'checked';
                                            }
                                        }
                                    }
                
                                    // $this->pr($menus);
                                    $data['menus']  = $menus;
                                    $this->load->view($page,$data);
                                }
                 break;
				 case 'delete_selected':
					if (!$this->input->is_ajax_request()) {
						exit('No direct script access allowed');
					}
					$ids = $this->input->post('ids');
				
					if (!empty($ids)) {
						foreach ($ids as $id) {
						 $this->Acl_model->delete_data('tb_user_role',$id);
						 logs($user->id,$id,'DELETE','Users Role');
						}
						echo json_encode(array('res' => 'success', 'msg' => 'Selected user role deleted successfully.'));
					} else {
						echo json_encode(array('res' => 'error', 'msg' => 'Selected user role not deleted .'));
					}
			   break;       
        }
    }

   
    public function remote($type,$id=null,$column='name')
    {
        if ($type=='users') {
            $tb = 'tb_admin';
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


    public function fetch_submenu()
    {
        if($this->input->post('parent'))
        {
            $parent= $this->input->post('parent');
            $this->Acl_model->fetch_submenu($parent);
        }
    }

}
