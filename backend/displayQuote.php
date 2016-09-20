<?php

use UnitedPrototype\GoogleAnalytics;
//autoload import script
require_once 'php-ga/src/autoload.php';
include "db.inc.php";
include "PDFQuoteDefs.php";

$item_query=sprintf("SELECT * FROM customizations WHERE `customizationID` = '%s'",  $mysqli->real_escape_string($_GET['id']));
//echo $photo_query;
$item_set = $mysqli->query($item_query) or die($mysqli->error);
$row_item_set = $item_set->fetch_assoc();

// check for duplicates
$duplicate_query=sprintf("SELECT * FROM customizations WHERE `email` = '%s'",  $mysqli->real_escape_string($row_item_set['email']));
//echo $photo_query;
$duplicate_set = $mysqli->query($duplicate_query) or die($mysqli->error);
$row_duplicate_set = $duplicate_set->fetch_assoc();

$duplicateQuote = $duplicate_set->num_rows > 1 ? 'Follow Up' : '';

//print_r($jeremyStates);
//echo '<br />'.$row_item_set['state'];
//exit;
$jeremyState = false;
$amyState = false;
$poolState = true;
$filterDisable = false; // the filter send consult invites to leadscores above 4.  Set to "true" to disable 
/*if (in_array($row_item_set['state'],$jeremyStates)) {
    $jeremyState = true;
} else if (in_array($row_item_set['state'],$amyStates)) {
    $poolState = true;
} else {
    $poolState = true;
}*/


$feature_query=sprintf("SELECT * FROM features WHERE `customizationID` = '%s'",  $mysqli->real_escape_string($_GET['id']));
//echo $photo_query;
$feature_set = $mysqli->query($feature_query) or die($mysqli->error);
$row_feature_set = $feature_set->fetch_assoc();
$featureArray = array();
do {
   $featureArray[$row_feature_set['featuregroup']][] = array('feature' => $row_feature_set['feature'], 'featurePrice' => $row_feature_set['featurePrice']); 
} while($row_feature_set = $feature_set->fetch_assoc());

//print_r($featureArray);
//exit;
// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');
//print_r($featureArray);
//exit;

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
       
	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Tumbleweed Tiny House Company  |  www.tumbleweedhouses.com   |  support@tumbleweedhouses.com                                        '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 2, false, 'T', 'M');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor(PDF_AUTHOR);
$pdf->SetTitle('Customized Quote');
$pdf->SetSubject('Customized Quote');
$pdf->SetKeywords('Tumbleweed Customized Quote');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', '', array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('helvetica', '', 12, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
$currentDate = date('F j, Y');

$pdf->SetFont('helvetica', '', 16, '', true);
$html = '<table width="100%" border="0" cellpadding="0" cellspacing="0">';
$html .= '<tr>';
if ($row_item_set['type'] == 'RM') {
    $html .= '<td colspan="2"><strong>Tumbleweed Tiny House RV Custom Quote</strong></td>';
} else {
    $html .= '<td colspan="2"><strong>Tumbleweed Tiny House Barn Raiser Custom Quote</strong></td>';
}
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td colspan="2"></td>';
$html .= '</tr>';
$html .= '</table>';
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->SetFont('helvetica', '', 12, '', true);
// Set some content to print
$html = '<table width="100%" border="0" cellpadding="0" cellspacing="0">';
$html .= '<tr>';
$html .= '<td width="20%" align="left"><strong>Date:</strong></td>';
$html .= '<td width="80%" align="left" colspan="2">'.$currentDate.'</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td width="20%" align="left"><strong>Customer:</strong></td>';
$html .= '<td width="80%" align="left">'.$row_item_set['fname'].' '.$row_item_set['lname'].'</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td width="20%" align="left"><strong>Email:</strong></td>';
$html .= '<td width="80%" align="left" colspan="2">'.$row_item_set['email'].'</td>';
$html .= '</tr>';
if ($row_item_set['phone'] != '') { // if phone number
$html .= '<tr>';
$html .= '<td width="20%" align="left"><strong>Phone:</strong></td>';
$html .= '<td width="80%" align="left" colspan="2">'.$row_item_set['phone'].'</td>';
$html .= '</tr>';
}
$html .= '<tr>';
$html .= '<td colspan="2"></td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td colspan="2"></td>';
$html .= '</tr>';
$html .= '</table>';

