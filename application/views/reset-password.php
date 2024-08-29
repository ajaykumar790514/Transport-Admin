
<!DOCTYPE html>
<html lang="en" >
    <!--begin::Head-->
    <head>
        <title>Reset Password</title>
        <meta charset="utf-8"/>
        <meta name="description" content="
            The most advanced Bootstrap 5 Admin Theme with 40 unique prebuilt layouts on Themeforest trusted by 100,000 beginners and professionals. Multi-demo,
            Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel versions.
            Grab your copy now and get life-time updates for free.
        "/>
        <meta name="keywords" content="
            metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js,
            Node.js, Flask, Symfony & Laravel starter kits, admin themes, web design, figma, web development, free templates,
            free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button,
            bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon
        "/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta property="og:locale" content="en_US" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="Metronic - The World's #1 Selling Bootstrap Admin Template by KeenThemes" />
        <meta property="og:url" content="https://keenthemes.com/metronic"/>
        <meta property="og:site_name" content="Metronic by Keenthemes" />
        <link rel="canonical" href="https://preview.keenthemes.com<?=base_url();?>authentication/layouts/corporate/reset-password.html"/>
        <link rel="shortcut icon" href="<?=base_url();?>assets/media/logos/favicon.ico"/>

        <!--begin::Fonts(mandatory for all pages)-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>        <!--end::Fonts-->

        
        
                    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
                            <link href="<?=base_url();?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
                            <link href="<?=base_url();?>assets/css/style.bundle.css" rel="stylesheet" type="text/css"/>
                        <!--end::Global Stylesheets Bundle-->
        
                    <!--begin::Google tag-->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-37564768-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-37564768-1');
</script>
<!--end::Google tag-->        
        <script>
            // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking)
            if (window.top != window.self) {
                window.top.location.replace(window.self.location.href);
            }
        </script>
    </head>
    <!--end::Head-->

    <!--begin::Body-->
    <body  id="kt_body"  class="app-blank" >
        <!--begin::Theme mode setup on page load-->
<script>
	var defaultThemeMode = "light";
	var themeMode;

	if ( document.documentElement ) {
		if ( document.documentElement.hasAttribute("data-bs-theme-mode")) {
			themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
		} else {
			if ( localStorage.getItem("data-bs-theme") !== null ) {
				themeMode = localStorage.getItem("data-bs-theme");
			} else {
				themeMode = defaultThemeMode;
			}			
		}

		if (themeMode === "system") {
			themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
		}

		document.documentElement.setAttribute("data-bs-theme", themeMode);
	}            
</script>
<!--end::Theme mode setup on page load-->
                    <!--Begin::Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5FS8GGP" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!--End::Google Tag Manager (noscript) -->
        
        <!--begin::Root-->
<div class="d-flex flex-column flex-root" id="kt_app_root">
    
<!--begin::Authentication - Password reset -->
<div class="d-flex flex-column flex-lg-row flex-column-fluid">    
    <!--begin::Body-->
    <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
        <!--begin::Form-->
        <div class="d-flex flex-center flex-column flex-lg-row-fluid">
            <!--begin::Wrapper-->
            <div class="w-lg-500px p-10">
                
<div id="mobile_div">
<!--begin::Form-->
<form class="form w-100" novalidate="novalidate" id="kt_password_reset_form" data-kt-redirect-url="<?=base_url();?>reset-send-otp" action="<?=base_url();?>reset-send-otp" method="post">
    <!--begin::Heading-->
    <div class="text-center mb-10">
        <!--begin::Title-->
        <h1 class="text-gray-900 fw-bolder mb-3">
            Forgot Password ?
        </h1>
        <!--end::Title-->

        <!--begin::Link-->
        <div class="text-gray-500 fw-semibold fs-6">
            Enter your mobile number to reset your password.
        </div>
        <!--end::Link-->
    </div>
    <!--begin::Heading-->

    <!--begin::Input group--->
    <div class="fv-row mb-8">
        <!--begin::Email-->
        <input type="number" placeholder="Mobile Number" name="mobile" autocomplete="off" class="form-control bg-transparent"/> 
        <!--end::Email-->
    </div>

    <!--begin::Actions-->
    <div class="d-flex flex-wrap justify-content-center pb-lg-0">
        <button type="button" id="kt_password_reset_submit" class="btn btn-primary me-4">
            
<!--begin::Indicator label-->
<span class="indicator-label">
    Submit</span>
<!--end::Indicator label-->

<!--begin::Indicator progress-->
<span class="indicator-progress">
    Please wait...    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
