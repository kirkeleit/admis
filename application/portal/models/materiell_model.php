<?php
  class Materiell_model extends CI_Model {

    var $ArrStatus = array(0 => "Ikke registrert", 1 => "Klar", 2 => "Klar / vedlikehold", 3 => "Ikke klar / vedlikehold", 4 => "Ikke klar / ødelagt", 5 => "Ikke klar / tapt");
    var $ArrTSStatus = array(1 => "Ny", 2 => "Under arbeid", 3 => "Ferdig");

    function grupper() {
      $rgrupper = $this->db->query("SELECT ID,Navn,(SELECT COUNT(*) FROM mat_utstyr WHERE (GruppeID=g.ID)) AS Antall FROM mat_grupper g ORDER BY Navn ASC");
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
      $rgrupper = $this->db->query("SELECT ID,Navn,Beskrivelse FROM mat_grupper WHERE (ID=".$ID.") LIMIT 1");
      if ($rgruppe = $rgrupper->row_array()) {
        return $rgruppe;
      }
    }

    function lagregruppe($gruppe) {
      if ($gruppe['ID'] == 0) {
        $this->db->query("INSERT INTO mat_grupper (DatoRegistrert) VALUES (Now())");
        $gruppe['ID'] = $this->db->insert_id();
      }
      $this->db->query("UPDATE mat_grupper SET Navn='".$gruppe['Navn']."' WHERE ID=".$gruppe['ID']." LIMIT 1");
      $this->db->query("UPDATE mat_grupper SET Beskrivelse='".$gruppe['Beskrivelse']."' WHERE ID=".$gruppe['ID']." LIMIT 1");
      $this->db->query("UPDATE mat_grupper SET DatoEndret=Now() WHERE ID=".$gruppe['ID']." LIMIT 1");
    }

    function produsenter() {
      $rprodusenter = $this->db->query("SELECT ID,Navn,(SELECT COUNT(ID) FROM mat_utstyr WHERE (ProdusentID=p.ID)) AS Antall FROM mat_produsenter p ORDER BY Navn ASC");
      foreach ($rprodusenter->result_array() as $rprodusent) {
        $produsenter[] = $rprodusent;
        unset($rprodusent);
      }
      if (isset($produsenter)) {
        return $produsenter;
      }
    }

    function produsent($ID) {
      $rprodusenter = $this->db->query("SELECT ID,Navn FROM mat_produsenter WHERE (ID=".$ID.") LIMIT 1");
      if ($rprodusent = $rprodusenter->row_array()) {
        return $rprodusent;
      }
    }

    function lagreprodusent($produsent) {
      if ($produsent['ID'] == 0) {
        $this->db->query("INSERT INTO mat_produsenter (DatoRegistrert) VALUES (Now())");
        $produsent['ID'] = $this->db->insert_id();
      }
      $this->db->query("UPDATE mat_produsenter SET Navn='".$produsent['Navn']."' WHERE ID=".$produsent['ID']." LIMIT 1");
      $this->db->query("UPDATE mat_produsenter SET DatoEndret=Now() WHERE ID=".$produsent['ID']." LIMIT 1");
    }

    function lagerplasser() {
      $rlagerplasser = $this->db->query("SELECT ID,Navn,Kode,(SELECT COUNT(*) FROM mat_utstyr WHERE (LagerID=l.ID)) AS Antall FROM mat_lagerplasser l ORDER BY Kode ASC");
      foreach ($rlagerplasser->result_array() as $rlagerplass) {
        $rlagerplass['Kasser'] = $this->utstyrskasser(array('LagerID' => $rlagerplass['ID']));
        $lagerplasser[] = $rlagerplass;
        unset($rlagerplass);
      }
      if (isset($lagerplasser)) {
        return $lagerplasser;
      }
    }

    function lagerplass($ID) {
      $rlagerplasser = $this->db->query("SELECT ID,Navn,Kode,Beskrivelse FROM mat_lagerplasser WHERE (ID=".$ID.") LIMIT 1");
      if ($lagerplass = $rlagerplasser->row_array()) {
        return $lagerplass;
      }
    }

    function lagrelagerplass($lagerplass) {
      if ($lagerplass['ID'] == 0) {
        $this->db->query("INSERT INTO mat_lagerplasser (DatoRegistrert) VALUES (Now())");
        $lagerplass['ID'] = $this->db->insert_id();
      }
      $this->db->query("UPDATE mat_lagerplasser SET Navn='".$lagerplass['Navn']."' WHERE ID=".$lagerplass['ID']." LIMIT 1");
      $this->db->query("UPDATE mat_lagerplasser SET Kode='".$lagerplass['Kode']."' WHERE ID=".$lagerplass['ID']." LIMIT 1");
      $this->db->query("UPDATE mat_lagerplasser SET Beskrivelse='".$lagerplass['Beskrivelse']."' WHERE ID=".$lagerplass['ID']." LIMIT 1");
      $this->db->query("UPDATE mat_lagerplasser SET DatoEndret=Now() WHERE ID=".$lagerplass['ID']." LIMIT 1");
    }

    function utstyrstyper() {
      $rutstyrstyper = $this->db->query("SELECT ID,Navn,(SELECT COUNT(*) FROM mat_utstyr WHERE (TypeID=t.ID)) AS Antall FROM mat_utstyrstyper t ORDER BY Navn ASC");
      foreach ($rutstyrstyper->result_array() as $utstyrstype) {
        $utstyrstyper[] = $utstyrstype;
      }
      if (isset($utstyrstyper)) {
        return $utstyrstyper;
      }
    }

    function utstyrstype($ID) {
      $rutstyrstype = $this->db->query("SELECT ID,Navn FROM mat_utstyrstyper WHERE (ID=".$ID.") LIMIT 1");
      if ($utstyrstype = $rutstyrstype->row_array()) {
        return $utstyrstype;
      }
    }

    function lagreutstyrstype($utstyrstype) {
      if ($utstyrstype['ID'] == 0) {
        $this->db->query("INSERT INTO mat_utstyrstyper (DatoRegistrert) VALUES (Now())");
        $utstyrstype['ID'] = $this->db->insert_id();
      }
      $this->db->query("UPDATE mat_utstyrstyper SET Navn='".$utstyrstype['Navn']."' WHERE ID=".$utstyrstype['ID']." LIMIT 1");
      $this->db->query("UPDATE mat_utstyrstyper SET DatoEndret=Now() WHERE ID=".$utstyrstype['ID']." LIMIT 1");
    }

    function utstyrsliste($filter = NULL) {
      if ($filter == NULL) {
        $sql = "SELECT * FROM mat_utstyr WHERE (DatoSlettet Is Null) ORDER BY ID ASC";
      } else {
        $sql = "SELECT * FROM mat_utstyr WHERE 1";
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
        if (isset($filter['LagerID'])) {
          $sql = $sql." AND (LagerID=".$filter['LagerID'].")";
        }
        if (isset($filter['KasseID'])) {
          $sql = $sql." AND (KasseID=".$filter['KasseID'].")";
        }
        $sql = $sql." ORDER BY LENGTH(ID), ID ASC";
      }
      $resultat = $this->db->query($sql);
      foreach ($resultat->result() as $rad) {
        $utstyr['ID'] = $rad->ID;
        $utstyr['UID'] = str_pad($rad->ID, 4, "0", STR_PAD_LEFT);
        $utstyr['Navn'] = str_pad($rad->ID, 4, "0", STR_PAD_LEFT);
	$utstyr['FaggruppeID'] = $rad->FaggruppeID;
        $grupper = $this->db->query("SELECT * FROM mat_grupper WHERE (ID=".$rad->GruppeID.") LIMIT 1");
        if ($gruppe = $grupper->row()) {
          $utstyr['Gruppe']['ID'] = $gruppe->ID;
          $utstyr['Gruppe']['Navn'] = $gruppe->Navn;
          unset($type);
        }
        unset($grupper);
        $typer = $this->db->query("SELECT * FROM mat_utstyrstyper WHERE (ID=".$rad->TypeID.") LIMIT 1");
        if ($type = $typer->row()) {
          $utstyr['Type']['ID'] = $type->ID;
          $utstyr['Type']['Navn'] = $type->Navn;
          unset($type);
        }
        unset($typer);
        $produsenter = $this->db->query("SELECT * FROM mat_produsenter WHERE (ID=".$rad->ProdusentID.") LIMIT 1");
        if ($produsent = $produsenter->row()) {
          $utstyr['Produsent']['ID'] = $produsent->ID;
          $utstyr['Produsent']['Navn'] = $produsent->Navn;
          $utstyr['Navn'] = $utstyr['Navn']." ".$produsent->Navn;
          unset($produsent);
        }
        unset($produsenter);
        if ($rad->DatoAnskaffet == "0000-00-00") {
          $utstyr['DatoAnskaffet'] = "";
        } else {
	  $utstyr['DatoAnskaffet'] = date('d.m.Y',strtotime($rad->DatoAnskaffet));
        }
	$utstyr['Modell'] = $rad->Modell;
        $utstyr['Navn'] = $utstyr['Navn']." ".$utstyr['Modell'];
        if (isset($utstyr['Type']['Navn'])) {
          $utstyr['Navn'] = $utstyr['Navn']." (".$utstyr['Type']['Navn'].")";
        }
	$utstyr['Serienummer'] = $rad->Serienummer;
        $lagerplasser = $this->db->query("SELECT * FROM mat_lagerplasser WHERE (ID=".$rad->LagerID.") LIMIT 1");
        if ($lagerplass = $lagerplasser->row()) {
          $utstyr['Lagerplass']['ID'] = $lagerplass->ID;
          $utstyr['Lagerplass']['Navn'] = $lagerplass->Kode." ".$lagerplass->Navn;
          $utstyr['UID'] = $lagerplass->Kode.$utstyr['UID'];
          $utstyr['Navn'] = $lagerplass->Kode.$utstyr['Navn'];
          unset($lagerplass);
        }
        unset($lagerplasser);
        $kasser = $this->db->query("SELECT * FROM mat_kasser WHERE (ID=".$rad->KasseID.") LIMIT 1");
        if ($kasse = $kasser->row()) {
          $utstyr['Kasse']['ID'] = $kasse->ID;
          $utstyr['Kasse']['Navn'] = $kasse->Navn;
          unset($kasse);
        }
        unset($kasser);
        $tsrapporter = $this->db->query("SELECT * FROM mat_tsrapporter WHERE (UtstyrID=".$rad->ID.") ORDER BY DatoRegistrert DESC");
        if ($tsrapport = $tsrapporter->row()) {
          $utstyr['TSRapportID'] = $tsrapport->ID;
          unset($tsrapport);
        }
        unset($tsrapporter);
	$utstyr['StatusID'] = $rad->Status;
        $utstyr['Status'] = $this->ArrStatus[$rad->Status];
	$utstyrsliste[] = $utstyr;
	unset($utstyr);
      }
      if (isset($utstyrsliste)) {
        return $utstyrsliste;
      }
    }

    function utstyr($ID = NULL) {
      if ($ID != NULL) {
        $resultat = $this->db->query("SELECT * FROM mat_utstyr WHERE (ID=".$ID.") LIMIT 1");
        if ($rad = $resultat->row()) {
          $utstyr['ID'] = $rad->ID;
          $utstyr['UID'] = str_pad($rad->ID, 4, "0", STR_PAD_LEFT);
          $utstyr['FaggruppeID'] = $rad->FaggruppeID;
          $utstyr['GruppeID'] = $rad->GruppeID;
          $utstyr['TypeID'] = $rad->TypeID;
          $utstyr['ProdusentID'] = $rad->ProdusentID;
          $utstyr['LeverandorID'] = $rad->LeverandorID;
          if ($rad->DatoAnskaffet == "0000-00-00") {
            $utstyr['DatoAnskaffet'] = "";
          } else {
            $utstyr['DatoAnskaffet'] = date('d.m.Y',strtotime($rad->DatoAnskaffet));
          }
          $utstyr['Modell'] = $rad->Modell;
          $utstyr['Serienummer'] = $rad->Serienummer;
          $utstyr['Notater'] = $rad->Notater;
          $utstyr['Kostnad'] = $rad->Kostnad;
          $utstyr['LagerID'] = $rad->LagerID;
          $lagerplasser = $this->db->query("SELECT * FROM mat_lagerplasser WHERE (ID=".$rad->LagerID.") LIMIT 1");
          if ($lagerplass = $lagerplasser->row()) {
            $utstyr['LagerplassNavn'] = $lagerplass->Kode." ".$lagerplass->Navn;
            $utstyr['UID'] = $lagerplass->Kode.$utstyr['UID'];
            unset($lagerplass);
          }
          unset($lagerplasser);
          $kasser = $this->db->query("SELECT * FROM mat_kasser WHERE (ID=".$rad->KasseID.") LIMIT 1");
          if ($kasse = $kasser->row()) {
            $utstyr['KasseNavn'] = $kasse->Navn;
            unset($kasse);
          }
          unset($kasser);
          $utstyr['Lagerplass'] = $rad->LagerID.".".$rad->KasseID;
          $utstyr['StatusID'] = $rad->Status;
          $utstyr['Status'] = $this->ArrStatus[$rad->Status];
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
        $sql = "SELECT ID,Navn,LagerID,(SELECT COUNT(*) FROM mat_utstyr WHERE (KasseID=k.ID)) AS Antall FROM mat_kasser k ORDER BY ID";
      } else {
        $sql = "SELECT ID,Navn,LagerID,(SELECT COUNT(*) FROM mat_utstyr WHERE (KasseID=k.ID)) AS Antall FROM mat_kasser k WHERE 1";
        if (isset($filter['LagerID'])) {
          $sql = $sql." AND (LagerID=".$filter['LagerID'].")";
        }
        $sql = $sql." ORDER BY ID";
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
      $rrapporter = $this->db->query("SELECT ID,Skadetype,PersonID,UtstyrID,Hva,Hvordan,Losning,Notater,Status AS StatusID FROM mat_tsrapporter WHERE (ID=".$ID.") LIMIT 1");
      if ($rapport = $rrapporter->row_array()) {
        $rapport['Status'] = $this->ArrTSStatus[$rapport['StatusID']];
        return $rapport;
      }
    }

    function lagretsrapport($rapport) {
      if ($rapport['ID'] == 0) {
        $this->db->query("INSERT INTO mat_tsrapporter (DatoRegistrert,Status) VALUES (Now(),1)");
        $rapport['ID'] = $this->db->insert_id();
      }
      $this->db->query("UPDATE mat_tsrapporter SET Skadetype=".$rapport['Skadetype']." WHERE ID=".$rapport['ID']." LIMIT 1");
      $this->db->query("UPDATE mat_tsrapporter SET PersonID=".$rapport['PersonID']." WHERE ID=".$rapport['ID']." LIMIT 1");
      $this->db->query("UPDATE mat_tsrapporter SET UtstyrID=".$rapport['UtstyrID']." WHERE ID=".$rapport['ID']." LIMIT 1");
      $this->db->query("UPDATE mat_tsrapporter SET Hva='".$rapport['Hva']."' WHERE ID=".$rapport['ID']." LIMIT 1");
      $this->db->query("UPDATE mat_tsrapporter SET Hvordan='".$rapport['Hvordan']."' WHERE ID=".$rapport['ID']." LIMIT 1");
      $this->db->query("UPDATE mat_tsrapporter SET Losning='".$rapport['Losning']."' WHERE ID=".$rapport['ID']." LIMIT 1");
      $this->db->query("UPDATE mat_tsrapporter SET Notater='".$rapport['Notater']."' WHERE ID=".$rapport['ID']." LIMIT 1");
      $this->db->query("UPDATE mat_tsrapporter SET DatoEndret=Now() WHERE ID=".$rapport['ID']." LIMIT 1");
      if ($rapport['UtstyrID'] > 0) {
        switch ($rapport['Skadetype']) {
          case 0:
            $this->db->query("UPDATE mat_utstyr SET Status=2 WHERE ID=".$rapport['UtstyrID']." LIMIT 1");
            break;
          case 2:
            $this->db->query("UPDATE mat_utstyr SET Status=4 WHERE ID=".$rapport['UtstyrID']." LIMIT 1");
            break;
          case 3:
            $this->db->query("UPDATE mat_utstyr SET Status=5 WHERE ID=".$rapport['UtstyrID']." LIMIT 1");
            break;
        }
      }
      return $rapport;
    }

    function tsrapporter() {
      $rrapporter = $this->db->query("SELECT ID,DatoRegistrert,PersonID,Skadetype,Status AS StatusID FROM mat_tsrapporter ORDER BY DatoRegistrert ASC");
      foreach ($rrapporter->result_array() as $rapport) {
        $personer = $this->db->query("SELECT * FROM kon_personer WHERE (ID=".$rapport['PersonID'].") LIMIT 1");
        if ($person = $personer->row()) {
          $rapport['Person']['Navn'] = $person->Fornavn." ".$person->Etternavn;
          unset($person);
        }
        unset($personer);
        $rapport['Status'] = $this->ArrTSStatus[$rapport['StatusID']];
        $rapporter[] = $rapport;
      }
      return $rapporter;
    }

    function vedlikeholdslogger($ID) {
      $rlogger = $this->db->query("SELECT ID,UtstyrID,DatoRegistrert,PersonID,Notat FROM mat_vedlikehold WHERE (UtstyrID=".$ID.") ORDER BY DatoRegistrert ASC");
      foreach ($rlogger->result_array() as $logg) {
        $logger[] = $logg;
      }
      if (isset($logger)) {
        return $logger;
      }
    }

  }
?>
