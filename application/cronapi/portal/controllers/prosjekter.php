<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prosjekter extends CI_Controller {

  public function index() {
    redirect('/prosjekter/liste');
  }

  public function liste() {
    $this->load->model('Prosjekter_model');
    $data['Prosjekter'] = $this->Prosjekter_model->prosjekter();
    $this->template->load('standard','prosjekter/prosjekter',$data);
  }

  public function arkiv() {
    $this->load->model('Prosjekter_model');
    $data['Prosjekter'] = $this->Prosjekter_model->prosjekter(array("Arkiv" => "1"));
    $this->template->load('standard','prosjekter/prosjekter',$data);
  }

  public function nyttprosjekt() {
    $prosjekt['ID'] = 0;
    $prosjekt['ProsjektAr'] = date("Y");
    $prosjekt['FaggruppeID'] = 0;
    $prosjekt['AnsvarligID'] = 0;
    $prosjekt['Navn'] = "";
    $prosjekt['Beskrivelse'] = "";
    $prosjekt['Arbeidstimer'] = 0;
    $prosjekt['KostnadTotal'] = 0;
    $prosjekt['StatusID'] = 0;
    $prosjekt['Status'] = "Ikke registrert";
    $data['Prosjekt'] = $prosjekt;
    $this->load->model('Kontakter_model');
    $data['Faggrupper'] = $this->Kontakter_model->faggrupper();
    $data['Medlemmer'] = $this->Kontakter_model->medlemmer();
    $this->template->load('standard','prosjekter/prosjekt',$data);
  }

  public function prosjekt() {
    $this->load->model('Prosjekter_model');
    $this->form_validation->set_rules('ID','ID','required');
    $this->form_validation->set_rules('ProsjektAr','Prosjektår','required|trim');
    $this->form_validation->set_rules('FaggruppeID','Faggruppe','required');
    $this->form_validation->set_rules('AnsvarligID','Ansvarlig','required');
    $this->form_validation->set_rules('Navn','Navn','required|trim');
    $this->form_validation->set_rules('Beskrivelse','Beskrivelse','required|trim');
    $this->form_validation->set_rules('Arbeidstimer','Arbeidstimer','trim');
    $this->form_validation->set_rules('KostnadTotal','Kostnad','trim');
    if ($this->form_validation->run() == FALSE) {
      $this->load->model('Kontakter_model');
      $this->load->model('Okonomi_model');
      $data['Faggrupper'] = $this->Kontakter_model->faggrupper();
      $data['Medlemmer'] = $this->Kontakter_model->medlemmer();
      $data['Prosjekt'] = $this->Prosjekter_model->prosjekt($this->uri->segment(3));
      $data['Utgifter'] = $this->Okonomi_model->utgifter(array('ProsjektID' => $this->uri->segment(3)));
      $this->template->load('standard','prosjekter/prosjekt',$data);
    } else {
      $prosjekt['ID'] = $this->input->post('ID');
      $prosjekt['ProsjektAr'] = $this->input->post('ProsjektAr');
      $prosjekt['FaggruppeID'] = $this->input->post('FaggruppeID');
      $prosjekt['AnsvarligID'] = $this->input->post('AnsvarligID');
      $prosjekt['Navn'] = $this->input->post('Navn');
      $prosjekt['Beskrivelse'] = $this->input->post('Beskrivelse');
      $prosjekt['Arbeidstimer'] = $this->input->post('Arbeidstimer');
      $prosjekt['KostnadTotal'] = $this->input->post('KostnadTotal');
      $this->Prosjekter_model->lagreprosjekt($prosjekt);
      redirect('prosjekter/prosjekt/'.$prosjekt['ID']);
    }
  }

  public function slettprosjekt() {
    $this->load->model('Prosjekter_model');
    $this->Prosjekter_model->slettprosjekt($this->uri->segment(3));
    redirect('prosjekter/liste/');
  }

  public function nykommentar() {
    $this->load->model('Prosjekter_model');
    $kommentar['ProsjektID'] = $this->input->post('ProsjektID');
    $kommentar['Kommentar'] = $this->input->post('NyKommentar');
    $kommentar['PersonID'] = $this->UABruker['ID'];
    $this->Prosjekter_model->lagrekommentar($kommentar);
    redirect('prosjekter/prosjekt/'.$kommentar['ProsjektID']);
  }

  public function settprosjektstatus() {
    $this->load->model('Prosjekter_model');
    $prosjekt['ID'] = $this->input->get('pid');
    $prosjekt['PersonID'] = $this->UABruker['ID'];
    $prosjekt['Status'] = $this->input->get('status');
    $this->Prosjekter_model->settprosjektstatus($prosjekt);
    redirect('prosjekter/prosjekt/'.$prosjekt['ID']);
  }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
