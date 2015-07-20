<?php

/**
 * @Project MANGA ON NUKEVIET 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 15/07/2015 10:51
 */

	$xtpl = new XTemplate( 'viewcat_list.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );

	$catid = $nv_Request->get_int( 'catid', 'get', 0 );
	$page = $nv_Request->get_int( 'page', 'get', 1 );
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&ajax=1&catid='.$catid;
	$ajax = $nv_Request->get_int( 'ajax', 'get', 0 );

if( $ajax )
{
	//List chapter of Category
	$order_by =  'chapter DESC';
	$db->sqlreset()
		->select( 'COUNT(*)' )
		->from( NV_PREFIXLANG . '_' . $module_data . '_' . $catid )
		->where( 'status=1' );
	$num_items = $db->query( $db->sql() )->fetchColumn();

	$db->select( 'id, title, alias, chapter, publtime' )
		->order( $order_by )
		->limit( $per_page )
		->offset( ( $page - 1 ) * $per_page );
	$result = $db->query( $db->sql() );
	while( $item = $result->fetch() )
	{
		$item['link'] = $global_array_cat[$catid]['link'] . '/' . $item['alias'] . '-' . $item['id'] . $global_config['rewrite_exturl'];
		$item['publtime'] = nv_date( 'd/m/Y', $item['publtime'] );
		$item['chapter'] = round($item['chapter'],1);
		$xtpl->clear_autoreset();
		$xtpl->assign( 'CONTENT', $item );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->set_autoreset();
		$xtpl->parse( 'viewcat_ajax.loop' );
	}
	$generate_page = nv_generate_page ( $base_url, $num_items, $per_page, $page, 'true', 'false', 'nv_urldecode_ajax', 'chapter_content' );
	
	if( !empty( $generate_page ) )
	{
		$xtpl->assign( 'PAGE', $generate_page );
		$xtpl->parse( 'viewcat_ajax.generate_page' );
	}
	
	$xtpl->parse( 'viewcat_ajax' );
	$contents = $xtpl->text( 'viewcat_ajax' );
	echo $contents;
	die();
}