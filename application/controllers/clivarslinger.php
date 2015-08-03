<?php
  class CLIVarslinger extends CI_Controller {

    public function sendeposter() {
      $this->load->library('email');
      $eposter = $this->db->query("SELECT EpostID,Emne,Meldingstekst,DatoSendt,Epost FROM `VarslingEposter` JOIN `kon_personer` ON (VarslingEposter.PersonMottakerID=kon_personer.ID AND DatoSendt='0000-00-00 00:00:00')");
      foreach ($eposter->result() as $epost) {
        $this->email->clear();

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = '213.162.247.41';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $this->email->initialize($config);

        $this->email->from('hjelpekorps@bomlork.no', 'Bømlo RKH');
        $this->email->to($epost->Epost);
        $this->email->subject($epost->Emne);
        $this->email->message($epost->Meldingstekst);
        if ($this->email->send()) {
          $this->db->query("UPDATE VarslingEposter SET DatoSendt=Now(),SMTPDebug='".$this->email->print_debugger()."' WHERE EpostID=".$epost->EpostID);
        }
      }
      $this->db->query("UPDATE CronStatus SET DatoSistekjoring=Now() WHERE Navn='SendEposter'");
    }

  }
?>
