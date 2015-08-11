<?php

  $AMeny = array(array('Navn' => 'Personer', 'URL' => 'personer', 'UAP' => 200, 'NyLink' => 'nyperson'),
                 array('Navn' => 'Organisasjoner', 'URL' => 'organisasjoner', 'UAP' => 200, 'NyLink' => 'nyorganisasjon'),
                 array('Navn' => 'Medlemmer', 'URL' => 'medlemmer', 'UAP' => 200),
                 array('Navn' => 'Medlemsgrupper', 'URL' => 'medlemsgrupper', 'UAP' => 200));
  $AModul = array('Navn' => 'Kontakter', 'URL' => 'kontakter', 'UAP' => 200, 'Meny' => $AMeny);
  $AModuler[] = $AModul;

  $AMeny = array(array('Navn' => 'Faggrupper', 'URL' => 'faggrupper', 'UAP' => 800),
                 array('Navn' => 'Kompetanseliste', 'URL' => 'kompetanseliste', 'UAP' => 800));
  $AModul = array('Navn' => 'Kompetanse', 'URL' => 'kompetanse', 'UAP' => 800, 'Meny' => $AMeny);
  $AModuler[] = $AModul;

  $AMeny = array(array('Navn' => 'Mine oppgaver', 'URL' => 'mineoppgaver', 'UAP' => 600),
                 array('Navn' => 'Alle oppgaver', 'URL' => 'alleoppgaver', 'UAP' => 600));
  $AModul = array('Navn' => 'Oppgaver', 'URL' => 'oppgaver', 'UAP' => 600, 'Meny' => $AMeny);
  $AModuler[] = $AModul;

  $AMeny = array(array('Navn' => 'Oversikt', 'URL' => 'oversikt', 'UAP' => 300),
                 array('Navn' => 'Fakturaer', 'URL' => 'fakturaer', 'UAP' => 300),
                 array('Navn' => 'Innkjøpsordrer', 'URL' => 'innkjopsordrer', 'UAP' => 300, 'NyLink' => 'nyinnkjopsordre'),
                 array('Navn' => 'Trenger støtte', 'URL' => 'trengerstotte', 'UAP' => 300),
                 array('Navn' => 'Varemottak', 'URL' => 'varemottak', 'UAP' => 300),
                 array('Navn' => 'Utgifter', 'URL' => 'utgifter', 'UAP' => 300, 'NyLink' => 'nyutgift'),
                 array('Navn' => 'Inntekter', 'URL' => 'inntekter', 'UAP' => 300, 'NyLink' => 'nyinntekt'),
                 array('Navn' => 'Utlegg', 'URL' => 'utleggskvitteringer', 'UAP' => 301, 'NyLink' => 'nyutleggskvittering'),
                 array('Navn' => 'Til fakturering', 'URL' => 'tilfakturering', 'UAP' => 311),
                 array('Navn' => 'Til utbetaling', 'URL' => 'tilutbetaling', 'UAP' => 308));
  $AModul = array('Navn' => 'Penger', 'URL' => 'okonomi', 'UAP' => 300, 'Meny' => $AMeny);
  $AModuler[] = $AModul;

  $AMeny = array(array('Navn' => 'Utstyrsliste', 'URL' => 'utstyrsliste', 'UAP' => 400, 'NyLink' => 'nyttutstyr'),
                 array('Navn' => 'Grupper', 'URL' => 'grupper', 'UAP' => 400, 'NyLink' => 'nygruppe'),
                 array('Navn' => 'Produsenter', 'URL' => 'produsenter', 'UAP' => 400, 'NyLink' => 'nyprodusent'),
                 array('Navn' => 'Lagerplasser', 'URL' => 'lagerplasser', 'UAP' => 400),
                 array('Navn' => 'Utstyrstyper', 'URL' => 'utstyrstyper', 'UAP' => 400, 'NyLink' => 'nyutstyrstype'),
                 array('Navn' => 'Vedlikehold', 'URL' => 'utstyrsvedlikehold', 'UAP' => 400),
                 array('Navn' => 'TS rapporter', 'URL' => 'tsrapporter', 'UAP' => 400, 'NyLink' => 'nytsrapport'));
  $AModul = array('Navn' => 'Materiell', 'URL' => 'materiell', 'UAP' => 400, 'Meny' => $AMeny);
  $AModuler[] = $AModul;

  $AMeny = array(array('Navn' => 'Prosjekter', 'URL' => 'prosjektliste', 'UAP' => 800, 'NyLink' => 'nyttprosjekt'),
                 array('Navn' => 'Tidslinje', 'URL' => 'tidslinje', 'UAP' => 800),
                 array('Navn' => 'Prosjektarkiv', 'URL' => 'prosjektarkiv', 'UAP' => 800));
  $AModul = array('Navn' => 'Prosjekter', 'URL' => 'prosjekter', 'UAP' => 500, 'Meny' => $AMeny);
  $AModuler[] = $AModul;

  $AMeny = array(array('Navn' => 'Saker', 'URL' => 'saksliste', 'UAP' => 800, 'NyLink' => 'nysak'),
                 array('Navn' => 'Saksarkiv', 'URL' => 'saksarkiv', 'UAP' => 800),
                 array('Navn' => 'Møter', 'URL' => 'moter', 'UAP' => 800),
                 array('Navn' => 'Budsjett', 'URL' => 'budsjett', 'UAP' => 800),
                 array('Navn' => 'Resultat', 'URL' => 'resultat', 'UAP' => 800));
  $AModul = array('Navn' => 'Rådet', 'URL' => 'raadet', 'UAP' => 800, 'Meny' => $AMeny);
  $AModuler[] = $AModul;
?>
