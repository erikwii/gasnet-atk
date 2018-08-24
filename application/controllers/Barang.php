<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('home_model');
		$this->load->model('admin_model');
	}

	public function index()
	{
		$this->auth();

		$data = array(
            'title'=> 'Gasnet ATK! - Data ATK',
            'nav' => 'nav.php',
            'isi' => 'pages/data_barang',
            'barang' => $this->home_model->get_barang(),
            'nav_active' => 'barang'
        );
        $this->load->view('layout/wrapper',$data);
	}

	public function data($id)
	{
		$data = $this->home_model->get_barang_where(array('IDbarang' => $id));
		echo json_encode($data);
	}

	public function tambah()
	{
		$this->auth();

		$namaBarang = $this->input->post('namaBarang');
		$tipeBarang = $this->input->post('tipeBarang');
		$jumlahBarang = $this->input->post('jumlahBarang');

		$data = array(
			'namaBarang' => $namaBarang,
			'tipeBarang' => $tipeBarang,
			'jumlahBarang'	=> $jumlahBarang
		);
		$this->db->insert('barang',$data);

		$_SESSION['success'] = ['Berhasil!','Barang '.$namaBarang.' berhasil ditambahkan :)'];
		redirect(base_url()."barang");
	}

	public function edit()
	{
		$this->auth();

		$IDbarang = $this->input->post('editIDbarang');
		$namaBarang = $this->input->post('editnamaBarang');
		$tipeBarang = $this->input->post('edittipeBarang');
		$jumlahBarang = $this->input->post('editjumlahBarang');

		$data = array(
			'namaBarang' => $namaBarang,
			'tipeBarang' => $tipeBarang,
			'jumlahBarang'	=> $jumlahBarang
		);
		$this->db->set($data);
		$this->db->where('IDbarang', $IDbarang);
		$this->db->update('barang');

		$_SESSION['success'] = ['Berhasil!',$namaBarang.' berhasil diupdate :)'];
		redirect(base_url()."barang");
	}

	public function hapus($id)
	{
		$this->auth();

		$barang = $this->home_model->get_barang_where(array('IDbarang' => $id));
		$this->db->delete('barang', array('IDbarang' => $id));

		$_SESSION['success'] = ['Berhasil!','Anda berhasil menghapus '.$barang['namaBarang']];
		redirect(base_url()."barang");
	}

	public function auth()
	{
		if (!isset($_SESSION['atk_email'])) {
			$_SESSION['login_error'] = 'Anda belum melakukan login ke halaman Admin';
			redirect(base_url());
		}
	}
}