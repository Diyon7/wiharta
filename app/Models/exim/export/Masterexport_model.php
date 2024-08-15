<?php

namespace App\Models\exim\Data;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Master_export extends Model
{
    protected $DBGroup = 'thirddb';
    protected $table      = 'invoice_dokumen_new';
    // protected $primaryKey = 'sec';

    protected $allowedFields = ['kode', 'negara'];

    protected $request;
    protected $dt;

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('thirddb');
        $this->dt = $this->db->table('invoice_dokumen_new');
        $this->request = $request;
    }

    public function Aju()
    {
        return $this->db->query("SELECT rec_hdr_freight_bill as aju FROM rech_hdr where rec_hdr_freight_bill NOT LIKE '%-%' AND (tgl_beacukai BETWEEN '2022-01-01' AND CURDATE()) GROUP BY rec_hdr_freight_bill ORDER BY rec_hdr_freight_bill")
            ->getResultArray();
    }
}