<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class ModelPengembalianDetPagination extends Model
{
    protected $table = "pengembalian";
    protected $column_order = array(null, 'pgmnomor', 'pgmtanggal', 'pgmoleh', null);
    protected $column_search = array('pgmnomor', 'pgmtanggal', 'pgmoleh', 'brgnama', 'ktp_nama');
    protected $order = array('pgmnomor' => 'ASC');
    protected $request;
    protected $db;
    protected $dt;

    function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }
    private function _get_datatables_query($tglawal, $tglakhir)
    {
        if ($tglawal == '' && $tglakhir == '') {
            $this->dt = $this->db->table($this->table)->join('detail_pengembalian', 'pgmnomor=detpgmnomor', 'left')->join('barang', 'detpgmbrgkode=brgkode', 'left')->join('subkategori', 'brgsubkatid=subkatid', 'left')->join('biodata_ktp', 'pgmoleh=ktp_nomor', 'left');
        } else {
            $this->dt = $this->db->table($this->table)->join('detail_pengembalian', 'pgmnomor=detpgmnomor', 'left')->join('barang', 'detpgmbrgkode=brgkode', 'left')->join('subkategori', 'brgsubkatid=subkatid', 'left')->join('biodata_ktp', 'pgmoleh=ktp_nomor', 'left')->where('pgmtanggal >=', $tglawal)->where('pgmtanggal <=', $tglakhir);
        }
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }
    function get_datatables($tglawal, $tglakhir)
    {
        $this->_get_datatables_query($tglawal, $tglakhir);
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered($tglawal, $tglakhir)
    {
        $this->_get_datatables_query($tglawal, $tglakhir);
        return $this->dt->countAllResults();
    }
    public function count_all($tglawal, $tglakhir)
    {
        if ($tglawal == '' && $tglakhir == '') {
            $tbl_storage = $this->db->table($this->table)->join('detail_pengembalian', 'pgmnomor=detpgmnomor', 'left')->join('barang', 'detpgmbrgkode=brgkode', 'left')->join('subkategori', 'brgsubkatid=subkatid', 'left')->join('biodata_ktp', 'pgmoleh=ktp_nomor', 'left');
        } else {
            $tbl_storage = $this->db->table($this->table)->join('detail_pengembalian', 'pgmnomor=detpgmnomor', 'left')->join('barang', 'detpgmbrgkode=brgkode', 'left')->join('subkategori', 'brgsubkatid=subkatid', 'left')->join('biodata_ktp', 'pgmoleh=ktp_nomor', 'left')->where('pgmtanggal >=', $tglawal)->where('pgmtanggal <=', $tglakhir);
        }

        return $tbl_storage->countAllResults();
    }
}