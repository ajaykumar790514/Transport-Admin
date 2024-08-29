<div class="row">
	<div class="table-responsive table-wrap col-md-12">
		<table class="table table-striped table-bordered base-styl menuaccess">
			<thead>
				<tr>
					<th>Select</th>
					<th>Menu</th>
					<th>Create</th>
					<th>Update</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody id="propaccess">
                <?php foreach ($menus as $row) { if($row->parent=="0"){ ?>
                    <tr>
                        <td>
                            <input type="checkbox" class="switchery" data-size="sm" name="" id="amenu<?=$row->id?>" value="<?=$row->id?>" <?=$row->checked?> >
                            <label for="amenu<?=$row->id?>"></label>
                        </td>
                        <td><?=$row->title?></td>
                        <td>
                            <input type="checkbox" class="switchery permissions" data-size="sm" name="add" value="<?=$row->id?>" <?=$row->c_checked?> id="cmenu<?=$row->id?>" >
                            <label for="cmenu<?=$row->id?>"></label>
                        </td>
                        <td>
                            <input type="checkbox" class="switchery permissions" data-size="sm" name="update" value="<?=$row->id?>" <?=$row->u_checked?> id="umenu<?=$row->id?>" >
                            <label for="umenu<?=$row->id?>"></label>
                        </td>
                        <td>
                            <input type="checkbox" class="switchery permissions" data-size="sm" name="delete" value="<?=$row->id?>" <?=$row->d_checked?> id="dmenu<?=$row->id?>" >
                            <label for="dmenu<?=$row->id?>"></label>
                        </td>	
                    </tr>
					<?php foreach ($menus as $row2) { if($row2->parent==$row->id){ ?>
                    <tr>
                        <td>
                            <input type="checkbox" class="switchery" data-size="sm" name="" id="amenu<?=$row2->id?>" value="<?=$row2->id?>" <?=$row2->checked?> >
                            <label for="amenu<?=$row2->id?>"></label>
                        </td>
                        <td><p class="text-xs"><i class="fas fa-arrow-right ml-5"></i> <?=$row2->title?></p></td>
                        <td>
                            <input type="checkbox" class="switchery permissions" data-size="sm" name="add" value="<?=$row2->id?>" <?=$row2->c_checked?> id="cmenu<?=$row2->id?>" >
                            <label for="cmenu<?=$row2->id?>"></label>
                        </td>
                        <td>
                            <input type="checkbox" class="switchery permissions" data-size="sm" name="update" value="<?=$row2->id?>" <?=$row2->u_checked?> id="umenu<?=$row2->id?>" >
                            <label for="umenu<?=$row2->id?>"></label>
                        </td>
                        <td>
                            <input type="checkbox" class="switchery permissions" data-size="sm" name="delete" value="<?=$row->id?>" <?=$row2->d_checked?> id="dmenu<?=$row2->id?>" >
                            <label for="dmenu<?=$row2->id?>"></label>
                        </td>	
                    </tr>
					<?php foreach ($menus as $row3) { if($row3->parent==$row2->id){ ?>
                    <tr >
                        <td>
                            <input type="checkbox" class="switchery" data-size="sm" name="" id="amenu<?=$row3->id?>" value="<?=$row3->id?>" <?=$row3->checked?> >
                            <label for="amenu<?=$row3->id?>"></label>
                        </td>
                        <td><p class="text-xs ml-5"><i class="fas fa-arrow-right ml-5"></i> <?=$row3->title?></p></td>
                        <td>
                            <input type="checkbox" class="switchery permissions" data-size="sm" name="add" value="<?=$row3->id?>" <?=$row3->c_checked?> id="cmenu<?=$row3->id?>" >
                            <label for="cmenu<?=$row3->id?>"></label>
                        </td>
                        <td>
                            <input type="checkbox" class="switchery permissions" data-size="sm" name="update" value="<?=$row3->id?>" <?=$row3->u_checked?> id="umenu<?=$row3->id?>" >
                            <label for="umenu<?=$row3->id?>"></label>
                        </td>
                        <td>
                            <input type="checkbox" class="switchery permissions" data-size="sm" name="delete" value="<?=$row->id?>" <?=$row3->d_checked?> id="dmenu<?=$row3->id?>" >
                            <label for="dmenu<?=$row3->id?>"></label>
                        </td>	
                    </tr>
                <?php }}}}}} ?>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">

	$('.menuaccess .switchery').change(function(event){
		$this = $(this);
		var id = $this.val();
		var name = $this.attr('name');
		if (event.currentTarget.checked) {
			var type = 'set';  
	   }
	   else{
	   	var type = 'remove';
	   }
	   $.post('<?=$m_access_url?><?=$user_role?>',{m_id:id,type:type,name:name})
		.done(function(data){
			console.log(data);
			data = JSON.parse(data);
			toastr.success(data.res,data.msg);
			if (data.res=='success') {
				if (name=='') {
					if (type=="set") {
						$this.parent().parent().children().children('.permissions').prop('checked',true);
					}
					else{
						$this.parent().parent().children().children('.permissions').prop('checked',false);
					}
				}
				loadtb();
			}
			if (data.res=="error") {
				if (type=="set") {
					$this.prop('checked',false);
				}
				else{
					$this.prop('checked',true);
				}
			}
		})
  })
</script>
