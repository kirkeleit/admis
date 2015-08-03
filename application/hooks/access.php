<?php
  class Access extends CI_Controller {
    var $UABruker;
    var $CI;

    function __construct(){
        $this->CI =& get_instance();
    }

    function InitAccess() {
      $this->CI =& get_instance();
      $brukere = $this->CI->db->query("SELECT Personer.PersonID,Brukernavn,Fornavn,Etternavn FROM Brukere,Personer WHERE (Brukere.PersonID=Personer.PersonID) AND (Brukernavn='".$_SERVER['PHP_AUTH_USER']."') LIMIT 1");
      if ($bruker = $brukere->row()) {
        $this->CI->db->query("UPDATE Brukere SET DatoSistInnlogget=Now() WHERE PersonID=".$bruker->PersonID." LIMIT 1");
        $UABruker['ID'] = $bruker->PersonID;
        $UABruker['Brukernavn'] = $bruker->Brukernavn;
        $UABruker['Fornavn'] = $bruker->Fornavn;
        $UABruker['Navn'] = $bruker->Fornavn." ".$bruker->Etternavn;
        $resultat = $this->CI->db->query("SELECT * FROM Faggrupper WHERE (PersonLederID=".$bruker->PersonID.") OR (PersonNestlederID=".$bruker->PersonID.")");
        foreach ($resultat->result() as $rad) {
          $faggruppe['FaggruppeID'] = $rad->FaggruppeID;
          $faggruppe['Navn'] = $rad->Navn;
          $faggrupper[] = $faggruppe;
          unset($faggruppe);
        }
        unset($resultat);
        if (isset($faggrupper)) {
          $UABruker['Faggrupper'] = $faggrupper;
        }
        $UABruker['UAP'] = array('100');
        $roller = $this->CI->db->query("SELECT UAP FROM PersonXRoller,BrukerRoller WHERE (PersonXRoller.PersonID=".$bruker->PersonID.") AND (PersonXRoller.RolleID=BrukerRoller.RolleID)");
        foreach ($roller->result() as $rolle) {
          $UAPs = unserialize($rolle->UAP);
          foreach ($UAPs as $UAP) {
            if (!in_array($UAP, $UABruker['UAP'])) {
            array_push($UABruker['UAP'],$UAP);
            }
          }
        }
        //$UABruker['UAP'] = array('200', '300', '400', '401','402','500','501','502');
        $data['UABruker'] = $UABruker;
        $this->CI->UABruker = $UABruker;
        $this->CI->load->vars($data);
      }
    }

  }
?>
