<div class="container app">
	<div class="row my-3">
        <div class="col-12">
        	<button class="btn btn-primary float-right my-2" data-toggle="modal" data-target="#exampleModalCenter">Tambah Barang</button>
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
        			swal({
					  	title: "<?php echo $_SESSION['success'][0] ?>",
					  	text: "<?php echo $_SESSION['success'][1] ?>",
					  	type: "success",
					});
        		</script>
				<?php unset($_SESSION['success']) ?>
        	<?php endif ?>
        	<div class="table-responsive">
        		<table class="table table-striped w-100" style="min-width: 100%" id="barang_table">
				  <thead>
				    <tr>
				      <th scope="col">No</th>
				      <th scope="col">Nama Barang</th>
				      <th scope="col">Tipe Barang</th>
				      <th scope="col">Jumlah</th>
				      <th scope="col">Action</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php $i = 1; ?>
				  	<?php foreach ($barang as $p): ?>
				  		<tr>
					      <th scope="row"><?php echo $i ?></th>
					      <td><?php echo $p->namaBarang ?></td>
					      <td><?php echo $p->tipeBarang ?></td>
					      <td><?php echo $p->jumlahBarang ?></td>
					      <td>
					      	<div class="btn-group">
					      		<button class="btn btn-sm btn-primary" onclick="edit_barang(<?php echo $p->IDbarang ?>)"><i class="fa fa-edit"></i> Edit</button>
					      		<button class="btn btn-sm btn-danger" onclick='hapus_barang(<?php echo $p->IDbarang ?>)'><i class="fa fa-trash-o"></i> Hapus</button>
					      	</div>
					      </td>
					    </tr>
					    <?php $i++; ?>
				  	<?php endforeach ?>
				  </tbody>
				</table>
			</div>
	  </div>
	</div>
    <div class="row">
    	<div class="col-12">
        </div>
    </div>
    <!-- Modal -->
	<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  	<div class="modal-dialog modal-dialog-centered" role="document">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<h5 class="modal-title" id="exampleModalCenterTitle">Tambah Barang</h5>
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          			<span aria-hidden="true">&times;</span>
	        		</button>
	      		</div>
	      		<div class="modal-body">
	      			<?php $attributes = array('class' => 'needs-validation'); ?>
	      			<?php echo form_open_multipart('barang/tambah/', $attributes);?>
					  	<div class="form-row">
					    	<div class="form-group col-md-12">
					      		<label for="nama">Nama Barang</label>
					      		<div class="input-group">
					      			<input type="text" class="form-control" id="nama" name="namaBarang" placeholder="Nama Barang" required>
					      			<div class="input-group-append">
									    <span class="input-group-text" id="basic-addon2"><i class="fa fa-cube"></i></span>
									</div>
					      		</div>
					      		<div class="invalid-feedback">Anda harus mengisi Nama Barang</div>
					    	</div>
					  	</div>
					  	<div class="form-row">
					  		<div class="form-group col-md-6">
					  			<label for="email">Tipe Barang</label>
					  			<div class="input-group">
								    <input type="text" class="form-control" id="email" name="tipeBarang" placeholder="Tipe Barang" list="tipe" required>
								    <?php $tipe = $this->home_model->get_barang_column('tipeBarang') ?>
								    <datalist id="tipe">
								    	<?php foreach ($tipe as $t): ?>
								    		<option value="<?php echo $t->tipeBarang ?>"><?php echo $t->tipeBarang ?></option>
								    	<?php endforeach ?>
								    </datalist>
								    <div class="input-group-append">
									    <span class="input-group-text" id="basic-addon2"><i class="fa fa-tag"></i></span>
									</div>
					  			</div>
							</div>
					  		<div class="form-group col-md-6">
					  			<label for="password">Jumlah</label>
					  			<div class="input-group">
					  				<input type="number" class="form-control" id="password" name="jumlahBarang" placeholder="Jumlah" min="1" required>
					  			</div>
							    <div class="invalid-feedback">Anda harus mengisi Password</div>
							</div>
					  	</div>
					  	<button type="submit" class="btn btn-lg btn-block btn-primary">Tambah</button>
					</form>
	      		</div>
	    	</div>
	  	</div>
	</div>
	<!-- Modal -->

	<!-- Edit Modal -->
	<div class="modal fade" id="editModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  	<div class="modal-dialog modal-dialog-centered" role="document">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<h5 class="modal-title" id="exampleModalCenterTitle">Edit Akun</h5>
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          			<span aria-hidden="true">&times;</span>
	        		</button>
	      		</div>
	      		<div class="modal-body">
	      			<?php $attributes = array('class' => 'needs-validation', 'id'=>'editform'); ?>
	      			<?php echo form_open_multipart('barang/edit/', $attributes);?>
					  	<div class="form-row">
					  		<input type="number" name="editIDbarang" class="d-none">
					    	<div class="form-group col-md-12">
					      		<label for="editnama">Nama Barang</label>
					      		<div class="input-group">
					      			<input type="text" class="form-control" id="editnama" name="editnamaBarang" placeholder="Nama Barang" required>
					      			<div class="input-group-append">
									    <span class="input-group-text" id="basic-addon2"><i class="fa fa-cube"></i></span>
									</div>
					      		</div>
					      		<div class="invalid-feedback">Anda harus mengisi Nama Barang</div>
					    	</div>
					  	</div>
					  	<div class="form-row">
					  		<div class="form-group col-md-6">
					  			<label for="editemail">Tipe Barang</label>
					  			<div class="input-group">
								    <input type="text" class="form-control" id="editemail" name="edittipeBarang" placeholder="Tipe Barang" list="tipe" required>
								    <?php $tipe = $this->home_model->get_barang_column('tipeBarang') ?>
								    <datalist id="tipe">
								    	<?php foreach ($tipe as $t): ?>
								    		<option value="<?php echo $t->tipeBarang ?>"><?php echo $t->tipeBarang ?></option>
								    	<?php endforeach ?>
								    </datalist>
								    <div class="input-group-append">
									    <span class="input-group-text" id="basic-addon2"><i class="fa fa-tag"></i></span>
									</div>
					  			</div>
							</div>
					  		<div class="form-group col-md-6">
					  			<label for="editpassword">Jumlah</label>
					  			<div class="input-group">
					  				<input type="number" class="form-control" id="editpassword" name="editjumlahBarang" placeholder="Jumlah" min="1" required>
					  			</div>
							</div>
					  	</div>
					  	<button type="submit" class="btn btn-lg btn-block btn-primary">Edit</button>
					</form>
	      		</div>
	    	</div>
	  	</div>
	</div>
	<!-- Edit Modal -->
