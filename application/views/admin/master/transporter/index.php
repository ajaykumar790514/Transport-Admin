    <!--begin::Content wrapper-->
	<div class="d-flex flex-column flex-column-fluid">
                                            
											<!--begin::Toolbar-->
											<div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 " 
												 
													 >
											
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
															<i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span class="path1"></span><span class="path2"></span></i>              
															  <input type="text" data-kt-transporter-table-filter="search" class="form-control form-control-solid w-350px ps-12" placeholder="Search Transport for Company Name" />
														</div>
														<!--end::Search-->
													</div>
													<!--begin::Card title-->
											
													<!--begin::Card toolbar-->
													<div class="card-toolbar">
														<!--begin::Toolbar-->
											<div class="d-flex justify-content-end" data-kt-transporter-table-toolbar="base">
												<!--begin::Add transporter-->
												<button type="button" class="btn btn-primary" data-whatever="New <?=$title?>" data-url="<?=$new_url?>" data-bs-toggle="modal" data-bs-target="#showModal">Add <?=$title;?> </button>
												<!--end::Add transporter-->
											</div>
											<!--end::Toolbar-->
											
											<!--begin::Group actions-->
											<div class="d-flex justify-content-end align-items-center d-none" data-kt-transporter-table-toolbar="selected">
												<div class="fw-bold me-5">
													<span class="me-2" data-kt-transporter-table-select="selected_count"></span> Selected
												</div>
											
												<button type="button" class="btn btn-danger" data-kt-transporter-table-select="delete_selected">
													Delete Selected
												</button>
											</div>
											<!--end::Group actions-->        </div>
													<!--end::Card toolbar-->
												</div>
												<!--end::Card header-->
											
												<!--begin::Card body-->
												<div class="card-body pt-0">
													
											<!--begin::Table-->
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_transporter_table">
												<thead>
													<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
														<th class="w-10px pe-2">
															<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
																<input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_transporter_table .form-check-input" value="1" />
															</div>
														</th>
														<th class="min-w-70px"><span class="fw-bold text-dark">Sr.No.</span></th>
														<th class="min-w-70px"><span class="fw-bold text-dark">Logo</span></th>
														<th class="min-w-125px"><span class="fw-bold text-dark">Company Name</span></th>
														<th class="min-w-125px"><span class="fw-bold text-dark">What You Provide</span></th> 
														<th class="min-w-125px"><span class="fw-bold text-dark">Mobile </span></th>  
														<th class="min-w-125px"><span class="fw-bold text-dark">Email </span></th>            
														<th class="min-w-125px"><span class="fw-bold text-dark">Minimum Load</span></th> 
														<th class="min-w-125px"><span class="fw-bold text-dark">Address</span></th> 
														<th class="min-w-125px"><span class="fw-bold text-dark">Status</span></th>
														<th class="min-w-70px"><span class="fw-bold text-dark">Actions</span></th>
													</tr>
												</thead>
												<tbody class="fw-semibold text-gray-600">
												</tbody>
											</table>
											<!--end::Table-->    </div>
												<!--end::Card body-->
											</div>
											<!--end::Card-->
											
											
										</div>
										<!--end::Content container-->
									</div>
					<!--end::Content-->	
											
					</div>
			<!--end::Content wrapper-->