//$html = 'Customer: '.$row_item_set['fname'].' '.$row_item_set['lname'].'<br />';
//$html .= 'Email: '.$row_item_set['email'].'<br />';
//$html .= 'Phone: '.$row_item_set['phone'].'<br /><br /><br />';

$html .= '<table width="100%" border="0" cellpadding="0" cellspacing="0">';
$html .= '<tr>';
$html .= '<td width="75%" align="left"><strong>DESCRIPTION</strong></td>';
$html .= '<td width="25%" align="left"><strong>UNIT PRICE</strong></td>';
$html .= '</tr>';

//$groupExcludeArray = array('TOTAL','LEADSCOR','TIMELINE','FINISH','LOCATION','FINANCE');
foreach ($featureArray as $group => $features) {
    if ($group == 'HOUSE' and $row_item_set['type'] == 'RM') {
        $html .= '<tr>';
        $html .= '<td>Model: '.$features[0]['feature'].'</td>';
        $html .= '<td>'.$features[0]['featurePrice'].'</td>';
        $html .= '</tr>';
        
        $html .= '<tr>';
        $html .= '<td>Floorplan: '.$features[1]['feature'].'</td>';
        $html .= '<td>&nbsp;</td>';
        $html .= '</tr>';
        if (count($features) > 2){
            $html .= '<tr>';
            $html .= '<td colspan="2"><strong>Options</strong></td>';
            $html .= '</tr>';
            $idx = 3;
            foreach ($features as $index => $item) {
                if ($index > 1) {
                    $html .= '<tr>';
                    $html .= '<td>'.$item['feature'].'</td>';
                    $html .= '<td>'.$item['featurePrice'].'</td>';
                    $html .= '</tr>';
                }
                $idx++;
            }
        }
    } else {
        
        if (count($features) > 0){
            if ($row_item_set['type'] == 'RM') {
            $html .= '<tr>';
            $html .= '<td colspan="2"></td>';
            $html .= '</tr>';
            
            $html .= '<tr>';
            $html .= '<td colspan="2"><strong>'.strtoupper($group).'</strong></td>';
            $html .= '</tr>';
            }
            $idx = 1;
            if ($group == 'EXTERIOR') { // add included exterior features
                $html .= '<tr>';
                $html .= '<td>Exterior Light</td>';
                $html .= '<td>Standard</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td>Cranks</td>';
                $html .= '<td>Standard</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td>Awning Windows</td>';
                $html .= '<td>Standard</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td>Door Hardware and Door Paint Color</td>';
                $html .= '<td>Standard</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td></td>';
                $html .= '<td></td>';
                $html .= '</tr>';
                
            }
            foreach ($features as $item) {
                $html .= '<tr>';
                $html .= '<td>'.$item['feature'].'</td>';
                $html .= '<td>'.$item['featurePrice'].'</td>';
                $html .= '</tr>';
            }
        }
    }
}
$html .= '<tr>';
$html .= '<td colspan="2"></td>';
$html .= '</tr>';
/*if ($row_item_set['type'] == 'ABR') {
    $html .= '<tr>';
    $html .= '<td><strong>LIMITED TIME DISCOUNT</strong></td>';
    $html .= '<td><strong>-$500</strong></td>';
    $html .= '</tr>';
}*/
$html .= '<tr>';
$html .= '<td><strong>GRAND TOTAL</strong></td>';
$html .= '<td><strong>'.trim(str_replace(array('GRAND TOTAL:','-'),'',$row_item_set['total'])).'</strong></td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td colspan="2"></td>';
$html .= '</tr>';
$html .= '</table>';


        




// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->AddPage();

