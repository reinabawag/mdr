<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="login-wrapper">
				<h3 align="center">Welcome to MDR</h3><br>
				<?php echo form_open('login/auth_login', ['id' => 'form-login']) ?>
					<div class="form-group">
						<label for="username" class="label-control">Username</label>
						<?php echo form_input('username', NULL, ['class' => 'form-control', 'id' => 'username', 'placeholder' => 'username']) ?>
						<span id="username"></span>
					</div>
					<div class="form-group">
						<label for="password" class="label-control">Password</label>
						<?php echo form_password('password', NULL, ['class' => 'form-control', 'id' => 'password', 'placeholder' => 'password']) ?>
						<span id="password"></span>
					</div>
					<button class="btn btn-block btn-success">Login</button>
					<p id="msg" align="center"></p>
				<?php echo form_close() ?>
			</div>
		</div>			
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#form-login').submit(function(e) {
			e.preventDefault();
			var form = $(this);
			$('#msg').html('Authenticating...');

			$.post(form.attr('action'), form.serialize(), null, 'json')
			.then(function(data) {
				$('#msg').empty();
				$.each(data.validation, function(index, elem) {
					if (elem != '') {
						$('input#'+index).parent('div').addClass('has-error');
						$("span#"+index).html(elem);
					} else {
						$('input#'+index).parent('div').removeClass('has-error').addClass('has-success');
						$("span#"+index+"").html('');
					}
				});

				if (data.status) {
					$('#msg').text('Login successful');
					window.location=data.url;
				} else {
					$('#msg').html(data.validation.message);
				}
			})
			.fail(function(data, status, error) {
				toastr.error('Cannot process request...', error);
			});
		})
	})
</script>