<?php
  class Prosjekter_model extends CI_Model {

    function prosjekter($filter = NULL) {
      if ($filter == NULL) {
        $sql = "SELECT * FROM pro_prosjekter WHERE (DatoSlettet Is Null) AND (Status<5) ORDER BY ProsjektAr, Prioritet";
      } else {
        $sql = "SELECT * FROM pro_prosjekter WHERE (DatoSlettet Is Null)";
        if (isset($filter['FaggruppeID'])) {
          $sql = $sql." AND (FaggruppeID=".$filter['FaggruppeID'].")";
        }
        if (isset($filter['Arkiv'])) {
          $sql = $sql." AND (Status = 5)";
        } else {
          $sql = $sql." AND (Status < 5)";
        }
        $sql = $sql." ORDER BY ProsjektAr, Prioritet";
      }
      $resultat = $this->db->query($sql);
      foreach ($resultat->result() as $rad) {
        $prosjekt['ID'] = $rad->ID;
        $prosjekt['DatoRegistrert'] = date("d.m.Y",strtotime($rad->DatoRegistrert));
        $prosjekt['ProsjektAr'] = $rad->ProsjektAr;
        $prosjekt['Navn'] = $rad->Navn;
        $prosjekt['FaggruppeID'] = $rad->FaggruppeID;
        $faggrupper = $this->db->query("SELECT * FROM faggrupper WHERE (ID=".$rad->FaggruppeID.") LIMIT 1");
        if ($faggruppe = $faggrupper->row()) {
          $prosjekt['Faggruppe'] = $faggruppe->Navn;
          unset($faggruppe);
        } else {
          $prosjekt['Faggruppe'] = "";
        }
        unset($faggrupper);
        $prosjekt['AnsvarligID'] = $rad->AnsvarligID;
        $medlemmer = $this->db->query("SELECT * FROM kon_personer,kon_medlemmer WHERE (kon_medlemmer.PersonID=kon_personer.ID) AND (kon_personer.ID=".$rad->AnsvarligID.") LIMIT 1");
        if ($medlem = $medlemmer->row()) {
          $prosjekt['Ansvarlig'] = $medlem->Fornavn." ".$medlem->Etternavn;
          unset($medlem);
        } else {
          $prosjekt['Ansvarlig'] = "";
        }
        unset($medlemmer);
        $prosjekt['KostnadTotal'] = $rad->KostnadTotal;
        $kommentarer = $this->db->query("SELECT * FROM pro_kommentarer WHERE (ProsjektID=".$rad->ID.") ORDER BY DatoRegistrert DESC");
        if ($kommentar = $kommentarer->row()) {
          $prosjekt['DatoOppdatert'] = date("d.m.Y H:i",strtotime($kommentar->DatoRegistrert));
        } else {
          $prosjekt['DatoOppdatert'] = $prosjekt['DatoRegistrert'];
        }
        $prosjekt['StatusID'] = $rad->Status;
        switch ($rad->Status) {
          case 0:
            $prosjekt['Status'] = "Registrert";
            break;
          case 1:
            $prosjekt['Status'] = "Under planlegging";
            break;
          case 2:
            $prosjekt['Status'] = "Til godkjenning";
            break;
          case 3:
            $prosjekt['Status'] = "Godkjent";
            break;
          case 4:
            $prosjekt['Status'] = "Påbegynt";
            break;
          case 5:
            $prosjekt['Status'] = "Fullført";
            break;
        }
        $prosjekter[] = $prosjekt;
        unset($prosjekt);
      }
      if (isset($prosjekter)) {
        return $prosjekter;
      } 
    }

    function prosjekt($ID) {
      $resultat = $this->db->query("SELECT * FROM pro_prosjekter WHERE (ID=".$ID.") LIMIT 1");
      if ($rad = $resultat->row()) {
        $prosjekt['ID'] = $rad->ID;
        $prosjekt['ProsjektAr'] = $rad->ProsjektAr;
        $prosjekt['FaggruppeID'] = $rad->FaggruppeID;
        $prosjekt['AnsvarligID'] = $rad->AnsvarligID;
        $prosjekt['Navn'] = $rad->Navn;
        $prosjekt['Beskrivelse'] = $rad->Beskrivelse;
        $prosjekt['Arbeidstimer'] = $rad->Arbeidstimer;
        $prosjekt['KostnadTotal'] = $rad->KostnadTotal;
        $resultat3 = $this->db->query("SELECT * FROM oko_innkjopsordre WHERE (ProsjektID=".$rad->ID.")");
        if ($ordre = $resultat3->row()) {
          $prosjekt['Ordre']['ID'] = $ordre->ID;
          $prosjekt['Ordre']['Sum'] = 0;
          $linjer = $this->db->query("SELECT * FROM oko_innkjopsordrelinjer WHERE (InnkjopsordreID=".$ordre->ID.")");
          foreach ($linjer->result() as $linje) {
            $prosjekt['Ordre']['Sum'] = $prosjekt['Ordre']['Sum'] + ($linje->Pris * $linje->Antall);
          }
          $prosjekt['Ordre']['Sum'] = str_replace('.',',',$prosjekt['Ordre']['Sum']);
        }
        $prosjekt['StatusID'] = $rad->Status;
        switch ($rad->Status) {
          case 0:
            $prosjekt['Status'] = "Registrert";
            break;
          case 1:
            $prosjekt['Status'] = "Under planlegging";
            break;
          case 2:
            $prosjekt['Status'] = "Til godkjenning";
            break;
          case 3:
            $prosjekt['Status'] = "Godkjent";
            break;
          case 4:
            $prosjekt['Status'] = "Påbegynt";
            break;
          case 5:
            $prosjekt['Status'] = "Fullført";
            break;
        }

        $resultat2 = $this->db->query("SELECT * FROM pro_kommentarer WHERE (ProsjektID=".$rad->ID.") AND (DatoSlettet Is Null) ORDER BY DatoRegistrert ASC");
        foreach ($resultat2->result() as $rad2) {
          $kommentar['DatoRegistrert'] = date("d.m.Y H:i",strtotime($rad2->DatoRegistrert));
	  $personer = $this->db->query("SELECT * FROM kon_personer WHERE (ID=".$rad2->PersonID.") LIMIT 1");
	  if ($person = $personer->row()) {
            $kommentar['Person']['ID'] = $person->ID;
	    $kommentar['Person']['Navn'] = $person->Fornavn." ".$person->Etternavn;
	  }
          $kommentar['Kommentar'] = $rad2->Kommentar;
          $kommentarer[] = $kommentar;
          unset($kommentar);
        }
        if (isset($kommentarer)) {
          $prosjekt['Kommentarer'] = $kommentarer;
        }
        return $prosjekt;
      }
    }

    function lagreprosjekt($prosjekt) {
      if (!isset($prosjekt['ID']) or ($prosjekt['ID'] == 0)) {
        $this->db->query("INSERT INTO pro_prosjekter (DatoRegistrert,Status) VALUES (Now(),1)");
        $prosjekt['ID'] = $this->db->insert_id();
        $this->db->query("INSERT INTO pro_kommentarer (ProsjektID,DatoRegistrert,Kommentar) VALUES (".$prosjekt['ID'].",Now(),'Prosjekt opprettet.')");
        $this->db->query("INSERT INTO oko_innkjopsordre (DatoRegistrert,DatoEndret,ProsjektID,Navn,Status,PersonID) VALUES (Now(),Now(),".$prosjekt['ID'].",'Prosjekt: ".$prosjekt['Navn']."',1,".$prosjekt['AnsvarligID'].")");
      }
      if (isset($prosjekt['ProsjektAr'])) { $this->db->query("UPDATE pro_prosjekter SET ProsjektAr='".$prosjekt['ProsjektAr']."' WHERE ID=".$prosjekt['ID']." LIMIT 1"); }
      if (isset($prosjekt['FaggruppeID'])) { $this->db->query("UPDATE pro_prosjekter SET FaggruppeID=".$prosjekt['FaggruppeID']." WHERE ID=".$prosjekt['ID']." LIMIT 1"); }
      if (isset($prosjekt['AnsvarligID'])) { $this->db->query("UPDATE pro_prosjekter SET AnsvarligID=".$prosjekt['AnsvarligID']." WHERE ID=".$prosjekt['ID']." LIMIT 1"); }
      if (isset($prosjekt['Navn'])) { $this->db->query("UPDATE pro_prosjekter SET Navn='".$prosjekt['Navn']."' WHERE ID=".$prosjekt['ID']." LIMIT 1"); }
      if (isset($prosjekt['Beskrivelse'])) { $this->db->query("UPDATE pro_prosjekter SET Beskrivelse='".$prosjekt['Beskrivelse']."' WHERE ID=".$prosjekt['ID']." LIMIT 1"); }
      if (isset($prosjekt['KostnadTotal'])) { $this->db->query("UPDATE pro_prosjekter SET KostnadTotal='".$prosjekt['KostnadTotal']."' WHERE ID=".$prosjekt['ID']." LIMIT 1"); }
      if (isset($prosjekt['Arbeidstimer'])) { $this->db->query("UPDATE pro_prosjekter SET Arbeidstimer='".$prosjekt['Arbeidstimer']."' WHERE ID=".$prosjekt['ID']." LIMIT 1"); }
      $this->db->query("UPDATE pro_prosjekter SET DatoEndret=Now() WHERE ID=".$prosjekt['ID']." LIMIT 1");
      $innkjopsordrer = $this->db->query("SELECT * FROM oko_innkjopsordre WHERE (ProsjektID=".$prosjekt['ID'].")");
      if ($innkjopsordrer->num_rows() > 0) {
        $this->db->query("UPDATE oko_innkjopsordre SET Navn='Prosjekt: ".$prosjekt['Navn']."' WHERE ProsjektID=".$prosjekt['ID']);
      }
      return $prosjekt;
    }

    function slettprosjekt($ID) {
      $this->db->query("UPDATE pro_prosjekter SET DatoSlettet=Now() WHERE ID=".$ID." LIMIT 1");
      $this->db->query("INSERT INTO pro_kommentarer (ProsjektID,DatoRegistrert,Kommentar) VALUES (".$ID.",Now(),'Prosjekt slettet.')");
      $this->db->query("UPDATE oko_innkjopsordre SET DatoSlettet=Now() WHERE ProsjektID=".$ID." LIMIT 1");
      $this->db->query("UPDATE pro_kommentarer SET DatoSlettet=Now() WHERE ProsjektID=".$ID);
    }

    function lagrekommentar($kommentar) {
      $this->db->query("INSERT INTO pro_kommentarer (ProsjektID,DatoRegistrert,PersonID,Kommentar) VALUES (".$kommentar['ProsjektID'].",Now(),'".$kommentar['PersonID']."','".$kommentar['Kommentar']."')");
    }

    function settprosjektstatus($data) {
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
    }

  }
?>
