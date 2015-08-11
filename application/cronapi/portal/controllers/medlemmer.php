<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Medlemmer extends CI_Controller {

  public function index() {
    redirect('/medlemmer/liste');
  }

  public function liste() {
    $this->load->model('Medlemmer_model');
    $data['Medlemmer'] = $this->Medlemmer_model->medlemmer();
    $this->template->load('standard','medlemmer/liste',$data);
  }

  public function medlem() {
    $this->load->model('Medlemmer_model');
    $data['Medlem'] = $this->Medlemmer_model->medlem($this->uri->segment(3));
    $this->template->load('standard','medlemmer/medlem',$data);
  }

  public function faggrupper() {
    $this->load->model('Medlemmer_model');
    $data['Faggrupper'] = $this->Medlemmer_model->faggrupper();
    $this->template->load('standard','medlemmer/faggrupper',$data);
  }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
