<?php
session_start();
if (isset($_POST['toggleStatusID'])) {
	require_once("../../../wp-load.php");
} else {
	require_once("../wp-load.php");
}
$monthArray = array(1 => 'January',2 => 'February',3 => 'March',4 => 'April',5 => 'May',6 => 'June',7 => 'July',8 => 'August',9 => 'September',10 => 'October',11 => 'November',12 => 'December');

// Ajax Stuff ///////////////////////////////////////////////////////////
if (isset($_POST['toggleStatusID'])) { 
	if ($_POST['status'] == 'Pending') {
		$newStatus = 'Paid';
	} else {
		$newStatus = 'Pending';
	}
	$query = sprintf("UPDATE registrations SET `regStatus` = '%s' WHERE `regID` = '%s' ",$newStatus,mysql_real_escape_string($_POST['toggleStatusID']));
	echo $query;
	mysql_query($query);
	echo mysql_error();
	exit;

}

// Delete Registration //////////////////////////////////////////////////
if (isset($_GET['function']) and $_GET['function'] == 'delete') {
	
	// delete entry

	$query = sprintf("DELETE FROM registrations WHERE `regID` ='%s'",$_GET['regID']);	
	mysql_query($query);
	echo mysql_error();
	
	$regDeleted = true;
}

/////////////////////////////////////////////////////////////////////////
////////////     Filters ////////////////////////////////////////////
if (isset($_GET['categoryID'])) {
	$_SESSION['sCategoryID'] = $_GET['categoryID'];
}
if (isset($_SESSION['sCategoryID']) and $_SESSION['sCategoryID'] != 'All') {
	$reportCategoryString = " AND wp_tt.term_id ='".$_SESSION['sCategoryID']."'"; 
} else {
	$reportCategoryString = '';
}

if (isset($_GET['courseID'])) {
	$_SESSION['sCourseID'] = $_GET['courseID'];
}
if (isset($_SESSION['sCourseID']) and $_SESSION['sCourseID'] != 'All') {
	$reportCourseIDString = " AND courseID ='".$_SESSION['sCourseID']."'"; 
} else {
	$reportCourseIDString = '';
}

if (isset($_GET['year'])) {
	$_SESSION['sYear'] = $_GET['year'];
}
if (isset($_SESSION['sYear']) and $_SESSION['sYear'] != 'All') {
	$reportYearString = " AND `courseYear` ='".$_SESSION['sYear']."'"; 
} else {
	$reportYearString = '';
}

if (isset($_GET['month'])) {
	$_SESSION['sMonth'] = $_GET['month'];
}
if (isset($_SESSION['sMonth']) and $_SESSION['sMonth'] != 'All') {
	$reportMonthString = " AND `courseMonth` ='".$_SESSION['sMonth']."'"; 
} else {
	$reportMonthString = '';
}

if (isset($_GET['day'])) {
	$_SESSION['sDay'] = $_GET['day'];
}
if (isset($_SESSION['sDay']) and $_SESSION['sDay'] != 'All') {
	$reportDateString = " AND `courseDate` ='".$_SESSION['sDay']."'"; 
} else {
	$reportDateString = '';
}

if (isset($_GET['status'])) {
	$_SESSION['sStatus'] = $_GET['status'];
}
if (isset($_SESSION['sStatus']) and $_SESSION['sStatus'] != 'All') {
	$reportStatusString = " AND `regStatus` ='".$_SESSION['sStatus']."'"; 
} else {
	$reportStatusString = '';
}


////////// End Filters //////////////////////////////////////////////
$item_query=sprintf("SELECT * FROM registrations  WHERE 1   %s %s %s %s %s ORDER BY `regDate` DESC",$reportCourseIDString,$reportYearString,$reportMonthString,$reportDateString,$reportStatusString);
//echo $item_query;
$item_set = mysql_query($item_query) or die(mysql_error());
$row_item_set = mysql_fetch_assoc($item_set);	
$num_items = mysql_num_rows($item_set);

?>
<script language="javascript">
<!--
function surePhotoDelete(cid,nm)
{
	var getConfirm;
	getConfirm = confirm("Are you sure you want to delete this registration?")
	if (getConfirm == true)
	{
		document.location.href = "<?=site_url()?>/wp-admin/admin.php?page=/tech-registrations/manageRegistrations.php&function=delete&regID="+ cid 
	}

}

