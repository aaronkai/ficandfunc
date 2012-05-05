<?php
// include the flag function
@ require_once (dirname(dirname(__FILE__)). '/flag-config.php');
if ( empty( $_SERVER['HTTP_REFERER'] ) ) {
	die('0');
} else {
	$ref = $_SERVER['HTTP_REFERER'];
	if ( false === strpos( $ref, get_home_url() ) ) {
		$homeUrl = get_home_url();
		echo 'referer:'.$_SERVER['HTTP_REFERER']."\n";
		echo 'homeUrl:'.$homeUrl."\n";
		die('-1');
	}
}
$upd = array('pid'=>false,'vote'=>false,'hit'=>false,'reset'=>false);
if ( isset($_POST['vote'])) {
	$vote = abs( intval($_POST['vote']) );
	$upd['pid'] = $vote;
	$upd['vote'] = 1;
}
if ( isset($_POST['hit']) ) {
	$hit = abs( intval($_POST['hit']) );
	$upd['pid'] = $hit;
	$upd['hit'] = 1;
}
if(!$upd['pid']){
	die('no picture id');
}
if( $upd['pid'] && ($upd['hit'] || $upd['vote']) ) {
	flag_update_counter($upd);
}
$pid = $upd['pid'];
$result = $wpdb->get_results( "SELECT hitcounter, total_votes FROM $wpdb->flagpictures WHERE `pid` = $pid" );
$rt=array(24.5, 45.7, 54.8, 59.3, 64.7, 68.9, 71.5, 73.7, 75.9, 77.1);
$hits = intval($result[0]->hitcounter);
$votes = intval($result[0]->total_votes);

if($votes==0){
	$like = 0.0;
}else if($votes<11){
	$like = $rt[$votes-1];
}else{
	$like = round( ((100-$rt[count($rt)-1])/($hits>0?$hits:1))*($votes<=$hits?$votes:$hits), 1 ) + $rt[count($rt)-1];
}

echo $hits.'~'.$like.'~'.$votes;

/**
 * Update image hitcounter in the database
 *
 * @param int $pid   id of the image
 * @param string | int $galleryid
 */
function flag_update_counter($upd) {
	global $wpdb;

	if ( $pid = abs( intval($upd['pid']) ) ){
		if($upd['reset'] == false){
			if( $upd['hit'] ){
				$wpdb->query( "UPDATE $wpdb->flagpictures SET `hitcounter` = `hitcounter`+1 WHERE pid = $pid" );
			}
			if( $upd['vote'] ){
				$wpdb->query( "UPDATE $wpdb->flagpictures SET `total_votes` = IF(hitcounter > total_votes, total_votes+1, hitcounter) WHERE pid = $pid" );
			}
		} else {
			if( $upd['hit'] ){
				$hit = abs( intval($upd['hit']) );
				$wpdb->query( "UPDATE $wpdb->flagpictures SET `hitcounter` = $hit WHERE pid = $pid" );
			}
			if( $upd['vote'] == 1 ){
				$vote = abs( intval($upd['vote']) );
				$wpdb->query( "UPDATE $wpdb->flagpictures SET `total_votes` = IF(hitcounter > $vote, $vote, hitcounter) WHERE pid = $pid" );
			}
		}
	}

}
?>