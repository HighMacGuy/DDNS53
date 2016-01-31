<?php /* Amazon Route 53 DDNS URL Script
------------------------------------------------------- */
$aws_id  = $_GET['id'];
$aws_secret = $_GET['secret'];
$aws_zone = $_GET['zone'];

$the_host = $_GET['hostname'];
$new_ip = $_GET['myip'];

$old_ip = '';
$record_type = '';
$record_ttl = '';
$route53 = '';
$recordSet = '';

/* Script Starts Below
------------------------------------------------------- */
require_once('r53.php');

// Check variables
if($aws_id == '' && $aws_secret == '') {
	exit('Failed (badauth). Please define your AWS credentials then try accessing this script again.');
}

// Start a new Route53 Class
$route53 = new Route53($aws_id, $aws_secret);

// Define record set
$recordSet = $route53->listResourceRecordSets('/hostedzone/' . $aws_zone);

// Search for the Old IP address
for($i = 0; $i < count($recordSet['ResourceRecordSets']); $i++) {
	
	if($recordSet['ResourceRecordSets'][$i]['Name'] == $the_host . '.') {
		
		$old_ip			= $recordSet['ResourceRecordSets'][$i]['ResourceRecords'][0];
		$record_type	= $recordSet['ResourceRecordSets'][$i]['Type'];
		$record_ttl		= $recordSet['ResourceRecordSets'][$i]['TTL'];
		
	}
	
}

// Process record changes
if($old_ip == '') {
	
	exit('Failed (nohost). The old IP address was not detected for <b>' . $the_host . '</b>.');
	
} elseif($new_ip == '') {
    
    exit('Failed (badagent). A new IP address is required for this script to run.');
    
} elseif($old_ip == $new_ip) {
	
	exit('Success (nochg). The old IP (<b>' . $old_ip . '</b>) is the same as the new IP (<b>' . $new_ip . '</b>).');
	
} else {
	
	$delete = $route53->prepareChange('DELETE', $the_host, $record_type, $record_ttl, $old_ip);
	$create = $route53->prepareChange('CREATE', $the_host, $record_type, $record_ttl, $new_ip);
	
	$route53->changeResourceRecordSets('/hostedzone/' . $aws_zone, $delete);
	$route53->changeResourceRecordSets('/hostedzone/' . $aws_zone, $create);
	
	exit('Success (good). The IP address for <b>' . $the_host . '</b> has been updated to <b>' . $new_ip . '</b> from <b>' . $old_ip . '</b>');
	
}