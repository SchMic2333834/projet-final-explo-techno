<?php

namespace App\Controllers;

$session = session();
class DonneesController extends BaseController
{
    public function ChercherDetection()
    {
        $db = db_connect();

        // Use Query Builder to get the user by email
        $builder = $db->table('tblDetection');
        $builder->select('temps');
        $query = $builder->get();
        $data  = $query->getRowArray();

        if ($data)
        {
            return $data;
        }
    }
}