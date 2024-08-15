SELECT pembagian4.`pembagian4_nama`, COUNT(pembagian4.`pembagian4_nama`) AS DKP, mk, sh0, dlk FROM pegawai
JOIN pembagian4 ON pembagian4.`pembagian4_id`=pegawai.`pembagian4_id`
LEFT JOIN pembagian2 ON pegawai.`pembagian2_id`=pembagian2.`pembagian2_id`
LEFT JOIN pembagian6 ON pegawai.`pembagian6_id`=pembagian6.`pembagian6_id`
LEFT JOIN tb_jadwal ON tb_jadwal.`grupass`=pegawai.`grup_jam_kerja`
LEFT JOIN(SELECT pembagian4.`pembagian4_nama`, pegawai.`pembagian4_id`, COUNT(pembagian4.`pembagian4_nama`) AS mk FROM
pegawai
LEFT JOIN tb_jadwal ON tb_jadwal.`grupass`=pegawai.`grup_jam_kerja`
LEFT JOIN pembagian2 ON pegawai.`pembagian2_id`=pembagian2.`pembagian2_id`
JOIN pembagian4 ON pembagian4.`pembagian4_id`=pegawai.`pembagian4_id`
JOIN (SELECT pin FROM att_log WHERE att_log.`scan_date` BETWEEN '" . $data['tanggal'] . " 11:00:00' AND '$time' GROUP BY
pin) AS pin ON pegawai.`pegawai_pin`=pin.`pin`
WHERE (pegawai.`tgl_resign`='0000-00-00' OR pegawai.`tgl_resign`>='" . $data['tanggal'] . "' OR pegawai.`tgl_resign` IS
NULL) AND pegawai.`tgl_mulai_kerja`<='" . $data['tanggal'] . "' AND tb_jadwal.`tgl`='" . $data['tanggal'] . "' AND shift!=0 AND pembagian2.`pembagian2_nama` LIKE '" . $data['divisi'] . "' GROUP BY pembagian4.`pembagian4_nama`) AS s1 ON s1.pembagian4_id=pembagian4.`pembagian4_id`
        LEFT JOIN(SELECT pembagian4.`pembagian4_nama`, pegawai.`pembagian4_id`, COUNT(pembagian4.`pembagian4_nama`) AS sh0 FROM pegawai
        LEFT JOIN tb_jadwal ON tb_jadwal.`grupass`=pegawai.`grup_jam_kerja`
        LEFT JOIN pembagian2 ON pegawai.`pembagian2_id`=pembagian2.`pembagian2_id`
        JOIN pembagian4 ON pembagian4.`pembagian4_id`=pegawai.`pembagian4_id`
        JOIN (SELECT pin FROM att_log WHERE att_log.`scan_date` LIKE '" . $data['tanggal'] . "%' GROUP BY pin) AS pin ON pegawai.`pegawai_pin`=pin.`pin`
        WHERE (pegawai.`tgl_resign`='0000-00-00' OR pegawai.`tgl_resign`>='" . $data['tanggal'] . "' OR pegawai.`tgl_resign` IS NULL) AND pegawai.`tgl_mulai_kerja`<='" . $data['tanggal'] . "' AND tb_jadwal.`tgl`='" . $data['tanggal'] . "' AND shift=0 AND pembagian2.`pembagian2_nama` LIKE '" . $data['divisi'] . "' GROUP BY pembagian4.`pembagian4_nama`) AS s0 ON s0.pembagian4_id=pembagian4.`pembagian4_id`
        LEFT JOIN(SELECT pembagian4.`pembagian4_nama`, pegawai.`pembagian4_id`, diliburkan.`jumlah_orang` dlk FROM pegawai
        LEFT JOIN pembagian2 ON pegawai.`pembagian2_id`=pembagian2.`pembagian2_id`
        JOIN pembagian4 ON pembagian4.`pembagian4_id`=pegawai.`pembagian4_id`
        JOIN diliburkan ON pembagian4.`pembagian4_id`=diliburkan.`pembagian4_id`
        WHERE (pegawai.`tgl_resign`='0000-00-00' OR pegawai.`tgl_resign`>='" . $data['tanggal'] . "' OR pegawai.`tgl_resign` IS NULL) AND pegawai.`tgl_mulai_kerja`<='" . $data['tanggal'] . "' AND diliburkan.`tgl_d`='" . $data['tanggal'] . "' AND pembagian2.`pembagian2_nama` LIKE '" . $data['divisi'] . "' GROUP BY pembagian4.`pembagian4_nama`) AS dl ON dl.pembagian4_id=pembagian4.`pembagian4_id`
        WHERE (pegawai.`tgl_resign`='0000-00-00' OR pegawai.`tgl_resign`>='" . $data['tanggal'] . "' OR pegawai.`tgl_resign` IS NULL) AND pegawai.`tgl_mulai_kerja`<='" . $data['tanggal'] . "' AND  tgl='" . $data['tanggal'] . "' AND pembagian2.`pembagian2_nama` LIKE '" . $data['divisi'] . "' GROUP BY pembagian2.`pembagian2_id`, pembagian4.`pembagian4_id` ORDER BY pembagian6.`pembagian6_nama`, pembagian2.`pembagian2_nama`, pembagian4.`pembagian4_nama`