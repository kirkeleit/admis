<h3>Tidslinje</h3>

<div id="timeline" style="height: 500px;"></div>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["timeline"]});
      google.setOnLoadCallback(drawChart);

      function drawChart() {
        var container = document.getElementById('timeline');
        var chart = new google.visualization.Timeline(container);
        var dataTable = new google.visualization.DataTable();

        dataTable.addColumn({ type: 'string', id: 'Prosjekt' });
        dataTable.addColumn({ type: 'date', id: 'Start' });
        dataTable.addColumn({ type: 'date', id: 'End' });
        dataTable.addRows([
<?php
  foreach ($Prosjekter as $Prosjekt) {
    if (($Prosjekt['DatoProsjektstart'] != '0000-00-00') and ($Prosjekt['DatoProsjektslutt'] != '0000-00-00') and (($Prosjekt['StatusID'] >= 1) and ($Prosjekt['StatusID'] <= 4))) {
?>
          [ '<?php echo $Prosjekt['Prosjektnavn']; ?>' , new Date(<?php echo date('Y',strtotime($Prosjekt['DatoProsjektstart'])).",".date('n',strtotime($Prosjekt['DatoProsjektstart'])).",".date('j',strtotime($Prosjekt['DatoProsjektstart'])); ?>), new Date(<?php echo date('Y',strtotime($Prosjekt['DatoProsjektslutt'])).",".date('n',strtotime($Prosjekt['DatoProsjektslutt'])).",".date('j',strtotime($Prosjekt['DatoProsjektslutt'])); ?>) ],
<?php
    }
  }
?>
          ]);
        chart.draw(dataTable);
      }
    </script>
