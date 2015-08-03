<?php
  $Redigerbar = 0;
  if (($Sak['SaksNummer'] == 0) and (in_array('801',$UABruker['UAP']))) {
    $Redigerbar = 1;
  }
?>
<?php echo form_open('/raadet/sak/'); ?>
<input type="hidden" name="SakID" value="<?php echo set_value('SakID',$Sak['SakID']); ?>" />
<fieldset>
  <legend>Sak</legend>

  <p>
    <label>Saksnummer:</label>
    <?php echo $Sak['SaksAr']."/".$Sak['SaksNummer']; ?>
  </p>

  <p>
    <label for="Tittel">Tittel:</label>
    <input type="text" name="Tittel" id="Tittel" value="<?php echo set_value('Tittel',$Sak['Tittel']); ?>" <?php if ($Redigerbar == 0) { echo "disabled "; } ?>/>
  </p>

  <p>
    <label for="PersonID">Innmeldt av:</label>
    <select name="PersonID" id="PersonID" <?php if ($Redigerbar == 0) { echo "disabled "; } ?>>
      <option value="0" <?php echo set_select('PersonID',0,($Sak['PersonID'] == 0) ? TRUE : FALSE); ?>>(ikke satt)</option>
<?php
  if (isset($Personer)) {
    foreach ($Personer as $Person) {
?>
      <option value="<?php echo $Person['PersonID']; ?>" <?php echo set_select('PersonID',$Person['PersonID'],($Sak['PersonID'] == $Person['PersonID']) ? TRUE : FALSE); ?>><?php echo $Person['Fornavn']." ".$Person['Etternavn']; ?></option>
<?php
    }
  }
?>
    </select>
  </p>

  <p>
    <label for="Saksbeskrivelse">Saksbeskrivelse:</label>
    <textarea name="Saksbeskrivelse" id="Saksbeskrivelse" <?php if ($Redigerbar == 0) { echo "disabled "; } ?>><?php echo set_value('Saksbeskrivelse',$Sak['Saksbeskrivelse']); ?></textarea>
  </p>

  <p>
    <label>Status:</label>
    <?php if (isset($Sak['Status'])) { echo $Sak['Status']; } else { echo "&nbsp;"; } ?>
  </p>

  <p class="handlinger">
    <label>&nbsp;</label>
<?php if ($Redigerbar == 1) { ?>
    <input type="submit" value="Lagre" <?php if (!in_array('801',$UABruker['UAP'])) { echo "disabled "; } ?>/>
<?php } ?>
<?php if ($Sak['SaksNummer'] == 0) { ?>
    <input type="button" value="Godkjenn" onclick="javascript:document.location.href='<?php echo site_url(); ?>/raadet/lagsaksnummer/?sid=<?php echo $Sak['SakID']; ?>';" <?php if (!in_array('803',$UABruker['UAP'])) { echo "disabled "; } ?>/>
<?php } ?>
  </p>
</fieldset>
<?php echo form_close(); ?>

<?php if ($Sak['SakID'] > 0) { ?>
<fieldset>
  <legend>Notater</legend>

  <table>
<?php
  if (isset($Notater)) {
    foreach ($Notater as $Notat) {
?>
    <tr>
      <td><?php echo date("d.m.Y",strtotime($Notat['DatoRegistrert'])); ?></td>
      <td><?php echo $Notat['PersonNavn']; ?></td>
      <td><?php echo nl2br($Notat['Notat']); ?></td>
    </tr>
<?php
    }
  }
?>
  </table>
</fieldset>

<?php echo form_open('raadet/nyttnotat'); ?>
<input type="hidden" name="SakID" value="<?php echo $Sak['SakID']; ?>" />
<fieldset>
  <legend>Nytt notat</legend>

  <p>
    <label for="Notatstype">Notatstype:</label>
    <select name="Notatstype" id="Notatstype">
      <option value="0">Kommentar</option>
<?php if ($Sak['StatusID'] == 0) { ?>
      <option value="1">Notat</option>
      <option value="2">Vedtak</option>
<?php } ?>
    </select>
  </p>

  <p>
    <label for="Notat">Notat:</label>
    <textarea name="Notat" id="Notat"></textarea>
  </p>

  <p class="handlinger">
    <label>&nbsp;</label>
    <input type="submit" value="Legg inn notat" />
  </p>
</fieldset>
<?php echo form_close(); ?>
<?php } ?>
