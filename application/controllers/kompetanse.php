<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kompetanse extends CI_Controller {

  public function index() {
    redirect('/kompetanse/kompetanseliste');
  }

  public function faggrupper() {
    $this->load->model('Kompetanse_model');
    $data['Faggrupper'] = $this->Kompetanse_model->faggrupper();
    $this->template->load('standard','kompetanse/faggrupper',$data);
  }

  public function faggruppe() {
    $this->load->model('Kompetanse_model');
    if ($this->input->post('FaggruppeLagre')) {
      $ID = $this->input->post('FaggruppeID');
      $faggruppe['Navn'] = $this->input->post('Navn');
      $faggruppe['PersonLederID'] = $this->input->post('PersonLederID');
      $faggruppe['PersonNestlederID'] = $this->input->post('PersonNestlederID');
      $faggruppe['Beskrivelse'] = $this->input->post('Beskrivelse');
      $faggruppe = $this->Kompetanse_model->faggruppelagre($ID,$faggruppe);
      redirect('/kompetanse/faggruppe/'.$faggruppe['FaggruppeID']);
    } else {
      $this->load->model('Kontakter_model');
      $this->load->model('Materiell_model');
      $this->load->model('Prosjekter_model');
      $data['Faggruppe'] = $this->Kompetanse_model->faggruppe($this->uri->segment(3));
      $data['Personer'] = $this->Kontakter_model->medlemmer();
      $data['Utstyrsliste'] = $this->Materiell_model->utstyrsliste(array('FaggruppeID' => $this->uri->segment(3)));
      $data['Prosjekter'] = $this->Prosjekter_model->prosjekter(array('FaggruppeID' => $this->uri->segment(3)));
      $this->template->load('standard','kompetanse/faggruppe',$data);
    }
  }

  public function kompetanseliste() {
    $this->load->model('Kompetanse_model');
    $data['Kompetanseliste'] = $this->Kompetanse_model->kompetanseliste();
    $this->template->load('standard','kompetanse/kompetanseliste',$data);
  }

  public function kompetanseinfo() {
    $this->load->model('Kompetanse_model');
    if ($this->input->post('KompetanseLagre')) {
      $ID = $this->input->post('KompetanseID');
      $kompetanse['Navn'] = $this->input->post('Navn');
      $kompetanse['TypeID'] = $this->input->post('TypeID');
      $kompetanse['Timer'] = $this->input->post('Timer');
      $kompetanse['Gyldighet'] = $this->input->post('Gyldighet');
      $kompetanse['Beskrivelse'] = $this->input->post('Beskrivelse');
      $kompetanse = $this->Kompetanse_model->kompetanselagre($ID,$kompetanse);
      redirect('/kompetanse/kompetanseinfo/'.$kompetanse['KompetanseID']);
    } else {
      $data['Kompetanse'] = $this->Kompetanse_model->kompetanseinfo($this->uri->segment(3));
      $this->template->load('standard','kompetanse/kompetanse',$data);
    }
  }

  public function nykompetanse() {
    $data['Kompetanse'] = null;
    $this->template->load('standard','kompetanse/kompetanse',$data);
  }


}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
