<?php

/**
 * @Project MANGA ON NUKEVIET 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 05/07/2010 09:47
 */

if( ! defined( 'NV_ADMIN' ) or ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

$module_version = array(
	'name' => 'Mangas', // Tieu de module
	'modfuncs' => 'main,viewcat,groups,detail,search,content,rss', // Cac function co block
	'change_alias' => 'groups,content,rss',
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