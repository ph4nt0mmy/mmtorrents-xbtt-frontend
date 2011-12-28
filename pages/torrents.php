<?php
// ******************* TORRENTS **************** //

$content = $tpl->fetch($style_path. 'html/torrents.tpl');
$tpl->set('block_content', $content);
$content = $tpl->fetch($style_path. 'html/block.tpl');
// ******************* TORRENTS END **************** //
?>