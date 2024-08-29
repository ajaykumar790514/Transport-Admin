<form class="ajaxsubmit needs-validation reload-page" action="<?=$action_url?>" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label class="form-check-label mb-2">Logo :</label>
                <input type="file" class="form-control form-control" id="logoImage" name="logo">
				<?php if($value->logo):?>
                <img src="<?=IMGS_URL.$value->logo;?>" height="50px" style="margin-top: 5px;" alt="">
				<?php endif;?>	
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 col-md-6 mt-4">
            <div class="form-group">
                <label class="form-check-label mb-2 required">Company Name :</label>
                <input type="text" class="form-control form-control" name="company_name" value="<?=$value->company_name;?>" placeholder="Enter Company Name">
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 col-md-6 mt-4">
            <div class="form-group">
                <label class="form-check-label mb-2 required">What You Provide :</label>
                <select class="form-control" name="what_you_provide">
                    <option value="">--Select --</option>
                    <option value="Transport Contactor" <?php if($value->what_you_provide=="Transport Contactor"){ echo "selected";};?> >Transport Contactor</option>
                    <option value="Fleet Owner" <?php if($value->what_you_provide=="Fleet Owner"){ echo "selected";};?>>Fleet Owner</option>
                    <option value="Agent / Broker" <?php if($value->what_you_provide=="Agent / Broker"){ echo "selected";};?>>Agent / Broker</option>
                </select>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 col-md-6 mt-4">
            <div class="form-group">
                <label class="form-check-label mb-2 required">Mobile Number :</label>
                <input type="number" class="form-control form-control" name="mobile_number" value="<?=$value->mobile_number;?>" placeholder="Enter Mobile Number">
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 col-md-6 mt-4">
            <div class="form-group">
                <label class="form-check-label mb-2">Email Address:</label>
                <input type="email" class="form-control form-control" name="email" value="<?=$value->email;?>" placeholder="Enter Email Address">
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-md-12 mt-4">
            <div class="form-group">
                <label class="form-check-label mb-2 required">Minimum Load:</label>
                <div class="input-group">
                    <input type="text" class="form-control form-control" name="minimum_load" value="<?=$value->minimum_load;?>" placeholder="Enter Minimum Load">
                    <select class="form-select form-select" name="minimum_load_type">
                        <option value="">--Select--</option>
                        <?php foreach($min_order_qty_types as $types): ?>
                        <option value="<?=$types->id;?>" <?php if($value->minimum_load_type==$types->id){ echo "selected";};?> ><?=$types->title;?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <span class="text-start mt-3 mb-3">Address Details</span>
        <div class="col-lg-6 col-sm-12 col-md-6 mt-4">
            <div class="form-group">
                <label class="form-check-label mb-2 required">State:</label>
                <select name="state" id="state" form-control="select2" class="form-select form-control" onchange="fetch_cities(this.value)">
                    <option value="">--Select--</option>
                    <?php foreach($states as $state): ?>
                    <option value="<?=$state->id;?>" <?php if($value->state==$state->id){ echo "selected";};?> ><?=$state->name;?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 col-md-6 mt-4">
            <div class="form-group">
                <label class="form-check-label mb-2 required">City:</label>
                <select name="city" id="city" class="select2 form-select form-control">
				<option value="<?=$value->city;?>"><?=$value->city_name;?></option>
				</select>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 col-md-6 mt-4">
            <div class="form-group">
                <label class="form-check-label mb-2 required">Building Number:</label>
                <input type="text" class="form-control form-control" value="<?=$value->building_no;?>" name="building_number" placeholder="Enter Building Number">
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 col-md-6 mt-4">
            <div class="form-group">
                <label class="form-check-label mb-2 required">Area / Street:</label>
                <input type="text" class="form-control form-control" value="<?=$value->area_street;?>" name="area_street" placeholder="Enter Area / Street">
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 col-md-6 mt-4">
            <div class="form-group">
                <label class="form-check-label mb-2">Landmark:</label>
                <input type="text" class="form-control form-control" value="<?=$value->landmark;?>" name="landmark" placeholder="Enter Landmark">
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 col-md-6 mt-4">
            <div class="form-group">
                <label class="form-check-label mb-2">Pincode:</label>
                <input type="number" class="form-control form-control" value="<?=$value->pincode;?>" name="pincode" placeholder="Enter Pincode">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="reset" class="btn btn-default waves-effect" data-bs-dismiss="modal">Close</button>
        <button id="btnsubmit" type="submit" class="btn btn-danger waves-light"><i id="loader" class=""></i>Update</button>
    </div>
</form>

<script>
function fetch_cities(stateValue) {
    $.ajax({
        url: "<?=base_url();?>master-data/fetch_cities",
        method: "POST",
        data: { state: stateValue },
        success: function(data) {
            $("#city").html(data);
        },
    });
}

$(document).ready(function() {
    $(".needs-validation").validate({
        rules: {
            company_name: {
                required: true,
                remote: "<?=$remote;?>null/company_name"
            },
            mobile_number: "required",
            what_you_provide: "required",
            minimum_load: "required",
            minimum_load_type: "required",
            state: "required",
            city: "required",
            building_number: "required",
            area_street: "required",
        },
        messages: {
            company_name: {
                required: "Please enter company name",
                remote: "Company Name already exists!"
            },
            what_you_provide: "Please select what you provide",
            mobile_number: "Please enter mobile number",
            minimum_load: "Please enter minimum load",
            minimum_load_type: "Please select minimum load type",
            state: "Please select state",
            city: "Please select city",
            building_number: "Please enter building number",
            area_street: "Please enter area street",
        },
        errorElement: "span",
        errorClass: "error",
        highlight: function(element) {
            $(element).addClass("error");
        },
        unhighlight: function(element) {
            $(element).removeClass("error");
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        }
    });

    function checkFileSize() {
        var files = $('#logoImage')[0].files;
        var maxSize = 100 * 1024; // 100 KB
        var submitButton = $('#btnsubmit');
        for (var i = 0; i < files.length; i++) {
            if (files[i].size > maxSize) {
                toastr.error("Logo image should be less than 100 KB.");
                submitButton.prop('disabled', true);
                $('#logoImage').val('');
                return;
            }
        }
        submitButton.prop('disabled', false);
    }

    $('#logoImage').on('change', checkFileSize);
});

</script>

  