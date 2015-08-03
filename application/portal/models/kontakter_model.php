<?php
  class Kontakter_model extends CI_Model {

    function personer() {
      $resultat = $this->db->query("SELECT *,TIMESTAMPDIFF(YEAR,Fodselsdato,CURDATE()) AS Alder FROM kon_personer WHERE (DatoSlettet Is Null) ORDER BY Fornavn, Etternavn");
      foreach ($resultat->result() as $rad) {
        $person['ID'] = $rad->ID;
        $person['Fornavn'] = $rad->Fornavn;
        $person['Etternavn'] = $rad->Etternavn;
        $person['Mobilnr'] = $rad->Mobilnr;
        $person['Epost'] = $rad->Epost;
        if ($rad->Alder != NULL) {
          $person['Alder'] = $rad->Alder;
        } else {
          $person['Alder'] = "";
        }
        $medlemmer = $this->db->query("SELECT * FROM kon_medlemmer WHERE (PersonID=".$rad->ID.")");
        if ($medlemmer->num_rows() > 0) {
          $person['Medlem'] = 1;
        } else {
          $person['Medlem'] = 0;
        }
        unset($medlemmer);
        $brukere = $this->db->query("SELECT * FROM brukere WHERE (PersonID=".$rad->ID.")");
        if ($brukere->num_rows() > 0) {
          $person['Bruker'] = 1;
        } else {
          $person['Bruker'] = 0;
        }
        unset($brukere);
        $personer[] = $person;
        unset($person);
      }
      if (isset($personer)) {
        return $personer;
      }
    }

    function lagreperson($person) {
      if ($person['ID'] == 0) {
        $this->db->query("INSERT INTO kon_personer (DatoRegistrert) VALUES (Now())");
        $person['ID'] = $this->db->insert_id();
      }
      $this->db->query("UPDATE kon_personer SET Fornavn='".$person['Fornavn']."' WHERE ID=".$person['ID']." LIMIT 1");
      $this->db->query("UPDATE kon_personer SET Etternavn='".$person['Etternavn']."' WHERE ID=".$person['ID']." LIMIT 1");
      $this->db->query("UPDATE kon_personer SET Fodselsdato='".date('Y-m-d',strtotime($person['Fodselsdato']))."' WHERE ID=".$person['ID']." LIMIT 1");
      $this->db->query("UPDATE kon_personer SET Adresse='".$person['Adresse']."' WHERE ID=".$person['ID']." LIMIT 1");
      $this->db->query("UPDATE kon_personer SET Postnr='".$person['Postnr']."' WHERE ID=".$person['ID']." LIMIT 1");
      $this->db->query("UPDATE kon_personer SET Mobilnr='".$person['Mobilnr']."' WHERE ID=".$person['ID']." LIMIT 1");
      $this->db->query("UPDATE kon_personer SET Epost='".$person['Epost']."' WHERE ID=".$person['ID']." LIMIT 1");
      $this->db->query("UPDATE kon_personer SET DatoEndret=Now() WHERE ID=".$person['ID']." LIMIT 1");
      if ($person['Medlem'] == 0) {
        $medlemmer = $this->db->query("SELECT * FROM kon_medlemmer WHERE (PersonID=".$person['ID'].")");
        if ($medlemmer->num_rows() > 0) {
          $this->db->query("DELETE FROM kon_medlemmer WHERE kon_medlemmer.PersonID=".$person['ID']." LIMIT 1");
        }
      } elseif ($person['Medlem'] == 1) {
        $medlemmer = $this->db->query("SELECT * FROM kon_medlemmer WHERE (PersonID=".$person['ID'].")");
        if ($medlem = $medlemmer->row()) {
          $this->db->query("UPDATE kon_medlemmer SET Relasjonsnr='".$person['Relasjonsnr']."' WHERE PersonID=".$person['ID']." LIMIT 1");
          $this->db->query("UPDATE kon_medlemmer SET Medlemsdato='".date("Y-m-d",strtotime($person['Medlemsdato']))."' WHERE PersonID=".$person['ID']." LIMIT 1");
          $this->db->query("UPDATE kon_medlemmer SET Initialer='".$person['Initialer']."' WHERE PersonID=".$person['ID']." LIMIT 1");
        } else {
          $this->db->query("INSERT INTO kon_medlemmer (PersonID,Relasjonsnr,Medlemsdato,Initialer) values (".$person['ID'].",'".$person['Relasjonsnr']."','".date("Y-m-d",strtotime($person['Medlemsdato']))."','".$person['Initialer']."')");
        }
      }
      if ($person['Bruker'] == 0) {
        $brukere = $this->db->query("SELECT * FROM brukere WHERE (PersonID=".$person['ID'].")");
        if ($brukere->num_rows() > 0) {
          $this->db->query("DELETE FROM brukere WHERE PersonID=".$person['ID']." LIMIT 1");
          $this->db->query("DELETE FROM personxroller WHERE PersonID=".$person['ID']);
        }
      } elseif ($person['Bruker'] == 1) {
        $brukere = $this->db->query("SELECT * FROM brukere WHERE (PersonID=".$person['ID'].")");
        if ($bruker = $brukere->row()) {
          $this->db->query("UPDATE brukere SET Brukernavn='".$person['Brukernavn']."' WHERE PersonID=".$person['ID']." LIMIT 1");
          if (isset($person['NyttPassord'])) {
            $this->db->query("UPDATE brukere SET Passord=MD5('".$person['NyttPassord']."') WHERE PersonID=".$person['ID']." LIMIT 1");
          }
        } else {
          $this->db->query("INSERT INTO brukere (PersonID,Brukernavn,Passord,DatoRegistrert) values (".$person['ID'].",'".$person['Brukernavn']."',MD5('".$person['NyttPassord']."'),NOW())");
          $this->db->query("INSERT INTO personxroller (PersonID,RolleID) VALUES (".$person['ID'].",4)");
        }
      }
      if ((isset($person['OrgID']) and ($person['OrgID'] != ""))) {
        $this->db->query("INSERT INTO kon_personxorganisasjon (PersonID,OrganisasjonID) VALUES (".$person['ID'].",".$person['OrgID'].")");
      }
      return $person;
    }

    function slettperson($ID) {
      $this->db->query("UPDATE kon_personer SET DatoSlettet=Now() WHERE ID=".$ID." LIMIT 1");
    }

    function lagreorganisasjon($organisasjon) {
      if ($organisasjon['ID'] == 0) {
        $this->db->query("INSERT INTO kon_organisasjoner (DatoRegistrert,Navn) VALUES (Now(),'".$organisasjon['Navn']."')");
        $organisasjon['ID'] = $this->db->insert_id();
      }
      $this->db->query("UPDATE kon_organisasjoner SET Navn='".$organisasjon['Navn']."' WHERE ID=".$organisasjon['ID']." LIMIT 1");
      $this->db->query("UPDATE kon_organisasjoner SET Orgnummer='".$organisasjon['Orgnummer']."' WHERE ID=".$organisasjon['ID']." LIMIT 1");
      $this->db->query("UPDATE kon_organisasjoner SET Telefonnr='".$organisasjon['Telefonnr']."' WHERE ID=".$organisasjon['ID']." LIMIT 1");
      $this->db->query("UPDATE kon_organisasjoner SET Epost='".$organisasjon['Epost']."' WHERE ID=".$organisasjon['ID']." LIMIT 1");
      $this->db->query("UPDATE kon_organisasjoner SET Datoendret=Now() WHERE ID=".$organisasjon['ID']." LIMIT 1");
      return $organisasjon;
    }

    function organisasjoner() {
      $resultat = $this->db->query("SELECT * FROM kon_organisasjoner WHERE (DatoSlettet Is Null) ORDER BY Navn");
      foreach ($resultat->result() as $rad) {
        $organisasjon['ID'] = $rad->ID;
        $organisasjon['Navn'] = $rad->Navn;
        $organisasjon['Orgnummer'] = $rad->Orgnummer;
        $organisasjon['Epost'] = $rad->Epost;
        $organisasjon['Telefonnr'] = $rad->Telefonnr;
        $organisasjoner[] = $organisasjon;
        unset($organisasjon);
      }
      if (isset($organisasjoner)) {
        return $organisasjoner;
      }
    }

    function organisasjon($ID) {
      $resultat = $this->db->query("SELECT * FROM kon_organisasjoner WHERE (ID=".$ID.") LIMIT 1");
      if ($rad = $resultat->row()) {
        $data['ID'] = $rad->ID;
        $data['Navn'] = $rad->Navn;
        $data['Orgnummer'] = $rad->Orgnummer;
        $data['Epost'] = $rad->Epost;
        $data['Telefonnr'] = $rad->Telefonnr;

        $personer = $this->db->query("SELECT * FROM kon_personxorganisasjon,kon_personer WHERE kon_personxorganisasjon.PersonID=kon_personer.ID AND kon_personxorganisasjon.OrganisasjonID=".$rad->ID);
        foreach ($personer->result() as $person) {
          $kontaktperson['ID'] = $person->ID;
          $kontaktperson['Fornavn'] = $person->Fornavn;
          $kontaktperson['Etternavn'] = $person->Etternavn;
          $kontaktperson['Epost'] = $person->Epost;
          $kontaktperson['Mobilnr'] = $person->Mobilnr;
          $kontaktperson['Rolle'] = $person->Rolle;
          $kontaktpersoner[] = $kontaktperson;
          unset($kontaktperson);
        }
        if (isset($kontaktpersoner)) {
          $data['Kontaktpersoner'] = $kontaktpersoner;
        }

        return $data;
      }
    }

    function slettorganisasjon($ID) {
      $this->db->query("UPDATE kon_organisasjoner SET DatoSlettet=Now() WHERE ID=".$ID." LIMIT 1");
    }

    function medlemmer() {
      $resultat = $this->db->query("SELECT * FROM kon_medlemmer,kon_personer WHERE kon_personer.ID=kon_medlemmer.PersonID ORDER BY Fornavn, Etternavn");
      foreach ($resultat->result() as $rad) {
        $data['ID'] = $rad->PersonID;
        $data['Initialer'] = $rad->Initialer;
        $data['Fornavn'] = $rad->Fornavn;
        $data['Etternavn'] = $rad->Etternavn;
        $medlemmer[] = $data;
        unset($data);
      }
      if (isset($medlemmer)) {
        return $medlemmer;
      }
    }

    function person($ID) {
      $resultat = $this->db->query("SELECT * FROM kon_personer WHERE (ID=".$ID.") LIMIT 1");
      if ($rad = $resultat->row()) {
        $data['ID'] = $rad->ID;
        $data['Fornavn'] = $rad->Fornavn;
        $data['Etternavn'] = $rad->Etternavn;
        $data['Fodselsdato'] = date("d.m.Y",strtotime($rad->Fodselsdato));
        $data['Adresse'] = $rad->Adresse;
        $data['Postnr'] = $rad->Postnr;
        $data['Mobilnr'] = $rad->Mobilnr;
        $data['Epost'] = $rad->Epost;
        $medlemmer = $this->db->query("SELECT * FROM kon_medlemmer WHERE (PersonID=".$rad->ID.")");
        if ($medlemmer->num_rows() > 0) {
          $medlem = $medlemmer->row();
          $data['Medlem'] = 1;
          $data['Relasjonsnr'] = $medlem->Relasjonsnr;
          $data['Medlemsdato'] = date("d.m.Y",strtotime($medlem->Medlemsdato));
          $data['Initialer'] = $medlem->Initialer;
          unset($medlem);
        } else {
          $data['Medlem'] = 0;
          $data['Relasjonsnr'] = "";
          $data['Medlemsdato'] = "";
          $data['Initialer'] = "";
        }
        unset($medlemmer);
        $brukere = $this->db->query("SELECT * FROM brukere WHERE (PersonID=".$rad->ID.")");
        if ($brukere->num_rows() > 0) {
          $bruker = $brukere->row();
          $data['Bruker'] = 1;
          $data['Brukernavn'] = $bruker->Brukernavn;
          unset($bruker);
        } else {
          $data['Bruker'] = 0;
          $data['Brukernavn'] = "";
        }
        unset($brukere);
        $rgrupper = $this->db->query("SELECT kon_grupper.ID,kon_grupper.Navn FROM kon_personxgruppe, kon_grupper WHERE (kon_personxgruppe.GruppeID=kon_grupper.ID) AND (kon_personxgruppe.PersonID=".$rad->ID.")");
        foreach ($rgrupper->result() as $rgruppe) {
          $gruppe['ID'] = $rgruppe->ID;
          $gruppe['Navn'] = $rgruppe->Navn;
          $data['Grupper'][] = $gruppe;
          unset($gruppe);
          unset($rgruppe);
        }
        unset($rgrupper);
        return $data;
      }
    }

    function faggrupper() {
      $resultat = $this->db->query("SELECT * FROM faggrupper ORDER BY Navn ASC");
      foreach ($resultat->result() as $rad) {
        $faggruppe['ID'] = $rad->ID;
        $faggruppe['Navn'] = $rad->Navn;
        $faggruppe['LederID'] = $rad->LederID;
        $medlemmer = $this->db->query("SELECT * FROM kon_medlemmer,kon_personer WHERE kon_personer.ID=kon_medlemmer.PersonID AND kon_medlemmer.ID=".$rad->LederID." LIMIT 1");
        if ($medlem = $medlemmer->row()) {
          $faggruppe['Leder']['Fornavn'] = $medlem->Fornavn;
        }
        $faggrupper[] = $faggruppe;
        unset($faggruppe);
      }
      if (isset($faggrupper)) {
        return $faggrupper;
      }
    }

    function faggruppe($ID) {
      $resultat = $this->db->query("SELECT * FROM faggrupper WHERE (ID=".$ID.") LIMIT 1");
      if ($rad = $resultat->row()) {
        $faggruppe['ID'] = $rad->ID;
        $faggruppe['Navn'] = $rad->Navn;
        if ($rad->LederID > 0) {
          $personer = $this->db->query("SELECT * FROM kon_personer WHERE (ID=".$rad->LederID.") LIMIT 1");
          if ($person = $personer->row()) {
            $faggruppe['Leder']['ID'] = $person->ID;
            $faggruppe['Leder']['Navn'] = $person->Fornavn." ".$person->Etternavn;
            unset($person);
          }
          unset($personer);
        }
        if ($rad->NestlederID > 0) {
          $personer = $this->db->query("SELECT * FROM kon_personer WHERE (ID=".$rad->NestlederID.") LIMIT 1");
          if ($person = $personer->row()) {
            $faggruppe['Nestleder']['ID'] = $person->ID;
            $faggruppe['Nestleder']['Navn'] = $person->Fornavn." ".$person->Etternavn;
            unset($person);
          }
          unset($personer);
        }
        $faggruppe['Beskrivelse'] = $rad->Beskrivelse;
      }
      return $faggruppe;
    }

    function grupper() {
      $resultat = $this->db->query("SELECT * FROM kon_grupper ORDER BY Navn");
      foreach ($resultat->result() as $rad) {
        $gruppe['ID'] = $rad->ID;
        $gruppe['Navn'] = $rad->Navn;
        $gruppe['Beskrivelse'] = $rad->Beskrivelse;
        $personer = $this->db->query("SELECT * FROM kon_personxgruppe WHERE (GruppeID=".$rad->ID.")");
        $gruppe['Antall'] = $personer->num_rows();
        unset($personer);
        $grupper[] = $gruppe;
        unset($gruppe);
      }
      return $grupper;
    }

    function gruppe() {
    }

    function koblepersongruppe($PersonID,$GruppeID) {
      $this->db->query("INSERT INTO kon_personxgruppe (PersonID,GruppeID) VALUES (".$PersonID.",".$GruppeID.")");
    }

  }
?>
