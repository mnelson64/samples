<? 
include("application_top.php");
$tmp_array = explode("\\",__FILE__);
if (count($tmp_array) < 2) {
	$tmp_array = explode("/",__FILE__); 
} 
$myFileName = $tmp_array[count($tmp_array) - 1];
if(!(isset($_SESSION['sUserID']))) {
	$_SESSION['sTournID']=$_GET['tournID'];
	header("Location: $path"); 
}

if(isset($_GET['tournID'])) {
	$_SESSION['sTournID']=$_GET['tournID'];
}

if (isset($_GET['function']) and $_GET['function'] == 'delete') {
	
	$query = sprintf("DELETE FROM %s WHERE userID = '%s' AND tournID = '%s'",$eventArray[$_GET['tournEvent']]['eventTable'],$_SESSION['sUserID'],$_GET['tournID']);
	mysql_query($query);
	echo mysql_error();
}

$tourn_query = sprintf("SELECT * FROM tournament_info WHERE `tournID` = '%s' ",$_GET['tournID']);
//echo $query;
$tourn_set= mysql_query($tourn_query) or die(mysql_error());
$row_tourn_set = mysql_fetch_assoc($tourn_set);

$user_query = sprintf("SELECT * FROM registration WHERE `userID` = '%s' ",$_SESSION['sUserID']);
//echo $query;
$user_set= mysql_query($user_query) or die(mysql_error());
$row_user_set = mysql_fetch_assoc($user_set);

$userDataArray[$row_user_set['userID']] = array('first_name' => $row_user_set['first_name'], 'last_name' => $row_user_set['last_name']);

if ($row_user_set['familyID'] != 0) {
	$query = sprintf("SELECT * FROM registration WHERE `familyID` = '%s' AND `userID` != '%s'", $row_user_set['familyID'],$row_user_set['userID']);
	$user_set = mysql_query($query) or die(mysql_error());
	$row_user_set = mysql_fetch_assoc($user_set);
	do {
		$userDataArray[$row_user_set['userID']] = array('first_name' => $row_user_set['first_name'], 'last_name' => $row_user_set['last_name']);
	} while ($row_user_set = mysql_fetch_assoc($user_set));
}

$totalOwed = 0;
$cartArray = array();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Payment Summary - <?=$row_tourn_set['title']?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<meta name="Description" content="List of upcoming Taekwondo tournaments" />
<meta name="Keywords" content="taekwondo tournament" />
<link href="<?=$path?>segals.css" rel="stylesheet" type="text/css" />
<?php include "include/jquery.php";?>
<?php include "include/analytics.php"?>
<script language="javascript">
<!--

function confirmDelete(tournEvent,tournID)
{
	var getConfirm;
	getConfirm = confirm("Are you sure you want to delete this registration?")
	if (getConfirm == true)
	{
		document.location.href = "<?=$path?>tournament-registration/"+tournID+"/"+tournEvent+"/delete/" 
	}

}
-->
</script>
</head>

