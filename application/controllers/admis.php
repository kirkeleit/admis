<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admis extends CI_Controller {

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

  public function rollerettigheter() {
    $this->load->model('Admis_model');
    if ($this->input->post('Tilgang')) {
      $this->Admis_model->lagreroller($this->input->post('Tilgang'));
    }
    $data['Roller'] = $this->Admis_model->roller();
    $this->template->load('standard','admis/rettigheter',$data);
  }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
