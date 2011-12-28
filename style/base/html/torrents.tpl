<script type="text/javascript" src="lang/<tag:lang />.lang.js"></script>
<script type="text/javascript" src="js/_ajax.new.js"></script>
<script type="text/javascript" src="js/torrents.js"></script>
<div style="margin: 0 auto; width: auto;">
	<input id="searchtext" type="text" style="width:194px; margin: 0; padding: 0; border: none;" onKeyUp="search('');" />
	<br />
	<div id="suggestion" style="width:194px; margin: 0; padding: 0px 0px 0px 0px; background-color: #ffffff; text-align: left;">&nbsp;</div>
	<br />
	<input type="submit" value="JS_SUBMIT" onClick="search('');" />
</div>
<div id="torrtable">
	<script>pager('');</script>
	<script>InitializeTimer();</script>
</div>