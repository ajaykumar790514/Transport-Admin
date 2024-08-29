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
										<!--begin::Actions-->
									<div class="d-flex align-items-center gap-2 gap-lg-3">
										<!--begin::Filter menu-->
										<div class="m-0">
										<!--begin::Menu toggle-->
										<a href="<?=base_url();?>sellers/details/<?=$seller_id;?>" class="btn btn-sm btn-flex btn-danger fw-bold" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"><i class="ki-duotone ki-filter fs-6 text-muted me-1"><span class="path1"></span><span class="path2"></span></i> Back</a>
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
														<!--begin::Layout-->
											<div class="d-flex flex-column flex-xl-row">
												<!--begin::Sidebar-->
												<div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
													
											<!--begin::Card-->
											<div class="card mb-5 mb-xl-8">
												<!--begin::Card body-->
												<div class="card-body pt-15">
													<!--begin::Summary-->
													<div class="d-flex flex-center flex-column mb-5">
														<!--begin::Avatar-->
														<div class="symbol symbol-150px  mb-7">
															<img src="<?=IMGS_URL.$value->thumbnail;?>" alt="image" />
														</div>
														<!--end::Avatar-->
											
														<!--begin::Name-->
														<a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1">
														<?=$value->name;?>      </a>
														<!--end::Name-->
													</div>
													<!--end::Summary-->
											
													<!--begin::Details toggle-->
													<div class="d-flex flex-stack fs-4 py-3">
														<div class="fw-bold">
															Product Details 
														</div>
											
													
													</div>
													<div class="modal fade" id="kt_modal_product_status" tabindex="-1" aria-hidden="true">
													<div class="modal-dialog modal-dialog-centered mw-650px">
														<div class="modal-content">
															<div class="modal-header">
																<h2>Update Status : <?= $value->name; ?></h2>
																<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
																	<i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
																</div>
															</div>

															<div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
																<form id="kt_modal_product_status_form" class="form" action="#">
																	<input type="hidden" name="product_id" value="<?= $value->id; ?>">
																	<div class="d-flex flex-column mb-7 fv-row">
																		<label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
																			<span class="required">Select Status</span>
																			<span class="ms-1" data-bs-toggle="tooltip">
																				<i class="ki-duotone ki-information-5 text-gray-500 fs-6"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
																			</span>
																		</label>
																		<select class="form-control form-control-solid" name="product_status" id="kt_modal_product_status_name">
																				<?php if($value->status=='APPROVED'){?>
																					<option value="APPROVED" <?= $value->status=='APPROVED	' ? 'selected' : ''; ?>>APPROVED	</option>
																				<?php }else{?>
																					<option value="PENDING" <?=$value->status=='PENDING' ? 'selected' : ''; ?>>PENDING</option>
																					<option value="APPROVED	" <?= $value->status=='APPROVED	' ? 'selected' : ''; ?>>APPROVED	</option>
																					<option value="REJECTED" <?= $value->status=='REJECTED' ? 'selected' : ''; ?>>REJECTED</option>
																				<?php }?>
																			</select>
																	</div>
																	<div class="d-flex flex-column mb-7 fv-row <?= $value->status == 'REJECTED' ? '' : 'd-none'; ?>">
																		<label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
																			<span class="required">Rejection Remark</span>
																			<span class="ms-1" data-bs-toggle="tooltip" title="Specify a rejection remark">
																				<i class="ki-duotone ki-information-5 text-gray-500 fs-6"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
																			</span>
																		</label>
																		<textarea class="form-control form-control-solid" name="remark"></textarea>
																	</div>
																	<div class="text-center pt-15">
																		<button type="reset" id="kt_modal_product_status_cancel" class="btn btn-light me-3">
																			Discard
																		</button>
																		<button type="submit" id="kt_modal_product_status_submit" class="btn btn-primary">
																			<span class="indicator-label">Submit</span>
																			<span class="indicator-progress">
																				Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
																			</span>
																		</button>
																	</div>
																</form>
															</div>
														</div>
													</div>
												</div>
													<!--end::Details toggle-->
											
													<div class="separator separator-dashed my-3"></div>
											
													<!--begin::Details content-->
													<div class="pb-5 fs-6">
																		<!--begin::Details item-->
															<div class="fw-bold mt-5">Keywords</div>
															<div class="text-gray-600"><?=$value->keywords;?></div>
															<!--begin::Details item-->
																		<!--begin::Details item-->
															<div class="fw-bold mt-5">SKU</div>
															<div class="text-gray-600"><a href="#" class="text-gray-600 text-hover-primary"><?=$value->sku;?></a></div>
															<!--begin::Details item-->
																		<!--begin::Details item-->
															<div class="fw-bold mt-5">Quantity</div>
															<div class="text-gray-600"><?=$value->min_order_qty;?> <?=$value->qty_unit;?></div>
															<!--begin::Details item-->
																		<!--begin::Details item-->
															<div class="fw-bold mt-5">Price</div>
															<div class="text-gray-600">Rs. <?=$value->price;?> /	<?=$value->price_unit;?></div>
															<div class="fw-bold mt-5">Approval Status  <?php if($value->status=='APPROVED'){?>
														<i class="fa-solid fa-circle-check text-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>                        
														<?php }elseif($value->status=='REJECTED'){?>
														<i class="fa-solid fa-circle-xmark text-danger"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>  
														<?php }else{?>
														<i class="fa-solid fa-hourglass-half text-warning"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>  
													<?php }?>
													<a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3 float-right" data-bs-toggle="modal" data-bs-target="#kt_modal_product_status">
													<span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Change Product Status">                                
														<i class="ki-duotone ki-pencil fs-3"><span class="path1"></span><span class="path2"></span></i>
													</span>
												</a></div>
															<div class="text-gray-600"><?=$value->status;?> </div>

															
															<!--begin::Details item-->
																</div>
													<!--end::Details content-->
												</div>
												<!--end::Card body-->
											</div>
											<!--end::Card-->    </div>
												<!--end::Sidebar-->
											
												<!--begin::Content-->
												<div class="flex-lg-row-fluid ms-lg-15">
													<!--begin:::Tabs-->
													<ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
														<!--begin:::Tab item-->
														<li class="nav-item">
															<a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_ecommerce_customer_overview">Overview</a>
														</li>
														<!--end:::Tab item-->
													</ul>
													<!--end:::Tabs-->
											
													<!--begin:::Tab content-->
													<div class="tab-content" id="myTabContent">
														<!--begin:::Tab pane-->
														<div class="tab-pane fade show active" id="kt_ecommerce_customer_overview" role="tabpanel">
											
											
															<!--begin::Card-->
											<div class="card pt-4 mb-6 mb-xl-9">
												<!--begin::Card header-->
												<div class="card-header border-0">
													<!--begin::Card title-->
													<div class="card-title">
														<h2>Descriptions</h2>
													</div>
													<!--end::Card title-->
												</div>
												<!--end::Card header-->
											
												<!--begin::Card body-->
												<div class="card-body pt-0 pb-5">
												<?=$value->description;?>
												</div>
												<!--end::Card body-->
											</div>
											<!--end::Card-->            </div>
														<!--end:::Tab pane-->
											
													</div>
													<!--end:::Tab content-->
												</div>
												<!--end::Content-->
											</div>
											<!--end::Layout-->
											
											<!--begin::Modals-->
										

											<!--end::Modals-->     
										   </div>
													<!--end::Content container-->
												</div>
											<!--end::Content-->	
											
																				</div>
															<!--end::Content wrapper-->
