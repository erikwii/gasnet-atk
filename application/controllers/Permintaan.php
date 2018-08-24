<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permintaan extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('home_model');
		$this->load->model('admin_model');
	}

	public function index()
	{
		$this->auth();

		$data = array(
            'title'=> 'Gasnet ATK - Permintaan ATK',
            'nav' => 'nav.php',
            'isi' => 'pages/permintaan',
            'nav_active' => 'permintaan'
        );
        $this->load->view('layout/wrapper',$data);
	}

	public function data()
	{
		$this->auth();

		$data = array(
            'title'=> 'GasnetGo! - Permohonan Kendaraan Operasional',
            'nav' => 'nav.php',
            'isi' => 'pages/data_permintaan',
            'permintaan' => $this->admin_model->get_permintaan(),
            'nav_active' => 'data'
        );
        $this->load->view('layout/wrapper',$data);
	}

	public function data_permintaan($id)
	{
		$data = $this->admin_model->get_permintaan_data(array('IDpermintaan' => $id));
		echo json_encode($data);
	}

	public function tambah()
	{
		$this->auth();

		$namaKaryawan = $this->input->post('namaKaryawan');
		$IDbarang = $this->input->post('IDbarang');
		$jumlah = $this->input->post('jumlah');

		// Update jumlah barang
		$barang = $this->home_model->get_barang_where(array('IDbarang'=>$IDbarang));
		$update = array(
			'jumlahBarang' => ($barang['jumlahBarang'] - $jumlah)
		);
		$this->db->set($update);
		$this->db->where('IDbarang',$IDbarang);
		$this->db->update('barang');

		$data = array(
			'namaKaryawan' => $namaKaryawan,
			'IDbarang' => $IDbarang,
			'jumlah' => $jumlah,
			'tanggal' => date('Y-m-d')
		);
		$this->db->insert('permintaan_barang',$data);

        $_SESSION['success'] = ['Berhasil!','Data permintaan barang berhasil direkam. :)'];
        
		redirect(base_url().'permintaan/data/');
	}

	public function edit()
	{
		$this->auth();

		$IDpermintaan = $this->input->post('IDpermintaan');
		$namaKaryawan = $this->input->post('namaKaryawan');
		$IDbarang = $this->input->post('IDbarang');
		$jumlahBaru = $this->input->post('jumlah');

		// Update jumlah barang
		$permintaan = $this->admin_model->get_permintaan_data(array('IDpermintaan'=>$IDpermintaan));
		$baranglama = $this->home_model->get_barang_where(array('IDbarang'=>$permintaan['IDbarang']));

		// Check jika barang yg diminta sebelumnya sama dengan barang yg diminta pada pengeditan
		if ($permintaan['IDbarang'] == $IDbarang)
		{
			$jumlahBarang = $baranglama['jumlahBarang'] + $permintaan['jumlah'] - $jumlahBaru;

			// Update barang yang dipilih sebelum pengeditan
			$update = array(
				'jumlahBarang' => $jumlahBarang
			);
			$this->db->set($update);
			$this->db->where('IDbarang',$permintaan['IDbarang']);
			$this->db->update('barang');
		}
		else
		{
			$jumlahBarang = $baranglama['jumlahBarang'] + $permintaan['jumlah'];

			// Update barang yg dipilih sebelum pengeditan
			$update = array(
				'jumlahBarang' => $jumlahBarang
			);
			$this->db->set($update);
			$this->db->where('IDbarang',$permintaan['IDbarang']);
			$this->db->update('barang');

			// Update jumlah barang yg dipilih saat pengeditan
			$barangbaru = $this->home_model->get_barang_where(array('IDbarang'=>$IDbarang));
			$update = array(
				'jumlahBarang' => ($barangbaru['jumlahBarang'] - $jumlahBaru)
			);
			$this->db->set($update);
			$this->db->where('IDbarang',$IDbarang);
			$this->db->update('barang');
		}

		$data = array(
			'namaKaryawan' => $namaKaryawan,
			'IDbarang' => $IDbarang,
			'jumlah' => $jumlahBaru
		);
		$this->db->set($data);
		$this->db->where('IDpermintaan',$IDpermintaan);
		$this->db->update('permintaan_barang');

		$_SESSION['success'] = ['Berhasil!','Permintaan ATK berhasil diupdate!'];
		redirect(base_url().'permintaan/data/');
	}

	public function hapus($id)
	{	
		$this->auth();

		$this->db->delete('permintaan_barang', array('IDpermintaan' => $id));

		$_SESSION['success'] = ['Berhasil Dihapus!','Anda berhasil menghapus data permintaan!'];
		redirect(base_url()."permintaan/data");
	}

	public function batal($id)
	{
		$this->auth();

		$barang = $this->admin_model->get_permintaan_data(array('IDpermintaan'=>$id));
		$jumlah = $barang['jumlah'];
		$IDbarang = $barang['IDbarang'];

		// Update jumlah barang
		$barang = $this->home_model->get_barang_where(array('IDbarang'=>$IDbarang));
		$update = array(
			'jumlahBarang' => ($barang['jumlahBarang'] + $jumlah)
		);
		$this->db->set($update);
		$this->db->where('IDbarang',$IDbarang);
		$this->db->update('barang');

		// hapus data permintaan
		$this->db->delete('permintaan_barang', array('IDpermintaan' => $id));

		$_SESSION['success'] = ['Berhasil Dibatalkan!','Anda berhasil membatalkan permintaan ATK!'];
		redirect(base_url()."permintaan/data");
	}

	public function auth()
	{
		if (!isset($_SESSION['atk_email'])) {
			$_SESSION['login_error'] = 'Anda belum melakukan login ke halaman Admin';
			redirect(base_url());
		}
	}
}
