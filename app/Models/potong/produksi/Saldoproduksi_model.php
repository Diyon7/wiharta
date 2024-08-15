<?php

namespace App\Models\potong\produksi;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Saldoproduksi_model extends Model
{
    protected $DBGroup = 'seconddb';
    protected $table      = 'potong_rcn_ri_sa';
    protected $primaryKey = 'seq';

    protected $allowedFields = ['seq', 'norcn', 'spp', 'use', 'jml', 'grup', 'tipe', 'kodeitem', 'tgl', 'sa_ri', 'jenismesin', 'vendor', 'created_at', 'updated_at', 'user'];

    protected $request;
    protected $dt;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('seconddb');
        $this->dt = $this->db->table('potong_rcn_ra');
        $this->request = $request;
    }

    public function _get_datatables_querydetailrencana($data)
    {
        $column_order = array("potong_rcn_ra.tgl", "potong_rcn_ra.tgl", "potong_rcn_ra.tgl", "potong_rcn_ra.tgl", "potong_rcn_ra.tgl",);
        $column_search = array("potong_rcn_ra.tgl", "potong_rcn_ra.tgl", "potong_rcn_ra.tgl", "potong_rcn_ra.tgl", "potong_rcn_ra.tgl",);
        $order = array('potong_mtipe_new.`kodetipe`' => 'asc');

        $this->dt->select("potong_rcn_ra.seq,potong_mtipe_new.namatipe,potong_rcn_ra.tgl,potong_rcn_ra.qty");
        $this->dt->join('potong_mtipe_new', 'potong_mtipe_new.`kodetipe`=potong_rcn_ra.`idtipe`');
        $this->dt->where('potong_rcn_ra.norcn', $data['norcn']);

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

    public function get_datatablesdetailrencana($data)
    {
        $this->_get_datatables_querydetailrencana($data);
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function count_filtereddetailrencana($data)
    {
        $this->_get_datatables_querydetailrencana($data);
        return $this->dt->countAllResults();
    }

    public function count_alldetailrencana()
    {
        return $this->select("potong_rcn_ra.qty")
            ->join('potong_mtipe_new', 'potong_mtipe_new.`kodetipe`=potong_rcn_ra.`idtipe`')
            ->countAllResults();
    }
}
