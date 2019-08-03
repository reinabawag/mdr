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

	<div class="row">
		<div class="col-md-4">
			<h4 class=""><span class="glyphicon glyphicon-user"></span>&nbsp;Auditor</h4>
			<table class="table">
				<thead>
					<th>Name</th>
					<th>Option</th>
				</thead>
				<tbody>
					
				</tbody>
			</table>
		</div>
		<div class="col-md-4 col-md-offset-4">
			<div class="panel panel-success">
				<div class="panel-heading">
					<span class="glyphicon glyphicon-user"></span>&nbsp;Auditor
				</div>
				<div class="panel-body">
					
				</div>
			</div>
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
		
	})

	function load_auditor() {
		$.get('<?php echo site_url('main/') ?>')
	}
</script>