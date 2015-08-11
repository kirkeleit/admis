<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Materiell extends CI_Controller {

  public function index() {
    redirect('/materiell/utstyrsliste');
  }

  public function grupper() {
    $this->load->model('Materiell_model');
    $data['Grupper'] = $this->Materiell_model->grupper();
    $this->template->load('standard','materiell/grupper',$data);
  }

  public function nygruppe() {
    $gruppe['ID'] = 0;
    $gruppe['Navn'] = "";
    $gruppe['Beskrivelse'] = "";
    $data['Gruppe'] = $gruppe;
    $this->template->load('standard','materiell/gruppe',$data);
  }

  public function gruppe() {
    $this->load->model('Materiell_model');
    $this->form_validation->set_rules('ID','ID','required');
    $this->form_validation->set_rules('Navn','Navn','required|trim');
    $this->form_validation->set_rules('Beskrivelse','Beskrivelse','trim');
    if ($this->form_validation->run() == FALSE) {
      $data['Gruppe'] = $this->Materiell_model->gruppe($this->uri->segment(3));
      $data['Utstyrsliste'] = $this->Materiell_model->utstyrsliste(array("GruppeID" => $this->uri->segment(3)));
      $this->template->load('standard','materiell/gruppe',$data);
    } else {
      $gruppe['ID'] = $this->input->post('ID');
      $gruppe['Navn'] = $this->input->post('Navn');
      $gruppe['Beskrivelse'] = $this->input->post('Beskrivelse');
      $this->Materiell_model->lagregruppe($gruppe);
      redirect('materiell/grupper/');
    }
  }

  public function produsenter() {
    $this->load->model('Materiell_model');
    $data['Produsenter'] = $this->Materiell_model->produsenter();
    $this->template->load('standard','materiell/produsenter',$data);
  }

  public function nyprodusent() {
    $produsent['ID'] = 0;
    $produsent['Navn'] = "";
    $data['Produsent'] = $produsent;
    $this->template->load('standard','materiell/produsent',$data);
  }

  public function produsent() {
    $this->load->model('Materiell_model');
    $this->form_validation->set_rules('ID','ID','required');
    $this->form_validation->set_rules('Navn','Navn','required|trim');
    if ($this->form_validation->run() == FALSE) {
      $data['Produsent'] = $this->Materiell_model->produsent($this->uri->segment(3));
      $data['Utstyrsliste'] = $this->Materiell_model->utstyrsliste(array("ProdusentID" => $this->uri->segment(3)));
      $this->template->load('standard','materiell/produsent',$data);
    } else {
      $produsent['ID'] = $this->input->post('ID');
      $produsent['Navn'] = $this->input->post('Navn');
      $this->Materiell_model->lagreprodusent($produsent);
      redirect('materiell/produsenter/');
    }
  }

  public function lagerplasser() {
    $this->load->model('Materiell_model');
    $data['Lagerplasser'] = $this->Materiell_model->lagerplasser();
    $this->template->load('standard','materiell/lagerplasser',$data);
  }

  public function nylagerplass() {
    $lagerplass['ID'] = 0;
    $lagerplass['Navn'] = "";
    $lagerplass['Kode'] = "";
    $lagerplass['Beskrivelse'] = "";
    $data['Lagerplass'] = $lagerplass;
    $this->template->load('standard','materiell/lagerplass',$data);
  }

  public function lagerplass() {
    $this->load->model('Materiell_model');
    $this->form_validation->set_rules('ID','ID','required');
    $this->form_validation->set_rules('Navn','Navn','required|trim');
    $this->form_validation->set_rules('Kode','Kode','required|trim');
    $this->form_validation->set_rules('Beskrivelse','Beskrivelse','trim');
    if ($this->form_validation->run() == FALSE) {
      $data['Lagerplass'] = $this->Materiell_model->lagerplass($this->uri->segment(3));
      $data['Kasser'] = $this->Materiell_model->utstyrskasser(array("LagerID" => $this->uri->segment(3)));
      if ($this->input->get('fkasseid') == "-1") {
        $data['Utstyrsliste'] = $this->Materiell_model->utstyrsliste(array("LagerID" => $this->uri->segment(3)));
      } else {
        if ($this->input->get('fkasseid')) {
          $data['Utstyrsliste'] = $this->Materiell_model->utstyrsliste(array("LagerID" => $this->uri->segment(3), "KasseID" => $this->input->get('fkasseid')));
        } else {
          $data['Utstyrsliste'] = $this->Materiell_model->utstyrsliste(array("LagerID" => $this->uri->segment(3), "KasseID" => "0"));
        }
      }
      //} else {
      //  $data['Utstyrsliste'] = $this->Materiell_model->utstyrsliste(array("LagerID" => $this->uri->segment(3)));
      //}
      $this->template->load('standard','materiell/lagerplass',$data);
    } else {
      $lagerplass['ID'] = $this->input->post('ID');
      $lagerplass['Navn'] = $this->input->post('Navn');
      $lagerplass['Kode'] = $this->input->post('Kode');
      $lagerplass['Beskrivelse'] = $this->input->post('Beskrivelse');
      $this->Materiell_model->lagrelagerplass($lagerplass);
      redirect('materiell/lagerplass/'.$lagerplass['ID']);
    }
  }

  public function utstyrstyper() {
    $this->load->model('Materiell_model');
    $data['Typer'] = $this->Materiell_model->utstyrstyper();
    $this->template->load('standard','materiell/utstyrstyper',$data);
  }

  public function nyutstyrstype() {
    $utstyrstype['ID'] = 0;
    $utstyrstype['Navn'] = "";
    $data['Type'] = $utstyrstype;
    $this->template->load('standard','materiell/utstyrstype',$data);
  }

  public function utstyrstype() {
    $this->load->model('Materiell_model');
    $this->form_validation->set_rules('ID','ID','required');
    $this->form_validation->set_rules('Navn','Navn','required|trim');
    if ($this->form_validation->run() == FALSE) {
      $data['Type'] = $this->Materiell_model->utstyrstype($this->uri->segment(3));
      $data['Utstyrsliste'] = $this->Materiell_model->utstyrsliste(array("TypeID" => $this->uri->segment(3)));
      $this->template->load('standard','materiell/utstyrstype',$data);
    } else {
      $utstyrstype['ID'] = $this->input->post('ID');
      $utstyrstype['Navn'] = $this->input->post('Navn');
      $this->Materiell_model->lagreutstyrstype($utstyrstype);
      redirect('materiell/utstyrstyper/');
    }
  }

  public function utstyrsliste() {
    $this->load->model('Materiell_model');
    $data['Utstyrsliste'] = $this->Materiell_model->utstyrsliste();
    $this->template->load('standard','materiell/utstyrsliste',$data);
  }

  public function utstyrsvedlikehold() {
    $this->load->model('Materiell_model');
    $data['Utstyrsliste'] = $this->Materiell_model->utstyrsliste();
    $this->template->load('standard','materiell/utstyrsvedlikehold',$data);
  }

  public function utstyr() {
    $this->load->model('Materiell_model');
    $this->load->model('Kontakter_model');
    $this->form_validation->set_rules('ID','ID','required');
    $this->form_validation->set_rules('FaggruppeID','FaggruppeID','required');
    $this->form_validation->set_rules('GruppeID','GruppeID','required');
    $this->form_validation->set_rules('TypeID','TypeID','required');
    $this->form_validation->set_rules('ProdusentID','ProdusentID','required');
    $this->form_validation->set_rules('LeverandorID','LeverandorID','required');
    $this->form_validation->set_rules('DatoAnskaffet','DatoAnskaffet','trim');
    $this->form_validation->set_rules('Modell','Modell','required');
    $this->form_validation->set_rules('Serienummer','Serienummer','trim');
    $this->form_validation->set_rules('Notater','Notater','trim');
    $this->form_validation->set_rules('Kostnad','Kostnad','trim');
    $this->form_validation->set_rules('LagerID','LagerID','trim');
    $this->form_validation->set_rules('KasseID','KasseID','trim');
    if ($this->form_validation->run() == FALSE) {
      $data['Faggrupper'] = $this->Kontakter_model->faggrupper();
      $data['Grupper'] = $this->Materiell_model->grupper();
      $data['Typer'] = $this->Materiell_model->utstyrstyper();
      $data['Produsenter'] = $this->Materiell_model->produsenter();
      $data['Leverandorer'] = $this->Kontakter_model->organisasjoner();
      $data['Lagerplasser'] = $this->Materiell_model->lagerplasser();
      $data['Utstyrsliste'] = $this->Materiell_model->utstyrsliste();
      $data['BarneUtstyrsliste'] = $this->Materiell_model->utstyrsliste(array('ForeldreID' => $this->uri->segment(3)));
      $data['Utstyr'] = $this->Materiell_model->utstyr($this->uri->segment(3));
      $data['Vedlikehold'] = $this->Materiell_model->vedlikeholdslogger($this->uri->segment(3));
      $this->template->load('standard','materiell/utstyr',$data);
    } else {
      if ($this->input->post('LagreKopi')) {
        $utstyr['ID'] = 0;
      } else {
        $utstyr['ID'] = $this->input->post('ID');
      }
      $utstyr['FaggruppeID'] = $this->input->post('FaggruppeID');
      $utstyr['GruppeID'] = $this->input->post('GruppeID');
      $utstyr['TypeID'] = $this->input->post('TypeID');
      $utstyr['ProdusentID'] = $this->input->post('ProdusentID');
      $utstyr['LeverandorID'] = $this->input->post('LeverandorID');
      $utstyr['DatoAnskaffet'] = $this->input->post('DatoAnskaffet');
      $utstyr['Modell'] = $this->input->post('Modell');
      $utstyr['Serienummer'] = $this->input->post('Serienummer');
      $utstyr['Notater'] = $this->input->post('Notater');
      $utstyr['Kostnad'] = $this->input->post('Kostnad');
      $lager = explode('.',$this->input->post('Lagerplass'));
      $utstyr['LagerID'] = $lager[0];
      $utstyr['KasseID'] = $lager[1];
      $utstyr = $this->Materiell_model->lagreutstyr($utstyr);
      redirect('materiell/utstyr/'.$utstyr['ID']);
    }
  }

  public function nyttutstyr() {
    $this->load->model('Materiell_model');
    $this->load->model('Kontakter_model');
    $utstyr['ID'] = 0;
    $utstyr['UID'] = "";
    $utstyr['FaggruppeID'] = 0;
    $utstyr['GruppeID'] = 0;
    $utstyr['TypeID'] = 0;
    $utstyr['ProdusentID'] = 0;
    $utstyr['LeverandorID'] = 0;
    $utstyr['DatoAnskaffet'] = "";
    $utstyr['Modell'] = "";
    $utstyr['Serienummer'] = "";
    $utstyr['Notater'] = "";
    $utstyr['Kostnad'] = 0;
    $utstyr['LagerID'] = 0;
    $utstyr['KasseID'] = 0;
    $utstyr['Lagerplass'] = "0.0";
    $utstyr['Status'] = "Ukjent";
    $data['Utstyr'] = $utstyr;
    $data['Faggrupper'] = $this->Kontakter_model->faggrupper();
    $data['Grupper'] = $this->Materiell_model->grupper();
    $data['Typer'] = $this->Materiell_model->utstyrstyper();
    $data['Produsenter'] = $this->Materiell_model->produsenter();
    $data['Leverandorer'] = $this->Kontakter_model->organisasjoner();
    $data['Lagerplasser'] = $this->Materiell_model->lagerplasser();
    $data['Utstyrsliste'] = $this->Materiell_model->utstyrsliste();
    $this->template->load('standard','materiell/utstyr',$data);
  }

  public function settutstyrsstatus() {
    $this->load->model('Materiell_model');
    $data['ID'] = $this->input->get('uid');
    $data['Status'] = $this->input->get('status');
    $this->Materiell_model->settutstyrsstatus($data);
    redirect('/materiell/utstyr/'.$data['ID']);
  }

  public function nytsrapport() {
    $this->load->model('Kontakter_model');
    $this->load->model('Materiell_model');
    $rapport['ID'] = 0;
    $rapport['Skadetype'] = 0;
    $rapport['PersonID'] = $this->UABruker['ID'];
    $rapport['UtstyrID'] = 0;
    $rapport['Hva'] = "";
    $rapport['Hvordan'] = "";
    $rapport['Losning'] = "";
    $rapport['Notater'] = "";
    $rapport['Status'] = "Uregistrert";
    $data['Rapport'] = $rapport;
    $data['Personer'] = $this->Kontakter_model->personer();
    $data['Utstyrsliste'] = $this->Materiell_model->utstyrsliste();
    $this->template->load('standard','materiell/tsrapport',$data);
  }

  public function tsrapport() {
    $this->load->model('Materiell_model');
    $this->load->model('Kontakter_model');
    $this->form_validation->set_rules('ID','ID','required');
    $this->form_validation->set_rules('Skadetype','Skadetype','required');
    $this->form_validation->set_rules('PersonID','PersonID','required');
    $this->form_validation->set_rules('UtstyrID','UtstyrID','required');
    $this->form_validation->set_rules('Hva','Hva','trim');
    $this->form_validation->set_rules('Hvordan','Hvordan','trim');
    $this->form_validation->set_rules('Losning','Losning','trim');
    $this->form_validation->set_rules('Notater','Notater','trim');
    if ($this->form_validation->run() == FALSE) {
      $data['Personer'] = $this->Kontakter_model->personer();
      $data['Utstyrsliste'] = $this->Materiell_model->utstyrsliste();
      $data['Rapport'] = $this->Materiell_model->tsrapport($this->uri->segment(3));
      $this->template->load('standard','materiell/tsrapport',$data);
    } else {
      $data['ID'] = $this->input->post('ID');
      $data['Skadetype'] = $this->input->post('Skadetype');
      $data['PersonID'] = $this->input->post('PersonID');
      $data['UtstyrID'] = $this->input->post('UtstyrID');
      $data['Hva'] = $this->input->post('Hva');
      $data['Hvordan'] = $this->input->post('Hvordan');
      $data['Losning'] = $this->input->post('Losning');
      $data['Notater'] = $this->input->post('Notater');
      $rapport = $this->Materiell_model->lagretsrapport($data);
      redirect('/materiell/tsrapport/'.$rapport['ID']);
    }
  }

  public function tsrapporter() {
    $this->load->model('Materiell_model');
    $data['Rapporter'] = $this->Materiell_model->tsrapporter();
    $this->template->load('standard','materiell/tsrapporter',$data);
  }

  public function nyttvedlikehold() {
    $data['UtstyrID'] = $this->input->post('UtstyrID');
  }


}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
