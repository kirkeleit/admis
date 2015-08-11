<?php
  class Access extends CI_Controller {
    var $UABruker;
    var $CI;

    function __construct(){
        $this->CI =& get_instance();
    }

    function InitAccess() {
      $this->CI =& get_instance();
      $brukere = $this->CI->db->query("SELECT kon_personer.ID,brukere.Brukernavn,kon_personer.Fornavn,kon_personer.Etternavn FROM brukere,kon_personer WHERE (brukere.PersonID=kon_personer.ID) AND (Brukernavn='".$_SERVER['PHP_AUTH_USER']."') LIMIT 1");
      if ($bruker = $brukere->row()) {
        $this->CI->db->query("UPDATE brukere SET DatoSistInnlogget=Now() WHERE PersonID=".$bruker->ID." LIMIT 1");
        $UABruker['ID'] = $bruker->ID;
        $UABruker['Brukernavn'] = $bruker->Brukernavn;
        $UABruker['Fornavn'] = $bruker->Fornavn;
        $UABruker['Navn'] = $bruker->Fornavn." ".$bruker->Etternavn;
        $resultat = $this->CI->db->query("SELECT * FROM faggrupper WHERE (LederID=".$bruker->ID.") OR (NestlederID=".$bruker->ID.")");
        foreach ($resultat->result() as $rad) {
          $faggruppe['ID'] = $rad->ID;
          $faggruppe['Navn'] = $rad->Navn;
          $faggrupper[] = $faggruppe;
          unset($faggruppe);
        }
        unset($resultat);
        if (isset($faggrupper)) {
          $UABruker['Faggrupper'] = $faggrupper;
        }
        $UABruker['UAP'] = array('100');
        $roller = $this->CI->db->query("SELECT * FROM personxroller,brukerroller WHERE (personxroller.PersonID=".$bruker->ID.") AND (personxroller.RolleID=brukerroller.ID)");
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
