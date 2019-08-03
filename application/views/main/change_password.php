<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default" style="margin-top: 25%">
				<div class="panel-heading">Change Password</div>
				<div class="panel-body">
					<form action="" method="POST">
						<input type="hidden" name="id" value="<?php echo $this->session->userId ?>">
						<div class="form-group">
							<label>Password</label>
							<input type="password" class="form-control" name="password" placeholder="Password">

							<span id="password"></span>
						</div>
						<div class="form-group">
							<label>Confirm Password</label>
							<input type="password" class="form-control" name="c_password" placeholder="Confirm Password">

							<span id="c_password"></span>
						</div>
						<button class="btn btn-primary btn-block">Change Password</button>
					</form>
				</div>
			</div>
		</div>			
	</div>
</div>

<script>
	$(document).ready(function() {
		$('form').submit(function(e) {
			e.preventDefault();
			var form = $(this);

			$.post('<?php echo site_url('user/change_password') ?>', form.serialize(), null, 'json')
			.done(function(data) {
				$(':input').parent('div').removeClass('has-error').find('span').empty();
				if (data.status) {
					toastr.success('Password updated', 'Success');
					window.location=data.url;
				}
				else if (data.statu == false && data.error == null) {
					toastr.success('Error updating password', 'System error or network');
				} else {
					$.each(data.error, function(index, elem) {
						$('span#'+index).empty().parent('div').removeClass('has-error');
						if (elem != '') {
							$('span#'+index).html(elem).parent('div').addClass('has-error');
						}
					})
				}
			})
			.fail(function() {
				toastr.error('Cannot process request...', 'System error or network');
			})
		})
	})
</script>