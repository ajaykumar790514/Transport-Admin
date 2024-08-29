  <!--begin::Content wrapper-->
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
         

            <!--begin::Name-->
            <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1">
               <?php echo $seller['contact_person'];?>  
			  </a>
            <!--end::Name-->
            <!--begin::Email-->
            <a href="#" class="fs-5 fw-semibold text-muted text-hover-primary mb-6">
			<?php echo $seller['email'];?>    
			</a>
            <!--end::Email-->
        </div>
        <!--end::Summary-->

        <!--begin::Details toggle-->
        <div class="d-flex flex-stack fs-4 py-3">
            <div class="fw-bold">
                Details
            </div>

            <!--begin::Badge-->
            <div class="badge badge-light-info d-inline">Premium user</div>
            <!--begin::Badge-->
        </div>
        <!--end::Details toggle-->

        <div class="separator separator-dashed my-3"></div>

        <!--begin::Details content-->
        <div class="pb-5 fs-6">
                    <!--begin::Details item-->
                <div class="fw-bold mt-5">Mobile No</div>
                <div class="text-gray-600"><?php echo $seller['mobile'];?></div>
                <!--begin::Details item-->
				   <!--begin::Details item-->
				   <div class="fw-bold mt-5">Alternate Mobile No</div>
                <div class="text-gray-600"><?php echo $seller['alternet_mobile'];?></div>
                <!--begin::Details item-->
                            <!--begin::Details item-->
                <div class="fw-bold mt-5">Email</div>
                <div class="text-gray-600"><a href="#" class="text-gray-600 text-hover-primary"><?php echo $seller['email'];?></a></div>
                <!--begin::Details item-->
                <!--begin::Details item-->
                <div class="fw-bold mt-5">Address</div>
                <div class="text-gray-600"><?php echo $seller['address_line1'];?>, <br/><?php echo $seller['address_line2'];?><br/><?php echo $seller['city_name'];?>, <?php echo $seller['state_name'];?>, <?php echo $seller['pincode'];?></div>
                <!--begin::Details item-->
                            <!--begin::Details item-->
                <div class="fw-bold mt-5">Account Status <?php if($seller['status']=='VERIFIED'){?>
							<i class="fa-solid fa-circle-check text-success new-font-icon"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>                        
							<?php }elseif($seller['status']=='REJECTED'){?>
							<i class="fa-solid fa-circle-xmark text-danger new-font-icon"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>  
							<?php }else{?>
							<i class="fa-solid fa-hourglass-half text-warning new-font-icon"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>  
						<?php }?>		
						<a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3 float-right" data-bs-toggle="modal" data-bs-target="#kt_modal_account_status">
                        <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Change Account Status">                                
                            <i class="ki-duotone ki-pencil fs-3"><span class="path1"></span><span class="path2"></span></i>
                        </span>
                    </a>
					</div>
                <div class="text-gray-600"><?php echo $seller['status'];?></div>
                <!--begin::Details item-->
                            <!--begin::Details item-->
                <!--begin::Details item-->
                    </div>
        <!--end::Details content-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->  
  </div>
    <!--end::Sidebar-->
	<div class="modal fade" id="kt_modal_account_status" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Update Status : <?= $seller['contact_person']; ?></h2>
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>

                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <form id="kt_modal_account_status_form" class="form" action="#">
                            <input type="hidden" name="seller_id" value="<?= $seller['id']; ?>">
                            <div class="d-flex flex-column mb-7 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                    <span class="required">Select Status</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Specify a card holder's name">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                    </span>
                                </label>
								<select class="form-control form-control-solid" name="account_status" id="kt_modal_account_status_name">
                                        <?php if($seller['status']=='VERIFIED'){?>
                                            <option value="VERIFIED" <?= $seller['status']=='VERIFIED' ? 'selected' : ''; ?>>VERIFIED</option>
                                        <?php }else{?>
                                            <option value="PENDING" <?=$seller['status']=='PENDING' ? 'selected' : ''; ?>>PENDING</option>
                                            <option value="VERIFIED" <?= $seller['status']=='VERIFIED' ? 'selected' : ''; ?>>VERIFIED</option>
                                            <option value="REJECTED" <?= $seller['status']=='REJECTED' ? 'selected' : ''; ?>>REJECTED</option>
                                        <?php }?>
                                    </select>
                            </div>
                            <div class="d-flex flex-column mb-7 fv-row <?= $seller['status'] == 'REJECTED' ? '' : 'd-none'; ?>">
                                <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                    <span class="required">Rejection Remark</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Specify a rejection remark">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                    </span>
                                </label>
                                <textarea class="form-control form-control-solid" name="account_remark"></textarea>
                            </div>
                            <div class="text-center pt-15">
                                <button type="reset" id="kt_modal_account_status_cancel" class="btn btn-light me-3">
                                    Discard
                                </button>
                                <button type="submit" id="kt_modal_account_status_submit" class="btn btn-primary">
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


    <!--begin::Content-->
    <div class="flex-lg-row-fluid ms-lg-15">
        <!--begin:::Tabs-->
        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
            <!--begin:::Tab item-->
            <li class="nav-item">
                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_ecommerce_customer_overview">Overview</a>
            </li>
            <!--end:::Tab item-->

            <!--begin:::Tab item-->
            <li class="nav-item">
                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_ecommerce_customer_general"  onclick="load_general('general')">General Settings</a>
            </li>
            <!--end:::Tab item-->

            <!--begin:::Tab item-->
            <li class="nav-item">
                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_ecommerce_customer_advanced" onclick="load_company('company')">Seller Company</a>
            </li>
			<li class="nav-item">
                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_ecommerce_category_advanced" onclick="load_category('category')">Category</a>
            </li>
			<li class="nav-item">
                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_ecommerce_product_advanced" onclick="load_product('product')">Product</a>
            </li>
			<li class="nav-item">
                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_ecommerce_wallet_advanced" onclick="load_wallet('wallet')">Wallet</a>
            </li>
            <!--end:::Tab item-->
        </ul>
        <!--end:::Tabs-->

        <!--begin:::Tab content-->
        <div class="tab-content" id="myTabContent">
            <!--begin:::Tab pane-->
            <div class="tab-pane fade show active" id="kt_ecommerce_customer_overview" role="tabpanel">
                <div class="row row-cols-1 row-cols-md-2 mb-6 mb-xl-9">
					<div class="col-lg-12 row">
                    <div class="w-200px mb-5">
						    <label for="" class="form-label">Start Date</label>
							<input type="date" class="form-control" name="start_date" id="start_date" value="<?=date('Y-m-d');?>">
					</div>
					<div class="w-200px mb-5">
						    <label for="" class="form-label">End Date</label>
							<input type="date" class="form-control" name="end_date" id="end_date" value="<?=date('Y-m-d');?>">
					</div>
					<input type="hidden" class="form-control" name="consumer_id" id="consumer_id" value="<?=$seller['id'];?>">
					<div class="w-200px mb-5">
					<label for="" class="form-label">Select Status</label>
							<select class="form-select form-select-white" data-control="select2" data-hide-search="true" data-placeholder="Status" data-kt-payment-filter="status">
								<option></option>
								<option value="PENDING">PENDING</option>
								<option value="FAILED">FAILED</option>
								<option value="SUCCESS">SUCCESS</option>
								<option value="REJECTED">REJECTED</option>
							</select>
						</div>
					</div>
                    <div class="col">
                        <!--begin::Card-->