</span>
<!--end::Indicator progress-->        </button>

        <a href="<?=base_url();?>login/admin" class="btn btn-light">Cancel</a>
    </div>
    <!--end::Actions-->
</form>
</div>
<!--end::Form-->
   <!--begin::New Div to Show After OTP Sent-->
   <div id="otp_sent_div" style="display:none;">
		<form class="form w-100" novalidate="novalidate" id="kt_password_verify_reset_form" data-kt-redirect-url="<?=base_url();?>verify-send-otp" action="<?=base_url();?>verify-send-otp" method="post">
			<!--begin::Heading-->
			<div class="text-center mb-10">
				<!--begin::Title-->
				<h1 class="text-gray-900 fw-bolder mb-3">
					Forgot Password  / OTP ?
				</h1>
				<!--end::Title-->

				<!--begin::Link-->
				<div class="text-gray-500 fw-semibold fs-6">
					Enter  OTP to reset your password.
				</div>
				<!--end::Link-->
			</div>
			<!--begin::Heading-->

			<!--begin::Input group--->
			<div class="fv-row mb-8">
				<!--begin::Email-->
				<input type="number" placeholder="Enter OTP" name="otp" autocomplete="off" class="form-control bg-transparent"/> 
				<input type="hidden" id="mobile_number" name="mobile_number">
				<!--end::Email-->
			</div>

			<!--begin::Actions-->
			<div class="d-flex flex-wrap justify-content-center pb-lg-0">
				<button type="button" id="kt_password_verify_reset_submit" class="btn btn-primary me-4">
					
		<!--begin::Indicator label-->
		<span class="indicator-label">
			Submit</span>
		<!--end::Indicator label-->

		<!--begin::Indicator progress-->
		<span class="indicator-progress">
			Please wait...    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
		</span>
		<!--end::Indicator progress-->        </button>

				<a href="<?=base_url();?>login/admin" class="btn btn-light">Cancel</a>
			</div>
			<!--end::Actions-->
		</form>
    </div>
    <!--end::New Div to Show After OTP Sent-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Form-->       

        <!--begin::Footer-->  
        <div class="w-lg-500px d-flex flex-stack px-10 mx-auto">
          
            <!--begin::Links-->
            <div class="d-flex fw-semibold text-primary fs-base gap-5">
                <a href="<?=base_url();?>pages/team.html" target="_blank">Terms</a>

                <a href="<?=base_url();?>pages/pricing/column.html" target="_blank">Plans</a>
                
                <a href="<?=base_url();?>pages/contact.html" target="_blank">Contact Us</a>
            </div>
            <!--end::Links-->
        </div>
        <!--end::Footer-->
    </div>
    <!--end::Body-->
    
    <!--begin::Aside-->
    <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image: url(<?=base_url();?>assets/media/misc/auth-bg.png)">
        <!--begin::Content-->
        <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">          
            <!--begin::Logo-->
            <a href="<?=base_url();?>index.html" class="mb-0 mb-lg-12">
                <img alt="Logo" src="<?=base_url();?>assets/media/logos/custom-1.png" class="h-60px h-lg-75px"/>
            </a>    
            <!--end::Logo-->

            <!--begin::Image-->                
            <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20" src="<?=base_url();?>assets/media/misc/auth-screens.png" alt=""/>                 
            <!--end::Image-->

            <!--begin::Title-->
            <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7"> 
                Fast, Efficient and Productive
            </h1>  
            <!--end::Title-->

            <!--begin::Text-->
            <div class="d-none d-lg-block text-white fs-base text-center">
                In this kind of post, <a href="#" class="opacity-75-hover text-warning fw-bold me-1">the blogger</a> 

                introduces a person they’ve interviewed <br/> and provides some background information about 
                
                <a href="#" class="opacity-75-hover text-warning fw-bold me-1">the interviewee</a> 
                and their <br/> work following this is a transcript of the interview.  
            </div>
            <!--end::Text-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Aside-->
</div>
<!--end::Authentication - Password reset-->
                         


                         </div>
<!--end::Root-->
        
        <!--begin::Javascript-->
        <script>
            var hostUrl = "<?=base_url();?>assets/";        </script>

                    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
                            <script src="<?=base_url();?>assets/plugins/global/plugins.bundle.js"></script>
                            <script src="<?=base_url();?>assets/js/scripts.bundle.js"></script>
                        <!--end::Global Javascript Bundle-->
        
        
                    <!--begin::Custom Javascript(used for this page only)-->
                            <script src="<?=base_url();?>assets/js/custom/authentication/reset-password/reset-password.js"></script>
                        <!--end::Custom Javascript-->
                <!--end::Javascript-->
    </body>
    <!--end::Body-->
</html>
