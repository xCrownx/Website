<?php
session_start();

// Include the config file to access the $mssql variable
require_once('config.inc.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cmt_submit'])) {
        if (empty($_POST['cmt_comment']) || empty($_POST['cmt_nid'])) {
            echo '<div class="fail">You must fill in all fields!</div>';
        } else {
            // Überprüfe das reCAPTCHA
            $captchaResponse = $_POST['g-recaptcha-response'];
            $secretKey = '6LchqEQmAAAAAGX5ter7ukB-CVjYaa65nlb4_0tP'; // Hier fügst du deinen reCAPTCHA-Key ein
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $captchaResponse);
            $responseData = json_decode($verifyResponse);

            if ($responseData->success) {
                // reCAPTCHA erfolgreich überprüft
                $comment = $_POST['cmt_comment'];
                $nid = $_POST['cmt_nid'];
                $author = $_SESSION['username'];
                $ip = $_SERVER['REMOTE_ADDR'];

                // SQL-Query zum Einfügen des Kommentars in die Datenbank
                $sql = "INSERT INTO web_newscomments (nid, author, content, ip, datetime) VALUES ('$nid', '$author', '$comment', '$ip', GETDATE())";

                // Führe die SQL-Abfrage aus
                $result = odbc_exec($mssql, $sql);

                if ($result) {
                    echo '<div class="success">Your comment was successfully saved!</div>';
                } else {
                    echo '<div class="fail">An error occurred while saving your comment. Please try again.</div>';
                }
            } else {
                // reCAPTCHA-Fehler
                echo '<div class="fail">Invalid reCAPTCHA. Please try again.</div>';
            }
        }
    }
}

?>
