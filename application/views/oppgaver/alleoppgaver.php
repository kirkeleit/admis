<h3 class="sub-header">Alle oppgaver <a href="<?php echo site_url('/oppgaver/nyoppgave'); ?>" class="btn btn-default" role="button"><span class="glyphicon glyphicon-plus"></span></a></h3>

<div class="table-responsive">
  <table class="table table-striped table-hover table-condensed">
    <thead>
      <tr>
        <th>Dato</th>
        <th>Prioritet</th>
        <th>Frist</th>
        <th>Tittel</th>
        <th>Opprettet av</th>
        <th>Ansvarlig</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
<?php
  if (isset($Oppgaver)) {
    foreach ($Oppgaver as $Oppgave) {
?>
      <tr>
        <td><?php echo anchor('/oppgaver/oppgave/'.$Oppgave['OppgaveID'],date("d.m.Y",strtotime($Oppgave['DatoRegistrert']))); ?></td>
        <td><?php echo anchor('/oppgaver/oppgave/'.$Oppgave['OppgaveID'],$Oppgave['Prioritet']); ?></td>
        <td><?php echo anchor('/oppgaver/oppgave/'.$Oppgave['OppgaveID'],($Oppgave['DatoFrist'] !== "0000-00-00" ? date("d.m.Y",strtotime($Oppgave['DatoFrist'])) : "&nbsp;")); ?></td>
        <td><?php echo anchor('/oppgaver/oppgave/'.$Oppgave['OppgaveID'],$Oppgave['Tittel']); ?></td>
        <td><?php echo anchor('/oppgaver/oppgave/'.$Oppgave['OppgaveID'],$Oppgave['PersonOpprettetNavn']); ?></td>
        <td><?php echo anchor('/oppgaver/oppgave/'.$Oppgave['OppgaveID'],$Oppgave['PersonAnsvarligNavn']); ?></td>
        <td><?php echo anchor('/oppgaver/oppgave/'.$Oppgave['OppgaveID'],$Oppgave['Status']); ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td colspan="7">Ingen oppgaver i utvalg.</td>
      </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>
