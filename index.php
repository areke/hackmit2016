<?php 
    require('includes/functions.php');


    $myClientId = 'M3UKBBHJW5';
    $mySecret = 'EUXn3aTj4vPbWcyDRphX3u';
    $myUrl = 'http://localhost:8888/hackmit2016/';

    // URLs
    $authorizeUrl = "https://quizlet.com/authorize?client_id={$myClientId}&response_type=code&scope=read%20write_set";
    $tokenUrl = 'https://api.quizlet.com/oauth/token';
    $content = '
        <div id = "container">
        <h1 id = "sentenceText" style = "font-family: courier; font-size: 50px"></h1>
        <!-- <input type = "button" id = "previous" value = "previous"></input>
        <input type = "button" id = "next" value = "next"></input> -->
        </div>';



    echoPage('Vocabulary', $content, 1, $authorizeUrl);

?>