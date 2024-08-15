<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Jadwalkerja_model extends Model
{
    protected $table      = 'jdw_kerja_m';
    protected $primaryKey = 'jdw_kerja_m_id';

    protected $allowedFields = ['jdw_kerja_m_kode', 'jdw_kerja_m_name', 'jdw_kerja_m_keterangan', 'jdw_kerja_m_periode', 'jdw_kerja_m_mulai', 'jdw_kerja_m_type', 'use_sama'];

    protected $useTimestamps = false;

    protected $skipValidation     = false;

    public function Jadwalkerjanormal()
    {
        return $this->select('jdw_kerja_m.`jdw_kerja_m_kode` AS kodejk, jdw_kerja_d.`jdw_kerja_d_idx` AS idx, jdw_kerja_m.`jdw_kerja_m_periode` AS p, jdw_kerja_m.`jdw_kerja_m_mulai` AS tglta, jdw_kerja_d.`jdw_kerja_d_libur` AS libur, jam_kerja.`jk_bcin` AS smasuk, jam_kerja.`jk_durtime` AS durasi, jam_kerja.`jk_ecout` AS skeluar')
            ->join('jdw_kerja_d', 'jdw_kerja_m.`jdw_kerja_m_id`=jdw_kerja_d.`jdw_kerja_m_id`')
            ->join('jam_kerja', 'jam_kerja.`jk_id` = jdw_kerja_d.`jk_id`', 'left')
            ->get()->getResultArray();
    }
    public function Jumlahkerjanormal()
    {
        return $this->select('jdw_kerja_m.`jdw_kerja_m_kode` AS kodejk, jdw_kerja_d.`jdw_kerja_d_idx` AS idx, jdw_kerja_m.`jdw_kerja_m_periode` AS p, jdw_kerja_m.`jdw_kerja_m_mulai` AS tglta, jdw_kerja_d.`jdw_kerja_d_libur` AS libur, jam_kerja.`jk_bcin` AS smasuk, jam_kerja.`jk_durtime` AS durasi, jam_kerja.`jk_ecout` AS skeluar')
            ->join('jdw_kerja_d', 'jdw_kerja_m.`jdw_kerja_m_id`=jdw_kerja_d.`jdw_kerja_m_id`')
            ->join('jam_kerja', 'jam_kerja.`jk_id` = jdw_kerja_d.`jk_id`', 'left')
            ->countAllResults();
    }
}
