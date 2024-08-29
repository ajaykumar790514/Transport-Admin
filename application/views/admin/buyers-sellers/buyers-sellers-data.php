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
				<!--begin::Stats-->
				<div class="col-12">
                    <div class="row">
                       <?php foreach($sub_menus as $menus){ ?>
                             <div class="col-lg-3 col-md-6">
                             <a href="<?php echo base_url($menus->url.'/'.$menu_id); ?>">
                              <div class="card text-center" style="padding:10px;">
                              <i style="font-size:4rem" class="mt-10 <?php echo $menus->icon_class; ?>" ></i>
                                <div class="card-body">
                               <h4 class="card-title"><?= $menus->title; ?></h4>
                               </div>
                          </div>
                            </a>
                        </div>
                        <?php } ?>
                  </div>
            </div>
		<!--end::Stats-->
		
		<!--begin::Modals-->
	       </div>
				<!--end::Content container-->
			</div>
		<!--end::Content-->	
		</div>
<!--end::Content wrapper-->
