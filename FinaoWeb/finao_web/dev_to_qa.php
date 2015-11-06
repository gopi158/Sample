<?php
    shell_exec("./dev_to_qa.bash");
    echo "Replication complete<br />";
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'To: Neha Suri <neha.suri@battatech.com.com>, Tarun Batta<tarun.batta@battatech.com>' . "\r\n";
    $headers .= 'From: Server Daemon<server@finaonationb.com>' . "\r\n";
    $headers .= 'Cc: Kunal Gala <kunal.gala@battatech.com>, Sandeep Kumar <sandeep.kumar@battatech.com>, Sanjeev Sharma <sanjeev.sharma@battatech.com>, Sawan Kumar <sawan.kumar@battatech.com>, Sumeet Bachchas <sumeet.bachchas@battatech.com>, Abhishek Chatterjee <abhishek.chatterjee@battatech.com>' . "\r\n";
    if (!mail("neha.suri@battatech.com","Dev Environment replicated to QA","",$headers))
    {
        echo "Failed to send email<br />";
    }
    else
        echo "All Teams Notified<br />";
?>
