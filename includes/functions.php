<?php
function echoPage($title, $content, $nav, $url){
 //Change the code here if you want to change the design across the board :)

	// head, doctype, etc 
	// Include scripts here. 
	echo "<!DOCTYPE HTML>
<html>
<head>
<link href='bootstrap/css/bootstrap.css' type='text/css' rel='stylesheet'>
<link href='css/index.css' type='text/css' rel='stylesheet'>
<script src='js/jquery.min.js'></script>
<script src='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
<script src='js/index.js'></script>
</head>
<body>";


	// navbar
	echo '<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">readez</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="library.php">Library</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Font <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#" class = "changeFont" style="font-family:garamound;">Garamound</a></li>
            <li><a href="#" class = "changeFont" style="font-family:Times New Roman;">Times New Roman</a></li>
            <li><a href="#" class = "changeFont" style="font-family:helvetica;">Helvetica</a></li>
            <li><a href="#" class = "changeFont" style="font-family:georgia;">Georgia</a></li>
            <li><a href="#" class = "changeFont" style="font-family:courier;">Courier</a></li>
            <li><a href="#" class = "changeFont" style="font-family:verdana;">Verdana</a></li>
            <li><a href="#" class = "changeFont" style="font-family:arial;">Arial</a></li>
            <li><a href="#" class = "changeFont" style="font-family:open dyslexic;">Open Dyslexic</a></li>
          </ul>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Size<span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="#" class = "changeSize" data-value = "30px" style="font-size:100%">Small</a></li>
                <li><a href="#" class = "changeSize" data-value = "50px" style="font-size:150%">Medium</a></li>
                <li><a href="#" class = "changeSize" data-value = "70px" style="font-size:200%">Large</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Color<span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="#" class = "changeColor" style="color:black;">Black</a></li>
                <li><a href="#" class = "changeColor" style="color:blue;">Blue</a></li>
                <li><a href="#" class = "changeColor" style="color:red;">Red</a></li>
                <li><a href="#" class = "changeColor" style="color:green;">Green</a></li>
                <li><a href="#" class = "changeColor" style="color:Orange;">Orange</a></li>
                <li><a href="#" class = "changeColor" style="color:Yellow;">Yellow</a></li>
            </ul>
        </li>
      </ul>';
      if (empty($_GET['code']) && empty($_GET['error'])) {
      echo '
      <ul class="nav navbar-nav navbar-right">
        <li style="position:relative;top:10px;">
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal">
            <a href="#"><span class="glyphicon glyphicon-user"></span> Login</a>
          </button>

          <!-- Modal -->
          <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <center><h2 class="modal-title" id="myModalLabel" style="font-family:arial;">readez</h2></center><br>
                </div>
                <div class="modal-body">
                  Sign in with Quizlet to create a library and begin using readez! <br><br>
                  <button type="button" class="btn btn-primary btn-lg">
                    <div style="text-align:center;">';
                    $_SESSION['state'] = md5(mt_rand().microtime(true));
                    echo '
                      <a href="'.$url.'&state='.urlencode($_SESSION['state']).'&redirect_uri='.urlencode('http://localhost:8888/hackmit2016/').'" style="color:white;"><img src="https://edshelf.com/wp-content/uploads/2012/12/400-Square-Quizlet.png" style="width:30px;height:30px;">
                      Login with Quizlet
                      </a>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
      </li>
      </ul>
      ';
  }
      echo '
    </div>
  </div>
</nav>';
	//Time for the actual content.
	echo "<div class='container'>$content</div>";
	//End the body
	echo "</body></html>";

    $myClientId = 'M3UKBBHJW5';
    $mySecret = 'EUXn3aTj4vPbWcyDRphX3u';
    $myUrl = 'http://localhost:8888/hackmit2016/';

    // URLs
    $authorizeUrl = "https://quizlet.com/authorize?client_id={$myClientId}&response_type=code&scope=read%20write_set";
    $tokenUrl = 'https://api.quizlet.com/oauth/token';

session_start();

    // Helper function for errors
    function displayError($error, $step) {
        echo '<h2>An error occurred in step '.$step.'</h2><p>Error: '.htmlspecialchars($error['error']).
            '<br />Description: '.(isset($error['error_description']) ? htmlspecialchars($error['error_description']) : 'n/a').'</p>';
    }

    // Step 1: Display dialog box on quizlet to ask the user to authorize my application
    // =================================================================================

    // Check for issues from step 1:
    if (!empty($_GET['error'])) { // An error occurred authorizing
        displayError($_GET, 1);
        exit();
    }


    // Step 2: Get the authorization token (via POST)
    // ==============================================
    if (!isset($_SESSION['access_token'])) {
        $payload = [
            'code' => $_GET['code'],
            'redirect_uri' => $myUrl,
            'grant_type' => 'authorization_code',
        ];
        $curl = curl_init($tokenUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERPWD, "{$myClientId}:{$mySecret}");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
        $token = json_decode(curl_exec($curl), true);
        $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($responseCode !== 200) { // An error occurred getting the token
            displayError($token, 2);
            exit();
        }

        $accessToken = $token['access_token'];
        $username = $token['user_id']; // the API sends back the username of the user in the access token

        // Store the token for later use (outside of this example, you might use a real database)
        // You must treat the "access token" like a password and store it securely
        $_SESSION['access_token'] = $accessToken;
        $_SESSION['username'] = $username;

    }

    // Step 3: Use the Quizlet API with the received token
    // ===================================================
    $curl = curl_init("https://api.quizlet.com/2.0/users/{$_SESSION['username']}/sets");
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Bearer '.$_SESSION['access_token']]);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $data = json_decode(curl_exec($curl));
    $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    $curl = curl_init("https://api.quizlet.com/2.0/users/{$_SESSION['username']}/sets");
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Bearer '.$_SESSION['access_token'], 'Content-type: application/json']);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, 5);

    $data = array(
    "title"    => "HackMIT Vocabulary",
    "terms" => ['ok', 'ok2'],
    "definitions" => ['ok2', 'ok']

);
    $json = json_encode($data);

    $data = json_decode(curl_exec($curl));
    echo($data);
    var_dump($data);
    $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    // Display the user's sets
    echo "<p>Found ".count($data)." sets</p>";
    echo "<ol>";
    foreach ($data as $set) {
        echo "<li>".htmlspecialchars($set->title)."</li>"; // Notice that we ensure HTML is displayed safely
    }
    echo "</ol>";


}
?>