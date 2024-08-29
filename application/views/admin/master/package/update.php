<form class="ajaxsubmit needs-validation reload-page" action="<?=$action_url?>" method="post" enctype="multipart/form-data">
    <div class="row">
      
        <div class="col-lg-12 col-sm-12 col-md-12 mt-4">
            <div class="form-group">
                <label class="form-check-label mb-2 required">Name :</label>
                <input type="text" class="form-control" value="<?=$value->name;?>" name="name" placeholder="Enter Name">
            </div>
        </div>
		<div class="col-lg-6 col-sm-12 col-md-6  mt-4">
            <div class="form-group">
                <label class="form-check-label mb-2">Logo :</label>
                <input type="file" class="form-control" id="logoImage" name="logo">
            </div>
        </div>
		<div class="col-lg-6 col-sm-12 col-md-6 mt-4">
            <div class="form-group">
                <label class="form-check-label mb-2 required">Sequence :</label>
                <input type="number" class="form-control" value="<?=$value->seq;?>" name="seq" placeholder="Enter Seq">
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 col-md-6 mt-4">
            <div class="form-group">
                <label class="form-check-label mb-2 required">Price :</label>
                <input type="number" class="form-control" value="<?=$value->price;?>" name="price" placeholder="Enter Price">
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 col-md-6 mt-4">
            <div class="form-group">
                <label class="form-check-label mb-2 required">Validity (in days):</label>
                <input type="number" class="form-control" value="<?=$value->validity;?>" name="validity" placeholder="Enter Validity">
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-md-12 mt-4">
            <div class="form-group">
                <label class="form-check-label mb-2">Description:</label>
                <div id="description" style="height: 180px;" class="form-control"></div>
                <textarea name="description" class="form-control d-none"><?=$value->description;?></textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="reset" class="btn btn-default waves-effect" data-bs-dismiss="modal">Close</button>
        <button id="btnsubmit" type="submit" class="btn btn-danger waves-light"><i id="loader" class=""></i>Update</button>
    </div>
</form>

<script>
$(document).ready(function() {
    const quill = new Quill('#description', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ header: [1, 2, false] }],
                ['bold', 'italic', 'underline'],
                ['image', 'code-block']
            ]
        },
        placeholder: 'Type your text here...'
    });
    quill.clipboard.dangerouslyPasteHTML('<?=$value->description;?>');
    quill.on('text-change', function() {
        document.querySelector('textarea[name="description"]').value = quill.root.innerHTML;
    });

    $(".needs-validation").validate({
        rules: {
                name: {
                    required: true,
                    remote: "<?=$remote;?>null/name"
                },
                description: "required",
                logo: "required",
			    price: "required",
                validity: "required"
            },
            messages: {
                name: {
                    required: "Please enter name",
                    remote: "Package Name already exists!"
                },
                description: "Please Enter Description!",
                logo: "Please select logo!",
				price: "Please enter price",
                validity: "Please enter validity"
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

    // Check file size for logo upload
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
