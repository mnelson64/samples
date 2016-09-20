<? 
include("application_top.php");
if(!(isset($_SESSION['sUserID']))) {
	header("Location: $path"); 
}
$tmp_array = explode("\\",__FILE__);
if (count($tmp_array) < 2) {
	$tmp_array = explode("/",__FILE__); 
} 
$myFileName = $tmp_array[count($tmp_array) - 1];

// Ajax Stuff ////////////////////////////////////
/////End Ajax Stuff /////////////////////////////////////////////////////////

// process payments manually /////////////////////
//////////////////////////////////////////////////
if(isset($_POST['title'])) {

	// Process all selected payments
	foreach ($eventArray as $eventKey => $event) {
		if (count($_POST['paymentArray'.$eventKey]) > 0) {
			foreach ($_POST['paymentArray'.$eventKey] as $key => $paymentUserID) {
				//$query = sprintf("INSERT INTO checkout (cartID,userID,tournID,eventTable,fee) VALUES('%s','%s','%s','%s','%s')",$myCartID,$paymentUserID,$_SESSION['sTournID'],$event['eventTable'],$_POST['feeArray'.$eventKey][$key]);	
				$query = sprintf("UPDATE %s SET status = 'Paid', fee = '%s' WHERE `userID` ='%s' AND `tournID` ='%s'",$event['eventTable'],$_POST['feeArray'.$eventKey][$key],$paymentUserID,$_SESSION['sTournID']);
				//echo $query;
				mysql_query($query);
				echo mysql_error();
			} 
		} 
	}
	header("Location: ".$path."student-registration/payment/");
	exit;
}

/////////////////////////////////////////////////////////////////////////////
// Get tournament context ///////////////////////////////////////////////////
if(isset($_GET['tournID'])) {
	$_SESSION['sTournID']=$_GET['tournID'];
	
}
if (isset($_GET['mode'])) {
	$_SESSION['sMode'] = $_GET['mode'];
}
if (!isset($_SESSION['sMode'])) {
	$_SESSION['sMode'] = 'payment';
}

$tourn_query = sprintf("SELECT * FROM tournament_info WHERE `tournID` = '%s' ",$_SESSION['sTournID']);
//echo $query;
$tourn_set= mysql_query($tourn_query) or die(mysql_error());
$row_tourn_set = mysql_fetch_assoc($tourn_set);

// Sorting & Filtering ///////////////////////////////////////////////////////
if (isset($_GET['formOrder'])) {
	$_SESSION['formOrder'] = $_GET['formOrder'];
}
if (isset($_GET['list_order'])) {
	$_SESSION['list_order'] = $_GET['list_order'];
}  else {
	$_SESSION['list_order'] = "ASC";	
}

if (isset($_SESSION['formOrder'])) {
	if ($_SESSION['formOrder'] == 'age') {
		$formOrderString = "ORDER BY `birth_year` ".$_SESSION['list_order'].", `birth_month` ".$_SESSION['list_order'].", `birth_day` ".$_SESSION['list_order'];
	} elseif ($_SESSION['formOrder'] == 'height') {
		$formOrderString = "ORDER BY `heightFeet` ".$_SESSION['list_order'].", `heightInches` ".$_SESSION['list_order'];
	} else {
		$formOrderString = "ORDER BY `".$_SESSION['formOrder']."` ".$_SESSION['list_order'];
	}
} else {
	$_SESSION['formOrder'] = "last_name";
	$_SESSION['list_order'] = "ASC";
	$formOrderString = "ORDER BY `".$_SESSION['formOrder']."` ".$_SESSION['list_order'];
}
if (isset($_GET['event'])) {
	$_SESSION['sEvent'] = $_GET['event'];
}
$query = sprintf("SELECT * FROM registration WHERE active = 1 AND instructor = '%s' %s",$_SESSION['sOwner'],$formOrderString);
//echo $query;
$Recordset2 = mysql_query($query) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$num_rows = mysql_num_rows($Recordset2);

