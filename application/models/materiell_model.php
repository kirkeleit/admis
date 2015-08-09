<?php
  class Materiell_model extends CI_Model {

    var $ArrStatus = array(0 => "Ikke registrert", 1 => "Klar", 2 => "Klar / vedlikehold", 3 => "Ikke klar / vedlikehold", 4 => "Ikke klar / ødelagt", 5 => "Ikke klar / tapt");
    var $ArrTSStatus = array(1 => "Ny", 2 => "Under arbeid", 3 => "Ferdig");

    function grupper() {
      $rgrupper = $this->db->query("SELECT GruppeID,Navn,Beskrivelse,(SELECT COUNT(*) FROM Utstyrsliste WHERE (GruppeID=g.GruppeID)) AS Antall FROM Utstyrsgrupper g ORDER BY Navn ASC");
      foreach ($rgrupper->result_array() as $rgruppe) {
        $grupper[] = $rgruppe;
        unset($rgruppe);
      }
      unset($rgrupper);
      if (isset($grupper)) {
        return $grupper;
      }
    }

    function gruppe($ID) {
      $rgrupper = $this->db->query("SELECT GruppeID,Navn,Beskrivelse FROM Utstyrsgrupper WHERE (GruppeID=".$ID.") LIMIT 1");
      if ($rgruppe = $rgrupper->row_array()) {
        return $rgruppe;
      }
    }

    function lagregruppe($ID=null,$gruppe) {
      $gruppe['DatoEndret'] = date('Y-m-d H:i:s');
      if ($ID == null) {
        $gruppe['DatoRegistrert'] = $gruppe['DatoEndret'];
        $this->db->query($this->db->insert_string('Utstyrsgrupper',$gruppe));
        $gruppe['GruppeID'] = $this->db->insert_id();
      } else {
        $this->db->query($this->db->update_string('Utstyrsgrupper',$gruppe,'GruppeID='.$ID));
        $gruppe['GruppeID'] = $ID;
      }
      return $gruppe;
    }

    function produsenter() {
      $rprodusenter = $this->db->query("SELECT ProdusentID,Navn,(SELECT COUNT(*) FROM Utstyrsliste WHERE (ProdusentID=p.ProdusentID)) AS Antall FROM Produsenter p ORDER BY Navn ASC");
      foreach ($rprodusenter->result_array() as $rprodusent) {
        $produsenter[] = $rprodusent;
        unset($rprodusent);
      }
      if (isset($produsenter)) {
        return $produsenter;
      }
    }

    function produsent($ID) {
      $rprodusenter = $this->db->query("SELECT ProdusentID,Navn FROM Produsenter WHERE (ProdusentID=".$ID.") LIMIT 1");
      if ($rprodusent = $rprodusenter->row_array()) {
        return $rprodusent;
      }
    }

    function lagreprodusent($ID=null,$produsent) {
      $produsent['DatoEndret'] = date('Y-m-d H:i:s');
      if ($ID == null) {
        $produsent['DatoRegistrert'] = $produsent['DatoEndret'];
        $this->db->query($this->db->insert_string('Produsenter',$produsent));
        $produsent['ProdusentID'] = $this->db->insert_id();
      } else {
        $thos->db->query($this->db->update_string('Produsenter',$produsent,'ProdusentID='.$ID));
        $produsent['ProdusentID'] = $ID;
      }
      return $produsent;
    }

    function lagerplasser() {
      $rlagerplasser = $this->db->query("SELECT LagerplassID,Navn,Kode,(SELECT COUNT(*) FROM Utstyrsliste WHERE (LagerplassID=l.LagerplassID)) AS Antall FROM Lagerplasser l ORDER BY Kode ASC");
      foreach ($rlagerplasser->result_array() as $rlagerplass) {
        $rlagerplass['Kasser'] = $this->utstyrskasser(array('LagerplassID' => $rlagerplass['LagerplassID']));
        $lagerplasser[] = $rlagerplass;
        unset($rlagerplass);
      }
      if (isset($lagerplasser)) {
        return $lagerplasser;
      }
    }

    function lagerplass($ID) {
      $rlagerplasser = $this->db->query("SELECT LagerplassID,Navn,Kode,Beskrivelse FROM Lagerplasser WHERE (LagerplassID=".$ID.") LIMIT 1");
      if ($lagerplass = $rlagerplasser->row_array()) {
        return $lagerplass;
      }
    }

    function lagrelagerplass($ID=null,$lagerplass) {
      $lagerplass['DatoEndret'] = date('Y-m-d H:i:s');
      if ($ID == null) {
        $lagerplass['DatoRegistrert'] = $lagerplass['DatoEndret'];
        $this->db->query($this->db->insert_string('Lagerplasser',$lagerplass));
        $lagerplass['LagerplassID'] = $this->db->insert_id();
      } else {
        $this->db->query($this->db->update_string('Lagerplasser',$lagerplass,'LagerplassID='.$ID));
        $lagerplass['LagerplassID'] = $ID;
      }
      return $lagerplass;
    }

    function utstyrstyper() {
      $rutstyrstyper = $this->db->query("SELECT TypeID,Navn,(SELECT COUNT(*) FROM Utstyrsliste WHERE (TypeID=t.TypeID)) AS Antall FROM Utstyrstyper t ORDER BY Navn ASC");
      foreach ($rutstyrstyper->result_array() as $utstyrstype) {
        $utstyrstyper[] = $utstyrstype;
      }
      if (isset($utstyrstyper)) {
        return $utstyrstyper;
      }
    }

    function utstyrstype($ID) {
      $rutstyrstype = $this->db->query("SELECT TypeID,Navn FROM Utstyrstyper WHERE (TypeID=".$ID.") LIMIT 1");
      if ($utstyrstype = $rutstyrstype->row_array()) {
        return $utstyrstype;
      }
    }

    function lagreutstyrstype($ID=null,$utstyrstype) {
      $utstyrstype['DatoEndret'] = date('Y-m-d H:i:s');
      if ($ID == null) {
        $utstyrstype['DatoRegistrert'] = $utstyrstype['DatoEndret'];
        $this->db->query($this->db->insert_string('Utstyrstyper',$utstyrstype));
        $utstyrstype['TypeID'] = $this->db->insert_id();
      } else {
        $this->db->query($this->db->update_string('Utstyrstyper',$utstyrstype,'TypeID='.$ID));
        $utstyrstype['TypeID'] = $ID;
      }
      return $utstyrstype;
    }

    function utstyrsliste($filter = NULL) {
      if ($filter == NULL) {
        $sql = "SELECT * FROM Utstyrsliste WHERE (DatoSlettet Is Null) ORDER BY UtstyrID ASC";
      } else {
        $sql = "SELECT * FROM Utstyrsliste WHERE 1";
        if (isset($filter['FaggruppeID'])) {
          $sql = $sql." AND (FaggruppeID=".$filter['FaggruppeID'].")";
        }
        if (isset($filter['GruppeID'])) {
          $sql = $sql." AND (GruppeID=".$filter['GruppeID'].")";
        }
        if (isset($filter['TypeID'])) {
          $sql = $sql." AND (TypeID=".$filter['TypeID'].")";
        }
        if (isset($filter['ProdusentID'])) {
          $sql = $sql." AND (ProdusentID=".$filter['ProdusentID'].")";
        }
        if (isset($filter['LagerplassID'])) {
          $sql = $sql." AND (LagerplassID=".$filter['LagerplassID'].")";
        }
        if (isset($filter['KasseID'])) {
          $sql = $sql." AND (KasseID=".$filter['KasseID'].")";
        }
        $sql = $sql." ORDER BY LENGTH(UtstyrID), UtstyrID ASC";
      }
      $resultat = $this->db->query($sql);
      foreach ($resultat->result() as $rad) {
        $utstyr['UtstyrID'] = $rad->UtstyrID;
        $utstyr['UID'] = str_pad($rad->UtstyrID, 4, "0", STR_PAD_LEFT);
        $utstyr['Navn'] = str_pad($rad->UtstyrID, 4, "0", STR_PAD_LEFT);
	$utstyr['FaggruppeID'] = $rad->FaggruppeID;
        $grupper = $this->db->query("SELECT * FROM Utstyrsgrupper WHERE (GruppeID=".$rad->GruppeID.") LIMIT 1");
        if ($gruppe = $grupper->row()) {
          $utstyr['GruppeID'] = $gruppe->GruppeID;
          $utstyr['GruppeNavn'] = $gruppe->Navn;
          unset($type);
        }
        unset($grupper);
        $typer = $this->db->query("SELECT * FROM Utstyrstyper WHERE (TypeID=".$rad->TypeID.") LIMIT 1");
        if ($type = $typer->row()) {
          $utstyr['TypeID'] = $type->TypeID;
          $utstyr['TypeNavn'] = $type->Navn;
          unset($type);
        }
        unset($typer);
        $produsenter = $this->db->query("SELECT * FROM Produsenter WHERE (ProdusentID=".$rad->ProdusentID.") LIMIT 1");
        if ($produsent = $produsenter->row()) {
          $utstyr['ProdusentID'] = $produsent->ProdusentID;
          $utstyr['ProdusentNavn'] = $produsent->Navn;
          $utstyr['Navn'] = $utstyr['Navn']." ".$produsent->Navn;
          unset($produsent);
        }
        unset($produsenter);
	$utstyr['DatoAnskaffet'] = $rad->DatoAnskaffet;
	$utstyr['Modell'] = $rad->Modell;
        $utstyr['Navn'] = $utstyr['Navn']." ".$utstyr['Modell'];
        if (isset($utstyr['TypeNavn'])) {
          $utstyr['Navn'] = $utstyr['Navn']." (".$utstyr['TypeNavn'].")";
        }
	$utstyr['Serienummer'] = $rad->Serienummer;
        $lagerplasser = $this->db->query("SELECT * FROM Lagerplasser WHERE (LagerplassID=".$rad->LagerplassID.") LIMIT 1");
        if ($lagerplass = $lagerplasser->row()) {
          $utstyr['LagerplassID'] = $lagerplass->LagerplassID;
          $utstyr['LagerplassNavn'] = $lagerplass->Kode." ".$lagerplass->Navn;
          $utstyr['UID'] = $lagerplass->Kode.$utstyr['UID'];
          $utstyr['Navn'] = $lagerplass->Kode.$utstyr['Navn'];
          unset($lagerplass);
        }
        unset($lagerplasser);
        $kasser = $this->db->query("SELECT * FROM Lagerkasser WHERE (KasseID=".$rad->KasseID.") LIMIT 1");
        if ($kasse = $kasser->row()) {
          $utstyr['KasseID'] = $kasse->KasseID;
          $utstyr['KasseNavn'] = $kasse->Navn;
          unset($kasse);
        }
        unset($kasser);
        $tsrapporter = $this->db->query("SELECT TapSkadeRapportID FROM TapSkadeRapporter WHERE (UtstyrID=".$rad->UtstyrID.") ORDER BY DatoRegistrert DESC");
        if ($tsrapport = $tsrapporter->row()) {
          $utstyr['TSRapportID'] = $tsrapport->TapSkadeRapportID;
          unset($tsrapport);
        }
        unset($tsrapporter);
	$utstyr['StatusID'] = $rad->StatusID;
        $utstyr['Status'] = $this->ArrStatus[$rad->StatusID];
	$utstyrsliste[] = $utstyr;
	unset($utstyr);
      }
      if (isset($utstyrsliste)) {
        return $utstyrsliste;
      }
    }

    function utstyr($ID = NULL) {
      if ($ID != NULL) {
        $resultat = $this->db->query("SELECT * FROM Utstyrsliste WHERE (UtstyrID=".$ID.") LIMIT 1");
        if ($rad = $resultat->row()) {
          $utstyr['UtstyrID'] = $rad->UtstyrID;
          $utstyr['UID'] = str_pad($rad->UtstyrID, 4, "0", STR_PAD_LEFT);
          $utstyr['Navn'] = str_pad($rad->UtstyrID, 4, "0", STR_PAD_LEFT);
          $utstyr['FaggruppeID'] = $rad->FaggruppeID;
          $utstyr['GruppeID'] = $rad->GruppeID;
          $grupper = $this->db->query("SELECT * FROM Utstyrsgrupper WHERE (GruppeID=".$rad->GruppeID.") LIMIT 1");
          if ($gruppe = $grupper->row()) {
            $utstyr['GruppeNavn'] = $gruppe->Navn;
            unset($gruppe);
          }
          unset($grupper);
          $utstyr['TypeID'] = $rad->TypeID;
          $typer = $this->db->query("SELECT * FROM Utstyrstyper WHERE (TypeID=".$rad->TypeID.") LIMIT 1");
          if ($type = $typer->row()) {
            $utstyr['TypeNavn'] = $type->Navn;
            unset($type);
          }
          unset($typer);
          $utstyr['ProdusentID'] = $rad->ProdusentID;
          $produsenter = $this->db->query("SELECT * FROM Produsenter WHERE (ProdusentID=".$rad->ProdusentID.") LIMIT 1");
          if ($produsent = $produsenter->row()) {
            $utstyr['ProdusentNavn'] = $produsent->Navn;
            $utstyr['Navn'] = $utstyr['Navn']." ".$produsent->Navn;
            unset($produsent);
          }
          $utstyr['ProdusentID'] = $rad->ProdusentID;
          $utstyr['LeverandorID'] = $rad->LeverandorID;
          $utstyr['DatoAnskaffet'] = $rad->DatoAnskaffet;
          $utstyr['Modell'] = $rad->Modell;
          $utstyr['Navn'] = $utstyr['Navn']." ".$rad->Modell;
          $utstyr['Serienummer'] = $rad->Serienummer;
          $utstyr['Notater'] = $rad->Notater;
          $utstyr['Kostnad'] = $rad->Kostnad;
          $utstyr['LagerplassID'] = $rad->LagerplassID;
          $lagerplasser = $this->db->query("SELECT * FROM Lagerplasser WHERE (LagerplassID=".$rad->LagerplassID.") LIMIT 1");
          if ($lagerplass = $lagerplasser->row()) {
            $utstyr['LagerplassNavn'] = $lagerplass->Kode." ".$lagerplass->Navn;
            $utstyr['UID'] = $lagerplass->Kode.$utstyr['UID'];
            $utstyr['Navn'] = $lagerplass->Kode.$utstyr['Navn'];
            unset($lagerplass);
          }
          unset($lagerplasser);
          $kasser = $this->db->query("SELECT * FROM Lagerkasser WHERE (KasseID=".$rad->KasseID.") LIMIT 1");
          if ($kasse = $kasser->row()) {
            $utstyr['KasseNavn'] = $kasse->Navn;
            unset($kasse);
          }
          unset($kasser);
          $utstyr['Lagerplass'] = $rad->LagerplassID.".".$rad->KasseID;
          $utstyr['StatusID'] = $rad->StatusID;
          $utstyr['Status'] = $this->ArrStatus[$rad->StatusID];
        }
        return $utstyr;
      }
    }

    function lagreutstyr($utstyr) {
      if ($utstyr['ID'] == 0) {
        $this->db->query("INSERT INTO mat_utstyr (DatoRegistrert) VALUES (Now())");
	$utstyr['ID'] = $this->db->insert_id();
      }
      $this->db->query("UPDATE mat_utstyr SET FaggruppeID=".$utstyr['FaggruppeID']." WHERE ID=".$utstyr['ID']." LIMIT 1");
      $this->db->query("UPDATE mat_utstyr SET GruppeID=".$utstyr['GruppeID']." WHERE ID=".$utstyr['ID']." LIMIT 1");
      $this->db->query("UPDATE mat_utstyr SET TypeID=".$utstyr['TypeID']." WHERE ID=".$utstyr['ID']." LIMIT 1");
      $this->db->query("UPDATE mat_utstyr SET ProdusentID=".$utstyr['ProdusentID']." WHERE ID=".$utstyr['ID']." LIMIT 1");
      $this->db->query("UPDATE mat_utstyr SET LeverandorID=".$utstyr['LeverandorID']." WHERE ID=".$utstyr['ID']." LIMIT 1");
      if ($utstyr['DatoAnskaffet'] == "") {
        $this->db->query("UPDATE mat_utstyr SET DatoAnskaffet='' WHERE ID=".$utstyr['ID']." LIMIT 1");
      } else {
        $this->db->query("UPDATE mat_utstyr SET DatoAnskaffet='".date('Y-m-d',strtotime($utstyr['DatoAnskaffet']))."' WHERE ID=".$utstyr['ID']." LIMIT 1");
      }
      $this->db->query("UPDATE mat_utstyr SET Modell='".$utstyr['Modell']."' WHERE ID=".$utstyr['ID']." LIMIT 1");
      $this->db->query("UPDATE mat_utstyr SET Serienummer='".$utstyr['Serienummer']."' WHERE ID=".$utstyr['ID']." LIMIT 1");
      $this->db->query("UPDATE mat_utstyr SET Notater='".$utstyr['Notater']."' WHERE ID=".$utstyr['ID']." LIMIT 1");
      $this->db->query("UPDATE mat_utstyr SET Kostnad='".$utstyr['Kostnad']."' WHERE ID=".$utstyr['ID']." LIMIT 1");
      $this->db->query("UPDATE mat_utstyr SET LagerID=".$utstyr['LagerID']." WHERE ID=".$utstyr['ID']." LIMIT 1");
      $this->db->query("UPDATE mat_utstyr SET KasseID=".$utstyr['KasseID']." WHERE ID=".$utstyr['ID']." LIMIT 1");
      $this->db->query("UPDATE mat_utstyr SET DatoEndret=Now() WHERE ID=".$utstyr['ID']." LIMIT 1");
      return $utstyr;
    }

    function utstyrskasser($filter = NULL) {
      if ($filter == NULL) {
        $sql = "SELECT KasseID,Navn,LagerplassID,(SELECT COUNT(*) FROM Utstyrsliste WHERE (KasseID=k.KasseID)) AS Antall FROM Lagerkasser k ORDER BY ID";
      } else {
        $sql = "SELECT KasseID,Navn,LagerplassID,(SELECT COUNT(*) FROM Utstyrsliste WHERE (KasseID=k.KasseID)) AS Antall FROM Lagerkasser k WHERE 1";
        if (isset($filter['LagerplassID'])) {
          $sql = $sql." AND (LagerplassID=".$filter['LagerplassID'].")";
        }
        $sql = $sql." ORDER BY KasseID";
      }
      $rkasser = $this->db->query($sql);
      foreach ($rkasser->result_array() as $kasse) {
        $kasser[] = $kasse;
      }
      if (isset($kasser)) {
        return $kasser;
      }
    }

    function settutstyrsstatus($data) {
      $this->db->query("UPDATE mat_utstyr SET Status=".$data['Status']." WHERE ID=".$data['ID']." LIMIT 1");
    }

    function tsrapport($ID) {
      $rrapporter = $this->db->query("SELECT TapSkadeRapportID,Skadetype,PersonRapportertID,UtstyrID,Hva,Hvordan,Losning,Notater,StatusID FROM TapSkadeRapporter WHERE (TapSkadeRapportID=".$ID.") LIMIT 1");
      if ($rapport = $rrapporter->row_array()) {
        $rapport['Status'] = $this->ArrTSStatus[$rapport['StatusID']];
        return $rapport;
      }
    }

    function lagretsrapport($rapport) {
      if ($rapport['TapSkadeRapportID'] == 0) {
        $this->db->query("INSERT INTO TapSkadeRapporter (DatoRegistrert,StatusID) VALUES (Now(),1)");
        $rapport['TapSkadeRapportID'] = $this->db->insert_id();
      }
      $this->db->query("UPDATE TapSkadeRapporter SET Skadetype=".$rapport['Skadetype']." WHERE TapSkadeRapportID=".$rapport['TapSkadeRapportID']." LIMIT 1");
      $this->db->query("UPDATE TapSkadeRapporter SET PersonRapportertID=".$rapport['PersonRapportertID']." WHERE TapSkadeRapportID=".$rapport['TapSkadeRapportID']." LIMIT 1");
      $this->db->query("UPDATE TapSkadeRapporter SET UtstyrID=".$rapport['UtstyrID']." WHERE TapSkadeRapportID=".$rapport['TapSkadeRapportID']." LIMIT 1");
      $this->db->query("UPDATE TapSkadeRapporter SET Hva='".$rapport['Hva']."' WHERE TapSkadeRapportID=".$rapport['TapSkadeRapportID']." LIMIT 1");
      $this->db->query("UPDATE TapSkadeRapporter SET Hvordan='".$rapport['Hvordan']."' WHERE TapSkadeRapportID=".$rapport['TapSkadeRapportID']." LIMIT 1");
      $this->db->query("UPDATE TapSkadeRapporter SET Losning='".$rapport['Losning']."' WHERE TapSkadeRapportID=".$rapport['TapSkadeRapportID']." LIMIT 1");
      $this->db->query("UPDATE TapSkadeRapporter SET Notater='".$rapport['Notater']."' WHERE TapSkadeRapportID=".$rapport['TapSkadeRapportID']." LIMIT 1");
      $this->db->query("UPDATE TapSkadeRapporter SET DatoEndret=Now() WHERE TapSkadeRapportID=".$rapport['TapSkadeRapportID']." LIMIT 1");
      if ($rapport['UtstyrID'] > 0) {
        switch ($rapport['Skadetype']) {
          case 0:
            $this->db->query("UPDATE Utstyrsliste SET Status=2 WHERE ID=".$rapport['UtstyrID']." LIMIT 1");
            break;
          case 2:
            $this->db->query("UPDATE Utstyrsliste SET Status=4 WHERE ID=".$rapport['UtstyrID']." LIMIT 1");
            break;
          case 3:
            $this->db->query("UPDATE Utstyrsliste SET Status=5 WHERE ID=".$rapport['UtstyrID']." LIMIT 1");
            break;
        }
      }

      $ci=& get_instance();
      $ci->load->model('Oppgaver_model');
      $ci->Oppgaver_model->lagreoppgave(array('Tittel' => 'Reparasjon/vedlikehold av utstyr','Beskrivelse' => 'Følgende utstyr har behov for reparasjon/vedlikehold: '.$rapport['UtstyrID'],'PersonAnsvarligID' => $rapport['PersonRapportertID']));

      return $rapport;
    }

    function tsrapporter() {
      $rrapporter = $this->db->query("SELECT TapSkadeRapportID,DatoRegistrert,PersonRapportertID,(SELECT Fornavn FROM Personer WHERE (PersonID=ts.PersonRapportertID) LIMIT 1) AS PersonRapportertNavn,UtstyrID,Skadetype,StatusID FROM TapSkadeRapporter ts ORDER BY DatoRegistrert ASC");
      foreach ($rrapporter->result_array() as $rapport) {
        if ($rapport['UtstyrID'] > 0) {
          $utstyr = $this->utstyr($rapport['UtstyrID']);
          $rapport['UID'] = $utstyr['UID'];
          $rapport['UtstyrNavn'] = $utstyr['Navn'];
        } else {
          $rapport['UID'] = "&nbsp;";
          $rapport['UtstyrNavn'] = "Privat utstyr";
        }
        $rapport['Status'] = $this->ArrTSStatus[$rapport['StatusID']];
        $rapporter[] = $rapport;
      }
      return $rapporter;
    }

    function vedlikeholdslogger($ID) {
      $rlogger = $this->db->query("SELECT VedlikeholdID,UtstyrID,DatoRegistrert,PersonID,(SELECT Fornavn FROM Personer WHERE (PersonID=v.PersonID)) AS PersonNavn,Notat,NyStatusID FROM Vedlikehold v WHERE (UtstyrID=".$ID.") ORDER BY DatoRegistrert ASC");
      foreach ($rlogger->result_array() as $logg) {
        $logg['NyStatus'] = $this->ArrStatus[$logg['NyStatusID']];
        $logger[] = $logg;
      }
      if (isset($logger)) {
        return $logger;
      }
    }

    function lagrevedlikehold($data) {
      $logg = array('UtstyrID' => $data['UtstyrID'], 'DatoRegistrert' => date('Y-m-d H:i:s'), 'DatoEndret' => date('Y-m-d H:i:s'), 'PersonID' => $data['PersonID'], 'Notat' => $data['Vedlikehold'], 'NyStatusID' => $data['StatusID']);
      $this->db->query($this->db->insert_string('Vedlikehold',$logg));
      if ($data['StatusID'] > 0) {
        $utstyr = array('StatusID' => $data['StatusID'], 'DatoEndret' => date('Y-m-d H:i:s'));
        $this->db->query($this->db->update_string('Utstyrsliste',$utstyr,'UtstyrID='.$data['UtstyrID']));
      }
      if ($data['StatusID'] = 1) {
        $this->db->query($this->db->update_string('TapSkadeRapporter',array('StatusID' => '3'),'UtstyrID='.$data['UtstyrID']));
      } elseif ($data['StatusID'] > 1) {
        $this->db->query($this->db->update_string('TapSkadeRapporter',array('StatusID' => '2'),'UtstyrID='.$data['UtstyrID']));
      }
    }

  }
?>
