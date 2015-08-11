<?php
  class Admis_model extends CI_Model {

    function roller() {
      $rroller = $this->db->query("SELECT RolleID,Navn,UAP FROM BrukerRoller ORDER BY Indeks ASC");
      foreach ($rroller->result_array() as $rolle) {
        $roller[] = $rolle;
        unset($rolle);
      }
      return $roller;
    }

    function lagreroller($data) {
      foreach ($data as $ID => $Rolle) {
        $this->db->query("UPDATE BrukerRoller SET UAP='".serialize($Rolle)."',DatoEndret=Now() WHERE RolleID=".$ID." LIMIT 1");
      }
    }

    function tt($data) {
      $this->db->query("INSERT INTO fil_filer (DatoRegistrert,Navn,Filnavn) VALUES (Now(),'".$data['Navn']."','".$data['Filnavn']."')");
      $ID = $this->db->insert_id();
      if (isset($data['UtgiftID'])) {
        $this->db->query("INSERT INTO fil_xutgifter (FilID,UtgiftID) VALUES (".$ID.",".$data['UtgiftID'].")");
      }
    }

  }
?>
