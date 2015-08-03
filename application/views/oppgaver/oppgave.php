<?php echo form_open('oppgaver/oppgave/'); ?>
<input type="hidden" name="OppgaveID" value="<?php echo set_value('OppgaveID',$Oppgave['OppgaveID']); ?>" />
<fieldset>
  <legend>Oppgave</legend>

  <p>
    <label for="DatoFrist">Frist:</label>
    <input type="date" name="DatoFrist" id="DatoFrist" value="<?php echo set_value('DatoFrist',($Oppgave['DatoFrist'] != "0000-00-00") ? date("d.m.Y",strtotime($Oppgave['DatoFrist'])) : '' ); ?>" placeholder="dd.mm.YYYY" />
  </p>

  <p>
    <label for="Prioritet">Prioritet:</label>
    <select name="PrioritetID">
      <option value="0"<?php echo set_select('PrioritetID',0,($Oppgave['PrioritetID'] == 0) ? TRUE : FALSE); ?>>Lav</option>
      <option value="1"<?php echo set_select('PrioritetID',1,($Oppgave['PrioritetID'] == 1) ? TRUE : FALSE, TRUE); ?>>Normal</option>
      <option value="2"<?php echo set_select('PrioritetID',2,($Oppgave['PrioritetID'] == 2) ? TRUE : FALSE); ?>>Høy</option>
    </select>
  </p>

  <p>
    <label for="Tittel">Tittel:</label>
    <input type="text" name="Tittel" id="Tittel" value="<?php echo set_value('Tittel',$Oppgave['Tittel']); ?>" placeholder="Tittel på oppgaven" />
  </p>

  <p>
    <label for="Beskrivelse" style="vertical-align: top">Beskrivelse:</label>
    <textarea name="Beskrivelse" id="Beskrivelse" placeholder="En god beskrivelse av hva som skal gjøres."><?php echo set_value('Beskrivelse',$Oppgave['Beskrivelse']); ?></textarea>
  </p>

  <p>
    <label for="PersonAnsvarligID">Ansvarlig:</label>
    <select name="PersonAnsvarligID" id="PersonAnsvarligID">
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
  </p>

  <p>
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
  </p>

  <p>
    <label>&nbsp;</label>
<?php } ?>
    <textarea name="Notat" id="Notat" style="height: 40px;" placeholder="Hva er gjort i forbindelse med oppgaven."></textarea>
  </p>

  <p>
    <label for="StatusID">Status:</label>
    <select name="StatusID">
      <option value="0"<?php echo set_select('StatusID',0,($Oppgave['StatusID'] == 0) ? TRUE : FALSE); ?> disabled>Ikke påbegynt</option>
      <option value="1"<?php echo set_select('StatusID',1,($Oppgave['StatusID'] == 1) ? TRUE : FALSE); ?>>Påbegynt</option>
      <option value="2"<?php echo set_select('StatusID',2,($Oppgave['StatusID'] == 2) ? TRUE : FALSE); ?>>Fullført</option>
    </select>
  </p>

  <p class="handlinger">
    <label>&nbsp;</label>
    <input type="submit" value="Lagre" name="OppgaveLagre" />
    <input type="submit" value="Slett" name="OppgaveSlett" />
  </p>

</fieldset>
<?php echo form_close(); ?>
