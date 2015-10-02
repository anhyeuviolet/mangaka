<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Apr 20, 2010 10:47:41 AM
 */

if( ! defined( 'NV_IS_MOD_MANGAKA' ) ) die( 'Stop!!!' );

$channel = array();
$items = array();

$show_no_image = $module_config[$module_name]['show_no_image'];
if (!empty($show_no_image)){
	$show_no_image = $show_no_image;
} else {
	$show_no_image = 'themes/default/images/'.$module_name.'/no_cover.jpg';
}


$channel['title'] = $module_info['custom_title'];
$channel['link'] = NV_MY_DOMAIN . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;
$channel['description'] = ! empty( $module_info['description'] ) ? $module_info['description'] : $global_config['site_description'];

$catid = 0;
if( isset( $array_op[1] ) )
{
	$alias_cat_url = $array_op[1];
	$cattitle = '';
	foreach( $global_array_cat as $catid_i => $array_cat_i )
	{
		if( $alias_cat_url == $array_cat_i['alias'] )
		{
			$catid = $catid_i;
			break;
		}
	}
}

// Sub RSS, show all chapters of category
if( ! empty( $catid ) )
{
	$channel['title'] = $module_info['custom_title'] . ' - ' . $global_array_cat[$catid]['title'];
	$channel['link'] = NV_MY_DOMAIN . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $alias_cat_url;
	$channel['description'] = $global_array_cat[$catid]['description'];
	$db->sqlreset()
		->select( 'id, catid, publtime, title, alias, ROUND(chapter,1)' )
		->order( 'publtime DESC' )
		->limit( 30 );
	$db->from( NV_PREFIXLANG . '_' . $module_data . '_' . $catid )
		->where( 'status=1' );
		if( $module_info['rss'] )
{
	$result = $db->query( $db->sql() );
	while( list( $id, $catid_i, $publtime, $title, $alias, $chapter ) = $result->fetch( 3 ) )
	{
		$catalias = $global_array_cat[$catid_i]['alias'];
		$hometext = $global_array_cat[$catid_i]['description'];

		// Image of Category
		if( $global_array_cat[$catid_i]['image_type'] == 1 ) //image thumb
		{
			$rimages = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_name . '/cover/' . $global_array_cat[$catid_i]['image'];
		}
		elseif( $global_array_cat[$catid_i]['image_type'] == 2 ) //image file
		{
			$rimages = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/cover/' . $global_array_cat[$catid_i]['image'];
		}
		elseif( $global_array_cat[$catid_i]['image_type'] == 3 ) //image url
		{
			$rimages = $global_array_cat[$catid_i]['image'];
		}
		elseif( ! empty( $show_no_image ) ) //no image
		{
			$rimages = NV_BASE_SITEURL . $show_no_image;
		}
		else
		{
			$rimages = '';
		}
		$rimages = ( ! empty( $rimages ) ) ? '<img src="' . $rimages . '" width="100" align="left" border="0">' : '';

		$items[] = array(
			'title' => $lang_module['chapter'] .' '.$chapter,
			'link' => NV_MY_DOMAIN . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $catalias . '/' . $alias . '-' . $id . $global_config['rewrite_exturl'], //
			'guid' => $module_name . '_' . $id,
			'description' => $rimages . $lang_module['chapter'] .' '.$chapter.' - '.$global_array_cat[$catid_i]['title'],
			'pubdate' => $publtime
		);
	}
}
}
else  // Main RSS, show all categories
{
	$db->sqlreset()
		->select( 'catid, last_update, title, alias' )
		->order( 'last_update DESC' )
		->limit( 30 );
	$db->from( NV_PREFIXLANG . '_' . $module_data . '_cat' )
		->where( 'inhome=1' );
	if( $module_info['rss'] )
	{
		$result = $db->query( $db->sql() );
		while( list( $catid_i, $publtime, $title, $alias  ) = $result->fetch( 3 ) )
		{
			$catalias = $global_array_cat[$catid_i]['alias'];
			$hometext = $global_array_cat[$catid_i]['description'];

			// Image of Category
			if( $global_array_cat[$catid_i]['image_type'] == 1 ) //image thumb
			{
				$rimages = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_name . '/cover/' . $global_array_cat[$catid_i]['image'];
			}
			elseif( $global_array_cat[$catid_i]['image_type'] == 2 ) //image file
			{
				$rimages = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/cover/' . $global_array_cat[$catid_i]['image'];
			}
			elseif( $global_array_cat[$catid_i]['image_type'] == 3 ) //image url
			{
				$rimages = $global_array_cat[$catid_i]['image'];
			}
			elseif( ! empty( $show_no_image ) ) //no image
			{
				$rimages = NV_BASE_SITEURL . $show_no_image;
			}
			else
			{
				$rimages = '';
			}
			$rimages = ( ! empty( $rimages ) ) ? '<img src="' . $rimages . '" width="100" align="left" border="0">' : '';

			$items[] = array(
				'title' => $title,
				'link' => NV_MY_DOMAIN . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $catalias, //
				'guid' => $module_name . '_' . $id,
				'description' => $rimages . $hometext,
				'pubdate' => $publtime
			);
		}
	}
}

nv_rss_generate( $channel, $items );
die();