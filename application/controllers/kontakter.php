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
    $person = null;
    $data['Person'] = $person;
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
      redirect('/kontakter/person/'.$ID);
    } else {
      $data['Person'] = $this->Kontakter_model->person($this->uri->segment(3));
      $data['Medlemsgrupper'] = $this->Kontakter_model->medlemsgrupper();
      $this->template->load('standard','kontakter/person',$data);
    }
  }

  public function slettperson() {
    $this->load->model('Kontakter_model');
    $this->Kontakter_model->slettperson($this->uri->segment(3));
    redirect('kontakter/personer/');
  }

  public function nyorganisasjon() {
    $organisasjon = null;
    $data['Organisasjon'] = $organisasjon;
    $this->template->load('standard','kontakter/organisasjon',$data);
  }

  public function slettorganisasjon() {
    $this->load->model('Kontakter_model');
    $this->Kontakter_model->slettorganisasjon($this->uri->segment(3));
    redirect('kontakter/organisasjoner/');
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
    $this->template->load('standard','kontakter/medlemmer');
  }

  public function hentmedlemmer() {
    $this->load->model('Kontakter_model');
    $data['data'] = $this->Kontakter_model->medlemmer();
    $this->load->view('json',$data);
  }

  public function hentfaggrupper() {
    $this->load->model('Kontakter_model');
    $data['data'] = $this->Kontakter_model->faggrupper();
    $this->load->view('json',$data);
  }

  public function minfaggruppe() {
    $this->load->model('Kontakter_model');
    $this->load->model('Materiell_model');
    $this->load->model('Prosjekter_model');
    $data['Faggruppe'] = $this->Kontakter_model->faggruppe($this->uri->segment(3));
    $data['Utstyrsliste'] = $this->Materiell_model->utstyrsliste(array('FaggruppeID' => $this->uri->segment(3)));
    $data['Prosjekter'] = $this->Prosjekter_model->prosjekter(array('FaggruppeID' => $this->uri->segment(3)));
    $this->template->load('standard','kontakter/minfaggruppe',$data);
  }

  public function medlemsgrupper() {
    $this->load->model('Kontakter_model');
    $data['Grupper'] = $this->Kontakter_model->medlemsgrupper();
    $this->template->load('standard','kontakter/medlemsgrupper',$data);
  }

  public function medlemsgruppe() {
    $this->load->model('Kontakter_model');
    $data['Gruppe'] = $this->Kontakter_model->medlemsgruppe($this->uri->segment(3));
    $this->template->load('standard','kontakter/medlemsgruppe',$data);
  }

  public function koblepersongruppe() {
    $this->load->model('Kontakter_model');
    $PersonID = $this->input->post('PersonID');
    $GruppeID = $this->input->post('GruppeID');
    $this->Kontakter_model->koblepersongruppe($PersonID,$GruppeID);
    redirect('kontakter/person/'.$PersonID);
  }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
