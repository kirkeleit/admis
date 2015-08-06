<h3>Oversikt </h3>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <div id="chart_div" style="height:500px;"></div>

<script>
  google.load('visualization', '1', {packages: ['bar']});
  google.setOnLoadCallback(drawAxisTickColors);

  function drawAxisTickColors() {
    var data = google.visualization.arrayToDataTable([
      ['Måned', 'Inntekter', 'Utgifter','Utlegg','Reiseutgifter'],
<?php
  $Maneder = array(1=>'Januar',2=>'Februar',3=>'Mars',4=>'April',5=>'Mai',6=>'Juni',7=>'Juli',8=>'August',9=>'September',10=>'Oktober',11=>'November',12=>'Desember');
  foreach ($Oversikt as $Maned => $Data) {
?>
      ['<?php echo $Maneder[$Maned]; ?>',<?php echo $Data['Inntekter'].','.$Data['Utgifter'].','.$Data['Utlegg'].','.$Data['Reiseutgifter']; ?>],
<?php
  }
?>
    ]);

    var options = {
      title: 'Økonomioversikt',
      chartArea: {width: '50%'},
      hAxis: {
        title: 'Sum',
        minValue: 0,
        textStyle: {
          bold: true,
          fontSize: 12,
          color: '#4d4d4d'
        },
        titleTextStyle: {
          bold: true,
          fontSize: 18,
          color: '#4d4d4d'
        }
      },
      vAxis: {
        title: 'Pr måned',
        textStyle: {
          fontSize: 14,
          bold: true,
          color: '#848484'
        },
        titleTextStyle: {
          fontSize: 14,
          bold: true,
          color: '#848484'
        }
      },
      legend: { position: 'none' }
    };
    var chart = new google.charts.Bar(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
</script>