</div>
<script>

    function edit_barang(id){
        $('#editform')[0].reset();

        $.ajax({
            url : "<?php echo site_url('barang/data/')?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
            	$('[name="editIDbarang"]').val(data.IDbarang);
            	$('[name="editnamaBarang"]').val(data.namaBarang);
                $('[name="edittipeBarang"]').val(data.tipeBarang);
                $('[name="editjumlahBarang"]').val(data.jumlahBarang);
                $('#editModalCenter').modal('show');

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
            	console.error(textStatus);
                console.log('failed get data');
            }
        });
    }

    function hapus_barang(id) {
    	const swalWithBootstrapButtons = swal.mixin({
		  confirmButtonClass: 'btn btn-danger mx-2',
		  cancelButtonClass: 'btn btn-primary mx-2',
		  buttonsStyling: false,
		})

		swalWithBootstrapButtons({
		  title: 'Apa Anda Yakin?',
		  text: "Saat menghapusnya Anda tidak akan bisa mengembalikannya seperti semula!",
		  type: 'warning',
		  showCancelButton: true,
		  showCloseButton: true,
		  confirmButtonText: 'Ya, Hapus!',
		  cancelButtonText: 'Batalkan!',
		  reverseButtons: true
		}).then((result) => {
		  if (result.value) {
		    window.location = '<?php echo base_url() ?>barang/hapus/'+id;
		  } else if (
		    // Read more about handling dismissals
		    result.dismiss === swal.DismissReason.cancel
		  ) {
		    swal(
		      'Dibatalkan',
		      'Data Anda berhasil diamankan :)',
		      'error'
		    )
		  }
		})
    }

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
</script>

<script>

	$(document).ready(function(){
		if(!$("table#barang_table tr td").hasClass('null')) {
			var userTable = $('#barang_table').DataTable({
				info: false,
				dom: '<"top"B>flt<"bottom"p><"clear">',
				oLanguage: {sLengthMenu: "_MENU_"},
				lengthMenu: [[5, 10, 25, 50, -1], ["5 Baris","10 Baris", "25 Baris", "50 Baris", "Semua"]],
				order: [[0, "asc"]],
				buttons: [
		            {
		            	text: 'Export Excel',
		                extend: 'excelHtml5',
		                exportOptions: {
		                    columns: [0,1,2,3]
		                },
		                className: 'btn btn-success'
		            }
		        ]
			});
		}
	});
	
</script>
