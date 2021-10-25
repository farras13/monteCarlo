<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_basic extends CI_Model {

    public function getData($t,$w = null)
    {   
        if ($t == 'penjualan') {
            $this->db->join('barang', 'barang.id_brg = penjualan.id_barang');
        }

        if ($w != null) {
           $this->db->where($w);
        }
        return $this->db->get($t);
    }

    public function ins($t, $object)
    {
        $this->db->insert($t, $object);
    }

    public function upd($t, $object, $w)
    {
        $this->db->update($t, $object, $w);
    }

    public function del($t, $w)
    {
        $this->db->delete($t, $w);
    }

}

/* End of file M_basic.php */
