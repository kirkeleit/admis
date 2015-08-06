<?php
  class Filer_model extends CI_Model {

    function nyfil($data) {
      $this->db->query($this->db->insert_string('Filer',array('DatoRegistrert'=>date('Y-m-d H:i:s'),'Navn'=>$data['Navn'],'Filnavn'=>$data['Filnavn'])));
      $ID = $this->db->insert_id();
      if (isset($data['UtgiftID'])) {
        $this->db->query("INSERT INTO FilXUtgifter (FilID,UtgiftID) VALUES (".$ID.",".$data['UtgiftID'].")");
      }
      if (isset($data['UtleggID'])) {
        $this->db->query("INSERT INTO FilXUtlegg (FilID,UtleggID) VALUES (".$ID.",".$data['UtleggID'].")");
      }
    }

  }
?>
