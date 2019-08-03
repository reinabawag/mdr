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
  					<li class="active"><a href="<?php echo site_url('main/calendar') ?>"><span class="glyphicon glyphicon-calendar"></span> Calendar</a></li>
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
		<div class="col-md-8 col-md-offset-2">
			<div class="well">
				<strong>Calendar Legends</strong> Green is for today's Delivery
			</div>
		</div>
		<div class="col-md-8 col-md-offset-2">
			<div id="calendar"></div>	
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			defaultDate: '<?php echo date('Y-m-d') ?>',
			eventLimit: true, // allow "more" link when too many events
			events: '<?php echo site_url('main/events') ?>',
			eventClick: function(event) {
				if (event.url) {
					window.open(event.url);
					return false;
				}
			}
		});
	})
</script>