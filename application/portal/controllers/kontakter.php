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
    $person['ID'] = 0;
    $person['Fornavn'] = "";
    $person['Etternavn'] = "";
    $person['Fodselsdato'] = "";
    $person['Adresse'] = "";
    $person['Postnr'] = "";
    $person['Mobilnr'] = "";
    $person['Epost'] = "";
    $person['Medlem'] = 0;
    $person['Relasjonsnr'] = "";
    $person['Medlemsdato'] = "";
    $person['Initialer'] = "";
    $person['Bruker'] = 0;
    $person['Brukernavn'] = "";
    if ($this->input->get('orgid')) {
      $person['OrgID'] = $this->input->get('orgid');
    }
    $data['Person'] = $person;
    $this->template->load('standard','kontakter/person',$data);
  }

  public function person() {
    $this->load->model('Kontakter_model');
    $this->form_validation->set_rules('ID','ID','required');
    $this->form_validation->set_rules('Fornavn','Fornavn','required');
    $this->form_validation->set_rules('Etternavn','Etternavn','required');
    $this->form_validation->set_rules('Fodselsdato','Fodselsdato','trim');
    $this->form_validation->set_rules('Adresse','Adresse','trim');
    $this->form_validation->set_rules('Postnr','Postnr','trim');
    $this->form_validation->set_rules('Mobilnr','Mobilnr','trim');
    $this->form_validation->set_rules('Epost','Epost','trim');
    $this->form_validation->set_rules('Relasjonsnr','Relasjonsnr','trim');
    $this->form_validation->set_rules('Medlemsdato','Medlemsdato','trim');
    $this->form_validation->set_rules('Initialer','Initialer','trim');
    $this->form_validation->set_rules('Brukernavn','Brukernavn','trim');
    $this->form_validation->set_rules('NyttPassord','NyttPassord','trim');
    if ($this->form_validation->run() == TRUE) {
      $person['ID'] = $this->input->post('ID');
      $person['Fornavn'] = $this->input->post('Fornavn');
      $person['Etternavn'] = $this->input->post('Etternavn');
      $person['Fodselsdato'] = $this->input->post('Fodselsdato');
      $person['Adresse'] = $this->input->post('Adresse');
      $person['Postnr'] = $this->input->post('Postnr');
      $person['Mobilnr'] = $this->input->post('Mobilnr');
      $person['Epost'] = $this->input->post('Epost');
      if ($this->input->post('ErMedlem')) {
        $person['Medlem'] = 1;
        $person['Relasjonsnr'] = $this->input->post('Relasjonsnr');
        $person['Medlemsdato'] = $this->input->post('Medlemsdato');
        $person['Initialer'] = $this->input->post('Initialer');
      } else {
        $person['Medlem'] = 0;
      }
      if ($this->input->post('ErBruker')) {
        $person['Bruker'] = 1;
        $person['Brukernavn'] = $this->input->post('Brukernavn');
        if ($this->input->post('NyttPassord')) {
          $person['NyttPassord'] = $this->input->post('NyttPassord');
        }
      } else {
        $person['Bruker'] = 0;
      }
      $this->Kontakter_model->lagreperson($person);
      redirect('/kontakter/personer');
    } else {
      $data['Person'] = $this->Kontakter_model->person($this->uri->segment(3));
      $data['Grupper'] = $this->Kontakter_model->grupper();
      $this->template->load('standard','kontakter/person',$data);
    }
  }

  public function slettperson() {
    $this->load->model('Kontakter_model');
    $this->Kontakter_model->slettperson($this->uri->segment(3));
    redirect('kontakter/personer/');
  }

  public function nyorganisasjon() {
    $organisasjon['ID'] = 0;
    $organisasjon['Navn'] = "";
    $organisasjon['Orgnummer'] = "";
    $organisasjon['Telefonnr'] = "";
    $organisasjon['Epost'] = "";
    $data['Organisasjon'] = $organisasjon;
    $this->template->load('standard','kontakter/organisasjon',$data);
  }

  public function lagreorganisasjon() {
    $this->load->model('Kontakter_model');
    if ($this->input->post('ID') != FALSE) {
      $organisasjon['ID'] = $this->input->post('ID');
    }
    $organisasjon['Navn'] = $this->input->post('Navn');
    $organisasjon['Orgnummer'] = $this->input->post('Orgnummer');
    $organisasjon['Telefonnr'] = $this->input->post('Telefonnr');
    $organisasjon['Epost'] = $this->input->post('Epost');
    $data['data'] = $this->Kontakter_model->lagreorganisasjon($organisasjon);
    $this->load->view('json',$data);
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
    $this->form_validation->set_rules('ID','ID','required|trim');
    $this->form_validation->set_rules('Navn','Navn','required|trim');
    $this->form_validation->set_rules('Orgnummer','Orgnummer','trim');
    $this->form_validation->set_rules('Telefonnr','Telefonnr','trim');
    $this->form_validation->set_rules('Epost','Epost','trim');
    if ($this->form_validation->run() == TRUE) {
      $organisasjon['ID'] = $this->input->post('ID');
      $organisasjon['Navn'] = $this->input->post('Navn');
      $organisasjon['Orgnummer'] = $this->input->post('Orgnummer');
      $organisasjon['Telefonnr'] = $this->input->post('Telefonnr');
      $organisasjon['Epost'] = $this->input->post('Epost');
      $this->Kontakter_model->lagreorganisasjon($organisasjon);
      redirect('kontakter/organisasjoner');
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

  public function grupper() {
    $this->load->model('Kontakter_model');
    $data['Grupper'] = $this->Kontakter_model->grupper();
    $this->template->load('standard','kontakter/grupper',$data);
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
