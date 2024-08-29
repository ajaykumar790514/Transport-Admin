
<script>
  $(document).ready(function() {
        $(".needs-validation").validate({
            rules: {
                day: {
                    required: true,
                    remote: "<?=$remote;?>null/day"
                },
                open: "required",
				close: "required"
            },
            messages: {
                day: {
                    required: "Please enter day",
                    remote: "Day already exists!"
                },
                 open: "Please select open time",
				close: "Please select close time"
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

<div class="row">
          <div class="col-lg-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label class="form-check-label mb-2 required">Day :</label>
				<?php
				$days = [
					"Sunday" => "sun",
					"Monday" => "mon",
					"Tuesday" => "tue",
					"Wednesday" => "wed",
					"Thursday" => "thu",
					"Friday" => "fri",
					"Saturday" => "sat"
				];
				?>
				<select class="form-select form-control" name="day">
					<option value="">--Select--</option>
					<?php foreach ($days as $fullName => $abbreviation): ?>
						<option value="<?= $abbreviation; ?>"  <?php if($value->day==$abbreviation){ echo "selected";} ;?> ><?= $fullName; ?></option>
					<?php endforeach; ?>
				</select>
            </div>
        </div>
		<div class="col-lg-6 col-sm-12 col-md-6 mt-4">
            <div class="form-group">
                <label class="form-check-label mb-2 required">Open :</label>
				<input type="time" class="form-control form-control" name="open" value="<?=$value->open;?>" >
            </div>
        </div>
		<div class="col-lg-6 col-sm-12 col-md-6 mt-4">
            <div class="form-group">
                <label class="form-check-label mb-2 required">Close :</label>
				<input type="time" class="form-control form-control" value="<?=$value->close;?>" name="close" >
            </div>
        </div>
		<div class="col-lg-6 col-sm-12 col-md-6 mt-4 mb-4">
            <div class="form-group">
                <label class="form-check-label mb-2 required">IS CLOSED :</label>
				<input type="checkbox" class="form-check" style="height: 20px;width:20px" name="is_closed" <?php if($value->is_closed=='CLOSE'){ echo "checked";} ;?>  value="CLOSE">
            </div>
        </div>
</div>
<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" data-bs-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Update</button>
</div>

</form>


  