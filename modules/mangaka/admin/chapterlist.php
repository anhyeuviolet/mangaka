<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-9-2010 14:43
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$catid = $nv_Request->get_int( 'catid', 'get', 0 );

global $db, $lang_module, $lang_global, $module_name, $module_data, $op, $global_array_cat, $module_file, $global_config, $nv_Request;

$xtpl = new XTemplate( 'chapterlist.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'GLANG', $lang_global );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
$xtpl->assign('NO_CHAPTER',$lang_module['no_chapter']);
$xtpl->assign('ADD_CHAPTER',NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=content&catid='. $catid);
$xtpl->assign('MANAGE_CHAPTER',NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=chapter_manage');

$page_title = $lang_module['chapter_list']. ' - ' .$global_array_cat[$catid]['title'];
$check_catid = $db->query( 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat WHERE catid= ' . intval($catid))->fetchColumn();
if ( $check_catid > 0 )
{
	$xtpl->assign( 'CATID', $catid );
	$xtpl->assign('CAT_TITLE',$global_array_cat[$catid]['title']);

	$base_url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . '&' . NV_OP_VARIABLE . '='. $op .'&catid=' .intval($catid);
	$page = $nv_Request->get_int( 'page', 'get', 1 );
	$per_page = 20;
	$all_page = $db->query( 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_' . intval($catid) )->fetchColumn();


	$global_array_cat[0] = array( 'alias' => 'Other' );

	$sql = 'SELECT id, catid, title, alias, ROUND(chapter,1) as chapter, edittime, status FROM ' . NV_PREFIXLANG . '_' . $module_data . '_' . intval($catid) . ' ORDER BY chapter ASC LIMIT ' .  ( $page - 1 ) * $per_page . ', ' . $per_page;
	$array_block = $db->query( $sql )->fetchAll();

	$num = sizeof( $array_block );

	$generate_page = nv_generate_page( $base_url, $all_page, $per_page, $page );
	if ( ! empty( $generate_page ) )
	{
		$xtpl->assign( 'GENERATE_PAGE', $generate_page );
		$xtpl->parse( 'main.data.generate_page' );
	}

	if( $nv_Request->get_title( 'action', 'post' ) =='delete' and $nv_Request->isset_request( 'idcheck', 'post' ) )
	{
		$array_id = $nv_Request->get_typed_array( 'idcheck', 'post', 'int' );
		if( defined( 'NV_IS_ADMIN_MODULE' ) or ( isset( $array_cat_admin[$admin_id][$catid] ) and $array_cat_admin[$admin_id][$catid]['add_content'] == 1 ) )
		{
			foreach ($array_id as $id)
			{
				nv_del_content_module( $id );
			}
			nv_del_moduleCache();
			Header( 'Location: '. NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '='. $op .'&catid=' .$catid);
			exit;
			die;
		}
	}

	if( $num > 0 )
	{
		foreach ($array_block as $row)
		{
			$xtpl->assign( 'ROW', array(
				'id' => $row['id'],
				'catid' => $catid,
				'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$row['catid']]['alias'] . '/' . $row['alias'] . '-' . $row['id'] . $global_config['rewrite_exturl'],
				'title' => $row['name'] = !empty($row['title'])?$row['title']:$lang_module['chapter']. ' ' . $row['chapter'],
				'chapter' => $row['chapter'],
				'edittime' => nv_date( "d/m/Y", $row['edittime'] ),
				'status' => $lang_module['status_' . $row['status']],
			) );

			if( defined( 'NV_IS_MODADMIN' ) )
			{
				$xtpl->assign( 'ADMINLINK', nv_link_edit_page( $row['id'] ) . " " . nv_link_delete_page( $row['id'] ) );
				$xtpl->parse( 'main.data.loop.adminlink' );
			}

			$xtpl->parse( 'main.data.loop' );
		}
		$xtpl->parse( 'main.data' );
	}
	else
	{
		$xtpl->parse( 'main.nochapter' );
	}
	$xtpl->parse( 'main' );
	$contents .= $xtpl->text( 'main' );
	$db->sqlreset();
}
else
{
	Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=chapter_manage' );
	die();
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';