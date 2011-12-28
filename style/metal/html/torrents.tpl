<!-- TORRENTEK KEZDETE -->
<script type="text/javascript" src="lang/<tag:lang />.lang.js"></script>
<script type="text/javascript" src="js/_ajax.new.js"></script>
<script type="text/javascript" src="js/torrents.js"></script>

<SCRIPT LANGUAGE = "JavaScript">
<!--
var msecs
var timerID = null
var timerRunning = false
var delay = 1

function InitializeTimer()
{
    // Set the length of the timer, in seconds
    msecs = 100
    StopTheClock()
    StartTheTimer()
}

function StopTheClock()
{
    if(timerRunning)
        clearTimeout(timerID)
    timerRunning = false
}

function StartTheTimer()
{
    if (msecs==0)
    {
        StopTheClock()
        // Here's where you put something useful that's
        // supposed to happen after the allotted time.
        // For example, you could display a message:
        //alert("You have just wasted 10 seconds of your life.")
        
        var currparam = window.document.getElementById('hiddenparam').innerHTML;
        var browserparam = window.location.hash.split('#');
		browserparam = browserparam[1];
		
		if ( currparam != browserparam ) {
			alert("current visible: " + currparam);
			alert("browser says: " + browserparam);
			pager(browserparam);
		}
		InitializeTimer();
    }
    else
    {
        self.status = msecs
        msecs = msecs - 1
        timerRunning = true
        timerID = self.setTimeout("StartTheTimer()", delay)
    }
}
//-->
</SCRIPT>

<div id="torrtable">
	<script>pager('');</script>
	<script>InitializeTimer();</script>
</div>
<!-- TORRENTEK VÉGE -->
