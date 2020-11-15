<?php
// secret key can be a random string 
define('SECRET_KEY','Super-Secret-Key'); 
// Algorithm used to sign the token
define('ALGORITHM','HS256');   
// time of token issued at + (1 day converted into seconds)
$iat = time() + (1 * 24 * 60 * 60);
//not before in seconds
$nbf = $iat + 100; 
// expire time of token in seconds (1 min * 60)
$tokenExp = $iat + 60 * 60; 
$token = array(
   "iss" => "http://example.org",
   "aud" => "http://example.com",
   "exp" => $tokenExp,
   "data" => array() 
);
?>