<div class="card pt-4 h-md-100 mb-6 mb-md-0">
    <!--begin::Card header-->
    <div class="card-header border-0">
        <!--begin::Card title-->
        <div class="card-title">
            <h2 class="fw-bold">Wallet Rupee</h2>
        </div>
        <!--end::Card title-->
    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
    <div class="card-body pt-0">
        <div class="fw-bold fs-2">
            <div class="d-flex">
                <i class="ki-duotone ki-heart text-info fs-2x"><span class="path1"></span><span class="path2"></span></i>                <div class="ms-2">
				<?=$general_master->currency;?> <span id="total-rupee">0.00</span> <span class="text-muted fs-4 fw-semibold">Rupee earned</span>
                </div>
            </div>
            <div class="fs-7 fw-normal text-muted">Earn rupee with every purchase.</div>
        </div>
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->                   
 </div>

                    <div class="col">
                        <!--begin::Reward Tier-->
<a href="#" class="card bg-info hoverable h-md-100">
    <!--begin::Body-->
    <div class="card-body">
        <i class="ki-duotone ki-award text-white fs-3x ms-n1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        <div class="text-white fw-bold fs-2 mt-5">
            Premium Member
        </div>

        <div class="fw-semibold text-white">
            Tier Milestone Reached
        </div>
    </div>
    <!--end::Body-->
</a>
<!--end::Reward Tier-->      
       </div>
   </div>


                <!--begin::Card-->
