//TODO: remove NFO option! This should go to details.php
var msecs;
var timerID 		= null;
var timerRunning 	= false;
var delay 			= 1;

var handleshow = function(response) {
	
	var respArr 			= response.split('&sprt;');
    var respType 			= respArr[0].toLowerCase();
    var respFid 	 		= respArr[1];
    var respMsg  			= respArr[2];
    var respAct  			= respArr[3];
    
    var formatStr1			= '';
    var formatStr2 			= '';
    
    var showDescStr			= '| ' + JS_DESCRIPTION + ' ';
    if ( respAct != 'showtorrent' ) 
       { 
		var showDescStr			= '| <a href="javascript:void(0);" onclick="showtorrent(\'' + respFid + '\', \'showdesc\');">' + JS_DESCRIPTION + '</a> ';
       }
    var showNfoStr			= '| ' + JS_NFO + ' ';
    if ( respAct != 'shownfo' ) 
       { 
		var showNfoStr			= '| <a href="javascript:void(0);" onclick="showtorrent(\'' + respFid + '\', \'shownfo\');">' + JS_NFO + '</a> ';
       }
    if ( respAct == 'shownfo' )
       {
		//formatStr1			= '<pre style="font-size:10pt; font-family: \'Courier New\', monospace;">';
		//formatStr2				= '</pre>';
		//formatStr1 = '<img src="tmp/imgtest.php">';
	   }
	var showFilesStr			= '| ' + JS_FILES + ' ';
    if ( respAct != 'showfiles' ) 
       { 
		var showFilesStr			= '| <a href="javascript:void(0);" onclick="showtorrent(\'' + respFid + '\', \'showfiles\');">' + JS_FILES + '</a> ';
       }
    var showCommentsStr			= '| ' + JS_COMMENTS + ' ';
    if ( respAct != 'showcomments' ) 
       { 
		var showCommentsStr			= '| <a href="javascript:void(0);" onclick="showtorrent(\'' + respFid + '\', \'showcomments\');">' + JS_COMMENTS + '</a> ';
       }
    var showPeersStr			= '| ' + JS_CONNECTIONSANDSPEED + ' ';
    if ( respAct != 'showpeers' )
       { 
		var showPeersStr			= '| <a href="javascript:void(0);" onclick="showtorrent(\'' + respFid + '\', \'showpeers\');">' + JS_CONNECTIONSANDSPEED + '</a> ';
       }
    var showHistoryStr			= '| ' + JS_HISTORY + ' ';
    if ( respAct != 'showhistory' )
       { 
		var showHistoryStr			= '| <a href="javascript:void(0);" onclick="showtorrent(\'' + respFid + '\', \'showhistory\');">' + JS_HISTORY + '</a> ';
       }
    
    var str1				= '<table style="width: 100%"><tr><td style="border-bottom: 2px solid #000000;"><a href="gettorrent.php?fid=' + respFid + '">Letöltés</a> ' + showDescStr + showNfoStr + showFilesStr + showCommentsStr + showPeersStr + showHistoryStr + '| <a href="?mpage=details&fid=' + respFid + '">Részletek</a></td></tr><tr><td>';
    var str2				= '</td></tr></table>';
    
    //alert(str1);
    /*
	window.document.getElementById('rules').style.display="block";
	//window.document.getElementById('ruleslegend').style.display="block";
	*/
	if (respType == 'success') {
		//window.document.getElementById('rules').innerHTML=legendstr1 + respCategoryName + legendstr2 + respMsg;
		window.document.getElementById('torrent-'+respFid).style.display="table-cell";
		window.document.getElementById('torrent-'+respFid).innerHTML = str1  + respMsg + str2;
		//alert(respMsg);
	}
	//else window.document.getElementById('rules').innerHTML=legendstr1 + legendstr2 + JS_ERROR;
	
	return false;
}

function showtorrent(fid, action) {
	
	var ajax 		= new Ajax();
	
	switch(action)
		  {
		    case 'showtorrent' :
				//alert('showtorrent');
				if ( window.document.getElementById('torrent-'+fid).style.display == "table-cell" ) 
				   {
					   window.document.getElementById('torrent-'+fid).style.display = "none";
					   return false;
				   }
				else if ( window.document.getElementById('torrent-'+fid).innerHTML != '' ) 
				        {
							//var container = window.document.getElementById('torrent-'+fid).innerHTML;
							window.document.getElementById('torrent-'+fid).style.display="table-cell";
							//alert(container);
							return false;
						}
		    break;
		    case 'shownfo' :
				//alert('shownfo');
			break;
			case 'showdesc' :
				action = 'showtorrent';
			break;
		  }
	
	var strtopost = 'torrents.ajax.php?action=' + action + '&fid=' + fid; // + '&language=' + language;
	//alert(strtopost);
	ajax.doGet(strtopost, handleshow,'text');
	return false;
}

