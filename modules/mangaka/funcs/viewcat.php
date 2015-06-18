<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 3-6-2010 0:14
 */

if( ! defined( 'NV_IS_MOD_NEWS' ) ) die( 'Stop!!!' );

$cache_file = '';
$contents = '';
$viewcat = $global_array_cat[$catid]['viewcat'];

$base_url_rewrite = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$catid]['alias'];
if( $page > 1 )
{
	$base_url_rewrite .= '/page-' . $page;
}
$base_url_rewrite = nv_url_rewrite( $base_url_rewrite, true );
if( $_SERVER['REQUEST_URI'] != $base_url_rewrite and NV_MAIN_DOMAIN . $_SERVER['REQUEST_URI'] != $base_url_rewrite )
{
	Header( 'Location: ' . $base_url_rewrite );
	die();
}
$set_view_page = ( $page > 1 and substr( $viewcat, 0, 13 ) == 'viewcat_main_' ) ? true : false;
if( ! defined( 'NV_IS_MODADMIN' ) and $page < 5 )
{
	if( $set_view_page )
	{
		$cache_file = NV_LANG_DATA . '_' . $module_info['template'] . '_' . $op . '_' . $catid . '_page_' . $page . '_' . NV_CACHE_PREFIX . '.cache';
	}
	else
	{
		$cache_file = NV_LANG_DATA . '_' . $module_info['template'] . '_' . $op . '_' . $catid . '_' . $page . '_' . NV_CACHE_PREFIX . '.cache';
	}
	if( ( $cache = nv_get_cache( $module_name, $cache_file ) ) != false )
	{
		$contents = $cache;
	}
}
$page_title = $global_array_cat[$catid]['title'];
$key_words = $global_array_cat[$catid]['keywords'];
$description = $global_array_cat[$catid]['description'];
$global_array_cat[$catid]['description'] = $global_array_cat[$catid]['descriptionhtml'];
if( ! empty($global_array_cat[$catid]['image']))
{
	$meta_property['og:image'] = NV_MY_DOMAIN . NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/' . $global_array_cat[$catid]['image'];
}

