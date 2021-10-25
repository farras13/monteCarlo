<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prediksi extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('M_prediksi', 'prediksi');        
        $this->load->model('M_basic', 'b');        
    }
    
    public function index()
    {
        if ($this->input->get('barang') != null) {			
            $data['prob'] = $this->prediksi->probabilitas($this->input->get('hari'), $this->input->get('barang'))->result();
			$data['tl'] = $this->totalProb($data['prob']);
        }else{
			$data['prob'] = null; 
			$data['tl'] = 0;
		}
        $data['barang'] = $this->b->getData('barang')->result();
        $this->load->view('template/header');
        $this->load->view('prediksi', $data);
        $this->load->view('template/footer');
    }

	function totalProb($data)
	{
		$tl = 0; 
		foreach ($data as $d) {
			$tl += $d->total;
		}
		return $tl;
	}

}

/* End of file Prediksi.php */
