<?php

// ******************* BLOCKS  **************** //
/* itt egy blokkot teszünk ki csak úgy, próbából */

$tpl->set('block_header', 'Hírek');
$content_in = 'Blokk tartalma: blabla';
$content_in .= '<br /><br /><center><img src=data/images/hirdetes.gif>&nbsp;<img src=data/images/hirdetes.gif></center>';
$tpl->set('block_content', $content_in);
$content=$content.$tpl->fetch($style_path. 'html/block.tpl');

/* blokk vége */
// ******************* BLOCKS END **************** //

?>