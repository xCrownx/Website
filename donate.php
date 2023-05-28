<?php include('./inc/header.php');
include_once('./inc/config.inc.php');
 ?>
<h1>Donate</h1>
<div class="site">
	<?php
if (isset($_POST['paypal_sbm'])) {
    if (empty($_POST['paypal_amount'])) {
        echo '<div class="fail">You must enter an amount!</div>';
    } else {
        // Code zum Verarbeiten der PayPal-Zahlung
        $amount = $_POST['paypal_amount'];

        // Spendenbetrag und zugehörige Donate-Punkte definieren
        $donationAmounts = array(
            5 => 500,
            10 => 1000,
            20 => 2000
        );

        // Überprüfen, ob der eingegebene Betrag in der Liste der definierten Beträge vorhanden ist
        if (isset($donationAmounts[$amount])) {
            $donatePoints = $donationAmounts[$amount];

            // Hier kannst du den PayPal-Zahlungsprozess implementieren, z. B. mit der PayPal API oder einem Zahlungs-Gateway-Service
            // Überprüfe, ob die Zahlung erfolgreich war

            $paymentSuccessful = true; // Beispiel: Annahme, dass die Zahlung erfolgreich war

            if ($paymentSuccessful) {
                // Guthaben des Benutzers aktualisieren
                $username = $_SESSION['user'];
                $sql = "UPDATE ACCOUNT_TBL SET cash = cash + $donatePoints WHERE account = '$username'";
                $result = odbc_exec($mssql, $sql);

                if ($result) {
                    // Guthaben erfolgreich aktualisiert
                    echo '<div class="success">Your donation of ' . $amount . ' was successfully submitted and processed through PayPal!<br/>You have received ' . $donatePoints . ' donate points.</div>';
                } else {
                    // Fehler beim Aktualisieren des Guthabens
                    echo '<div class="fail">An error occurred while processing your donation. Please try again.</div>';
                }
            } else {
                // Zahlung nicht erfolgreich
                echo '<div class="fail">Payment was not successful. Please try again.</div>';
            }
        } else {
            echo '<div class="fail">Invalid donation amount!</div>';
        }
    }
}
        ?>
        <img src="img/paypal.png" style="margin-top: 5px; margin-bottom: 8px;" />
        <form method="post">
            Donation Amount<br/>
            <select name="paypal_amount">
                <option value="5">5€ - 500 Donate Points</option>
                <option value="10">10€ - 1000 Donate Points</option>
                <option value="20">20€ - 2000 Donate Points</option>
            </select><br/><br/>
            Account: <span style="font-weight: bold;"><?php echo $_SESSION['user']; ?></span>
            <br/><br/>
            <input type="submit" name="paypal_sbm" value="Donate Now" />
        </form>
        <?php
    } else {
        echo '<div class="fail">You must be logged in to donate!</div>';
    }
    ?>
</div>
<?php include('./inc/footer.php'); ?>