// Standard features
$html = '<strong>STANDARD FEATURES</strong>';
$html .= '<ul class="ready-ul">';
if ($row_item_set['type'] == 'RM') {
    
    $html .= '<li class="ready-li">Tumbleweed Trailer</li>';
    $html .= '<li class="ready-li">Sheathed underlayment</li>';
    $html .= '<li class="ready-li">Leveling jacks</li>';
    $html .= '<li class="ready-li">All thread rods</li>';
    $html .= '<li class="ready-li">Radial tires</li>';
    $html .= '<li class="ready-li">Cedar, oak and pine woods</li>';
    $html .= '<li class="ready-li">2x4 wall framing</li>';
    $html .= '<li class="ready-li">Sheathing: OSB zipboard</li>';
    $html .= '<li class="ready-li">Subfloor: 3/4" tongue and groove</li>';
    $html .= '<li class="ready-li">AC breaker panel</li>';
    $html .= '<li class="ready-li">DC panel</li>';
    $html .= '<li class="ready-li">Insulation <span class="ready-font-small">(R-20 formaldehyde free icynene polyurethane)</span></li>';
    $html .= '<li class="ready-li">Ring shank nails and screws</li>';
    $html .= '<li class="ready-li">Simpson strong ties</li>';
    $html .= '<li class="ready-li">Hurricane and rafter clips</li>';
    $html .= '<li class="ready-li">Moen fixtures</li>';
    $html .= '<li class="ready-li">Flojet water pump</li>';
    $html .= '<li class="ready-li">PEX water lines</li>';
    $html .= '<li class="ready-li">Gravity type 3" slide valve</li>';
    $html .= '<li class="ready-li">10 gallon water heater</li>';
    $html .= '<li class="ready-li">1-year Workmanship Warranty</li>';
    $html .= '<li class="ready-li">Original Appliance & Material Warranties Applicable</li>';
    $html .= '<li class="ready-li">RVIA Certified Travel Trailer</li>';
} else { // ABR Standard Features
    $html .= '<li class="ready-li"><strong>Building Plans</strong>: Free set of plans with purchase</li>';
    $html .= '<li class="ready-li"><strong>Tumbleweed Trailer</strong>: Includes brakes, lights, underside flashing and more</li>';
    $html .= '<li class="ready-li"><strong>Sub Floor</strong>: Fully insulated floor, embedded in trailer</li>';
    $html .= '<li class="ready-li"><strong>Head Space</strong>: Unique design provides an extra 3.5" of headspace</li>';
    $html .= '<li class="ready-li"><strong>Walls and Roof</strong>: Stick built walls and roof are framed and attached to the trailer</li>';
    $html .= '<li class="ready-li"><strong>Secured</strong>: 8 engineered Simpson Strong tie-downs and engineered strapping</li>';
    $html .= '<li class="ready-li"><strong>Water Resistant</strong>: Framing sheathed in zip boards, an integrated vapor barrier</li>';
    $html .= '<li class="ready-li"><strong>Roof Protected</strong>: Ice and water shielding applied</li>';
    
}
$html .= '</ul>';
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->SetFont('helvetica', '', 16, '', true);
$html = '<table width="100%" border="0" cellpadding="0" cellspacing="0">';
$html .= '<tr>';
$html .= '<td colspan="2"></td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td colspan="2"></td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td colspan="2"><strong>Terms and Conditions</strong></td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td colspan="2"></td>';
$html .= '</tr>';
$html .= '</table>';
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->SetFont('helvetica', '', 12, '', true);
$html = '<table width="100%" border="0" cellpadding="0" cellspacing="0">';
$html .= '<tr>';
$html .= '<td colspan="2">Quote is valid for 30 days. Sales tax is not included.</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td colspan="2"></td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td colspan="2">_____ When buyer initializes quote, buyer accepts the quote and authorizes Tumbleweed to prepare an agreement. Initializing the quote does not constitute an agreement with Tumbleweed.</td>';
$html .= '</tr>';
$html .= '</table>';

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
// ---------------------------------------------------------

