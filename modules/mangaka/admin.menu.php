<?php

/**
 * @Project MANGA ON NUKEVIET 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 07/30/2013 10:27
 */

if( ! defined( 'NV_ADMIN' ) ) die( 'Stop!!!' );

if( ! function_exists('nv_news_array_cat_admin') )
{
	/**
	 * nv_news_array_cat_admin()
	 *
	 * @return
	 */
	function nv_news_array_cat_admin( $module_data )
	{
		global $db;

		$array_cat_admin = array();
		$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_admins ORDER BY userid ASC';
		$result = $db->query( $sql );

		while( $row = $result->fetch() )
		{
			$array_cat_admin[$row['userid']][$row['catid']] = $row;
		}

		return $array_cat_admin;
	}
}

$is_refresh = false;
$array_cat_admin = nv_news_array_cat_admin( $module_data );

if( ! empty( $module_info['admins'] ) )
{
	$module_admin = explode( ',', $module_info['admins'] );
	foreach( $module_admin as $userid_i )
	{
		if( ! isset( $array_cat_admin[$userid_i] ) )
		{
			$db->query( 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_admins (userid, catid, admin, add_content, pub_content, edit_content, del_content) VALUES (' . $userid_i . ', 0, 1, 1, 1, 1, 1)' );
			$is_refresh = true;
		}
	}
}
if( $is_refresh )
{
	$array_cat_admin = nv_news_array_cat_admin( $module_data );
}

$admin_id = $admin_info['admin_id'];
$NV_IS_ADMIN_MODULE = false;
$NV_IS_ADMIN_FULL_MODULE = false;
if( defined( 'NV_IS_SPADMIN' ) )
{
	$NV_IS_ADMIN_MODULE = true;
	$NV_IS_ADMIN_FULL_MODULE = true;
}
else
{
	if( isset( $array_cat_admin[$admin_id][0] ) )
	{
		$NV_IS_ADMIN_MODULE = true;
		if( intval( $array_cat_admin[$admin_id][0]['admin'] ) == 2 )
		{
			$NV_IS_ADMIN_FULL_MODULE = true;
		}
	}
}

$allow_func = array( 'main', 'view', 'stop', 'publtime', 'waiting', 'declined', 're-published', 'content', 'chapterlist', 'rpc', 'del_content', 'alias', 'cat', 'cat_manage', 'change_cat', 'list_cat', 'del_cat', 'chapter_manage', 'getchap_conf' , 'getchap', 'getmanga_conf', 'getmanga' );

$menu_cat = array();
$menu_cat['cat'] = $lang_module['categories'];
$submenu['cat_manage'] = array( 'title' => $lang_module['categories_list'], 'submenu' => $menu_cat );

$submenu['chapter_manage'] = $lang_module['chapter_manage'];


if( ! isset( $site_mods['cms'] ) )
{
	$submenu['content'] = $lang_module['content_add'];
}
	$submenu['getchap'] = $lang_module['getchap'];
	$submenu['getmanga'] = $lang_module['getmanga'];


if( $NV_IS_ADMIN_MODULE )
{
	$menu_setting = array();
	
	$menu_setting['groups'] = $lang_module['genre_manage'];
	$menu_setting['getchap_conf'] = $lang_module['getchap_conf'];
	$menu_setting['getmanga_conf'] = $lang_module['getmanga_conf'];
	
	$submenu['setting'] = array( 'title' => $lang_module['setting'], 'submenu' => $menu_setting );
	$submenu['admins'] = $lang_module['admin'];

	$allow_func[] = 'admins';
	$allow_func[] = 'block';
	$allow_func[] = 'groups';
	$allow_func[] = 'del_block_cat';
	$allow_func[] = 'list_block_cat';
	$allow_func[] = 'chang_block_cat';
	$allow_func[] = 'change_block';
	$allow_func[] = 'list_block';
	$allow_func[] = 'setting';
	$allow_func[] = 'move';
	$allow_func[] = 'tools';
	$allow_func[] = 'chapterlist';
	$allow_func[] = 'chapter_manage';
	$allow_func[] = 'getchap_conf';
	$allow_func[] = 'getchap';
	$allow_func[] = 'getmanga_conf';
	$allow_func[] = 'getmanga';
}