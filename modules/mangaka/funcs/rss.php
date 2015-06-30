<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Apr 20, 2010 10:47:41 AM
 */

if( ! defined( 'NV_IS_MOD_NEWS' ) ) die( 'Stop!!!' );

$channel = array();
$items = array();

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

$db->sqlreset()
	->select( 'catid, add_time, title, alias, descriptionhtml, image_type, image' )
	->order( 'alias ASC' )
	->limit( 30 );

// if( ! empty( $catid ) )
// {
	// $channel['title'] = $module_info['custom_title'] . ' - ' . $global_array_cat[$catid]['title'];
	// $channel['link'] = NV_MY_DOMAIN . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $alias_cat_url;
	// $channel['description'] = $global_array_cat[$catid]['description'];

	// $db->from( NV_PREFIXLANG . '_' . $module_data . '_' . $catid )
		// ->where( 'status=1' );
// }
// else
// {
	$db->from( NV_PREFIXLANG . '_' . $module_data . '_cat' )
		->where( 'inhome=1' );
// }
if( $module_info['rss'] )
{
	$result = $db->query( $db->sql() );
	while( list( $catid_i, $add_time, $title, $alias, $descriptionhtml, $image_type, $image ) = $result->fetch( 3 ) )
	{
		$catalias = $global_array_cat[$catid_i]['alias'];

		if( $image_type == 1 ) // image thumb
		{
			$rimages = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_name . '/' . $image;
		}
		elseif( $image_type == 2 ) // image file
		{
			$rimages = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/' . $image;
		}
		elseif( $image_type == 3 ) // image url
		{
			$rimages = $image;
		}
		else // no image
		{
			$rimages = '';
		}
		$rimages = ( ! empty( $rimages ) ) ? '<img src="' . $rimages . '" width="100" align="left" border="0">' : '';
		$descriptionhtml = strip_tags($descriptionhtml);
		$descriptionhtml = nv_clean60($descriptionhtml, 450);
		$items[] = array(
			'title' => $title,
			'link' => NV_MY_DOMAIN . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $catalias, //
			'guid' => $module_name . '_' . $id,
			'description' => $rimages . $descriptionhtml,
			'pubdate' => $add_time
		);
	}
}
nv_rss_generate( $channel, $items );
die();