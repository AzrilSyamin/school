<?php
// rename this file to config.php
// insert detail database connection
$host = "localhost";
$user = "";
$pass = "";
$db_name = "";

//function base_url
function myUrl($url = null)
{
  // $base_url = 'http://localhost.test';
  $base_url = '';
  if ($url != null) {
    return $base_url . "/" . $url;
  } else {
    return $base_url;
  }
}
//end function base_url
