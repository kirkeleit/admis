<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Json extends CI_Controller {

  public function elementer() {
    $this->output->set_header('Access-Control-Allow-Origin: *');
    $data['data'] = $this->Dadas_model->elementer($this->uri->segment(3));
    $this->load->view('json',$data);
  }

  public function nyttelement() {
    $data['TypeID'] = $this->input->post('TypeID');
    $data['Tittel'] = $this->input->post('Tittel');
    /*$data['MVerdiNr'] = $this->input->post('MVerdiNr');
    $data['MVerdiNrType'] = $this->input->post('MVerdiNrType');*/
    $data['MVerdiNr'] = 0;
    $data['MVerdiNrType'] = 0;
    $data['SideID'] = $this->input->post('SideID');
    $data['PosX'] = 0;
    $data['PosY'] = 0;
    $data['SizeW'] = 40;
    $data['SizeH'] = 40;
    $data['data'] = $this->Dadas_model->nyttelement($data);
    $this->load->view('json',$data);
  }

  public function lagreelement() {
    $element['ID'] = $this->input->post('ID');
    if ($this->input->post('Tittel')) {
      $element['Tittel'] = $this->input->post('Tittel');
    }
    if ($this->input->post('PosY')) {
      $element['PosY'] = $this->input->post('PosY');
      error_log("ID: ".$element['ID'].", PosY: ".$element['PosY']);
    }
    if ($this->input->post('PosX')) {
      $element['PosX'] = $this->input->post('PosX');
      error_log("ID: ".$element['ID'].", PosX: ".$element['PosX']);
    }
    if ($this->input->post('SizeW')) {
      $element['SizeW'] = $this->input->post('SizeW');
    }
    if ($this->input->post('SizeH')) {
      $element['SizeH'] = $this->input->post('SizeH');
    }
    $data['data'] = $this->Dadas_model->lagreelement($element);
    $this->load->view('json',$data);
  }

  public function slettelement() {
    $this->Dadas_model->slettelement($this->uri->segment(3));
  }
}

/* End of file json.php */
/* Location: ./application/controllers/json.php */
