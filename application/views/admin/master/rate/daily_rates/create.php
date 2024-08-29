
<script>
$(document).ready(function() {
    // Initialize form validation
    $(".needs-validation").validate({
        rules: {
            rate: {
                required: true,
            },
            daily_item_master_id: "required",
        },
        messages: {
            rate: {
				required: "Please enter rate",
            },
			daily_item_master_id: "Please select daily items ",
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
                <label class="form-check-label mb-2 required">Daily Items :</label>
                <select class="form-select form-select" name="daily_item_master_id">
				<option value="">--Select--</option>
					<?php foreach($daily_items_master as $items):?>
					<option value="<?=$items->id;?>"><?=$items->title;?></option>
					<?php endforeach;?>
				</select>
            </div>
        </div>
		<div class="col-lg-12 col-sm-12 col-md-12 mt-4">
		<div class="form-group">
			<label class="form-check-label mb-2 required">Rate:</label>
			<div class="input-group">
				<input type="text" class="form-control form-control" name="rate" placeholder="Enter rate">
				<select class="form-select form-select" name="rate_type">
					<option value="">--Select--</option>
					<?php foreach($min_order_qty_types as $types):?>
					<option value="<?=$types->id;?>"><?=$types->title;?></option>
					<?php endforeach;?>
				</select>
			</div>
		</div>
	</div>

    </div>
</div>
<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" data-bs-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Add</button>
</div>

</form>


  