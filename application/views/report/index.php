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
  					<li class="active"><a href="<?php echo site_url('user') ?>"><span class="glyphicon glyphicon-list"></span> MDR List</a></li>
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
	
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">AUDIT REPORT</div>
				<div class="panel-body">
					<form>
						<div class="form-group">
							<label>From</label>
							<input type="text" name="dateFrom" class="form-control" maxlength="0">
						</div>
						<div class="form-group">
							<label>To</label>
							<input type="text" name="dateTo" class="form-control" maxlength="0">
						</div>
						<button class="btn btn-primary btn-block">Generate Report</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('input[name="dateFrom"]').datepicker("setDate", new Date);
		$('input[name="dateTo"]').datepicker("setDate", new Date);
	});

	$('form').submit(function(e) {
		e.preventDefault();
		var start = $('input[name="dateFrom"]').val();
		var end = $('input[name="dateTo"]').val();

		if (start > end) {
			toastr.warning('Start Date Cannot Be Greater Than End Date');
			return false;
		}
		
		var url = '<?php echo site_url('report/audit_report') ?>/?startDate='+encodeURIComponent($('input[name="dateFrom"]').val())+'&endDate='+encodeURIComponent($('input[name="dateTo"]').val());
		window.open(url, '_blank');
	})
</script>