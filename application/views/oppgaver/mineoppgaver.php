<h3 class="sub-header">Mine oppgaver <?php echo anchor('/oppgaver/nyoppgave','<span class="glyphicon glyphicon-plus"></span>'); ?></h3>
<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>Dato</th>
        <th>Prioritet</th>
        <th>Frist</th>
        <th>Tittel</th>
        <th>Opprettet av</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Oppgaver)) {
    foreach ($Oppgaver as $Oppgave) {
?>
      <tr>
        <td><a href="<?php echo site_url(); ?>/oppgaver/oppgave/<?php echo $Oppgave['OppgaveID']; ?>"><?php echo date("d.m.Y",strtotime($Oppgave['DatoRegistrert'])); ?></a></td>
        <td><a href="<?php echo site_url(); ?>/oppgaver/oppgave/<?php echo $Oppgave['OppgaveID']; ?>"><?php echo $Oppgave['Prioritet']; ?></a></td>
        <td><a href="<?php echo site_url(); ?>/oppgaver/oppgave/<?php echo $Oppgave['OppgaveID']; ?>"><?php if ($Oppgave['DatoFrist'] !== "0000-00-00") { echo date("d.m.Y",strtotime($Oppgave['DatoFrist'])); } else { echo "&nbsp;"; } ?></a></td>
        <td><a href="<?php echo site_url(); ?>/oppgaver/oppgave/<?php echo $Oppgave['OppgaveID']; ?>"><?php echo $Oppgave['Tittel']; ?></a></td>
        <td><a href="<?php echo site_url(); ?>/oppgaver/oppgave/<?php echo $Oppgave['OppgaveID']; ?>"><?php echo $Oppgave['PersonOpprettetNavn']; ?></a></td>
        <td><a href="<?php echo site_url(); ?>/oppgaver/oppgave/<?php echo $Oppgave['OppgaveID']; ?>"><?php echo $Oppgave['Status']; ?></a></td>
     </tr>
<?php
    }
  }
?>
    </tbody>
  </table>
</div>

<br /><br />

<h4 class="sub-header">Oppgaver som ikke er tildelt</h4>
<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>Dato</th>
        <th>Prioritet</th>
        <th>Frist</th>
        <th>Tittel</th>
        <th>Opprettet av</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($OppgaverUtenAnsvarlige)) {
    foreach ($OppgaverUtenAnsvarlige as $Oppgave) {
?>
      <tr>
        <td><?php echo date("d.m.Y",strtotime($Oppgave['DatoRegistrert'])); ?></td>
        <td><?php echo $Oppgave['Prioritet']; ?></td>
        <td><?php if ($Oppgave['DatoFrist'] !== "0000-00-00") { echo date("d.m.Y",strtotime($Oppgave['DatoFrist'])); } else { echo "&nbsp;"; } ?></td>
        <td><a href="<?php echo site_url(); ?>/oppgaver/oppgave/<?php echo $Oppgave['OppgaveID']; ?>"><?php echo $Oppgave['Tittel']; ?></a></td>
        <td><?php echo $Oppgave['PersonOpprettetNavn']; ?></td>
        <td><?php echo $Oppgave['Status']; ?></td>
      </tr>
<?php
    }
  }
?>
    </tbody>
  </table>
</div>
