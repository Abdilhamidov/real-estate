<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Helper functions
 */
if ( ! function_exists( 'ppr' ) ) :
	function ppr($_arr, $_ar_name){
		echo "<pre>$_ar_name<br>";
		print_r($_arr);
		echo "</pre>";
	}
endif;

if ( ! function_exists( 'fppr' ) ) :
	function fppr($_arr, $_ar_name, $_log_name=false, $append=FILE_APPEND){
		$_log_name = ($_log_name) ? $_log_name : "rlog";
		$str = date("d.m.y H:m:s") . "\r\n" . $_ar_name . "\r\n" . print_r($_arr, true) . "\r\n-------------------\r\n";
		file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/wp-content/uploads/'.$_log_name.'.log', $str, $append);
	}
endif;
