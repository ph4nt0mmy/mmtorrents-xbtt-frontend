<!-- LOGIN KEZDETE -->
<script type="text/javascript" src="lang/<tag:lang />.lang.js"></script>
<script type="text/javascript" src="js/_applogin.js"></script>
<script type="text/javascript" src="js/_ajax.new.js"></script>
<script type="text/javascript" src="js/_formdata2querystring.js"></script>
<div id="not_logged_in">
<ul>
    <li class="left">
     <form id="loginForm" method="POST" action="index.php">
     <p>
        <tag:name />:&nbsp;<input id="loginname" name="loginname" type="text" value="">&nbsp;
        <tag:passwd />:&nbsp;<input id="password" name="password" type="password" value="">
	<input type="submit" id="submitButton" name="submitButton" value="<tag:login />">
     </p>
     </FORM>
    </li>
    <li class="right">
     <p><a class="not_logged_in" href="?mpage=reg"><tag:registration /></a>&nbsp;|&nbsp;<a class="not_logged_in" href="?mpage=lostpwd"><tag:lostpasswd /></a>&nbsp;&nbsp;
     <a href=./?lang=hu><img src="<tag:style_path />images/hu.png"></a>&nbsp;&nbsp;<a href=./?lang=en><img src="<tag:style_path />images/gb.png"></a>
     <!--<select name="lang">
      <option class="lang_hu">HU</option>
      <option class="lang_en">EN</option>
     </select>-->
     </p>
    </li>
 
</ul>
</div>
<div id="users_mnu_end">
 <ul>
  <li>
   
  </li>
 </ul>
</div>
<!-- LOGIN VÉGE -->