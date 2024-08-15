<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;
use DateTime;

class RekapAll_model extends Model
{

    protected $table      = 'pegawai';
    protected $primaryKey = 'pegawai_id';

    protected $allowedFields = ['pegawai_pin', 'pegawai_nip', 'pegawai_id', 'pegawai_nama', 'tgl_lahir', 'tgl_mulai_kerja', 'tgl_masuk_pertama', 'golongan', 'grup', 'grup_t', 'grup_jam_kerja', 'resign'];

    protected $request;

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }

    public function TidakmasukNS1($tanggal)
    {
        $grupkerja = ['GK01', 'GK02', 'GK03'];
        return $this->select('pegawai.`pegawai_nip` AS nip, pegawai.`pegawai_nama` AS nama, grup_jam_kerja, m.pegawai_pin, pembagian4.`pembagian4_nama` AS unit')
            ->join("pembagian4", "pegawai.`pembagian4_id`=pembagian4.`pembagian4_id`")
            ->join("pembagian2", "pegawai.`pembagian2_id`=pembagian2.`pembagian2_id`", "left")
            ->join("(SELECT pegawai_pin FROM pegawai
                    JOIN att_log ON pegawai.`pegawai_pin`=att_log.`pin`
                    WHERE grup_jam_kerja in ('GK01', 'GK02','GK03') AND scan_date BETWEEN '" . $tanggal['tanggal'] . " 05:00:00' AND '" . $tanggal['tanggal'] . " 13:00:00' GROUP BY pegawai.`pegawai_pin`) AS m", "m.pegawai_pin=pegawai.`pegawai_pin`", "left")
            ->where("(pegawai.`tgl_resign`='0000-00-00' OR pegawai.`tgl_resign`>='" . $tanggal['tanggal'] . "' OR pegawai.`tgl_resign` IS NULL) AND pegawai.`tgl_mulai_kerja`<='" . $tanggal['tanggal'] . "'")
            ->whereIn("grup_jam_kerja", $grupkerja)
            ->where("m.pegawai_pin IS NULL")
            ->like("pembagian2.`pembagian2_nama`", $tanggal['divisi'])
            ->get()->getResultArray();
    }
    public function TidakmasukNS2($tanggal)
    {
        $grupkerja = ['GK02', 'GK03'];
        return $this->select('pegawai.`pegawai_nip` AS nip, pegawai.`pegawai_nama` AS nama, grup_jam_kerja, m.pegawai_pin, pembagian4.`pembagian4_nama` AS unit')
            ->join("pembagian4", "pegawai.`pembagian4_id`=pembagian4.`pembagian4_id`")
            ->join("(SELECT pegawai_pin FROM pegawai
                    JOIN att_log ON pegawai.`pegawai_pin`=att_log.`pin`
                    WHERE grup_jam_kerja in ('GK02','GK03') AND scan_date BETWEEN '" . $tanggal['tanggal'] . " 05:00:00' AND '" . $tanggal['tanggal'] . " 13:00:00' GROUP BY pegawai.`pegawai_pin`) AS m", "m.pegawai_pin=pegawai.`pegawai_pin`", "left")
            ->where("(pegawai.`tgl_resign`='0000-00-00' OR pegawai.`tgl_resign`>='" . $tanggal['tanggal'] . "' OR pegawai.`tgl_resign` IS NULL) AND pegawai.`tgl_mulai_kerja`<='" . $tanggal['tanggal'] . "'")
            ->whereIn("grup_jam_kerja", $grupkerja)
            ->where("m.pegawai_pin IS NULL")
            ->get()->getResultArray();
    }

    public function Shift1($tanggal)
    {
        $grupkerja = ['GK01', 'GK02', 'GK03'];
        return $this->select('pegawai.`pegawai_nip` AS nip, pegawai.`pegawai_nama` AS nama, grup_jam_kerja, m.pegawai_pin, pembagian4.`pembagian4_nama` AS unit')
            ->join("pembagian4", "pegawai.`pembagian4_id`=pembagian4.`pembagian4_id`")
            ->join("pembagian2", "pegawai.`pembagian2_id`=pembagian2.`pembagian2_id`", "left")
            ->join('tb_jadwal', 'pegawai.`grup_jam_kerja`=tb_jadwal.`grup`')
            ->join("(SELECT pegawai_pin FROM pegawai
            JOIN tb_jadwal ON pegawai.`grup_jam_kerja`=tb_jadwal.`grup`
            JOIN att_log ON pegawai.`pegawai_pin`=att_log.`pin`
            WHERE grup_jam_kerja NOT IN('GK01','GK02', 'GK03') AND tb_jadwal.`tgl`='" . $tanggal['tanggal'] . "' AND shift=1 AND scan_date BETWEEN '" . $tanggal['tanggal'] . " 05:00:00' AND '" . $tanggal['tanggal'] . " 13:00:00' GROUP BY pegawai.`pegawai_pin`) AS m", "m.pegawai_pin=pegawai.`pegawai_pin`", "left")
            ->whereNotIn("grup_jam_kerja", $grupkerja)
            ->like("pembagian2.`pembagian2_nama`", $tanggal['divisi'])
            ->where("m.pegawai_pin IS NULL")
            ->where('tb_jadwal.`tgl`', $tanggal['tanggal'])
            ->where('shift', '1')
            ->where("(pegawai.`tgl_resign`='0000-00-00' OR pegawai.`tgl_resign`>='" . $tanggal['tanggal'] . "' OR pegawai.`tgl_resign` IS NULL) AND pegawai.`tgl_mulai_kerja`<='" . $tanggal['tanggal'] . "'")
            ->get()->getResultArray();
    }

    public function Shift2($tanggal)
    {
        $grupkerja = ['GK01', 'GK02', 'GK03'];
        return $this->select('pegawai.`pegawai_nip` AS nip, pegawai.`pegawai_nama` AS nama, grup_jam_kerja, m.pegawai_pin, pembagian4.`pembagian4_nama` AS unit')
            ->join("pembagian4", "pegawai.`pembagian4_id`=pembagian4.`pembagian4_id`")
            ->join("pembagian2", "pegawai.`pembagian2_id`=pembagian2.`pembagian2_id`", "left")
            ->join('tb_jadwal', 'pegawai.`grup_jam_kerja`=tb_jadwal.`grup`')
            ->join("(SELECT pegawai_pin FROM pegawai
            JOIN tb_jadwal ON pegawai.`grup_jam_kerja`=tb_jadwal.`grup`
            JOIN att_log ON pegawai.`pegawai_pin`=att_log.`pin`
            WHERE grup_jam_kerja NOT IN('GK01','GK02', 'GK03') AND tb_jadwal.`tgl`='" . $tanggal['tanggal'] . "' AND shift=2 AND scan_date BETWEEN '" . $tanggal['tanggal'] . " 13:00:00' AND '" . $tanggal['tanggal'] . " 20:00:00' GROUP BY pegawai.`pegawai_pin`) AS m", "m.pegawai_pin=pegawai.`pegawai_pin`", "left")
            ->whereNotIn("grup_jam_kerja", $grupkerja)
            ->like("pembagian2.`pembagian2_nama`", $tanggal['divisi'])
            ->where("m.pegawai_pin IS NULL")
            ->where('tb_jadwal.`tgl`', $tanggal['tanggal'])
            ->where('shift', '2')
            ->where("(pegawai.`tgl_resign`='0000-00-00' OR pegawai.`tgl_resign`>='" . $tanggal['tanggal'] . "' OR pegawai.`tgl_resign` IS NULL) AND pegawai.`tgl_mulai_kerja`<='" . $tanggal['tanggal'] . "'")
            ->get()->getResultArray();
    }

    public function Shift3($tanggal)
    {
        $grupkerja = ['GK01', 'GK02', 'GK03'];
        return $this->select('pegawai.`pegawai_nip` AS nip, pegawai.`pegawai_nama` AS nama, grup_jam_kerja, m.pegawai_pin, pembagian4.`pembagian4_nama` AS unit')
            ->join("pembagian4", "pegawai.`pembagian4_id`=pembagian4.`pembagian4_id`")
            ->join("pembagian2", "pegawai.`pembagian2_id`=pembagian2.`pembagian2_id`", "left")
            ->join('tb_jadwal', 'pegawai.`grup_jam_kerja`=tb_jadwal.`grup`')
            ->join("(SELECT pegawai_pin FROM pegawai
            JOIN tb_jadwal ON pegawai.`grup_jam_kerja`=tb_jadwal.`grup`
            JOIN att_log ON pegawai.`pegawai_pin`=att_log.`pin`
            WHERE grup_jam_kerja NOT IN('GK01','GK02', 'GK03') AND tb_jadwal.`tgl`='" . $tanggal['tanggal'] . "' AND shift=3 AND scan_date BETWEEN '" . $tanggal['tanggal'] . " 21:00:00' AND '" . $tanggal['tanggal'] . " 23:59:00' GROUP BY pegawai.`pegawai_pin`) AS m", "m.pegawai_pin=pegawai.`pegawai_pin`", "left")
            ->whereNotIn("grup_jam_kerja", $grupkerja)
            ->like("pembagian2.`pembagian2_nama`", $tanggal['divisi'])
            ->where("m.pegawai_pin IS NULL")
            ->where('tb_jadwal.`tgl`', $tanggal['tanggal'])
            ->where('shift', '3')
            ->where("(pegawai.`tgl_resign`='0000-00-00' OR pegawai.`tgl_resign`>='" . $tanggal['tanggal'] . "' OR pegawai.`tgl_resign` IS NULL) AND pegawai.`tgl_mulai_kerja`<='" . $tanggal['tanggal'] . "'")
            ->get()->getResultArray();
    }

    public function TerlambatNS1($tanggal)
    {
        $grupkerja = ['GK01', 'GK02', 'GK03'];
        return $this->select("pegawai.`pegawai_nip` AS pin, pegawai.`pegawai_nama` AS nama, pegawai.`pegawai_nip`, TIMEDIFF(TIME('07:51:00'),TIME(att_log.`scan_date`)) AS selisih")
            ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`')
            ->join("pembagian2", "pegawai.`pembagian2_id`=pembagian2.`pembagian2_id`", "left")
            ->whereIn('pegawai.`grup_jam_kerja`', 'GK01')
            ->like("pembagian2.`pembagian2_nama`", $tanggal['divisi'])
            ->where('pegawai.`resign`', '0')
            ->where("scan_date BETWEEN '" . $tanggal['tanggal'] . " 07:51:00' AND '" . $tanggal['tanggal'] . " 13:00:00'")
            ->get()->getResultArray();
    }

    public function TerlambatNS2($tanggal)
    {
        $grupkerja = ['GK02', 'GK03'];
        return $this->select("pegawai.`pegawai_nip` AS pin, pegawai.`pegawai_nama` AS nama, pegawai.`pegawai_nip`, TIMEDIFF(TIME('06:51:00'),TIME(att_log.`scan_date`)) AS selisih")
            ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`')
            ->join("pembagian2", "pegawai.`pembagian2_id`=pembagian2.`pembagian2_id`", "left")
            ->whereIn('pegawai.`grup_jam_kerja`', $grupkerja)
            ->like("pembagian2.`pembagian2_nama`", $tanggal['divisi'])
            ->where('pegawai.`resign`', '0')
            ->where("scan_date BETWEEN '" . $tanggal['tanggal'] . " 06:51:00' AND '" . $tanggal['tanggal'] . " 13:00:00'")
            ->get()->getResultArray();
    }

    public function TS1($tanggal)
    {
        $grupkerja = ['GK01', 'GK02', 'GK03'];
        return $this->select("pegawai.`pegawai_pin` AS pin, pegawai.`pegawai_nama` AS nama, pegawai.`pegawai_nip`, TIMEDIFF(TIME('06:51:00'),TIME(att_log.`scan_date`)) AS selisih")
            ->join('tb_jadwal', 'pegawai.`grup_jam_kerja`=tb_jadwal.`grup`')
            ->join("pembagian2", "pegawai.`pembagian2_id`=pembagian2.`pembagian2_id`", "left")
            ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`')
            ->whereNotIn('pegawai.`grup_jam_kerja`', $grupkerja)
            ->like("pembagian2.`pembagian2_nama`", $tanggal['divisi'])
            ->where('pegawai.`resign`', '0')
            ->where("scan_date BETWEEN '" . $tanggal['tanggal'] . " 06:51:00' AND '" . $tanggal['tanggal'] . " 13:00:00'")
            ->get()->getResultArray();
    }

    public function TS2($tanggal)
    {
        $grupkerja = ['GK01', 'GK02', 'GK03'];
        return $this->select("pegawai.`pegawai_pin` AS pin, pegawai.`pegawai_nama` AS nama, pegawai.`pegawai_nip`, TIMEDIFF(TIME('14:51:00'),TIME(att_log.`scan_date`)) AS selisih")
            ->join('tb_jadwal', 'pegawai.`grup_jam_kerja`=tb_jadwal.`grup`')
            ->join("pembagian2", "pegawai.`pembagian2_id`=pembagian2.`pembagian2_id`", "left")
            ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`')
            ->whereNotIn('pegawai.`grup_jam_kerja`', $grupkerja)
            ->like("pembagian2.`pembagian2_nama`", $tanggal['divisi'])
            ->where('pegawai.`resign`', '0')
            ->where("scan_date BETWEEN '" . $tanggal['tanggal'] . " 14:51:00' AND '" . $tanggal['tanggal'] . " 23:00:00'")
            ->get()->getResultArray();
    }

    public function TS3($tanggal)
    {
        $grupkerja = ['GK01', 'GK02', 'GK03'];
        return $this->select("pegawai.`pegawai_pin` AS pin, pegawai.`pegawai_nama` AS nama, pegawai.`pegawai_nip`, TIMEDIFF(TIME('22:51:00'),TIME(att_log.`scan_date`)) AS selisih")
            ->join('tb_jadwal', 'pegawai.`grup_jam_kerja`=tb_jadwal.`grup`')
            ->join("pembagian2", "pegawai.`pembagian2_id`=pembagian2.`pembagian2_id`", "left")
            ->join('att_log', 'pegawai.`pegawai_pin`=att_log.`pin`')
            ->whereNotIn('pegawai.`grup_jam_kerja`', $grupkerja)
            ->like("pembagian2.`pembagian2_nama`", $tanggal['divisi'])
            ->where('pegawai.`resign`', '0')
            ->where("scan_date BETWEEN '" . $tanggal['tanggal'] . " 22:51:00' AND '" . $tanggal['tanggal'] . " 07:00:00'")
            ->get()->getResultArray();
    }

    public function DKPHarian($data)
    {
        return $this->db->query("SELECT pembagian2.`pembagian2_nama`, pembagian4.`pembagian4_nama`, COUNT(pembagian4.`pembagian4_nama`) AS dkp, ns1, sh1, sh2, sh3, sh0 FROM pegawai
        JOIN pembagian4 ON pembagian4.`pembagian4_id`=pegawai.`pembagian4_id`
        LEFT JOIN pembagian2 ON pegawai.`pembagian2_id`=pembagian2.`pembagian2_id`
        LEFT JOIN tb_jadwal ON tb_jadwal.`grupass`=pegawai.`grup_jam_kerja`
        LEFT JOIN(SELECT pembagian4.`pembagian4_nama`, pegawai.`pembagian4_id`, COUNT(pembagian4.`pembagian4_nama`) AS ns1 FROM pegawai
        LEFT JOIN tb_jadwal ON tb_jadwal.`grupass`=pegawai.`grup_jam_kerja`
        LEFT JOIN pembagian2 ON pegawai.`pembagian2_id`=pembagian2.`pembagian2_id`
        JOIN pembagian4 ON pembagian4.`pembagian4_id`=pegawai.`pembagian4_id`
        WHERE (pegawai.`tgl_resign`='0000-00-00' OR pegawai.`tgl_resign`>='" . $data['tanggal'] . "' OR pegawai.`tgl_resign` IS NULL) AND pegawai.`tgl_mulai_kerja`<='" . $data['tanggal'] . "' AND pegawai.`grup_jam_kerja` IN ('GK01', 'GK02', 'GK03') AND  tgl='" . $data['tanggal'] . "' AND pembagian2.`pembagian2_nama` LIKE '" . $data['divisi'] . "' GROUP BY pegawai.`pembagian4_id`) AS jns1 ON jns1.pembagian4_id=pembagian4.`pembagian4_id`
        LEFT JOIN(SELECT pembagian4.`pembagian4_nama`, pegawai.`pembagian4_id`, COUNT(pembagian4.`pembagian4_nama`) AS sh1 FROM pegawai
        LEFT JOIN tb_jadwal ON tb_jadwal.`grupass`=pegawai.`grup_jam_kerja`
        LEFT JOIN pembagian2 ON pegawai.`pembagian2_id`=pembagian2.`pembagian2_id`
        JOIN pembagian4 ON pembagian4.`pembagian4_id`=pegawai.`pembagian4_id`
        WHERE (pegawai.`tgl_resign`='0000-00-00' OR pegawai.`tgl_resign`>='" . $data['tanggal'] . "' OR pegawai.`tgl_resign` IS NULL) AND pegawai.`tgl_mulai_kerja`<='" . $data['tanggal'] . "' AND pegawai.`grup_jam_kerja` NOT IN('GK01','GK02', 'GK03') AND tb_jadwal.`shift`=1 AND  tgl='" . $data['tanggal'] . "' AND pembagian2.`pembagian2_nama` LIKE '" . $data['divisi'] . "' GROUP BY pegawai.`pembagian4_id`) AS s1 ON s1.pembagian4_id=pembagian4.`pembagian4_id`
        LEFT JOIN(SELECT pembagian4.`pembagian4_nama`, pegawai.`pembagian4_id`, COUNT(pembagian4.`pembagian4_nama`) AS sh2 FROM pegawai
        LEFT JOIN tb_jadwal ON tb_jadwal.`grupass`=pegawai.`grup_jam_kerja`
        LEFT JOIN pembagian2 ON pegawai.`pembagian2_id`=pembagian2.`pembagian2_id`
        JOIN pembagian4 ON pembagian4.`pembagian4_id`=pegawai.`pembagian4_id`
        WHERE (pegawai.`tgl_resign`='0000-00-00' OR pegawai.`tgl_resign`>='" . $data['tanggal'] . "' OR pegawai.`tgl_resign` IS NULL) AND pegawai.`tgl_mulai_kerja`<='" . $data['tanggal'] . "' AND pegawai.`grup_jam_kerja` NOT IN('GK01','GK02', 'GK03') AND tb_jadwal.`shift`=2 AND  tgl='" . $data['tanggal'] . "' AND pembagian2.`pembagian2_nama` LIKE '" . $data['divisi'] . "' GROUP BY pegawai.`pembagian4_id`) AS s2 ON s2.pembagian4_id=pembagian4.`pembagian4_id`
        LEFT JOIN(SELECT pembagian4.`pembagian4_nama`, pegawai.`pembagian4_id`, COUNT(pembagian4.`pembagian4_nama`) AS sh3 FROM pegawai
        LEFT JOIN tb_jadwal ON tb_jadwal.`grupass`=pegawai.`grup_jam_kerja`
        LEFT JOIN pembagian2 ON pegawai.`pembagian2_id`=pembagian2.`pembagian2_id`
        JOIN pembagian4 ON pembagian4.`pembagian4_id`=pegawai.`pembagian4_id`
        WHERE (pegawai.`tgl_resign`='0000-00-00' OR pegawai.`tgl_resign`>='" . $data['tanggal'] . "' OR pegawai.`tgl_resign` IS NULL) AND pegawai.`tgl_mulai_kerja`<='" . $data['tanggal'] . "' AND pegawai.`grup_jam_kerja` NOT IN('GK01','GK02', 'GK03') AND tb_jadwal.`shift`=3 AND  tgl='" . $data['tanggal'] . "' AND pembagian2.`pembagian2_nama` LIKE '" . $data['divisi'] . "' GROUP BY pegawai.`pembagian4_id`) AS s3 ON s3.pembagian4_id=pembagian4.`pembagian4_id`
        LEFT JOIN(SELECT pembagian4.`pembagian4_nama`, pegawai.`pembagian4_id`, COUNT(pembagian4.`pembagian4_nama`) AS sh0 FROM pegawai
        LEFT JOIN tb_jadwal ON tb_jadwal.`grupass`=pegawai.`grup_jam_kerja`
        LEFT JOIN pembagian2 ON pegawai.`pembagian2_id`=pembagian2.`pembagian2_id`
        JOIN pembagian4 ON pembagian4.`pembagian4_id`=pegawai.`pembagian4_id`
        WHERE (pegawai.`tgl_resign`='0000-00-00' OR pegawai.`tgl_resign`>='" . $data['tanggal'] . "' OR pegawai.`tgl_resign` IS NULL) AND pegawai.`tgl_mulai_kerja`<='" . $data['tanggal'] . "' AND pegawai.`grup_jam_kerja` NOT IN('GK01','GK02', 'GK03') AND tb_jadwal.`shift`=0 AND  tgl='" . $data['tanggal'] . "' AND pembagian2.`pembagian2_nama` LIKE '" . $data['divisi'] . "' GROUP BY pegawai.`pembagian4_id`) AS s0 ON s0.pembagian4_id=pembagian4.`pembagian4_id`
        WHERE (pegawai.`tgl_resign`='0000-00-00' OR pegawai.`tgl_resign`>='" . $data['tanggal'] . "' OR pegawai.`tgl_resign` IS NULL) AND pegawai.`tgl_mulai_kerja`<='" . $data['tanggal'] . "' AND  tgl='" . $data['tanggal'] . "' AND pembagian2.`pembagian2_nama` LIKE '" . $data['divisi'] . "' GROUP BY pembagian4.`pembagian4_id`")->getResultArray();
    }

    public function DKPMasuk($data)
    {
        return $this->db->query("SELECT pembagian4.`pembagian4_nama`, COUNT(pembagian4.`pembagian4_nama`) AS DKP, ns1, sh1, sh2, sh3, sh0 FROM pegawai
        JOIN pembagian4 ON pembagian4.`pembagian4_id`=pegawai.`pembagian4_id`
        LEFT JOIN pembagian2 ON pegawai.`pembagian2_id`=pembagian2.`pembagian2_id`
        LEFT JOIN tb_jadwal ON tb_jadwal.`grupass`=pegawai.`grup_jam_kerja`
        LEFT JOIN(SELECT pembagian4.`pembagian4_nama`, pegawai.`pembagian4_id`, COUNT(pembagian4.`pembagian4_nama`) AS ns1 FROM pegawai
        LEFT JOIN pembagian2 ON pegawai.`pembagian2_id`=pembagian2.`pembagian2_id`
        JOIN pembagian4 ON pembagian4.`pembagian4_id`=pegawai.`pembagian4_id`
        JOIN (SELECT pin FROM att_log WHERE att_log.`scan_date` BETWEEN '" . $data['tanggal'] . " 05:00:00' AND '" . $data['tanggal'] . " 11:51:00' GROUP BY pin) AS pin ON pegawai.`pegawai_pin`=pin.`pin`
        WHERE (pegawai.`tgl_resign`='0000-00-00' OR pegawai.`tgl_resign`>='" . $data['tanggal'] . "' OR pegawai.`tgl_resign` IS NULL) AND pegawai.`tgl_mulai_kerja`<='" . $data['tanggal'] . "' AND pegawai.`grup_jam_kerja` IN ('GK01', 'GK02', 'GK03') AND pembagian2.`pembagian2_nama` LIKE '" . $data['divisi'] . "' GROUP BY pembagian4.`pembagian4_nama`) AS jns1 ON jns1.pembagian4_id=pembagian4.`pembagian4_id`
        LEFT JOIN(SELECT pembagian4.`pembagian4_nama`, pegawai.`pembagian4_id`, COUNT(pembagian4.`pembagian4_nama`) AS sh1 FROM pegawai
        LEFT JOIN tb_jadwal ON tb_jadwal.`grupass`=pegawai.`grup_jam_kerja`
        LEFT JOIN pembagian2 ON pegawai.`pembagian2_id`=pembagian2.`pembagian2_id`
        JOIN pembagian4 ON pembagian4.`pembagian4_id`=pegawai.`pembagian4_id`
        JOIN (SELECT pin FROM att_log WHERE att_log.`scan_date` BETWEEN '" . $data['tanggal'] . " 05:00:00' AND '" . $data['tanggal'] . " 11:51:00' GROUP BY pin) AS pin ON pegawai.`pegawai_pin`=pin.`pin`
        WHERE (pegawai.`tgl_resign`='0000-00-00' OR pegawai.`tgl_resign`>='" . $data['tanggal'] . "' OR pegawai.`tgl_resign` IS NULL) AND pegawai.`tgl_mulai_kerja`<='" . $data['tanggal'] . "' AND pegawai.`grup_jam_kerja` NOT IN('GK01','GK02', 'GK03') AND tb_jadwal.`tgl`='" . $data['tanggal'] . "' AND shift=1 AND pembagian2.`pembagian2_nama` LIKE '" . $data['divisi'] . "' GROUP BY pembagian4.`pembagian4_nama`) AS s1 ON s1.pembagian4_id=pembagian4.`pembagian4_id`
        LEFT JOIN(SELECT pembagian4.`pembagian4_nama`, pegawai.`pembagian4_id`, COUNT(pembagian4.`pembagian4_nama`) AS sh2 FROM pegawai
        LEFT JOIN tb_jadwal ON tb_jadwal.`grupass`=pegawai.`grup_jam_kerja`
        LEFT JOIN pembagian2 ON pegawai.`pembagian2_id`=pembagian2.`pembagian2_id`
        JOIN pembagian4 ON pembagian4.`pembagian4_id`=pegawai.`pembagian4_id`
        JOIN (SELECT pin FROM att_log WHERE att_log.`scan_date` BETWEEN '" . $data['tanggal'] . " 13:00:00' AND '" . $data['tanggal'] . " 19:51:00' GROUP BY pin) AS pin ON pegawai.`pegawai_pin`=pin.`pin`
        WHERE (pegawai.`tgl_resign`='0000-00-00' OR pegawai.`tgl_resign`>='" . $data['tanggal'] . "' OR pegawai.`tgl_resign` IS NULL) AND pegawai.`tgl_mulai_kerja`<='" . $data['tanggal'] . "' AND pegawai.`grup_jam_kerja` NOT IN('GK01','GK02', 'GK03') AND tb_jadwal.`tgl`='" . $data['tanggal'] . "' AND shift=2 AND pembagian2.`pembagian2_nama` LIKE '" . $data['divisi'] . "' GROUP BY pembagian4.`pembagian4_nama`) AS s2 ON s2.pembagian4_id=pembagian4.`pembagian4_id`
        LEFT JOIN(SELECT pembagian4.`pembagian4_nama`, pegawai.`pembagian4_id`, COUNT(pembagian4.`pembagian4_nama`) AS sh3 FROM pegawai
        LEFT JOIN tb_jadwal ON tb_jadwal.`grupass`=pegawai.`grup_jam_kerja`
        LEFT JOIN pembagian2 ON pegawai.`pembagian2_id`=pembagian2.`pembagian2_id`
        JOIN pembagian4 ON pembagian4.`pembagian4_id`=pegawai.`pembagian4_id`
        JOIN (SELECT pin FROM att_log WHERE att_log.`scan_date` BETWEEN '" . $data['tanggal'] . " 21:00:00' AND '" . $data['tanggal'] . " 23:59:00' GROUP BY pin) AS pin ON pegawai.`pegawai_pin`=pin.`pin`
        WHERE (pegawai.`tgl_resign`='0000-00-00' OR pegawai.`tgl_resign`>='" . $data['tanggal'] . "' OR pegawai.`tgl_resign` IS NULL) AND pegawai.`tgl_mulai_kerja`<='" . $data['tanggal'] . "' AND pegawai.`grup_jam_kerja` NOT IN('GK01','GK02', 'GK03') AND tb_jadwal.`tgl`='" . $data['tanggal'] . "' AND shift=3 AND pembagian2.`pembagian2_nama` LIKE '" . $data['divisi'] . "' GROUP BY pembagian4.`pembagian4_nama`) AS s3 ON s3.pembagian4_id=pembagian4.`pembagian4_id`
        LEFT JOIN(SELECT pembagian4.`pembagian4_nama`, pegawai.`pembagian4_id`, COUNT(pembagian4.`pembagian4_nama`) AS sh0 FROM pegawai
        LEFT JOIN tb_jadwal ON tb_jadwal.`grupass`=pegawai.`grup_jam_kerja`
        LEFT JOIN pembagian2 ON pegawai.`pembagian2_id`=pembagian2.`pembagian2_id`
        JOIN pembagian4 ON pembagian4.`pembagian4_id`=pegawai.`pembagian4_id`
        JOIN (SELECT pin FROM att_log WHERE att_log.`scan_date` LIKE '" . $data['tanggal'] . "%' GROUP BY pin) AS pin ON pegawai.`pegawai_pin`=pin.`pin`
        WHERE (pegawai.`tgl_resign`='0000-00-00' OR pegawai.`tgl_resign`>='" . $data['tanggal'] . "' OR pegawai.`tgl_resign` IS NULL) AND pegawai.`tgl_mulai_kerja`<='" . $data['tanggal'] . "' AND pegawai.`grup_jam_kerja` NOT IN('GK01','GK02', 'GK03') AND tb_jadwal.`tgl`='" . $data['tanggal'] . "' AND shift=0 AND pembagian2.`pembagian2_nama` LIKE '" . $data['divisi'] . "' GROUP BY pembagian4.`pembagian4_nama`) AS s0 ON s0.pembagian4_id=pembagian4.`pembagian4_id`
        WHERE (pegawai.`tgl_resign`='0000-00-00' OR pegawai.`tgl_resign`>='" . $data['tanggal'] . "' OR pegawai.`tgl_resign` IS NULL) AND pegawai.`tgl_mulai_kerja`<='" . $data['tanggal'] . "' AND  tgl='" . $data['tanggal'] . "' AND pembagian2.`pembagian2_nama` LIKE '" . $data['divisi'] . "' GROUP BY pembagian4.`pembagian4_id`")->getResultArray();
    }
}