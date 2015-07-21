<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 - 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 08 Apr 2012 00:00:00 GMT GMT
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );


// Tong so Manga
$total_manga = $db->query( 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat' )->fetchColumn();
if(!$total_manga)
{
	$total_manga = $lang_module['updating'];
}
// Tong so chapter
$total_chapter = $db->query( 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows' )->fetchColumn();
if(!$total_chapter)
{
	$total_chapter = $lang_module['updating'];
}
// Tong luot xem
$total_view = $db->query( 'SELECT SUM(	hitstotal ) as total_view FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows')->fetchColumn();
if(!$total_view)
{
	$total_view = $lang_module['updating'];
}

$xtpl = new XTemplate( 'main.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'GLANG', $lang_global );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );

$xtpl->assign( 'LINK', array(
			'manage_manga' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=cat_manage',
			'manage_chapter' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=chapter_manage',
			'add_chapter' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=content',
			'manage_genre' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=groups',
			'tool_upload' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=uploads',
			'tool_leech' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=leecher',
) );

if(  defined( 'NV_IS_ADMIN_MODULE' ) )
{
	$xtpl->parse( 'main.tools' );
}
$xtpl->assign( 'TOTAL_MANGA', $total_manga );
$xtpl->assign( 'TOTAL_CHAP', $total_chapter );
$xtpl->assign( 'TOTAL_VIEW', $total_view );

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';