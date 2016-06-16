<?php

/**
 * @Project MANGA ON NUKEVIET 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 05/07/2010 09:47
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

include NV_ROOTDIR . '/modules/' . $module_name . '/dom.php';

$action =  $nv_Request->get_int( 'action', 'post', 0 );
$fcheckss = $nv_Request->get_string( 'checkss', 'post', 0 );
$checkss = md5( $admin_info['userid'] . session_id() . $global_config['sitekey']);

$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_LANG_VARIABLE', NV_LANG_VARIABLE );
$xtpl->assign( 'NV_LANG_DATA', NV_LANG_DATA );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
$xtpl->assign( 'CHECKSS', $checkss );

// List of Get Chap Config
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_get_chap ORDER BY title ASC';
$result = $db->query( $sql );
while( list($str_id, $str_title) = $result->fetch( 3 ) )
{
	$get_list['id'] = $str_id;
	$get_list['title'] = $str_title;
	if(!empty($get_list))
	{
		$xtpl->assign( 'GETLIST', $get_list );
	}
	$xtpl->parse( 'main.getlist_loop_list' );
	$xtpl->parse( 'main.getlist_loop_chap' );
}
unset($sql);


// Cac chu de co quyen han
$array_cat_check_content = array();
foreach( $global_array_cat as $catid_i => $array_value )
{
	if( defined( 'NV_IS_ADMIN_MODULE' ) )
	{
		$array_cat_check_content[] = $catid_i;
	}
	elseif( isset( $array_cat_admin[$admin_id][$catid_i] ) )
	{
		if( $array_cat_admin[$admin_id][$catid_i]['admin'] == 1 )
		{
			$array_cat_check_content[] = $catid_i;
		}
		elseif( $array_cat_admin[$admin_id][$catid_i]['add_content'] == 1 )
		{
			$array_cat_check_content[] = $catid_i;
		}
		elseif( $array_cat_admin[$admin_id][$catid_i]['pub_content'] == 1 )
		{
			$array_cat_check_content[] = $catid_i;
		}
		elseif( $array_cat_admin[$admin_id][$catid_i]['edit_content'] == 1 )
		{
			$array_cat_check_content[] = $catid_i;
		}
	}
}


$sql = 'SELECT catid, title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat ORDER BY title ASC';
$rowall = $db->query( $sql )->fetchAll( 3 );
foreach ($rowall as $row)
{
	list( $catid, $title ) = $row;
	if( defined( 'NV_IS_ADMIN_MODULE' ) or ( isset( $array_cat_admin[$admin_id][$catid] ) and $array_cat_admin[$admin_id][$catid]['add_content'] == 1 ) )
	{
		$check_show = 1;
	}
	else
	{
		$array_cat = GetCatidInParent( $catid );
		$check_show = array_intersect( $array_cat, $array_cat_check_content );
	}
	if( ! empty( $check_show ) )
	{
		$xtpl->assign( 'CAT', array(
			'catid' => $catid,
			'title' => $title
		) );
		$xtpl->parse( 'main.catloop' );
	}
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

$page_title = $lang_module['getchap'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';