// Close and output PDF document
if (!is_dir('quotes/'.$_GET['id'])) {
	mkdir ('quotes/'.$_GET['id']);
}
$pdf->Output('quotes/'.$_GET['id'].'/Tumbleweed Custom Quote.pdf', 'F');
//$pdf->Output('quotes/'.$_GET['id'].'/Tumbleweed Custom Quote.pdf', 'I');

//echo 'Duplicate = '.$duplicateQuote;
//echo 'PDF Quote created';
//exit;
// HTML body

if ($row_item_set['type'] == 'RM') {
    //$ab = rand(1,2);
    $ab = 2;
    if ($ab ==  1) {
        /*$body  = "<p>Hi " .$row_item_set['fname'] . ",</p>";
        $body .= "<p>I've attached your quote as a pdf and linked it <a href=\"http://www2.tinyhouses.org/PDFQuote/quotes/".$_GET['id']."/Tumbleweed Custom Quote.pdf\">here</a>.</p>";
        $body .= "<p>I was wondering if your design is a work in progress or ready to go. The reason I ask is because most people like to do a little bit of customization, and I'm here to help you with that. From additional sleeping lofts, to custom kitchen designs and more.</p>";
        $body .= "<p>Can I give you a call to discuss what you'd like to do with your Tiny Home RV? <a href=\"http://www2.tinyhouses.org/PDFQuote/scheduleConsult.php?rand=a&id=".$_GET['id']."\">Schedule Your Time Here</a></p>";

        $body .= "<p>During our phone consult, we can discuss the issues that are specific to you. It usually takes about 30 minutes and I'll give you advice on questions you likely have that can range from financing to closet space to sleeping in a loft. This is a big decision and it's wise to understand all your options.</p>";

        $body .= "Sincerely, <br>";
        if ($jeremyState) {
            $body .= "Jeremy<br>";
        } else {
            $body .= "Amy<br>";	
        }
        $body .= "Design Consultant<br>";
        $body .= "Tumbleweed Tiny Houses<br>";
        if ($jeremyState) {
            $body .= "(877) 331-8469 x537";
        } else {
            $body .= "(877) 331-8469 x269";	
        }*/
        include "html_email.php";

    } else {
        
        if ($row_item_set['leadscore'] > 4 or $filterDisable) {

            $body  = "<p>Hi " .$row_item_set['fname'] . ",</p>";
            $body .= "<p>I've attached your quote as a pdf and linked it <a href=\"http://www2.tinyhouses.org/PDFQuote/quotes/".$_GET['id']."/Tumbleweed Custom Quote.pdf\">here</a>.</p>";
            $body .= "<p>I was wondering if your design is a work in progress or ready to go. The reason I ask is because most people like to do a little bit of customization, and I'm here to help you with that. From additional sleeping lofts, to custom kitchen designs and more.</p>";
            $body .= "<p>Can I give you a call to discuss what you'd like to do with your Tiny Home RV? <a href=\"http://www2.tinyhouses.org/PDFQuote/scheduleConsult.php?rand=b&id=".$_GET['id']."\">Schedule Your Time Here</a></p>";

            $body .= "<p>During our phone consult, we can discuss the issues that are specific to you. It usually takes about 30 minutes and I'll give you advice on questions you likely have that can range from financing to closet space to sleeping in a loft. This is a big decision and it's wise to understand all your options.</p>";

            $body .= "Sincerely, <br>";
            $body .= "Custom Design Services<br>";
            $body .= "Tumbleweed Tiny Houses<br>";
        } else {
            $body  = "<p>Hi " .$row_item_set['fname'] . ",</p>";
            $body .= "<p>I've attached your quote as a pdf and linked it <a href=\"http://www2.tinyhouses.org/PDFQuote/quotes/".$_GET['id']."/Tumbleweed Custom Quote.pdf\">here</a>.</p>";
            $body .= "<p>If you have more questions, please reply to this email or contact our friendly support staff at 1-877-331-8469</p>";

            $body .= "Sincerely, <br>";
            $body .= "Custom Design Services<br>";
            $body .= "Tumbleweed Tiny Houses<br>";
            
        }


    } // if AB Test
    //echo 'AB= '.$ab;
    //exit;
} else { // ABR Email
    if ($row_item_set['leadscore'] > 4  or $filterDisable) {
        $body  = "<p>Hi " .$row_item_set['fname'] . ",</p>";
        $body .= "<p>I've attached your quote as a pdf and linked it <a href=\"http://www2.tinyhouses.org/PDFQuote/quotes/".$_GET['id']."/Tumbleweed Custom Quote.pdf\">here</a>.</p>";
        $body .= "<p>Can I give you a call to discuss your next steps? <a href=\"http://www2.tinyhouses.org/PDFQuote/scheduleConsult.php?rand=b&id=".$_GET['id']."\">Schedule Your Time Here</a></p>";
        $body .= "<p>During our phone consult, we can discuss the issues that are specific to you. It usually 
            takes about 30 minutes and I'll give you advice on questions you likely have that can range from getting 
            a loan (<a href=\"http://www2.tinyhouses.org/PDFQuote/financeABR.php?id=".$_GET['id']."\">apply here</a>) to insuring your barn raiser to customization options that aren't available online. 
            This is a big decision and it's wise to understand all your options.</p>";

        $body .= "Sincerely, <br>";
        $body .= "Custom Design Services<br>";
        $body .= "Tumbleweed Tiny Houses<br>";
    } else {
        $body  = "<p>Hi " .$row_item_set['fname'] . ",</p>";
        $body .= "<p>I've attached your quote as a pdf and linked it <a href=\"http://www2.tinyhouses.org/PDFQuote/quotes/".$_GET['id']."/Tumbleweed Custom Quote.pdf\">here</a>.</p>";
        $body .= "<p>If you have more questions, please reply to this email or contact our friendly support staff at 1-877-331-8469</p>";

        $body .= "Sincerely, <br>";
        $body .= "Custom Design Services<br>";
        $body .= "Tumbleweed Tiny Houses<br>";
    }
}



// Now mail it as an attachment
require 'PHPMailer/PHPMailerAutoload.php';

// send GA Events //////////////////////////////////////////////////////////////////////////
// Initilize GA Tracker
$tracker = new GoogleAnalytics\Tracker('UA-1771070-1', 'www.tumbleweedhouses.com');

// Assemble Visitor information
// (could also get unserialized from database)
$visitor = new GoogleAnalytics\Visitor();
$visitor->setIpAddress($_SERVER['REMOTE_ADDR']);
$visitor->setUserAgent($_SERVER['HTTP_USER_AGENT']);

// Assemble Session information
// (could also get unserialized from PHP session)
$session = new GoogleAnalytics\Session();


// Assemble Event information
$abTest = ($ab == 1) ? 'html' : 'txt';
if ($jeremyState) {
	$event = new GoogleAnalytics\Event('Consult Booking',$row_item_set['type'].' Quote email '.$abTest.' sent - Jeremy');
} elseif ($amyState) {
	$event = new GoogleAnalytics\Event('Consult Booking',$row_item_set['type'].' Quote email '.$abTest.' sent - Amy');
} else {
	$event = new GoogleAnalytics\Event('Consult Booking',$row_item_set['type'].' Quote email '.$abTest.' sent - Pool');
}

// Track event
$tracker->trackEvent($event, $session, $visitor);

//echo "success1";
//exit;

////////////////////////////////////////////////////////////////////////////////////////////
// Create email for follow up based on customer criteria 
$qbody  = "<p>Hi Design Specialists,</p>";
$qbody .= "<p>Here's a quote!</p>";
$qbody .= "<p><strong>Name: </strong>".$row_item_set['fname'].' '.$row_item_set['lname']."</p>";
$qbody .= "<p><strong>Email: </strong>".$row_item_set['email']."</p>";
$qbody .= "<p>The customer lead score info is: ".$row_item_set['customer']."</p>";

$qbody .= "Thanks! <br>";

//Create a new PHPMailer instance
$mail = new PHPMailer;
//Set who the message is to be sent from
$mail->setFrom($row_item_set['email'], $row_item_set['fname'].' '.$row_item_set['lname']);
//Set who the message is to be sent to
$mail->addAddress('support@tumbleweedhouses.com', 'Support');
//Set the subject line
$mail->Subject = $duplicateQuote.' Quote Received From Customizer';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
$mail->Body = $qbody;
//Replace the plain text body with one created manually
$mail->AltBody = 'Leadscore = '.$row_item_set['leadscore'].' Info:'.$row_item_set['customer'];
//Attach an image file
$mail->addAttachment('quotes/'.$_GET['id'].'/Tumbleweed Custom Quote.pdf');

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
	exit;
}

