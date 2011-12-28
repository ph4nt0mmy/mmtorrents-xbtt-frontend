<?php
$tpl->set('block_header', LOGIN);
$content = $tpl->fetch($style_path. 'html/loginblock.tpl');
$content = $content. LOGIN_HINT;
$tpl->set('block_content', $content);
$content = $tpl->fetch($style_path. 'html/block.tpl');
?>
