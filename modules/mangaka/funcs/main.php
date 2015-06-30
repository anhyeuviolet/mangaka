<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 3-6-2010 0:14
 */

if( ! defined( 'NV_IS_MOD_NEWS' ) ) die( 'Stop!!!' );

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];

$contents = '';
$cache_file = '';
$array_bid = array();
$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;
$base_url_rewrite = nv_url_rewrite( $base_url, true );
$page_url_rewrite = $page ? nv_url_rewrite( $base_url . '/page-' . $page, true ) : $base_url_rewrite;
$request_uri = $_SERVER['REQUEST_URI'];
if( ! ( $home OR $request_uri == $base_url_rewrite OR $request_uri == $page_url_rewrite OR NV_MAIN_DOMAIN . $request_uri == $base_url_rewrite OR NV_MAIN_DOMAIN . $request_uri == $page_url_rewrite ) )
{
	$redirect = '<meta http-equiv="Refresh" content="3;URL=' . $base_url_rewrite . '" />';
	nv_info_die( $lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content'] . $redirect );
}
if( ! defined( 'NV_IS_MODADMIN' ) and $page < 5 )
{
	$cache_file = NV_LANG_DATA . '_' . $module_info['template'] . '-' . $op . '-' . $page . '-' . NV_CACHE_PREFIX . '.cache';
	if( ( $cache = nv_get_cache( $module_name, $cache_file ) ) != false )
	{
		$contents = $cache;
	}
}

if( empty( $contents ) )
{
	$viewcat = $module_config[$module_name]['indexfile'];
	$show_no_image = $module_config[$module_name]['show_no_image'];
	$array_catpage = array();
	$array_cat_other = array();

	if(  $viewcat == 'viewcat_none' )
	{
		$contents = '';
	}
	elseif( $viewcat == 'viewcat_full_home'  ) // Hien thi day du, phong cach BT.com
	{
		$db->sqlreset()
			->select( 'COUNT(*)' )
			->from( NV_PREFIXLANG . '_' . $module_data . '_cat' )
			->where( 'inhome=1' );
		$num_items = $db->query( $db->sql() )->fetchColumn();
		$sql='SELECT * FROM '.NV_PREFIXLANG . '_' . $module_data . '_cat WHERE inhome=1 ORDER BY last_update DESC LIMIT '.( $page - 1 ) * $per_page .','.$per_page;
		$result = $db->query( $sql );
		$array_cat = array();
		while( $item = $result->fetch( ) )
		{
			if( $item['image_type'] == 1 ) //image thumb
			{
				$item['imghome'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/' . $item['image'];
			}
			elseif( $item['image_type'] == 2 ) //image file
			{
				$item['imghome'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/' . $item['image'];
			}
			elseif( $item['image_type'] == 3 ) //image url
			{
				$item['imghome'] = $item['image'];
			}
			elseif( ! empty( $show_no_image ) ) //no image
			{
				$item['imghome'] = NV_BASE_SITEURL . $show_no_image;
			}
			else
			{
				$item['imghome'] = '';
			}

			$item['link'] = $global_array_cat[$catid]['link'];
			$bid = $global_array_cat[$item['catid']]['bid'];
			$bid_array = explode( ',', $bid );
			$item['bid'] = array();
			if(  !empty( $bid_array ) )
			{
				foreach( $bid_array as $id )
				{
					if( intval( $id ) != 0 )
					{
						$item['bid'][] = $global_array_block[$id];
					}
					
				}
			}
	
			$sql = 'SELECT COUNT(*) as total_chapter, SUM(hitstotal) as total_view, max(chapter) as last_chapter FROM '. NV_PREFIXLANG . '_' . $module_data . '_'.$item['catid'].' WHERE status=1';
			$rowall = $db->query( $sql )->fetchAll( 3 );
			foreach ($rowall as $row)
			{
				list( $total_chapter, $total_view, $last_chapter ) = $row;
			}
			$item['last_chapter'] = $last_chapter;
			$item['total_chapter'] = $total_chapter;
			$item['total_view'] = $total_view;
			
			$array_catpage[] = $item;
		}
		unset($array_cat);
					
		$viewcat = 'viewcat_full_home';
		$generate_page = nv_alias_page( $page_title, $base_url, $num_items, $per_page, $page );
		$contents = viewcat_full_home( $array_catpage, $generate_page );
	}
	elseif( $viewcat == 'viewcat_list_home'  ) // Hien thi danh sach, phong cach 3T.com
	{
		$db->sqlreset()
			->select( 'COUNT(*)' )
			->from( NV_PREFIXLANG . '_' . $module_data . '_cat' )
			->where( 'inhome=1' );
			
		$num_items = $db->query( $db->sql() )->fetchColumn();
		$sql='SELECT * FROM '.NV_PREFIXLANG . '_' . $module_data . '_cat WHERE inhome=1 LIMIT '.( $page - 1 ) * $per_page .','.$per_page;
		$result = $db->query( $sql );
		$array_cat = array();
		while( $item = $result->fetch( ) )
		{
			if( $item['image'] == 1 ) //image thumb
			{
				$item['imghome'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_name . '/' . $item['homeimgfile'];
			}
			elseif( $item['image'] == 2 ) //image file
			{
				$item['imghome'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/' . $item['homeimgfile'];
			}
			elseif( $item['image'] == 3 ) //image url
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

			$item['link'] = $global_array_cat[$catid]['link'];
			
			$bid = $global_array_cat[$item['catid']]['bid'];
			$bid_array = explode( ',', $bid );
			$item['bid'] = array();
			if(  !empty( $bid_array ) )
			{
				foreach( $bid_array as $id )
				{
					if( intval( $id ) != 0 )
					{
						$item['bid'][] = $global_array_block[$id];
					}
					
				}
			}

			$array_catpage[] = $item;
		}
		unset($array_cat);
					
		$viewcat = 'viewcat_list_home';
		$generate_page = nv_alias_page( $page_title, $base_url, $num_items, $per_page, $page );
		$contents = viewcat_list_home( $array_catpage, $generate_page );
	}

	if( ! defined( 'NV_IS_MODADMIN' ) and $contents != '' and $cache_file != '' )
	{
		nv_set_cache( $module_name, $cache_file, $contents );
	}
}

if( $page > 1 )
{
	$page_title .= ' ' . NV_TITLEBAR_DEFIS . ' ' . $lang_global['page'] . ' ' . $page;
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';