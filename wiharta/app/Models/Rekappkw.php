<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;
use DateTime;

class Rekappkw extends Model
{
    protected $DBGroup = 'seconddb';

    protected $table      = 'pegawai';
    protected $primaryKey = 'pegawai_id';

    protected $allowedFields = ['pegawai_pin', 'pegawai_nip', 'pegawai_id', 'pegawai_nama', 'tgl_lahir', 'tgl_mulai_kerja', 'tgl_masuk_pertama', 'golongan', 'grup', 'grup_t', 'resign'];

    protected $request;

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('seconddb');
        $this->request = $request;
    }

    public function Alllaporan($vendor)
    {
        return $this->select('pegawai.`pegawai_nama` AS nama, pegawai.`pegawai_nip` AS idkar, pegawai.`golongan` AS golongan, pembagian2.`pembagian2_nama` AS divisi, pembagian4.`pembagian4_nama` AS unit, pembagian5.`pembagian5_nama` AS subunit, pegawai.`grup_t` AS grupt, pembagian3.`pembagian3_nama` AS asal, pegawai.`golongan` AS golongan, pegawai.`tgl_mulai_kerja` AS tmt, pegawai.`grup` AS grup')
            ->join('pembagian2', 'pembagian2.`pembagian2_id`=pegawai.`pembagian2_id`')
            ->join('pembagian4', 'pembagian4.`pembagian4_id`=pegawai.`pembagian4_id`')
            ->join('pembagian5', 'pembagian5.`pembagian5_id`=pegawai.`pembagian5_id`')
            ->join('pembagian3', 'pembagian3.`pembagian3_id`=pegawai.`pembagian3_id`')
            ->where('pegawai.`resign`', '0')
            ->like('pembagian3.`pembagian3_nama`', $vendor)
            ->get()->getResultArray();
    }

    public function Dataabsen($form)
    {
        $alldata = 0;
        return $alldata;
    }

    public function Rekapabsen()
    {
        $dbrekap = $this->db->query("SELECT karyawan.`kode_sub_unit`,COUNT(karyawan.`kode_sub_unit`),sh1,sh2,sh3,sh0 FROM karyawan 
        LEFT JOIN tb_jadwal1 ON tb_jadwal1.grup=karyawan.`KODE_GROUP_KERJA`
        LEFT JOIN(SELECT kode_sub_unit,COUNT(kode_sub_unit) AS sh1 FROM karyawan 
        LEFT JOIN tb_jadwal1 ON tb_jadwal1.grup=karyawan.`KODE_GROUP_KERJA`
        WHERE resign=0 AND shift=1 AND tgl BETWEEN '2020-11-26' AND '2020-12-25' GROUP BY kode_sub_unit) AS s1 ON s1.kode_sub_unit=karyawan.`kode_sub_unit`
        LEFT JOIN(SELECT kode_sub_unit,COUNT(kode_sub_unit) AS sh2 FROM karyawan 
        LEFT JOIN tb_jadwal1 ON tb_jadwal1.grup=karyawan.`KODE_GROUP_KERJA`
        WHERE resign=0 AND shift=2 AND tgl BETWEEN '2020-11-26' AND '2020-12-25' GROUP BY kode_sub_unit) AS s2 ON s2.kode_sub_unit=karyawan.`kode_sub_unit`
        LEFT JOIN(SELECT kode_sub_unit,COUNT(kode_sub_unit) AS sh3 FROM karyawan 
        LEFT JOIN tb_jadwal1 ON tb_jadwal1.grup=karyawan.`KODE_GROUP_KERJA`
        WHERE resign=0 AND shift=3 AND tgl BETWEEN '2020-11-26' AND '2020-12-25' GROUP BY kode_sub_unit) AS s3 ON s3.kode_sub_unit=karyawan.`kode_sub_unit`
        LEFT JOIN(SELECT kode_sub_unit,COUNT(kode_sub_unit) AS sh0 FROM karyawan 
        LEFT JOIN tb_jadwal1 ON tb_jadwal1.grup=karyawan.`KODE_GROUP_KERJA`
        WHERE resign=0 AND shift=0 AND tgl BETWEEN '2020-11-26' AND '2020-12-25' GROUP BY kode_sub_unit) AS s0 ON s0.kode_sub_unit=karyawan.`kode_sub_unit`
        WHERE resign=0  AND tgl BETWEEN '2020-11-26' AND '2020-12-25' GROUP BY karyawan.`kode_sub_unit`")

    }
}