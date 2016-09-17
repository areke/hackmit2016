<?php
function echoPage($title, $content, $nav){
 //Change the code here if you want to change the design across the board :)

	// head, doctype, etc 
	// Include scripts here. 
	echo "<!DOCTYPE HTML>
<html>
<head>
<link href='bootstrap/css/bootstrap.css' type='text/css' rel='stylesheet'>
<script src='js/jquery.min.js'></script>
</head>
<body>";


	// navbar
	echo '
	<div class="navbar navbar-default">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="#">readez</a>
          <div class="nav-collapse collapse">
            <ul class="nav">';
	//Navigation time!
	$navTextArray = array("Home");
	$navLinkArray = array("index.php");
	for($i = 0; $i < count($navTextArray); $i++){
		if($nav == $i){
			//selected, active.
			echo  "<li class='active'><a href='$navLinkArray[$i]'>$navTextArray[$i]</a></li>";
		} else {
			//not selected/active
			echo "<li><a href='$navLinkArray[$i]'>$navTextArray[$i]</a></li>";
		}
	}
	echo '</ul>';
    echo '</div>
        </div>
      </div>
    </div>';
	//Time for the actual content.
	echo "<div class='container'>$content</div>";
	//End the body
	echo "</body></html>";
}
?>