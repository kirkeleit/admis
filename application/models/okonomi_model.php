<?php
  class Okonomi_model extends CI_Model {

    var $InnkjopsordreStatus = array(0 =>'Registrert',1=>'Under planlegging',2=>'Til godkjenning',3=>'Godkjent',4=>'Bestilt',5=>'Levert',6=>'Fullført');
    var $InnkjopslinjeStatus = array(0 => 'Ikke bestilt', 1 => 'Bestilt', 2 => 'Levert');
    var $FakturaStatus = array(0 => 'Under arbeid', 1 => 'Til fakturering', 3 => 'Fakturert');

    function okonomioversikt() {
      for ($i=1; $i<=12; $i++) {
        $oversikt[$i]['Inntekter'] = 0;
        $oversikt[$i]['Utgifter'] = 0;
        $oversikt[$i]['Utlegg'] = 0;
        $oversikt[$i]['Reiseutgifter'] = 0;
      }
      $rinntekter = $this->db->query("SELECT MONTH(DatoBokfort) AS Maned,SUM(Belop) AS Inntekter FROM Inntekter WHERE (YEAR(DatoBokfort)=YEAR(CURDATE())) GROUP BY YEAR(DatoBokfort), MONTH(DatoBokfort)");
      foreach ($rinntekter->result_array() as $inntekt) {
        $oversikt[$inntekt['Maned']]['Inntekter'] = $inntekt['Inntekter'];
      }
      $rutgifter = $this->db->query("SELECT MONTH(DatoBokfort) AS Maned,SUM(Belop) AS Utgifter FROM Utgifter WHERE (YEAR(DatoBokfort)=YEAR(CURDATE())) GROUP BY YEAR(DatoBokfort), MONTH(DatoBokfort)");
      foreach ($rutgifter->result_array() as $utgift) {
        $oversikt[$utgift['Maned']]['Utgifter'] = $utgift['Utgifter'];
      }
      $rutlegg = $this->db->query("SELECT MONTH(DatoUtlegg) AS Maned,SUM(Belop) AS Utlegg FROM Utleggskvitteringer WHERE (YEAR(DatoUtlegg)=YEAR(CURDATE())) AND (DatoGodkjent != '0000-00-00 00:00:00') GROUP BY YEAR(DatoUtlegg), MONTH(DatoUtlegg)");
      foreach ($rutlegg->result_array() as $utlegg) {
        $oversikt[$utlegg['Maned']]['Utlegg'] = $utlegg['Utlegg'];
      }
      return $oversikt;
    }

    function innkjopsordrer($filter = null) {
      $sql = "SELECT OrdreID,DatoRegistrert,DatoEndret,ProsjektID,(SELECT Prosjektnavn FROM Prosjekter WHERE (ProsjektID=o.ProsjektID) LIMIT 1) AS Prosjektnavn,Referanse,PersonAnsvarligID,(SELECT Fornavn FROM Personer WHERE (PersonID=o.PersonAnsvarligID) LIMIT 1) AS PersonAnsvarligNavn,(SELECT SUM(Pris*Antall) FROM InnkjopsordreLinjer ol WHERE (ol.OrdreID=o.OrdreID)) AS OrdreSum,StatusID FROM Innkjopsordrer o WHERE (StatusID < 6)";
      if ($filter != NULL) {
        if (isset($filter['ProsjektID'])) {
          $sql = $sql." AND (ProsjektID=".$filter['ProsjektID'].")";
        }
      }
      $sql = $sql." ORDER BY DatoRegistrert ASC";
      $rordrer = $this->db->query($sql);
      foreach ($rordrer->result_array() as $ordre) {
        $ordre['Sum'] = 0;
        $ordre['Status'] = $this->InnkjopsordreStatus[$ordre['StatusID']];
        $ordrer[] = $ordre;
        unset($ordre);
      }
      if (isset($ordrer)) {
        return $ordrer;
      }
    }

    function innkjopsordre($ID) {
      $rordrer = $this->db->query("SELECT OrdreID,DatoRegistrert,DatoEndret,ProsjektID,(SELECT Prosjektnavn FROM Prosjekter WHERE (ProsjektID=o.ProsjektID) LIMIT 1) AS Prosjektnavn,Referanse,Beskrivelse,PersonAnsvarligID,(SELECT Fornavn FROM Personer WHERE (PersonID=o.PersonAnsvarligID) LIMIT 1) AS PersonAnsvarligNavn,StatusID,LeverandorID,(SELECT Navn FROM Organisasjoner WHERE (OrganisasjonID=o.LeverandorID) LIMIT 1) AS LeverandorNavn FROM Innkjopsordrer o WHERE (OrdreID=".$ID.") LIMIT 1");
      if ($ordre = $rordrer->row_array()) {
        $ordre['Status'] = $this->InnkjopsordreStatus[$ordre['StatusID']];
        return $ordre;
      }
    }

    /*function innkjopsordrelinjercrc($ID) {
      $rlinjer = $this->db->query("SELECT ID,InnkjopsordreID,Varenummer,Varenavn,Pris,Antall FROM oko_innkjopsordrelinjer WHERE (InnkjopsordreID=".$ID.")");
      foreach ($rlinjer->result_array() as $linje) {
        $linjer[] = $linje;
      }
      if (isset($linjer)) {
        return md5(serialize($linjer));
      }
    }*/

    function lagreinnkjopsordre($ID,$ordre) {
      $ordre['DatoEndret'] = date("Y-m-d H:i:s");
      if ($ID == 0) {
        $ordre['DatoRegistrert'] = $ordre['DatoEndret'];
        $this->db->query($this->db->insert_string('Innkjopsordrer',$ordre));
        $ID = $this->db->insert_id();
      } else {
        $this->db->query($this->db->update_string('Innkjopsordrer',$ordre,'OrdreID='.$ID));
      }
      $ordre['OrdreID'] = $ID;
      return $ordre;
    }

    function lagreinnkjopsordrelinje($ID,$linje) {
      if ($ID == 0) {
        $this->db->query($this->db->insert_string('InnkjopsordreLinjer',$linje));
      } else {
        $this->db->query($this->db->update_string('InnkjopsordreLinjer',$linje,'LinjeID='.$ID));
      }
    }

    function slettinnkjopsordre($ID) {
      $this->db->query("DELETE FROM Innkjopsordrer WHERE OrdreID=".$ID." LIMIT 1");
      $this->db->query("DELETE FROM InnkjopsordreLinjer WHERE OrdreID=".$ID." LIMIT 1");
    }

    function slettinnkjopsordrelinje($ID) {
      $this->db->query("DELETE FROM InnkjopsordreLinjer WHERE LinjeID=".$ID." LIMIT 1");
    }

    function settinnkjopsordrestatus($data) {
      $this->db->query("UPDATE Innkjopsordrer SET StatusID='".$data['Status']."' WHERE OrdreID=".$data['ID']." LIMIT 1");
      $this->db->query("UPDATE Innkjopsordrer SET DatoEndret=Now() WHERE OrdreID=".$data['ID']." LIMIT 1");
      switch ($data['Status']) {
        case 1:
          $ordre = $this->innkjopsordre($data['ID']);
          $this->db->query("INSERT INTO VarslingEposter (DatoRegistrert,AdresseMottaker,Emne,Meldingstekst) VALUES (Now(),'thorbjorn@kirkeleit.net','[admis] Innkjøpsordre avvist: ".$ordre['Referanse']."','')");
        case 2:
          $ordre = $this->innkjopsordre($data['ID']);
          $this->db->query("INSERT INTO VarslingEposter (DatoRegistrert,AdresseMottaker,Emne,Meldingstekst) VALUES (Now(),'thorbjorn@kirkeleit.net','[admis] Innkjøpsordre til godkjenning: ".$ordre['Referanse']."','')");
        case 3:
          $ordre = $this->innkjopsordre($data['ID']);
          $this->db->query("INSERT INTO VarslingEposter (DatoRegistrert,AdresseMottaker,Emne,Meldingstekst) VALUES (Now(),'thorbjorn@kirkeleit.net','[admis] Innkjøpsordre godkjent: ".$ordre['Referanse']."','')");
        case 4:
          $this->db->query("UPDATE InnkjopsordreLinjer SET StatusID=1 WHERE OrdreID=".$data['ID']);
          break;
      }
      return TRUE;
    }

    function innkjopsordrelinjer($filter) {
      if ($filter == NULL) {
        $sql = "SELECT LinjeID,OrdreID,Varenummer,Varenavn,Pris,Antall,(Pris * Antall) AS Sum,(SELECT SUM(Levert) FROM Varemottak WHERE (LinjeID=l.LinjeID)) AS Levert,StatusID FROM InnkjopsordreLinjer l ORDER BY OrdreID ASC";
      } else {
        $sql = "SELECT LinjeID,OrdreID,Varenummer,Varenavn,Pris,Antall,(Pris * Antall) AS Sum,(SELECT SUM(Levert) FROM Varemottak WHERE (LinjeID=l.LinjeID)) AS Levert,StatusID FROM InnkjopsordreLinjer l WHERE 1";
        if (isset($filter['StatusID'])) {
          $sql = $sql." AND (StatusID='".$filter['StatusID']."')";
        }
        if (isset($filter['OrdreID'])) {
          $sql = $sql." AND (OrdreID='".$filter['OrdreID']."')";
        }
        $sql = $sql." ORDER BY LinjeID ASC";
      }
      $rlinjer = $this->db->query($sql);
      foreach ($rlinjer->result_array() as $linje) {
        $linje['Ordre'] = $this->innkjopsordre($linje['OrdreID']);
        $linje['Status'] = $this->InnkjopslinjeStatus[$linje['StatusID']];
        $linjer[] = $linje;
      }
      if (isset($linjer)) {
        return $linjer;
      }
    }

    function registrerevaremottak($data) {
      foreach ($data['Linjer'] as $ID => $Antall) {
        if ($Antall > 0) {
          $rlinjer = $this->db->query("SELECT LinjeID,OrdreID,Antall,(SELECT SUM(Levert) FROM Varemottak WHERE (LinjeID=l.LinjeID)) AS Levert FROM InnkjopsordreLinjer l WHERE (LinjeID=".$ID.") LIMIT 1");
          if ($linje = $rlinjer->row_array()) {
            $this->db->query("INSERT INTO Varemottak (PersonID,LinjeID,DatoRegistrert,Levert) VALUES ('".$data['PersonID']."','".$linje['LinjeID']."',Now(),'".$Antall."')");
            if (($linje['Antall']-($linje['Levert']+$Antall)) == 0) {
              $this->db->query("UPDATE InnkjopsordreLinjer SET StatusID=2 WHERE LinjeID=".$linje['LinjeID']." LIMIT 1");
            }
            $rrestlinjer = $this->db->query("SELECT * FROM InnkjopsordreLinjer WHERE (OrdreID='".$linje['OrdreID']."') AND (StatusID < 2)");
            if ($rrestlinjer->num_rows() == 0) {
              $this->db->query("UPDATE Innkjopsordrer SET Status=5 WHERE OrdreID=".$linje['OrdreID']." LIMIT 1");
            }
          }
        }
      }
    }

    function aktiviteter() {
      $resultat = $this->db->query("SELECT * FROM RegnskapsAktiviteter ORDER BY AktivitetID ASC");
      foreach ($resultat->result() as $rad) {
        $aktivitet['AktivitetID'] = $rad->AktivitetID;
        $aktivitet['Navn'] = $rad->Navn;
        $aktiviteter[] = $aktivitet;
        unset($aktivitet);
      }
      return $aktiviteter;
    }

    function kontoer($type = 0) {
      $resultat = $this->db->query("SELECT * FROM RegnskapsKontoer WHERE (Type=".$type.") ORDER BY KontoID ASC");
      foreach ($resultat->result() as $rad) {
        $konto['KontoID'] = $rad->KontoID;
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
        $sql = "SELECT * FROM Utgifter WHERE (Year(DatoBokfort) = Year(Now())) ORDER BY DatoBokfort ASC";
      } else {
        $sql = "SELECT * FROM Utgifter WHERE 1";
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
        $utgift['UtgiftID'] = $rad->UtgiftID;
        $utgift['DatoRegistrert'] = $rad->DatoRegistrert;
        $utgift['DatoBokfort'] = $rad->DatoBokfort;
        $utgift['PersonID'] = $rad->PersonID;
        $personer = $this->db->query("SELECT * FROM Medlemmer,Personer WHERE (Medlemmer.PersonID=Personer.PersonID) AND (Personer.PersonID=".$rad->PersonID.") LIMIT 1");
        if ($person = $personer->row()) {
          $utgift['PersonInitialer'] = $person->Initialer;
          $utgift['Person'] = $person->Fornavn." ".$person->Etternavn;
        } else {
          $utgift['PersonInitialer'] = "&nbsp;";
          $utgift['Person'] = "&nbsp;";
        }
        unset($personer);
        $utgift['AktivitetID'] = $rad->AktivitetID;
        $aktiviteter = $this->db->query("SELECT * FROM RegnskapsAktiviteter WHERE (AktivitetID='".$rad->AktivitetID."')");
        if ($aktivitet = $aktiviteter->row()) {
          $utgift['Aktivitet'] = $aktivitet->Navn;
          unset($aktivitet);
        } else {
          $utgift['Aktivitet'] = "n/a";
        }
        unset($aktiviteter);
        $utgift['KontoID'] = $rad->KontoID;
        $kontoer = $this->db->query("SELECT * FROM RegnskapsKontoer WHERE (KontoID='".$rad->KontoID."')");
        if ($konto = $kontoer->row()) {
          $utgift['Konto'] = $konto->Navn;
          unset($konto);
        } else {
          $utgift['Konto'] = "n/a";
        }
        unset($kontoer);
        $utgift['Beskrivelse'] = $rad->Beskrivelse;
        $utgift['Belop'] = $rad->Belop;
        $filer = $this->db->query("SELECT * FROM FilXUtgifter, Filer WHERE (Filer.FilID=FilXUtgifter.FilID) AND (FilXUtgifter.UtgiftID=".$utgift['UtgiftID'].")");
        foreach ($filer->result() as $fil) {
          $utgift['Filer'][$fil->FilID] = $fil->Filnavn;
        }
        $utgifter[] = $utgift;
        unset($utgift);
      }
      if (isset($utgifter)) {
        return $utgifter;
      }
    }

    function utgift($ID) {
      $rutgifter = $this->db->query("SELECT UtgiftID,DatoRegistrert,DatoEndret,DatoBokfort,PersonID,AktivitetID,KontoID,ProsjektID,Beskrivelse,Belop FROM Utgifter WHERE (UtgiftID=".$ID.") LIMIT 1");
      if ($utgift = $rutgifter->row_array()) {
        $filer = $this->db->query("SELECT * FROM FilXUtgifter, Filer WHERE (Filer.FilID=FilXUtgifter.FilID) AND (FilXUtgifter.UtgiftID=".$utgift['UtgiftID'].")");
        foreach ($filer->result() as $fil) {
          $utgift['Filer'][$fil->FilID] = $fil->Filnavn;
        }
        return $utgift;
      }
    }

    function lagreutgift($ID = null, $utgift) {
      $utgift['DatoEndret'] = date('Y-m-d H:i:s');
      if ($ID == null) {
        $utgift['DatoRegistrert'] = $utgift['DatoEndret'];
        $this->db->query($this->db->insert_string('Utgifter',$utgift));
        $utgift['UtgiftID'] = $this->db->insert_id();
      } else {
        $this->db->query($this->db->update_string('Utgifter',$utgift,'UtgiftID='.$ID));
        $utgift['UtgiftID'] = $ID;
      }
      return $utgift;
    }

    function slettutgift($ID) {
      $this->db->query("DELETE FROM Utgifter WHERE UtgiftID=".$ID." LIMIT 1");
    }

    function inntekter() {
      $resultat = $this->db->query("SELECT * FROM Inntekter WHERE (Year(DatoBokfort) = Year(Now())) ORDER BY DatoBokfort ASC");
      foreach ($resultat->result() as $rad) {
        $inntekt['InntektID'] = $rad->InntektID;
        $inntekt['DatoRegistrert'] = date('d.m.Y H:i',strtotime($rad->DatoRegistrert));
        $inntekt['DatoEndret'] = date('d.m.Y H:i',strtotime($rad->DatoRegistrert));
        $inntekt['DatoBokfort'] = date('d.m.Y',strtotime($rad->DatoBokfort));
        $inntekt['PersonID'] = $rad->PersonID;
        $personer = $this->db->query("SELECT * FROM Medlemmer,Personer WHERE (Personer.PersonID=Medlemmer.PersonID) AND (Personer.PersonID=".$rad->PersonID.") LIMIT 1");
        if ($person = $personer->row()) {
          $inntekt['PersonInitialer'] = $person->Initialer;
          $inntekt['Person'] = $person->Fornavn." ".$person->Etternavn;
        } else {
          $inntekt['PersonInitialer'] = "&nbsp;";
          $inntekt['Person'] = "&nbsp;";
        }
        unset($personer);
        $inntekt['AktivitetID'] = $rad->AktivitetID;
        $aktiviteter = $this->db->query("SELECT * FROM RegnskapsAktiviteter WHERE (AktivitetID='".$rad->AktivitetID."')");
        if ($aktivitet = $aktiviteter->row()) {
          $inntekt['Aktivitet'] = $aktivitet->Navn;
          unset($aktivitet);
        } else {
          $inntekt['Aktivitet'] = "n/a";
        }
        unset($aktiviteter);
        $inntekt['KontoID'] = $rad->KontoID;
        $kontoer = $this->db->query("SELECT * FROM RegnskapsKontoer WHERE (KontoID='".$rad->KontoID."')");
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
      $rinntekter = $this->db->query("SELECT InntektID,DatoRegistrert,DatoEndret,DatoBokfort,PersonID,AktivitetID,KontoID,ProsjektID,Beskrivelse,Belop FROM Inntekter WHERE (InntektID=".$ID.") LIMIT 1");
      if ($inntekt = $rinntekter->row_array()) {
        return $inntekt;
      }
    }

    function lagreinntekt($inntekt) {
      if ($inntekt['InntektID'] == 0) {
        $this->db->query("INSERT INTO Inntekter (DatoRegistrert) VALUES (Now())");
        $inntekt['InntektID'] = $this->db->insert_id();
      }
      $this->db->query("UPDATE Inntekter SET PersonID=".$inntekt['PersonID']." WHERE InntektID=".$inntekt['InntektID']." LIMIT 1");
      $this->db->query("UPDATE Inntekter SET AktivitetID='".$inntekt['AktivitetID']."' WHERE InntektID=".$inntekt['InntektID']." LIMIT 1");
      $this->db->query("UPDATE Inntekter SET KontoID='".$inntekt['KontoID']."' WHERE InntektID=".$inntekt['InntektID']." LIMIT 1");
      $this->db->query("UPDATE Inntekter SET ProsjektID='".$inntekt['ProsjektID']."' WHERE InntektID=".$inntekt['InntektID']." LIMIT 1");
      $this->db->query("UPDATE Inntekter SET DatoBokfort='".date('Y-m-d',strtotime($inntekt['DatoBokfort']))."' WHERE InntektID=".$inntekt['InntektID']." LIMIT 1");
      $this->db->query("UPDATE Inntekter SET Beskrivelse='".$inntekt['Beskrivelse']."' WHERE InntektID=".$inntekt['InntektID']." LIMIT 1");
      $this->db->query("UPDATE Inntekter SET Belop='".$inntekt['Belop']."' WHERE InntektID=".$inntekt['InntektID']." LIMIT 1");
      $this->db->query("UPDATE Inntekter SET DatoEndret=Now() WHERE InntektID=".$inntekt['InntektID']." LIMIT 1");
    }

    function slettinntekt($ID) {
      $this->db->query("DELETE FROM Inntekter WHERE InntektID=".$ID." LIMIT 1");
    }

    function resultat() {
      $kontoer = $this->db->query("SELECT * FROM RegnskapsKontoer ORDER BY KontoID ASC");
      foreach ($kontoer->result() as $konto) {
        $data[$konto->KontoID]['Navn'] = $konto->Navn;
        $data[$konto->KontoID]['Type'] = $konto->Type;
        $data[$konto->KontoID]['Bokfort'] = 0;
        $data[$konto->KontoID]['Budsjett'] = 0;

        $i = 0;
        $aktiviteter = $this->db->query("SELECT * FROM RegnskapsAktiviteter ORDER BY AktivitetID ASC");
        foreach ($aktiviteter->result() as $aktivitet) {
          if ($konto->Type == 0) {
            $resultat = $this->db->query("SELECT SUM(Belop) AS Belop FROM Inntekter WHERE (KontoID='".$konto->KontoID."') AND (AktivitetID='".$aktivitet->AktivitetID."') AND (Year(DatoBokfort) = Year(Now()))");
            if ($rad = $resultat->row()) {
              $data[$konto->KontoID][$i]['Bokfort'] = $rad->Belop;
              $data[$konto->KontoID]['Bokfort'] = $data[$konto->KontoID]['Bokfort'] + $rad->Belop;
            } else {
              $data[$konto->KontoID][$i]['Bokfort'] = 0;
            }
            $resultat2 = $this->db->query("SELECT SUM(Belop) AS Belop,(SUM(Belop)/12) AS Belop2 FROM Budsjett WHERE (KontoID='".$konto->KontoID."') AND (AktivitetID='".$aktivitet->AktivitetID."')");
            if ($rad2 = $resultat2->row()) {
              $data[$konto->KontoID][$i]['Budsjett'] = $rad2->Belop;
              $data[$konto->KontoID]['Budsjett'] = $data[$konto->KontoID]['Budsjett'] + $rad2->Belop;
              //$data[$konto->ID][$i]['BudsjettHIA'] = $rad2->Belop2 * date('m');
              //$data[$konto->ID][$i]['ResultatHIA'] = $rad->Belop - ($rad2->Belop2 * date('m'));
              $data[$konto->KontoID][$i]['Resultat'] = $rad->Belop - $rad2->Belop;
            }
          } elseif ($konto->Type == 1) {
            $resultat = $this->db->query("SELECT SUM(Belop) AS Belop FROM Utgifter WHERE (KontoID='".$konto->KontoID."') AND (AktivitetID='".$aktivitet->AktivitetID."') AND (Year(DatoBokfort) = Year(Now()))");
            if ($rad = $resultat->row()) {
              $data[$konto->KontoID][$i]['Bokfort'] = $rad->Belop;
              $data[$konto->KontoID]['Bokfort'] = $data[$konto->KontoID]['Bokfort'] + $rad->Belop;
            } else {
              $data[$konto->KontoID][$i]['Bokfort'] = 0;
              $data[$konto->KontoID]['Bokfort'] = 0;
            }
            $resultat2 = $this->db->query("SELECT SUM(Belop) AS Belop,(SUM(Belop)/12) AS Belop2 FROM Budsjett WHERE (KontoID='".$konto->KontoID."') AND (AktivitetID='".$aktivitet->AktivitetID."')");
            if ($rad2 = $resultat2->row()) {
              $data[$konto->KontoID][$i]['Budsjett'] = $rad2->Belop;
              $data[$konto->KontoID]['Budsjett'] = $data[$konto->KontoID]['Budsjett'] + $rad2->Belop;
              //$data[$konto->ID][$i]['BudsjettHIA'] = $rad2->Belop2 * date('m');
              //$data[$konto->ID][$i]['ResultatHIA'] = ($rad2->Belop2 * date('m')) - $rad->Belop;
              $data[$konto->KontoID][$i]['Resultat'] = $rad2->Belop - $rad->Belop;
            }
          }
          $i++;
        }
      }
      return $data;
    }

    function budsjett() {
      $kontoer = $this->db->query("SELECT * FROM RegnskapsKontoer ORDER BY KontoID ASC");
      foreach ($kontoer->result() as $konto) {
        $aktiviteter = $this->db->query("SELECT * FROM RegnskapsAktiviteter ORDER BY AktivitetID ASC");
        foreach ($aktiviteter->result() as $aktivitet) {
          $resultat = $this->db->query("SELECT * FROM Budsjett WHERE (KontoID='".$konto->KontoID."') AND (AktivitetID='".$aktivitet->AktivitetID."') AND (BudsjettAr='2015')");
          if ($rad = $resultat->row()) {
            $data[$konto->KontoID][$aktivitet->AktivitetID] = $rad->Belop;
          } else {
            $data[$konto->KontoID][$aktivitet->AktivitetID] = "";
          }
        }
      }
      return $data;
    }

    function lagrebudsjett($data) {
      for ($x=0;$x<sizeof($data['Konto']);$x++) {
        $resultat = $this->db->query("SELECT * FROM Budsjett WHERE (KontoID='".$data['Konto'][$x]."') AND (AktivitetID='".$data['Aktivitet'][$x]."') AND (BudsjettAr='".$data['BudsjettAr']."')");
        if ($resultat->num_rows() == 0) {
          if ($data['Budsjett'][$x] > 0) {
            $this->db->query("INSERT INTO Budsjett (KontoID,AktivitetID,BudsjettAr,Belop) VALUES ('".$data['Konto'][$x]."','".$data['Aktivitet'][$x]."','".$data['BudsjettAr']."','".$data['Budsjett'][$x]."')");
          }
        } else {
          if ($data['Budsjett'][$x] > 0) {
            $this->db->query("UPDATE Budsjett SET Belop='".$data['Budsjett'][$x]."' WHERE KontoID='".$data['Konto'][$x]."' AND AktivitetID='".$data['Aktivitet'][$x]."' AND BudsjettAr='".$data['BudsjettAr']."' LIMIT 1");
          } else {
            $this->db->query("DELETE FROM Budsjett WHERE KontoID='".$data['Konto'][$x]."' AND AktivitetID='".$data['Aktivitet'][$x]."' AND BudsjettAr='".$data['BudsjettAr']."' LIMIT 1");
          }
        }
      }
    }

    function utleggskvitteringer($filter = NULL) {

      if ($filter == NULL) {
        $sql = "SELECT UtleggID,DatoUtlegg,AktivitetID,(SELECT Navn FROM RegnskapsAktiviteter WHERE (AktivitetID=u.AktivitetID) LIMIT 1) AS AktivitetNavn,PersonID,(SELECT Fornavn FROM Personer WHERE (PersonID=u.PersonID) LIMIT 1) AS PersonNavn,Belop,DatoSignert,DatoGodkjent,DatoUtbetalt FROM Utleggskvitteringer u WHERE (Year(DatoUtlegg) = Year(Now())) ORDER BY DatoUtlegg ASC";
      } else {
        $sql = "SELECT UtleggID,DatoUtlegg,AktivitetID,(SELECT Navn FROM RegnskapsAktiviteter WHERE (AktivitetID=u.AktivitetID) LIMIT 1) AS AktivitetNavn,PersonID,(SELECT Fornavn FROM Personer WHERE (PersonID=u.PersonID) LIMIT 1) AS PersonNavn,Belop,DatoSignert,DatoGodkjent,DatoUtbetalt FROM Utleggskvitteringer u WHERE 1";
        if (isset($filter['Ar'])) {
          $sql = $sql." AND (Year(DatoUtlegg)='".$filter['Ar']."')";
        }
        if (isset($filter['AktivitetID'])) {
          $sql = $sql." AND (AktivitetID='".$filter['AktivitetID']."')";
        }
        if (isset($filter['PersonID'])) {
          $sql = $sql." AND (PersonID='".$filter['PersonID']."')";
        }
        $sql = $sql." ORDER BY DatoUtlegg ASC";
      }
      $resultat = $this->db->query($sql);
      foreach ($resultat->result_array() as $kvittering) {
        if (($kvittering['DatoSignert'] == "0000-00-00 00:00:00") and ($kvittering['DatoGodkjent'] == "0000-00-00 00:00:00") and ($kvittering['DatoUtbetalt'] == "0000-00-00 00:00:00")) {
          $kvittering['StatusID'] = 0;
          $kvittering['Status'] = "Ikke signert";
        } elseif (($kvittering['DatoSignert'] != "0000-00-00 00:00:00") and ($kvittering['DatoGodkjent'] == "0000-00-00 00:00:00") and ($kvittering['DatoUtbetalt'] == "0000-00-00 00:00:00")) {
          $kvittering['StatusID'] = 1;
          $kvittering['Status'] = "Signert";
        } elseif (($kvittering['DatoSignert'] != "0000-00-00 00:00:00") and ($kvittering['DatoGodkjent'] != "0000-00-00 00:00:00") and ($kvittering['DatoUtbetalt'] == "0000-00-00 00:00:00")) {
          $kvittering['StatusID'] = 2;
          $kvittering['Status'] = "Godkjent";
        } elseif (($kvittering['DatoSignert'] != "0000-00-00 00:00:00") and ($kvittering['DatoGodkjent'] != "0000-00-00 00:00:00") and ($kvittering['DatoUtbetalt'] != "0000-00-00 00:00:00")) {
          $kvittering['StatusID'] = 3;
          $kvittering['Status'] = "Utbetalt";
        }
        $kvitteringer[] = $kvittering;
      }
      if (isset($kvitteringer)) {
        return $kvitteringer;
      }
    }

    function utleggskvittering($ID = 0) {
      $resultat = $this->db->query("SELECT UtleggID,DatoUtlegg,AktivitetID,(SELECT Navn FROM RegnskapsAktiviteter WHERE (AktivitetID=u.AktivitetID) LIMIT 1) AS AktivitetNavn,PersonID,(SELECT Fornavn FROM Personer WHERE (PersonID=u.PersonID) LIMIT 1) AS PersonNavn,PersonID,DatoSignert,DatoGodkjent,DatoUtbetalt,Beskrivelse,ProsjektID,Kontonummer,Belop FROM Utleggskvitteringer u WHERE (UtleggID=".$ID.")");
      if ($utlegg = $resultat->row_array()) {
        if (($utlegg['DatoSignert'] == "0000-00-00 00:00:00") and ($utlegg['DatoGodkjent'] == "0000-00-00 00:00:00") and ($utlegg['DatoUtbetalt'] == "0000-00-00 00:00:00")) {
          $utlegg['StatusID'] = 0;
        } elseif (($utlegg['DatoSignert'] != "0000-00-00 00:00:00") and ($utlegg['DatoGodkjent'] == "0000-00-00 00:00:00") and ($utlegg['DatoUtbetalt'] == "0000-00-00 00:00:00")) {
          $utlegg['StatusID'] = 1;
        } elseif (($utlegg['DatoSignert'] != "0000-00-00 00:00:00") and ($utlegg['DatoGodkjent'] != "0000-00-00 00:00:00") and ($utlegg['DatoUtbetalt'] == "0000-00-00 00:00:00")) {
          $utlegg['StatusID'] = 2;
        } elseif (($utlegg['DatoSignert'] != "0000-00-00 00:00:00") and ($utlegg['DatoGodkjent'] != "0000-00-00 00:00:00") and ($utlegg['DatoUtbetalt'] != "0000-00-00 00:00:00")) {
          $utlegg['StatusID'] = 3;
        }
        $filer = $this->db->query("SELECT FilID,Filnavn FROM FilXUtlegg,Filer WHERE (Filer.FilID=FilXUtlegg.FilID) AND (FilXUtlegg.UtleggID=".$utlegg['UtleggID'].")");
        foreach ($filer->result() as $fil) {
          $utlegg['Filer'][$fil->FilID] = $fil->Filnavn;
        }
        return $utlegg;
      }
    }

    function lagreutleggskvittering($utlegg) {
      if ($utlegg['UtleggID'] == 0) {
        $this->db->query("INSERT INTO Utleggskvitteringer (DatoRegistrert) VALUES (Now())");
        $utlegg['UtleggID'] = $this->db->insert_id();
      }
      $this->db->query("UPDATE Utleggskvitteringer SET PersonID=".$utlegg['PersonID']." WHERE UtleggID=".$utlegg['UtleggID']." LIMIT 1");
      $this->db->query("UPDATE Utleggskvitteringer SET AktivitetID='".$utlegg['AktivitetID']."' WHERE UtleggID=".$utlegg['UtleggID']." LIMIT 1");
      $this->db->query("UPDATE Utleggskvitteringer SET ProsjektID='".$utlegg['ProsjektID']."' WHERE UtleggID=".$utlegg['UtleggID']." LIMIT 1");
      $this->db->query("UPDATE Utleggskvitteringer SET DatoUtlegg='".$utlegg['DatoUtlegg']."' WHERE UtleggID=".$utlegg['UtleggID']." LIMIT 1");
      $this->db->query("UPDATE Utleggskvitteringer SET Kontonummer='".str_replace('.','',$utlegg['Kontonummer'])."' WHERE UtleggID=".$utlegg['UtleggID']." LIMIT 1");
      $this->db->query("UPDATE Utleggskvitteringer SET Beskrivelse='".$utlegg['Beskrivelse']."' WHERE UtleggID=".$utlegg['UtleggID']." LIMIT 1");
      $this->db->query("UPDATE Utleggskvitteringer SET Belop='".$utlegg['Belop']."' WHERE UtleggID=".$utlegg['UtleggID']." LIMIT 1");
      $this->db->query("UPDATE Utleggskvitteringer SET DatoEndret=Now() WHERE UtleggID=".$utlegg['UtleggID']." LIMIT 1");
      return $utlegg['UtleggID'];
    }

    function slettutleggskvittering($ID) {
      $this->db->query("DELETE FROM utleggskvitteringer WHERE UtleggID=".$ID." LIMIT 1");
    }

    function utleggskvitteringcrc($ID) {
      $resultat = $this->db->query("SELECT UtleggID,DatoRegistrert,DatoUtlegg,AktivitetID,PersonID,Beskrivelse,ProsjektID,Kontonummer,Belop FROM Utleggskvitteringer u WHERE (UtleggID=".$ID.")");
      if ($utlegg = $resultat->row_array()) {
        return md5(serialize($utlegg));
      } else {
        return false;
      }
    }

    function signerutleggskvittering($ID,$BrukerID) {
      $this->db->query("UPDATE Utleggskvitteringer SET DatoSignert=Now(),CRCSignert='".$this->utleggskvitteringcrc($ID)."',SignertAv='".$BrukerID."' WHERE UtleggID=".$ID." LIMIT 1");
    }

    function godkjennutleggskvittering($ID,$BrukerID) {
      $this->db->query("UPDATE Utleggskvitteringer SET DatoGodkjent=Now(),CRCGodkjent='".$this->utleggskvitteringcrc($ID)."',GodkjentAv='".$BrukerID."' WHERE UtleggID=".$ID." LIMIT 1");
      $rutlegg = $this->db->query("SELECT UtleggID,DatoUtlegg,PersonID,AktivitetID,ProsjektID,Beskrivelse,Belop FROM Utleggskvitteringer WHERE (UtleggID=".$ID.")");
      if ($utlegg = $rutlegg->row_array()) {
        $this->db->query("INSERT INTO Utgifter (DatoRegistrert,DatoEndret,DatoBokfort,PersonID,AktivitetID,KontoID,ProsjektID,Beskrivelse,Belop,UtleggID) VALUES (Now(),Now(),'".$utlegg['DatoUtlegg']."',".$utlegg['PersonID'].",'".$utlegg['AktivitetID']."','4300',".$utlegg['ProsjektID'].",'".$utlegg['Beskrivelse']."','".$utlegg['Belop']."',".$utlegg['UtleggID'].")");
      }
    }

    function utbetaltutleggskvittering($ID,$BrukerID) {
      $this->db->query("UPDATE Utleggskvitteringer SET DatoUtbetalt=Now(),CRCUtbetalt='".$this->utleggskvitteringcrc($ID)."',UtbetaltAv='".$BrukerID."' WHERE UtleggID=".$ID." LIMIT 1");
    }

    function utleggtilutbetaling() {
      $rutlegg = $this->db->query("SELECT UtleggID,DatoUtlegg,PersonID,(SELECT Fornavn FROM Personer WHERE (PersonID=u.PersonID) LIMIT 1) AS PersonNavn,Beskrivelse,Kontonummer,Belop,DatoGodkjent,GodkjentAv,(SELECT CONCAT(Fornavn,' ',Etternavn) FROM Personer WHERE (PersonID=u.GodkjentAv) LIMIT 1) AS GodkjentAvNavn,CRCGodkjent FROM Utleggskvitteringer u WHERE (GodkjentAv > 0) AND (UtbetaltAv=0) ORDER BY DatoUtlegg ASC");
      foreach ($rutlegg->result_array() as $utlegg) {
        if ($this->utleggskvitteringcrc($utlegg['ID']) == $utlegg['CRCGodkjent']) {
          $utlegg['GodkjentStatus'] = 1;
        } else {
          $utlegg['GodkjentStatus'] = 0;
        }
        unset($utlegg['CRCGodkjent']);
        $tilutbetaling[] = $utlegg;
      }
      if (isset($tilutbetaling)) {
      return $tilutbetaling;
      }
    }

    function fakturaer() {
      $rfaktuaer = $this->db->query("SELECT FakturaID,DatoRegistrert,DatoFakturadato,OrganisasjonID,(SELECT Navn FROM Organisasjoner WHERE (Organisasjoner.OrganisasjonID=f.OrganisasjonID) LIMIT 1) AS OrganisasjonNavn,PersonID,(SELECT Fornavn FROM Personer WHERE (Personer.PersonID=f.PersonID) LIMIT 1) AS PersonNavn,AdresseID,PersonAnsvarligID,(SELECT Fornavn FROM Personer WHERE (Personer.PersonID=f.PersonAnsvarligID) LIMIT 1) AS PersonAnsvarligNavn,Referanse,(SELECT SUM(Pris*Antall) FROM FakturaLinjer WHERE (FakturaLinjer.FakturaID=f.FakturaID)) AS FakturaSum,StatusID FROM Fakturaer f ORDER BY DatoFakturadato ASC");
      foreach ($rfaktuaer->result_array() as $faktura) {
        $faktura['Status'] = $this->FakturaStatus[$faktura['StatusID']];
        $fakturaer[] = $faktura;
      }
      if (isset($fakturaer)) {
        return $fakturaer;
      }
    }

    function faktura($ID) {
      $rfakturaer = $this->db->query("SELECT FakturaID,Referanse,Notater,PersonAnsvarligID FROM Fakturaer WHERE (FakturaID=".$ID.") LIMIT 1");
      if ($faktura = $rfakturaer->row_array()) {
        return $faktura;
      }
    }

    function lagrefaktura($ID = null, $faktura) {
      $faktura['DatoEndret'] = date('Y-m-d H:i:s');
      if ($ID == null) {
        $faktura['DatoRegistrert'] = $faktura['DatoEndret'];
        $this->db->query($this->db->insert_string('Fakturaer',$faktura));
        $faktura['FakturaID'] = $this->db->insert_id();
      } else {
        $this->db->query($this->db->update_string('Fakturaer',$faktura,'FakturaID='.$ID));
        $faktura['FakturaID'] = $ID;
      }
      return $faktura;
    }

  }
?>
