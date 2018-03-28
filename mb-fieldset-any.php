<?php
/*
Plugin Name:    MB Fieldset Any
Plugin URI:     https://github.com/karrirasinmaki/mb-fieldset-any
Description:    New field type "fieldset_any" for Meta Box.
Version:        20180327
Author:         Intraktio Ltd
Author URI:     https://intraktio.com
License:        MIT
Domain Path:    /languages
 */


function init_mb_fieldset_any() {
	include 'rwmb_fieldset_any_field.php';
}

add_action( 'init', 'init_mb_fieldset_any' );
