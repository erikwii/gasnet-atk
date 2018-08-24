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
					      		<button class="btn btn-sm btn-outline-primary" onclick="edit_permohonan(<?php echo $p->IDpermintaan ?>)"><i class="fa fa-edit"></i> Edit</button>
					      		<button class="btn btn-sm btn-danger" onclick='hapus_permohonan(<?php echo $p->IDpermintaan ?>)'><i class="fa fa-trash-o"></i> Hapus</button>
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
	        		<h5 class="modal-title" id="exampleModalCenterTitle">Edit Permohonan <span id="tgledit"></span></h5>
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          			<span aria-hidden="true">&times;</span>
	        		</button>
	      		</div>
	      		<div class="modal-body">
	      			<?php $attributes = array('class' => 'needs-validation', 'id'=>'editform'); ?>
	      			<?php echo form_open_multipart('permintaan/edit/', $attributes);?>
					  	<div class="form-row">
					  		<input type="number" name="IDpermohonan" class="d-none">
					    	<div class="form-group col-md-5">
					      		<label for="edittanggalBerangkat">Tgl. Keberangkatan</label>
					      		<div class="input-group">
					      			<input type="text" class="form-control datepicker" id="edittanggalBerangkat" name="edittanggalBerangkat" placeholder="Tgl. Keberangkatan" required>
					      			<div class="input-group-append">
									    <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
									</div>
					      		</div>
					      		<div class="invalid-feedback">Anda harus mengisi Tanggal Keberangkatan</div>
					    	</div>
					    	<div class="form-group col-md-7">
					      		<label for="editnamaPengguna">Nama Pengguna</label>
					      		<input id="editnamaPengguna" name="editnamaPengguna" class="form-control" placeholder="Nama Pengguna" required/>
					      		<div class="invalid-feedback">Anda harus mengisi Nama Pengguna</div>
					    	</div>
					  	</div>
					  	<div class="form-row">
					  		<div class="form-group col-md-4" id="editberangkat">
					  			<label for="editjamBerangkat">Jam Berangkat</label>
					  			<div class="input-group">
								    <input type="text" class="form-control" id="editjamBerangkat" name="editjamBerangkat" placeholder="Berangkat" required>
								    <div class="input-group-append">
									    <span class="input-group-text" id="basic-addon2"><i class="fa fa-clock-o"></i></span>
									</div>
					  			</div>
							    <div class="invalid-feedback">Anda harus mengisi Jam Berangkat</div>
							</div>
					  		<div class="form-group col-md-4" id="editkembali">
					  			<label for="editjamKembali">Jam Kembali</label>
					  			<div class="input-group">
					  				<input type="text" class="form-control" id="editjamKembali" value="" name="editjamKembali" placeholder="Kembali" required>
								    <div class="input-group-append">
								        <span class="input-group-text"><span class="fa fa-clock-o"></span></span>
								    </div>
					  			</div>
							    <div class="invalid-feedback">Anda harus mengisi Jam Kembali</div>
							</div>
							<div class="form-group col-md-4">
						    	<label for="editnoPol">No. Polisi</label>
						    	<input type="text" class="form-control" id="editnoPol" name="editnoPol" placeholder='ex: "B 1234 CD"'  />
						    	<div class="invalid-feedback">Anda harus mengisi Tujuan</div>
						  	</div>
					  	</div>
					  	<div class="form-row">
					  		<div class="form-group col-md-6">
						    	<label for="editsatuanKerja">Satuan Kerja</label>
						    	<input type="text" class="form-control" id="editsatuanKerja" name="editsatuanKerja" list="satuan" placeholder="Satuan Kerja" required />
						    	<div class="invalid-feedback">Anda harus mengisi Satuan Kerja</div>
						  	</div>
						  	<div class="form-group col-md-6">
						    	<label for="editpengemudi">Nama Pengemudi</label>
						    	<input type="text" class="form-control" id="editpengemudi" name="editpengemudi" placeholder="Nama Pengemudi"  />
						    	<div class="invalid-feedback">Anda harus mengisi Satuan Kerja</div>
						  	</div>
						<?php if ($_SESSION['atk_level'] == 0 || $_SESSION['atk_level'] == 3): ?>
						  	<div class="form-group col-md-3">
						    	<label for="editkmAwal">KM Awal</label>
						    	<input type="number" class="form-control" id="editkmAwal" name="editkmAwal" list="satuan" placeholder="KM Awal"  />
						  	</div>
						  	<div class="form-group col-md-3">
						    	<label for="editkmAkhir">KM Akhir</label>
						    	<input type="number" class="form-control" id="editkmAkhir" name="editkmAkhir" placeholder="KM Akhir"/>
						  	</div>
						  	<div class="form-group col-md-6">
						    	<label for="editpersekot">Persekot</label>
						    	<div class="input-group">
							    	<div class="input-group-prepend">
								        <span class="input-group-text">Rp.</span>
								    </div>
							    	<input type="number" class="form-control" id="editpersekot" name="editpersekot" placeholder="Persekot"/>
						    	</div>
						  	</div>
						<?php endif ?>
					  	</div>
					  	<div class="form-group">
					  		<label for="edittujuan">Tujuan</label>
					    	<textarea class="form-control" id="edittujuan" name="edittujuan" placeholder="Lokasi Tujuan" required></textarea>
					    	<div class="invalid-feedback">Anda harus menyertakan lokasi</div>
					  	</div>
					  	<button type="submit" class="btn btn-primary">Edit</button>
					</form>
	      		</div>
	    	</div>
	  	</div>
	</div>
	<!-- Edit Modal -->

	<!-- Lihat Modal -->
	<div class="modal fade" id="lihatModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  	<div class="modal-dialog modal-dialog-centered" role="document">
	    	<div class="modal-content">
	      		<div class="modal-header bg-primary text-white">
	        		<h5 class="modal-title" id="exampleModalCenterTitle">Data Permohonan <span id="tgldata"></span></h5>
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          			<span aria-hidden="true">&times;</span>
	        		</button>
	      		</div>
	      		<div class="modal-body">
	      			<form id="lihatform">
	      				<div class="form-group">
					  		<label for="lihatnama">Nama Pemohon</label>
					    	<input type="text" class="form-control" id="lihatnama" name="lihatnama" placeholder="Nama Pemohon" readonly>
					    	<div class="invalid-feedback">Anda harus menyertakan lokasi</div>
					  	</div>
					  	<div class="form-row">
					    	<div class="form-group col-md-5">
					      		<label for="lihattanggalBerangkat">Tgl. Keberangkatan</label>
					      		<div class="input-group">
					      			<input type="text" class="form-control" id="lihattanggalBerangkat" name="lihattanggalBerangkat" placeholder="Tgl. Keberangkatan" readonly>
					      			<div class="input-group-append">
									    <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
									</div>
					      		</div>
					      		<div class="invalid-feedback">Anda harus mengisi Tanggal Keberangkatan</div>
					    	</div>
					    	<div class="form-group col-md-7">
					      		<label for="lihatnamaPengguna">Nama Pengguna</label>
					      		<input id="lihatnamaPengguna" name="lihatnamaPengguna" class="form-control" placeholder="Nama Pengguna" readonly />
					      		<div class="invalid-feedback">Anda harus mengisi Nama Pengguna</div>
					    	</div>
					  	</div>
					  	<div class="form-row">
					  		<div class="form-group col-md-4">
					  			<label for="lihatjamBerangkat">Jam Berangkat</label>
					  			<div class="input-group">
								    <input type="text" class="form-control" id="lihatjamBerangkat" name="lihatjamBerangkat" placeholder="Berangkat" readonly>
								    <div class="input-group-append">
									    <span class="input-group-text" id="basic-addon2"><i class="fa fa-clock-o"></i></span>
									</div>
					  			</div>
							    <div class="invalid-feedback">Anda harus mengisi Jam Berangkat</div>
							</div>
					  		<div class="form-group col-md-4">
					  			<label for="lihatjamKembali">Jam Kembali</label>
					  			<div class="input-group">
					  				<input type="text" class="form-control" id="lihatjamKembali" name="lihatjamKembali
								    " placeholder="Kembali" readonly>
								    <div class="input-group-append">
								        <span class="input-group-text"><span class="fa fa-clock-o"></span></span>
								    </div>
					  			</div>
							    <div class="invalid-feedback">Anda harus mengisi Jam Kembali</div>
							</div>
							<div class="form-group col-md-4">
						    	<label for="lihatnoPol">No. Polisi</label>
						    	<input type="text" class="form-control" id="lihatnoPol" name="lihatnoPol" placeholder='No. Pol' readonly />
						    	<div class="invalid-feedback">Anda harus mengisi Tujuan</div>
						  	</div>
					  	</div>
					  	<div class="form-row">
					  		<div class="form-group col-md-6">
						    	<label for="lihatsatuanKerja">Satuan Kerja</label>
						    	<input type="text" class="form-control" id="lihatsatuanKerja" name="lihatsatuanKerja" list="satuan" placeholder="Satuan Kerja" readonly />
						    	<div class="invalid-feedback">Anda harus mengisi Satuan Kerja</div>
						  	</div>
						  	<div class="form-group col-md-6">
						    	<label for="lihatpengemudi">Nama Pengemudi</label>
						    	<input type="text" class="form-control" id="lihatpengemudi" name="lihatpengemudi" placeholder="Nama Pengemudi" readonly />
						    	<div class="invalid-feedback">Anda harus mengisi Satuan Kerja</div>
						  	</div>
						  	<div class="form-group col-md-3">
						    	<label for="lihatkmAwal">KM Awal</label>
						    	<input type="number" class="form-control" id="lihatkmAwal" name="lihatkmAwal" list="satuan" placeholder="KM Awal" readonly/>
						  	</div>
						  	<div class="form-group col-md-3">
						    	<label for="lihatkmAkhir">KM Akhir</label>
						    	<input type="number" class="form-control" id="lihatkmAkhir" name="lihatkmAkhir" placeholder="KM Akhir" readonly />
						  	</div>
						  	<div class="form-group col-md-6">
						    	<label for="lihatpersekot">Persekot</label>
						    	<div class="input-group">
							    	<div class="input-group-prepend">
								        <span class="input-group-text">Rp.</span>
								    </div>
							    	<input type="number" class="form-control" id="lihatpersekot" name="lihatpersekot" placeholder="Persekot" readonly />
						    	</div>
						  	</div>
					  	</div>
					  	<div class="form-group">
					  		<label for="lihattujuan">Tujuan</label>
					    	<textarea class="form-control" id="lihattujuan" name="lihattujuan" placeholder="Lokasi Tujuan" readonly></textarea>
					    	<div class="invalid-feedback">Anda harus menyertakan lokasi</div>
					  	</div>
					</form>
	      		</div>
	    	</div>
	  	</div>
	</div>
	<!-- Lihat Modal -->
