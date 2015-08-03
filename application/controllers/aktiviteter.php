<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aktiviteter extends CI_Controller {

  public function index() {
    redirect('/medlemmer/liste');
  }

  public function aksjoner() {
    $this->load->model('Aktiviteter_model');
    $data['Aksjoner'] = $this->Aktiviteter_model->aksjoner();
    $this->template->load('standard','aktiviteter/aksjoner',$data);
  }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
