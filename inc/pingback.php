<?php
include_once('./inc/config.inc.php');

$pingbackkey = isset($_POST["pingbackkey"]) ? $_POST["pingbackkey"] : "";

if ($pingbackkey === "iu56zerghdh6534563sfst567gs") {
    $voterIP = isset($_POST["VoterIP"]) ? $_POST["VoterIP"] : '';
    $success = abs($_POST["Successful"]);
    $reason = $_POST["Reason"];
    $pingUsername = $_POST["pingUsername"];

    function pingback($voterIP, $success, $mssql) {
        $result = odbc_exec($mssql, "SELECT account, votepoints FROM [ACCOUNT_TBL] WHERE LastIP = '" . $voterIP . "'");
        
        if ($result !== FALSE) {
            $row = odbc_fetch_array($result);
            if (is_array($row)) {
                $username = $row['account'];
                $votepoints = $row['votepoints'] + 3;

                if ($success == 0) {
                    // Belohnung an $username (Benutzername) senden
                    // Beispiel: belohne($username, 3);
                }

                // Aktualisiere die Anzahl der Vote-Punkte in der Datenbank
                odbc_exec($mssql, "UPDATE [ACCOUNT_TBL] SET votepoints = " . $votepoints . " WHERE account = '" . $username . "'");
            }
            odbc_free_result($result);
        }
    }
}
?>