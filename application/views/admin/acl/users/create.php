
<script>
$(document).ready(function() {
    // Initialize form validation
    $(".needs-validation").validate({
        rules: {
            userName: {
                required: true,
                remote: "<?=$remote?>null/userName"
            },
            fullName: "required",
            email: {
                required: true,
                email: true
            },
            contact: {
                required: true,
                minlength: 10,
                maxlength: 10,
                number: true
            },
            role_id: "required",
            photo: "required"
        },
        messages: {
            userName: {
                remote: "Username already exists!"
            }
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
});
</script>

<form class="ajaxsubmit needs-validation reload-page" action="<?=$action_url?>" method="post" enctype= multipart/form-data>
<div class="modal-body">
<div class="row">
        <div class="col-lg-6 col-sm-12 col-md-6">
            <div class="form-group">
                <label class="form-check-label">Username:</label>
                <input type="text" class="form-control form-control-solid" name="userName">
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 col-md-6">
            <div class="form-group">
                <label class="form-check-label">Full Name:</label>
                <input type="text" class="form-control form-control-solid" name="fullName">
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
            <div class="form-group">
                <label class="form-check-label">Email:</label>
                <input type="email" class="form-control form-control-solid" name="email">
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
            <div class="form-group">
                <label class="form-check-label">Mobile:</label>
                <input type="number" class="form-control form-control-solid" name="contact">
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
            <div class="form-group">
                <label class="form-check-label">Password:</label>
                <input type="text" class="form-control form-control-solid" name="password" value="123456" >
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 col-md-6 mt-3">
            <div class="form-group">
                <label class="form-check-label">User Role:</label>
                <select class="form-select form-select-solid" style="width:100%;" name="role_id">
                <option value="">--Select--</option>
                <?php foreach ($user_roles as $roles) { ?>
                <option value="<?php echo $roles->id; ?>">
                    <?php echo $roles->name; ?>
                </option>
                <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-check-label">Photo:</label>
                <input type="file" class="form-control form-control-solid" name="photo" >
            </div>
        </div>
        </div>
    
</div>
<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" data-bs-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Add</button>
</div>

</form>


  