<form class="ajaxsubmit needs-validation reload-page" action="<?=$action_url?>" method="post" enctype="multipart/form-data">
   
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label class="form-check-label mb-2 required">Title :</label>
                    <input type="text" class="form-control" value="<?=$value->title;?>" name="title" placeholder="Enter Title">
                </div>
            </div>
            <div class="col-lg-12 col-sm-12 col-md-12 mt-4">
                <div class="form-group">
                    <label class="form-check-label mb-2 required">URL :</label>
                    <input type="text" class="form-control" value="<?=$value->url;?>" name="url" placeholder="Enter URL">
                </div>
            </div>
            <div class="col-lg-12 col-sm-12 col-md-12 mt-4">
                <div class="form-group">
                    <label class="form-check-label mb-2">Description:</label>
                    <div id="description" style="height: 180px" class="form-control"></div>
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
    // Initialize Quill editor for description
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
            title: {
                required: true,
                remote: "<?=$remote;?>null/title"
            },
            description: "required",
            url: "required"
        },
        messages: {
            title: {
                required: "Please enter title",
                remote: "Title already exists!"
            },
            description: "Please Enter Description!",
            url: "Please Enter URL!"
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