// create registration array
$formsArray = array();
$hasRegistrants = false;
foreach ($eventArray as $eventKey => $event) {
	$formsArray[$eventKey] = array();
	if ($eventKey != 'testing') { 
		$forms_query = sprintf("SELECT * FROM registration AS r, %s AS f WHERE r.instructor = '%s' AND r.userID = f.userID AND f.tournID = '%s'",$event['eventTable'],$_SESSION['sOwner'],$_SESSION['sTournID']);
		//echo $forms_query;
		$forms_set = mysql_query($forms_query) or die(mysql_error());
		$row_forms_set = mysql_fetch_assoc($forms_set);
		
		if (mysql_num_rows($forms_set) > 0) {
			$hasRegistrants = true;
			do {
				$formsArray[$eventKey][$row_forms_set['userID']] = $row_forms_set['status'];
				$formsRegArray[$eventKey][$row_forms_set['userID']] = $row_forms_set['regID'];
				if ($row_forms_set['comp_rank'] != "Choose one..." and $row_forms_set['comp_rank'] != "") {
					$formsCompArray[$eventKey][$row_forms_set['userID']] = true;
				} else {
					$formsCompArray[$eventKey][$row_forms_set['userID']] = false;
				}
			} while ($row_forms_set = mysql_fetch_assoc($forms_set));
		}
	}
}
$familyArray = array();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>My Students</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<meta name="Description" content="List of upcoming Taekwondo tournaments" />
<meta name="Keywords" content="taekwondo tournament" />
<link href="<?=$path?>segals.css" rel="stylesheet" type="text/css" />
<script src="scripts/header.js" type="text/javascript"></script>
<?php include "include/jquery.php";?>
</head>

