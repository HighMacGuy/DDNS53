<?php
/**
 * Amazon Route 53 DDNS script.
 *
 * @since 1.0.0
 */
$aws_id     = $_GET[ 'id' ];
$aws_secret = $_GET[ 'secret' ];
$aws_zone   = $_GET[ 'zone' ];

$hostname = $_GET[ 'hostname' ];
$type     = $_GET[ 'type' ];
$new_ip   = $_GET[ 'newip' ];

$old_ip      = '';
$record_type = '';
$record_ttl  = '';
$route53     = '';
$recordSet   = '';

$synology = ( $_GET[ 'synology' ] == '1' ) ? true : false;
$debug    = ( $_GET[ 'debug' ] == '1' ) ? true : false;

/**
 * Required files.
 *
 * @since 1.0.0
 */
require_once( 'r53.php' );

/**
 * Start a new instance.
 *
 * @since 1.0.0
 */
$route53 = new Route53( $aws_id, $aws_secret );

/**
 * Define record set.
 *
 * @since 1.0.0
 */
$recordSet = $route53->listResourceRecordSets( '/hostedzone/' . $aws_zone );

/**
 * Validate the authentication variables.
 *
 * @since 1.0.0
 */
if ( empty( $aws_id ) || empty( $aws_secret ) || empty( $aws_zone ) || empty( $recordSet ) ) {
	
	if ( $synology == true ) {
		exit( '(badauth)' );
	} else {
		exit( 'Failed. Your AWS credentials and Zone ID information is incorrect or incomplete.' );
	}
	
}

/**
 * Search for the old IP address.
 *
 * @since 1.0.0
 */
for ( $i = 0; $i < count( $recordSet[ 'ResourceRecordSets' ] ); $i++ ) {
	
	if ( $debug == true ) {
		echo '<b>Host:</b> ' . $recordSet[ 'ResourceRecordSets' ][$i][ 'Name' ] . '<br />';
		echo '<b>Host Value:</b> ' . $recordSet[ 'ResourceRecordSets' ][$i][ 'ResourceRecords' ][0] . '<br />';
		echo '<b>Type:</b> ' . $recordSet[ 'ResourceRecordSets' ][$i][ 'Type' ] . '<br />';
		echo '<b>TTL (sec):</b> ' . $recordSet[ 'ResourceRecordSets' ][$i][ 'TTL' ] . '<br />';
		echo '<br />';
	}
	
	// Matches the hostname and the type
	if ( $recordSet[ 'ResourceRecordSets' ][$i][ 'Name' ] == $hostname . '.' && $recordSet[ 'ResourceRecordSets' ][$i][ 'Type' ] == $type ) {
		
		$old_ip      = $recordSet[ 'ResourceRecordSets' ][$i][ 'ResourceRecords' ][0];
		$record_type = $recordSet[ 'ResourceRecordSets' ][$i][ 'Type' ];
		$record_ttl  = $recordSet[ 'ResourceRecordSets' ][$i][ 'TTL' ];
		
	}
	
}

/**
 * Process record changes.
 *
 * @since 1.0.0
 */
if ( empty( $old_ip ) ) {
	
	if ( $synology == true ) {
		echo '(nohost)';
	} else {
		echo 'Failed. The hostname (<b>' . $hostname . '</b>) and type (<b>' . $type . '</b>) you specified yielded no results.';
	}
	
} elseif ( empty( $new_ip ) ) {
	
	if ( $synology == true ) {
		echo '(badagent)';
	} else {
		echo 'Failed. A new IP address is required for this script to run.';
	}
	
} elseif ( $old_ip == $new_ip ) {
	
	if ( $synology == true ) {
		echo '(nochg)';
	} else {
		echo 'Failed. The old IP (<b>' . $old_ip . '</b>) is the same as the new IP (<b>' . $new_ip . '</b>).';
	}
	
} else {
	
	$delete = $route53->prepareChange( 'DELETE', $hostname, $record_type, $record_ttl, $old_ip );
	$create = $route53->prepareChange( 'CREATE', $hostname, $record_type, $record_ttl, $new_ip );
	
	$route53->changeResourceRecordSets( '/hostedzone/' . $aws_zone, $delete );
	$route53->changeResourceRecordSets( '/hostedzone/' . $aws_zone, $create );
	
	if ( $synology == true ) {
		echo '(good)';
	} else {
		echo 'Success. The IP address for <b>' . $hostname . '</b> has been updated from <b>' . $old_ip . '</b> to <b>' . $new_ip . '</b>';
	}
	
}