<!-- Image and text -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #f8f9fa;">
  	<a href="<?php echo base_url() ?>" class="navbar-brand">
    	<img src="<?php echo base_url() ?>assets/img/gasnet.png" width="60" height="35" class="d-inline-block align-top" alt="logo">
    	<span class="text-danger pacifico"><b>ATK</b></span>
  	</a>
  	<?php if (isset($_SESSION['atk_email'])): ?>
	  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
	    	<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavDropdown">
		    <ul class="navbar-nav my-lg-0 ml-auto">
		    	<?php if (isset($_SESSION['atk_email'])): ?>
		    		<?php if (isset($nav_active) && $nav_active == 'permintaan'): ?>
						<li class="nav-item active">
					       	<b><a class="nav-link text-primary" href="<?php echo base_url() ?>permintaan/"><i class="fa fa-file-text-o"></i> Form Permintaan</a></b>
					    </li>
			    	<?php else: ?>
			    		<li class="nav-item">
					       	<b><a class="nav-link" href="<?php echo base_url() ?>permintaan/"><i class="fa fa-file-text-o"></i> Form Permintaan</a></b>
					    </li>
			    	<?php endif ?>
		    	<?php endif ?>
		    	<?php if (isset($_SESSION['atk_email'])): ?>
			    	<?php if (isset($nav_active) && $nav_active == 'data'): ?>
				    	<li class="nav-item active">
				        	<b>
				        		<a class="nav-link text-primary" href="<?php echo base_url() ?>permintaan/data/">
				        			<i class="fa fa-inbox"></i> Data Permintaan
				        		</a>
				        	</b>
				      	</li>
				    <?php else: ?>
				    	<li class="nav-item">
				        	<b>
				        		<a class="nav-link" href="<?php echo base_url() ?>permintaan/data/">
				        			<i class="fa fa-inbox"></i> Data Permintaan 
				        		</a>
				        	</b>
				      	</li>
			      	<?php endif; ?>
			      	<?php if (isset($nav_active) && $nav_active == 'barang'): ?>
						<li class="nav-item active">
				        	<b><a class="nav-link text-primary" href="<?php echo base_url() ?>barang/"><i class="fa fa-cube"></i> Data Barang</a></b>
				      	</li>
				    <?php else: ?>
				    	<li class="nav-item">
				        	<b><a class="nav-link" href="<?php echo base_url() ?>barang/"><i class="fa fa-cube"></i> Data Barang</a></b>
				      	</li>
					<?php endif ?>
				<?php endif ?>
				<?php if (isset($_SESSION['atk_email'])): ?>
			      	<li class="nav-item">
			        	<b><a class="nav-link" href="<?php echo base_url() ?>home/logout"><i class="fa fa-sign-out"></i> Logout <span class="sr-only">(current)</span></a></b>
			      	</li>
				<?php endif ?>
			</ul>
		</div>
  	<?php endif ?>
</nav>
<script type="text/javascript">
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
</script>