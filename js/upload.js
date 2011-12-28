var handlecategory = function(response) {
	
	var respArr 			= response.split('&sprt;');
    var respType 			= respArr[0].toLowerCase();
    var respCategory  		= respArr[1];
    var respCategoryName  	= respArr[2];
    var respMsg  			= respArr[3];
    var legendstr1			= '<legend><tag:upload_rules />: ';
    var legendstr2			= '</legend>';
    
    //alert('iéz');

	window.document.getElementById('rules').style.display="block";
	//window.document.getElementById('ruleslegend').style.display="block";

	if (respType == 'success') {
		window.document.getElementById('rules').innerHTML=legendstr1 + respCategoryName + legendstr2 + respMsg;
	}
	else window.document.getElementById('rules').innerHTML=legendstr1 + legendstr2 + JS_ERROR;
	
	return false;
}

function showcategory(categoryid) {
	
	var strDomain	= '';
	var ajax 		= new Ajax();
	
	var strtopost = strDomain +  'upload.ajax.php?action=uploadrules&categoryid=' + categoryid; // + '&language=' + language;
	//alert(strtopost);
	ajax.doGet(strtopost, handlecategory,'text');
	return false;
}

function checkupload(form) {
	
	
	return true;
}