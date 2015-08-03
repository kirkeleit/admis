<?php
  class Oppgaver_model extends CI_Model {

    var $OppgaveStatus = array(0 => "Ikke påbegynt", 1 => "Under arbeid", 2 => "Fullført");
    var $OppgavePrioritet = array(0 => "Lav", 1 => "Normal", 2 => "Høy");

    function oppgaver($filter = NULL) {
      $sql = "SELECT OppgaveID,DatoRegistrert,DatoFrist,PrioritetID,Tittel,Beskrivelse,PersonOpprettetID,(SELECT Fornavn FROM Personer WHERE (PersonID=o.PersonOpprettetID) LIMIT 1) AS PersonOpprettetNavn,PersonAnsvarligID,(SELECT Fornavn FROM Personer WHERE (PersonID=o.PersonAnsvarligID) LIMIT 1) AS PersonAnsvarligNavn,StatusID FROM Oppgaver o WHERE 1";
      if ($filter != NULL) {
        if (isset($filter['StatusID'])) {
          $sql = $sql." AND (StatusID='".$filter['StatusID']."')";
        }
        if (isset($filter['PersonAnsvarligID'])) {
          $sql = $sql." AND (PersonAnsvarligID=".$filter['PersonAnsvarligID'].")";
        }
      }
      $sql = $sql." ORDER BY PrioritetID DESC,DatoRegistrert ASC";
      $roppgaver = $this->db->query($sql);
      foreach ($roppgaver->result_array() as $oppgave) {
        $oppgave['Prioritet'] = $this->OppgavePrioritet[$oppgave['PrioritetID']];
        $oppgave['Status'] = $this->OppgaveStatus[$oppgave['StatusID']];
        $oppgaver[] = $oppgave;
        unset($oppgave);
      }
      if (isset($oppgaver)) {
        return $oppgaver;
      }
    }

    function oppgave($ID) {
      $roppgaver = $this->db->query("SELECT OppgaveID,DatoRegistrert,DatoFrist,PrioritetID,Tittel,Beskrivelse,PersonOpprettetID,PersonAnsvarligID,StatusID FROM Oppgaver WHERE (OppgaveID=".$ID.") LIMIT 1");
      foreach ($roppgaver->result_array() as $oppgave) {
        $oppgave['Notater'] = $this->notater($oppgave['OppgaveID']);
        $oppgave['Prioritet'] = $this->OppgavePrioritet[$oppgave['PrioritetID']];
        $oppgave['Status'] = $this->OppgaveStatus[$oppgave['StatusID']];
        return $oppgave;
      }
    }

    function notater($ID) {
      $rnotater = $this->db->query("SELECT NotatID,OppgaveID,DatoRegistrert,PersonID,(SELECT Fornavn FROM Personer WHERE (PersonID=n.PersonID) LIMIT 1) AS PersonNavn,Notat FROM OppgaveNotater n WHERE (OppgaveID=".$ID.") ORDER BY DatoRegistrert ASC");
      foreach ($rnotater->result_array() as $notat) {
        $notater[] = $notat;
      }
      if (isset($notater)) { return $notater; }
    }

    function lagreoppgave($ID = 0,$oppgave) {
      $oppgave['DatoEndret'] = date("Y-m-d H:i:s");
      if (isset($oppgave['Notat'])) {
        $Notat = $oppgave['Notat'];
        unset($oppgave['Notat']);
      }
      if ($ID == 0) {
        $oppgave['DatoRegistrert'] = $oppgave['DatoEndret'];
        $oppgave['PersonOpprettetID'] = $this->UABruker['ID'];
        $this->db->query($this->db->insert_string('Oppgaver',$oppgave));
        $oppgave['OppgaveID'] = $this->db->insert_id();
      } else {
        $goppgave = $this->oppgave($ID);
        $this->db->query($this->db->update_string('Oppgaver',$oppgave,'OppgaveID='.$ID));
        $oppgave['OppgaveID'] = $ID;
      }
      if (isset($Notat)) {
        $this->db->query($this->db->insert_string('OppgaveNotater',array('OppgaveID'=>$oppgave['OppgaveID'],'DatoRegistrert'=>date('Y-m-d H:i:s'),'PersonID'=>$this->UABruker['ID'],'Notat'=>$Notat)));
      }
      if ((!isset($goppgave) and ($oppgave['PersonAnsvarligID'] > 0)) or (($oppgave['PersonAnsvarligID'] != $goppgave['PersonAnsvarligID']) and ($oppgave['PersonAnsvarligID'] > 0))) {
        $this->db->query("INSERT INTO VarslingEposter (DatoRegistrert,PersonMottakerID,Emne,Meldingstekst) VALUES (Now(),".$oppgave['PersonAnsvarligID'].",'[admis] Oppgave tildelt deg: ".$oppgave['Tittel']."','Frist: ".($oppgave['DatoFrist'] != '' ? date("d.m.Y",strtotime($oppgave['DatoFrist'])) : '')."\nTittel: ".$oppgave['Tittel']."\nBeskrivelse: ".$oppgave['Beskrivelse']."')");
      }
      if (($oppgave['StatusID'] == 2) and (isset($goppgave))) {
        $this->db->query("INSERT INTO VarslingEposter (DatoRegistrert,PersonMottakerID,Emne,Meldingstekst) VALUES (Now(),".$goppgave['PersonOpprettetID'].",'[admis] Oppgave er utført: ".$oppgave['Tittel']."','Frist: ".($oppgave['DatoFrist'] != '' ? date("d.m.Y",strtotime($oppgave['DatoFrist'])) : '')."\nTittel: ".$oppgave['Tittel']."\nBeskrivelse: ".$oppgave['Beskrivelse']."')");
      }
      return $oppgave;
    }

    function slettoppgave($ID) {
      $this->db->query("DELETE FROM Oppgaver WHERE OppgaveID=".$ID." LIMIT 1");
      $this->db->query("DELETE FROM OppgaveNotater WHERE OppgaveID=".$ID." LIMIT 1");
    }

  }
?>
