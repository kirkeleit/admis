<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Oppgaver extends CI_Controller {

  public function index() {
    redirect('/oppgaver/mineoppgaver');
  }

  public function mineoppgaver() {
    $this->load->model('Oppgaver_model');
    $data['Oppgaver'] = $this->Oppgaver_model->oppgaver(array('PersonAnsvarligID' => $this->UABruker['ID']));
    $data['OppgaverUtenAnsvarlige'] = $this->Oppgaver_model->oppgaver(array('PersonAnsvarligID' => 0));
    $this->template->load('standard','oppgaver/mineoppgaver',$data);
  }

  public function alleoppgaver() {
    $this->load->model('Oppgaver_model');
    $data['Oppgaver'] = $this->Oppgaver_model->oppgaver();
    $this->template->load('standard','oppgaver/alleoppgaver',$data);
  }

  public function nyoppgave() {
    $this->load->model('Kontakter_model');
    $oppgave['OppgaveID'] = 0;
    $oppgave['DatoFrist'] = "0000-00-00";
    $oppgave['PrioritetID'] = 1;
    $oppgave['Tittel'] = "";
    $oppgave['Beskrivelse'] = "";
    $oppgave['PersonAnsvarligID'] = 0;
    $oppgave['StatusID'] = 0;
    $data['Oppgave'] = $oppgave;
    $data['Personer'] = $this->Kontakter_model->medlemmer();
    $this->template->load('standard','oppgaver/oppgave',$data);
  }

  public function oppgave() {
    $this->load->model('Oppgaver_model');
    $this->load->model('Kontakter_model');
    if ($this->input->post('OppgaveLagre')) {
      $data['DatoFrist'] = ($this->input->post('DatoFrist')) ? date("Y-m-d",strtotime($this->input->post('DatoFrist'))) : '';
      $data['PrioritetID'] = $this->input->post('PrioritetID');
      $data['Tittel'] = $this->input->post('Tittel');
      $data['Beskrivelse'] = $this->input->post('Beskrivelse');
      $data['PersonAnsvarligID'] = $this->input->post('PersonAnsvarligID');
      $data['Notat'] = $this->input->post('Notat');
      $data['StatusID'] = $this->input->post('StatusID');
      $oppgave = $this->Oppgaver_model->lagreoppgave($this->input->post('OppgaveID'),$data);
      redirect('/oppgaver/oppgave/'.$oppgave['OppgaveID']);
    } elseif ($this->input->post('OppgaveSlett')) {
      $this->Oppgaver_model->slettoppgave($this->input->post('OppgaveID'));
      redirect('/oppgaver/oppgaver');
    } else {
      $data['Oppgave'] = $this->Oppgaver_model->oppgave($this->uri->segment(3));
      $data['Personer'] = $this->Kontakter_model->medlemmer();
      $this->template->load('standard','oppgaver/oppgave',$data);
    }
  }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