//Create a new PHPMailer instance
$mail = new PHPMailer;
//Set who the message is to be sent from
$mail->setFrom('<tinyhous@box268.bluehost.com>', 'Tumbleweed Tiny Houses');
//Set who the message is to be sent to
$mail->addAddress('support@tumbleweedhouses.com', 'Support');
//Set the subject line
$mail->Subject = $duplicateQuote.' Quote Received From Customizer - '.$row_item_set['fname'].' '.$row_item_set['lname'];
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
$mail->Body = $qbody;
//Replace the plain text body with one created manually
$mail->AltBody = 'Leadscore = '.$row_item_set['leadscore'].' Info:'.$row_item_set['customer'];
//Attach an image file
$mail->addAttachment('quotes/'.$_GET['id'].'/Tumbleweed Custom Quote.pdf');

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
	exit;
}

if ($row_item_set['leadscore'] > 4 and $row_item_set['phone'] != '') {
    
    //$mail->addAddress('michael.nelson@techeffex.com', 'Mike Nelson');
    //Create a new PHPMailer instance
    $mail = new PHPMailer;
    //Set who the message is to be sent from
    //$mail->setFrom($row_item_set['email'], $row_item_set['fname'].' '.$row_item_set['lname']);
    //Set who the message is to be sent to
    $mail->addAddress('kevin.gainey@tumbleweedhouses.com', 'Kevin Gainey');
    //Set the subject line
    $mail->Subject = 'Quote Received From Customizer - '.$row_item_set['fname'].' '.$row_item_set['lname'];
    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
    $mail->Body = $qbody;
    //Replace the plain text body with one created manually
    $mail->AltBody = 'Leadscore = '.$row_item_set['leadscore'].' Info:'.$row_item_set['customer'];
    //Attach an image file
    $mail->addAttachment('quotes/'.$_GET['id'].'/Tumbleweed Custom Quote.pdf');

    //send the message, check for errors
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
            exit;
    }
}

