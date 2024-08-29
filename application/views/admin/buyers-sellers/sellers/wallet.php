       <!--begin::Content wrapper-->
	   <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
		<div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
		<!--begin::Toolbar container-->
		<div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
		<!--begin::Page title-->
		<?=$breadcrumb;?>
		<!--end::Page title-->
			<!--begin::Actions-->
			<div class="d-flex align-items-center gap-2 gap-lg-3">
				<!--begin::Filter menu-->
				<div class="m-0">
				<!--begin::Menu toggle-->
				<a href="<?=base_url();?>sellers/<?=$menu_id;?>" class="btn btn-sm btn-flex btn-danger fw-bold" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"><i class="ki-duotone ki-filter fs-6 text-muted me-1"><span class="path1"></span><span class="path2"></span></i> Back</a>
				<!--end::Menu toggle-->
			     </div>
				<!--end::Filter menu-->
				</div>
				<!--end::Actions-->
													</div>
													<!--end::Toolbar container-->
												</div>
											<!--end::Toolbar-->                                        
																
											<!--begin::Content-->
											<div id="kt_app_content" class="app-content  flex-column-fluid " >
												
													   
													<!--begin::Content container-->
													<div id="kt_app_content_container" class="app-container  container-xxl ">
											<div class="card mb-5 card-flush">
												<div class="card-header align-items-center py-5 gap-2 gap-md-5">
													<div class="card-title">
                                                     <table class="table table-responsive">
														<tr class="fw-semibold text-gray-600">
															<td>Seller Name : <span><?=$seller->contact_person;?></span></td>
															<td>Mobile Number: <?=$seller->mobile;?></td>
														</tr>
													 </table>
													</div>
												</div>
											</div>		
														<!--begin::Products-->
											<div class="card card-flush">
												<!--begin::Card header-->
												<div class="card-header align-items-center py-5 gap-2 gap-md-5">
													<!--begin::Card title-->
													<div class="card-title">
														<!--begin::Search-->
														<div class="d-flex align-items-center position-relative my-1">
															<i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4"><span class="path1"></span><span class="path2"></span></i>                <input type="text" data-kt-ecommerce-order-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Search By Transation Head" />
														</div>
														<!--end::Search-->
											
														<!--begin::Export buttons-->
														<div id="kt_ecommerce_wallet_export" class="d-none"></div>
														<!--end::Export buttons-->
													</div>
													<!--end::Card title-->
											
													<!--begin::Card toolbar-->
													<div class="card-toolbar flex-row-fluid justify-content-end gap-5">
														<!--begin::Daterangepicker-->
											<input class="form-control form-control-solid w-100 mw-250px" placeholder="Pick date range" id="kt_ecommerce_wallet_daterangepicker" />
											<!--end::Daterangepicker-->
											<input type="hidden" name="seller_id" id="seller_id" value="<?=$seller_id;?>">
											<!--begin::Export dropdown-->
											<button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
												<i class="ki-duotone ki-exit-up fs-2"><span class="path1"></span><span class="path2"></span></i>    Export Wallet
											</button>
											<!--begin::Menu-->
											<div id="kt_ecommerce_wallet_export_menu" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
												<!--begin::Menu item-->
												<div class="menu-item px-3">
													<a href="#" class="menu-link px-3" data-kt-ecommerce-export="copy">
														Copy to clipboard
													</a>
												</div>
												<!--end::Menu item-->
											
												<!--begin::Menu item-->
												<div class="menu-item px-3">
													<a href="#" class="menu-link px-3" data-kt-ecommerce-export="excel">
														Export as Excel
													</a>
												</div>
												<!--end::Menu item-->
											
												<!--begin::Menu item-->
												<div class="menu-item px-3">
													<a href="#" class="menu-link px-3" data-kt-ecommerce-export="csv">
														Export as CSV
													</a>
												</div>
												<!--end::Menu item-->
											
												<!--begin::Menu item-->
												<div class="menu-item px-3">
													<a href="#" class="menu-link px-3" data-kt-ecommerce-export="pdf">
														Export as PDF
													</a>
												</div>
												<!--end::Menu item-->
											 
											</div>
											<!--end::Menu-->
											<!--end::Export dropdown-->        </div>
													<!--end::Card toolbar-->
												</div>
												<!--end::Card header-->
											
												<!--begin::Card body-->
												<div class="card-body pt-0">
													
											<!--begin::Table-->
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_wallet_table">
												<thead>
													<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
														<th class="text-start min-w-75px"><span class="fw-bold text-dark">Sr. No.</span></th>
														<th class="text-start min-w-100px"><span class="fw-bold text-dark">Transation Head</span></th>
														<th class="text-start min-w-75px"><span class="fw-bold text-dark">Date</span></th>            
														<th class="text-start min-w-75px"><span class="fw-bold text-dark">Credit</span></th>
														<th class="text-start min-w-100px"><span class="fw-bold text-dark">Debit</span></th>
													</tr>
												</thead>
												<tbody class="fw-semibold text-gray-600"></tbody>

											</table>
											<!--end::Table--> 
										   </div>
												<!--end::Card body-->
											</div>
											<!--end::Products--> 
										       </div>
													<!--end::Content container-->
												</div>
											<!--end::Content-->	
											
																		
										</div>
									<!--end::Content wrapper-->
