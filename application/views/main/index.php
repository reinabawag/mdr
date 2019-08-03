<div class="container">
	<p align="center">
	    <a href="<?php echo site_url('main'); ?>"><img src="<?php echo base_url('assets/img/amwire_logo.jpg') ?>" width="150"></a>
	</p>
	<nav class="navbar navbar-inverse">
	  	<div class="container-fluid">
	    	<div class="navbar-header">
	    		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			      </button>
	      		<a class="navbar-brand" href="#">MISC-DR</a>
	    	</div>
	    	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		    	<ul class="nav navbar-nav">
		      		<li class="active"><a href="<?php echo site_url('main') ?>"><span class="glyphicon glyphicon-home"></span> Home</a></li>
					<li><a href="<?php echo site_url('user') ?>"><span class="glyphicon glyphicon-list"></span> MDR List</a></li>
					<li><a href="<?php echo site_url('main/calendar') ?>"><span class="glyphicon glyphicon-calendar"></span> Calendar</a></li>
					<li><a href="<?php echo site_url('main/logs') ?>"><span class="glyphicon glyphicon-print"></span> Logs</a></li>
			    </ul>
			    <ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
				        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $this->session->lastName.', '.$this->session->firstName ?>
				        <span class="caret"></span></a>
				        <ul class="dropdown-menu">
							<li><a href="<?php echo site_url('login/logout') ?>">Logout</a></li>
				        </ul>
				    </li>
				</ul>
	    	</div>
	  </div>
	</nav><!-- End of navbar -->	

	<div class="panel panel-primary">
		<div class="panel-heading">DR INFORMATION</div>
		<div class="panel-body">
			<?php echo form_open('main/create_dr', ['id' => 'frm-dr']) ?>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>D.R No.</label>
							<!-- <input type="text" name="number" id="number" class="form-control" value="<?php echo str_pad($number, 6, '0', STR_PAD_LEFT); ?>" placeholder="D.R No." readonly> -->
							<!-- dr number will be generated upon save -->
							<input type="text" name="number" id="number" class="form-control" value="" placeholder="D.R No." readonly>
							<select class="form-control" id="number-select" style="display: none;"></select>
							<span id="number"></span>
						</div>
						<?php 
						if($this->session->is_supervisor) {?>
							<div class="form-group">
								<label>
									<input type="checkbox" id="cbox-edit"> Edit Mode
							    </label>
							</div><?php
						}
						?>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Date</label>
							<input type="text" name="date" id="date" class="form-control" placeholder="D.R Date">
							<span id="date"></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Plate No.</label>
							<input type="text" name="plate" class="form-control" id="plate" placeholder="Plate Number">
							<span id="plate"></span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Delivery Truck</label>
							<input type="text" name="type" class="form-control" id="type" placeholder="Type">
							<span id="type"></span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label>Deliver To</label>
					<input type="text" name="deliver" class="form-control" id="deliver_to" placeholder="Deliver To">
					<span id="deliver"></span>
				</div>
				<div class="form-group">
					<label>Address</label>
					<input type="text" name="address" class="form-control" id="address" placeholder="Address">
					<span id="address"></span>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="auditor">Auditor</label>
							<select class="form-control" name="auditor" id="auditor" required>
								<option value="">-- Please Select --</option>
								<option value="Aries Saquibal">Aries Saquibal</option>
    							<option value="Egan Tobias">Egan Tobias</option>
    							<option value="Vianney Legacion">Vianney Legacion</option>
							</select>
							<span id="auditor"></span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="approver">Approver</label>
							<!-- <input type="text" name="approver" id="approver" class="form-control" placeholder="Approver" required=""> -->
							<select class="form-control" name="approver" id="approver" required>
								<option value="">-- Please Select --</option>
								<option value="Alfredo P. Medes">Alfredo P. Medes</option>
								<option value="Eng'r. Alfredo Plaza">Eng'r. Alfredo Plaza</option>
								<option value="Eng'r. Ben Estebal">Eng'r Ben Estebal</option>
								<option value="Eng'r. Jimmy M. Ocampo">Eng'r Jimmy M. Ocampo</option>
								<option value="Eng'r. Joel Raidis Poon">Eng'r Joel Raidis Poon</option>
								<option value="Eng'r. Joey Del Rosario">Eng'r Joey Del Rosario</option>
								<option value="Edgar T. Celebre">Edgar T. Celebre</option>
							</select>
							<span id="approver"></span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="">Remarks</label>
					<input type="text" class="form-control" name="remarks" id="remarks">
					<!-- <textarea rows="5" class="form-control" name="remarks" id="remarks"></textarea> -->
					<span id="remarks"></span>
				</div>
				<!-- <button class="btn btn-primary" id="btn-add-option">ADD ITEMS</button><hr> -->
				
				<div class="" id="grp-items"></div>
			<?php echo form_close() ?>
			<!-- <hr> -->
			<h3>ITEMS</h3>
			<table class="table table-stripe table-hover table-condensed" id="tbl-items">
				<thead>
					<tr>
						<th>QTY</th>
						<th>UNIT</th>
						<th>DESCRIPTION</th>
						<th>Options</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
			<button type="button" class="btn btn-info btn-sm" id="btn-add-item" disabled><span class="glyphicon glyphicon-plus"></span> ADD ITEM</button>
			<button class="btn btn-success btn-sm" id="btn-dr-save"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
			<button class="btn btn-success btn-sm" id="btn-dr-update" style="display: none;"><span class="glyphicon glyphicon-floppy-disk"></span> Update</button>
			<!-- <button class="btn btn-danger btn-sm" id="btn-dr-remove" style="display: none;"><span class="glyphicon glyphicon-trash"></span> Remove</button> -->
			<button class="btn btn-primary btn-sm" id="btn-dr-new" style="display: none;"><span class="glyphicon glyphicon-file"></span> New DR</button>
		</div>
	</div>
