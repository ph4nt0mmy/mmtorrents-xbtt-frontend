<!-- TORRENTEK KEZDETE -->
<div id="hiddenparam" style="display: block;"></div>
<table class="torrents" cellpadding="0" cellspacing="0">
<tr style="margin:0; padding:0;">
    <td class="head_category"><tag:category /></td>
    <td class="head_filename"><a href="javascript:void(0);" onclick="pager('order=filename&sort=DESC');"><tag:filename /></a> | <tag:filedate /> | <tag:multiplier /></td>
    <td class="head_staff"><tag:staff /></td>
    <td class="head_size"><tag:size /></td>
    <td class="head_sl"><tag:sl /></td>
    <td class="head_seeders"><tag:seeders /></td>
    <td class="head_leechers"><tag:leechers /></td>
    <td class="head_completed"><tag:completed /></td>
</tr>
<loop:torrents>
<tr>
    <td class="category"><img src="<tag:path />/images/categories/<tag:torrents[].catimg />"></td>
    <td class="filename">
		<a href="javascript:void(0);" onclick="showtorrent('<tag:torrents[].fid />', 'showtorrent');"><tag:torrents[].filename /></a>
		<br />
		<tag:torrents[].added />
    </td>
    <td class="staff"><img src="<tag:path />/images/<tag:torrents[].staff_ok />.gif"></td>
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
<!-- TORRENTEK VÉGE -->