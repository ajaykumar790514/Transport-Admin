
<script>
$(document).ready(function() {
    // Initialize form validation
    $(".needs-validation").validate({
        rules: {
            title: {
                required: true,
                remote: "<?=$remote?>null/title"
            },
            description: "required",
        },
        messages: {
            title: {
				required: "Please enter title",
                remote: "Title already exists!"
            },
			description: "Please enter description",
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
        <div class="col-lg-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label class="form-check-label required">Title:</label>
                <input type="text" class="form-control form-control" name="title">
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-md-12 mt-3">
            <div class="form-group">
                <label class="form-check-label required">Description:</label>
                <textarea class="form-control form-control" name="description"></textarea>
            </div>
        </div>
        </div>
</div>
<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" data-bs-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Add</button>
</div>

</form>


  