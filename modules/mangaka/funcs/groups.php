<?php

/**
 * @Project NUKEVIET 4.x
 * @authors VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 3-6-2010 0:14
 */

if( ! defined( 'NV_IS_MOD_NEWS' ) ) die( 'Stop!!!' );

$show_no_image = $module_config[$module_name]['show_no_image'];

$array_mod_title[] = array(
	'catid' => 0,
	'title' => $module_info['funcs'][$op]['func_custom_name'],
	'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['groups']
);

$alias = isset( $array_op[1] ) ? trim( $array_op[1] ) : '';
//List cat inside Genre
//var_dump($array_op[1]);
if( !empty( $alias ) )
{
	$page = ( isset( $array_op[2] ) and substr( $array_op[2], 0, 5 ) == 'page-' ) ? intval( substr( $array_op[2], 5 ) ) : 1;

	$sth = $db->prepare( 'SELECT bid, title, alias, image, description, keywords FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat WHERE alias= :alias' );
	$sth->bindParam( ':alias', $alias, PDO::PARAM_STR );
	$sth->execute();

	list( $bid, $page_title, $alias, $topic_image, $description, $key_words ) = $sth->fetch( 3 );

	if( $bid > 0 )
	{
		$base_url_rewrite = $base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['groups'] . '/' . $alias;
		if( $page > 1 )
		{
			$page_title .= ' ' . NV_TITLEBAR_DEFIS . ' ' . $lang_global['page'] . ' ' . $page;
			$base_url_rewrite .= '/page-' . $page;
		}
		$base_url_rewrite = nv_url_rewrite( $base_url_rewrite, true );
		if( $_SERVER['REQUEST_URI'] != $base_url_rewrite and NV_MAIN_DOMAIN . $_SERVER['REQUEST_URI'] != $base_url_rewrite )
		{
			Header( 'Location: ' . $base_url_rewrite );
			die();
		}

		$array_mod_title[] = array(
			'catid' => 0,
			'title' => $page_title,
			'link' => $base_url
		);

		$db->sqlreset()
			->select( 'COUNT(*)' )
			->from( NV_PREFIXLANG . '_' . $module_data . '_block' )
			->where( 'bid = ' . $bid );

		$num_items = $db->query( $db->sql() )->fetchColumn();
	
		$db->sqlreset()
			->select( 't1.catid, t1.authors, t1.add_time, t1.edit_time, t1.last_update, t1.title, t1.alias, t1.image' )
			->from( NV_PREFIXLANG . '_' . $module_data . '_cat t1' )
			->join( 'INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_block t2 ON t1.catid = t2.catid' )
			->where( 't2.bid= ' . $bid  )
			->order( 't1.alias ASC' )
			->limit( $per_page )
			->offset( ( $page - 1 ) * $per_page );

		$topic_array = array();
		$end_last_update = 0;

		$result = $db->query( $db->sql() );
		$pre_letter = '';
		while( $item = $result->fetch() )
		{
			// Ky tu dau cho moi chu cai
			$item['f_letter'] = substr($item['alias'], 0, 1);
			if($pre_letter !== $item['f_letter']) 
			{
				$item['letter'] = $item['f_letter'];
			} else {$item['letter'] = '';}
			$pre_letter = $item['f_letter']; // Ket thuc list theo ky tu dau cua bang chu cai
			
			if( ! empty( $item['image'] ) AND file_exists( NV_ROOTDIR. '/' . NV_FILES_DIR . '/' . $module_name . '/' . $item['image'] ) )//image thumb
			{
				$item['src'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_name . '/' . $item['image'];
			}
			elseif( ! empty( $item['image'] ) )//image file
			{
				$item['src'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/' . $item['image'];
			}
			elseif( ! empty( $show_no_image ) )//no image
			{
				$item['src'] = NV_BASE_SITEURL . $show_no_image;
			}
			else
			{
				$item['src'] = '';
			}
			$item['alt'] = ! empty( $item['homeimgalt'] ) ? $item['homeimgalt'] : $item['title'];
			$item['width'] = $module_config[$module_name]['homewidth'];

			$end_last_update = $item['last_update'];

			$item['link'] = $global_array_cat[$item['catid']]['link'];
			$topic_array[] = $item;
		}
		$result->closeCursor();
		unset( $result, $row );

		$generate_page = nv_alias_page( $page_title, $base_url, $num_items, $per_page, $page );

		if( ! empty( $topic_image ) )
		{
			$topic_image = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_name . '/' . $topic_image;
		}

		$contents = topic_theme( $topic_array, $generate_page, $page_title, $description, $topic_image, $num_items);
	}
	else
	{
		Header( 'Location: ' . nv_url_rewrite( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['groups'], true ) );
		exit();
	}
}
else // List all genre
{
	$page_title = $module_info['custom_title'];
	$key_words = $module_info['keywords'];
	
	$pre_letter = '';
	$result = $db->query( 'SELECT bid as id, title, alias, image, description as hometext, keywords, add_time FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat ORDER BY alias ASC');
	while( $item = $result->fetch() )
	{
		$item['f_letter'] = substr($item['alias'], 0, 1);
	    if($pre_letter !== $item['f_letter']) {
			$item['letter'] = $item['f_letter'];
		} else {$item['letter'] = '';}
	    $pre_letter = $item['f_letter'];

		if( ! empty( $item['image'] ) AND file_exists( NV_ROOTDIR. '/' . NV_FILES_DIR . '/' . $module_name . '/' . $item['image'] ) )//image thumb
		{
			$item['src'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_name . '/' . $item['image'];
		}
		elseif( ! empty( $item['image'] ) )//image file
		{
			$item['src'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/' . $item['image'];
		}
		elseif( ! empty( $show_no_image ) )//no image
		{
			$item['src'] = NV_BASE_SITEURL . $show_no_image;
		}
		else
		{
			$item['src'] = '';
		}
		$item['alt'] = ! empty( $item['homeimgalt'] ) ? $item['homeimgalt'] : $item['title'];
		$item['width'] = $module_config[$module_name]['homewidth'];

		$item['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['groups'] . '/' . $item['alias'];
		$topic_array[] = $item;
	}
	$result->closeCursor();
	unset( $result, $row );

	$contents = topic_theme( $topic_array, '', $page_title, $description, '', '');
}
include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';