</div>

<!-- Modal -->
<div id="modal-item" class="modal fade" data-backdrop="static" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">ADD ITEMS</h4>
      </div>
      <div class="modal-body">
			<form method="POST" id="form-item">
				<input type="hidden" name="item" id="hidden-item-no">
				<div class="form-group">
					<label for="qty">Quantity</label>
					<?php echo form_input('qty', NULL, ['class' => 'form-control', 'id' => 'qty', 'placeholder' => 'Quantity']) ?>
					<span id="qty"></span>
				</div>
				<div class="form-group">
					<label for="unit">UNIT</label>
					<?php echo form_input('unit', NULL, ['class' => 'form-control', 'id' => 'unit', 'placeholder' => 'UNIT']) ?>
					<span id="unit"></span>
				</div>
				<div class="form-group">
					<label for="description">DESCRIPTION</label>
					<?php echo form_input('description', NULL, ['class' => 'form-control', 'id' => 'description', 'placeholder' => 'DESCRIPTION']) ?>
					<span id="description"></span>
				</div>
			</form>
      </div>
      <div class="modal-footer">
      	<button class="btn btn-success btn-sm" id="btn-save-item"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
      	<button class="btn btn-success btn-sm" id="btn-update-item"><span class="glyphicon glyphicon-floppy-disk"></span> Update</button>
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#remarks').jqte();

		$('#date').datepicker({
			autoclose: true,
			startDate: '<?php echo date('m/d/Y') ?>',
			todayHighlight: true,
		});

		$('#btn-add-option').click(function(e) {
			e.preventDefault();

			var wrapper = $('#grp-items');
			var template = '<div class="opt"><div class="form-group"><label>Quantity</label><input type="text" name="quantity[]" class="form-control" placeholder="Quantity"></div><div class="form-group"><label>Unit</label><input type="text" name="unit[]" class="form-control" placeholder="Unit"></div><div class="form-group"><label>Description</label><input type="text" name="description[]" class="form-control" placeholder="Description"></div><a href="#" id="remove-item">Remove</a><hr/></div>';
			$(wrapper).append(template);
		});

		$('#grp-items').on('click', '#remove-item', function(e) {
			e.preventDefault();

			$(this).parent('div').remove();
		});

		$('#btn-dr-save').click(function(e) {
			e.preventDefault();
			var form = $('#frm-dr');

			$.ajax({
				url: form.attr('action'),
				type: 'POST',
				data: form.serialize(),
				dataType: 'json'
			})
			.then(function(data) {
				if (data.error != null) {
					toastr.info(data.msg, 'Info');
					$.each(data.error, function(index, elem) {
						if (elem != '') {
							$('span#'+index).html(elem).parent('div').addClass('has-error');
						} else {
							$('span#'+index).html('').parent('div').removeClass('has-error').addClass('has-success');
						}
					});
				} else if (data.status) {
					$('#number').val(data.number);
					toastr.success(data.msg, 'Success');
					$('#btn-add-item').prop('disabled', false);
					$('#btn-dr-save').hide();
					$('#btn-dr-update').show();
					$('#btn-dr-remove').show();
					$('#btn-dr-new').show();
					$('#frm-dr span').html('').parent('div').removeClass('has-error').addClass('has-success');
				} else {
					toastr.warning(data.msg, 'Failed');
				}
			})

			.fail(function() {
				toastr.error('Cannot process request', "Error");
			})
		});

		$('#btn-dr-update').click(function(e) {
			e.preventDefault();
			var form = $('form#frm-dr');

			$.post('<?php echo site_url('main/update_dr') ?>', form.serialize(), null, 'json')
			.then(function(data) {
				if (data.error != null) {
					toastr.info(data.msg, 'Info');
					$.each(data.error, function(index, elem) {
						if (elem != '') {
							$('span#'+index).html(elem).parent('div').addClass('has-error');
						} else {
							$('span#'+index).html('').parent('div').removeClass('has-error').addClass('has-success');
						}
					});
				} else if (data.status) {
					toastr.success('MISC - DR successfully updated', 'Success');
					$('#frm-dr span').html('').parent('div').removeClass('has-error').addClass('has-success');
				} else {
					toastr.warning('Failed to update MISC - DR', 'Failed');
				}
			})
			.fail(function() {
				toastr.error('Cannot process request...', 'Error');
			})
		});

		$('#btn-dr-remove').click(function(e) {
			var number = $('input#number').val();
			var conf = confirm('Are you sure you want to delete the current MDR?');

			if (conf) {
				$.post('<?php echo site_url('main/remove_dr') ?>', {number: number}, null, 'json')
				.then(function(data) {
					toastr.success('MISC - DR removed', 'Success');
					$(':input').val('');
					$(':input').parent('div').removeClass('has-error').removeClass('has-success');
					$('#btn-dr-save').show();
					$('#btn-dr-update').hide();
					$('#btn-dr-remove').hide();
					$('#btn-dr-new').hide();
					$('#btn-add-item').prop('disabled', true);
					$('#cbox-edit').trigger('click');
					loadItem();
				})
				.fail(function() {
					toastr.error('Cannot process request...', 'Error');
				});
			}
		});

		$('#btn-dr-new').click(function() {
			if ($('tbody tr').length > 0) {
				$(this).hide();
				$(':input').val('');
				$('#remarks').jqteVal('');
				$(':input').parent('div').removeClass('has-error').removeClass('has-success');
				$('#btn-dr-save').show();
				$('#btn-dr-update').hide();
				$('#btn-dr-remove').hide();
				$('#btn-add-item').prop('disabled', true);
				$('#tbl-items tbody').empty();
				$('#cbox-edit').trigger('click');
			} else {
				alert('Items are empty');
			}
		});

		// $(window).unload(function(e) {
		// 	if ($('#tbl-items tbody tr').length == 0 && $('input#number').val() != '') {
		// 		$.post('main/remove_dr', {number: $('#number').val(), empty: 'TRUE'}, null, 'json');
		// 	}
		// });

		$('#btn-add-item').click(function(e) {
			e.preventDefault();
			$('.modal-title').html('ADD ITEM');
			$('#btn-save-item').show();
			$('#btn-update-item').hide();
			$('#modal-item').modal('show');
		});

		$('#modal-item').on('hide.bs.modal', function(e) {
			$('#qty').val('');
			$('#unit').val('');
			$('#description').val('');
			$('#modal-item span').empty();
			$('#modal-item :input').parent('div').removeClass('has-error').removeClass('has-success');
		});

		$('#btn-save-item').click(function(e) {
			e.preventDefault();
			var number = $('#number');
			var qty = $('#qty');
			var unit = $('#unit');
			var description = $('#description');

			$('#form-item').slideUp();

			$.ajax({
				type: 'POST',
				url: '<?php echo site_url('main/add_item') ?>',
				data: {number: number.val(), qty: qty.val(), unit: unit.val(), description: description.val()},
				dataType: 'json'
			}).then(function(data) {
				$('#form-item').slideDown();
				if (data.status == false) {
					$.each(data.error, function(index, elem) {
						if (elem != '') {
							$('input#'+index).parent('div').addClass('has-error');
							$('span#'+index).html(elem);
						} else {
							$('input#'+index).parent('div').removeClass('has-error').addClass('has-success');
							$('span#'+index).html('');
						}
					})
				} else {
					toastr.success('Item added to the MDR', 'Success');
					$('#modal-item').modal('hide');
					loadItem();
				}
			}).fail(function() {
				toastr.error('Cannot process request...', 'Error');
			})
		});

		$('#tbl-items tbody').on('click', '#btn-item-remove', function(e) {
			e.preventDefault();
			var remove = $(this);
			var conf = confirm('Remove the selected item');

			if (conf) {
				var number = $('input#number').val();
				var id = remove.closest('tr').find('input#item-no').val();
				$.post('<?php echo site_url('main/remove_item') ?>', {number: number, item: id}, null, 'json')
				.then(function(data) {
					if (data.status) {
						toastr.success(data.msg, 'Success');
						loadItem();
					} else {
						toastr.warning(data.msg, 'Failed');
					}
				})
				.fail(function() {
					toastr.error('Cannot process request...', 'Error');
				})
			}
		});

		$('#tbl-items tbody').on('click', '#btn-item-edit', function(e) {
			e.preventDefault();
			var edit = $(this);
			$('.modal-title').html('UPDATE ITEM');
			$('#btn-save-item').hide();
			$('#btn-update-item').show();
			var number = $('input#number').val();
			var id = edit.closest('tr').find('input#item-no').val();

			$.post('<?php echo site_url('main/get_item') ?>', {number: number, item: id}, null, 'json')
			.then(function(data) {
				$('#hidden-item-no').val(data.id);
				$('#qty').val(data.quantity);
				$('#unit').val(data.unit);
				$('#description').val(data.description);

				$('#modal-item').modal('show');
			})
			.fail(function() {
				toastr.error('Cannot process request...', 'Error');
			})	
		});

		$('#btn-update-item').click(function(e) {
			e.preventDefault();
			var item = $('#hidden-item-no').val();
			var qty = $('#qty').val();
			var unit = $('#unit').val();
			var description = $('#description').val();

			$.post('<?php echo site_url('main/update_item') ?>', {item: item, qty: qty, unit: unit, description: description}, null, 'json')
			.then(function(data) {
				if (data.error != null) {
					$.each(data.error, function(index, elem) {
						if (elem != '') {
							$('input#'+index).parent('div').addClass('has-error');
							$('span#'+index).html(elem);
						} else {
							$('input#'+index).parent('div').removeClass('has-error').addClass('has-success');
							$('span#'+index).html('');
						}
					});
				}

				if (data.status) {
					toastr.success('Item successfully updated', 'Success');
					$('#modal-item').modal('hide');
					loadItem();
				} else {
					toastr.warning('Failed to update item', 'Failed');
				}
			})
			.fail(function() {
				toastr.error('Cannot process request...', 'Error');
			})
		});

		$('#cbox-edit').change(function() {
			var mode = $(this).prop('checked');

			if (mode) {
				$('#number').hide();
				$('#number-select').empty();
				$.post('<?php echo site_url('main/get_dr_number') ?>', null, null, 'json')
				.done(function(data) {
					$('span').html('').parent('div').removeClass('has-error').removeClass('has-success');
					$('#number-select').append('<option>-- PLEASE SELECT --</option>');
					$.each(data, function(index, elem) {
						$('#number-select').append('<option>'+elem+'</option>');
					});
				})
				.fail(function() {
					toastr.error('Cannot process request...', 'Error');
				});
				$('#number-select').show();
			} else {
				$('#number').val('');
				$('#number').show();
				$('#number-select').hide();
				// addtional
				$(':input').val('');
				$('#remarks').jqteVal('');
				$(':input').parent('div').removeClass('has-error').removeClass('has-success');
				$('#btn-dr-save').show();
				$('#btn-dr-update').hide();
				$('#btn-dr-remove').hide();
				$('#btn-dr-new').hide();
				$('#btn-add-item').prop('disabled', true);
				loadItem();
			}
		});

		$('#number-select').change(function() {
			if ($('#number-select').prop("selectedIndex") > 0) {
				// additional
				$('#btn-add-item').prop('disabled', false);
				$('#btn-dr-new').show();
				$('#btn-dr-save').hide();
				$('#btn-dr-update').show();
				$('#btn-dr-remove').show();
				$.post('<?php echo site_url('main/get_dr_by_number') ?>', {number: $(this).val()}, null, 'json')
				.done(function(data) {
					$('#number').val(data.id);
					$('#date').val(data.date);
					$('#plate').val(data.plate);
					$('#type').val(data.type);
					$('#deliver_to').val(data.deliver_to);
					$('#address').val(data.address);
					$('#auditor').val(data.auditor);
					$('#approver').val(data.approver);
					$('#remarks').jqteVal(data.remarks);
					$(':input').parent('div').removeClass('has-error').removeClass('has-success');
					loadItem();
				})
				.fail(function() {
					toastr.error('Cannot process request...', 'Error');
				})
			} else {
				$(':input').val('');
				$('#remarks').jqteVal('');
				loadItem();
			}
		});

		function loadItem() {
			var number = $('#number').val();
			$('#tbl-items').slideUp();
			$('#tbl-items tbody').empty();
			$.post('<?php echo site_url('main/get_items') ?>', {number: number}, null, 'json')
			.then(function(data) {
				$.each(data.items, function(index, elem) {
					$('#tbl-items tbody').append('<tr><input type="hidden" id="item-no" value="'+elem.id+'"><td>'+elem.quantity+'</td><td>'+elem.unit+'</td><td>'+elem.description+'</td><td align="center"><button class="btn btn-primary btn-sm" id="btn-item-edit"><span class="glyphicon glyphicon-pencil"></span></button><button class="btn btn-danger btn-sm" id="btn-item-remove"><span class="glyphicon glyphicon-trash"></span></button></td></tr>');
				});
				$('#tbl-items').slideDown();
			})
			.fail(function() {
				toastr.error('Cannot process request', 'Error');
			})
		}
	})
</script>