//Create a new PHPMailer instance
/*$mail = new PHPMailer;
//Set who the message is to be sent from
//$mail->setFrom($row_item_set['email'], $row_item_set['fname'].' '.$row_item_set['lname']);
//Set who the message is to be sent to
$mail->addAddress('mike@tumbleweedhouses.com', 'Support');
//Set the subject line
$mail->Subject = 'Quote Received From Customizer';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
$mail->Body = $qbody;
//Replace the plain text body with one created manually
$mail->AltBody = 'Leadscore = '.$row_item_set['leadscore'].' Info:'.$row_item_set['customer'];
//Attach an image file
$mail->addAttachment('quotes/'.$_GET['id'].'/Tumbleweed Custom Quote.pdf');

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
	exit;
}*/

////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////
// Create email for follow up based on customer criteria 
$kbody  = "<p>Hi Jarred,</p>";
$kbody .= "<p>This prospect has indicated less than 6 months timeframe and already has a location, making them a well qualified lead.</p>";
if ($jeremyState) {
$kbody .= "<p>This lead is assigned to Jeremy</p>";	
} else {
$kbody .= "<p>This lead is assigned to Amy</p>";		
}
$kbody .= "<p>The customer lead score info is: ".$row_item_set['customer']."</p>";
$kbody .= "<p>Can you follow up to see if they have booked a consult?</p>";

