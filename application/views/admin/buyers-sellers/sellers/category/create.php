
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
	<input type="hidden" id="remote" value="<?=$remote?>">
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
	<form id="kt_ecommerce_add_category_form" class="categorysubmit needs-validation form d-flex flex-column flex-lg-row" action="<?=$action_url?>" method="post" enctype= multipart/form-data>
		<input type="hidden" name="consumer_id" id="consumer_id" value="<?=$seller_id;?>">
	<!--begin::Aside column-->
	<div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
		
													<!--begin::Thumbnail settings-->
											<div class="card card-flush py-4">
												<!--begin::Card header-->
												<div class="card-header">
													<!--begin::Card title-->
													<div class="card-title">
														<h2>Thumbnail</h2>
													</div>
													<!--end::Card title-->
												</div>
												<!--end::Card header-->
											
												<!--begin::Card body-->
												<div class="card-body text-center pt-0">
													<!--begin::Image input-->
																<!--begin::Image input placeholder-->
														<style>
															.image-input-placeholder {
																background-image: url('<?=base_url();?>assets/media/svg/files/blank-image.svg');
															}
											
															[data-bs-theme="dark"] .image-input-placeholder {
																background-image: url('<?=base_url();?>assets/media/svg/files/blank-image-dark.svg');
															}                
														</style>
														<!--end::Image input placeholder-->
													
													<!--begin::Image input-->
													<div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3" data-kt-image-input="true">
														<!--begin::Preview existing avatar-->
																		<div class="image-input-wrapper w-150px h-150px"></div>
																	<!--end::Preview existing avatar-->
											
														<!--begin::Label-->
														<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
															<!--begin::Icon-->
															<i class="ki-duotone ki-pencil fs-7"><span class="path1"></span><span class="path2"></span></i>                <!--end::Icon-->
											
															<!--begin::Inputs-->
															<input type="file" accept=".png, .jpg, .jpeg" id="categoryImage" name="icon" />
															<input type="hidden" name="avatar_remove" />
															<!--end::Inputs-->
														</label>
														<!--end::Label-->
											
														<!--begin::Cancel-->
														<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
															<i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>            </span>
														<!--end::Cancel-->
											
														<!--begin::Remove-->
														<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
															<i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>            </span>
														<!--end::Remove-->
													</div>
													<!--end::Image input-->
											
													<!--begin::Description-->
													<div class="text-muted fs-7">Set the category thumbnail image. Only *.png, *.jpg, *.webp and *.jpeg image files are accepted or file size 200kb.</div>
													<!--end::Description-->
												</div>
												<!--end::Card body-->
											</div>
											<!--end::Thumbnail settings-->
													<!--begin::Status-->
											<div class="card card-flush py-4">
												<!--begin::Card header-->
												<div class="card-header">
													<!--begin::Card title-->
													<div class="card-title">
														<h2>Status</h2>
													</div>
													<!--end::Card title-->
											
													<!--begin::Card toolbar-->
													<div class="card-toolbar">
														<div class="rounded-circle bg-success w-15px h-15px" id="kt_ecommerce_add_category_status"></div>
													</div>
													<!--begin::Card toolbar-->
												</div>
												<!--end::Card header-->
											
												<!--begin::Card body-->
												<div class="card-body pt-0">
													<!--begin::Select2-->
													<select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Select an option" name="status"  id="kt_ecommerce_add_category_status_select">
														<option></option>
														<option value="1" selected>Active</option>
														<option value="0">Inactive</option>
													</select>
													<!--end::Select2-->
											
													<!--begin::Description-->
													<div class="text-muted fs-7">Set the category status.</div>
													<!--end::Description-->
											
													<!--begin::Datepicker-->
													<div class="d-none mt-10">
														<label for="kt_ecommerce_add_category_status_datepicker" class="form-label">Select publishing date and time</label>
														<input class="form-control" id="kt_ecommerce_add_category_status_datepicker" placeholder="Pick date & time" />
													</div>
													<!--end::Datepicker-->
												</div>
												<!--end::Card body-->
											</div>
											<!--end::Status-->
												
										</div>
												<!--end::Aside column-->
											
												<!--begin::Main column-->
												<div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
													<!--begin::General options-->
											<div class="card card-flush py-4">
												<!--begin::Card header-->
												<div class="card-header">
													<div class="card-title">
														<h2>General</h2>
													</div>
												</div>
												<!--end::Card header-->
											
												<!--begin::Card body-->
												<div class="card-body pt-0">
													<div class="row container">
													<!--begin::Input group-->
													<div class="mb-10 fv-row col-lg-4">
														<!--begin::Label-->
														<label class="required form-label">Parent Category</label>
														<!--end::Label-->
											
														<!--begin::Input-->
														<select class="form-select form-select-solid "  name="parent_id" onchange="fetch_sub_categories(this.value)"  >
														<option value="">--Select--</option>
														<?php foreach ($parent_cat as $parent) { ?>
														<option value="<?php echo $parent->id; ?>">
															<?php echo $parent->name; ?>
														</option>
														<?php } ?>
														</select>
														<!--end::Input-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="mb-10 fv-row col-lg-4">
														<!--begin::Label-->
														<label class="required form-label">Sub Categories</label>
														<!--end::Label-->
											
														<!--begin::Input-->
														<select class="form-select form-select-solid sub_cat_id" style="width:100%;" name="sub_cat_id" id="sub_cat_id" >
                                                
												      </select>
														<!--end::Input-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="mb-10 fv-row col-lg-4">
														<!--begin::Label-->
														<label class="required form-label">Category Name</label>
														<!--end::Label-->
											
														<!--begin::Input-->
																	<input type="text" name="name" class="form-control form-control-solid mb-2" placeholder="Category name" value="" />
														<!--end::Input-->
											
														<!--begin::Description-->
														<div class="text-muted fs-7">A category name is required and recommended to be unique.</div>
														<!--end::Description-->
													</div>
													<!--end::Input group-->
															<!--begin::Input group-->
															<div class="mb-10 fv-row col-lg-12">
														<!--begin::Label-->
														<label class=" form-label">Seq</label>
														<!--end::Label-->
											
														<!--begin::Input-->
																	<input type="text" name="seq" class="form-control form-control-solid mb-2" placeholder="Seq" value="" />
														<!--end::Input-->
													</div>
													<!--end::Input group-->
											
													<!--begin::Input group-->
													<div>
													
													</div>
													<!--end::Input group-->
												</div>
												<!--end::Card header-->
												</div>
											</div>
											<!--end::General options-->
												
													
													<div class="d-flex justify-content-end">
														 <!--begin::Button-->
														 <a href="<?=base_url();?>sellers/details/<?=$seller_id;?>" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">
															Cancel
														</a>
														<!--end::Button-->
											
														<!--begin::Button-->
														<button type="submit" id="kt_ecommerce_add_category_submit" class="btn btn-primary">
															<span class="indicator-label">
																Add Category
															</span>
															<span class="indicator-progress">
																Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
															</span>
														</button>
														<!--end::Button-->
													</div>
												</div>
												<!--end::Main column-->
											</form>        </div>
													<!--end::Content container-->
												</div>
											<!--end::Content-->	
										</div>
						<!--end::Content wrapper-->
  
						