<body >
<div id="main">
	<div id="mainBody">
    <?php include "header.php";?>
       	  <div id="mainContentFull">
          <div id="pageHeading">My Student Registration Fee Summary</div>
          <div id="tournLinks"><a href="<?=$path?>tournaments/">Back to Tournaments</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?=$path?>tournament-details/<?=$_SESSION['sTournID']?>/">Tournament Details</a></div>
          <div class="clearFloat"></div>
          <div id="tournTitle"><?=$row_tourn_set['title']?></div>
           <div id="tournModeLinks">
                <a href="<?=$path?>student-registration/payment/" <?php if ($_SESSION['sMode'] == 'payment') echo "style=\"text-decoration:underline\"";?> >Payment Status</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                <a href="<?=$path?>student-registration/register/" <?php if ($_SESSION['sMode'] == 'register') echo "style=\"text-decoration:underline\"" ?>> Registrations</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                <a href="<?=$path?>student-registration/print/" <?php if ($_SESSION['sMode'] == 'print') echo "style=\"text-decoration:underline\"" ?>>Printable Registration Forms</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                <a href="<?=$path?>student-registration/delete/" <?php if ($_SESSION['sMode'] == 'delete') echo "style=\"text-decoration:underline\"" ?>>Delete Registrations </a><?php if ($hasRegistrants) { ?>&nbsp;&nbsp;|&nbsp;&nbsp;
                <a href="<?=$path?>export-financial/<?=$_SESSION['sTournID']?>/<?=$_SESSION['sUserID']?>/"  target="_blank">Financial Summary</a><?php } ?>
          </div>
            
          
          <?php if ($_SESSION['sMode'] == 'payment') { ?>
          <div id="tournLegend">Click on a student/event icon to toggle payment status.</div>
          <?php } ?>
          <?php if ($_SESSION['sMode'] == 'register') { ?>
          <div id="tournLegend">Click on an icon to edit the registration form details or select one or more student/events then click "Register Selected" to register multiple students. <br /><br /><img src="<?=$path?>images/png/Pencil yellow_incomplete.png" width="16" /><div id="tournLegendText"> = Incomplete Form</div></div>
          <?php } ?>
          <?php if ($_SESSION['sMode'] == 'print') { ?>
          <div id="tournLegend">Click on a student/event to view a printable registration form.</div>
          <?php } ?>
          <?php if ($_SESSION['sMode'] == 'delete') { ?>
          <div id="tournLegend">Select one or more student/events then click "Delete Selected" to delete student registrations. </div>
          <?php } ?>	
           <div id="studentRegistrationTable">
            <table width="100%" border="0" cellpadding="5" align="left">
            <tr>
            
                  <td colspan="12" class="alert"><?php 
					if ($msg == 1) {
						echo "Account updated";
					} elseif ($msg == 2) {
						echo "New account created.";
					}
            
                  ?></td>
            
              </tr>
              <tr >
                <td width="10%" class="adminTableItemHeading">First</td>
        
                <td width="10%" class="adminTableItemHeading">Last</td>
                
                <?php foreach ($eventArray as $eventKey => $event) {
					$paymentArray[$eventKey] =  array(); //create an empty array for each event
					if ($eventKey != 'testing' and $eventKey != 'judging') { ?>
                <td width="4%" align="center"  class="adminTableItemHeading"><?=$event['eventName']?></td>
                <?php }
				} ?>
                <?php if ($row_tourn_set['fee'] != 0) { ?>
                <td width="4%" align="center"  class="adminTableItemHeading">Conv. Fee</td>
                <?php } ?>
                <td width="4%" align="center"  class="adminTableItemHeading">Total</td>
              </tr>
        
              <?php 
              if ($num_rows > 0) {
				  $idx = 1;
              $color_flag = 0;
              do { 
              
			  if ($idx > 15) {
				  $idx = 1;?>
              
              <tr >
                <td  class="adminTableItemHeading">First</td>
        
                <td class="adminTableItemHeading">Last</td>
                
                <?php foreach ($eventArray as $eventKey => $event) {
					if ($eventKey != 'testing' and $eventKey != 'judging') { ?>
                <td align="center"  class="adminTableItemHeading"><?=$event['eventName']?></td>
                <?php }?>
				
				<?php } ?>
                <?php if ($row_tourn_set['fee'] != 0) { ?>
                <td align="center"  class="adminTableItemHeading">Conv. Fee</td>
                <?php } ?>
                <td  align="center"  class="adminTableItemHeading">Total</td>
              </tr>
              
              <?php } else {
				  $idx++;
			  }?>
              
        
                <tr <?php if ($color_flag == 1) { echo ('class = "background_lite"'); } else { echo ('class = "background_dark"'); } ?>>
        
                  
                  <td class="tableContent"><?php echo $row_Recordset2['first_name'] ?></td>
        
                  <td class="tableContent"><?php echo $row_Recordset2['last_name'] ?></td>
                  
                  <?php // payment display
				  if ($_SESSION['sMode'] == 'payment') {
					  $studentTotalOwed = 0;
					  $numEvents = 0;
					  $payingFee = false;
				  	foreach ($eventArray as $eventKey => $event) {
						
					  if ($eventKey != 'testing' and $eventKey != 'judging') {?>
                  		<td align="center" class="tableContent" >
				  		<?php if (isset($_POST[$eventKey.'Payment'])) {
								if (array_key_exists($row_Recordset2['userID'], $formsArray[$eventKey])) {
								if ($row_Recordset2['familyID'] != 0) { // check if student part of a family
									//check if 2 have paid full price for this event already
									//$totalPaid = checkFamilyPayment($row_Recordset2['familyID'],$eventKey,$_SESSION['sTournID']);
									// add this student to the registered family array
									// add to family array if selected for payment or already paid
									if (in_array($row_Recordset2['userID'],$_POST[$eventKey.'Payment']) or $formsArray[$eventKey][$row_Recordset2['userID']] == 'Paid') { 
										$familyArray[$row_Recordset2['familyID']][$eventKey][] =  $row_Recordset2['userID']; // add this userID to the event array for the family they belong to
									}
									//print_r($familyArray);
								}
								
					  			if ($formsArray[$eventKey][$row_Recordset2['userID']] == 'Paid') {?>
                            	<img src="<?=$path?>images/png/Green Ball.png" width="16"  id="<?=$eventKey?>Image_<?=$formsRegArray[$eventKey][$row_Recordset2['userID']]?>"/>
					  	  <?php } else {
							  		
							  		$numEvents++; // increment number of events student is signed up for
									if ($eventKey == 'forms' or $eventKey == 'tiny') { // combine Forms and Tiger counts
										$traditionalTotal = count($familyArray[$row_Recordset2['familyID']]['forms']) + count($familyArray[$row_Recordset2['familyID']]['tiny']);
										$feeArray = getFee($row_Recordset2['userID'],$traditionalTotal,$numEvents,$eventKey,$_SESSION['sTournID']);
									} else {
										$feeArray = getFee($row_Recordset2['userID'],count($familyArray[$row_Recordset2['familyID']][$eventKey]),$numEvents,$eventKey,$_SESSION['sTournID']);
									}
									if (in_array($row_Recordset2['userID'],$_POST[$eventKey.'Payment'])) { // selected for payment
										$payingFee = true;
										echo '$'.$feeArray['fee'];
										$paymentArray[$eventKey][] = array('userID' => $row_Recordset2['userID'], 'fee' => $feeArray['fee']);
									
										$studentTotalOwed = $studentTotalOwed + $feeArray['fee'];
									} else { // not selected for payment ?>
										<img src="<?=$path?>images/png/Red Ball.png" width="16" />
									<?php }
					 			} 
				  			   } // if stuent registerd in event
							 } //if $_POST exists ?>
                         </td>
					  <?php } elseif ($eventKey == 'judging') { // place student total?>
                      	
				<?php 	} // if not judging ot testing
					  } // foreach?>
                      
                      <?php if ($row_tourn_set['fee'] != 0) { ?>
                      <td align="center" class="tableContent" >
                      <?php if ($payingFee) { ?>
					  		<?php 
							$con_query = sprintf("SELECT * FROM convenience_reg WHERE `tournID` = '%s' AND `userID` = '%s'",mysql_real_escape_string($_SESSION['sTournID']),mysql_real_escape_string($row_Recordset2['userID']));
							$con_set= mysql_query($con_query) or die(mysql_error());
							?>
							<?php if (mysql_num_rows($con_set) > 0) { ?>
									<img src="<?=$path?>images/png/Green Ball.png" width="16"/>
							<?php } else { 
									$paymentArray['convenience_reg'][] = array('userID' => $row_Recordset2['userID'], 'fee' => $row_tourn_set['fee']);
									$studentTotalOwed = $studentTotalOwed + $row_tourn_set['fee'];?>
									$<?=number_format($row_tourn_set['fee'],2)?>
							<?php } ?>
                       <?php } // if more than 0 events?>
                  	  </td>
                      <?php } ?>
                      <td align="center" class="tableContent" >
					  		<?php $displayTotal = $studentTotalOwed == 0 ? '' : '$'.$studentTotalOwed;
								  echo '<strong>'.$displayTotal.'</strong>';?>
                  	  </td>
				  <?php } // if payment?>
                </tr>
        
               <?php 
                if ($color_flag == 1) {
                    $color_flag = 0;
                 } else {
                    $color_flag = 1;
                 }
				 $groupTotalOwed = $groupTotalOwed + $studentTotalOwed;
                } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));?>
                 <tr class="paymentOwedRow">
                 	<?php if ($row_tourn_set['fee'] != 0) { ?>
                    <td colspan="11" align="right"><strong>Total Payment</strong></td>
                    <?php } else { ?>
                    <td colspan="10" align="right"><strong>Total Payment</strong></td>
                    <?php } ?>
                    <td ><strong>$<?=number_format($groupTotalOwed,2)?></strong></td>
                  </tr> 
				
                <?php } else {?>
               <tr>
                <td colspan="16">No students found</td>
              </tr>
              <?php } ?> 
        
          </table>
          <div id="paymentButton">
          <?php 
		  // determine host owner ID to exempt them from paying through Paypal
		  
		  ?>
			<?php if ($_SESSION['sOwnerID'] == $row_tourn_set['hostID']) { ?>
            	<form action="<?=$path?>student-payment/" method="post" enctype="application/x-www-form-urlencoded" name="form1">
            <?php } else {?>
           		<form action="<?=$path?>paypal-1.3.0/submit_paypal.php?action=process" method="post" enctype="application/x-www-form-urlencoded" name="form1">
            <?php } ?> 
            
                <?php foreach ($eventArray as $eventKey => $event) {
                    //print_r($paymentArray[$eventKey]);
                    if (count($paymentArray[$eventKey]) > 0) {
                        foreach ($paymentArray[$eventKey] as $paymentUser) {?>
                            <input name="paymentArray<?=$eventKey?>[]" type="hidden" value="<?=$paymentUser['userID']?>" />
                            <input name="feeArray<?=$eventKey?>[]" type="hidden" value="<?=$paymentUser['fee']?>" />
                        <?php } ?>
                    
                    <?php } ?>
                <?php } ?>
                <?php if (count($paymentArray['convenience_reg']) > 0) {
					foreach ($paymentArray['convenience_reg'] as $paymentUser) {?>
						<input name="paymentArrayconvenience_reg[]" type="hidden" value="<?=$paymentUser['userID']?>" />
						<input name="feeArrayconvenience_reg[]" type="hidden" value="<?=$paymentUser['fee']?>" />
					<?php } ?>
				
				<?php } ?>
            
                <input name="title" type="hidden" value="<?=$row_tourn_set['title']?> Registration" />
                <input name="amount" type="hidden" value="<?=$groupTotalOwed?>" />
                <input name="submit" id="submit" type="submit" value="Make Payment" />
            </form>
            </div>
          </div>
	  </div>
 
  </div>
    <div id="footer">
		<?php include "footer.php";?>
	</div> 

</div>

</body>
</html>
<script language="JavaScript">
<!--

-->
</script>