if( empty( $contents ) )
{
	$array_catpage = array();
	$array_cat_other = array();
	$base_url = $global_array_cat[$catid]['link'];
	$show_no_image = $module_config[$module_name]['show_no_image'];

	if( $viewcat == 'viewcat_page_new' or $viewcat == 'viewcat_page_old' or $set_view_page )
	{
		$order_by = 'chapter DESC';

		$db->sqlreset()
			->select( 'COUNT(*)' )
			->from( NV_PREFIXLANG . '_' . $module_data . '_' . $catid )
			->where( 'status=1' );

		$num_items = $db->query( $db->sql() )->fetchColumn();

		$db->select( 'id, listcatid, topicid, admin_id, author, sourceid, addtime, edittime, publtime, title, alias, hometext, homeimgfile, homeimgalt, homeimgthumb, allowed_rating, hitstotal, hitscm, total_rating, click_rating, chapter' )
			->order( $order_by )
			->limit( $per_page )
			->offset( ( $page - 1 ) * $per_page );
		$result = $db->query( $db->sql() );
		$end_publtime = 0;
		while( $item = $result->fetch() )
		{
			if( $item['homeimgthumb'] == 1 ) //image thumb
			{
				$item['imghome'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_name . '/' . $item['homeimgfile'];
			}
			elseif( $item['homeimgthumb'] == 2 ) //image file
			{
				$item['imghome'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/' . $item['homeimgfile'];
			}
			elseif( $item['homeimgthumb'] == 3 ) //image url
			{
				$item['imghome'] = $item['homeimgfile'];
			}
			elseif( ! empty( $show_no_image ) ) //no image
			{
				$item['imghome'] = NV_BASE_SITEURL . $show_no_image;
			}
			else
			{
				$item['imghome'] = '';
			}
			$item['newday'] = $global_array_cat[$catid]['newday'];
			$item['link'] = $global_array_cat[$catid]['link'] . '/' . $item['alias'] . '-' . $item['id'] . $global_config['rewrite_exturl'];
			$array_catpage[] = $item;
			$end_publtime = $item['publtime'];
		}
		$db->sqlreset()
			->select( 'id, listcatid, addtime, edittime, publtime, title, alias, hitstotal' )
			->from( NV_PREFIXLANG . '_' . $module_data . '_' . $catid )
			->order( $order_by )
			->limit( $st_links );
		if( $viewcat == 'viewcat_page_new' )
		{
			$db->where( 'status=1 AND publtime < ' . $end_publtime );
		}
		else
		{
			$db->where( 'status=1 AND publtime > ' . $end_publtime );
		}
		$result = $db->query( $db->sql() );
		while( $item = $result->fetch() )
		{
			$item['newday'] = $global_array_cat[$catid]['newday'];
			$item['link'] = $global_array_cat[$catid]['link'] . '/' . $item['alias'] . '-' . $item['id'] . $global_config['rewrite_exturl'];
			$array_cat_other[] = $item;
		}

		$generate_page = nv_alias_page( $page_title, $base_url, $num_items, $per_page, $page );
		$contents = viewcat_page_new( $array_catpage, $array_cat_other, $generate_page );
	}
	elseif( $viewcat == 'viewcat_list_new' or $viewcat == 'viewcat_list_old' ) // Xem theo danh sach
	{
		$order_by =  'chapter DESC';

		$db->sqlreset()
			->select( 'COUNT(*)' )
			->from( NV_PREFIXLANG . '_' . $module_data . '_' . $catid )
			->where( 'status=1' );
		$num_items = $db->query( $db->sql() )->fetchColumn();

		$db->select( 'id, title, alias, chapter, publtime' )
			->order( $order_by );
			// ->limit( $per_page )
			// ->offset( ( $page - 1 ) * $per_page );
		$result = $db->query( $db->sql() );
		while( $item = $result->fetch() )
		{
			$item['link'] = $global_array_cat[$catid]['link'] . '/' . $item['alias'] . '-' . $item['id'] . $global_config['rewrite_exturl'];
			$array_catpage[] = $item;
		}
		$bid = $global_array_cat[$catid]['bid'];
		$bid_array = explode( ',', $bid );
		$array_cat_block = array();
		if(  !empty( $bid_array ) )
		{
			foreach( $bid_array as $id )
			{
				if( intval( $id ) != 0 )
				{
					$array_cat_block[] = $global_array_block[$id];
				}
			
			}
		}
		// comment
		if( isset( $site_mods['comment'] ) and isset( $module_config[$module_name]['activecomm'] ) )
		{
			define( 'NV_COMM_ID',  $global_array_cat[$catid]['catid'] );//ID bài viết hoặc
			define( 'NV_COMM_AREA', $module_info['funcs'][$op]['func_id'] );//để đáp ứng comment ở bất cứ đâu không cứ là bài viết
			//check allow comemnt
			$allowed = $module_config[$module_name]['allowed_comm'];//tuy vào module để lấy cấu hình. Nếu là module news thì có cấu hình theo bài viết
			if( $allowed == '-1' )
			{
			   $allowed = $global_array_cat[$catid]['allowed_comm'];
			}
			define( 'NV_PER_PAGE_COMMENT', 5 ); //Số bản ghi hiển thị bình luận
			require_once NV_ROOTDIR . '/modules/comment/comment.php';
			$area = ( defined( 'NV_COMM_AREA' ) ) ? NV_COMM_AREA : 0;
			$checkss = md5( $module_name . '-' . $area . '-' . NV_COMM_ID . '-' . $allowed . '-' . NV_CACHE_PREFIX );

			//get url comment
			$url_info = parse_url( $client_info['selfurl'] );
			$content_comment = nv_comment_module( $module_name, $checkss, $area, NV_COMM_ID, $allowed, 1 );
		}
		else
		{
			$content_comment = '';
		}
		//$content_comment = '';
		// Image of Category
		$global_array_cat[$catid]['imghome'] = '';
		if( $global_array_cat[$catid]['image'] )
		{
			if( $global_array_cat[$catid]['image_type'] == 1 ) //image thumb
			{
				$global_array_cat[$catid]['imghome'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_name . '/' . $global_array_cat[$catid]['image'];
			}
			elseif( $global_array_cat[$catid]['image_type'] == 2 ) //image file
			{
				$global_array_cat[$catid]['imghome'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/' . $global_array_cat[$catid]['image'];
			}
			elseif( $global_array_cat[$catid]['image_type'] == 3 ) //image url
			{
				$global_array_cat[$catid]['imghome'] = $global_array_cat[$catid]['image'];
			}
			elseif( ! empty( $show_no_image ) ) //no image
			{
				$global_array_cat[$catid]['imghome'] = NV_BASE_SITEURL . $show_no_image;
			}
			else
			{
				$global_array_cat[$catid]['imghome'] = '';
			}
		}
		$viewcat_img  = $global_array_cat[$catid]['imghome'];

		$viewcat = 'viewcat_list_new';
		//$generate_page = nv_alias_page( $page_title, $base_url, $num_items, $per_page, $page );
		$contents = viewcat_list_new( $array_catpage, $array_cat_block, $catid, $page,'', $viewcat_img, $content_comment);
	}
	if( ! defined( 'NV_IS_MODADMIN' ) and $contents != '' and $cache_file != '' )
	{
		nv_set_cache( $module_name, $cache_file, $contents );
	}
}
if( $page > 1 )
{
	$page_title .= ' ' . NV_TITLEBAR_DEFIS . ' ' . $lang_global['page'] . ' ' . $page;
	$description .= ' ' . $page;
}
include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';