</div>
<script>

	$('.datepicker').datepicker({
	    format: 'dd/mm/yyyy',
	    startDate: '-3d',
	    todayHighlight: true,
	    language: 'id',
	    autoclose: true
	});

	$('#berangkat').clockpicker({
		autoclose: true,
	    placement: 'bottom',
	    align: 'left',
	    donetext: 'Ok'
	});

	$('#kembali').clockpicker({
		autoclose: true,
	    placement: 'bottom',
	    align: 'left',
	    donetext: 'Ok'
	});

	$('#editberangkat').clockpicker({
		autoclose: true,
	    placement: 'bottom',
	    align: 'left',
	    donetext: 'Ok'
	});

	$('#editkembali').clockpicker({
		autoclose: true,
	    placement: 'bottom',
	    align: 'left',
	    donetext: 'Ok'
	});

	function read_date(date) {
		var arrdate = date.split('-');

		var bulan = {'01': 'Januari', '02': 'Februari', '03': 'Maret','04': 'April', '05': 'Mei', '06': 'Juni','07': 'Juli', '08': 'Agustus', '09': 'September','10': 'Oktober', '11': 'November', '12': 'Desember'};

		return arrdate[2]+" "+bulan[arrdate[1]]+" "+arrdate[0];
	}

	function tindak_lanjut_permohonan(id) {
		$('#TDform')[0].reset();

        $.ajax({
            url : "<?php echo site_url('admin/data_permohonan/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
            	data[0].tanggalPermohonan

                $('[name="TDIDpermohonan"]').val(data[0].IDpermohonan);
                $('[name="TDnoPol"]').val(data[0].noPol);
                $('[name="TDpengemudi"]').val(data[0].pengemudi);
                $('[name="TDkmAwal"]').val(data[0].kmAwal);
                $('[name="TDkmAkhir"]').val(data[0].kmAkhir);
                $('[name="TDpersekot"]').val(data[0].persekot);
                $('#TDModalCenter').modal('show');

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log('failed get data');
            }
        });
	}

    function edit_permohonan(id){
        $('#editform')[0].reset();

        $.ajax({
            url : "<?php echo site_url('admin/data_permohonan/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
            	data[0].tanggalPermohonan

                $('[name="IDpermohonan"]').val(data[0].IDpermohonan);
                $('[name="edittanggalBerangkat"]').val(data[0].tanggalBerangkat);
                $('[name="editnamaPengguna"]').val(data[0].namaPengguna);
                $('[name="editsatuanKerja"]').val(data[0].satuanKerja);
                $('[name="edittujuan"]').val(data[0].tujuan);
                $('[name="editjamBerangkat"]').val(data[0].jamBerangkat);
                $('#editjamKembali').val(data[0].jamKembali);
                $('[name="editkmAwal"]').val(data[0].kmAwal);
                $('[name="editkmAkhir"]').val(data[0].kmAkhir);
                $('[name="editnoPol"]').val(data[0].noPol);
                $('[name="editpengemudi"]').val(data[0].pengemudi);
                $('#tgledit').text(read_date(data[0].tanggalPermohonan));
                $('#editModalCenter').modal('show');

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log('failed get data');
            }
        });
    }

    function lihat_permohonan(id){
        $('#lihatform')[0].reset();

        $.ajax({
            url : "<?php echo site_url('admin/data_permohonan/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="lihattanggalBerangkat"]').val(read_date(data[0].tanggalBerangkat));
                $('[name="lihatnamaPengguna"]').val(data[0].namaPengguna);
                $('[name="lihatsatuanKerja"]').val(data[0].satuanKerja);
                $('[name="lihattujuan"]').val(data[0].tujuan);
                $('#lihatjamKembali').val(data[0].jamKembali);
                $('[name="lihatjamBerangkat"]').val(data[0].jamBerangkat);
                $('[name="lihatnoPol"]').val(data[0].noPol);
                $('[name="lihatpengemudi"]').val(data[0].pengemudi);
                $('[name="lihatnama"]').val(data[0].nama);
                $('[name="lihatkmAwal"]').val(data[0].kmAwal);
                $('[name="lihatkmAkhir"]').val(data[0].kmAkhir);
                $('[name="lihatpersekot"]').val(data[0].persekot);
                $('#tgldata').text(read_date(data[0].tanggalPermohonan));
                var wow = $("#lihatpersekot").val();
                wow = parseInt(wow).toLocaleString('id');
                $("#lihatpersekot").val(wow);
                $('#lihatModalCenter').modal('show');
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log('failed get data');
            }
        });
    }

    function hapus_permohonan(id) {
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
		    	window.location = '<?php echo base_url() ?>permintaan/hapus_permohonan/'+id;
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
