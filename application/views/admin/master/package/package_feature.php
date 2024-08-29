<div class="row">
	<div class="table-responsive table-wrap col-md-12">
		<table class="table table-striped table-bordered base-styl menuaccess">
			<thead>
				<tr>
					<th>Select</th>
					<th>Features</th>
				</tr>
			</thead>
			<tbody id="propaccess">
                <?php foreach ($features as $row){?>
                    <tr>
                        <td>
                            <input type="checkbox" class="switchery" data-size="sm" style="height: 20px;width:20px;" name="" id="amenu<?=$row->id?>" value="<?=$row->id?>" <?=$row->checked?> >
                            <label for="amenu<?=$row->id?>"></label>
                        </td>
                        <td><?=$row->title?></td>
                     	
                    </tr>
				
                <?php }?>
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
	   $.post('<?=$m_access_url?><?=$package_id?>',{m_id:id,type:type,name:name})
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
