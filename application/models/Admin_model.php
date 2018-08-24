<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_model extends CI_Model{

	public function get_permintaan($where=null)
	{
		if ($where == null) {
			$this->db->order_by('IDpermintaan', 'DESC');
			$this->db->join('barang', 'barang.IDbarang = permintaan_barang.IDbarang');
			$this->db->like('tanggal', date('Y'), 'after');
			$query = $this->db->get('permintaan_barang');
			return $query->result();
			
		} else {
			$this->db->order_by('IDpermintaan', 'DESC');
			$this->db->join('barang', 'barang.IDbarang = permintaan_barang.IDbarang');
			$this->db->like('tanggalpermintaan', date('Y-m'), 'after');
			$query = $this->db->get_where('permintaan_barang',$where);
			return $query->result();
		}
	}

	public function get_permintaan_data($where)
	{
		$this->db->order_by('IDpermintaan', 'DESC');
		$this->db->join('barang', 'barang.IDbarang = permintaan_barang.IDbarang');
		$this->db->like('tanggal', date('Y'), 'after');
		$query = $this->db->get_where('permintaan_barang',$where);
		return $query->row_array();
	}

	public function get_permintaan_column($select)
	{
		$this->db->distinct();
		$this->db->join('barang', 'barang.IDbarang = permintaan_barang.IDbarang');
		$this->db->select($select);
		return $this->db->get('permintaan_barang')->result();
	}

	public function get_akun_role($role=null)
	{
		if ($role == null) {
			return $this->db->get('users')->result();
		} else {
			if ($role == 'admin') {
				return $this->db->get_where('users', array('level'=>3))->result();
			} elseif($role == 'spv') {
				return $this->db->get_where('users', array('level'=>2))->result();
			} else {
				return $this->db->get_where('users', array('level'=>1))->result();
			}
		}
	}

	public function get_akun($where)
	{
		if ($where == null) {
			return $this->db->get('users')->result();
		} else {
			return $this->db->get_where('users',$where)->row_array();
		}
	}

	public function get_email_spv()
	{
		return $this->db->get_where('users',array('level'=>2))->result();
	}
}