var handlepager = function(response) {
	
	var respArr 			= response.split('&sprt;');
    var respType 			= respArr[0].toLowerCase();
    var respMsg 	 		= respArr[1];
    var respParam 	 		= respArr[2];
    var respPage 	 		= respArr[3];
    
    //alert(respParam);
    if (respType == 'success') {
		window.document.getElementById('torrtable').innerHTML = respMsg;

		respParam = respParam; // + 'page=' + respPage;
		window.document.getElementById('hiddenparam').innerHTML = respParam;
		window.location.hash = respParam;
		//alert('response param: ' + respParam);
	}
	else {
		alert('error' + respArr[0]);
	}
	
	return false;
}

function pager(param) {
	
	var ajax 		= new Ajax();
	var page		= '';
	
	//alert(param);
	if ( param == '' && ( window.location.hash == undefined || window.location.hash == '' ) ) 
	   { 
		 param = 'page=0';
		 //alert('page=0');
       } 
    else if ( param == '' && ( window.location.hash != undefined || window.location.hash != '' ) ) {
		 param = window.location.hash.split('#');
		 //alert('param=' + param);
		 param = param[1];
		 //alert('page!=0');
	}
	//if ( param.indexOf('page')==-1 ) page = 'page=0&';
	var strtopost = 'torrents.ajax.php?action=pager&' + param;
	//alert(strtopost);
	//alert('param to post: ' + param);
	//window.location.hash = param;
	ajax.doGet(strtopost, handlepager,'text');
	return false;
}

function InitializeTimer()
{
    // Set the length of the timer, in milliseconds
    msecs = 100;
    StopTheClock();
    StartTheTimer();
}

function StopTheClock()
{
    if(timerRunning)
        clearTimeout(timerID);
    timerRunning = false;
}

function StartTheTimer()
{
    if (msecs==0)
    {
        StopTheClock();
        
        var currparam = window.document.getElementById('hiddenparam').innerHTML;
        var currparamArray = currparam.split('&amp;');
        /* the innerHTML gives html entity encoded text and we need to replace &amp; signs to & */
        currparam = '';
        var i=0;
        for (i=0;i<currparamArray.length;i++)
			{
			 if (i>0) currparam = currparam + '&' + currparamArray[i];
			 else currparam = currparamArray[i];
			}
		//alert('currparam (from hidden url): ' + currparam);
		//return false;
        var browserparam = window.location.hash.split('#');
		browserparam = browserparam[1];
		
		if ( currparam != browserparam ) {
			//alert("current visible (hidden url): " + currparam);
			//alert("browser url " + browserparam);
			pager(browserparam);
		}
		InitializeTimer();
    }
    else
    {
        self.status = msecs;
        msecs = msecs - 1;
        timerRunning = true;
        timerID = self.setTimeout("StartTheTimer()", delay);
    }
}

var handlesearch = function(response) {
	
	var respArr 			= response.split('&sprt;');
    var respType 			= respArr[0].toLowerCase();
    var respMsg 	 		= respArr[1];

    //alert(respParam);
    
    
    if (respType == 'success') {
		//window.document.getElementById('torrtable').innerHTML = respMsg;

		//respParam = respParam; // + 'page=' + respPage;
		//window.document.getElementById('hiddenparam').innerHTML = respParam;
		//window.location.hash = respParam;
		var hiddensearch =  window.document.getElementById('hiddensearch').innerHTML;
		if ( hiddensearch != respMsg ) {
			window.document.getElementById('hiddensearch').innerHTML = respMsg;
			window.document.getElementById('suggestion').innerHTML = respMsg;
			/* IDE JÖN A LÉNYEGI RÉSZ! */
			//alert('Találatok: ' + respMsg);
		}
		//alert(hiddensearch);
	}
	else {
		alert('error' + respArr[0]);
	}

	return false;
}

function search()
{
	/* 
	  Search funtion
	  1) display suggestion if typed text is longer than 4 characters
	  2) if submit button has been pressed this should call pager function with search = entered text
	*/
	var ajax = new Ajax();
	var text = window.document.getElementById('searchtext').value;
	
	if ( text.length > 4 ) 
		{
		  window.document.getElementById('suggestion').style.display = "block";
		  //alert("More than 4 chars.. " + text);
		  var strtopost = 'torrents.ajax.php?action=searchtorrent&text=' + text;
		  ajax.doGet(strtopost, handlesearch,'text');
		}
	//alert("Search function..");
	
}