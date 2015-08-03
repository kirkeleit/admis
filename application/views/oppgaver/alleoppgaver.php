<h3>Alle oppgaver</h3>

<table>
  <tr>
    <th>Dato</th>
    <th>Prioritet</th>
    <th>Frist</th>
    <th>Tittel</th>
    <th>Opprettet av</th>
    <th>Ansvarlig</th>
    <th>Status</th>
  </tr>
<?php
  if (isset($Oppgaver)) {
    foreach ($Oppgaver as $Oppgave) {
?>
  <tr>
    <td><a href="<?php echo site_url(); ?>/oppgaver/oppgave/<?php echo $Oppgave['OppgaveID']; ?>"><?php echo date("d.m.Y",strtotime($Oppgave['DatoRegistrert'])); ?></a></td>
    <td><a href="<?php echo site_url(); ?>/oppgaver/oppgave/<?php echo $Oppgave['OppgaveID']; ?>"><?php echo $Oppgave['Prioritet']; ?></a></td>
    <td><a href="<?php echo site_url(); ?>/oppgaver/oppgave/<?php echo $Oppgave['OppgaveID']; ?>"><?php echo ($Oppgave['DatoFrist'] !== "0000-00-00" ? date("d.m.Y",strtotime($Oppgave['DatoFrist'])) : "&nbsp;"); ?></a></td>
    <td><a href="<?php echo site_url(); ?>/oppgaver/oppgave/<?php echo $Oppgave['OppgaveID']; ?>"><?php echo $Oppgave['Tittel']; ?></a></td>
    <td><a href="<?php echo site_url(); ?>/oppgaver/oppgave/<?php echo $Oppgave['OppgaveID']; ?>"><?php echo $Oppgave['PersonOpprettetNavn']; ?></a></td>
    <td><a href="<?php echo site_url(); ?>/oppgaver/oppgave/<?php echo $Oppgave['OppgaveID']; ?>"><?php echo $Oppgave['PersonAnsvarligNavn']; ?></a></td>
    <td><a href="<?php echo site_url(); ?>/oppgaver/oppgave/<?php echo $Oppgave['OppgaveID']; ?>"><?php echo $Oppgave['Status']; ?></a></td>
  </tr>
<?php
    }
  }
?>
</table>
