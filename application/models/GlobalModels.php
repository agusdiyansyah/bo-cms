<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GlobalModels extends CI_Model{

    public function listKopSuratCuti ($kop) {
        $data = array(
            "bkd" => array(
                "satuanKerja" => "BADAN KEPEGAWAIAN DAERAH",
                "info" => "Komplek Kantor Walikota Pontianak Jl. Rahadi Osman No. 3 Telephone (0561) 747910 Faximile: (0561) 747910 PONTIANAK 78111"
            ),
            "sekda" => array(
                "satuanKerja" => "SEKRETARIAT DAERAH KOTA",
                "info" => "Jalan Rahadi Osman No. 03 Telephone 732570 - 733041 - 733042 Fax 730616 website : www.pontianakkota.go.id e-mail : sekda@pontianakkota.go.id PONTIANAK 78111"
            )
        );

        return @$data[$kop];
    }

    public function listPejabatTtd () {
		$this->db->select("id_pejabat, nama_pejabat, jabatan");
		return $this->db->get("pejabat_ttd")->result();
	}

}