$kbody .= "Thanks! <br>";

if (strpos($row_item_set['customer'], 'Timeline: 0 - 6 mo.  - Location: Yes') !== false) {
//Create a new PHPMailer instance
$mail = new PHPMailer;
//Set who the message is to be sent from
$mail->setFrom('info@tumbleweedhouses.com');
//Set who the message is to be sent to
$mail->addAddress('jarred.ehart@tumbleweedhouses.com', 'Jarred Ehart');
//Set the subject line
$mail->Subject = 'A Highly Qualified Lead Just Received a Quote';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
$mail->Body = $kbody;
//Replace the plain text body with one created manually
$mail->AltBody = 'Here is your Tumbleweed Tiny House RV Custom Quote';
//Attach an image file
$mail->addAttachment('quotes/'.$_GET['id'].'/Tumbleweed Custom Quote.pdf');

//send the message, check for errors
/*if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
	//exit;
}*/
} // if customer data indicates strong lead
////////////////////////////////////////////////////////////////////////////////////////////
//Create a new PHPMailer instance
$mail = new PHPMailer;
//Set who the message is to be sent from
if ($jeremyState){
    $mail->setFrom('jeremy@tumbleweedhouses.com', 'Tumbleweed Houses');
} elseif ($amyState){
    $mail->setFrom('amy@tumbleweedhouses.com', 'Tumbleweed Houses');
} else {
    $mail->setFrom('quotes@tinyhouses.org', 'Tumbleweed Tiny Houses');
}
//Set who the message is to be sent to
$mail->addAddress($row_item_set['email'], $row_item_set['fname'].' '.$row_item_set['lname']);

//Set the subject line
if ($row_item_set['type'] == 'RM') {
    $mail->Subject = 'Your Tumbleweed Tiny House RV Custom Quote';
} else {
    $mail->Subject = 'Your Tumbleweed Tiny House Barn Raiser Custom Quote'; 
}
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

$mail->Body = $body;
//Replace the plain text body with one created manually
$mail->AltBody = 'Here is your Tumbleweed Tiny House RV Custom Quote';
//Attach an image file
$mail->addAttachment('quotes/'.$_GET['id'].'/Tumbleweed Custom Quote.pdf');

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
    exit;
} else {
    if (isset($_GET['dev'])) {
        echo 'Done';
        exit;
        header("Location: http://tumbleweed-tiny-houses-dev.myshopify.com/pages/thank-you/?id=".$_GET['id']);
    } else {
        if ($row_item_set['type'] == 'RM') {
            if ($jeremyState){
                header("Location: http://tumbleweedhouses.com/pages/thank-you-rv-region2/?id=".$_GET['id']);
            } elseif ($amyState){
                header("Location: http://tumbleweedhouses.com/pages/thank-you-rv-region1/?id=".$_GET['id']);
            } else {
                if ($row_item_set['leadscore'] > 4  or $filterDisable) {
                    header("Location: http://tumbleweedhouses.com/pages/thank-you-rv-pool/?id=".$_GET['id']);
                } else {
                    header("Location: http://tumbleweedhouses.com/pages/thank-you-rv-lowls/?id=".$_GET['id']);
                }
            }
        } else {
            if ($jeremyState){
                header("Location: http://tumbleweedhouses.com/pages/thank-you-br-region2/?id=".$_GET['id']);
            } elseif ($amyState){
                header("Location: http://tumbleweedhouses.com/pages/thank-you-br-region1/?id=".$_GET['id']);
            } else {
                if ($row_item_set['leadscore'] > 4  or $filterDisable) {
                    header("Location: http://tumbleweedhouses.com/pages/thank-you-br-pool/?id=".$_GET['id']); 
                } else {
                    header("Location: http://tumbleweedhouses.com/pages/thank-you-br-lowls/?id=".$_GET['id']);
                }
            }
        }
    }
    exit;
}

//============================================================+
// END OF FILE
//============================================================+
