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

	public function akun()
	{
		$data = array(
            'title'=> 'GasnetGo! - Pengaturan akun',
            'nav' => 'nav.php',
            'isi' => 'pages/data_akun',
            'admin' => $this->admin_model->get_akun_role('admin'),
            'supervisor' => $this->admin_model->get_akun_role('spv'),
            'user' => $this->admin_model->get_akun_role('user'),
            'nav_active' => 'akun'
        );
        $this->load->view('layout/wrapper',$data);
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

	public function hapus_akun($email)
	{
		$this->auth();

		$this->db->delete('users', array('email' => $email));

		$_SESSION['success'] = ['Berhasil!','Anda berhasil menghapus Akun '.$email];
		redirect(base_url()."admin/akun/");
	}

	public function data_permohonan($IDpermohonan)
	{
		$data = $this->admin_model->get_permohonan(array('IDpermohonan' => $IDpermohonan));
		echo json_encode($data);
	}

	public function tambah_permohonan()
	{
		$this->auth();

		$tanggalBerangkat = $this->input->post('tanggalBerangkat');
		$namaPengguna = $this->input->post('namaPengguna');
		$satuanKerja = $this->input->post('satuanKerja');
		$tujuan = $this->input->post('tujuan');
		$jamBerangkat = $this->input->post('jamBerangkat');
		$jamKembali = $this->input->post('jamKembali');
		$noPol = $this->input->post('noPol');
		$pengemudi = $this->input->post('pengemudi');
		$tanggalPermohonan = date('d-m-Y');
		$email = $_SESSION['atk_email'];
		
		$data = array(
			'tanggalBerangkat' => $tanggalBerangkat,
			'namaPengguna' => $namaPengguna,
			'satuanKerja' => $satuanKerja,
			'tujuan' => $tujuan,
			'jamBerangkat' => $jamBerangkat,
			'jamKembali' => $jamKembali,
			'noPol' => $noPol,
			'pengemudi' => $pengemudi,
			'tanggalPermohonan' => $tanggalPermohonan,
			'email' => $email
		);
		$this->db->insert('permohonan_kendaraan',$data);

		$_SESSION['success'] = ['Berhasil!','Permohonan kendaraan berhasil ditambahkan :)'];
		redirect(base_url().'/home/inventaris');
	}

	public function tindak_lanjut_permohonan()
	{
		$this->auth();

		$IDpermohonan = $this->input->post('TDIDpermohonan');
		$noPol = $this->input->post('TDnoPol');
		$pengemudi = $this->input->post('TDpengemudi');
		$kmAwal = $this->input->post('TDkmAwal');
		$kmAkhir = $this->input->post('TDkmAkhir');
		$persekot = $this->input->post('TDpersekot');
		
		$data = array(
			'kmAwal' => $kmAwal,
			'kmAkhir' => $kmAkhir,
			'noPol' => $noPol,
			'persekot' => $persekot,
			'pengemudi' => $pengemudi,
		);

		$this->db->set($data);
		$this->db->where('IDpermohonan',$IDpermohonan);
		$this->db->update('permohonan_kendaraan');

        $_SESSION['success'] = ['Berhasil!','Permohonan berhasil ditindaklanjuti. Kini Anda dapat mencetak form permohonan'];
		redirect(base_url().'admin/');
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
		$kmAwal = $this->input->post('editkmAwal');
		$kmAkhir = $this->input->post('editkmAkhir');
		$persekot = $this->input->post('editpersekot');
		$noPol = $this->input->post('editnoPol');
		$pengemudi = $this->input->post('editpengemudi');
		
		$data = array(
			'tanggalBerangkat' => $tanggalBerangkat,
			'namaPengguna' => $namaPengguna,
			'satuanKerja' => $satuanKerja,
			'tujuan' => $tujuan,
			'jamBerangkat' => $jamBerangkat,
			'jamKembali' => $jamKembali,
			'kmAwal' => $kmAwal,
			'kmAkhir' => $kmAkhir,
			'persekot' => $persekot,
			'noPol' => $noPol,
			'pengemudi' => $pengemudi,
		);
		$this->db->set($data);
		$this->db->where('IDpermohonan',$IDpermohonan);
		$this->db->update('permohonan_kendaraan');

        $_SESSION['success'] = ['Berhasil!','Permohonan berhasil diupdate.'];
		redirect(base_url().'admin/');
	}

	public function hapus_permohonan($id)
	{	
		$this->auth();

		$this->db->delete('permohonan_kendaraan', array('IDpermohonan' => $id));

		$_SESSION['success'] = ['Berhasil!', 'Anda berhasil menghapus data permohonan!'];
		redirect(base_url()."admin/");
	}

	public function auth()
	{
		if (!isset($_SESSION['atk_email'])) {
			$_SESSION['login_error'] = 'Anda belum melakukan login ke halaman Admin'.$_SESSION['atk_level'];
			redirect(base_url());
		}
	}

	public function setuju($id)
	{
		$this->auth();

		$data = array(
			'approval' => 'Disetujui Pusat'
		);
		$this->db->set($data);
		$this->db->where('IDpermohonan',$id);
		$this->db->update('permohonan_kendaraan');

		$permohonan = $this->admin_model->get_permohonan_data(array('IDpermohonan'=>$id));
		$config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => 'gasnet.dummy@gmail.com',
            'smtp_pass' => 'passwordgasnet',
            'mailtype'  => 'html', 
            'charset'   => 'iso-8859-1'
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");

        $this->email->from('gasnet.dummy@gmail.com', 'Gasnet-doNotReply');
        $this->email->to('eriksantiago.science@gmail.com');

        $content = array(
        	'title' => 'Permohonan Kendaraan Operasional',
        	'preheader' => 'Persetujuan Permohonan Kendaraan Operasional.',
        	'main' => 'Selamat, permohonan Anda <b>disetujui</b> oleh Admin! Silahkan gunakan kendaraan operasional dengan baik dan hati-hati di jalan.',
        	'nama' => $permohonan['nama']
        );
        $msg = $this->load->view('pages/email_approval',$content,true);
        $this->email->subject('[GasnetGo] Persetujuan dari Admin');
        $this->email->message($msg);

        if ($this->email->send()) {
            $_SESSION['success'] = ['Berhasil!','Permohonan berhasil disetujui.'];
        }else{
            $_SESSION['error'] = 'gagal Mengirim email';
        }
		redirect(base_url()."admin/");
	}

	public function batal_setuju($id)
	{
		$this->auth();

		$data = array(
			'approval' => 'Disetujui Supervisor'
		);
		$this->db->set($data);
		$this->db->where('IDpermohonan',$id);
		$this->db->update('permohonan_kendaraan');
		redirect(base_url()."admin/");
	}

	public function tidak_setuju($id)
	{
		$this->auth();

		$data = array(
			'approval' => 'Tidak disetujui Pusat'
		);
		$this->db->set($data);
		$this->db->where('IDpermohonan',$id);
		$this->db->update('permohonan_kendaraan');
		redirect(base_url().'admin/');
	}
}