<?php

namespace App\Models\potong\item;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Tipedtl_model extends Model
{
    protected $DBGroup = 'seconddb';
    protected $table      = 'potong_mtipe_dtl_new';
    protected $primaryKey = 'seq';

    protected $allowedFields = ['seq', 'kodetipe', 'namatipe', 'kodeitem', 'namaitem', 'jml', 'no_rak'];

    protected $request;
    protected $dt;
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('seconddb');
        $this->dt = $this->db->table('potong_mtipe_dtl_new');
        $this->request = $request;
    }

    public function Addtipedtl($data)
    {
        return $this->dt->insert([
            'kodetipe' => $data['kodetipe'],
            'namatipe' => $data['namatipe'],
            'kodeitem' => $data['kodeitem'],
            'namaitem' => $data['namaitem'],
            'jml' => $data['jml']
        ]);
        // return $this->db->query("INSERT INTO beacukai_saldoawal_penerimaan_bj(kode_item, qty_awal, netto_awal, tgl, aju, iduser, created_at) VALUES('" . $data['kode_item'] . "','" . $data['qty_awal'] . "','" . $data['netto_awal'] . "','" . $data['tgl'] . "','" . $data['aju'] . "','" . $data['iduser'] . "','" . $data['created_at'] . "')")
        //     ->getResult();
    }

    public function Updadata($data)
    {
        return $this->query("update potong_mtipe_dtl_new set kodeitem='" . $data['kodeitem'] . "',namaitem='" . $data['namaitem'] . "',jml='" . $data['use'] . "' where seq='" . $data['seque'] . "'");
    }

    public function Updadatari($data)
    {
        return $this->query("update potong_rcn join potong_rcn_ri on potong_rcn_ri.`norcn`=potong_rcn.`norcn` set potong_rcn_ri.`iditem`='" . $data['item'] . "' where potong_rcn.`idtipe`='" . $data['tipe'] . "' and potong_rcn_ri.`iditem`='" . $data['kodetipeitem'] . "' and potong_rcn.`tgl`>='2024-07-01'");
    }

    public function _get_datatables_querytipeitem($data)
    {
        $column_order = array("potong_mitem_new.`kodeitem`", 'potong_mtipe_new.`namatipe`', 'potong_mitem_new.`namaitem`', 'potong_mtipe_dtl_new.jml', 'potong_mtipe_new.`kodetipe`');
        $column_search = array("potong_mitem_new.`kodeitem`", 'potong_mtipe_new.`namatipe`', 'potong_mitem_new.`namaitem`', 'potong_mtipe_dtl_new.jml', 'potong_mtipe_new.`kodetipe`');
        $order = array('potong_mtipe_new.`kodetipe`' => 'asc');

        $this->dt->select("potong_mtipe_dtl_new.`seq`,potong_mitem_new.`kodeitem`,potong_mitem_new.`namaitem`,potong_mtipe_new.`kodetipe`,potong_mtipe_new.`namatipe`,potong_mtipe_dtl_new.jml");
        $this->dt->join('potong_mtipe_new', 'potong_mtipe_new.`kodetipe`=potong_mtipe_dtl_new.`kodetipe`');
        $this->dt->join('potong_mitem_new', 'potong_mitem_new.`kodeitem`=potong_mtipe_dtl_new.`kodeitem`');
        // if ($data['kodetipe'] != '') {
        //     $this->dt->like('potong_mtipe_new.`kodetipe`', $data['kodetipe']);
        // }

        $i = 0;
        foreach ($column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    public function get_datatablestipeitem($data)
    {
        $this->_get_datatables_querytipeitem($data);
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function count_filteredtipeitem($data)
    {
        $this->_get_datatables_querytipeitem($data);
        return $this->dt->countAllResults();
    }

    public function count_alltipeitem()
    {
        return $this->select("kodetipe")
            ->countAllResults();
    }
}