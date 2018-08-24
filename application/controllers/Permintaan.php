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

	public function tambah()
	{
		$this->auth();

		$namaKaryawan = $this->input->post('namaKaryawan');
		$IDbarang = $this->input->post('IDbarang');
		$jumlah = $this->input->post('jumlah');
		
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

	public function edit_permohonan()
	{
		$this->auth();

		$IDpermohonan = $this->input->post('IDpermohonan');
		$tanggalBerangkat = $this->input->post('edittanggalBerangkat');
		$namaPengguna = $this->input->post('editnamaPengguna');
		$satuanKerja = $this->input->post('editsatuanKerja');
		$tujuan = $this->input->post('edittujuan');
		$jamBerangkat = $this->input->post('editjamBerangkat');
		$jamKembali = $this->input->post('editjamKembali');
		$noPol = $this->input->post('editnoPol');
		$pengemudi = $this->input->post('editpengemudi');
		
		$data = array(
			'tanggalBerangkat' => $tanggalBerangkat,
			'namaPengguna' => $namaPengguna,
			'satuanKerja' => $satuanKerja,
			'tujuan' => $tujuan,
			'jamBerangkat' => $jamBerangkat,
			'jamKembali' => $jamKembali,
			'noPol' => $noPol,
			'pengemudi' => $pengemudi
		);
		$this->db->set($data);
		$this->db->where('IDpermohonan',$IDpermohonan);
		$this->db->update('permohonan_kendaraan');

		$_SESSION['success'] = ['Berhasil!','Permohonan kendaraan berhasil diupdate!'];
		redirect(base_url().'permohonan/data/');
	}

	public function hapus_permohonan($id)
	{	
		$this->auth();

		if (!isset($_SESSION['atk_email']) || !isset($_SESSION['go_password'])) {
			$_SESSION['login_error'] = 'Anda belum melakukan login';
			redirect(base_url());
		}

		$this->db->delete('permohonan_kendaraan', array('IDpermohonan' => $id));

		$_SESSION['success'] = ['Berhasil Dihapus!','Anda berhasil menghapus data permohonan!'];
		redirect(base_url()."permohonan/data");
	}

	public function cetakform($id)
	{	
		$this->auth();
		
		$permohonan = $this->admin_model->get_permohonan_data(array('IDpermohonan'=>$id));

		if ($permohonan['approval'] == 'Belum ada persetujuan') {
			redirect(base_url()."permohonan/data");
		}

		$data = array(
            'title'=> 'GasnetGo! - Permohonan Kendaraan Operasional',
            'nav' => 'nav.php',
            'isi' => 'pages/cetak_form',
            'nav_active' => 'permohonan',
            'permohonan' => $permohonan
        );
        $this->load->view('pages/cetak_form',$data);
	}

	public function auth()
	{
		if (!isset($_SESSION['atk_email'])) {
			$_SESSION['login_error'] = 'Anda belum melakukan login ke halaman Admin'.$_SESSION['atk_level'];
			redirect(base_url());
		}
	}
}