-->
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>&nbsp;</td>
                      <td valign="top" class="alert">
					  <?php if ($_GET['msg'] == 'del') { echo ITEM_NAME_ENGLISH." deleted successfully."; 
							} elseif ($_GET['msg'] == 'new') { echo ITEM_NAME_ENGLISH." added successfully.";
							} elseif ($_GET['msg'] == 'up') { echo ITEM_NAME_ENGLISH." updated successfully.";
							}?></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td valign="top">
                      <?php ///////////////////////// Select Category /////////////////////////?>
                         <div class="selectItem">
                            <div class="selectLabel">Category</div>
                               
                        <select name="category" id="category" onChange="window.location =this.options[this.selectedIndex].value">
                        
                            <option value="<?=site_url()?>/wp-admin/admin.php?page=/tech-registrations/manageRegistrations.php&categoryID=All" <?php if ($_SESSION['sCategory'] == 'All') echo "selected=\"selected\"" ?>>Show All</option>
                            <?php
							$cat_query=sprintf("SELECT * FROM wp_term_taxonomy AS tax, wp_terms WHERE tax.term_id = wp_terms.term_id AND tax.taxonomy='product_cat' ORDER BY `name`");
							$cat_set = mysql_query($cat_query) or die(mysql_error());
							$row_cat_set = mysql_fetch_assoc($cat_set);
							do {?>
                            <option value="<?=site_url()?>/wp-admin/admin.php?page=/tech-registrations/manageRegistrations.php&categoryID=<?=$row_cat_set['term_id']?>" <?php if ($_SESSION['sCategoryID'] == $row_cat_set['term_id']) echo "selected=\"selected\"" ?>><?=$row_cat_set['name']?></option>
                            
                             <?php } while ($row_cat_set = mysql_fetch_assoc($cat_set));?>
                        </select>
                         
                        </div>
                         <?php ///////////////////////// Select Course /////////////////////////?>
                         <div class="selectItem">
                            <div class="selectLabel">Course</div>
                               
                        <select name="courseID" id="courseID" onChange="window.location =this.options[this.selectedIndex].value">
                        
                            <option value="<?=site_url()?>/wp-admin/admin.php?page=/tech-registrations/manageRegistrations.php&courseID=All" <?php if ($_SESSION['sCourseID'] == 'All') echo "selected=\"selected\"" ?>>Show All</option>
                            <?php
							$course_query=sprintf("SELECT * FROM wp_posts WHERE `post_type` = 'product' ORDER BY `post_title`");
							echo $course_query;
							$course_set = mysql_query($course_query) or die(mysql_error());
							$row_course_set = mysql_fetch_assoc($course_set);
							do {
							?>
                            <option value="<?=site_url()?>/wp-admin/admin.php?page=/tech-registrations/manageRegistrations.php&courseID=<?=$row_course_set['ID']?>" <?php if ($_SESSION['sCourseID'] == $row_course_set['ID']) echo "selected=\"selected\"" ?>><?=$row_course_set['post_title']?></option>
                            <?php } while ($row_course_set = mysql_fetch_assoc($course_set));?>
                        </select>
                         
                        </div>
                        <?php ///////////////////////// Select Year /////////////////////////?>
                         <div class="selectItem">
                            <div class="selectLabel">Year</div>
                               
                        <select name="year" id="year" onChange="window.location =this.options[this.selectedIndex].value">
                        
                            <option value="<?=site_url()?>/wp-admin/admin.php?page=/tech-registrations/manageRegistrations.php&year=All" <?php if ($_SESSION['sYear'] == 'All') echo "selected=\"selected\"" ?>>Show All</option>
							<?php for ($y =2012; $y <= date('Y') + 1; $y++) {?>
                            <option value="<?=site_url()?>/wp-admin/admin.php?page=/tech-registrations/manageRegistrations.php&year=<?=$y?>" <?php if ($_SESSION['sYear'] == $y) echo "selected=\"selected\"" ?>><?=$y?></option>
                            <?php }?>
                        </select>
                         
                        </div>
                        <?php ///////////////////////// Select Month /////////////////////////?>
                         <div class="selectItem">
                            <div class="selectLabel">Month</div>
                               
                        <select name="month" id="month" onChange="window.location =this.options[this.selectedIndex].value">
                        
                            <option value="<?=site_url()?>/wp-admin/admin.php?page=/tech-registrations/manageRegistrations.php&month=All" <?php if ($_SESSION['sMonth'] == 'All') echo "selected=\"selected\"" ?>>Show All</option>
							<?php for ($m =1; $m <= 12; $m++) {?>
                            <option value="<?=site_url()?>/wp-admin/admin.php?page=/tech-registrations/manageRegistrations.php&month=<?=$monthArray[$m]?>" <?php if ($_SESSION['sMonth'] == $monthArray[$m]) echo "selected=\"selected\"" ?>><?=$monthArray[$m]?></option>
                            <?php }?>
                        </select>
                         
                        </div>
                        <?php ///////////////////////// Select Day /////////////////////////?>
                         <div class="selectItem">
                            <div class="selectLabel">Day</div>
                               
                        <select name="day" id="day" onChange="window.location =this.options[this.selectedIndex].value">
                        
                            <option value="<?=site_url()?>/wp-admin/admin.php?page=/tech-registrations/manageRegistrations.php&day=All" <?php if ($_SESSION['sDay'] == 'All') echo "selected=\"selected\"" ?>>Show All</option>
							<?php for ($d =1; $d <= 31; $d++) {?>
                            <option value="<?=site_url()?>/wp-admin/admin.php?page=/tech-registrations/manageRegistrations.php&day=<?=$d?>" <?php if ($_SESSION['sDay'] == $d) echo "selected=\"selected\"" ?>><?=$d?></option>
                            <?php }?>
                        </select>
                         
                        </div>
                        <?php ///////////////////////// Select Status /////////////////////////?>
                         <div class="selectItem">
                            <div class="selectLabel">Payment Status</div>
                               
                        <select name="status" id="status" onChange="window.location =this.options[this.selectedIndex].value">
                        
                            <option value="<?=site_url()?>/wp-admin/admin.php?page=/tech-registrations/manageRegistrations.php&status=All" <?php if ($_SESSION['sStatus'] == 'All') echo "selected=\"selected\"" ?>>Show All</option>
                            <option value="<?=site_url()?>/wp-admin/admin.php?page=/tech-registrations/manageRegistrations.php&status=Pending" <?php if ($_SESSION['sStatus'] == 'Pending') echo "selected=\"selected\"" ?>>Pending</option>
                            <option value="<?=site_url()?>/wp-admin/admin.php?page=/tech-registrations/manageRegistrations.php&status=Paid" <?php if ($_SESSION['sStatus'] == 'Paid') echo "selected=\"selected\"" ?>>Paid</option>
                        </select>
                         
                        </div>
                      </td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td valign="top" class="adminTableItemHeading"><?php if ($num_items > 0) { ?>
		<table width="100%" border="0" cellpadding="5" cellspacing="2">
	 <tr>
	   <td class="adminTableItemHeading" width="7%" align="left">Category</td>
	   <td class="adminTableItemHeading" width="8%" align="left">Course</td>
       <td class="adminTableItemHeading" width="8%" align="left">Order ID</td>
	   <td class="adminTableItemHeading" width="7%" align="left">Date</td>
	   <td class="adminTableItemHeading" width="14%" align="left">Name</td>
	   <td class="adminTableItemHeading" width="13%" align="left">Address</td>
	   <td class="adminTableItemHeading" width="10%" align="left">Phone</td>
	   <td class="adminTableItemHeading" width="14%" align="left">Email</td>
	   <td class="adminTableItemHeading" width="6%" align="left">Status</td>
	   <td class="adminTableItemHeading" width="13%" align="left">Registration Date</td>
	   <!--<td width="4%" class="adminTableItemHeading"  align="center">Edit</td>-->
		<td width="4%" class="adminTableItemHeading" align="center">Delete </td>
        </tr>
	<?php 
	$color_flag = 0;
	do {
		$category = get_the_terms($row_item_set['courseID'],'product_cat');?>
	
	<tr <?php if ($row_item_set['regStatus'] == "Paid") {
				echo ('class = "background_approved"');
			} elseif ($row_item_set['regStatus'] == "Pending") { 
				echo ('class = "background_pending"');
			} else { 
				echo ('class = "background_lite"'); 
			} ?> id="regRow<?=$row_item_set['regID']?>">
    <?php
		$mod_query=sprintf("SELECT * FROM course_modifiers WHERE `courseID` = '%s' AND `courseYear` = '%s' AND `courseMonth` = '%s' AND `courseDate` = '%s'",mysql_real_escape_string($row_item_set['courseID']),											mysql_real_escape_string($row_item_set['courseYear']),mysql_real_escape_string($row_item_set['courseMonth']),mysql_real_escape_string($row_item_set['courseDate']));
		//echo $mod_query;
		$mod_set = mysql_query($mod_query) or die(mysql_error());
		$row_mod_set = mysql_fetch_assoc($mod_set);
		
		$post = get_post(mysql_real_escape_string($row_item_set['courseID'])); 
		$custom = get_post_meta(mysql_real_escape_string($row_item_set['courseID']));
		
		if (mysql_num_rows($mod_set) > 0) {
			$courseTitle = stripslashes($row_mod_set['newTitle']);
			$courseDescription = stripslashes($row_mod_set['newDescription']);
			$courseStartHour = stripslashes($row_mod_set['newStartHour']);
			$courseStartMinute = stripslashes($row_mod_set['newStartMinute']);
			$courseStartAMPM = stripslashes($row_mod_set['newStartAMPM']);
			$courseEndHour = stripslashes($row_mod_set['newEndHour']);
			$courseEndMinute = stripslashes($row_mod_set['newEndMinute']);
			$courseEndAMPM = stripslashes($row_mod_set['newEndAMPM']);
			$courseCost = stripslashes($row_mod_set['newCost']);
		} else {
			
			$courseTitle = $post->post_title;
			$courseDescription = $post->post_content;
			$courseStartHour = $custom['courseStartHour'][0];
			$courseStartMinute = $custom['courseStartMinute'][0];
			$courseStartAMPM = $custom['courseStartAMPM'][0];
			$courseEndHour = $custom['courseEndHour'][0];
			$courseEndMinute = $custom['courseEndMinute'][0];
			$courseEndAMPM = $custom['courseEndAMPM'][0];
			
		}								
		
		?>
	  <td align="left" valign="top"  class="tableContent" ><?=stripslashes($category[0]->name)?></td>
	  <td align="left" valign="top"  class="tableContent" ><?=$courseTitle?></td>
      <td align="left" valign="top"  class="tableContent" ><?=$row_item_set['orderID']?></td>
	  <td align="left" valign="top"  class="tableContent" ><?=$row_item_set['courseMonth']?>&nbsp;<?=$row_item_set['courseDate']?>, <?=$row_item_set['courseYear']?></td>
	  <td align="left" valign="top"  class="tableContent" ><?=stripslashes($row_item_set['firstName'])?>&nbsp;<?=stripslashes($row_item_set['lastName'])?></td>
	  <td align="left" valign="top"  class="tableContent" ><?=stripslashes($row_item_set['address'])?>&nbsp;<?=stripslashes($row_item_set['address2'])?><br /><?=stripslashes($row_item_set['city'])?>, <?=stripslashes($row_item_set['state'])?>&nbsp;<?=stripslashes($row_item_set['zip'])?></td>
	  <td align="left" valign="top"  class="tableContent" ><?=stripslashes($row_item_set['phone'])?></td>
	  <td align="left" valign="top"  class="tableContent" ><?=stripslashes($row_item_set['email'])?></td>
	  <td align="left" valign="top"  class="tableContent" ><a href="javascript:toggleStatus('<?=$row_item_set['regID']?>')" id="status<?=$row_item_set['regID']?>"><?=stripslashes($row_item_set['regStatus'])?></a></td>
	  <td align="left" valign="top"  class="tableContent" ><?=date('F j, Y',$row_item_set['regDate'])?></td>
	  <!--<td align="center" valign="top" ><a href="edit<?=ITEM_NAME?>.php?<?=ITEM_ID?>=<?=$row_item_set[ITEM_ID]?>"><img src="images/write.gif" border="0"></a></td>-->
	  <td align="center" valign="top"  class="header_text_16px"><a href="javascript: surePhotoDelete('<?=$row_item_set['regID']?>')"><img src="<?=plugins_url( 'images/Badge-multiply.png', __FILE__ )?>"  border="0" width="20px"/></a></td>
	</tr>
      
	  <?php 
	  if ($color_flag == 1) {
	  	$color_flag = 0;
	  } else {
		$color_flag = 1;
	  }
	  $idx++;
		} while ($row_item_set = mysql_fetch_assoc($item_set));?>
      <tr >
	  <td align="left" valign="top"  class="tableContent" >&nbsp;</td>
	  
      <td align="right" valign="top"  class="tableContent"  bgcolor="#CCCCCC" colspan="2"><strong>Total Registrants</strong></td>
	  <td align="left" valign="top"  class="tableContent" bgcolor="#CCCCCC"><strong>
	    <?=$num_items?>
	  </strong></td>
      <td align="left" valign="top"  class="tableContent" >&nbsp;</td>
	  <td align="left" valign="top"  class="tableContent" >&nbsp;</td>
	  <td align="left" valign="top"  class="tableContent" >&nbsp;</td>
	  <td align="left" valign="top"  class="tableContent" >&nbsp;</td>
	  <td align="left" valign="top"  class="tableContent" >&nbsp;</td>
	  <td align="left" valign="top"  class="tableContent" >&nbsp;</td>
	  <td align="center" valign="top" >&nbsp;</td>
      
	</tr>
    </table>
		<?php } else { echo "No registrations found."; }?></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td valign="top">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table>

    </td>
  </tr>
 
        
      </table>