<?php

require __DIR__.'/../_ensure_https.php';

//Stop Direct Access to the File
//Works only in PHP 5.0 and Up
if (get_included_files()[0] == __FILE__) {exit("<h1>Access Denied</h1>");}

//Stop Including This File Twice
if (defined(strtoupper(basename(__FILE__,".php"))."_PHP")) {return True;}
define(strtoupper(basename(__FILE__,".php"))."_PHP", True);

//JSON input
//if ($_SERVER["REQUEST_METHOD"] == "POST" and $_SERVER["CONTENT_TYPE"] == "application/json") {
//    $json = file_get_contents("php://input");
//    $_POST = json_decode($json, True);
//}
// JSON input
// JSON input

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SERVER["CONTENT_TYPE"]) && strpos($_SERVER["CONTENT_TYPE"], "application/json") !== false) {
    $json = file_get_contents("php://input");
    $_POST = json_decode($json, true);

    // If you want to handle JSON data in the same way as form data
    foreach ($_POST as $key => $value) {
        if (gettype($_POST[$key]) == "string") {
            $_POST[$key] = htmlspecialchars($value);
        }
    }
} else {
    // If it's not JSON, you can keep your existing code for handling form data
    foreach ($_POST as $key => $value) {
        if (gettype($_POST[$key]) == "string") {
            $_POST[$key] = htmlspecialchars($value);
        }
    }
    foreach ($_GET as $key => $value) {
        if (gettype($_GET[$key]) == "string") {
            $_GET[$key] = htmlspecialchars($value);
        }
    }
}
//Output JSON Error
function jsonError($err, $data = NULL)
{
  if ($data) {
    echo json_encode(["Error" => $err, "Data" => $data]);
    exit();
  }
  echo json_encode(["Error" => $err]);
  exit();
}

$isMobile = (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile') || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'android'));

//Constants
$socketurl = "BloxPVP.com";
$maxGameItems = 100;
$minimumTotalTaxItems = 4; // Set To Above maxGameItems * 2 to Disable
$minimumTotalTaxValue = 50;
$taxRecieverId = 1;
?>
