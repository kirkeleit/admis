<?php
  class Raadet_model extends CI_Model {

    var $SakStatus = array(0 => "Under behandling", 1 => "Ferdig behandlet");
    var $MoteType = array(1 => "Rådsmøte");

    function saksliste($filter = NULL) {
      $sql = "SELECT SakID,SaksAr,SaksNummer,DatoRegistrert,PersonID,(SELECT Fornavn FROM Personer WHERE (PersonID=s.PersonID) LIMIT 1) AS PersonNavn,Tittel,(SELECT COUNT(*) FROM SakNotater WHERE (SakID=s.SakID)) AS Notater,IF((SELECT COUNT(*) FROM SakNotater WHERE (SakID=s.SakID) AND (Notatstype=2)) > 0,1,0) AS StatusID FROM Saker s WHERE 1";
      if ($filter != NULL) {
        if (isset($filter['StatusID'])) {
          $sql = $sql." HAVING (StatusID='".$filter['StatusID']."')";
        }
      }
      $sql = $sql." ORDER BY SaksAr,SaksNummer,DatoRegistrert";
      $rsaker = $this->db->query($sql);
      foreach ($rsaker->result_array() as $sak) {
        $sak['Status'] = $this->SakStatus[$sak['StatusID']];
        $saker[] = $sak;
        unset($sak);
      }
      if (isset($saker)) {
        return $saker;
      }
    }

    function sak($ID) {
      $rsaker = $this->db->query("SELECT SakID,SaksAr,SaksNummer,DatoRegistrert,PersonID,(SELECT Fornavn FROM Personer WHERE (PersonID=s.PersonID) LIMIT 1) AS PersonNavn,Tittel,Saksbeskrivelse,(SELECT COUNT(*) FROM SakNotater WHERE (SakID=s.SakID)) AS Notater,IF((SELECT COUNT(*) FROM SakNotater WHERE (SakID=s.SakID) AND (Notatstype=2)) > 0,1,0) AS StatusID FROM Saker s WHERE (SakID=".$ID.") ORDER BY SaksAr,SaksNummer,DatoRegistrert");
      foreach ($rsaker->result_array() as $sak) {
        $sak['Status'] = $this->SakStatus[$sak['StatusID']];
        return $sak;
      }
    }

    function lagresak($ID=null,$sak) {
      $sak['DatoEndret'] = date('Y-m-d H:i:s');
      if ($ID == null) {
        $sak['DatoRegistrert'] = $sak['DatoEndret'];
        $this->db->query($this->db->insert_string('Saker',$sak));
        $sak['SakID'] = $this->db->insert_id();
      } else {
        $this->db->query($this->db->update_string('Saker',$sak,'SakID='.$ID));
        $sak['SakID'] = $ID;
      }
      return $sak;
    }

    function lagsaksnummer($ID) {
      $this->db->query("UPDATE Saker SET SaksAr=Year(Now()) WHERE SakID=".$ID." LIMIT 1");
      $rsaker = $this->db->query("SELECT * FROM Saker WHERE (SaksAr=Year(Now()))");
      $nr = $rsaker->num_rows();
      $this->db->query("UPDATE Saker SET SaksNummer='".$nr."' WHERE SakID=".$ID." LIMIT 1");
    }

    function saksnotater($ID) {
      $rnotater = $this->db->query("SELECT NotatID,SakID,DatoRegistrert,PersonID,(SELECT Fornavn FROM Personer WHERE (PersonID=n.PersonID) LIMIT 1) AS PersonNavn,Notat,IF(Notatstype=2,'Vedtak','Notat') AS Notatstype FROM SakNotater n WHERE (SakID=".$ID.") ORDER BY DatoRegistrert");
      foreach ($rnotater->result_array() as $notat) {
        $notater[] = $notat;
      }
      if (isset($notater)) {
        return $notater;
      }
    }

    function lagrenotat($notat) {
      $this->db->query($this->db->insert_string('SakNotater',array('SakID' => $notat['SakID'], 'MoteID' => $notat['MoteID'], 'DatoRegistrert' => date('Y-m-d H:i:s'), 'DatoEndret' => date('Y-m-d H:i:s'), 'PersonID' => $notat['PersonID'], 'Notat' => $notat['Notat'], 'Notatstype' => $notat['Notatstype'])));
    }

    function moter() {
      $rmoter = $this->db->query("SELECT MoteID,MotetypeID,DatoPlanlagtStart,DatoPlanlagtSlutt,Lokasjon FROM Moter ORDER BY DatoPlanlagtStart ASC");
      foreach ($rmoter->result_array() as $mote) {
        $mote['Motetype'] = $this->MoteType[$mote['MotetypeID']];
        $moter[] = $mote;
      }
      return $moter;
    }

    function mote($ID) {
      $rmoter = $this->db->query("SELECT MoteID,MotetypeID,DatoPlanlagtStart,DatoPlanlagtSlutt,Lokasjon FROM Moter WHERE (MoteID=".$ID.") LIMIT 1");
      if ($mote = $rmoter->row_array()) {
        return $mote;
      }
    }

  }
?>
