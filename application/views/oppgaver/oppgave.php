<?php echo form_open('oppgaver/oppgave/'); ?>
<input type="hidden" name="OppgaveID" value="<?php echo set_value('OppgaveID',$Oppgave['OppgaveID']); ?>" />
<div class="panel panel-default">
  <div class="panel-heading"><h4>Oppgave</h4></div>

  <div class="panel-body">

    <div class="form-group">
      <label for="DatoFrist">Frist:</label>
      <input type="date" class="form-control" name="DatoFrist" id="DatoFrist" value="<?php echo set_value('DatoFrist',($Oppgave['DatoFrist'] != "0000-00-00") ? date("d.m.Y",strtotime($Oppgave['DatoFrist'])) : '' ); ?>" placeholder="dd.mm.YYYY" />
    </div>

    <div class="form-group">
      <label for="Prioritet">Prioritet:</label>
      <select name="PrioritetID" class="form-control">
        <option value="0"<?php echo set_select('PrioritetID',0,($Oppgave['PrioritetID'] == 0) ? TRUE : FALSE); ?>>Lav</option>
        <option value="1"<?php echo set_select('PrioritetID',1,($Oppgave['PrioritetID'] == 1) ? TRUE : FALSE, TRUE); ?>>Normal</option>
        <option value="2"<?php echo set_select('PrioritetID',2,($Oppgave['PrioritetID'] == 2) ? TRUE : FALSE); ?>>Høy</option>
      </select>
    </div>

    <div class="form-group">
      <label for="Tittel">Tittel:</label>
      <input type="text" class="form-control" name="Tittel" id="Tittel" value="<?php echo set_value('Tittel',$Oppgave['Tittel']); ?>" placeholder="Tittel på oppgaven" />
    </div>

    <div class="form-group">
      <label for="Beskrivelse" style="vertical-align: top">Beskrivelse:</label>
      <textarea name="Beskrivelse" class="form-control" id="Beskrivelse" placeholder="En god beskrivelse av hva som skal gjøres."><?php echo set_value('Beskrivelse',$Oppgave['Beskrivelse']); ?></textarea>
    </div>

    <div class="form-group">
      <label for="PersonAnsvarligID">Ansvarlig:</label>
      <select name="PersonAnsvarligID" id="PersonAnsvarligID" class="form-control">
        <option value="0" <?php echo set_select('PersonAnsvarligID',0,($Oppgave['PersonAnsvarligID'] == 0) ? TRUE : FALSE); ?>>(ikke satt)</option>
<?php
  if (isset($Personer)) {
    foreach ($Personer as $Person) {
?>
        <option value="<?php echo $Person['PersonID']; ?>" <?php echo set_select('PersonAnsvarligID',$Person['PersonID'],($Oppgave['PersonAnsvarligID'] == $Person['PersonID']) ? TRUE : FALSE); ?>><?php echo $Person['Fornavn']." ".$Person['Etternavn']; ?></option>
<?php
    }
  }
?>
      </select>
    </div>

    <div class="form-group">
      <label for="Notat" style="vertical-align: top">Arbeid utført:</label>
<?php if (isset($Oppgave['Notater'])) { ?>
      <table>
<?php foreach ($Oppgave['Notater'] as $Notat) { ?>
        <tr>
          <td><?php echo date("d.m.Y H:i",strtotime($Notat['DatoRegistrert'])); ?></td>
          <td><?php echo $Notat['Notat']; ?></td>
        </tr>
<?php } ?>
      </table>
    </div>

    <div class="form-group">
      <label>&nbsp;</label>
<?php } ?>
      <textarea name="Notat" class="form-control" id="Notat" style="height: 40px;" placeholder="Hva er gjort i forbindelse med oppgaven."></textarea>
    </div>

    <div class="form-group">
      <label for="StatusID">Status:</label>
      <select name="StatusID" class="form-control">
        <option value="0"<?php echo set_select('StatusID',0,($Oppgave['StatusID'] == 0) ? TRUE : FALSE); ?> disabled>Ikke påbegynt</option>
        <option value="1"<?php echo set_select('StatusID',1,($Oppgave['StatusID'] == 1) ? TRUE : FALSE); ?>>Påbegynt</option>
        <option value="2"<?php echo set_select('StatusID',2,($Oppgave['StatusID'] == 2) ? TRUE : FALSE); ?>>Fullført</option>
      </select>
    </div>

    <div class="form-group">
      <input type="submit" class="btn btn-default" value="Lagre" name="OppgaveLagre" />
      <input type="submit" class="btn btn-default" value="Slett" name="OppgaveSlett" />
    </div>
  </div>
</div>
<?php echo form_close(); ?>
