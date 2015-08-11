<?php
  class Aktiviteter_model extends CI_Model {

    function aksjoner() {
      $resultat = $this->db->query("SELECT * FROM aksjoner");
      foreach ($resultat->result() as $rad) {
        $data['ID'] = $rad->ID;
        $data['Type'] = $rad->Type;
        $data['Sted'] = $rad->Sted;
        $data['SARnr'] = $rad->SARnr;
        $data['DatoStart'] = $rad->DatoStart;
        $data['DatoSlutt'] = $rad->DatoSlutt;
        $aksjoner[] = $data;
        unset($data);
      }
      if (isset($aksjoner)) {
        return $aksjoner;
      }
    }

    function medlem($ID) {
      $resultat = $this->db->query("SELECT * FROM medlemmer WHERE (ID=".$ID.") LIMIT 1");
      if ($rad = $resultat->row()) {
        $data['ID'] = $rad->ID;
        $data['Fornavn'] = $rad->Fornavn;
        $data['Etternavn'] = $rad->Etternavn;
        return $data;
      }
    }

  }
?>
