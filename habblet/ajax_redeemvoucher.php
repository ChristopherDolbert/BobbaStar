<?php
/*===================================================+ 
|| # HoloCMS - Website and Content Management System 
|+===================================================+ 
|| # Copyright � 2008 Meth0d. All rights reserved. 
|| # http://www.meth0d.org 
|+===================================================+ 
|| # HoloCMS is provided "as is" and comes without 
|| # warrenty of any kind. HoloCMS is free software! 
|+===================================================*/

require_once('../config.php');

$credits = $myrow['credits'];
$voucher = FilterText($_POST['voucherCode']);

$check = $bdd->prepare("SELECT type, credits FROM vouchers WHERE voucher = :voucher LIMIT 1");
$check->execute(array(':voucher' => $voucher));
$valid = $check->rowCount();

if ($valid > 0) {
    $tmp = $check->fetch(PDO::FETCH_ASSOC);
    $amount = $tmp['credits'];
    $resultcode = "green";

    if ($tmp['type'] == 'credits') {
        $credits += $amount;
        $update_credits = $bdd->prepare("UPDATE users SET credits = :credits WHERE name = :name LIMIT 1");
        $update_credits->execute(array(':credits' => $credits, ':name' => FilterText($name)));

        $delete_voucher = $bdd->prepare("DELETE FROM vouchers WHERE voucher = :voucher LIMIT 1");
        $delete_voucher->execute(array(':voucher' => $voucher));

        $insert_transaction = $bdd->prepare("INSERT INTO `cms_transactions` (`date`, `amount`, `descr`, `userid`) VALUES (:date_full, :amount, 'Credit voucher redeem', :my_id)");
        $insert_transaction->execute(array(':date_full' => $date_full, ':amount' => $amount, ':my_id' => $user['id']));

        $result = "You have redeemed " . $amount . " credits successfully.";
        @SendMUSData('UPRC' . $user['id']);
    } else {
        $item = $bdd->prepare("SELECT tid FROM catalogue_items WHERE name_cct = :amount LIMIT 1");
        $item->execute(array(':amount' => $amount));
        $itemvalid = $item->rowCount();

        if ($itemvalid > 0) {
            $itemtmp = $item->fetch(PDO::FETCH_ASSOC);
            $itemid = $itemtmp['tid'];

            $insert_furniture = $bdd->prepare("INSERT INTO furniture (tid, ownerid) VALUES (:itemid, :my_id)");
            $insert_furniture->execute(array(':itemid' => $itemid, ':my_id' => $user['id']));

            $delete_voucher = $bdd->prepare("DELETE FROM vouchers WHERE voucher = :voucher LIMIT 1");
            $delete_voucher->execute(array(':voucher' => $voucher));

            $insert_transaction = $bdd->prepare("INSERT INTO `cms_transactions` (`date`, `amount`, `descr`, `userid`) VALUES (:date_full, :amount, 'Item voucher redeem', :my_id)");
            $insert_transaction->execute(array(':date_full' => $date_full, ':amount' => $amount, ':my_id' => $user['id']));

            $result = "You have redeemed this item of furniture successfully.";
            @SendMUSData('UPRH' . $user['id']);
        } else {
            $resultcode = "red";
            $result = "Item not valid, please contact an admin for assistance.";
        }
    }
} else {
    $resultcode = "red";
    $result = "Your redeem code could not be found. Please try again.";
}

echo "<ul> 
    <li class=\"even icon-purse\"> 
        <div>You Currently Have:</div> 
        <span class=\"purse-balance-amount\">" . $credits . " Credits</span> 
        <div class=\"purse-tx\"><a href=\"transactions.php\">Account transactions</a></div> 
    </li> 
</ul> 
<div id=\"purse-redeem-result\"> 
        <div class=\"redeem-error\"> 
            <div class=\"rounded rounded-" . $resultcode . "\"> 
                " . $result . " 
            </div> 
        </div> 
</div>";
