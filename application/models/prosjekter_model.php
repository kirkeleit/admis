<?php
  class Prosjekter_model extends CI_Model {
    
    var $ProsjektStatus = array(0 => "Registrert", 1 => "Under planlegging", 2 => "Til godkjenning", 3 => "Godkjent", 4 => "Påbegynt", 5 => "Fullført");

    function prosjekter($filter = NULL) {
      $sql = "SELECT ProsjektID,DatoRegistrert,ProsjektAr,Prosjektnavn,FaggruppeID,(SELECT Navn FROM Faggrupper WHERE (FaggruppeID=p.FaggruppeID) LIMIT 1) AS FaggruppeNavn,PersonProsjektlederID,(SELECT Fornavn FROM Personer WHERE (PersonID=p.PersonProsjektlederID) LIMIT 1) AS PersonProsjektlederNavn,Budsjettramme,StatusID FROM Prosjekter p WHERE 1";
      if (isset($filter['FaggruppeID'])) {
        $sql = $sql." AND (FaggruppeID=".$filter['FaggruppeID'].")";
      }
      if (isset($filter['Arkiv'])) {
        $sql = $sql." AND (StatusID = 5)";
      } else {
        $sql = $sql." AND (StatusID < 5)";
      }
      $sql = $sql." ORDER BY ProsjektAr, PrioritetID";
      $rprosjekter = $this->db->query($sql);
      foreach ($rprosjekter->result_array() as $prosjekt) {
        $prosjekt['Status'] = $this->ProsjektStatus[$prosjekt['StatusID']];
        $prosjekter[] = $prosjekt;
        unset($prosjekt);
      }
      if (isset($prosjekter)) {
        return $prosjekter;
      } 
    }

    function prosjekt($ID) {
      $rprosjekter = $this->db->query("SELECT ProsjektID,ProsjektAr,FaggruppeID,PersonProsjektlederID,DatoProsjektstart,DatoProsjektslutt,Prosjektnavn,Formaal,Prosjektmaal,Maalgruppe,Prosjektbeskrivelse,Arbeidstimer,Budsjettramme,StatusID FROM Prosjekter WHERE (ProsjektID=".$ID.") LIMIT 1");
      if ($prosjekt = $rprosjekter->row_array()) {
        $prosjekt['Status'] = $this->ProsjektStatus[$prosjekt['StatusID']];
        //$prosjekt['Kommentarer'] = $this->kommentarer($prosjekt['ProsjektID']);
        return $prosjekt;
      }
    }

    function lagreprosjekt($ID,$prosjekt) {
      $prosjekt['DatoEndret'] = date("Y-m-d H:i:s");
      if ($ID == null) {
        $this->db->query($this->db->insert_string('Prosjekter',$prosjekt));
        $ID = $this->db->insert_id();
        $kommentar = array('ProsjektID' => $ID,'DatoRegistrert' => date('Y-m-d H:i:s'),'PersonID' => $prosjekt['PersonProsjektlederID'],'Kommentar' => 'Prosjekt er opprettet.');
        $this->db->query($this->db->insert_string('ProsjektKommentarer',$kommentar));
      } else {
        $this->db->query($this->db->update_string('Prosjekter',$prosjekt,'ProsjektID='.$ID));
      }
      $prosjekt['ProsjektID'] = $ID;
      return $prosjekt;
    }

    function slettprosjekt($ID) {
      $this->db->query("DELETE FROM Prosjekter WHERE ProsjektID=".$ID." LIMIT 1");
      $this->db->query("DELETE FROM ProsjektKommentarer WHERE ProsjektID=".$ID);
    }

    /*function kommentarer($ID) {
      $rkommentarer = $this->db->query("SELECT KommentarID,ProsjektID,DatoRegistrert,PersonID,(SELECT Fornavn FROM kon_personer WHERE (Personer.PersonID=pk.PersonID) LIMIT 1) AS PersonNavn,Kommentar FROM ProsjektKommentarer pk WHERE (ProsjektID=".$ID.") ORDER BY DatoRegistrert ASC");
      foreach ($rkommentarer->result_array() as $kommentar) {
        $kommentarer[] = $kommentar;
        unset($kommentar);
      }
      return $kommentarer;
    }*/

    /*function lagrekommentar($kommentar) {
      $this->db->query("INSERT INTO ProsjektKommentarer (ProsjektID,DatoRegistrert,PersonID,Kommentar) VALUES (".$kommentar['ProsjektID'].",Now(),'".$kommentar['PersonID']."','".$kommentar['Kommentar']."')");
    }*/

    /*function settprosjektstatus($data) {
      $this->db->query("UPDATE pro_prosjekter SET Status='".$data['Status']."' WHERE ID=".$data['ID']." LIMIT 1");
      $this->db->query("UPDATE pro_prosjekter SET DatoEndret=Now() WHERE ID=".$data['ID']." LIMIT 1");
      switch ($data['Status']) {
        case 0:
          $this->db->query("INSERT INTO pro_kommentarer (ProsjektID,DatoRegistrert,PersonID,Kommentar) VALUES (".$data['ID'].",Now(),".$data['PersonID'].",'Prosjektet er registrert.')");
          break;
        case 1:
          $this->db->query("INSERT INTO pro_kommentarer (ProsjektID,DatoRegistrert,PersonID,Kommentar) VALUES (".$data['ID'].",Now(),".$data['PersonID'].",'Prosjektet er under planlegging.')");
          break;
        case 2:
          $this->db->query("INSERT INTO pro_kommentarer (ProsjektID,DatoRegistrert,PersonID,Kommentar) VALUES (".$data['ID'].",Now(),".$data['PersonID'].",'Prosjektet er sendt til godkjenning.')");
          break;
        case 3:
          $this->db->query("INSERT INTO pro_kommentarer (ProsjektID,DatoRegistrert,PersonID,Kommentar) VALUES (".$data['ID'].",Now(),".$data['PersonID'].",'Prosjektet er godkjent.')");
          break;
        case 4:
          $this->db->query("INSERT INTO pro_kommentarer (ProsjektID,DatoRegistrert,PersonID,Kommentar) VALUES (".$data['ID'].",Now(),".$data['PersonID'].",'Prosjektet er påbegynt.')");
          break;
        case 5:
          $this->db->query("INSERT INTO pro_kommentarer (ProsjektID,DatoRegistrert,PersonID,Kommentar) VALUES (".$data['ID'].",Now(),".$data['PersonID'].",'Prosjektet er fullført.')");
          break;
      }
    }*/

  }
?>
