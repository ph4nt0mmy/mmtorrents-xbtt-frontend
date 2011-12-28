<div id="hiddenparam" style="display: none;"></div>
<div id="hiddensearch" style="display: none;">cc</div>
<table class="torrents" cellpadding="0" cellspacing="0">
<tr style="margin:0; padding:0;">
    <td class="head_category"><tag:category /></td>
    <td class="head_filename"><a href="javascript:void(0);" onclick="pager('order=filename&amp;sort=DESC');"><tag:filename /></a> | <a href="javascript:void(0);" onclick="pager('order=added&amp;sort=DESC');"><tag:filedate /></a> | <tag:multiplier /></td>
    <td class="head_staff"><tag:staff /></td>
	<td class="head_staff"><tag:language /></td>
    <td class="head_size"><a href="javascript:void(0);" onclick="pager('order=size&amp;sort=DESC');"><tag:size /></a></td>
    <td class="head_sl"><tag:sl /></td>
    <td class="head_seeders"><a href="javascript:void(0);" onclick="pager('order=seeders&amp;sort=DESC');"><tag:seeders /></a></td>
    <td class="head_leechers"><a href="javascript:void(0);" onclick="pager('order=leechers&amp;sort=DESC');"><tag:leechers /></a></td>
    <td class="head_completed"><a href="javascript:void(0);" onclick="pager('order=completed&amp;sort=DESC');"><tag:completed /></a></td>
</tr>
<loop:torrents>
<tr class="">
    <td class="category"><img src="<tag:path />/images/categories/<tag:torrents[].catimg />"></td>
    <td class="filename">
		<a href="javascript:void(0);" onclick="showtorrent('<tag:torrents[].fid />', 'showtorrent');"><tag:torrents[].filename /></a>
		<br />
		<tag:torrents[].added />
    </td>
    <td class="staff"><img src="<tag:path />/images/<tag:torrents[].staff_ok />.gif"></td>
	<td class="staff"><img src="<tag:path />/images/<tag:torrents[].language />.png"></td>
    <td class="size"><tag:torrents[].size /></td>
    <td class="sl"><img src="<tag:path />/images/status/<tag:torrents[].sl />"</td>
    <td class="seeders"><tag:torrents[].seeders /></td>
    <td class="leechers"><tag:torrents[].leechers /></td>
    <td class="completed"><tag:torrents[].completed /></td>
</tr>
<tr>
	<td colspan="8" class="torrentcontainer" id="torrent-<tag:torrents[].fid />"></td>
</tr>
</loop:torrents>
</table> 