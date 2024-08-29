<script type="text/javascript">
$(document).ready(function() {
    // Initialize form validation
    $(".needs-validation").validate({
        rules: {
            name: {
                required:true,
                remote:"<?=$remote?>null"
            },
            description: "required",
        },
        messages: {
            name: {
               remote : "Role already exists!"
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
        <div class="col-lg-12">
            <div class="form-group">
                <label class="form-check-label">Name:</label>
                <input type="text" class="form-control form-control-solid" name="name" value="<?= $value->name ?>">
            </div>
        </div>
        <div class="col-lg-12 mt-3">
            <div class="form-group">
                <label class="form-check-label">Description:</label>
                <textarea class="form-control form-control-solid" name="description" rows="4" cols="50"><?= $value->description ?></textarea>
            </div>
        </div>
        </div>
</div>
<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" data-bs-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Update</button>
</div>
</form>
            
