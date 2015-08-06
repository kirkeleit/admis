<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prosjekter extends CI_Controller {

  public function index() {
    redirect('/prosjekter/prosjektliste');
  }

  public function prosjektliste() {
    $this->load->model('Prosjekter_model');
    $data['Prosjekter'] = $this->Prosjekter_model->prosjekter();
    $this->template->load('standard','prosjekter/prosjekter',$data);
  }

  public function tidslinje() {
    $this->load->model('Prosjekter_model');
    $data['Prosjekter'] = $this->Prosjekter_model->prosjekter();
    $this->template->load('standard','prosjekter/tidslinje',$data);
  }

  public function prosjektarkiv() {
    $this->load->model('Prosjekter_model');
    $data['Prosjekter'] = $this->Prosjekter_model->prosjekter(array("Arkiv" => "1"));
    $this->template->load('standard','prosjekter/prosjekter',$data);
  }

  public function nyttprosjekt() {
    $data['Prosjekt'] = null;
    $this->load->model('Kontakter_model');
    $data['Faggrupper'] = $this->Kontakter_model->faggrupper();
    $data['Medlemmer'] = $this->Kontakter_model->medlemmer();
    $this->template->load('standard','prosjekter/prosjekt',$data);
  }

  public function prosjekt() {
    $this->load->model('Prosjekter_model');
    $this->load->model('Kontakter_model');
    $this->load->model('Okonomi_model');
    if ($this->input->post('ProsjektLagre')) {
      $prosjekt['ProsjektAr'] = $this->input->post('ProsjektAr');
      $prosjekt['FaggruppeID'] = $this->input->post('FaggruppeID');
      $prosjekt['PersonProsjektlederID'] = $this->input->post('PersonProsjektlederID');
      $prosjekt['DatoProsjektstart'] = date("Y-m-d",strtotime($this->input->post('DatoProsjektstart')));
      $prosjekt['DatoProsjektslutt'] = date("Y-m-d",strtotime($this->input->post('DatoProsjektslutt')));
      $prosjekt['Prosjektnavn'] = $this->input->post('Prosjektnavn');
      $prosjekt['Formaal'] = $this->input->post('Formaal');
      $prosjekt['Prosjektmaal'] = $this->input->post('Prosjektmaal');
      $prosjekt['Maalgruppe'] = $this->input->post('Maalgruppe');
      $prosjekt['Prosjektbeskrivelse'] = $this->input->post('Prosjektbeskrivelse');
      $prosjekt['Arbeidstimer'] = $this->input->post('Arbeidstimer');
      $prosjekt['Budsjettramme'] = $this->input->post('Budsjettramme');
      $prosjekt = $this->Prosjekter_model->lagreprosjekt($this->input->post('ProsjektID'),$prosjekt);
      redirect('prosjekter/prosjekt/'.$prosjekt['ProsjektID']);
    } elseif ($this->input->post('ProsjektSlett')) {
      $this->Prosjekter_model->slettprosjekt($this->input->post('ProsjektID'));
      redirect('prosjekter/prosjektliste/');
    } elseif ($this->input->post('KommentarLagre')) {
      $kommentar['ProsjektID'] = $this->input->post('ProsjektID');
      $kommentar['Kommentar'] = $this->input->post('NyKommentar');
      $kommentar['PersonID'] = $this->UABruker['ID'];
      $this->Prosjekter_model->lagrekommentar($kommentar);
      redirect('prosjekter/prosjekt/'.$kommentar['ProsjektID']);
    } else {
      $data['Faggrupper'] = $this->Kontakter_model->faggrupper();
      $data['Medlemmer'] = $this->Kontakter_model->medlemmer();
      $data['Prosjekt'] = $this->Prosjekter_model->prosjekt($this->uri->segment(3));
      $data['Innkjopsordrer'] = $this->Okonomi_model->innkjopsordrer(array('ProsjektID' => $this->uri->segment(3)));
      $data['Utgifter'] = $this->Okonomi_model->utgifter(array('ProsjektID' => $this->uri->segment(3)));
      $this->template->load('standard','prosjekter/prosjekt',$data);
    }
  }

  /*public function settprosjektstatus() {
    $this->load->model('Prosjekter_model');
    $prosjekt['ID'] = $this->input->get('pid');
    $prosjekt['PersonID'] = $this->UABruker['ID'];
    $prosjekt['Status'] = $this->input->get('status');
    $this->Prosjekter_model->settprosjektstatus($prosjekt);
    redirect('prosjekter/prosjekt/'.$prosjekt['ID']);
  }*/

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
