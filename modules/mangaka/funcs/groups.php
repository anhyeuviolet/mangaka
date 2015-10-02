<?php

/**
 * @Project MANGA ON NUKEVIET 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 15/07/2015 10:51
 */

if( ! defined( 'NV_IS_MOD_MANGAKA' ) ) die( 'Stop!!!' );

$show_no_image = $module_config[$module_name]['show_no_image'];
if (!empty($show_no_image))
{
	$show_no_image = $show_no_image;
} 
else 
{
	$show_no_image = '/themes/default/images/'.$module_name.'/no_cover.jpg';
}
$array_mod_title[] = array(
'catid' => 0,
'title' => $lang_module['genre'],
'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['groups']
);

$alias = isset( $array_op[1] ) ? trim( $array_op[1] ) : '';
//List cat inside Genre
if( !empty( $alias ) )
{
	$page = ( isset( $array_op[2] ) and substr( $array_op[2], 0, 5 ) == 'page-' ) ? intval( substr( $array_op[2], 5 ) ) : 1;

	$sth = $db->prepare( 'SELECT bid, numbers, title, alias, image, description, keywords FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat WHERE alias= :alias' );
	$sth->bindParam( ':alias', $alias, PDO::PARAM_STR );
	$sth->execute();

	list( $bid, $per_page, $page_title, $alias, $group_image, $description, $key_words ) = $sth->fetch( 3 );
	$page_title = $lang_module['genre'].' '. $page_title;
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
		// Total result 
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

		$group_array = array();
		$end_last_update = 0;

		$result = $db->query( $db->sql() );
		$pre_letter = '';
		while( $item = $result->fetch() )
		{
			$db->sqlreset()
				->select( 'COUNT(*) as total_chapter, max(chapter) as last_chapter' )
				->from( NV_PREFIXLANG . '_' . $module_data . '_'. $item['catid'] );
			$_m = $db->query( $db->sql() )->fetchAll( 3 );
			foreach ($_m as $_m_i)
			{
				list( $item['total_chap'],$item['last_chapter'] ) = $_m_i;
			}
			unset( $_m );
			// Ky tu dau cho moi chu cai
			$item['f_letter'] = substr($item['alias'], 0, 1);
			if($pre_letter !== $item['f_letter']) 
			{
				$item['letter'] = $item['f_letter'];
			} else {$item['letter'] = '';}
			$pre_letter = $item['f_letter']; 
			
			// Image of each genre
			if( ! empty( $item['image'] ) AND file_exists( NV_ROOTDIR. '/' . NV_FILES_DIR . '/' . $module_name . '/cover/' . $item['image'] ) )//image thumb
			{
				$item['src'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_name . '/cover/' . $item['image'];
			}
			elseif( ! empty( $item['image'] ) )//image URL
			{
				$item['src'] = $item['image'];
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
			$group_array[] = $item;
		}
		$result->closeCursor();
		unset( $result, $row );
		$generate_page = nv_alias_page( $page_title, $base_url, $num_items, $per_page, $page );

		// Genre thumb image
		if( ! empty( $group_image ) AND file_exists( NV_ROOTDIR. '/' . NV_FILES_DIR . '/' . $module_name . '/genre/' . $group_image ) )//image thumb
		{
			$group_image = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_name . '/genre/' . $group_image;
		}
		elseif( ! empty( $group_image ) )//image URL
		{
			$group_image = $group_image;
		}
		elseif( ! empty( $show_no_image ) )//no image
		{
			$group_image = NV_BASE_SITEURL . $show_no_image;
		}
		else
		{
			$group_image = '';
		}

		$contents = group_theme( $group_array, $generate_page, $page_title, $description, $group_image);
	}
	else
	{
		Header( 'Location: ' . nv_url_rewrite( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['groups'], true ) );
		exit();
	}
}
else // List all genre
{
	$page_title = $lang_module['list'].' '.strtolower($lang_module['genre']);
	$key_words = $module_info['keywords'];
	
	$pre_letter = '';
	$result = $db->query( 'SELECT bid as id, title, alias, image, description as hometext, keywords FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat ORDER BY alias ASC');
	while( $item = $result->fetch() )
	{
		// Chuc nang tao ky tu dau tien cho Genre - tam thoi vo hieu hoa
		// $item['f_letter'] = substr($item['alias'], 0, 1);
	    // if($pre_letter !== $item['f_letter']) {
			// $item['letter'] = $item['f_letter'];
		// } else {$item['letter'] = '';}
	    // $pre_letter = $item['f_letter'];

		// Image of each genre
		if( ! empty( $item['image'] ) AND file_exists( NV_ROOTDIR. '/' . NV_FILES_DIR . '/' . $module_name . '/genre/' . $item['image'] ) )//image thumb
		{
			$item['src'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_name . '/genre/' . $item['image'];
		}
		elseif( ! empty( $item['image'] ) )//image URL
		{
			$item['src'] = $item['image'];
		}
		elseif( ! empty( $show_no_image ) )//no image
		{
			$item['src'] = NV_BASE_SITEURL . $show_no_image;
		}
		else
		{
			$item['src'] = '';
		}
		$item['alt'] = $item['title'];
		$item['width'] = $module_config[$module_name]['homewidth'];

		$item['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['groups'] . '/' . $item['alias'];
		$group_array[] = $item;
	}
	$result->closeCursor();
	unset( $result, $row );
	
	$generate_page = $group_image = '';
	$contents = group_theme( $group_array, $generate_page, $page_title, $description, $group_image );
}
include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';