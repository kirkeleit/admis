<h3 class="sub-header">Saksdetaljer</h3>

<?php echo form_open('/raadet/sak/'.$Sak['SakID']); ?>
<input type="hidden" name="SakID" value="<?php echo set_value('SakID',$Sak['SakID']); ?>" />
<div class="panel panel-default">
  <div class="panel-heading">&nbsp;</div>
  <div class="panel-body">

    <div class="form-group">
      <label>Saksnummer:</label>
      <p class="form-control-static"><?php echo $Sak['SaksAr']."/".$Sak['SaksNummer']; ?></p>
    </div>

    <div class="form-group">
      <label for="Tittel">Tittel:</label>
      <input type="text" class="form-control" name="Tittel" id="Tittel" value="<?php echo set_value('Tittel',$Sak['Tittel']); ?>" />
    </div>

    <div class="form-group">
      <label for="PersonID">Innmeldt av:</label>
      <select name="PersonID" class="form-control" id="PersonID">
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
    </div>

    <div class="form-group">
      <label for="Saksbeskrivelse">Saksbeskrivelse:</label>
      <textarea name="Saksbeskrivelse" class="form-control" id="Saksbeskrivelse"><?php echo set_value('Saksbeskrivelse',$Sak['Saksbeskrivelse']); ?></textarea>
    </div>

    <div class="form-group">
      <label>Status:</label>
      <p class="form-control-static"><?php if (isset($Sak['Status'])) { echo $Sak['Status']; } else { echo "&nbsp;"; } ?></p>
    </div>
  </div>

  <div class="panel-footer">
    <div class="input-group">
      <input type="submit" class="btn btn-primary" name="SakLagre" value="Lagre" <?php if (!in_array('801',$UABruker['UAP'])) { echo "disabled "; } ?>/>
<?php if ($Sak['SaksNummer'] == 0) { ?>
      <input type="button" class="btn btn-success" value="Godkjenn" onclick="javascript:document.location.href='<?php echo site_url(); ?>/raadet/lagsaksnummer/?sid=<?php echo $Sak['SakID']; ?>';" <?php if (!in_array('803',$UABruker['UAP'])) { echo "disabled "; } ?>/>
<?php } ?>
    </div>
  </div>
</div>
<?php echo form_close(); ?>

<?php if ($Sak['SakID'] > 0) { ?>
<div class="panel panel-default">
  <div class="panel-heading">Saksnotater</div>
  <div class="panel-body">

<?php
  if (isset($Notater)) {
    foreach ($Notater as $Notat) {
?>
    <div class="panel panel-default <?php echo ($Notat['Notatstype'] == 'Vedtak' ? 'panel-success' : 'panel-info'); ?>">
      <div class="panel-heading"><?php echo date('d.m.Y H:i',strtotime($Notat['DatoRegistrert'])).", av ".$Notat['PersonNavn']; ?></div>
      <div class="panel-body"><?php echo nl2br($Notat['Notat']); ?></div>
    </div>
<?php
    }
  }
?>
<?php echo form_open('raadet/nyttnotat'); ?>
<input type="hidden" name="SakID" value="<?php echo $Sak['SakID']; ?>" />
    <div class="panel panel-default">
      <div class="panel-heading">Nytt notat</div>
      <div class="panel-body">
        <div class="form-group">
          <select name="Notatstype" id="Notatstype" class="form-control">
            <option value="0">Kommentar</option>
<?php if ($Sak['StatusID'] == 0) { ?>
            <option value="1">Notat</option>
            <option value="2">Vedtak</option>
<?php } ?>
          </select>
        </div>
        <div class="form-group">
          <textarea name="Notat" id="Notat" class="form-control"></textarea>
        </div>
        <div class="form-group">
          <input type="submit" class="btn btn-primary btn-xs" value="Legg inn notat" />
        </div>
      </div>
    </div>
<?php echo form_close(); ?>
  </div>
</div>
<?php } ?>
