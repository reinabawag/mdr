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
  		      		<li><a href="<?php echo site_url('main') ?>"><span class="glyphicon glyphicon-home"></span> Home</a></li>
  					<li><a href="<?php echo site_url('user') ?>"><span class="glyphicon glyphicon-list"></span> MDR List</a></li>
  					<li><a href="<?php echo site_url('main/calendar') ?>"><span class="glyphicon glyphicon-calendar"></span> Calendar</a></li>
  					<li class="active"><a href="<?php echo site_url('main/logs') ?>"><span class="glyphicon glyphicon-print"></span> Logs</a></li>
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

	<div class="row">
		<div class="col-md-4">
			<form method="GET" id="frm-logs">
				<div class="form-group">
					<label for="date">Date</label>
					<input type="text" name="date" class="form-control" id="date" placeholder="Date" value="<?php echo date('m/d/Y') ?>">
				</div>
				<div class="form-group">
					<label for="filter">Filter</label>
					<select name="filter" class="form-control" id="filter">
						<option value="0">ALL</option>
						<option value="1">Login/out</option>
						<option value="2">MDR Created</option>
					</select>
				</div>
				<input type="submit" role="button" id="btn-filter" class="btn btn-success btn-sm" value="FILTER">
				<input type="reset" role="button" class="btn btn-warning btn-sm">
			</form>
		</div>
		<div class="col-md-8">
			<textarea class="form-control" id="log-container" rows="15" disabled=""></textarea>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		loadLogs();

		$('#date').datepicker({
			setDate: new Date(),
			autoclose: true,
			todayBtn: true,
			todayHighlight: true
		});

		$('#btn-filter').click(function(e) {
			e.preventDefault();

			loadLogs();
		});

		function loadLogs() {
			$.get('<?php echo site_url('main/audit_logs') ?>', $('#frm-logs').serialize(), function() { $('#log-container').empty() })
			.done(function(data) {
				$.each(JSON.parse(data), function(index, elem) {
					$('#log-container').append(elem);
				})
			})
			.fail(function() {
				alert('Cannot process request...');
			})
		}
	})
</script>