<body >
<div id="main">
	<div id="mainBody">
    <?php include "header.php";?>
    	
           <?php $numEvents = 0;?> 	
       	  <div id="mainContentFull">
          <div id="pageHeading">Payment Summary</div>
          <div id="tournLinks"><a href="<?=$path?>tournament-registration/<?=$_GET['tournID']?>/">Go Back</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?=$path?>tournaments/">Back to Tournaments</a></div>
          <div id="paymentTableArea">
          	<div id="paymentTableTitle"><?=$row_tourn_set['title']?></div>
            <div id="paymentTableText">
            <strong>Discounts:</strong> Certain discounts are available based on the number of events a student is registered for and the number of family members participating as described below.<br /><br />
            <strong>Family Discount:</strong> The 3rd and any additional family members competing in the same event pay only $5 for that event.<br />
            <strong>Multi Event Discount:</strong> An individual receives a $10 discount on the 4th event and any additional events they register for.<br />
            <strong>Convenience Fee:</strong> This fee is per person and is used to improve the tournament experience and offset the cost of the registration system.
            </div>
            <?php foreach ($userDataArray as $userID => $userData) {
					$userRegistered = false;?>
                    <div class="tournRegUserName"><?=$userData['first_name']?> <?=$userData['last_name']?></div>		
                    <?php 
                    foreach ($eventArray as $eventKey => $event) {
                        if ($eventKey != 'testing' and $eventKey != 'judging') {
                            $bgColor = ($colorFlag == 0) ? 'background_lite': 'background_dark';?>
                            <div class="paymentTableUnit <?=$bgColor?>">
                                <div class="paymentTableEventHeading"><?=$event['eventName']?></div>
                                <div class="paymentTableEventStatus">
                                <?php 
                                $reg_query = sprintf("SELECT * FROM %s WHERE `tournID` = '%s' AND `userID` = '%s'",mysql_real_escape_string($event['eventTable']),mysql_real_escape_string($_GET['tournID']),$userID);
                                $reg_set= mysql_query($reg_query) or die(mysql_error());
                                $row_reg_set = mysql_fetch_assoc($reg_set);
								if (mysql_num_rows($reg_set) > 0) {
									$userRegistered = true;
								}
                                
                                if (mysql_num_rows($reg_set) > 0 and $row_reg_set['status'] == 'Paid') { ?>  
                                    Paid&nbsp;<i class="fa fa-check"></i>
                                <?php 
                                } elseif (mysql_num_rows($reg_set) > 0 and $row_reg_set['status'] == 'Unpaid') { 
                                    $numEvents++;
									$familyRegisteredInEvent[$eventKey]++;
                                    $fee = getFee($_SESSION['sUserID'],$familyRegisteredInEvent[$eventKey],$numEvents,$eventKey,$_GET['tournID']);
                                    $totalOwed = $totalOwed + $fee['fee'];
                                    $cartArray[$userID][] = array('event' => $eventKey, 'fee' => $fee['fee']);
                                ?>
                                    $<?=$fee['fee']?><?php if ($fee['discount'] != '') echo ' ('.$fee['discount'].')'?>
                                <?php 
                                } else { ?> 
                                    Not Registered 
                                <?php } ?>
                                </div>
                            </div>
                      <?php } // if not judging or high-rank
                            $colorFlag = ($colorFlag == 1) ? 0 : 1;
                      } // foreach event?>
                    <?php if ($row_tourn_set['fee'] != 0  and $userRegistered) { ?>
                            <div class="paymentTableUnit <?=$bgColor?>">
                                <div class="paymentTableEventHeading">Convenience Fee</div>
                                <div class="paymentTableEventStatus">
                                <?php 
                                $reg_query = sprintf("SELECT * FROM convenience_reg WHERE `tournID` = '%s' AND `userID` = '%s'",mysql_real_escape_string($_GET['tournID']),$userID);
                                $reg_set= mysql_query($reg_query) or die(mysql_error());
                                $row_reg_set = mysql_fetch_assoc($reg_set);
                                if (mysql_num_rows($reg_set) > 0 and ($row_reg_set['status'] == 'Paid')) { ?>  
                                    Paid&nbsp;<i class="fa fa-check"></i>
                                <?php } else { ?> 
                                    $<?=number_format($row_tourn_set['fee'],2)?>
                                    <?php
                                    $totalOwed = $totalOwed + $row_tourn_set['fee'];
                                    $cartArray[$userID][] = array('event' => 'convenience_reg', 'fee' => $row_tourn_set['fee']);
                                    ?>
                                <?php } ?>
                                </div>
                            
                              </div>
                        <?php } ?>
                   <?php } // for each family member ?>
              <div class="paymentTableTotal">
            	<div class="paymentTableEventHeading">Total</div>
            	<div class="paymentTableTotalAmount">$<?=$totalOwed?></div>
              </div>
              <div class="paymentTableInstructions">Clicking on the "Make Payment" button will bring you to our secure Paypal payment site.<br /><br />Once on the Paypal site, you can make your payment with your credit card or Paypal account.</div>
           
            <?php //print_r($cartArray);?>
            </div>
		  	<div id="paymentButton">
            	<form action="<?=$path?>paypal-1.3.0/submit_paypal.php?action=process" method="post" enctype="application/x-www-form-urlencoded" name="form1">
                	<?php foreach ($cartArray as $userID => $userPaymentArray) {?>
                    	<?php foreach ($userPaymentArray as $paymentEntry) {?>
                            <input name="paymentArray<?=$paymentEntry['event']?>[]" type="hidden" value="<?=$userID?>" />
                            <input name="feeArray<?=$paymentEntry['event']?>[]" type="hidden" value="<?=$paymentEntry['fee']?>" />
                         <?php } ?>
                    <?php } ?>
                
                    <input name="title" type="hidden" value="<?=$row_tourn_set['title']?> Registration" />
                    <input name="amount" type="hidden" value="<?=$totalOwed?>" />
                	<a href="<?=$path?>tournament-registration/<?=$_GET['tournID']?>/">&lt;&lt;Back</a>&nbsp;&nbsp;&nbsp;<input name="submit" id="submit" type="submit" value="Make Payment" />
                </form>
            </div>
          
		</div>
 

  </div>
    <div id="footer">
		<?php include "footer.php";?>
	</div> 

</div>

</body>
</html>
