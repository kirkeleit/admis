<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Raadet extends CI_Controller {

  public function index() {
    redirect('/raadet/saksliste');
  }

  public function saksliste() {
    $this->load->model('Raadet_model');
    $data['Saksliste'] = $this->Raadet_model->saksliste(array('StatusID' => '0'));
    $this->template->load('standard','raadet/saksliste',$data);
  }

  public function saksarkiv() {
    $this->load->model('Raadet_model');
    $data['Saksliste'] = $this->Raadet_model->saksliste(array('StatusID' => '1'));
    $this->template->load('standard','raadet/saksliste',$data);
  }

  public function nysak() {
    $this->load->model('Kontakter_model');
    $data['Sak'] = null;
    $data['Personer'] = $this->Kontakter_model->medlemmer();
    $this->template->load('standard','raadet/sak',$data);
  }

  public function sak() {
    $this->load->model('Raadet_model');
    $this->load->model('Kontakter_model');
    if ($this->input->post('SakLagre')) {
      $ID = $this->input->post('SakID');
      $data['PersonID'] = $this->input->post('PersonID');
      $data['Tittel'] = $this->input->post('Tittel');
      $data['Saksbeskrivelse'] = $this->input->post('Saksbeskrivelse');
      $sak = $this->Raadet_model->lagresak($ID,$data);
      redirect('/raadet/sak/'.$sak['SakID']);
    } else {
      $data['Sak'] = $this->Raadet_model->sak($this->uri->segment(3));
      $data['Notater'] = $this->Raadet_model->saksnotater($this->uri->segment(3));
      $data['Personer'] = $this->Kontakter_model->medlemmer();
      $this->template->load('standard','raadet/sak',$data);
    }
  }

  public function lagsaksnummer() {
    $this->load->model('Raadet_model');
    $this->Raadet_model->lagsaksnummer($this->input->get('sid'));
    redirect('/raadet/sak/'.$this->input->get('sid'));
  }

  public function nyttnotat() {
    $this->load->model('Raadet_model');
    $data['SakID'] = $this->input->post('SakID');
    $data['MoteID'] = 0;
    $data['Notatstype'] = $this->input->post('Notatstype');
    $data['Notat'] = $this->input->post('Notat');
    $data['PersonID'] = $this->UABruker['ID'];
    $this->Raadet_model->lagrenotat($data);
    redirect('/raadet/sak/'.$this->input->post('SakID'));
  }

  public function resultat() {
    $this->load->model('Okonomi_model');
    $data['Aktiviteter'] = $this->Okonomi_model->aktiviteter();
    $data['Resultat'] = $this->Okonomi_model->resultat();
    $this->template->load('standard','raadet/resultat',$data);
  }

  public function budsjett() {
    $this->load->model('Okonomi_model');
    $this->Okonomi_model->lagrebudsjett($this->input->post());
    $data['Aktiviteter'] = $this->Okonomi_model->aktiviteter();
    $data['KontoerINN'] = $this->Okonomi_model->kontoer(0);
    $data['KontoerUT'] = $this->Okonomi_model->kontoer(1);
    $data['Budsjett'] = $this->Okonomi_model->budsjett();
    $this->template->load('standard','raadet/budsjett',$data);
  }

  public function moter() {
    $this->load->model('Raadet_model');
    $data['Moter'] = $this->Raadet_model->moter();
    $this->template->load('standard','raadet/moter',$data);
  }

  public function moteskjerm() {
    $this->load->model('Raadet_model');
    if ($this->input->post('LagreNotat')) {
      $data['SakID'] = $this->input->post('SakID');
      $data['MoteID'] = $this->input->post('MoteID');
      $data['Notatstype'] = $this->input->post('Notatstype');
      $data['Notat'] = $this->input->post('Notat');
      $data['PersonID'] = $this->UABruker['ID'];
      $this->Raadet_model->lagrenotat($data);
      unset($data);
    }
    $data['Mote'] = $this->Raadet_model->mote($this->input->get('mid'));
    $data['Saksliste'] = $this->Raadet_model->saksliste(array('Status' => '0'));
    if ($this->input->get('sid')) {
      $data['Sak'] = $this->Raadet_model->sak($this->input->get('sid'));
      $data['Notater'] = $this->Raadet_model->saksnotater($this->input->get('sid'));
    }
    $this->load->view('raadet/moteskjerm',$data);
  }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
