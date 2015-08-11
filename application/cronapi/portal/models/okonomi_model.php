<?php
  class Okonomi_model extends CI_Model {

    function innkjopsordrer() {
      $resultat = $this->db->query("SELECT * FROM oko_innkjopsordre WHERE (DatoSlettet Is Null) AND (Status < 6) ORDER BY ID ASC");
      foreach ($resultat->result() as $rad) {
        $ordre['ID'] = $rad->ID;
        $ordre['DatoRegistrert'] = date('d.m.Y',strtotime($rad->DatoRegistrert));
        $ordre['DatoEndret'] = date('d.m.Y H:i',strtotime($rad->DatoEndret));
        $ordre['ProsjektID'] = $rad->ProsjektID;
        $ordre['Navn'] = $rad->Navn;
        $ordre['PersonID'] = $rad->PersonID;
        $personer = $this->db->query("SELECT * FROM kon_personer WHERE (ID=".$rad->PersonID.") LIMIT 1");
        if ($person = $personer->row()) {
          $ordre['PersonNavn'] = $person->Fornavn." ".$person->Etternavn;
          $ordre['PersonEpost'] = $person->Epost;
          unset($person);
        } else {
          $ordre['PersonNavn'] = "(ingen)";
          $ordre['PersonEpost'] = NULL;
        }
        unset($personer);
        $ordre['Linjer'] = 0;
        $ordre['Sum'] = 0;
        $resultat2 = $this->db->query("SELECT * FROM oko_innkjopsordrelinjer WHERE (InnkjopsordreID=".$rad->ID.") ORDER BY ID ASC");
        foreach ($resultat2->result() as $rad2) {
          $ordre['Linjer']++;
          $ordre['Sum'] = $ordre['Sum'] + ($rad2->Pris * $rad2->Antall);
        }
        $ordre['StatusID'] = $rad->Status;
        switch ($rad->Status) {
          case 0:
            $ordre['Status'] = "Registrert";
            break;
          case 1:
            $ordre['Status'] = "Under planlegging";
            break;
          case 2:
            $ordre['Status'] = "Til godkjenning";
            break;
          case 3:
            $ordre['Status'] = "Godkjent";
            break;
          case 4:
            $ordre['Status'] = "Bestilt";
            break;
          case 5:
            $ordre['Status'] = "Levert";
            break;
          case 6:
            $ordre['Status'] = "Fullført";
            break;
        }
        $ordrer[] = $ordre;
        unset($ordre);
      }
      if (isset($ordrer)) {
        return $ordrer;
      }
    }

    function innkjopsordre($ID) {
      $resultat = $this->db->query("SELECT * FROM oko_innkjopsordre WHERE (ID=".$ID.") LIMIT 1");
      if ($rad = $resultat->row()) {
        $ordre['ID'] = $rad->ID;
        $ordre['DatoRegistrert'] = date('d.m.Y H:i',strtotime($rad->DatoRegistrert));
        $ordre['DatoEndret'] = date('d.m.Y H:i',strtotime($rad->DatoEndret));
        $ordre['PersonID'] = $rad->PersonID;
        $personer = $this->db->query("SELECT * FROM kon_personer WHERE (ID=".$rad->PersonID.") LIMIT 1");
        if ($person = $personer->row()) {
          $ordre['PersonNavn'] = $person->Fornavn." ".$person->Etternavn;
          $ordre['PersonEpost'] = $person->Epost;
          unset($person);
        } else {
          $ordre['PersonNavn'] = "(ingen)";
          $ordre['PersonEpost'] = NULL;
        }
        unset($personer);
        $ordre['ProsjektID'] = $rad->ProsjektID;
        $ordre['LeverandorID'] = $rad->LeverandorID;
        $ordre['Navn'] = $rad->Navn;
        $ordre['Beskrivelse'] = $rad->Beskrivelse;
        $ordre['Sum'] = 0;
        $resultat2 = $this->db->query("SELECT * FROM oko_innkjopsordrelinjer WHERE (InnkjopsordreID=".$rad->ID.") ORDER BY ID ASC");
        foreach ($resultat2->result() as $rad2) {
          $linje['ID'] = $rad2->ID;
          $linje['LeverandorID'] = $rad2->LeverandorID;
          $organisasjoner = $this->db->query("SELECT * FROM kon_organisasjoner WHERE (ID=".$rad2->LeverandorID.")");
          if ($organisasjon = $organisasjoner->row()) {
            $linje['Leverandor'] = $organisasjon->Navn;
          } else {
            $linje['Leverandor'] = "n/a";
          }
          $linje['Varenummer'] = $rad2->Varenummer;
          $linje['Varenavn'] = $rad2->Varenavn;
          $linje['Pris'] = $rad2->Pris;
          $linje['Antall'] = $rad2->Antall;
          $linje['Sum'] = $rad2->Pris * $rad2->Antall;
          $ordre['Sum'] = $ordre['Sum'] + $linje['Sum'];
          $linjer[] = $linje;
          unset($linje);
        }
        if (isset($linjer)) {
          $ordre['Linjer'] = $linjer;
        }
        $ordre['StatusID'] = $rad->Status;
        switch ($rad->Status) {
          case 0:
            $ordre['Status'] = "Registrert";
            break;
          case 1:
            $ordre['Status'] = "Under planlegging";
            break;
          case 2:
            $ordre['Status'] = "Til godkjenning";
            break;
          case 3:
            $ordre['Status'] = "Godkjent";
            break;
          case 4:
            $ordre['Status'] = "Bestilt";
            break;
          case 5:
            $ordre['Status'] = "Levert";
            break;
          case 6:
            $ordre['Status'] = "Fullført";
            break;
        }
        return $ordre;
      }
    }

    function lagreinnkjopsordre($ordre) {
      if ($ordre['ID'] == 0) {
        $this->db->query("INSERT INTO oko_innkjopsordre (DatoRegistrert,Status) VALUES (Now(),1)");
        $ordre['ID'] = $this->db->insert_id();
      }
      $this->db->query("UPDATE oko_innkjopsordre SET PersonID=".$ordre['PersonID']." WHERE ID=".$ordre['ID']." LIMIT 1");
      $this->db->query("UPDATE oko_innkjopsordre SET LeverandorID='".$ordre['LeverandorID']."' WHERE ID=".$ordre['ID']." LIMIT 1");
      $this->db->query("UPDATE oko_innkjopsordre SET Navn='".$ordre['Navn']."' WHERE ID=".$ordre['ID']." LIMIT 1");
      $this->db->query("UPDATE oko_innkjopsordre SET Beskrivelse='".$ordre['Beskrivelse']."' WHERE ID=".$ordre['ID']." LIMIT 1");
      $this->db->query("UPDATE oko_innkjopsordre SET DatoEndret=Now() WHERE ID=".$ordre['ID']." LIMIT 1");
      return $ordre;
    }

    function lagreinnkjopsordrelinje($linje) {
      if ($linje['ID'] == 0) {
        $this->db->query("INSERT INTO oko_innkjopsordrelinjer (InnkjopsordreID,LeverandorID,Varenummer,Varenavn,Pris,Antall) VALUES (".$linje['OrdreID'].",".$linje['LeverandorID'].",'".$linje['Varenummer']."','".$linje['Varenavn']."','".$linje['Pris']."','".$linje['Antall']."')");
      } else {
        $this->db->query("UPDATE oko_innkjopsordrelinjer SET LeverandorID=".$linje['LeverandorID'].",Varenummer='".$linje['Varenummer']."',Varenavn='".$linje['Varenavn']."',Pris='".$linje['Pris']."',Antall='".$linje['Antall']."' WHERE ID=".$linje['ID']." LIMIT 1");
      }
    }

    function slettinnkjopsordre($ID) {
      $this->db->query("UPDATE oko_innkjopsordre SET DatoSlettet=Now() WHERE ID=".$ID." LIMIT 1");
    }

    function slettinnkjopsordrelinje($ID) {
      $this->db->query("DELETE FROM oko_innkjopsordrelinjer WHERE ID=".$ID." LIMIT 1");
    }

    function settinnkjopsordrestatus($data) {
      $this->db->query("UPDATE oko_innkjopsordre SET Status='".$data['Status']."' WHERE ID=".$data['ID']." LIMIT 1");
      $this->db->query("UPDATE oko_innkjopsordre SET DatoEndret=Now() WHERE ID=".$data['ID']." LIMIT 1");
      return TRUE;
    }

    function aktiviteter() {
      $resultat = $this->db->query("SELECT * FROM oko_aktiviteter ORDER BY ID ASC");
      foreach ($resultat->result() as $rad) {
        $aktivitet['ID'] = $rad->ID;
        $aktivitet['Navn'] = $rad->Navn;
        $aktiviteter[] = $aktivitet;
        unset($aktivitet);
      }
      return $aktiviteter;
    }

    function kontoer($type = 0) {
      $resultat = $this->db->query("SELECT * FROM oko_kontoer WHERE (Type=".$type.") ORDER BY ID ASC");
      foreach ($resultat->result() as $rad) {
        $konto['ID'] = $rad->ID;
        $konto['Navn'] = $rad->Navn;
        $konto['Beskrivelse'] = $rad->Beskrivelse;
        $konto['Type'] = $rad->Type;
        $kontoer[] = $konto;
        unset($konto);
      }
      return $kontoer;
    }

    function utgifter($filter = NULL) {
      if ($filter == NULL) {
        $sql = "SELECT * FROM oko_utgifter WHERE (Year(DatoBokfort) = Year(Now())) ORDER BY DatoBokfort ASC";
      } else {
        $sql = "SELECT * FROM oko_utgifter WHERE 1";
        if (isset($filter['Ar'])) {
          $sql = $sql." AND (Year(DatoBokfort)='".$filter['Ar']."')";
        }
        if (isset($filter['AktivitetID'])) {
          $sql = $sql." AND (AktivitetID='".$filter['AktivitetID']."')";
        }
        if (isset($filter['KontoID'])) {
          $sql = $sql." AND (KontoID='".$filter['KontoID']."')";
        }
        if (isset($filter['ProsjektID'])) {
          $sql = $sql." AND (ProsjektID='".$filter['ProsjektID']."')";
        }
        if (isset($filter['PersonID'])) {
          $sql = $sql." AND (PersonID='".$filter['PersonID']."')";
        }
        if (isset($filter['Beskrivelse'])) {
          $sql = $sql." AND (Beskrivelse LIKE '%".$filter['Beskrivelse']."%')";
        }
        $sql = $sql." ORDER BY DatoBokfort ASC";
      }
      $resultat = $this->db->query($sql);
      foreach ($resultat->result() as $rad) {
        $utgift['ID'] = $rad->ID;
        $utgift['DatoRegistrert'] = date('d.m.Y',strtotime($rad->DatoRegistrert));
        $utgift['DatoBokfort'] = date('d.m.Y',strtotime($rad->DatoBokfort));
        $utgift['PersonID'] = $rad->PersonID;
        $personer = $this->db->query("SELECT * FROM kon_medlemmer,kon_personer WHERE (kon_personer.ID=kon_medlemmer.PersonID) AND (PersonID=".$rad->PersonID.") LIMIT 1");
        if ($person = $personer->row()) {
          $utgift['PersonInitialer'] = $person->Initialer;
          $utgift['Person'] = $person->Fornavn." ".$person->Etternavn;
        } else {
          $utgift['PersonInitialer'] = "&nbsp;";
          $utgift['Person'] = "&nbsp;";
        }
        unset($personer);
        $utgift['AktivitetID'] = $rad->AktivitetID;
        $aktiviteter = $this->db->query("SELECT * FROM oko_aktiviteter WHERE (ID='".$rad->AktivitetID."')");
        if ($aktivitet = $aktiviteter->row()) {
          $utgift['Aktivitet'] = $aktivitet->Navn;
          unset($aktivitet);
        } else {
          $utgift['Aktivitet'] = "n/a";
        }
        unset($aktiviteter);
        $utgift['KontoID'] = $rad->KontoID;
        $kontoer = $this->db->query("SELECT * FROM oko_kontoer WHERE (ID='".$rad->KontoID."')");
        if ($konto = $kontoer->row()) {
          $utgift['Konto'] = $konto->Navn;
          unset($konto);
        } else {
          $utgift['Konto'] = "n/a";
        }
        unset($kontoer);
        $utgift['Beskrivelse'] = $rad->Beskrivelse;
        $utgift['Belop'] = $rad->Belop;
        $filer = $this->db->query("SELECT * FROM fil_xutgifter, fil_filer WHERE (fil_filer.ID=fil_xutgifter.FilID) AND (fil_xutgifter.UtgiftID=".$utgift['ID'].")");
        foreach ($filer->result() as $fil) {
          $utgift['Filer'][$fil->ID] = $fil->Filnavn;
        }
        $utgifter[] = $utgift;
        unset($utgift);
      }
      if (isset($utgifter)) {
        return $utgifter;
      }
    }

    function utgift($ID) {
      $resultat = $this->db->query("SELECT * FROM oko_utgifter WHERE (ID=".$ID.") LIMIT 1");
      if ($rad = $resultat->row()) {
        $utgift['ID'] = $rad->ID;
        $utgift['DatoRegistrert'] = $rad->DatoRegistrert;
        $utgift['DatoEndret'] = $rad->DatoEndret;
        $utgift['DatoBokfort'] = date('d.m.Y',strtotime($rad->DatoBokfort));
        $utgift['PersonID'] = $rad->PersonID;
        $utgift['AktivitetID'] = $rad->AktivitetID;
        $utgift['KontoID'] = $rad->KontoID;
        $utgift['ProsjektID'] = $rad->ProsjektID;
        $utgift['Beskrivelse'] = $rad->Beskrivelse;
        $utgift['Belop'] = $rad->Belop;
        $filer = $this->db->query("SELECT * FROM fil_xutgifter, fil_filer WHERE (fil_filer.ID=fil_xutgifter.FilID) AND (fil_xutgifter.UtgiftID=".$utgift['ID'].")");
        foreach ($filer->result() as $fil) {
          $utgift['Filer'][$fil->ID] = $fil->Filnavn;
        }
        return $utgift;
      }
    }

    function lagreutgift($utgift) {
      if ($utgift['ID'] == 0) {
        $this->db->query("INSERT INTO oko_utgifter (DatoRegistrert) VALUES (Now())");
        $utgift['ID'] = $this->db->insert_id();
      }
      $this->db->query("UPDATE oko_utgifter SET PersonID=".$utgift['PersonID']." WHERE ID=".$utgift['ID']." LIMIT 1");
      $this->db->query("UPDATE oko_utgifter SET AktivitetID='".$utgift['AktivitetID']."' WHERE ID=".$utgift['ID']." LIMIT 1");
      $this->db->query("UPDATE oko_utgifter SET KontoID='".$utgift['KontoID']."' WHERE ID=".$utgift['ID']." LIMIT 1");
      $this->db->query("UPDATE oko_utgifter SET ProsjektID=".$utgift['ProsjektID']." WHERE ID=".$utgift['ID']." LIMIT 1");
      $this->db->query("UPDATE oko_utgifter SET DatoBokfort='".date('Y-m-d',strtotime($utgift['DatoBokfort']))."' WHERE ID=".$utgift['ID']." LIMIT 1");
      $this->db->query("UPDATE oko_utgifter SET Beskrivelse='".$utgift['Beskrivelse']."' WHERE ID=".$utgift['ID']." LIMIT 1");
      $this->db->query("UPDATE oko_utgifter SET Belop='".$utgift['Belop']."' WHERE ID=".$utgift['ID']." LIMIT 1");
      $this->db->query("UPDATE oko_utgifter SET DatoEndret=Now() WHERE ID=".$utgift['ID']." LIMIT 1");
      return $utgift['ID'];
    }

    function slettutgift($ID) {
      $this->db->query("DELETE FROM oko_utgifter WHERE ID=".$ID." LIMIT 1");
    }

    function inntekter() {
      $resultat = $this->db->query("SELECT * FROM oko_inntekter WHERE (Year(DatoBokfort) = Year(Now())) ORDER BY DatoBokfort ASC");
      foreach ($resultat->result() as $rad) {
        $inntekt['ID'] = $rad->ID;
        $inntekt['DatoRegistrert'] = date('d.m.Y H:i',strtotime($rad->DatoRegistrert));
        $inntekt['DatoEndret'] = date('d.m.Y H:i',strtotime($rad->DatoRegistrert));
        $inntekt['DatoBokfort'] = date('d.m.Y',strtotime($rad->DatoBokfort));
        $inntekt['PersonID'] = $rad->PersonID;
        $personer = $this->db->query("SELECT * FROM kon_medlemmer,kon_personer WHERE (kon_personer.ID=kon_medlemmer.PersonID) AND (PersonID=".$rad->PersonID.") LIMIT 1");
        if ($person = $personer->row()) {
          $inntekt['PersonInitialer'] = $person->Initialer;
          $inntekt['Person'] = $person->Fornavn." ".$person->Etternavn;
        } else {
          $inntekt['PersonInitialer'] = "&nbsp;";
          $inntekt['Person'] = "&nbsp;";
        }
        unset($personer);
        $inntekt['AktivitetID'] = $rad->AktivitetID;
        $aktiviteter = $this->db->query("SELECT * FROM oko_aktiviteter WHERE (ID='".$rad->AktivitetID."')");
        if ($aktivitet = $aktiviteter->row()) {
          $inntekt['Aktivitet'] = $aktivitet->Navn;
          unset($aktivitet);
        } else {
          $inntekt['Aktivitet'] = "n/a";
        }
        unset($aktiviteter);
        $inntekt['KontoID'] = $rad->KontoID;
        $kontoer = $this->db->query("SELECT * FROM oko_kontoer WHERE (ID='".$rad->KontoID."')");
        if ($konto = $kontoer->row()) {
          $inntekt['Konto'] = $konto->Navn;
          unset($konto);
        } else {
          $inntekt['Konto'] = "n/a";
        }
        unset($kontoer);
        $inntekt['Beskrivelse'] = $rad->Beskrivelse;
        $inntekt['Belop'] = $rad->Belop;
        $inntekter[] = $inntekt;
        unset($inntekt);
      }
      if (isset($inntekter)) {
        return $inntekter;
      }
    }

    function inntekt($ID) {
      $rinntekter = $this->db->query("SELECT ID,DatoRegistrert,DatoEndret,DatoBokfort,PersonID,AktivitetID,KontoID,Beskrivelse,Belop FROM oko_inntekter WHERE (ID=".$ID.") LIMIT 1");
      if ($inntekt = $rinntekter->row_array()) {
        return $inntekt;
      }
    }

    function lagreinntekt($inntekt) {
      if ($inntekt['ID'] == 0) {
        $this->db->query("INSERT INTO oko_inntekter (DatoRegistrert) VALUES (Now())");
        $inntekt['ID'] = $this->db->insert_id();
      }
      $this->db->query("UPDATE oko_inntekter SET PersonID=".$inntekt['PersonID']." WHERE ID=".$inntekt['ID']." LIMIT 1");
      $this->db->query("UPDATE oko_inntekter SET AktivitetID='".$inntekt['AktivitetID']."' WHERE ID=".$inntekt['ID']." LIMIT 1");
      $this->db->query("UPDATE oko_inntekter SET KontoID='".$inntekt['KontoID']."' WHERE ID=".$inntekt['ID']." LIMIT 1");
      $this->db->query("UPDATE oko_inntekter SET DatoBokfort='".date('Y-m-d',strtotime($inntekt['DatoBokfort']))."' WHERE ID=".$inntekt['ID']." LIMIT 1");
      $this->db->query("UPDATE oko_inntekter SET Beskrivelse='".$inntekt['Beskrivelse']."' WHERE ID=".$inntekt['ID']." LIMIT 1");
      $this->db->query("UPDATE oko_inntekter SET Belop='".$inntekt['Belop']."' WHERE ID=".$inntekt['ID']." LIMIT 1");
      $this->db->query("UPDATE oko_inntekter SET DatoEndret=Now() WHERE ID=".$inntekt['ID']." LIMIT 1");
    }

    function slettinntekt($ID) {
      $this->db->query("DELETE FROM oko_inntekter WHERE ID=".$ID." LIMIT 1");
    }

    function resultat() {
      $kontoer = $this->db->query("SELECT * FROM oko_kontoer ORDER BY ID ASC");
      foreach ($kontoer->result() as $konto) {
        $data[$konto->ID]['Navn'] = $konto->Navn;
        $data[$konto->ID]['Type'] = $konto->Type;
        $data[$konto->ID]['Bokfort'] = 0;
        $data[$konto->ID]['Budsjett'] = 0;

        $i = 0;
        $aktiviteter = $this->db->query("SELECT * FROM oko_aktiviteter ORDER BY ID ASC");
        foreach ($aktiviteter->result() as $aktivitet) {
          if ($konto->Type == 0) {
            $resultat = $this->db->query("SELECT SUM(Belop) AS Belop FROM oko_inntekter WHERE (KontoID='".$konto->ID."') AND (AktivitetID='".$aktivitet->ID."') AND (Year(DatoBokfort) = Year(Now()))");
            if ($rad = $resultat->row()) {
              $data[$konto->ID][$i]['Bokfort'] = $rad->Belop;
              $data[$konto->ID]['Bokfort'] = $data[$konto->ID]['Bokfort'] + $rad->Belop;
            } else {
              $data[$konto->ID][$i]['Bokfort'] = 0;
            }
            $resultat2 = $this->db->query("SELECT SUM(Belop) AS Belop,(SUM(Belop)/12) AS Belop2 FROM oko_budsjett WHERE (KontoID='".$konto->ID."') AND (AktivitetID='".$aktivitet->ID."')");
            if ($rad2 = $resultat2->row()) {
              $data[$konto->ID][$i]['Budsjett'] = $rad2->Belop;
              $data[$konto->ID]['Budsjett'] = $data[$konto->ID]['Budsjett'] + $rad2->Belop;
              //$data[$konto->ID][$i]['BudsjettHIA'] = $rad2->Belop2 * date('m');
              //$data[$konto->ID][$i]['ResultatHIA'] = $rad->Belop - ($rad2->Belop2 * date('m'));
              $data[$konto->ID][$i]['Resultat'] = $rad->Belop - $rad2->Belop;
            }
          } elseif ($konto->Type == 1) {
            $resultat = $this->db->query("SELECT SUM(Belop) AS Belop FROM oko_utgifter WHERE (KontoID='".$konto->ID."') AND (AktivitetID='".$aktivitet->ID."') AND (Year(DatoBokfort) = Year(Now()))");
            if ($rad = $resultat->row()) {
              $data[$konto->ID][$i]['Bokfort'] = $rad->Belop;
              $data[$konto->ID]['Bokfort'] = $data[$konto->ID]['Bokfort'] + $rad->Belop;
            } else {
              $data[$konto->ID][$i]['Bokfort'] = 0;
              $data[$konto->ID]['Bokfort'] = 0;
            }
            $resultat2 = $this->db->query("SELECT SUM(Belop) AS Belop,(SUM(Belop)/12) AS Belop2 FROM oko_budsjett WHERE (KontoID='".$konto->ID."') AND (AktivitetID='".$aktivitet->ID."')");
            if ($rad2 = $resultat2->row()) {
              $data[$konto->ID][$i]['Budsjett'] = $rad2->Belop;
              $data[$konto->ID]['Budsjett'] = $data[$konto->ID]['Budsjett'] + $rad2->Belop;
              //$data[$konto->ID][$i]['BudsjettHIA'] = $rad2->Belop2 * date('m');
              //$data[$konto->ID][$i]['ResultatHIA'] = ($rad2->Belop2 * date('m')) - $rad->Belop;
              $data[$konto->ID][$i]['Resultat'] = $rad2->Belop - $rad->Belop;
            }
          }
          $i++;
        }
      }
      return $data;
    }

    function budsjett() {
      $kontoer = $this->db->query("SELECT * FROM oko_kontoer ORDER BY ID ASC");
      foreach ($kontoer->result() as $konto) {
        $aktiviteter = $this->db->query("SELECT * FROM oko_aktiviteter ORDER BY ID ASC");
        foreach ($aktiviteter->result() as $aktivitet) {
          $resultat = $this->db->query("SELECT * FROM oko_budsjett WHERE (KontoID='".$konto->ID."') AND (AktivitetID='".$aktivitet->ID."') AND (BudsjettAr='2015')");
          if ($rad = $resultat->row()) {
            $data[$konto->ID][$aktivitet->ID] = $rad->Belop;
          } else {
            $data[$konto->ID][$aktivitet->ID] = "";
          }
        }
      }
      return $data;
    }

    function lagrebudsjett($data) {
      for ($x=0;$x<sizeof($data['Konto']);$x++) {
        $resultat = $this->db->query("SELECT * FROM oko_budsjett WHERE (KontoID='".$data['Konto'][$x]."') AND (AktivitetID='".$data['Aktivitet'][$x]."') AND (BudsjettAr='".$data['BudsjettAr']."')");
        if ($resultat->num_rows() == 0) {
          if ($data['Budsjett'][$x] > 0) {
            $this->db->query("INSERT INTO oko_budsjett (KontoID,AktivitetID,BudsjettAr,Belop) VALUES ('".$data['Konto'][$x]."','".$data['Aktivitet'][$x]."','".$data['BudsjettAr']."','".$data['Budsjett'][$x]."')");
          }
        } else {
          if ($data['Budsjett'][$x] > 0) {
            $this->db->query("UPDATE oko_budsjett SET Belop='".$data['Budsjett'][$x]."' WHERE KontoID='".$data['Konto'][$x]."' AND AktivitetID='".$data['Aktivitet'][$x]."' AND BudsjettAr='".$data['BudsjettAr']."' LIMIT 1");
          } else {
            $this->db->query("DELETE FROM oko_budsjett WHERE KontoID='".$data['Konto'][$x]."' AND AktivitetID='".$data['Aktivitet'][$x]."' AND BudsjettAr='".$data['BudsjettAr']."' LIMIT 1");
          }
        }
      }
    }

  }
?>
