<?php

namespace App\Models\Gudang;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Item_ccn_model extends Model
{
    protected $DBGroup = 'seconddb';
    protected $table      = 'item_ccn_new';
    protected $primaryKey = 'item';

    protected $allowedFields = ['seq', 'item', 'item_description', 'hpl', 'item_ccn_floorstock', 'item_ccn_dircost', 'item_ccn_std_cost', 'item_ccn_phantom', 'item_ccn_mrp_or_mps', 'item_ccn_fingood', 'item_ccn_make', 'item_ccn_cpo_auto_conv_type', 'item_ccn_make', 'item_height', 'item_length', 'item_weight', 'item_width', 'item_ccn_buy_um', 'item_ccn_stock_um', 'item_ccn_sell_um', 'colour_warp', 'spec', 'item_desc_rnd', 'mult_cut_size', 'product_type', 'reinf', 'main_desc', 'item_ccn_qty_conv', 'desc_cust', 'spec_cust', 'nama_beacukai'];

    protected $request;

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('seconddb');
        $this->request = $request;
    }

    public function Allitem($data)
    {
        return $this->db->query("select item, item_description from item_ccn where item like '%$data%'")
            ->getResult();
    }

    public function Namaitem($data)
    {
        return $this->db->query("SELECT item_description FROM item_ccn WHERE item LIKE '%$data%'")
            ->getRowArray();
    }
}
