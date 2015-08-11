<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class okonomi extends CI_Controller {

  public function index() {
    redirect('/okonomi/innkjopsordrer');
  }

  public function oversikt() {
    $this->load->model('Okonomi_model');
    $data['Oversikt'] = $this->Okonomi_model->okonomioversikt();
    $this->template->load('standard','okonomi/oversikt',$data);
  }

  public function innkjopsordrer() {
    $this->load->model('Okonomi_model');
    $data['Ordrer'] = $this->Okonomi_model->innkjopsordrer();
    $this->template->load('standard','okonomi/innkjopsordrer',$data);
  }

  public function innkjopsordre() {
    $this->load->model('Okonomi_model');
    $this->load->model('Kontakter_model');
    $this->load->model('Prosjekter_model');

    if ($this->input->post('OrdreLagre')) {
      $data['ProsjektID'] = $this->input->post('ProsjektID');
      $data['PersonAnsvarligID'] = $this->input->post('PersonAnsvarligID');
      $data['LeverandorID'] = $this->input->post('LeverandorID');
      $data['Referanse'] = $this->input->post('Referanse');
      $data['Beskrivelse'] = $this->input->post('Beskrivelse');
      $ordre = $this->Okonomi_model->lagreinnkjopsordre($this->input->post('OrdreID'),$data);
      redirect('/okonomi/innkjopsordre/'.$ordre['OrdreID']);
    } elseif ($this->input->post('OrdreLagrelinje')) {
      $ID = $this->input->post('VarelinjeLinjeID');
      $linje['OrdreID'] = $this->input->post('OrdreID');
      $linje['Varenummer'] = $this->input->post('VarelinjeVarenummer');
      $linje['Varenavn'] = $this->input->post('VarelinjeVarenavn');
      $linje['Pris'] = str_replace(',', '.', $this->input->post('VarelinjePris'));
      $linje['Antall'] = $this->input->post('VarelinjeAntall');
      $linje = $this->Okonomi_model->lagreinnkjopsordrelinje($ID,$linje);
      redirect('/okonomi/innkjopsordre/'.$linje['OrdreID']);
    } elseif ($this->input->post('OrdreSlett')) {
      $this->Okonomi_model->slettinnkjopsordre($this->input->post('OrdreID'));
      redirect('okonomi/innkjopsordrer/');
    } elseif ($this->input->post('OrdreSendtilgodkjenning')) {
      $ID = $this->input->post('OrdreID');
      $ordre['StatusID'] = 2;
      $ordre = $this->Okonomi_model->lagreinnkjopsordre($ID,$ordre);
      redirect('/okonomi/innkjopsordre/'.$ordre['OrdreID']);
    } elseif ($this->input->post('OrdreGodkjenn')) {
      $ID = $this->input->post('OrdreID');
      $ordre['StatusID'] = 3;
      $ordre = $this->Okonomi_model->lagreinnkjopsordre($ID,$ordre);
      redirect('/okonomi/innkjopsordre/'.$ordre['OrdreID']);
    } elseif ($this->input->post('OrdreAvvis')) {
      $ID = $this->input->post('OrdreID');
      $ordre['StatusID'] = 1;
      $ordre = $this->Okonomi_model->lagreinnkjopsordre($ID,$ordre);
      redirect('/okonomi/innkjopsordre/'.$ordre['OrdreID']);
    } elseif ($this->input->post('OrdreBestilt')) {
      $ID = $this->input->post('OrdreID');
      $ordre['StatusID'] = 4;
      $ordre = $this->Okonomi_model->lagreinnkjopsordre($ID,$ordre);
      redirect('/okonomi/innkjopsordre/'.$ordre['OrdreID']);
    } elseif ($this->input->post('OrdreFullfort')) {
      $ID = $this->input->post('OrdreID');
      $ordre['StatusID'] = 6;
      $ordre = $this->Okonomi_model->lagreinnkjopsordre($ID,$ordre);
      redirect('/okonomi/innkjopsordre/'.$ordre['OrdreID']);
    } else {
      $data['Prosjekter'] = $this->Prosjekter_model->prosjekter();
      $data['ProsjekterArkiv'] = $this->Prosjekter_model->prosjekter(array("Arkiv" => "1"));
      $data['Medlemmer'] = $this->Kontakter_model->medlemmer();
      $data['Organisasjoner'] = $this->Kontakter_model->organisasjoner();
      $data['Ordre'] = $this->Okonomi_model->innkjopsordre($this->uri->segment(3));
      $data['Varelinjer'] = $this->Okonomi_model->innkjopsordrelinjer(array('OrdreID' => $this->uri->segment(3)));
      $this->template->load('standard','okonomi/innkjopsordre',$data);
    }
  }

  public function nyinnkjopsordre() {
    $this->load->model('Okonomi_model');
    $this->load->model('Kontakter_model');
    $this->load->model('Prosjekter_model');
    $data['Medlemmer'] = $this->Kontakter_model->medlemmer();
    $data['Organisasjoner'] = $this->Kontakter_model->organisasjoner();
    $data['Prosjekter'] = $this->Prosjekter_model->prosjekter();
    $data['ProsjekterArkiv'] = $this->Prosjekter_model->prosjekter(array("Arkiv" => "1"));
    $data['Ordre'] = null;
    $this->template->load('standard','okonomi/innkjopsordre',$data);
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
    if ($this->input->post('UtgiftLagre')) {
      $ID = $this->input->post('UtgiftID');
      $utgift['PersonID'] = $this->input->post('PersonID');
      $utgift['AktivitetID'] = $this->input->post('AktivitetID');
      $utgift['KontoID'] = $this->input->post('KontoID');
      $utgift['ProsjektID'] = $this->input->post('ProsjektID');
      $utgift['DatoBokfort'] = date("Y-m-d",strtotime($this->input->post('DatoBokfort')));
      $utgift['Beskrivelse'] = $this->input->post('Beskrivelse');
      $utgift['Belop'] = str_replace(',', '.', $this->input->post('Belop'));
      $config['upload_path'] = './uploads/';
      $config['allowed_types'] = 'gif|jpg|png|pdf';
      $config['encrypt_name'] = 'true';
      $utgift = $this->Okonomi_model->lagreutgift($ID,$utgift);
      $this->load->library('upload',$config);
      if ($this->upload->do_upload()) {
        $udata = $this->upload->data();
        $fildata['Filnavn'] = $udata['file_name'];
        $fildata['Navn'] = "Utgift ".$utgift['UtgiftID'];
        $fildata['UtgiftID'] = $utgift['UtgiftID'];
        $this->load->model('Filer_model');
        $this->Filer_model->nyfil($fildata);
      }
      redirect('/okonomi/utgift/'.$utgift['UtgiftID']);
    } elseif ($this->input->post('UtgiftSlett')) {
      $this->Okonomi_model->slettutgift($this->input->post('UtgiftID'));
      redirect('okonomi/utgifter/');
    } else {
      $this->load->model('Prosjekter_model');
      $this->load->model('Kontakter_model');
      $data['Aktiviteter'] = $this->Okonomi_model->aktiviteter();
      $data['Kontoer'] = $this->Okonomi_model->kontoer(1);
      $data['Prosjekter'] = $this->Prosjekter_model->prosjekter();
      $data['ProsjekterArkiv'] = $this->Prosjekter_model->prosjekter(array("Arkiv" => "1"));
      $data['Medlemmer'] = $this->Kontakter_model->medlemmer();
      $data['Utgift'] = $this->Okonomi_model->utgift($this->uri->segment(3));
      $this->template->load('standard','okonomi/utgift',$data);
    }
  }

  public function nyutgift() {
    $this->load->model('Okonomi_model');
    $this->load->model('Prosjekter_model');
    $this->load->model('Kontakter_model');
    $data['Utgift'] = null;
    $data['Aktiviteter'] = $this->Okonomi_model->aktiviteter();
    $data['Kontoer'] = $this->Okonomi_model->kontoer(1);
    $data['Prosjekter'] = $this->Prosjekter_model->prosjekter();
    $data['ProsjekterArkiv'] = $this->Prosjekter_model->prosjekter(array("Arkiv" => "1"));
    $data['Medlemmer'] = $this->Kontakter_model->medlemmer();
    $this->template->load('standard','okonomi/utgift',$data);
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
    if ($this->input->post('InntektLagre')) {
      $ID = $this->input->post('InntektID');
      $inntekt['PersonID'] = $this->input->post('PersonID');
      $inntekt['AktivitetID'] = $this->input->post('AktivitetID');
      $inntekt['KontoID'] = $this->input->post('KontoID');
      $inntekt['ProsjektID'] = $this->input->post('ProsjektID');
      $inntekt['DatoBokfort'] = date("Y-m-d",strtotime($this->input->post('DatoBokfort')));
      $inntekt['Beskrivelse'] = $this->input->post('Beskrivelse');
      $inntekt['Belop'] = str_replace(',', '.', $this->input->post('Belop'));
      $inntekt = $this->Okonomi_model->lagreinntekt($ID,$inntekt);
      redirect('/okonomi/inntekt/'.$inntekt['InntektID']);
    } elseif ($this->input->post('InntektSlett')) {
      $this->Okonomi_model->slettinntekt($this->input->post('InntektID'));
      redirect('okonomi/inntekter/');
    } else {
      $this->load->model('Prosjekter_model');
      $this->load->model('Kontakter_model');
      $data['Aktiviteter'] = $this->Okonomi_model->aktiviteter();
      $data['Kontoer'] = $this->Okonomi_model->kontoer();
      $data['Prosjekter'] = $this->Prosjekter_model->prosjekter();
      $data['ProsjekterArkiv'] = $this->Prosjekter_model->prosjekter(array("Arkiv" => "1"));
      $data['Medlemmer'] = $this->Kontakter_model->medlemmer();
      $data['Inntekt'] = $this->Okonomi_model->inntekt($this->uri->segment(3));
      $this->template->load('standard','okonomi/inntekt',$data);
    }
  }

  public function nyinntekt() {
    $this->load->model('Okonomi_model');
    $this->load->model('Prosjekter_model');
    $this->load->model('Kontakter_model');
    $data['Inntekt'] = null;
    $data['Aktiviteter'] = $this->Okonomi_model->aktiviteter();
    $data['Kontoer'] = $this->Okonomi_model->kontoer();
    $data['Prosjekter'] = $this->Prosjekter_model->prosjekter();
    $data['ProsjekterArkiv'] = $this->Prosjekter_model->prosjekter(array("Arkiv" => "1"));
    $data['Medlemmer'] = $this->Kontakter_model->medlemmer();
    $this->template->load('standard','okonomi/inntekt',$data);
  }


  public function varemottak() {
    $this->load->model('Okonomi_model');
    if ($this->input->post('Levert')) {
      $mottak['PersonID'] = $this->input->post('PersonID');
      $mottak['Linjer'] = $this->input->post('Levert');
      $this->Okonomi_model->registrerevaremottak($mottak);
    }
    $data['Varelinjer'] = $this->Okonomi_model->innkjopsordrelinjer(array('StatusID' => 1));
    $this->template->load('standard','okonomi/varemottak',$data);
  }

  public function utleggskvitteringer() {
    $this->load->model('Okonomi_model');
    $this->load->model('Kontakter_model');

    if ($this->input->get('far')) {
      $filter['Ar'] = $this->input->get('far');
    } else {
      $filter['Ar'] = date('Y');
    }
    if ($this->input->get('faktivitetid')) { $filter['AktivitetID'] = $this->input->get('faktivitetid'); }
    if ($this->input->get('fpersonid')) { $filter['PersonID'] = $this->input->get('fpersonid'); }

    $data['Aktiviteter'] = $this->Okonomi_model->aktiviteter();
    $data['Personer'] = $this->Kontakter_model->medlemmer();
    $data['Utleggskvitteringer'] = $this->Okonomi_model->utleggskvitteringer($filter);
    $this->template->load('standard','okonomi/utleggskvitteringer',$data);
  }

  public function utleggskvittering() {
    $this->load->model('Okonomi_model');
    if ($this->input->post('UtleggLagre')) {
      $ID = $this->input->post('UtleggID');
      $utlegg['PersonID'] = $this->input->post('PersonID');
      $utlegg['AktivitetID'] = $this->input->post('AktivitetID');
      $utlegg['ProsjektID'] = $this->input->post('ProsjektID');
      $utlegg['Kontonummer'] = $this->input->post('Kontonummer');
      $utlegg['DatoUtlegg'] = date('Y-m-d',strtotime($this->input->post('DatoUtlegg')));
      $utlegg['Beskrivelse'] = $this->input->post('Beskrivelse');
      $utlegg['Belop'] = str_replace(',', '.', $this->input->post('Belop'));
      $utlegg = $this->Okonomi_model->lagreutleggskvittering($ID,$utlegg);

      $config['upload_path'] = './uploads/';
      $config['allowed_types'] = 'gif|jpg|png|pdf';
      $config['encrypt_name'] = 'true';
      $this->load->library('upload',$config);
      if ($this->upload->do_upload()) {
        $udata = $this->upload->data();
        $fildata['Filnavn'] = $udata['file_name'];
        $fildata['Navn'] = "Utleggskvittering ".$utlegg['UtleggID'];
        $fildata['UtleggID'] = $utlegg['UtleggID'];
        $this->load->model('Filer_model');
        $this->Filer_model->nyfil($fildata);
      }

      redirect('/okonomi/utleggskvittering/'.$utlegg['UtleggID']);
    } elseif ($this->input->post('UtleggSlett')) {
      $this->Okonomi_model->slettutleggskvittering($this->input->post('UtleggID'));
      redirect('/okonomi/utleggskvitteringer/');
    } elseif ($this->input->post('UtleggSigner')) {
      $this->Okonomi_model->signerutleggskvittering($this->input->post('UtleggID'),$this->UABruker['ID']);
    } elseif ($this->input->post('UtleggGodkjenn')) {
      $this->Okonomi_model->godkjennutleggskvittering($this->input->post('UtleggID'),$this->UABruker['ID']);
    } else {
      $this->load->model('Kontakter_model');
      $this->load->model('Prosjekter_model');
      $data['Aktiviteter'] = $this->Okonomi_model->aktiviteter();
      $data['Personer'] = $this->Kontakter_model->medlemmer();
      $data['Prosjekter'] = $this->Prosjekter_model->prosjekter();
      $data['ProsjekterArkiv'] = $this->Prosjekter_model->prosjekter(array("Arkiv" => "1"));
      $data['Utlegg'] = $this->Okonomi_model->utleggskvittering($this->uri->segment(3));
      $this->template->load('standard','okonomi/utleggskvittering',$data);
    }
  }

  public function nyutleggskvittering() {
    $this->load->model('Okonomi_model');
    $this->load->model('Kontakter_model');
    $this->load->model('Prosjekter_model');
    $data['Aktiviteter'] = $this->Okonomi_model->aktiviteter();
    $data['Personer'] = $this->Kontakter_model->medlemmer();
    $data['Prosjekter'] = $this->Prosjekter_model->prosjekter();
    $data['ProsjekterArkiv'] = $this->Prosjekter_model->prosjekter(array("Arkiv" => "1"));
    $data['Utlegg'] = null;
    $this->template->load('standard','okonomi/utleggskvittering',$data);
  }

  public function tilutbetaling() {
    $this->load->model('Okonomi_model');
    if ($this->input->post('UtleggUtbetalt')) {
      $UtleggUtbetalt = $this->input->post('UtleggUtbetalt');
      for ($x=0; $x<sizeof($UtleggUtbetalt); $x++) {
        $this->Okonomi_model->utbetaltutleggskvittering($UtleggUtbetalt[$x],$this->UABruker['ID']);
      }
      unset($UtleggUtbetalt);
    }
    $data['Utleggskvitteringer'] = $this->Okonomi_model->utleggtilutbetaling();
    $this->template->load('standard','okonomi/tilutbetaling',$data);
  }

  public function fakturaer() {
    $this->load->model('Okonomi_model');
    $data['Fakturaer'] = $this->Okonomi_model->fakturaer();
    $this->template->load('standard','okonomi/fakturaer',$data);
  }

  public function tilfakturering() {
    $this->load->model('Okonomi_model');
    $data['Fakturaer'] = $this->Okonomi_model->fakturaer(array('StatusID' => 1));
    $this->template->load('standard','okonomi/fakturaer',$data);
  }

  public function faktura() {
    $this->load->model('Okonomi_model');
    $this->load->model('Kontakter_model');
    if ($this->input->post('FakturaLagre')) {
      $ID = $this->input->post('FakturaID');
      $faktura['OrganisasjonID'] = $this->input->post('OrganisasjonID');
      $faktura['Referanse'] = $this->input->post('Referanse');
      $faktura['DatoFakturadato'] = date('Y-m-d',strtotime($this->input->post('DatoFakturadato')));
      $faktura['PersonAnsvarligID'] = $this->input->post('PersonAnsvarligID');
      $faktura['Notater'] = $this->input->post('Notater');
      $faktura = $this->Okonomi_model->lagrefaktura($ID,$faktura);
      redirect('/okonomi/faktura/'.$faktura['FakturaID']);
    } elseif ($this->input->post('FakturaTilfakturering')) {
      $ID = $this->input->post('FakturaID');
      $faktura['StatusID'] = 1;
      $faktura = $this->Okonomi_model->lagrefaktura($ID,$faktura);
      redirect('/okonomi/faktura/'.$faktura['FakturaID']);
    } elseif ($this->input->post('FakturaFakturert')) {
      $ID = $this->input->post('FakturaID');
      $faktura['StatusID'] = 2;
      $faktura = $this->Okonomi_model->lagrefaktura($ID,$faktura);
      redirect('/okonomi/faktura/'.$faktura['FakturaID']);
    } elseif ($this->input->post('FakturaLagrelinje')) {
      $ID = $this->input->post('FakturalinjeLinjeID');
      $linje['FakturaID'] = $this->input->post('FakturaID');
      $linje['Produktnummer'] = $this->input->post('FakturalinjeProduktnummer');
      $linje['Beskrivelse'] = $this->input->post('FakturalinjeBeskrivelse');
      $linje['Antall'] = $this->input->post('FakturalinjeAntall');
      $linje['Pris'] = str_replace(',','.',$this->input->post('FakturalinjePris'));
      $linje = $this->Okonomi_model->lagrefakturalinje($ID,$linje);
      redirect('/okonomi/faktura/'.$linje['FakturaID']);
    } else {
      $data['Personer'] = $this->Kontakter_model->medlemmer();
      $data['Organisasjoner'] = $this->Kontakter_model->organisasjoner();
      $data['Faktura'] = $this->Okonomi_model->faktura($this->uri->segment(3));
      $this->template->load('standard','okonomi/faktura',$data);
    }
  }

  public function nyfaktura() {
    $this->load->model('Kontakter_model');
    $data['Faktura'] = null;
    $data['Personer'] = $this->Kontakter_model->medlemmer();
    $data['Organisasjoner'] = $this->Kontakter_model->organisasjoner();
    $this->template->load('standard','okonomi/faktura',$data);
  }

  public function trengerstotte() {
    $this->load->model('Prosjekter_model');
    $data['Prosjekter'] = $this->Prosjekter_model->prosjekter(array('VisAlle' => 1,'Finansiering' => 1));
    $this->template->load('standard','okonomi/trengerstotte',$data);
  }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
