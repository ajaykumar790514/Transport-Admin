<style>
	.form-check {
		padding-top: 7px;
    position: relative;
    display: block;
    padding-left: 3.25rem;
}
[type=checkbox]+label {
    padding-left: 26px;
    height: 25px;
    line-height: 21px;
    font-weight: normal;
}

[type=checkbox]+label {
    position: relative;
    padding-left: 1px;
    cursor: pointer;
    display: inline-block;
    height: 25px;
    line-height: 25px;
    font-size: 1rem;
}
.form-check-input {
    --bs-form-check-bg: transparent;
    flex-shrink: 0;
    width: 1.75rem;
    height: 1.75rem;
    margin-top: -.125rem;
    vertical-align: top;
    appearance: none;
    background-color: var(--bs-form-check-bg);
    background-image: var(--bs-form-check-bg-image);
    background-repeat: no-repeat;
    background-position: center;
    background-size: contain;
    border: 2px solid #1d1d1e;
    print-color-adjust: exact;
}
 </style>  
   <!--begin::Content wrapper-->
   <div class="d-flex flex-column flex-column-fluid">
     <!--begin::Toolbar-->
	<div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 "  >
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
														<!--begin::Form-->
											<form id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row" data-kt-redirect="<?=$action_url?>" action="<?=$action_url?>" method="post" enctype= multipart/form-data>
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
																	<!--begin::Image input placeholder-->
																	<?php if(!empty($value->pic)){?>
															<style>
															.image-input-placeholder {
																background-image: url('<?=IMGS_URL.$value->pic;?>');
															}
											
															[data-bs-theme="dark"] .image-input-placeholder {
																background-image: url('<?=IMGS_URL.$value->pic;?>');
															}                
														</style>
														<?php }else{?>	
														<style>
															.image-input-placeholder {
																background-image: url('<?=base_url();?>assets/media/svg/files/blank-image.svg');
															}
											
															[data-bs-theme="dark"] .image-input-placeholder {
																background-image: url('<?=base_url();?>assets/media/svg/files/blank-image-dark.svg');
															}                
														</style>
														<?php }?>
														<!--end::Image input placeholder-->
															
													<div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3" data-kt-image-input="true">
														<!--begin::Preview existing avatar-->
																		<div class="image-input-wrapper w-150px h-150px"></div>
																	<!--end::Preview existing avatar-->
											
														<!--begin::Label-->
														<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
															<i class="ki-duotone ki-pencil fs-7"><span class="path1"></span><span class="path2"></span></i>
															<!--begin::Inputs-->
															<input type="file" name="img[]" accept=".png, .jpg, .jpeg, .gif ,.webP, .svg"  id="productImage" multiple="" />
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
													<div class="text-muted fs-7">Set the product thumbnail image. Only *.png, *.jpg and *.jpeg image files are accepted or 100kb.</div>
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
														<div class="rounded-circle bg-success w-15px h-15px" id="kt_ecommerce_add_product_status"></div>
													</div>
													<!--begin::Card toolbar-->
												</div>
												<!--end::Card header-->
											
												<!--begin::Card body-->
												<div class="card-body pt-0">
													<!--begin::Select2-->
													<select class="form-select mb-2" data-control="select2" data-hide-search="true" name="status" data-placeholder="Select an option" id="kt_ecommerce_add_product_status_select">
														<option></option>
														<option value="1" <?php if($value->active=='1'){ echo "selected";};?> >Active</option>
														<option value="0" <?php if($value->active=='0'){ echo "selected";};?>>Inactive</option>
													</select>
													<!--end::Select2-->
											
													<!--begin::Description-->
													<div class="text-muted fs-7">Set the product status.</div>
													<!--end::Description-->
											
													<!--begin::Datepicker-->
													<div class="d-none mt-10">
														<label for="kt_ecommerce_add_product_status_datepicker" class="form-label">Select publishing date and time</label>
														<input class="form-control" id="kt_ecommerce_add_product_status_datepicker" placeholder="Pick date & time" />
													</div>
													<!--end::Datepicker-->
												</div>
												<!--end::Card body-->
											</div>
											<!--end::Status-->
													
											<!--begin::Category & tags-->
											<div class="card card-flush py-4">
												<!--begin::Card header-->
												<div class="card-header">
													<!--begin::Card title-->
													<div class="card-title">
														<h2>Category Selection</h2>
													</div>
													<!--end::Card title-->
												</div>
												<!--end::Card header-->
											
												<!--begin::Card body-->
												<div class="card-body pt-0">
													<!--begin::Input group-->
													<!--begin::Label-->
													<label class="form-label">Categories</label>
													<!--end::Label-->
											
													<!--begin::Select2-->
													<div class="form-group">
														<div class="parent_cat_id" id="parent_cat_id" style="height: 250px;overflow: scroll;">
															<?php 
																foreach($parent_cat as $row){
																	$checked1 = '';
																	foreach($cat_pro_map as $row_cat_id){ 
																		if ($row_cat_id->cat_id == $row->id) {
																			$checked1 = 'checked';
																		}
																	}
															?>
															<div class="form-check">
																<input class="form-check-input" type="checkbox" value="<?= $row->id; ?>" name="cat_id[]" id="defaultCheck<?= $row->id; ?>" <?=$checked1;?>>
																<label class="form-check-label" for="defaultCheck<?= $row->id; ?>"><?= $row->name; ?></label>
															</div>
															<?php
																foreach($categories as $row2){
																	if ($row->id == $row2->parent) {
																		$checked2 = '';
																		foreach($cat_pro_map as $row_cat_id){ 
																			if ($row_cat_id->cat_id == $row2->id) {
																				$checked2 = 'checked';
																			}
																		}
															?>
															<div class="form-check ms-8">
																<input class="form-check-input" type="checkbox" value="<?= $row2->id; ?>" name="cat_id[]" onclick="select_parent_cat(this, <?= $row->id; ?>)" id="defaultCheck<?= $row2->id; ?>" <?=$checked2;?>>
																<label class="form-check-label" for="defaultCheck<?= $row2->id; ?>"><?= $row2->name; ?></label>
															</div>
															<?php
																	
																	foreach($categories as $row3){
																		if ($row2->id == $row3->parent) {
																			$checked = '';
																			foreach($cat_pro_map as $row_cat_id){ 
																				if ($row_cat_id->cat_id == $row3->id) {
																					$checked = 'checked';
																				}
																			}
															?>
															<div class="form-check ms-15">
																<input class="form-check-input" type="checkbox" value="<?= $row3->id; ?>" name="cat_id[]" onclick="select_parent_cat(this, <?= $row->id; ?>, <?= $row2->id; ?>)" id="defaultCheck<?= $row3->id; ?>" <?=$checked;?>>
																<label class="form-check-label" for="defaultCheck<?= $row3->id; ?>"><?= $row3->name; ?></label>
															</div>
															<?php
																		
																		}
																	}

																	}
																}
															}
															?>
														</div>
													</div>
													<!--end::Select2-->
											
													<!--begin::Description-->
													<div class="text-muted fs-7 mb-7">Add product to a category.</div>
													<!--end::Description-->
													<!--end::Input group-->
											
													<!--begin::Button-->
													<a href="<?=base_url();?>sellers/create_category/<?=$seller_id;?>" class="btn btn-light-primary btn-sm mb-10">
														<i class="ki-duotone ki-plus fs-2"></i>            Create new category
													</a>
													<!--end::Button-->
											
												
												</div>
												<!--end::Card body-->
											</div>
											<!--end::Category & tags-->
												
													
										</div>
												<!--end::Aside column-->
											
												<!--begin::Main column-->
												<div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
													<!--begin:::Tabs-->
											<ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-n2">
												<!--begin:::Tab item-->
												<li class="nav-item">
													<a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_ecommerce_add_product_general">General</a>
												</li>
												<!--end:::Tab item-->
											
												</ul>
											<!--end:::Tabs-->
													<!--begin::Tab content-->
													<div class="tab-content">
														<!--begin::Tab pane-->
														<div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
															<div class="d-flex flex-column gap-7 gap-lg-10">
																
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
													<!--begin::Input group-->
													<div class="mb-10 fv-row">
														<!--begin::Label-->
														<label class="required form-label">Product Name</label>
														<!--end::Label-->
											
														<!--begin::Input-->
																	<input type="text" name="product_name" class="form-control mb-2" placeholder="Product name" value="<?=$value->name;?>" />
																	<div id="product_name_error"></div>
														<!--end::Input-->
											
														<!--begin::Description-->
														<div class="text-muted fs-7">A product name is required and recommended to be unique.</div>
														<!--end::Description-->
													</div>
													<!--end::Input group-->
											
													<!--begin::Input group-->
													<div>
														<!--begin::Label-->
														<label class="form-label">Description</label>
														<!--end::Label-->
											
														<!--begin::Editor-->
														<div id="kt_ecommerce_add_product_description" name="kt_ecommerce_add_product_description" class="min-h-200px mb-2"></div>
														<!--end::Editor-->
														<!-- Hidden input to hold the Quill editor's HTML content -->
											
														<!--begin::Description-->
														<div class="text-muted fs-7">Set a description to the product for better visibility.</div>
														<!--end::Description-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="mb-10 mt-5	 fv-row">
														<!--begin::Label-->
														<label class="required form-label">SKU</label>
														<!--end::Label-->
											
														<!--begin::Input-->
																	<input type="text" name="product_sku" class="form-control mb-2" placeholder="Product SKU"  value="<?=$value->sku;?>" />
														<!--end::Input-->
													</div>
													<!--end::Input group-->
														<!--begin::Input group-->
														<div class="mb-10 mt-5	 fv-row">
														<!--begin::Label-->
														<label class="required form-label">Keywords</label>
														<!--end::Label-->
											
														<!--begin::Input-->
																	<input type="text" name="keywords" class="form-control mb-2" placeholder="Product Keywords"  value="<?=$value->keywords;?>" />
														<!--end::Input-->
													</div>
													<!--end::Input group-->
												</div>
												<!--end::Card header-->
											</div>
											<!--end::General options-->
											
											<!--begin::Pricing-->
											<div class="card card-flush py-4">
												<!--begin::Card header-->
												<div class="card-header">
													<div class="card-title">
														<h2>Pricing</h2>
													</div>
												</div>
												<!--end::Card header-->
											
											<!--begin::Card body-->
											<div class="card-body pt-0">
												<!--begin::Input group for Base Price-->
												<div class="mb-10 fv-row">
													<!--begin::Label-->
													<label class="required form-label">Base Price</label>
													<!--end::Label-->
													
													<!--begin::Input group-->
													<div class="input-group mb-2">
														<div class="row">
															<div class="col-lg-4">
														<!--begin::Rupee Input-->
														<input type="number" name="price" class="w-lg-300px form-control" placeholder="Product price" value="<?=$value->price;?>" />
															   <!--end::Rupee Input-->
															</div>
															<div class="col-lg-8">
															<!--begin::Unit Selector-->
															<select name="price_unit"  data-control="select2" class="form-select  w-lg-550px">
															<option value="">select</option>
															<?php foreach($units as $unit):?>
															<option value="<?=$unit->id;?>" <?php if($unit->id==$value->price_type){ echo "selected";} ;?> ><?=$unit->title;?></option>
															<?php endforeach;?>
															<!-- Add more units as needed -->
														</select>
														<!--end::Unit Selector-->
															</div>
														</div>
													</div>
													<!--end::Input group-->
													
													<!--begin::Description-->
													<div class="text-muted fs-7">Set the product price and unit.</div>
													<!--end::Description-->
												</div>
												<!--end::Input group-->
													<!--begin::Input group for Base Price-->
													<div class="mb-10 fv-row">
													<!--begin::Label-->
													<label class="required form-label">Quantity</label>
													<!--end::Label-->
													
													<!--begin::Input group-->
													<div class="input-group mb-2">
														<div class="row">
															<div class="col-lg-4">
														<!--begin::Rupee Input-->
														<input type="number" name="qty" class="w-lg-300px form-control" placeholder="Product quantity" value="<?=$value->min_order_qty;?>" />
															   <!--end::Rupee Input-->
															</div>
															<div class="col-lg-8">
															<!--begin::Unit Selector-->
															<select name="qty_unit"  data-control="select2" class="form-select w-lg-550px">
															<option value="">select</option>
															<?php foreach($units as $unit):?>
															<option value="<?=$unit->id;?>"  <?php if($unit->id==$value->min_order_type){ echo "selected";} ;?> ><?=$unit->title;?></option>
															<?php endforeach;?>
															<!-- Add more units as needed -->
														</select>
														<!--end::Unit Selector-->
															</div>
														</div>
													</div>
													<!--end::Input group-->
													
													<!--begin::Description-->
													<div class="text-muted fs-7">Set the product price and unit.</div>
													<!--end::Description-->
												</div>
												<!--end::Input group-->
											</div>
											<!--end::Card body-->

											</div>
											<!--end::Pricing-->
															</div>
														</div>
														<!--end::Tab pane-->
											
																</div>
													<!--end::Tab content-->
											
													<div class="d-flex justify-content-end">
														<!--begin::Button-->
														<a href="<?=base_url('sellers/details/'.$seller_id);?>" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">
															Cancel
														</a>
														<!--end::Button-->
											
														<!--begin::Button-->
														<button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
															<span class="indicator-label">
																Edit Product
															</span>
															<span class="indicator-progress">
																Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
															</span>
														</button>
														<!--end::Button-->
													</div>
												</div>
												<!--end::Main column-->
											</form>
											<!--end::Form-->        </div>
													<!--end::Content container-->
												</div>
											<!--end::Content-->	
											
																				</div>
															<!--end::Content wrapper-->
