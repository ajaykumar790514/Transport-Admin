
<script>
  $(document).ready(function() {
        $(".needs-validation").validate({
            rules: {
                day: {
                    required: true,
                    remote: "<?=$remote;?>null/day"
                },
                part_of_day: "required",
                open: "required",
				close: "required"
            },
            messages: {
                day: {
                    required: "Please enter day",
                    remote: "Day already exists!"
                },
                part_of_day: "Please select part of day!",
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
          <div class="col-lg-6 col-sm-12 col-md-6">
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
						<option value="<?= $abbreviation; ?>"><?= $fullName; ?></option>
					<?php endforeach; ?>
				</select>
            </div>
        </div>
		<div class="col-lg-6 col-sm-12 col-md-6 ">
            <div class="form-group">
                <label class="form-check-label mb-2 required">Part Of Day :</label>
				<select class="form-select form-control" name="part_of_day">
					<option value="">--Select--</option>
					<option value="Morning">Morning</option>
					<option value="Evening">Evening</option>
				   </select>
            </div>
        </div>
		<div class="col-lg-6 col-sm-12 col-md-6 mt-4">
            <div class="form-group">
                <label class="form-check-label mb-2 required">Open :</label>
				<input type="time" class="form-control form-control" name="open" >
            </div>
        </div>
		<div class="col-lg-6 col-sm-12 col-md-6 mt-4">
            <div class="form-group">
                <label class="form-check-label mb-2 required">Close :</label>
				<input type="time" class="form-control form-control" name="close" >
            </div>
        </div>
		<div class="col-lg-6 col-sm-12 col-md-6 mt-4 mb-4">
            <div class="form-group">
                <label class="form-check-label mb-2 required">IS CLOSED :</label>
				<input type="checkbox" class="form-check" style="height: 20px;width:20px" name="is_closed"  value="CLOSE">
            </div>
        </div>
</div>
<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" data-bs-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Add</button>
</div>

</form>


  