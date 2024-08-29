<script type="text/javascript">
$(document).ready(function() {
	$(".select2").select2();
    $(".needs-validation").validate({
        rules: {
            title: "required"
        },
        messages: {
            title: "Please enter a title"
        },
        errorClass: "error",
        errorElement: "div",
        highlight: function(element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
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
          <div class="col-lg-4">
            <div class="form-group">
                <label class="form-check-label">Parent Menu:</label>
                <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Select Parent Menu" style="width:100%;" name="parent" id="parent" onchange="fetch_submenu(this.value)">
                <option value="">--Select--</option>
                <?php foreach ($parent_menus as $parent) { ?>
                <option value="<?php echo $parent->id; ?>">
                    <?php echo $parent->title; ?>
                </option>
                <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label class="form-check-label">Sub Menu:</label>
                <select class="form-select form-select-solid " style="width:100%;" id="sub_parent" name="sub_parent">
                </select>
            </div>
        </div>
        <div class="col-lg-4 mt-3">
            <div class="form-group">
                <label class="form-check-label">Title:</label>
                <input type="text" class="form-control form-control-solid" name="title">
            </div>
        </div>
        <div class="col-lg-5 mt-3">
            <div class="form-group">
                <label class="form-check-label">Icon class:</label>
                <input type="text" class="form-control form-control-solid" name="icon_class">
            </div>
        </div>
      
        <div class="col-lg-5 mt-3">
            <div class="form-group">
                <label class="form-check-label">Url:</label>
                <input type="text" class="form-control form-control-solid" name="url">
            </div>
        </div>
        <div class="col-lg-2 mt-3">
            <div class="form-group">
                <label class="form-check-label">Indexing:</label>
                <input type="number" class="form-control form-control-solid" name="indexing">
            </div>
        </div>
        </div>
 
        

</div>
<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" data-bs-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Add</button>
</div>

</form>

<script>
	function fetch_submenu(parent)
   {
    $.ajax({
        url: "<?php echo base_url('acl-data/fetch_submenu'); ?>",
        method: "POST",
        data: {
            parent:parent
        },
        success: function(data){
            $("#sub_parent").html(data);
        },
    });
   }
</script>
  