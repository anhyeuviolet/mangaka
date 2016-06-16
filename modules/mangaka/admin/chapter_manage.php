<?php

/**
 * @Project MANGA ON NUKEVIET 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 05/07/2010 09:47
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
$catid = $nv_Request->get_int( 'catid', 'get', 0 );

if( $catid > 0 ){
	$xtpl = new XTemplate( 'chapter_manage.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
	$page_title = $lang_module['chapter_list']. ' - ' .$global_array_cat[$catid]['title'];

	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'GLANG', $lang_global );
	$xtpl->assign( 'SHOW_CHAPTER', nv_show_list_chapter($catid, $page = 1) );
	$xtpl->parse( 'chapter_main' );
	
	$contents = $xtpl->text( 'chapter_main' );

	include NV_ROOTDIR . '/includes/header.php';
	echo nv_admin_theme( $contents );
	include NV_ROOTDIR . '/includes/footer.php';
}
else{
	$page_title = $lang_module['chapter_manage'];
	$base_url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . '&' . NV_OP_VARIABLE . '=chapter_manage';

	global $db, $lang_module, $lang_global, $module_name, $module_data, $array_viewcat_full, $array_viewcat_nosub, $array_cat_admin, $global_array_cat, $admin_id, $global_config, $module_file;

	$xtpl = new XTemplate( 'chapter_manage.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'GLANG', $lang_global );
	// Phan trang cho danh sach
	$page = $nv_Request->get_int( 'page', 'get', 1 );
	$per_page = 20;
	$all_page = $db->query( 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat' )->fetchColumn();

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

	$sql = 'SELECT catid, title, last_update FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat ORDER BY title ASC LIMIT ' .  ( $page - 1 ) * $per_page . ', ' . $per_page;
	$rowall = $db->query( $sql )->fetchAll( 3 );
	$num = sizeof( $rowall );
	$a = 1;
	if ($page > 1) $a = 1 + (( $page - 1 ) * $per_page);

	foreach ($rowall as $row)
	{
		list( $catid, $title, $last_update ) = $row;
		if( defined( 'NV_IS_ADMIN_MODULE' ) or ( isset( $array_cat_admin[$admin_id][$catid] ) and $array_cat_admin[$admin_id][$catid]['add_content'] == 1 ) )
		{
			$check_show = 1;
		}
		else
		{
			$array_cat = GetCatidInParent( $catid );
			$check_show = array_intersect( $array_cat, $array_cat_check_content );
		}

		//Tong so chapter, Tong luot xem, Chuong moi nhat
		$sql = 'SELECT COUNT(*) as total_chapter, SUM(hitstotal) as total_view, MAX(chapter*1) as last_chapter FROM ' . NV_PREFIXLANG . '_' . $module_data . '_' . $catid;
		$rowall = $db->query( $sql )->fetchAll( 3 );
		foreach ($rowall as $row)
		{
			list( $total_chapter, $total_view, $last_chapter ) = $row;
		}
		
		if( ! empty( $check_show ) )
		{
			$xtpl->assign( 'ROW', array(
				'catid' => $catid,
				'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=chapter_manage&amp;catid=' . $catid,
				'title' => $title,
				'last_chapter' => $last_chapter,
				'last_update' => nv_date( "H:i - d/m/Y", $last_update),
				'total_chapter' => $total_chapter,
				'total_view' => $total_view
			) );
				$xtpl->assign( 'STT', $a );
				$xtpl->parse( 'main.data.loop.stt' );
			$xtpl->parse( 'main.data.loop' );
			++$a;
		}
	}
	$db->sqlreset();
	// Phan trang cho danh sach
	$generate_page = nv_generate_page( $base_url, $all_page, $per_page, $page );
	if ( ! empty( $generate_page ) )
	{
		$xtpl->assign( 'GENERATE_PAGE', $generate_page );
		$xtpl->parse( 'main.data.generate_page' );
	}

	if( $num > 0 )
	{
		$xtpl->parse( 'main.data' );
	}
	else
	{
		Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=cat' );
		die();
	}

	$xtpl->parse( 'main' );
	$contents .= $xtpl->text( 'main' );

	include NV_ROOTDIR . '/includes/header.php';
	echo nv_admin_theme( $contents );
	include NV_ROOTDIR . '/includes/footer.php';
}