<div class="card pt-4 mb-6 mb-xl-9">
    <!--begin::Card header-->
    <div class="card-header border-0">
        <!--begin::Card title-->
        <div class="card-title">
            <h2>Withdrawals History</h2>
        </div>
        <!--end::Card title-->
    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
    <div class="card-body pt-0 pb-5">
        <!--begin::Table-->
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_customers_payment">
            <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                <tr class="text-start text-muted text-uppercase gs-0">
                    <th class="min-w-100px">order No.</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th class="min-w-100px">Date</th>
                </tr>
            </thead>
            <tbody class="fs-6 fw-semibold text-gray-600">
            </tbody>
        </table>
        <!--end::Table-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->       
     </div>
            <!--end:::Tab pane-->

            <!--begin:::Tab pane-->
            <div class="tab-pane fade" id="kt_ecommerce_customer_general" role="tabpanel">
			<div id="general_loader" class="custom_loader" style="display:none;"></div>
			<div id="general_content" style="display:none;">
                <!--begin::Card-->
<div class="card pt-4 mb-6 mb-xl-9">
    <!--begin::Card header-->
    <div class="card-header border-0">
        <!--begin::Card title-->
        <div class="card-title">
            <h2>General Profile</h2>
        </div>
        <!--end::Card title-->
    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
    <div class="card-body pt-0 pb-5">
        <!--begin::Form-->
        <form class="form" action="#" id="kt_ecommerce_customer_profile">
		<input type="hidden" class="form-control form-control-solid" placeholder="" name="consumer_id" value="<?=$seller['id'];?>" readonly/>

            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2 required">Name</label>
                <!--end::Label-->

                <!--begin::Input-->
                <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="<?=$seller['contact_person'];?>" readonly/>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
			 <!--begin::Row-->
			 <div class="row row-cols-1 row-cols-md-2">
                <!--begin::Col-->
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="required"> Address Line 1</span>
                        </label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" placeholder="" name="address_line1" value="<?=$seller['address_line1'];?>"  readonly/>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Col-->

                <!--begin::Col-->
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                          <!--begin::Label-->
						  <label class="fs-6 fw-semibold mb-2">
                            <span class="required"> Address Line 2</span>
                        </label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" placeholder="" name="address_line2" value="<?=$seller['address_line2'];?>"  readonly/>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Col-->
				
            </div>
            <!--end::Row-->
			 <!--begin::Row-->
			 <div class="row row-cols-1 row-cols-md-2">
                <!--begin::Col-->
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="required"> State</span>
                        </label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid" placeholder="" name="state" value="<?=$seller['state_name'];?>"  readonly/>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Col-->

                <!--begin::Col-->
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 required">
                            <span>City</span>
                        </label>
                        <!--end::Label-->

                        <!--begin::Input-->
						<input type="text" class="form-control form-control-solid" placeholder="" name="city" value="<?=$seller['city_name'];?>"  readonly/>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Col-->
				
            </div>
            <!--end::Row-->
			   <!--begin::Input group-->
			   <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2 required">Pincode</label>
                <!--end::Label-->

                <!--begin::Input-->
                <input type="text" class="form-control form-control-solid" placeholder="" name="pincode" value="<?=$seller['pincode'];?>" readonly/>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        <div class="card-title mb-5">
            <h5>Verification Email / Mobile / Alternet Mobile</h5>
        </div>
        <!--end::Card title-->
            <!--begin::Row-->
            <div class="row row-cols-1 row-cols-md-2">
                <!--begin::Col-->
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="required"> Email
								
							</span>

                            <span class="ms-1" data-bs-toggle="tooltip" title="Email address must be active"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>                            </span>
							<?php if($seller['email_verified']=='1'){?>
							<i class="fa-solid new-font-icon fa-circle-check text-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>                        
							<?php }elseif($seller['email_verified']=='0'){?>
							<i class="fa-solid new-font-icon fa-circle-xmark text-danger"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>  
							<?php }else{?>
							<i class="fa-solid new-font-icon fa-hourglass-half text-warning"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>  
						<?php }?>
                        </label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <input type="email" class="form-control form-control-solid" placeholder="" name="gen_email" value="<?=$seller['email'];?>"  readonly/>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Col-->
				  <!--begin::Col-->
				  <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="required"> Mobile Number</span>
                            <span class="ms-1" data-bs-toggle="tooltip" title="Mobile NUmber must be active"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>                            </span>
							<?php if($seller['mobile_verified']=='1'){?>
							<i class="fa-solid new-font-icon fa-circle-check text-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>                        
							<?php }elseif($seller['mobile_verified']=='0'){?>
							<i class="fa-solid new-font-icon fa-circle-xmark text-danger"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>  
							<?php }else{?>
							<i class="fa-solid new-font-icon fa-hourglass-half text-warning"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>  
						<?php }?>
                        </label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <input type="number" class="form-control form-control-solid" placeholder="" name="mobile" value="<?=$seller['mobile'];?>"  readonly/>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Col-->
				  <!--begin::Col-->
				  <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="required">Alternet Mobile Number</span>
                            <span class="ms-1" data-bs-toggle="tooltip" title="Mobile NUmber must be active"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>                            </span>
							<?php if($seller['alternet_verified']=='1'){?>
							<i class="fa-solid fa-circle-check new-font-icon text-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>    
							<?php }elseif($seller['alternet_verified']=='0'){?>
							<i class="fa-solid fa-circle-xmark new-font-icon text-danger"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>  
							<?php }else{?>
							<i class="fa-solid fa-hourglass-half new-font-icon text-warning"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>  
						<?php }?>	
                        </label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <input type="number" class="form-control form-control-solid" placeholder="" name="alternet_mobile" value="<?=$seller['alternet_mobile'];?>"  readonly/>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Col-->
				

                <!--begin::Col-->
                <?php /*<div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span>Email Verification</span>
							<?php if($seller['email_verified']=='1'){?>
							<i class="fa-solid fa-circle-check text-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>                        
							<?php }elseif($seller['email_verified']=='0'){?>
							<i class="fa-solid fa-circle-xmark text-danger"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>  
							<?php }else{?>
							<i class="fa-solid fa-hourglass-half text-warning"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>  
						<?php }?>	
					    </span>
                        </label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <select class="form-select form-select-solid" placeholder="Select" name="email_verify">
						<?php if($seller['email_verified']=='0'){?>
						<option value="1" <?php if($seller['email_verified']=='1'){ echo "selected"; } ;?> >Verified</option>
						<option value="0" <?php if($seller['email_verified']=='0'){ echo "selected"; } ;?>  >Not Verified</option>
						<?php }else{?>
							<option value="1" <?php if($seller['email_verified']=='1'){ echo "selected"; } ;?> >Verified</option>
						<?php }?>
						</select>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div> *
                <!--end::Col-->
				
            </div>
            <!--end::Row-->
			    <!--begin::Row-->
				<div class="row row-cols-1 row-cols-md-2">
                <!--begin::Col-->
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="required"> Mobile Number</span>
                            <span class="ms-1" data-bs-toggle="tooltip" title="Mobile NUmber must be active"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>                            </span>
							<?php if($seller['mobile_verified']=='1'){?>
							<i class="fa-solid fa-circle-check text-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>                        
							<?php }elseif($seller['mobile_verified']=='0'){?>
							<i class="fa-solid fa-circle-xmark text-danger"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>  
							<?php }else{?>
							<i class="fa-solid fa-hourglass-half text-warning"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>  
						<?php }?>
                        </label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <input type="number" class="form-control form-control-solid" placeholder="" name="mobile" value="<?=$seller['mobile'];?>"  readonly/>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Col-->

                <!--begin::Col-->
              <?php /*  <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span>Mobile Verification</span>
							<?php if($seller['mobile_verified']=='1'){?>
							<i class="fa-solid fa-circle-check text-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>                        
							<?php }elseif($seller['mobile_verified']=='0'){?>
							<i class="fa-solid fa-circle-xmark text-danger"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>  
							<?php }else{?>
							<i class="fa-solid fa-hourglass-half text-warning"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>  
						<?php }?>	
					    </span>
                        </label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <select class="form-select form-select-solid" placeholder="Select" name="mobile_verify">
					   <?php if($seller['mobile_verified']=='0'){ ?>		
						<option value="1" <?php if($seller['mobile_verified']=='1'){ echo "selected"; } ;?> >Verified</option>
						<option value="0" <?php if($seller['mobile_verified']=='0'){ echo "selected"; } ;?>  >Not Verified</option>
						<?php }else{?>
							<option value="1" <?php if($seller['mobile_verified']=='1'){ echo "selected"; } ;?> >Verified</option>
						<?php }?>
						</select>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div> 
                <!--end::Col-->
				
            </div>
            <!--end::Row-->
			    <!--begin::Row-->
				<div class="row row-cols-1 row-cols-md-2">
                <!--begin::Col-->
                <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="required">Alternet Mobile Number</span>
                            <span class="ms-1" data-bs-toggle="tooltip" title="Mobile NUmber must be active"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>                            </span>
							<?php if($seller['alternet_verified']=='1'){?>
							<i class="fa-solid fa-circle-check text-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>    
							<?php }elseif($seller['alternet_verified']=='0'){?>
							<i class="fa-solid fa-circle-xmark text-danger"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>  
							<?php }else{?>
							<i class="fa-solid fa-hourglass-half text-warning"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>  
						<?php }?>	
                        </label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <input type="number" class="form-control form-control-solid" placeholder="" name="alternet_mobile" value="<?=$seller['alternet_mobile'];?>"  readonly/>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Col-->

                <!--begin::Col-->
               <?php /* <div class="col">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span>Alternet Mobile Verification</span>
							<?php if($seller['alternet_verified']=='1'){?>
							<i class="fa-solid fa-circle-check text-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>    
							<?php }elseif($seller['alternet_verified']=='0'){?>
							<i class="fa-solid fa-circle-xmark text-danger"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>  
							<?php }else{?>
							<i class="fa-solid fa-hourglass-half text-warning"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>  
						<?php }?>	
					    </span>
                        </label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <select class="form-select form-select-solid" placeholder="Select" name="alternet_mobile_verify">
						<?php if($seller['alternet_verified']=='0'){?>	
						<option value="1" <?php if($seller['alternet_verified']=='1'){ echo "selected"; } ;?> >Verified</option>
						<option value="0" <?php if($seller['alternet_verified']=='0'){ echo "selected"; } ;?>  >Not Verified</option>
						<?php }else{?>
							<option value="1" <?php if($seller['alternet_verified']=='1'){ echo "selected"; } ;?> >Verified</option>
							<?php }?>
						</select>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div> */?>
                <!--end::Col-->
				
            </div>
            <!--end::Row-->

            <div class="d-flex justify-content-end">
            <!--begin::Button-->
            <!-- <button type="submit" id="kt_ecommerce_customer_profile_submit" class="btn btn-light-primary">
                <span class="indicator-label">
                    Save
                </span>
                <span class="indicator-progress">
                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button> -->
            <!--end::Button-->
            </div>
        </form>
        <!--end::Form-->
    </div>
    <!--end::Card body-->
