

<div class="d-flex flex-column flex-column-fluid">
                                            
<!--begin::Toolbar-->
 <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
	<!--begin::Toolbar container-->
	<div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
	  <!--begin::Page title-->
	  <?=$breadcrumb;?>
	  <!--end::Page title-->
	</div>
	<!--end::Toolbar container-->
  </div>
<!--end::Toolbar-->                                        
		<!--begin::Content-->
		<div id="kt_app_content" class="app-content  flex-column-fluid " >
		<!--begin::Content container-->
		<div id="kt_app_content_container" class="app-container  container-xxl ">
		<!--begin::Card-->
			<div class="card">
			 <!--begin::Card header-->
				<div class="card-header border-0 pt-6">
					<!--begin::Card title-->
					<div class="card-title">
						<!--begin::Search-->
							<div class="d-flex align-items-center position-relative my-1">
							<i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span class="path1"></span><span class="path2"></span></i>                <input type="text" data-kt-role-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search User Roles" />
							</div>
						<!--end::Search-->
					</div>
			<!--begin::Card title-->
											
				<!--begin::Card toolbar-->
				<div class="card-toolbar">
					<!--begin::Toolbar-->
						<div class="d-flex justify-content-end" data-kt-role-table-toolbar="base">
											
					<!--begin::Add role-->
					<button type="button" class="btn btn-primary" data-whatever="New <?=$title?>" data-url="<?=$new_url?>" data-bs-toggle="modal" data-bs-target="#showModal">Add <?=$title;?> </button>
					<!--end::Add role-->
					</div>
					<!--end::Toolbar-->
											
					<!--begin::Group actions-->
					<div class="d-flex justify-content-end align-items-center d-none" data-kt-role-table-toolbar="selected">
					<div class="fw-bold me-5">
					<span class="me-2" data-kt-role-table-select="selected_count"></span> Selected
					</div>
					<button type="button" class="btn btn-danger" data-kt-role-table-select="delete_selected">
					Delete Selected</button>
					</div>
					<!--end::Group actions-->       
				 </div>
				<!--end::Card toolbar-->
				</div>
			  <!--end::Card header-->
				<!--begin::Card body-->
				<div class="card-body pt-0">
													
					<!--begin::Table-->
					<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_roles_table">
					<thead>
					<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
					<th class="w-10px pe-2">
					<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
					<input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_roles_table .form-check-input" value="1" />
					</div>
					</th>
					<th class="text-start min-w-40px"><span class="fw-bold text-dark">S.No.</span></th>
					<th class="text-start min-w-50px"><span class="fw-bold text-dark">NAME</span></th>
					<th class="text-start min-w-50px"><span class="fw-bold text-dark">DESCRIPTION</span></th>
					<th class="text-start min-w-50px"><span class="fw-bold text-dark">MENUS & PERMISSIONS</span></th>
					<th class="text-start min-w-100px"><span class="fw-bold text-dark">STATUS</span></th>
					<th class="text-start min-w-70px"><span class="fw-bold text-dark">ACTIONS</span></th>
					</tr>
					</thead>
					<tbody class="fw-semibold text-gray-600">
					
					</tbody>
					<!--end::Table body-->
					</table>
				<!--end::Table-->    </div>
			<!--end::Card body-->
			</div>
		</div>
	<!--end::Content container-->
	</div>
<!--end::Content-->	
</div>

