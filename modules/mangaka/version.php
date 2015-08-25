<?php

/**
 * @Project MANGA ON NUKEVIET 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @License GNU/GPL version 2 or any later version
 * @Createdate 24/07/2015 10:51
 */

if( ! defined( 'NV_ADMIN' ) or ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

$module_version = array(
	'name' => 'Mangaka', 
	'modfuncs' => 'main,viewcat,viewcat_ajax,groups,detail,rss,suggest', 
	'change_alias' => 'groups,viewcat,rss',
	'submenu' => 'content,rss,search',
	'is_sysmod' => 0, 
	'virtual' => 1, 
	'version' => '1.4.08', 
	'date' => 'Fri, 24 July 2015 00:00:00 GMT', 
	'author' => 'KENNYNGUYEN (nguyentiendat713@gmail)', 
	'note' => '', 
	'uploads_dir' => array( $module_name, $module_name . '/temp_pic', $module_name . '/cover',$module_name . '/genre' ),
	'files_dir' => array( $module_name . '/cover' )
);