</div>
</div>
<!--end::Card-->
                

<!--end::Card-->            </div>
            <!--end:::Tab pane-->

            <!--begin:::Tab pane-->
            <div class="tab-pane fade" id="kt_ecommerce_customer_advanced" role="tabpanel">  
			<div id="loader" class="custom_loader" style="display:none;"></div>
			<div id="company_content" style="display:none;">
<!--begin::Card-->
<div class="card pt-4 mb-6 mb-xl-9">
    <!--begin::Card header-->
    <div class="card-header border-0">
        <!--begin::Card title-->
        <div class="card-title">
            <h2 class="fw-bold mb-0">Companies</h2>
        </div>
        <!--end::Card title-->

        <!--begin::Card toolbar-->
        <!-- <div class="card-toolbar">
            <a href="#" class="btn btn-sm btn-flex btn-light-primary"  data-bs-toggle="modal" data-bs-target="#kt_modal_company_status" >
                <i class="ki-duotone ki-plus-square fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> Add new company
            </a>
        </div> -->
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
	<div id="kt_customer_view_payment_method" class="card-body pt-0">
    <div class="accordion accordion-icon-toggle" id="kt_customer_view_payment_method_accordion">
        <?php $isFirst = true; foreach($companies as $company):
            $addedDate = new DateTime($company->added);
            $formattedAddedDate = $addedDate->format('M Y');
        ?>
        <div class="py-0" data-kt-customer-payment-method="row">
            <div class="py-3 d-flex flex-stack flex-wrap">
                <div class="accordion-header d-flex align-items-center" data-bs-toggle="collapse" href="#kt_customer_view_payment_method_<?= $company->id; ?>" role="button" aria-expanded="false" aria-controls="kt_customer_view_payment_method_<?= $company->id; ?>">
                    <div class="accordion-icon me-2">
                        <i class="ki-duotone ki-right fs-4"></i>
                    </div>
                    <img src="<?=IMGS_URL.$company->logo;?>" class="w-40px me-3" alt=""/>
                    <div class="me-3">
                        <div class="d-flex align-items-center">
                            <div class="text-gray-800 fw-bold">
                                <?= $company->company_name; ?>  
                                <?php if($company->status=='VERIFIED'){?>
                                    <i class="fa-solid fa-circle-check new-font-icon text-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>                        
									<?php }elseif($company->status=='REJECTED'){?>
							<i class="fa-solid fa-circle-xmark new-font-icon text-danger"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>  
							<?php }else{?>
							<i class="fa-solid fa-hourglass-half new-font-icon text-warning"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>  
						<?php }?>	
                            </div>
                        </div>
                        <div class="text-muted">Added <?= $formattedAddedDate; ?></div>
                    </div>
                </div>
                <div class="d-flex my-3 ms-9">    
                    <a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_company_status_<?= $company->id; ?>">
                        <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Change Company Status">                                
                            <i class="ki-duotone ki-pencil fs-3"><span class="path1"></span><span class="path2"></span></i>
                        </span>
                    </a>
                </div>
            </div>

            <div id="kt_customer_view_payment_method_<?= $company->id; ?>" class="collapse <?= $isFirst ? 'show' : ''; ?> fs-6 ps-10" data-bs-parent="#kt_customer_view_payment_method_accordion">
                <div class="d-flex flex-wrap py-5">
                    <div class="flex-equal me-5">
                        <table class="table table-flush fw-semibold gy-1">
                            <tr>
                                <td class="text-muted min-w-125px w-125px">GST NO</td>
                                <td class="text-gray-800"><?= $company->gst; ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted min-w-125px w-125px">PAN NO</td>
                                <td class="text-gray-800"><?= $company->pan; ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted min-w-125px w-125px">Website</td>
                                <td class="text-gray-800"><a target="_blank" href="<?= $company->website; ?>"><?= $company->website; ?></a></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="kt_modal_company_status_<?= $company->id; ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Update Status : <?= $company->company_name; ?></h2>
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>

                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <form id="kt_modal_company_status_form_<?= $company->id; ?>" class="form" action="#">
                            <input type="hidden" name="company_id" value="<?= $company->id; ?>">
                            <div class="d-flex flex-column mb-7 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                    <span class="required">Select Status</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Specify a card holder's name">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                    </span>
                                </label>
								<select class="form-control form-control-solid" name="verify_status" id="kt_modal_company_change_status_<?= $company->id; ?>" >
                                        <?php if($company->status=='VERIFIED'){?>
                                            <option value="VERIFIED" <?= $company->status=='VERIFIED' ? 'selected' : ''; ?>>VERIFIED</option>
                                        <?php }else{?>
                                            <option value="PENDING" <?= $company->status=='PENDING' ? 'selected' : ''; ?>>PENDING</option>
                                            <option value="VERIFIED" <?= $company->status=='VERIFIED' ? 'selected' : ''; ?>>VERIFIED</option>
                                            <option value="REJECTED" <?= $company->status=='REJECTED' ? 'selected' : ''; ?>>REJECTED</option>
                                        <?php }?>
                                    </select>
                            </div>
                            <div class="d-flex flex-column mb-7 fv-row <?= $company->status == 'REJECTED' ? '' : 'd-none'; ?>" id="remarkTextarea_<?= $company->id; ?>">
                                <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                    <span class="required">Rejection Remark</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Specify a rejection remark">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                    </span>
                                </label>
                                <textarea class="form-control form-control-solid" name="remark"></textarea>
                            </div>
                            <div class="text-center pt-15">
                                <button type="reset" id="kt_modal_company_status_cancel_<?= $company->id; ?>" class="btn btn-light me-3">
                                    Discard
                                </button>
                                <button type="submit" id="kt_modal_company_status_submit_<?= $company->id; ?>" class="btn btn-primary">
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
        <?php $isFirst = false; endforeach;?>
    </div>
