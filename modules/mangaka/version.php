<?php

/**
 * @Project MANGA ON NUKEVIET 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @License GNU/GPL version 2 or any later version
 * @Createdate 15/06/2015 21:43
 */

if( ! defined( 'NV_ADMIN' ) or ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

$module_version = array(
	'name' => 'Mangaka', // Tieu de module
	'modfuncs' => 'main,viewcat,groups,detail,rss,suggest', // Cac function co block
	'change_alias' => 'groups,viewcat,rss',
	'submenu' => 'content,rss,search',
	'is_sysmod' => 0, // 1:0 => Co phai la module he thong hay khong
	'virtual' => 1, // 1:0 => Co cho phep ao hao module hay khong
	'version' => '1.0.00', // Phien ban cua modle
	'date' => 'Wed, 20 May 2015 00:00:00 GMT', // Ngay phat hanh phien ban
	'author' => 'KENNYNGUYEN (nguyentiendat713@gmail)', // Tac gia
	'note' => '', // Ghi chu
	'uploads_dir' => array( $module_name, $module_name . '/chapter', $module_name . '/temp_pic', $module_name . '/cover' ),
	'files_dir' => array( $module_name . '/cover' )
);