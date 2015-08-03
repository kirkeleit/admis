<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class okonomi extends CI_Controller {

  public function index() {
    redirect('/okonomi/resultat');
  }

  public function innkjopsordrer() {
    $this->load->model('Okonomi_model');
    $data['Ordrer'] = $this->Okonomi_model->innkjopsordrer();
    $this->template->load('standard','okonomi/innkjopsordrer',$data);
  }

  public function innkjopsordre() {
    $this->load->model('Okonomi_model');
    $this->form_validation->set_rules('ID','ID','required|numeric');
    $this->form_validation->set_rules('PersonID','PersonID','required|numeric');
    $this->form_validation->set_rules('LeverandorID','LeverandorID','required|numeric');
    $this->form_validation->set_rules('Navn','Navn','required|trim');
    $this->form_validation->set_rules('Beskrivelse','Beskrivelse','trim');
    if ($this->form_validation->run() == TRUE) {
      $data['ID'] = $this->input->post('ID');
      $data['PersonID'] = $this->input->post('PersonID');
      $data['LeverandorID'] = $this->input->post('OrganisasjonID');
      $data['Navn'] = $this->input->post('Navn');
      $data['Beskrivelse'] = $this->input->post('Beskrivelse');
      $ordre = $this->Okonomi_model->lagreinnkjopsordre($data);
      redirect('/okonomi/innkjopsordre/'.$ordre['ID']);
    } else {
      $this->load->model('Kontakter_model');
      $data['Medlemmer'] = $this->Kontakter_model->medlemmer();
      $data['Organisasjoner'] = $this->Kontakter_model->organisasjoner();
      $data['Ordre'] = $this->Okonomi_model->innkjopsordre($this->uri->segment(3));
      $this->template->load('standard','okonomi/innkjopsordre',$data);
    }
  }

  public function nyinnkjopsordre() {
    $this->load->model('Okonomi_model');
    $this->load->model('Kontakter_model');
    $data['Medlemmer'] = $this->Kontakter_model->medlemmer();
    $data['Organisasjoner'] = $this->Kontakter_model->organisasjoner();
    $ordre['ID'] = 0;
    $ordre['PersonID'] = $this->UABruker['ID'];
    $ordre['LeverandorID'] = 0;
    $ordre['ProsjektID'] = 0;
    $ordre['Navn'] = "";
    $ordre['Beskrivelse'] = "";
    $ordre['StatusID'] = 0;
    $ordre['Status'] = "Under registrering";
    $data['Ordre'] = $ordre;
    $this->template->load('standard','okonomi/innkjopsordre',$data);
  }

  public function nyinnkjopsordrelinje() {
    $this->load->model('Okonomi_model');
    $linje['ID'] = $this->input->post('LinjeID');
    $linje['OrdreID'] = $this->input->post('OrdreID');
    $linje['LeverandorID'] = $this->input->post('LeverandorID');
    $linje['Varenummer'] = $this->input->post('Varenummer');
    $linje['Varenavn'] = $this->input->post('Varenavn');
    $linje['Pris'] = str_replace(',', '.', $this->input->post('Pris'));
    $linje['Antall'] = $this->input->post('Antall');
    $this->Okonomi_model->lagreinnkjopsordrelinje($linje);
    redirect('/okonomi/innkjopsordre/'.$linje['OrdreID']);
  }

  public function slettinnkjopsordrelinje() {
    $this->load->model('Okonomi_model');
    $this->Okonomi_model->slettinnkjopsordrelinje($this->input->get('linjeid'));
    redirect('okonomi/innkjopsordre/'.$this->input->get('ordreid'));
  }

  public function slettinnkjopsordre() {
    $this->load->model('Okonomi_model');
    $this->Okonomi_model->slettinnkjopsordre($this->uri->segment(3));
    redirect('okonomi/innkjopsordrer/');
  }

  public function settinnkjopsordrestatus() {
    $this->load->model('Okonomi_model');
    $ordre['ID'] = $this->input->get('iid');
    $ordre['Status'] = $this->input->get('status');
    if ($this->Okonomi_model->settinnkjopsordrestatus($ordre)) {
      $this->load->library('email');
      $ordre = $this->Okonomi_model->innkjopsordre($ordre['ID']);
      $config['protocol'] = "smtp";
      $config['smtp_host'] = "jhsmx.hatteland.com";
      $config['smtp_port'] = "25";
      $this->email->initialize($config);
      $this->email->from('hjelpekorps@bomlork.no', 'Bømlo RKH');
      if ($ordre['StatusID'] == 1) {
        $this->email->to($ordre['PersonEpost']);
        $this->email->subject('[admis] Innkjøpsordre ble avvist ('.$ordre['ID'].')');
        $this->email->message("Navn: ".$ordre['Navn']."\nBeløp: kr ".number_format($ordre['Sum'],2,',','.')."\nBeskrivelse: ".$ordre['Beskrivelse']."\n\nLink: ".site_url()."/okonomi/innkjopsordre/".$ordre['ID']);
        $this->email->send();
      } elseif ($ordre['StatusID'] == 2) {
        $this->email->to('chrizzbjerke@hotmail.com');
        $this->email->subject('[admis] Innkjøpsordre trenger godkjenning ('.$ordre['ID'].')');
        $this->email->message("Navn: ".$ordre['Navn']."\nBeløp: kr ".number_format($ordre['Sum'],2,',','.')."\nBeskrivelse: ".$ordre['Beskrivelse']."\n\nLink: ".site_url()."/okonomi/innkjopsordre/".$ordre['ID']);
        $this->email->send();
      } elseif ($ordre['StatusID'] == 3) {
        $this->email->to($ordre['PersonEpost']);
        $this->email->subject('[admis] Innkjøpsordre er godkjent ('.$ordre['ID'].')');
        $this->email->message("Navn: ".$ordre['Navn']."\nBeløp: kr ".number_format($ordre['Sum'],2,',','.')."\nBeskrivelse: ".$ordre['Beskrivelse']."\n\nLink: ".site_url()."/okonomi/innkjopsordre/".$ordre['ID']);
        $this->email->send();
      }
      //echo $this->email->print_debugger();
    }
    redirect('okonomi/innkjopsordre/'.$ordre['ID']);
  }

  public function utgifter() {
    $this->load->model('Okonomi_model');
    $this->load->model('Prosjekter_model');
    $this->load->model('Kontakter_model');
    $data['Aktiviteter'] = $this->Okonomi_model->aktiviteter();
    $data['Kontoer'] = $this->Okonomi_model->kontoer(1);
    $data['Prosjekter'] = $this->Prosjekter_model->prosjekter();
    $data['Personer'] = $this->Kontakter_model->medlemmer();
    if ($this->input->get('far')) {
      $filter['Ar'] = $this->input->get('far');
    } else {
      $filter['Ar'] = date('Y');
    }
    if ($this->input->get('fkontoid')) { $filter['KontoID'] = $this->input->get('fkontoid'); }
    if ($this->input->get('faktivitetid')) { $filter['AktivitetID'] = $this->input->get('faktivitetid'); }
    if ($this->input->get('fprosjektid')) { $filter['ProsjektID'] = $this->input->get('fprosjektid'); }
    if ($this->input->get('fpersonid')) { $filter['PersonID'] = $this->input->get('fpersonid'); }
    if ($this->input->get('fbeskrivelse')) { $filter['Beskrivelse'] = $this->input->get('fbeskrivelse'); }
    $data['Utgifter'] = $this->Okonomi_model->utgifter($filter);
    $this->template->load('standard','okonomi/utgifter',$data);
  }

  public function utgift() {
    $this->load->model('Okonomi_model');
    $this->form_validation->set_rules('ID','ID','required|numeric');
    $this->form_validation->set_rules('PersonID','PersonID','required|numeric');
    $this->form_validation->set_rules('AktivitetID','AktivitetID','required|trim');
    $this->form_validation->set_rules('KontoID','KontoID','required|trim');
    $this->form_validation->set_rules('ProsjektID','ProsjektID','required|numeric');
    $this->form_validation->set_rules('DatoBokfort','DatoBokfort','required|trim');
    $this->form_validation->set_rules('Beskrivelse','Beskrivelse','required|trim');
    $this->form_validation->set_rules('Belop','Belop','required|trim');
    if ($this->form_validation->run() == TRUE) {
      $utgift['ID'] = $this->input->post('ID');
      $utgift['PersonID'] = $this->input->post('PersonID');
      $utgift['AktivitetID'] = $this->input->post('AktivitetID');
      $utgift['KontoID'] = $this->input->post('KontoID');
      $utgift['ProsjektID'] = $this->input->post('ProsjektID');
      $utgift['DatoBokfort'] = $this->input->post('DatoBokfort');
      $utgift['Beskrivelse'] = $this->input->post('Beskrivelse');
      $utgift['Belop'] = str_replace(',', '.', $this->input->post('Belop'));
      $config['upload_path'] = './uploads/';
      $config['allowed_types'] = 'gif|jpg|png|pdf';
      $config['encrypt_name'] = 'true';
      $ID = $this->Okonomi_model->lagreutgift($utgift);
      $this->load->library('upload',$config);
      if ($this->upload->do_upload()) {
        $udata = $this->upload->data();
        $fildata['Filnavn'] = $udata['file_name'];
        $fildata['Navn'] = "Utgift ".$ID;
        $fildata['UtgiftID'] = $ID;
        $this->load->model('Filer_model');
        $this->Filer_model->nyfil($fildata);
      }
      redirect('/okonomi/utgifter');
    } else {
      $this->load->model('Prosjekter_model');
      $this->load->model('Kontakter_model');
      $data['Aktiviteter'] = $this->Okonomi_model->aktiviteter();
      $data['Kontoer'] = $this->Okonomi_model->kontoer(1);
      $data['Prosjekter'] = $this->Prosjekter_model->prosjekter();
      $data['Medlemmer'] = $this->Kontakter_model->medlemmer();
      $data['Utgift'] = $this->Okonomi_model->utgift($this->uri->segment(3));
      $this->template->load('standard','okonomi/utgift',$data);
    }
  }

  private function utgiftepost($ID) {
    $this->load->model('Okonomi_model');
    $utgift = $this->Okonomi_model->utgift($ID);
    $this->load->library('email');
    $config['protocol'] = "smtp";
    $config['smtp_host'] = "jhsmx.hatteland.com";
    $config['smtp_port'] = "25";
    $this->email->initialize($config);
    $this->email->from('hjelpekorps@bomlork.no', 'Bømlo RKH');
    $this->email->to('thorbjorn@kirkeleit.net');
    $this->email->subject('[admis] Utgift registrert');
    $this->email->message("Aktivitet: ".$utgift['AktivitetID']."\nKonto: ".$utgift['KontoID']."\nDato: ".$utgift['DatoBokfort']."\nBeløp: kr ".$utgift['Belop']."\n\n".$utgift['Beskrivelse']);
    if ($utgift['Filnavn'] != "") {
      $this->email->attach('/var/www/admis.bomlork.no/uploads/bilag/'.$utgift['Filnavn']);
    }
    $this->email->send();
     echo $this->email->print_debugger();
  }

  public function nyutgift() {
    $this->load->model('Okonomi_model');
    $this->load->model('Prosjekter_model');
    $this->load->model('Kontakter_model');
    $utgift['ID'] = 0;
    $utgift['PersonID'] = $this->UABruker['ID'];
    $utgift['AktivitetID'] = 0;
    $utgift['KontoID'] = 0;
    $utgift['ProsjektID'] = 0;
    $utgift['DatoBokfort'] = date('d.m.Y');
    $utgift['Beskrivelse'] = "";
    $utgift['Belop'] = 0;
    $data['Utgift'] = $utgift;
    $data['Aktiviteter'] = $this->Okonomi_model->aktiviteter();
    $data['Kontoer'] = $this->Okonomi_model->kontoer(1);
    $data['Prosjekter'] = $this->Prosjekter_model->prosjekter();
    $data['Medlemmer'] = $this->Kontakter_model->medlemmer();
    $this->template->load('standard','okonomi/utgift',$data);
  }

  public function slettutgift() {
    $this->load->model('Okonomi_model');
    $this->Okonomi_model->slettutgift($this->uri->segment(3));
    redirect('okonomi/utgifter/');
  }

  public function inntekter() {
    $this->load->model('Okonomi_model');
    $data['Aktiviteter'] = $this->Okonomi_model->aktiviteter();
    $data['Kontoer'] = $this->Okonomi_model->kontoer();
    $data['Inntekter'] = $this->Okonomi_model->Inntekter();
    $this->template->load('standard','okonomi/inntekter',$data);
  }

  public function inntekt() {
    $this->load->model('Okonomi_model');
    $this->form_validation->set_rules('ID','ID','required|numeric');
    $this->form_validation->set_rules('PersonID','PersonID','required|numeric');
    $this->form_validation->set_rules('AktivitetID','AktivitetID','required|trim');
    $this->form_validation->set_rules('KontoID','KontoID','required|trim');
    $this->form_validation->set_rules('DatoBokfort','DatoBokfort','required|trim');
    $this->form_validation->set_rules('Beskrivelse','Beskrivelse','required|trim');
    $this->form_validation->set_rules('Belop','Belop','required|trim');
    if ($this->form_validation->run() == TRUE) {
      $inntekt['ID'] = $this->input->post('ID');
      $inntekt['PersonID'] = $this->input->post('PersonID');
      $inntekt['AktivitetID'] = $this->input->post('AktivitetID');
      $inntekt['KontoID'] = $this->input->post('KontoID');
      $inntekt['DatoBokfort'] = $this->input->post('DatoBokfort');
      $inntekt['Beskrivelse'] = $this->input->post('Beskrivelse');
      $inntekt['Belop'] = str_replace(',', '.', $this->input->post('Belop'));
      $this->Okonomi_model->lagreinntekt($inntekt);
      redirect('/okonomi/inntekter');
    } else {
      $this->load->model('Prosjekter_model');
      $this->load->model('Kontakter_model');
      $data['Aktiviteter'] = $this->Okonomi_model->aktiviteter();
      $data['Kontoer'] = $this->Okonomi_model->kontoer();
      $data['Medlemmer'] = $this->Kontakter_model->medlemmer();
      $data['Inntekt'] = $this->Okonomi_model->inntekt($this->uri->segment(3));
      $this->template->load('standard','okonomi/inntekt',$data);
    }
  }

  public function nyinntekt() {
    $this->load->model('Okonomi_model');
    $this->load->model('Prosjekter_model');
    $this->load->model('Kontakter_model');
    $inntekt['ID'] = 0;
    $inntekt['PersonID'] = 0;
    $inntekt['AktivitetID'] = 0;
    $inntekt['KontoID'] = 0;
    $inntekt['DatoBokfort'] = date('d.m.Y');
    $inntekt['Beskrivelse'] = "";
    $inntekt['Belop'] = 0;
    $data['Inntekt'] = $inntekt;
    $data['Aktiviteter'] = $this->Okonomi_model->aktiviteter();
    $data['Kontoer'] = $this->Okonomi_model->kontoer();
    $data['Medlemmer'] = $this->Kontakter_model->medlemmer();
    $this->template->load('standard','okonomi/inntekt',$data);
  }

  public function slettinntekt() {
    $this->load->model('Okonomi_model');
    $this->Okonomi_model->slettinntekt($this->uri->segment(3));
    redirect('okonomi/inntekter/');
  }

  public function resultat() {
    $this->load->model('Okonomi_model');
    $data['Aktiviteter'] = $this->Okonomi_model->aktiviteter();
    $data['Resultat'] = $this->Okonomi_model->resultat();
    $this->template->load('standard','okonomi/resultat',$data);
  }

  public function budsjett() {
    $this->load->model('Okonomi_model');
    $this->Okonomi_model->lagrebudsjett($this->input->post());
    $data['Aktiviteter'] = $this->Okonomi_model->aktiviteter();
    $data['KontoerINN'] = $this->Okonomi_model->kontoer(0);
    $data['KontoerUT'] = $this->Okonomi_model->kontoer(1);
    $data['Budsjett'] = $this->Okonomi_model->budsjett();
    $this->template->load('standard','okonomi/budsjett',$data);
  }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
