<?php
  class Kontakter_model extends CI_Model {

    function personer() {
      $rpersoner = $this->db->query("SELECT PersonID,Fornavn,Etternavn,Mobilnr,Epost,AdresseID,(SELECT Poststed FROM PostAdresser,PostNummer WHERE (PostAdresser.Postnummer=PostNummer.Postnummer) AND (AdresseID=p.AdresseID) LIMIT 1) As Poststed,TIMESTAMPDIFF(YEAR,DatoFodselsdato,CURDATE()) AS Alder FROM Personer p ORDER BY Fornavn, Etternavn");
      foreach ($rpersoner->result_array() as $person) {
        $personer[] = $person;
        unset($person);
      }
      if (isset($personer)) {
        return $personer;
      }
    }

    function person($ID) {
      $rpersoner = $this->db->query("SELECT PersonID,Fornavn,Etternavn,DatoFodselsdato,Mobilnr,Epost,AdresseID,Medlem,Initialer,Relasjonsnummer,DatoMedlemsdato FROM Personer WHERE (PersonID=".$ID.") LIMIT 1");
      if ($person = $rpersoner->row_array()) {
        $person['Adresser'] = $this->personadresser($person['PersonID']);
        $person['Medlemsgrupper'] = $this->medlemsgrupper($person['PersonID']);
        return $person;
      }
    }

    private function personadresser($ID) {
      $radresser = $this->db->query("SELECT PostAdresser.AdresseID,Adresse1,Adresse2,PostAdresser.Postnummer,Poststed FROM PostAdresseXPerson,PostAdresser,PostNummer WHERE (PostAdresser.AdresseID=PostAdresseXPerson.AdresseID) AND (PostAdresseXPerson.PersonID=".$ID.") AND (PostNummer.Postnummer=PostAdresser.Postnummer)");
      foreach ($radresser->result_array() as $adresse) {
        $adresser[] = $adresse;
        unset($adresse);
      }
      if (isset($adresser)) {
        return $adresser;
      }
    }

    function lagreperson($ID = null,$person) {
      $person['DatoEndret'] = date("Y-m-d H:i:s");
      if ($ID == null) {
        $person['DatoRegistrert'] = $person['DatoEndret'];
        $this->db->query($this->db->insert_string('Personer',$person));
        $person['PersonID'] = $this->db->insert_id();
      } else {
        $this->db->query($this->db->update_string('Personer',$person,'PersonID='.$ID));
        $person['PersonID'] = $ID;
      }
      return $person;
    }

    function lagreadresseperson($ID = null,$PersonID,$adresse) {
      if ($ID == null) {
        $this->db->query($this->db->insert_string('PostAdresser',$adresse));
        $adresse['AdresseID'] = $this->db->insert_id();
        $this->db->query($this->db->insert_string('PostAdresseXPerson',array('AdresseID'=>$adresse['AdresseID'],'PersonID'=>$PersonID)));
      } else {
        $this->db->query($this->db->update_string('PostAdresser',$adresse,'AdresseID='.$ID));
        $adresse['AdresseID'] = $ID;
      }
      $this->db->query($this->db->update_string('Personer',array('AdresseID'=>$adresse['AdresseID']),'PersonID='.$PersonID));
      return $adresse;
    }

    function lagreadresseorganisasjon($ID = null,$OrganisasjonID,$adresse) {
      if ($ID == null) {
        $this->db->query($this->db->insert_string('PostAdresser',$adresse));
        $adresse['AdresseID'] = $this->db->insert_id();
        $this->db->query($this->db->insert_string('PostAdresseXOrganisasjon',array('AdresseID'=>$adresse['AdresseID'],'OrganisasjonID'=>$OrganisasjonID)));
      } else {
        $this->db->query($this->db->update_string('PostAdresser',$adresse,'AdresseID='.$ID));
        $adresse['AdresseID'] = $ID;
      }
      $this->db->query($this->db->update_string('Organisasjoner',array('AdresseID'=>$adresse['AdresseID']),'OrganisasjonID='.$OrganisasjonID));
      return $adresse;
    }

    function slettperson($ID) {
      $this->db->query("DELETE FROM Personer WHERE PersonID=".$ID." LIMIT 1");
    }

    function lagreorganisasjon($ID=null,$organisasjon) {
      $organisasjon['DatoEndret'] = date("Y-m-d H:i:s");
      if ($ID == null) {
        $organisasjon['DatoRegistrert'] = $organisasjon['DatoEndret'];
        $this->db->query($this->db->insert_string('Organisasjoner',$organisasjon));
        $organisasjon['OrganisasjonID'] = $this->db->insert_id();
      } else {
        $this->db->query($this->db->update_string('Organisasjoner',$organisasjon,'OrganisasjonID='.$ID));
        $organisasjon['OrganisasjonID'] = $ID;
      }
      return $organisasjon;
    }

    function organisasjoner() {
      $rorganisasjoner = $this->db->query("SELECT OrganisasjonID,Navn,Orgnummer,Epost,Telefonnr,(SELECT Poststed FROM PostAdresser,PostNummer WHERE (PostAdresser.Postnummer=PostNummer.Postnummer) AND (AdresseID=o.AdresseID) LIMIT 1) As Poststed FROM Organisasjoner o ORDER BY Navn");
      foreach ($rorganisasjoner->result_array() as $organisasjon) {
        $organisasjoner[] = $organisasjon;
        unset($organisasjon);
      }
      if (isset($organisasjoner)) {
        return $organisasjoner;
      }
    }

    function organisasjon($ID) {
      $rorganisasjoner = $this->db->query("SELECT OrganisasjonID,Navn,Orgnummer,Epost,Telefonnr FROM Organisasjoner WHERE (OrganisasjonID=".$ID.") LIMIT 1");
      if ($organisasjon = $rorganisasjoner->row_array()) {
        $organisasjon['Adresser'] = $this->organisasjonadresser($organisasjon['OrganisasjonID']);
        return $organisasjon;
      }
    }

    private function organisasjonadresser($ID) {
      $radresser = $this->db->query("SELECT PostAdresser.AdresseID,Adresse1,Adresse2,PostAdresser.Postnummer,Poststed FROM PostAdresseXOrganisasjon,PostAdresser,PostNummer WHERE (PostAdresser.AdresseID=PostAdresseXOrganisasjon.AdresseID) AND (PostAdresseXOrganisasjon.OrganisasjonID=".$ID.") AND (PostNummer.Postnummer=PostAdresser.Postnummer)");
      foreach ($radresser->result_array() as $adresse) {
        $adresser[] = $adresse;
        unset($adresse);
      }
      if (isset($adresser)) {
        return $adresser;
      }
    }

    function slettorganisasjon($ID) {
      $this->db->query("DELETE FROM Organisasjoner WHERE OrganisasjonID=".$ID." LIMIT 1");
    }

    function medlemmer() {
      $resultat = $this->db->query("SELECT * FROM Medlemmer,Personer WHERE Personer.PersonID=Medlemmer.PersonID ORDER BY Fornavn, Etternavn");
      foreach ($resultat->result() as $rad) {
        $data['PersonID'] = $rad->PersonID;
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

    function faggrupper() {
      $resultat = $this->db->query("SELECT * FROM Faggrupper ORDER BY Navn ASC");
      foreach ($resultat->result() as $rad) {
        $faggruppe['FaggruppeID'] = $rad->FaggruppeID;
        $faggruppe['Navn'] = $rad->Navn;
        $faggruppe['PersonLederID'] = $rad->PersonLederID;
        $medlemmer = $this->db->query("SELECT * FROM Medlemmer,Personer WHERE Personer.PersonID=Medlemmer.PersonID AND Medlemmer.PersonID=".$rad->PersonLederID." LIMIT 1");
        if ($medlem = $medlemmer->row()) {
          $faggruppe['PersonLederNavn'] = $medlem->Fornavn;
        }
        $faggrupper[] = $faggruppe;
        unset($faggruppe);
      }
      if (isset($faggrupper)) {
        return $faggrupper;
      }
    }

    function faggruppe($ID) {
      $resultat = $this->db->query("SELECT * FROM Faggrupper WHERE (FaggruppeID=".$ID.") LIMIT 1");
      if ($rad = $resultat->row()) {
        $faggruppe['FaggruppeID'] = $rad->FaggruppeID;
        $faggruppe['Navn'] = $rad->Navn;
        if ($rad->PersonLederID > 0) {
          $personer = $this->db->query("SELECT * FROM Personer WHERE (PersonID=".$rad->PersonLederID.") LIMIT 1");
          if ($person = $personer->row()) {
            $faggruppe['PersonLederID'] = $person->PersonID;
            $faggruppe['PersonLederNavn'] = $person->Fornavn;
            unset($person);
          }
          unset($personer);
        }
        if ($rad->PersonNestlederID > 0) {
          $personer = $this->db->query("SELECT * FROM Personer WHERE (PersonID=".$rad->PersonNestlederID.") LIMIT 1");
          if ($person = $personer->row()) {
            $faggruppe['PersonNestlederID'] = $person->PersonID;
            $faggruppe['PersonNestlederNavn'] = $person->Fornavn;
            unset($person);
          }
          unset($personer);
        }
        $faggruppe['Beskrivelse'] = $rad->Beskrivelse;
      }
      return $faggruppe;
    }

    function medlemsgrupper($PersonID=null) {
      if ($PersonID == null) {
        $sql = "SELECT GruppeID,Navn,Beskrivelse,(SELECT COUNT(*) FROM PersonXMedlemsgruppe WHERE (GruppeID=g.GruppeID)) AS Antall,Alarmgruppe FROM Medlemsgrupper g ORDER BY Navn";
      } else {
        $sql = "SELECT g.GruppeID,Navn,Beskrivelse,(SELECT COUNT(*) FROM PersonXMedlemsgruppe WHERE (GruppeID=g.GruppeID)) AS Antall,Alarmgruppe FROM PersonXMedlemsgruppe,Medlemsgrupper g WHERE (PersonXMedlemsgruppe.PersonID=".$PersonID.") AND (PersonXMedlemsgruppe.GruppeID=g.GruppeID) ORDER BY Navn";
      }
      $rgrupper = $this->db->query($sql);
      foreach ($rgrupper->result_array() as $gruppe) {
        $grupper[] = $gruppe;
        unset($gruppe);
      }
      if (isset($grupper)) {
        return $grupper;
      }
    }

    function medlemsgruppe($ID) {
      $medlemsgrupper = $this->db->query("SELECT GruppeID,Navn,Beskrivelse,Alarmgruppe FROM Medlemsgrupper WHERE (GruppeID=".$ID.") LIMIT 1");
      if ($gruppe = $medlemsgrupper->row_array()) {
        $rkompetanse = $this->db->query("SELECT Kompetanse.KompetanseID,TypeID,Navn,Gyldighet FROM Kompetanse,MedlemsgruppeKompetanseKrav WHERE (MedlemsgruppeKompetanseKrav.KompetanseID=Kompetanse.KompetanseID) AND (MedlemsgruppeKompetanseKrav.GruppeID=".$gruppe['GruppeID'].")");
        foreach ($rkompetanse->result_array() as $kompetanse) {
          $kompetansekrav[] = $kompetanse;
          unset($kompetanse);
        }
        if (isset($kompetansekrav)) { $gruppe['Kompetansekrav'] = $kompetansekrav; }
        $rpersoner = $this->db->query("SELECT Personer.PersonID,Fornavn,Etternavn,Mobilnr,Epost,TIMESTAMPDIFF(YEAR,DatoFodselsdato,CURDATE()) AS Alder FROM PersonXMedlemsgruppe,Personer WHERE (Personer.PersonID=PersonXMedlemsgruppe.PersonID) AND (PersonXMedlemsgruppe.GruppeID=".$gruppe['GruppeID'].") ORDER BY Fornavn, Etternavn");
        foreach ($rpersoner->result_array() as $person) {
          if (isset($gruppe['Kompetansekrav'])) {
            $person['Godkjent'] = 1;
            foreach ($gruppe['Kompetansekrav'] as $KompetanseKrav) {
              $sql = "SELECT PersonID,KompetanseID FROM PersonXKompetanse WHERE (PersonID=".$person['PersonID'].") AND (KompetanseID=".$KompetanseKrav['KompetanseID'].")";
              if ($KompetanseKrav['Gyldighet'] > 0) {
                $sql .= " AND (TIMESTAMPDIFF(MONTH,DatoGodkjent,CURDATE()) < ".$KompetanseKrav['Gyldighet'].")";
              }
              $rtemp = $this->db->query($sql);
              if ($rtemp->num_rows() == 0) {
                $person['Godkjent'] = 0;
              }
            }
          } else {
            $person['Godkjent'] = -1;
          }
          $personer[] = $person;
          unset($person);
        }
        $gruppe['Personer'] = $personer;
      }
      return $gruppe;
    }

    function koblepersonmedlemsgruppe($PersonID,$GruppeID) {
      $this->db->query("INSERT INTO PersonXMedlemsgruppe (PersonID,GruppeID) VALUES (".$PersonID.",".$GruppeID.")");
    }

  }
?>
