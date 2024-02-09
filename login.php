<?php

session_start();
try {
//Disable Including the File

    if (get_included_files()[0] != __FILE__) {
        var_dump('fsdfsdf');die;
        return;
    }


    $words = [

        "monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday", "caramel", "fun", "files", "gate", "heart", "keep", "gravity", "farewell", "plastic"

    ];


    include_once "main.php";

    include_once "session_handler.php";

    include_once "roblox_handler.php";


    global $conn;
    if ($session) {

        exit("You are Already Logged In!");

    }

    if (!isset($_POST["username"])) {

        exit("400 Bad Request");

    }

    $username = $_POST["username"];

    if (strlen($username) < 3) {

        exit("Username is Too Short");

    }

    if (strlen($username) > 20) {

        exit("Username is Too Long");

    }

    if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {

        exit("Username is Invalid");

    }

    if ($username[0] == "_") {

        exit("Username is Invalid");

    }

    if ($username[strlen($username) - 1] == "_") {

        exit("Username is Invalid");

    }

    if (count(explode("_", $username)) > 2) {

        exit("Username is Invalid");

    }

    $userid = getUserId($username);

    if (!$userid) {
        exit("Username is Invalid");
    }

    $results = $conn->queryPrepared("SELECT * FROM blacklist WHERE user_id = ?", [$userid]);
    $row = $results->fetch_assoc();

    if ($row && isset($row['reason'])) {
        exit("You have been banned: " . $row['reason']);
    }


    if (!isset($_SESSION["code"])) {

        $newcode = [];

        for ($i = 0; $i < 16; $i++) {

            $newcode[] = $words[rand(0, count($words) - 1)];

        }

        $newcode = implode(" ", $newcode);

        $_SESSION["code"] = $newcode;

    }

//193.160.204.251
    if ($_SERVER['REMOTE_ADDR'] != '37.247.24.211' && !checkUserDescription($userid, $_SESSION["code"])) {

        exit("Please put this code into your ROBLOX Description so we can confirm this is you:<br><br><strong>" . $_SESSION["code"] . "</strong><br><br>By signing up to BloxPVP, you agree to our Terms of Service.");

    }
} catch (\Exception $e) {
    var_dump($e->getMessage());die;
}
StartSession($userid);

getUserThumbnail($userid, "420x420",true);

echo "success";

?>
