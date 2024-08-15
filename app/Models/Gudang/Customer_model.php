<?php

namespace App\Models\Gudang;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Customer_model extends Model
{
    protected $DBGroup = 'seconddb';
    protected $table      = 'customer';
    protected $primaryKey = 'customer';

    protected $allowedFields = ['customer_name', 'customer_addr1'];

    protected $request;

    function __construct(RequestInterface $request = null)
    {
        parent::__construct();
        $this->db = db_connect('seconddb');
        $this->request = $request;
    }

    public function Allcustomer($data)
    {
        return $this->db->query("select customer_name from customer where customer_name like '%$data%'")
            ->getResult();
    }

    public function Addrcustomer($data)
    {
        return $this->db->query("SELECT customer_addr1 FROM customer WHERE customer_name LIKE '%$data%'")
            ->getRowArray();
    }
}
