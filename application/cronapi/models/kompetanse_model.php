<?php
  class Kompetanse_model extends CI_Model {

    function faggrupper() {
      $rfaggrupper = $this->db->query("SELECT FaggruppeID,Navn,PersonLederID,(SELECT Fornavn FROM Personer WHERE (Personer.PersonID=f.PersonLederID) LIMIT 1) AS PersonLederNavn,PersonNestlederID,(SELECT Fornavn FROM Personer WHERE (Personer.PersonID=f.PersonNestlederID) LIMIT 1) AS PersonNestlederNavn,(SELECT COUNT(*) FROM Utstyrsliste WHERE (FaggruppeID=f.FaggruppeID)) AS UtstyrAntall,(SELECT COUNT(*) FROM Prosjekter WHERE (FaggruppeID=f.FaggruppeID)) AS ProsjekterAntall FROM Faggrupper f ORDER BY Navn ASC");
      foreach ($rfaggrupper->result_array() as $faggruppe) {
        $faggrupper[] = $faggruppe;
        unset($faggruppe);
      }
      if (isset($faggrupper)) {
        return $faggrupper;
      }
    }

    function faggruppe($ID) {
      $rfaggrupper = $this->db->query("SELECT FaggruppeID,Navn,PersonLederID,PersonNestlederID,Beskrivelse FROM Faggrupper WHERE (FaggruppeID=".$ID.") LIMIT 1");
      if ($faggruppe = $rfaggrupper->row_array()) {
        return $faggruppe;
      }
    }

    function faggruppelagre($ID=null,$faggruppe) {
      $faggruppe['DatoEndret'] = date('Y-m-d H:i:s');
      if ($ID == null) {
        $faggruppe['DatoRegistrert'] = $faggruppe['DatoEndret'];
        $this->db->query($this->db->insert_string('Faggrupper',$faggruppe));
        $faggruppe['FaggruppeID'] = $this->db->insert_id();
      } else {
        $this->db->query($this->db->update_string('Faggrupper',$faggruppe,'FaggruppeID='.$ID));
        $faggruppe['FaggruppeID'] = $ID;
      }
      return $faggruppe;
    }

    var $KompetanseType = array(0 => 'RK-kurs',1 => 'RK-erfaring',2 => 'Sertifikat',3 => 'Intern oppplæring');
    function kompetanseliste() {
      $rkompetanseliste = $this->db->query("SELECT KompetanseID,TypeID,Navn,Beskrivelse,Timer,Gyldighet,(SELECT COUNT(*) FROM PersonXKompetanse WHERE (PersonXKompetanse.KompetanseID=k.KompetanseID)) AS Antall FROM Kompetanse k ORDER BY TypeID,Navn");
      foreach ($rkompetanseliste->result_array() as $kompetanse) {
        $kompetanse['TypeNavn'] = $this->KompetanseType[$kompetanse['TypeID']];
        $kompetanseliste[] = $kompetanse;
        unset($kompetanse);
      }
      if (isset($kompetanseliste)) {
        return $kompetanseliste;
      }
    }

    function kompetanseinfo($ID) {
      $rkompetanseliste = $this->db->query("SELECT KompetanseID,TypeID,Navn,Beskrivelse,Timer,Gyldighet FROM Kompetanse WHERE (KompetanseID=".$ID.") LIMIT 1");
      if ($kompetanse = $rkompetanseliste->row_array()) {
        $rpersoner = $this->db->query("SELECT Personer.PersonID,Fornavn,Etternavn,Mobilnr,Epost,DatoGodkjent,Kommentar FROM Personer,PersonXKompetanse WHERE (PersonXKompetanse.PersonID=Personer.PersonID) AND (PersonXKompetanse.KompetanseID=".$ID.")");
        $kompetanse['Personer'] = $rpersoner->result_array();
        return $kompetanse;
      }
    }

    function kompetanselagre($ID=null,$kompetanse) {
      $kompetanse['DatoEndret'] = date('Y-m-d H:i:s');
      if ($ID == null) {
        $kompetanse['DatoRegistrert'] = $kompetanse['DatoEndret'];
        $this->db->query($this->db->insert_string('Kompetanse',$kompetanse));
        $kompetanse['KompetanseID'] = $this->db->insert_id();
      } else {
        $this->db->query($this->db->update_string('Kompetanse',$kompetanse,'KompetanseID='.$ID));
        $kompetanse['KompetanseID'] = $ID;
      }
      return $kompetanse;
    }

  }
?>
