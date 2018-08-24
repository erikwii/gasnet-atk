<div class="container form-app">
	<div class="row my-3">
        <div class="col-12 offset-lg-3 col-lg-6 col-md-12">
        	<?php if (isset($_SESSION['error'])): ?>
        		<script>
        			swal({
					  	title: "Error!",
					  	text: "<?php echo $_SESSION['error'] ?>",
					  	type: "error",
					});
        		</script>
				<?php unset($_SESSION['error']) ?>
        	<?php endif ?>
        	<?php if (isset($_SESSION['success'])): ?>
        		<script>
        			const toast = swal.mixin({
					  toast: true,
					  position: 'bottom-end',
					  showConfirmButton: false,
					  timer: 5000
					});

					toast({
					  type: 'success',
					  title: '<?php echo $_SESSION['success'][1] ?>'
					})
        		</script>
				<?php unset($_SESSION['success']) ?>
        	<?php endif ?>
			<div class="card">
	      		<div class="card-header">
	        		<h5 class="modal-title" id="exampleModalCenterTitle">Form Permohonan Kendaraan Operasional</h5>
	      		</div>
	      		<div class="card-body">
	      			<?php $attributes = array('class' => 'needs-validation'); ?>
	      			<?php echo form_open_multipart('permintaan/tambah', $attributes);?>
					  	<div class="form-row">
					    	<div class="form-group col-md-12">
					      		<label for="tanggalBerangkat">Nama Karyawan</label>
					      		<div class="input-group">
					      			<input type="text" class="form-control" id="tanggalBerangkat" name="namaKaryawan" placeholder="Nama Karyawan" list="karyawan" required>
					      			<?php $karyawan = $this->admin_model->get_permintaan_column('namaKaryawan') ?>
					      			<datalist id="karyawan">
					      				<?php foreach ($karyawan as $k): ?>
					      					<option value="<?php echo $k->namaKaryawan ?>"><?php echo $k->namaKaryawan ?></option>
					      				<?php endforeach ?>
					      			</datalist>
					      			<div class="input-group-append">
									    <span class="input-group-text" id="basic-addon2"><i class="fa fa-user"></i></span>
									</div>
					      		</div>
					    	</div>
					    	<div class="form-group col-md-6">
					      		<label for="IDbarang">Nama Barang</label>
					      		<select name="IDbarang" id="IDbarang" class="form-control" required>
					      			<option selected disabled>Pilih Barang</option>
					      			<?php $barang = $this->home_model->get_barang() ?>
					      			<?php foreach ($barang as $b): ?>
					      				<?php if ($b->jumlahBarang < 1): ?>
					      					<option disabled value="<?php echo $b->IDbarang ?>" title="<?php echo $b->jumlahBarang ?> buah"><?php echo $b->namaBarang ?></option>
					      				<?php else: ?>
					      					<option value="<?php echo $b->IDbarang ?>" title="<?php echo $b->jumlahBarang ?> buah"><?php echo $b->namaBarang ?></option>
					      				<?php endif ?>
					      			<?php endforeach ?>
					      		</select>
					    	</div>
					    	<div class="form-group col-md-6">
					      		<label for="jumlah">Jumlah</label>
					      		<div class="input-group">
					      			<input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah" required>
					      		</div>
					    	</div>
					  	</div>
					  	<button type="submit" class="btn btn-block btn-lg btn-primary">Tambah</button>
					</form>
	      		</div>
	    	</div>
	    </div>
	</div>
</div>
<script type="text/javascript">
	// Example starter JavaScript for disabling form submissions if there are invalid fields
	(function() {
	  'use strict';
	  window.addEventListener('load', function() {
	    // Fetch all the forms we want to apply custom Bootstrap validation styles to
	    var forms = document.getElementsByClassName('needs-validation');
	    // Loop over them and prevent submission
	    var validation = Array.prototype.filter.call(forms, function(form) {
	      form.addEventListener('submit', function(event) {
	        if (form.checkValidity() === false) {
	          event.preventDefault();
	          event.stopPropagation();
	        }
	        form.classList.add('was-validated');
	      }, false);
	    });
	  }, false);
	})();

	$(document).ready(function() {
		
		$('#IDbarang').change(function() {
        	$('#jumlah').attr('max', $(this).find("option:selected").attr("title"));
    	});

	});
</script>