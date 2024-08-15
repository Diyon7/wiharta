<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Pegawai_Model extends Model
{
    protected $table      = 'pegawai';
    protected $primaryKey = 'pegawai_id';

    protected $allowedFields = ['pegawai_pin', 'pegawai_nip', 'pegawai_nama', 'pegawai_alias', 'pegawai_telp', 'tempat_lahir', 'tgl_lahir', 'pembagian1_id', 'pembagian2_id', 'pembagian3_id', 'pembagian4_id', 'pembagian5_id', 'pembagian6_id', 'tgl_mulai_kerja', 'tgl_resign', 'gender', 'tgl_masuk_pertama', 'golongan', 'grup', 'grup_t', 'grup_jam_kerja', 'resign', 'pegawai_id', 'user', 'validator', 'created_at', 'updated_at'];

    protected $request;
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->dt = $this->db->table('tmp');
        $this->tk = $this->db->table('pegawai_temp');
        $this->request = $request;
    }

    public function JAvendor()
    {
        return $this->select('COUNT(pegawai_nip) as jumlah, pembagian3_nama')
            ->join('pembagian3', 'pegawai.pembagian3_id=pembagian3.pembagian3_id')
            ->where('pegawai.resign', '0')
            // ->where("pegawai.`pegawai_nip` REGEXP '^[0-9]+$'")
            ->groupBy('pembagian3.pembagian3_nama')
            ->get()->getResultArray();
    }

    public function Groupt()
    {
        return $this->select('grup_t')
            ->groupBy('grup_t')
            ->get()->getResultArray();
    }

    public function Datapv($datav)
    {
        return $this->select('COUNT(pegawai.pegawai_nip) AS jumlah, pembagian4.pembagian4_nama')
            ->join('pembagian3', 'pembagian3.pembagian3_id=pegawai.pembagian3_id')
            ->join('pembagian4', 'pembagian4.pembagian4_id=pegawai.pembagian4_id')
            ->where('pembagian3.pembagian3_nama', $datav)
            ->where('pegawai.resign', '0')
            // ->where("pegawai.`pegawai_nip` REGEXP '^[0-9]+$'")
            ->groupBy('pembagian4.pembagian4_nama')
            ->get()->getResultArray();
    }
    public function Pda_Pegawai($idp)
    {
        return $this->db->query("SELECT pembagian2.`pembagian2_nama` AS namadivisi, pembagian2.`pembagian2_id` AS pembagian2id, pembagian4.`pembagian4_nama` AS namaunit, pembagian4.`pembagian4_id` AS pembagian4id, pembagian5.`pembagian5_nama` AS namasubunit, pembagian5.`pembagian5_id` AS pembagian5id FROM pda_pegawai
        JOIN pembagian2 ON pda_pegawai.`pembagian2_id`=pembagian2.`pembagian2_id`
        JOIN pembagian4 ON pda_pegawai.`pembagian4_id`=pembagian4.`pembagian4_id`
        JOIN pembagian5 ON pda_pegawai.`pembagian5_id`=pembagian5.`pembagian5_id`
        WHERE pembagian5.`pembagian5_id`='$idp'")->getRowArray();
    }
    
    public function pembagian3($dpv)
    {
        return $this->db->query("SELECT pembagian3_ket FROM pembagian3 WHERE pembagian3_nama='$dpv'")->getRowArray();
    }
    
    public function Golongan()
    {
        return $this->select('pegawai.`golongan` AS golongan')
            ->where('pegawai.resign', '0')
            ->groupBy('pegawai.golongan')
            ->get()->getResultArray();
    }

    public function Detailkaryawana($nippegaw)
    {
        return $this->select('pegawai.`pegawai_pin` AS idk, pembagian3.`pembagian3_nama` AS asal, pegawai.`pegawai_nama` AS nama, pegawai.`tgl_lahir` AS tgllahir, pegawai_d.`alamat` AS alamat, pendidikan.`pend_name` AS pendidikan, pembagian2.`pembagian2_nama` AS divisi, pembagian4.`pembagian4_nama` AS unit, pembagian5.`pembagian5_nama` AS subunit, pegawai.`grup` AS grup, pegawai.`grup_t` AS grup, pembagian1.`pembagian1_nama` AS jabatan, pegawai.`golongan` AS golongan, pegawai.`tgl_masuk_pertama` AS tmt')
            ->join('pembagian3', 'pembagian3.`pembagian3_id`=pegawai.`pembagian3_id`')
            ->join('pegawai_d', 'pegawai_d.`pegawai_pin`=pegawai.`pegawai_pin`', 'left')
            ->join('pendidikan', 'pendidikan.`pend_id`=pegawai_d.`pend_id`', 'left')
            ->join('pembagian2', 'pembagian2.`pembagian2_id`=pegawai.`pembagian2_id`')
            ->join('pembagian4', 'pembagian4.`pembagian4_id`= pegawai.`pembagian4_id`')
            ->join('pembagian5', 'pembagian5.`pembagian5_id`=pegawai.`pembagian5_id`')
            ->join('pembagian1', 'pembagian1.`pembagian1_id`=pegawai.`pembagian1_id`')
            ->where('pegawai.`pegawai_pin`', $nippegaw)
            ->get()->getResultArray();
    }

    public function Edit($nippegaw)
    {
        return $this->select('pegawai.`pegawai_pin` AS idk, pegawai.`pegawai_nip` AS nip, pembagian3.`pembagian3_nama` AS asal, pegawai.`pegawai_nama` AS nama, pegawai.`pegawai_telp` AS telepon, pegawai.`gender` AS gender, pegawai.`tgl_lahir` AS tgllahir, pembagian1.`pembagian1_id` AS pembagian1id, pembagian2.`pembagian2_id` AS pembagian2id, pembagian3.`pembagian3_id` AS pembagian3id, pembagian4.`pembagian4_id` AS pembagian4id, pembagian5.`pembagian5_id` AS pembagian5id, pembagian6.`pembagian6_id` AS pembagian6id, pegawai_d.`alamat` AS alamat, pendidikan.`pend_name` AS pendidikan, pembagian2.`pembagian2_nama` AS divisi, pembagian4.`pembagian4_nama` AS unit, pembagian5.`pembagian5_nama` AS subunit, pembagian6.`pembagian6_nama` AS kategori, pegawai.`grup` AS grup, pegawai.`grup_t` AS grupt, pegawai.`grup_jam_kerja` AS grupjk, pembagian1.`pembagian1_nama` AS jabatan, pegawai.`golongan` AS golongan, pegawai.`tgl_masuk_pertama` AS tmt')
            ->join('pembagian3', 'pembagian3.`pembagian3_id`=pegawai.`pembagian3_id`', 'left')
            ->join('pegawai_d', 'pegawai_d.`pegawai_pin`=pegawai.`pegawai_pin`', 'left')
            ->join('pendidikan', 'pendidikan.`pend_id`=pegawai_d.`pend_id`', 'left')
            ->join('pembagian2', 'pembagian2.`pembagian2_id`=pegawai.`pembagian2_id`', 'left')
            ->join('pembagian4', 'pembagian4.`pembagian4_id`= pegawai.`pembagian4_id`', 'left')
            ->join('pembagian5', 'pembagian5.`pembagian5_id`=pegawai.`pembagian5_id`', 'left')
            ->join('pembagian6', 'pembagian6.`pembagian6_id`=pegawai.`pembagian6_id`', 'left')
            ->join('pembagian1', 'pembagian1.`pembagian1_id`=pegawai.`pembagian1_id`', 'left')
            ->where('pegawai.`pegawai_nip`', $nippegaw)
            ->get()->getRowArray();
    }
    
    public function Editvi($nippegaw)
    {
        return $this->tk->select('pegawai_temp.`pegawai_pin` AS idk, pegawai_temp.`pegawai_nip` AS nip, pembagian3.`pembagian3_nama` AS asal, pegawai_temp.`pegawai_nama` AS nama, pegawai_temp.`pegawai_telp` AS telepon, pegawai_temp.`gender` AS gender, pegawai_temp.`tgl_lahir` AS tgllahir, pembagian1.`pembagian1_id` AS pembagian1id, pembagian2.`pembagian2_id` AS pembagian2id, pembagian3.`pembagian3_id` AS pembagian3id, pembagian4.`pembagian4_id` AS pembagian4id, pembagian5.`pembagian5_id` AS pembagian5id, pembagian6.`pembagian6_id` AS pembagian6id, pegawai_d.`alamat` AS alamat, pendidikan.`pend_name` AS pendidikan, pembagian2.`pembagian2_nama` AS divisi, pembagian4.`pembagian4_nama` AS unit, pembagian5.`pembagian5_nama` AS subunit, pembagian6.`pembagian6_nama` AS kategori, pegawai_temp.`grup` AS grup, pegawai_temp.`grup_t` AS grupt, pegawai_temp.`grup_jam_kerja` AS grupjk, pembagian1.`pembagian1_nama` AS jabatan, pegawai_temp.`golongan` AS golongan, pegawai_temp.`tgl_masuk_pertama` AS tmt')
            ->join('pembagian3', 'pembagian3.`pembagian3_id`=pegawai_temp.`pembagian3_id`', 'left')
            ->join('pegawai_d', 'pegawai_d.`pegawai_pin`=pegawai_temp.`pegawai_pin`', 'left')
            ->join('pendidikan', 'pendidikan.`pend_id`=pegawai_d.`pend_id`', 'left')
            ->join('pembagian2', 'pembagian2.`pembagian2_id`=pegawai_temp.`pembagian2_id`', 'left')
            ->join('pembagian4', 'pembagian4.`pembagian4_id`= pegawai_temp.`pembagian4_id`', 'left')
            ->join('pembagian5', 'pembagian5.`pembagian5_id`=pegawai_temp.`pembagian5_id`', 'left')
            ->join('pembagian6', 'pembagian6.`pembagian6_id`=pegawai_temp.`pembagian6_id`', 'left')
            ->join('pembagian1', 'pembagian1.`pembagian1_id`=pegawai_temp.`pembagian1_id`', 'left')
            ->where('pegawai_temp.`pegawai_nip`', $nippegaw)
            ->get()->getRowArray();
    }

    public function Daftarkaryawanajp3()
    {
        return $this->select('pegawai.`pegawai_nip` as idkar, pembagian3.`pembagian3_nama` as vendor, pegawai.`pegawai_nama` as nama, pembagian2.`pembagian2_nama` as bagian, pegawai.`tgl_mulai_kerja` as tmt, pegawai.`grup_t` as grup_t')
            ->join('pembagian2', 'pembagian2.`pembagian2_id`=pegawai.`pembagian2_id`')
            ->join('pembagian3', 'pembagian3.`pembagian3_id`=pegawai.`pembagian3_id`')
            ->where('pegawai.`resign`', '0')
            ->where("pegawai.`pegawai_nip` REGEXP '^[0-9]+$'")
            ->orderBy('pegawai.`pegawai_id`', 'DESC')
            ->get()->getResultArray();
    }
    
    public function Daftarkaryawan($data)
    {
        return $this->select('pegawai.`pegawai_nip` as idkar, pembagian3.`pembagian3_nama` as vendor, pegawai.`pegawai_nama` as nama, pembagian2.`pembagian2_nama` as bagian, pegawai.`tgl_mulai_kerja` as tmt, pegawai.`grup_t` as grup_t')
            ->join('pembagian2', 'pembagian2.`pembagian2_id`=pegawai.`pembagian2_id`')
            ->join('pembagian3', 'pembagian3.`pembagian3_id`=pegawai.`pembagian3_id`')
            ->where('pegawai.`resign`', '0')
            ->like('pembagian3.`pembagian3_nama`', $data)
            ->orderBy('pegawai.`pegawai_nama`', 'ASC')
            ->get()->getResultArray();
    }

    public function Daftarizin()
    {
        return $this->select('tbl_izin.pegawai_nip, tbl_izin.pegawai_nama, tbl_izin.grup, tbl_izin.tanggal, tbl_izin.`in`, tbl_izin.`out`, tbl_izin.unit, tbl_izin.izin tbl_izin.verified, tbl_izin.created_at')
            ->join('pembagian2', 'pembagian2.`pembagian2_id`=pegawai.`pembagian2_id`')
            ->join('pembagian3', 'pembagian3.`pembagian3_id`=pegawai.`pembagian3_id`')
            ->where('pegawai.`resign`', '0')
            ->where("pegawai.`pegawai_nip` REGEXP '^[0-9]+$'")
            ->orderBy('pegawai.`pegawai_id`', 'DESC')
            ->get()->getResultArray();
    }

    public function Daftarkaryawanalog()
    {
        return $this->select('pegawai.`pegawai_nip` as idkar, pembagian3.`pembagian3_nama` as vendor, pegawai.`pegawai_nama` as nama, pembagian2.`pembagian2_nama` as bagian, pegawai.`tgl_mulai_kerja` as tmt, pegawai.`grup_t` as grup_t')
            ->join('pembagian2', 'pembagian2.`pembagian2_id`=pegawai.`pembagian2_id`')
            ->join('pembagian3', 'pembagian3.`pembagian3_id`=pegawai.`pembagian3_id`')
            ->where('pegawai.`resign`', '0')
            ->where("pegawai.`pegawai_nip` REGEXP '^[0-9]+$'")
            ->orderBy('pegawai.`pegawai_id`', 'DESC')
            ->get()->getResultArray();
    }

    public function Daftarkaryawaninsjp3($idkar)
    {
        return $this->select('pegawai.`grup` AS grup, pegawai.`pegawai_nip` as idkar, pegawai.`pegawai_nama` as nama, pembagian4.`pembagian4_nama` AS unit, pembagian5.`pembagian5_nama` AS subunit')
            ->join('pembagian2', 'pembagian2.`pembagian2_id`=pegawai.`pembagian2_id`')
            ->join('pembagian3', 'pembagian3.`pembagian3_id`=pegawai.`pembagian3_id`')
            ->join('pembagian4', 'pembagian4.`pembagian4_id`= pegawai.`pembagian4_id`')
            ->join('pembagian5', 'pembagian5.`pembagian5_id`=pegawai.`pembagian5_id`')
            ->where('pegawai.`resign`', '0')
            ->where('pegawai.`pegawai_nip`', $idkar)
            ->get()->getRowArray();
    }

    public function Daftarkaryawankjp3()
    {
        return $this->select('pegawai.`pegawai_nip` as idkar, pembagian3.`pembagian3_nama` as vendor, pegawai.`pegawai_nama` as nama, pembagian2.`pembagian2_nama` as bagian, pegawai.`tgl_mulai_kerja` as tmt, pegawai.`grup_t` as grup_t')
            ->join('pembagian2', 'pembagian2.`pembagian2_id`=pegawai.`pembagian2_id`')
            ->join('pembagian3', 'pembagian3.`pembagian3_id`=pegawai.`pembagian3_id`')
            ->where('pegawai.`resign`', '1')
            ->where("pegawai.`pegawai_nip` REGEXP '^[0-9]+$'")
            ->orderBy('pegawai.`pegawai_id`', 'DESC')
            ->get()->getResultArray();
    }

    public function _get_datatables_querykaryawanajp3()
    {
        $column_order = array('pegawai.`pegawai_nip`', 'pembagian3.`pembagian3_nama`', 'pegawai.`pegawai_nama`', 'pembagian2.`pembagian2_nama`', 'pembagian4.`pembagian4_nama`', 'pegawai.`golongan`', 'pegawai.`tgl_mulai_kerja`', 'pegawai.`grup_t`');
        $column_search = array('pegawai.`pegawai_nip`', 'pembagian3.`pembagian3_nama`', 'pegawai.`pegawai_nama`', 'pembagian2.`pembagian2_nama`', 'pembagian4.`pembagian4_nama`', 'pegawai.`golongan`', 'pegawai.`tgl_mulai_kerja`', 'pegawai.`grup_t`');
        $order = array('pegawai.`pegawai_id`' => 'desc');

        $this->select('pegawai.`pegawai_nip` as idkar, pembagian3.`pembagian3_nama` as vendor, pegawai.`pegawai_nama` as nama, pembagian2.`pembagian2_nama` as bagian, pembagian4.`pembagian4_nama` as unit, pegawai.`golongan` as golongan, pegawai.`tgl_mulai_kerja` as tmt, pegawai.`grup_t` as grup_t');
        $this->join('pembagian2', 'pembagian2.`pembagian2_id`=pegawai.`pembagian2_id`', 'left');
        $this->join('pembagian4', 'pembagian4.`pembagian4_id`=pegawai.`pembagian4_id`', 'left');
        $this->join('pembagian3', 'pembagian3.`pembagian3_id`=pegawai.`pembagian3_id`', 'left');
        $this->where('pegawai.`resign`', '0');
        // $this->where("pegawai.`pegawai_nip` REGEXP '^[0-9]+$'");

        $i = 0;
        foreach ($column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->groupStart();
                    $this->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($column_search) - 1 == $i)
                    $this->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->orderBy($column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->orderBy(key($order), $order[key($order)]);
        }
    }

    public function get_datatableskaryawanajp3()
    {
        $this->_get_datatables_querykaryawanajp3();
        if ($this->request->getPost('length') != -1)
            $this->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->get();
        return $query->getResult();
    }

    public function count_filteredkaryawanajp3()
    {
        $this->_get_datatables_querykaryawanajp3();
        return $this->countAllResults();
    }

    public function count_allkaryawanajp3()
    {
        $this->select('pegawai.`pegawai_nip` as idkar, pembagian3.`pembagian3_nama` as vendor, pegawai.`pegawai_nama` as nama, pembagian2.`pembagian2_nama` as bagian, pegawai.`tgl_mulai_kerja` as tmt, pegawai.`grup_t` as grup_t');
        $this->join('pembagian2', 'pembagian2.`pembagian2_id`=pegawai.`pembagian2_id`');
        $this->join('pembagian4', 'pembagian4.`pembagian4_id`=pegawai.`pembagian4_id`');
        $this->join('pembagian3', 'pembagian3.`pembagian3_id`=pegawai.`pembagian3_id`', 'left');
        $this->where('pegawai.`resign`', '0');
        // $this->where("pegawai.`pegawai_nip` REGEXP '^[0-9]+$'");
        return $this->countAllResults();
    }
    
    public function _get_datatables_querykaryawankfjp3($kode)
    {
        $column_order = array('pin', 'pin');
        $column_search = array('pin', 'pin');
        $order = array('pin' => 'desc');

        $this->dt->select("pin,IFNULL(pegawai_temp.`pegawai_pin`,'diisi') AS pegawaipin");
        $this->dt->join("pegawai_temp","tmp.`pin`=pegawai_temp.`pegawai_pin`","left");
        $this->dt->join("pegawai","tmp.`pin`=pegawai.`pegawai_pin`","right");
        $this->dt->where("LEFT(pin,2) LIKE '$kode%'");
        $this->dt->where('pegawai.pegawai_nip IS NULL');

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
        
        $this->dt->groupBy('pin');

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    public function get_datatableskaryawankfjp3($kode)
    {
        $this->_get_datatables_querykaryawankfjp3($kode);
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function count_filteredkaryawankfjp3($kode)
    {
        $this->_get_datatables_querykaryawankfjp3($kode);
        return $this->dt->countAllResults();
    }

    public function count_allkaryawankfjp3($kode)
    {
        $this->dt->select("pin,IFNULL(pegawai_pin,'diisi') AS pegawaipin");
        $this->dt->join("pegawai_temp","tmp.`pin`=pegawai_temp.`pegawai_pin`","left");
        $this->dt->where("LEFT(pin,1) LIKE '$kode'");
        $this->dt->where('pin NOT IN (SELECT pegawai_pin FROM pegawai)');
        return $this->dt->countAllResults();
    }
    
    public function _get_datatables_querykaryawanvk()
    {
        $column_order = array('pegawai_pin', 'pegawai_pin', 'pegawai_pin');
        $column_search = array('pegawai_pin', 'pegawai_pin', 'pegawai_pin');
        $order = array('pegawai_pin' => 'desc');

        $this->tk->select("pegawai_pin AS pin, user AS user");

        $i = 0;
        foreach ($column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->tk->groupStart();
                    $this->tk->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->tk->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($column_search) - 1 == $i)
                    $this->tk->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->tk->orderBy($column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->tk->orderBy(key($order), $order[key($order)]);
        }
    }

    public function get_datatableskaryawanvk()
    {
        $this->_get_datatables_querykaryawanvk();
        if ($this->request->getPost('length') != -1)
            $this->tk->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->tk->get();
        return $query->getResult();
    }

    public function count_filteredkaryawanvk()
    {
        $this->_get_datatables_querykaryawanvk();
        return $this->tk->countAllResults();
    }

    public function count_allkaryawanvk()
    {
        $this->tk->select("pegawai_pin AS pin");
        return $this->tk->countAllResults();
    }
    
    public function _get_datatables_querykaryawankjp3()
    {
        $column_order = array('pegawai.`pegawai_nip`', 'pembagian3.`pembagian3_nama`', 'pegawai.`pegawai_nama`', 'pembagian2.`pembagian2_nama`', 'pembagian4.`pembagian4_nama`', 'pembagian5.`pembagian5_nama`', 'pegawai.`tgl_mulai_kerja`', 'pegawai.`tgl_resign`');
        $column_search = array('pegawai.`pegawai_nip`', 'pembagian3.`pembagian3_nama`', 'pegawai.`pegawai_nama`', 'pembagian2.`pembagian2_nama`', 'pembagian4.`pembagian4_nama`', 'pembagian5.`pembagian5_nama`', 'pegawai.`tgl_mulai_kerja`', 'pegawai.`tgl_resign`');
        $order = array('pegawai.`tgl_resign' => 'desc');

        $this->select('pegawai.`pegawai_nip` as idkar, pembagian3.`pembagian3_nama` as vendor, pegawai.`pegawai_nama` as nama, pembagian2.`pembagian2_nama` as bagian, pembagian4.`pembagian4_nama` as unit, pembagian5.`pembagian5_nama` AS subunit,  pegawai.`tgl_mulai_kerja` as tmt, pegawai.`tgl_resign` AS tgl_resign');
        $this->join('pembagian2', 'pembagian2.`pembagian2_id`=pegawai.`pembagian2_id`', 'left');
        $this->join('pembagian4', 'pembagian4.`pembagian4_id`=pegawai.`pembagian4_id`');
        $this->join('pembagian5', 'pembagian5.`pembagian5_id`=pegawai.`pembagian5_id`');
        $this->join('pembagian3', 'pembagian3.`pembagian3_id`=pegawai.`pembagian3_id`', 'left');
        $this->where('pegawai.`resign`', '1');
        // $this->where("pegawai.`pegawai_nip` REGEXP '^[0-9]+$'");
        $i = 0;
        foreach ($column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->groupStart();
                    $this->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($column_search) - 1 == $i)
                    $this->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->orderBy($column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->orderBy(key($order), $order[key($order)]);
        }
    }

    public function get_datatableskaryawankjp3()
    {
        $this->_get_datatables_querykaryawankjp3();
        if ($this->request->getPost('length') != -1)
            $this->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->get();
        return $query->getResult();
    }

    public function count_filteredkaryawankjp3()
    {
        $this->_get_datatables_querykaryawankjp3();
        return $this->countAllResults();
    }

    public function count_allkaryawankjp3()
    {
        $this->select('pegawai.`pegawai_nip` as idkar, pembagian3.`pembagian3_nama` as vendor, pegawai.`pegawai_nama` as nama, pembagian2.`pembagian2_nama` as bagian, pegawai.`tgl_mulai_kerja` as tmt, pegawai.`grup_t` as grup_t');
        $this->join('pembagian2', 'pembagian2.`pembagian2_id`=pegawai.`pembagian2_id`');
        $this->join('pembagian4', 'pembagian4.`pembagian4_id`=pegawai.`pembagian4_id`');
        $this->join('pembagian3', 'pembagian3.`pembagian3_id`=pegawai.`pembagian3_id`');
        $this->where('pegawai.`resign`', '1');
        // $this->where("pegawai.`pegawai_nip` REGEXP '^[0-9]+$'");
        return $this->countAllResults();
    }
}