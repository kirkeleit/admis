<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kontakter extends CI_Controller {

  public function index() {
    redirect('/kontakter/personer');
  }

  public function personer() {
    $this->load->model('Kontakter_model');
    $data['Personer'] = $this->Kontakter_model->personer();
    $this->template->load('standard','kontakter/personer',$data);
  }

  public function nyperson() {
    $data['Person'] = null;
    $this->template->load('standard','kontakter/person',$data);
  }

  public function person() {
    $this->load->model('Kontakter_model');
    if ($this->input->post('PersonLagre')) {
      $ID = $this->input->post('PersonID');
      $person['Fornavn'] = $this->input->post('Fornavn');
      $person['Etternavn'] = $this->input->post('Etternavn');
      $person['DatoFodselsdato'] = ($this->input->post('DatoFodselsdato') == '' ? '' : date("Y-m-d",strtotime($this->input->post('DatoFodselsdato'))));
      $person['Mobilnr'] = $this->input->post('Mobilnr');
      $person['Epost'] = $this->input->post('Epost');
      $person['Medlem'] = ($this->input->post('Medlem') ? 1 : 0);
      $person['Relasjonsnummer'] = $this->input->post('Relasjonsnummer');
      $person['DatoMedlemsdato'] = ($this->input->post('DatoMedlemsdato') == '' ? '' : date("Y-m-d",strtotime($this->input->post('DatoMedlemsdato'))));
      $person['Initialer'] = $this->input->post('Initialer');
      $person = $this->Kontakter_model->lagreperson($ID,$person);
      if ($this->input->post('AdresseID')) { $AdresseID = $this->input->post('AdresseID'); } else { $AdresseID = null; }
      if ($this->input->post('Adresse1')) { $adresse['Adresse1'] = $this->input->post('Adresse1'); }
      if ($this->input->post('Adresse2')) { $adresse['Adresse2'] = ($this->input->post('Adresse2') == '' ? $this->input->post('Adresse2') : ''); }
      if ($this->input->post('Postnummer')) { $adresse['Postnummer'] = $this->input->post('Postnummer'); }
      if (isset($adresse)) { $this->Kontakter_model->lagreadresseperson($AdresseID,$person['PersonID'],$adresse); }
      if ($this->input->post('NyMedlemsgruppeID') > 0) { $this->Kontakter_model->koblepersonmedlemsgruppe($person['PersonID'],$this->input->post('NyMedlemsgruppeID')); }
      if ($this->input->post('FjernMedlemsgruppeID')) {
        $grupper = $this->input->post('FjernMedlemsgruppeID');
        for ($i=0; $i<sizeof($grupper); $i++) {
          $this->Kontakter_model->fjernpersonmedlemsgruppe($person['PersonID'],$grupper[$i]);
        }
      }
      redirect('/kontakter/person/'.$person['PersonID']);
    } else {
      $data['Person'] = $this->Kontakter_model->person($this->uri->segment(3));
      $data['Medlemsgrupper'] = $this->Kontakter_model->medlemsgrupper();
      $this->template->load('standard','kontakter/person',$data);
    }
  }

  public function nyorganisasjon() {
    $data['Organisasjon'] = null;
    $this->template->load('standard','kontakter/organisasjon',$data);
  }

  public function organisasjoner() {
    $this->load->model('Kontakter_model');
    $data['Organisasjoner'] = $this->Kontakter_model->organisasjoner();
    $this->template->load('standard','kontakter/organisasjoner',$data);
  }

  public function organisasjon() {
    $this->load->model('Kontakter_model');
    if ($this->input->post('OrganisasjonLagre')) {
      $ID = $this->input->post('OrganisasjonID');
      $organisasjon['Navn'] = $this->input->post('Navn');
      $organisasjon['Orgnummer'] = $this->input->post('Orgnummer');
      $organisasjon['Telefonnr'] = $this->input->post('Telefonnr');
      $organisasjon['Epost'] = $this->input->post('Epost');
      $organisasjon = $this->Kontakter_model->lagreorganisasjon($ID,$organisasjon);
      if ($this->input->post('AdresseID')) { $AdresseID = $this->input->post('AdresseID'); } else { $AdresseID = null; }
      if ($this->input->post('Adresse1')) { $adresse['Adresse1'] = $this->input->post('Adresse1'); }
      if ($this->input->post('Adresse2')) { $adresse['Adresse2'] = ($this->input->post('Adresse2') == '' ? $this->input->post('Adresse2') : ''); }
      if ($this->input->post('Postnummer')) { $adresse['Postnummer'] = $this->input->post('Postnummer'); }
      if (isset($adresse)) { $this->Kontakter_model->lagreadresseorganisasjon($AdresseID,$organisasjon['OrganisasjonID'],$adresse); }
      redirect('kontakter/organisasjon/'.$organisasjon['OrganisasjonID']);
    } else {
      $data['Organisasjon'] = $this->Kontakter_model->organisasjon($this->uri->segment(3));
      $this->template->load('standard','kontakter/organisasjon',$data);
    }
  }

  public function medlemmer() {
    $this->load->model('Kontakter_model');
    $data['Personer'] = $this->Kontakter_model->medlemmer();
    $this->template->load('standard','kontakter/medlemmer',$data);
  }

  public function medlemsgrupper() {
    $this->load->model('Kontakter_model');
    $data['Grupper'] = $this->Kontakter_model->medlemsgrupper();
    $this->template->load('standard','kontakter/medlemsgrupper',$data);
  }

  public function medlemsgruppe() {
    $this->load->model('Kontakter_model');
    $this->load->model('Kompetanse_model');
    if ($this->input->post('GruppeLagre')) {
      $ID = $this->input->post('GruppeID');
      $gruppe['Navn'] = $this->input->post('Navn');
      $gruppe['Beskrivelse'] = $this->input->post('Beskrivelse');
      if ($this->input->post('Alarmgruppe')) { $gruppe['Alarmgruppe'] = 1; } else { $gruppe['Alarmgruppe'] = 0; }
      $gruppe = $this->Kontakter_model->medlemsgruppelagre($ID,$gruppe);
      redirect('kontakter/medlemsgruppe/'.$gruppe['GruppeID']);
    } elseif ($this->input->post('GruppeOppdaterKompetansekrav')) {
      if ($this->input->post('NyttKompetanseKrav') > 0) {
        $this->Kontakter_model->koblekompetansemedlemsgruppe($this->input->post('NyttKompetanseKrav'),$this->input->post('GruppeID'));
      }
      if ($this->input->post('FjernKompetansekrav')) {
        $kompetanse = $this->input->post('FjernKompetansekrav');
        for ($i=0; $i<sizeof($kompetanse); $i++) {
          $this->Kontakter_model->fjernkompetansemedlemsgruppe($kompetanse[$i],$this->input->post('GruppeID'));
        }
      }
      redirect('kontakter/medlemsgruppe/'.$this->input->post('GruppeID'));
    } else {
      $data['Gruppe'] = $this->Kontakter_model->medlemsgruppe($this->uri->segment(3));
      $data['Kompetanseliste'] = $this->Kompetanse_model->kompetanseliste();
      $this->template->load('standard','kontakter/medlemsgruppe',$data);
    }
  }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
