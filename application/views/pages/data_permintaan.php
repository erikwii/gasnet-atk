<div class="container app">
	<div class="row my-3">
        <div class="col-12 col-lg-12 col-md-12">
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
        		<table class="table table-striped w-100" style="min-width: 100%" id="permintaan_table">
				  <thead>
				    <tr>
				      <th scope="col">No</th>
				      <th scope="col">Tanggal</th>
				      <th scope="col">Nama Karyawan</th>
				      <th scope="col">Nama Barang</th>
				      <th scope="col">Jumlah</th>
				      <th scope="col">Action</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php $i = 1; ?>
				  	<?php foreach ($permintaan as $p): ?>
				  		<?php 
				  			$timestamp = strtotime($p->tanggal);
							$day = date('D', $timestamp);
				  		?>
				  		<tr>
					      <th scope="row"><?php echo $i ?></th>
					      <td><?php echo $this->home_model->tranlate_day_to_indo($day)."/".$this->home_model->read_date($p->tanggal) ?></td>
					      <td><?php echo $p->namaKaryawan ?></td>
					      <td><?php echo $p->namaBarang ?></td>
					      <td><?php echo $p->jumlah ?></td>
					      <td>
					      	<div class="btn-group">
					      		<button class="btn btn-sm btn-outline-primary" onclick="edit_permintaan(<?php echo $p->IDpermintaan ?>)"><i class="fa fa-edit"></i> Edit</button>
					      		<button class="btn btn-sm btn-success" onclick='batalkan_permintaan(<?php echo $p->IDpermintaan ?>)'><i class="fa fa-refresh"></i> Batalkan</button>
					      		<button class="btn btn-sm btn-danger align-middle d-inline-flex" onclick='hapus_permintaan(<?php echo $p->IDpermintaan ?>)'><i class="material-icons">delete_outline</i> Hapus</button>
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

	<!-- Edit Modal -->
	<div class="modal fade" id="editModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  	<div class="modal-dialog modal-dialog-centered" role="document">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<h5 class="modal-title" id="exampleModalCenterTitle">Edit Permintaan <span id="tgledit"></span></h5>
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          			<span aria-hidden="true">&times;</span>
	        		</button>
	      		</div>
	      		<div class="modal-body">
	      			<?php $attributes = array('class' => 'needs-validation', 'id'=>'editform'); ?>
	      			<?php echo form_open_multipart('permintaan/edit/', $attributes);?>
					  	<div class="form-row">
					  		<input type="number" name="IDpermintaan" class="d-none">
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
					      				<option value="<?php echo $b->IDbarang ?>" title="<?php echo $b->jumlahBarang ?>"><?php echo $b->namaBarang ?></option>
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
					  	<button type="submit" class="btn btn-primary">Edit</button>
					</form>
	      		</div>
	    	</div>
	  	</div>
	</div>
	<!-- Edit Modal -->
</div>
<script>

	function read_date(date) {
		var arrdate = date.split('-');

		var bulan = {'01': 'Januari', '02': 'Februari', '03': 'Maret','04': 'April', '05': 'Mei', '06': 'Juni','07': 'Juli', '08': 'Agustus', '09': 'September','10': 'Oktober', '11': 'November', '12': 'Desember'};

		return arrdate[2]+" "+bulan[arrdate[1]]+" "+arrdate[0];
	}

    function edit_permintaan(id){
        $('#editform')[0].reset();

        $.ajax({
            url : "<?php echo site_url('permintaan/data_permintaan/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
            	// console.table(data);
                $('[name="IDpermintaan"]').val(data.IDpermintaan);
                $('[name="namaKaryawan"]').val(data.namaKaryawan);
                $('[name="jumlah"]').val(data.jumlah);
                $('[name="IDbarang"]').val(data.IDbarang);
                $('#editModalCenter').modal('show');

            },
            error: function (jqXHR, textStatus, errorThrown)
            {	
            	console.error(textStatus);
                console.log('failed get data');
            }
        });
    }

    function batalkan_permintaan(id) {
    	const swalWithBootstrapButtons = swal.mixin({
		  	confirmButtonClass: 'btn btn-success mx-2',
		  	cancelButtonClass: 'btn btn-primary mx-2',
		  	buttonsStyling: false,
		})

		swalWithBootstrapButtons({
		  	title: 'Apa Anda Yakin?',
		  	text: "Saat membatalkannya data permintaan akan dihapus dan stok barang akan kembali pada kondisi di mana saat barang belum diminta",
		  	type: 'warning',
		  	showCancelButton: true,
		  	showCloseButton: true,
		  	confirmButtonText: 'Ya, Batalkan Permintaan!',
		  	cancelButtonText: 'Back',
		  	reverseButtons: true
		}).then((result) => {
		  	if (result.value) {
		    	window.location = '<?php echo base_url() ?>permintaan/batal/'+id;
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

    function hapus_permintaan(id) {
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
		    	window.location = '<?php echo base_url() ?>permintaan/hapus/'+id;
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

		if(!$("table#permintaan_table tr td").hasClass('null')) {
			var preRegTable = $('#permintaan_table').DataTable({
				info: false,
				dom: '<"top"B>flt<"bottom"p><"clear">',
				oLanguage: {sLengthMenu: "_MENU_"},
				lengthMenu: [[5, 10, 25, 50, -1], ["5 Baris","10 Baris", "25 Baris", "50 Baris", "Semua"]],
				order: [[0, "asc"]],
				buttons: [
		            {
		                extend: 'excelHtml5',
		                exportOptions: {
		                    columns: [0,1,2,3,4]
		                }
		            }
		        ]
			});
		}
	});
</script>
