<?php
  class KovaSync extends CI_Controller {

    public function hentmedlemmer() {
      $medlemmer = $this->db->query("SELECT PersonID,KovaPrimKey,Fornavn,Etternavn,Mobilnr,Epost,DatoFodselsdato,DatoMedlemsdato,Relasjonsnummer,Notater FROM Personer WHERE NOT (KovaPrimKey='')");
      foreach ($medlemmer->result() as $medlem) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://www.kova.no/ajax/Api.Person/GetMember?Organization=BRKH&ApiKey=4C5E8F64-B3F5-405C-9549-E5A587BA0C6E&PrimKey=".$medlem->KovaPrimKey);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $kova = json_decode(curl_exec($ch));
        if ($kova->FirstName != $medlem->Fornavn) {
          $person['Fornavn'] = $kova->FirstName;
        }
        if ($kova->LastName != $medlem->Etternavn) {
          $person['Etternavn'] = $kova->LastName;
        }
        if ($kova->PhoneMobile != $medlem->Mobilnr) {
          $person['Mobilnr'] = $kova->PhoneMobile;
        }
        if ($kova->EMail != $medlem->Epost) {
          $person['Epost'] = $kova->EMail;
        }
        if (date("Y-m-d",(substr($kova->DateOfBirth,6,-2)/1000)) != $medlem->DatoFodselsdato) {
          if (date("Y-m-d",(substr($kova->DateOfBirth,6,-2)/1000)) != '1970-01-01') {
            $person['DatoFodselsdato'] = date("Y-m-d",(substr($kova->DateOfBirth,6,-2)/1000));
          }
        }
        if (date("Y-m-d",(substr($kova->MemberFrom,6,-2)/1000)) != $medlem->DatoMedlemsdato) {
          if (date("Y-m-d",(substr($kova->MemberFrom,6,-2)/1000)) != '1970-01-01') {
            $person['DatoMedlemsdato'] = date("Y-m-d",(substr($kova->MemberFrom,6,-2)/1000));
          }
        }
        if ($kova->MemberNumber != $medlem->Relasjonsnummer) {
          $person['Relasjonsnummer'] = $kova->MemberNumber;
        }
        if ($kova->Comments != $medlem->Notater) {
          $person['Notater'] = $kova->Comments;
        }
        if (isset($person)) {
          $person['DatoKovaSync'] = date('Y-m-d H:i:s');
          echo $medlem->Fornavn;
          print_r($person);
          $this->db->query($this->db->update_string('Personer',$person,'PersonID='.$medlem->PersonID));
        }
        unset($kova);
        unset($person);
        unset($ch);
      }
    }

    public function hentmedlemskompetanse() {
      $medlemmer = $this->db->query("SELECT PersonID,KovaPrimKey,Fornavn,Etternavn,Mobilnr,Epost,DatoFodselsdato,DatoMedlemsdato,Relasjonsnummer FROM Personer WHERE NOT (KovaPrimKey='')");
      foreach ($medlemmer->result() as $medlem) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://www.kova.no/ajax/Api.Course/GetMembersCourses?Organization=BRKH&ApiKey=4C5E8F64-B3F5-405C-9549-E5A587BA0C6E&PersonRef=".$medlem->KovaPrimKey);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $kova = json_decode(curl_exec($ch));
        foreach ($kova as $kovakurs) {
          $kursliste = $this->db->query("SELECT KompetanseID,Navn FROM Kompetanse WHERE (KovaPrimKey='".$kovakurs->CourseRef."')");
          if ($kurs = $kursliste->row()) {
            $xref = $this->db->query("SELECT * FROM PersonXKompetanse WHERE (PersonID='".$medlem->PersonID."') AND (KompetanseID='".$kurs->KompetanseID."')");
            if ($xref->num_rows() == 0) {
              $xkompetanse['PersonID'] = $medlem->PersonID;
              $xkompetanse['KompetanseID'] = $kurs->KompetanseID;
              $xkompetanse['DatoRegistrert'] = date('Y-m-d H:i:s');
              if (date("Y-m-d",(substr($kovakurs->Date,6,-2)/1000)) != '1970-01-01') {
                $xkompetanse['DatoGodkjent'] = date("Y-m-d",(substr($kovakurs->Date,6,-2)/1000));
              }
              $this->db->query($this->db->insert_string('PersonXKompetanse',$xkompetanse));
              unset($xkompetanse);
              //$this->db->query("INSERT INTO PersonXKompetanse (PersonID,KompetanseID,DatoRegistrert,DatoGodkjent) VALUES ('".$medlem->PersonID."','".$kurs->KompetanseID."',Now(),'".date("Y-m-d",(substr($kovakurs->Date,6,-2)/1000))."')");
            }
          }
        }
      }
    }

    public function hentkurskatalog() {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "http://www.kova.no/ajax/Api.Course/GetCourses?Organization=BRKH&ApiKey=4C5E8F64-B3F5-405C-9549-E5A587BA0C6E");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $kursliste = json_decode(curl_exec($ch));
      //print_r($kurs);
      foreach ($kursliste as $kurs) {
        $this->db->query("INSERT INTO Kompetanse (DatoRegistrert,DatoEndret,Navn,Gyldighet,KovaPrimKey) VALUES (Now(),Now(),'".$kurs->Name."','".$kurs->RequiredInterval."','".$kurs->PrimKey."')");
      }
    }

  }
?>
