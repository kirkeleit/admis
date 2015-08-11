<table id="Medlemmer">
  <tr>
    <th>Navn</th>
  </tr>
</table>
<script language="JavaScript">
  function HentMedlemmer() {
    $.getJSON("<?php echo site_url(); ?>/kontakter/hentmedlemmer/"+new Date().getTime(), function(data) {
      if (data != null) {
        $.each(data, function (i, Medlem) {
          var content = "<tr>";
          content += "  <td><a href=\"<?php echo site_url(); ?>/kontakter/person/"+Medlem.ID+"\">"+Medlem.Fornavn+" "+Medlem.Etternavn+"</a></td>";
          content += "</tr>";
          $('#Medlemmer').append(content);
        });
      }
    });
  }

  HentMedlemmer();
</script>
