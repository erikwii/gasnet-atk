<div class="container app login">
	<div class="row my-3">
		<div class="col-lg-4 offset-lg-4">
			<img src="<?php echo base_url() ?>assets/img/gasnet.png" class="w-100">
		</div>
	</div>
	<div class="row my-3">
        <div class="col-12 col-lg-4 offset-lg-4 col-md-4">
        	<?php if (isset($_SESSION['login_error'])): ?>
        		<script>
        			swal({
					  	title: "Error!",
					  	text: "<?php echo $_SESSION['login_error']?>",
					  	type: "error",
					});
        		</script>
				<?php unset($_SESSION['login_error']) ?>
        	<?php endif ?>
        	<?php if (isset($_SESSION['login_success'])): ?>
        		<script>
        			swal({
					  	title: "Berhasil!",
					  	text: "<?php echo $_SESSION['login_success'] ?>",
					  	type: "success",
					});
        		</script>
				<?php unset($_SESSION['login_success']) ?>
        	<?php endif ?>
        	<form action="<?php echo base_url() ?>home/login/" class="needs-validation" method="post">
			  	<div class="form-group">
			    	<label for="exampleInputEmail1">Email</label>
			    	<div class="input-group">
			    		<input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Your Email" required>
			    		<div class="input-group-append">
						    <span class="input-group-text bg-white text-primary" id="basic-addon2"><i class="fa fa-envelope"></i></span>
						</div>
			    	</div>
			  	</div>
			  	<div class="form-group">
			    	<label for="exampleInputPassword1">Password</label>
			    	<div class="input-group">
			    		<input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Your Password" required>
			    		<div class="input-group-append">
						    <span class="input-group-text bg-white text-primary" id="basic-addon2"><i class="fa fa-lock"></i></span>
						</div>
			    	</div>
			  	</div>
			  	<button type="submit" class="btn btn-block btn-primary mb-2">Login</button>
			  	atau isi form permintaan <a href="<?php echo base_url('permintaan') ?>">di sini</a>
			</form>
        </div>
    </div>
</div>