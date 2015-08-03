<?php
  class Filer_model extends CI_Model {

    function nyfil($data) {
      $this->db->query("INSERT INTO fil_filer (DatoRegistrert,Navn,Filnavn) VALUES (Now(),'".$data['Navn']."','".$data['Filnavn']."')");
      $ID = $this->db->insert_id();
      if (isset($data['UtgiftID'])) {
        $this->db->query("INSERT INTO fil_xutgifter (FilID,UtgiftID) VALUES (".$ID.",".$data['UtgiftID'].")");
      }
      if (isset($data['UtleggID'])) {
        $this->db->query("INSERT INTO fil_xutlegg (FilID,UtleggID) VALUES (".$ID.",".$data['UtleggID'].")");
      }
    }

  }
?>