</div>

				<!--end::Card body-->
			</div>
			</div>
			<!--end::Card-->
            </div>
            <!--end:::Tab pane-->

             <!--begin:::Category Tab pane-->
			 <div class="tab-pane fade" id="kt_ecommerce_category_advanced" role="tabpanel">
            <!--begin::Card-->
			<div id="category_loader" class="custom_loader" style="display:none;"></div>
			<div id="category_content" style="display:none;">
		   <div class="card pt-4 mb-6 mb-xl-9">
			   <!--begin::Card header-->
			   <div class="card-header border-0">
				   <!--begin::Card title-->
				   <div class="card-title">
					   <h2 class="fw-bold mb-0">Category</h2>
				   </div>
				   <!--end::Card title-->
			   </div>
			   <!--end::Card header-->
		   
			   <!--begin::Card body-->
			<div class="card-body pt-0">
			<!--begin::Card header-->
			<div class="card-header border-0">
				<!--begin::Card title-->
				<div class="card-title">
					<!--begin::Search-->
					<div class="d-flex align-items-center position-relative my-1">
						<i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span class="path1"></span><span class="path2"></span></i>
						<input type="text" data-kt-category-table-filter="search" class="form-control  form-control-solid w-250px ps-13" placeholder="Search Categories" />
					</div>
					<!--end::Search-->
				</div>
				<!--begin::Card title-->
				<!--begin::Card toolbar-->
				<div class="col-md-5"></div>
				<div class="card-toolbar">
					<!--begin::Toolbar-->
					<div class="d-flex justify-content-end" data-kt-category-table-toolbar="base">
						
						<!--begin::Add category-->
						<a  class="btn btn-primary"  href="<?=$new_category_url?>" >Add <?=$title2;?></a>
						<!--end::Add category-->
					</div>
					<!--end::Toolbar-->
					<!--begin::Group actions-->
					<div class="d-flex justify-content-end align-items-center d-none" data-kt-category-table-toolbar="selected">
						
						<div class="fw-bold me-5">
							<span class="me-2" data-kt-category-table-select="selected_count"></span> Selected
						</div>
						<button type="button" class="btn btn-sm btn-danger" data-kt-category-table-select="delete_selected">Delete Selected</button>
					</div>
					<!--end::Group actions-->
				</div>
				<!--end::Card toolbar-->
				
				<div class="row">
				<div class="w-350px">
					   <label for="" class="form-label">Parent Category</label>
							<select class="form-select form-select-solid"  data-hide-search="true"  data-placeholder="Parent Category" data-kt-category-filter="parent_category" onchange="fetch_sub_categories(this.value)">
								<option value="">Select Parent Category</option>
								<?php foreach($categories as $category):?>
								<option value="<?=$category->id;?>"><?=$category->name;?></option>
								<?php  endforeach;?>
						</select>
				  </div>
				  <div class="w-350px">
					   <label for="" class="form-label">Sub Category</label>
							<select class="form-select  form-select-solid sub_cat_id"  data-hide-search="true" data-placeholder="Sub Category" data-kt-category-filter="sub_category" >
						</select>
				  </div>
				</div>
			</div>
			
			<!--end::Card header-->
			<!--begin::Card body-->
			<div class="card-body pt-0">
				<!--begin::Table-->
				<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_category_table">
					<thead>
						<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
							<th class="w-10px pe-2">
								<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
									<input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_category_table .form-check-input" value="1" />
								</div>
							</th>
							<th class="text-start min-w-10px"><span class="fw-bold text-dark">S.No.</span></th>
							<th class="text-start min-w-50px"><span class="fw-bold text-dark">Photo</span></th>
							<th class="text-start min-w-70px"><span class="fw-bold text-dark">Level 1</span></th>
							<th class="text-start min-w-70px"><span class="fw-bold text-dark">Level 2</span></th>
							<th class="text-start min-w-70px"><span class="fw-bold text-dark">Level 3</span></th>
							<th class="text-start min-w-50px"><span class="fw-bold text-dark">Status</span></th>
							<th class="text-start min-w-20px"><span class="fw-bold text-dark">Sequence</span></th>
							<th class="text-start min-w-100px"><span class="fw-bold text-dark">Actions</span></th>
						</tr>
					</thead>
					<tbody class="fw-semibold text-gray-600">
					</tbody>
				</table>
				<!--end::Table-->
			</div>
			<!--end::Card body-->

			</div>
		<!--end::Card body-->
		</div>
		</div>
		<!--end::Card-->
		 </div>
		<!--end:::Tab pane-->


		     <!--begin:::Product Tab pane-->
			 <div class="tab-pane fade" id="kt_ecommerce_product_advanced" role="tabpanel">
            <!--begin::Card-->
			<div id="product_loader" class="custom_loader" style="display:none;"></div>
			<div id="product_content" style="display:none;">
		   <div class="card pt-4 mb-6 mb-xl-9">
			   <!--begin::Card header-->
			   <div class="card-header border-0">
				   <!--begin::Card title-->
				   <div class="card-title">
					   <h2 class="fw-bold mb-0">Products</h2>
				   </div>
				   <!--end::Card title-->
			   </div>
			   <!--end::Card header-->
		   
			   <!--begin::Card body-->
			<div class="card-body pt-0">
			<!--begin::Card header-->
			<div class="card-header border-0">
				<!--begin::Card title-->
				<div class="card-title">
					<!--begin::Search-->
					<div class="d-flex align-items-center position-relative my-1">
						<i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span class="path1"></span><span class="path2"></span></i>
						<input type="text" data-kt-product-table-filter="search" class="form-control  form-control-solid w-250px ps-13" placeholder="Search Products" />
					</div>
					<!--end::Search-->
				</div>
				<!--begin::Card title-->
				<!--begin::Card toolbar-->
				<div class="col-md-5"></div>
				<div class="card-toolbar">
					<!--begin::Toolbar-->
					<div class="d-flex justify-content-end" data-kt-product-table-toolbar="base">
						
						<!--begin::Add category-->
						<a class="btn btn-primary" href="<?=$new_product_url?>" >Add <?=$title3;?></a>
						<!--end::Add category-->
					</div>
					<!--end::Toolbar-->
					<!--begin::Group actions-->
					<div class="d-flex justify-content-end align-items-center d-none" data-kt-product-table-toolbar="selected">
						
						<div class="fw-bold me-5">
							<span class="me-2" data-kt-product-table-select="selected_count"></span> Selected
						</div>
						<button type="button" class="btn btn-sm btn-danger" data-kt-product-table-select="delete_selected">Delete Selected</button>
					</div>
					<!--end::Group actions-->
				</div>
				<!--end::Card toolbar-->
				
				<div class="row">
				<div class="w-250px">
					   <label for="" class="form-label">Parent Category</label>
							<select class="form-select form-select-solid"  data-hide-search="true"  data-placeholder="Parent Category" data-kt-product-filter="parent_category" onchange="fetch_sub_categories(this.value)">
								<option value="">Select Parent Category</option>
								<?php foreach($categories as $category):?>
								<option value="<?=$category->id;?>"><?=$category->name;?></option>
								<?php  endforeach;?>
						</select>
				  </div>
				  <div class="w-250px">
					   <label for="" class="form-label">Sub Category</label>
							<select class="form-select  form-select-solid sub_cat_id"  data-hide-search="true" data-placeholder="Sub Category" data-kt-product-filter="sub_category" onchange="fetch_categories(this.value)">
						</select>
				  </div>
				  <div class="w-250px">
					   <label for="" class="form-label"> Category</label>
							<select class="form-select  form-select-solid cat_id"  data-hide-search="true" data-placeholder=" Category" data-kt-product-filter="category" >
						</select>
				  </div>
				</div>
			</div>
			
			<!--end::Card header-->
			<!--begin::Card body-->
			<div class="card-body pt-0">
				<!--begin::Table-->
				<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_product_table">
					<thead>
						<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
							<th class="w-10px pe-2">
								<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
									<input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_product_table .form-check-input" value="1" />
								</div>
							</th>
							<th class="text-start min-w-10px"><span class="fw-bold text-dark">S.No.</span></th>
							<th class="text-start min-w-50px"><span class="fw-bold text-dark">Photo</span></th>
							<th class="text-start min-w-50px"><span class="fw-bold text-dark">Name</span></th>
						
							<th class="text-start min-w-50px"><span class="fw-bold text-dark">SKU</span></th>
							<th class="text-start min-w-50px"><span class="fw-bold text-dark">Qty</span></th>
							<th class="text-start min-w-20px"><span class="fw-bold text-dark">Price</span></th>
							<th class="text-start min-w-50px"><span class="fw-bold text-dark">SEQ</span></th>
							<th class="text-start min-w-50px"><span class="fw-bold text-dark">Status</span></th>
							<th class="text-start min-w-100px"><span class="fw-bold text-dark">Actions</span></th>
						</tr>
					</thead>
					<tbody class="fw-semibold text-gray-600">
					</tbody>
				</table>
				<!--end::Table-->
			</div>
			<!--end::Card body-->

			</div>
		<!--end::Card body-->
		</div>
		</div>
		<!--end::Card-->
		 </div>
		<!--end:::Tab pane-->


		     <!--begin:::Product Tab pane-->
			 <div class="tab-pane fade" id="kt_ecommerce_wallet_advanced" role="tabpanel">
          			<!--begin::Products-->
					  <div id="wallet_loader" class="custom_loader" style="display:none;"></div>
					  <div id="wallet_content" style="display:none;">
					  <div class="card card-flush">
					  <h2 style="padding-left: 30px;" class="fw-bold mt-6 pl-5">Wallet</h2>
												<!--begin::Card header-->
												<div class="card-header align-items-center gap-2 gap-md-5">
													<!--begin::Card title-->
													
													<br>
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
											</div>
											<!--end::Products--> 
		 </div>
		<!--end:::Tab pane-->

        </div>
        <!--end:::Tab content-->
    </div>
    <!--end::Content-->
</div>
<!--end::Layout-->
   
   </div>
        <!--end::Content container-->
    </div>
<!--end::Content-->	
 </div>
  <!--end::Content wrapper-->.

 
 
