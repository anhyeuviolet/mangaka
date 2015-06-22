<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 3-6-2010 0:14
 */

if( ! defined( 'NV_IS_MOD_NEWS' ) ) die( 'Stop!!!' );

$contents = '';
$publtime = 0;

if( nv_user_in_groups( $global_array_cat[$catid]['groups_view'] ) )
{
	$query = $db->query( 'SELECT *,ROUND(chapter,1) as chapter FROM ' . NV_PREFIXLANG . '_' . $module_data . '_' . $catid . ' WHERE id = ' . $id );
	$news_contents = $query->fetch();
	if( $news_contents['id'] > 0 )
	{
		$body_contents = $db->query( 'SELECT bodyhtml as bodytext FROM ' . NV_PREFIXLANG . '_' . $module_data . '_bodyhtml_' . ceil( $news_contents['id'] / 2000 ) . ' where id=' . $news_contents['id'] )->fetch();
		$news_contents = array_merge( $news_contents, $body_contents );
		unset( $body_contents );
		
		$show_no_image = $module_config[$module_name]['show_no_image'];
		if( defined( 'NV_IS_MODADMIN' ) or ( $news_contents['status'] == 1 and $news_contents['publtime'] < NV_CURRENTTIME and ( $news_contents['exptime'] == 0 or $news_contents['exptime'] > NV_CURRENTTIME ) ) )
		{
			$time_set = $nv_Request->get_int( $module_name . '_' . $op . '_' . $id, 'session' );
			if( empty( $time_set ) )
			{
				$nv_Request->set_Session( $module_data . '_' . $op . '_' . $id, NV_CURRENTTIME );
				$query = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET hitstotal=hitstotal+1 WHERE id=' . $id;
				$db->query( $query );

				$array_catid = explode( ',', $news_contents['listcatid'] );
				foreach( $array_catid as $catid_i )
				{
					$query = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_' . $catid_i . ' SET hitstotal=hitstotal+1 WHERE id=' . $id;
					$db->query( $query );
				}
			}
			$news_contents['showhometext'] = $module_config[$module_name]['showhometext'];
			if( ! empty( $news_contents['homeimgfile'] ) )
			{
				$src = $alt = $note = '';
				$width = $height = 0;
				if( $news_contents['homeimgthumb'] == 1 and $news_contents['imgposition'] == 1 )
				{
					$src = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_name . '/' . $news_contents['homeimgfile'];
					$news_contents['homeimgfile'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/' . $news_contents['homeimgfile'];
					$width = $module_config[$module_name]['homewidth'];
				}
				elseif( $news_contents['homeimgthumb'] == 3 )
				{
					$src = $news_contents['homeimgfile'];
					$width = ( $news_contents['imgposition'] == 1 ) ? $module_config[$module_name]['homewidth'] : $module_config[$module_name]['imagefull'];
				}
				elseif( file_exists( NV_UPLOADS_REAL_DIR . '/' . $module_name . '/' . $news_contents['homeimgfile'] ) )
				{
					$src = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/' . $news_contents['homeimgfile'];
					if( $news_contents['imgposition'] == 1 )
					{
						$width = $module_config[$module_name]['homewidth'];
					}
					else
					{
						$imagesize = @getimagesize( NV_UPLOADS_REAL_DIR . '/' . $module_name . '/' . $news_contents['homeimgfile'] );
						if( $imagesize[0] > 0 and $imagesize[0] > $module_config[$module_name]['imagefull'] )
						{
							$width = $module_config[$module_name]['imagefull'];
						}
						else
						{
							$width = $imagesize[0];
						}
					}
					$news_contents['homeimgfile'] = $src;
				}

				if( ! empty( $src ) )
				{
					$meta_property['og:image'] = ( $news_contents['homeimgthumb'] == 1 ) ? NV_MY_DOMAIN . $news_contents['homeimgfile'] : NV_MY_DOMAIN . $src;

					if( $news_contents['imgposition'] > 0 )
					{
						$news_contents['image'] = array(
							'src' => $src,
							'width' => $width,
							'alt' => ( empty( $news_contents['homeimgalt'] ) ) ? $news_contents['title'] : $news_contents['homeimgalt'],
							'note' => $news_contents['homeimgalt'],
							'position' => $news_contents['imgposition']
						);
					}
				}
				elseif( !empty( $show_no_image ) )
				{
					$meta_property['og:image'] = NV_MY_DOMAIN . NV_BASE_SITEURL . $show_no_image;
				}
			}
			elseif( ! empty( $show_no_image ) )
			{
				$meta_property['og:image'] = NV_MY_DOMAIN . NV_BASE_SITEURL . $show_no_image;
			}
			if( $alias_url == $news_contents['alias'] )
			{
				$publtime = intval( $news_contents['publtime'] );
			}
		}

		if( defined( 'NV_IS_MODADMIN' ) and $news_contents['status'] != 1 )
		{
			$alert = sprintf( $lang_module['status_alert'], $lang_module['status_' . $news_contents['status']] );
			$my_head .= "<script type=\"text/javascript\">alert('". $alert ."')</script>";
		}
	}

	if( $publtime == 0 )
	{
		$redirect = '<meta http-equiv="Refresh" content="3;URL=' . nv_url_rewrite( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name, true ) . '" />';
		nv_info_die( $lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content'] . $redirect );
	}


	$base_url_rewrite = nv_url_rewrite( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$news_contents['catid']]['alias'] . '/' . $news_contents['alias'] . '-' . $news_contents['id'] . $global_config['rewrite_exturl'], true );
	if( $_SERVER['REQUEST_URI'] == $base_url_rewrite )
	{
		$canonicalUrl = NV_MAIN_DOMAIN . $base_url_rewrite;
	}
	elseif( NV_MAIN_DOMAIN . $_SERVER['REQUEST_URI'] != $base_url_rewrite )
	{
		Header( 'Location: ' . $base_url_rewrite );
		die();
	}
	else
	{
		$canonicalUrl = $base_url_rewrite;
	}

	unset( $sql, $result );

	$news_contents['newscheckss'] = md5( $news_contents['id'] . session_id() . $global_config['sitekey'] );
	$news_contents['publtime'] = nv_date( 'l - d/m/Y H:i', $news_contents['publtime'] );

	if( $news_contents['allowed_rating'] )
	{
		$time_set_rating = $nv_Request->get_int( $module_name . '_' . $op . '_' . $news_contents['id'], 'cookie', 0 );
		if( $time_set_rating > 0 )
		{
			$news_contents['disablerating'] = 1;
		}
		else
		{
			$news_contents['disablerating'] = 0;
		}
		$news_contents['stringrating'] = sprintf( $lang_module['stringrating'], $news_contents['total_rating'], $news_contents['click_rating'] );
		$news_contents['numberrating'] = ( $news_contents['click_rating'] > 0 ) ? round( $news_contents['total_rating'] / $news_contents['click_rating'], 1 ) : 0;
		$news_contents['langstar'] = array(
			'note' => $lang_module['star_note'],
			'verypoor' => $lang_module['star_verypoor'],
			'poor' => $lang_module['star_poor'],
			'ok' => $lang_module['star_ok'],
			'good' => $lang_module['star_good}'],
			'verygood' => $lang_module['star_verygood']
		);
	}

	list( $post_username, $post_first_name, $post_last_name ) = $db->query( 'SELECT username, first_name, last_name FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid = ' . $news_contents['admin_id'] )->fetch( 3 );
	$news_contents['post_name'] = nv_show_name_user( $post_first_name, $post_last_name, $post_username );
	
	$next_chapter = $previous_chapter = '';
	//Next Chapter
	$sql = 'SELECT id, catid, alias, ROUND(chapter,1) as chapter, status FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE ROUND(chapter,1) > '.$news_contents['chapter'].' AND catid ='.$news_contents['catid'].' ORDER BY chapter ASC LIMIT 1';
	$list = nv_db_cache( $sql, 'id', $module_name );
	foreach( $list as $next )
	{
		$next_chapter['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$next['catid']]['alias'] . '/' . $next['alias'] . '-' . $next['id'] . $global_config['rewrite_exturl'];
		$next_chapter['chapter'] = $next['chapter'];
	}
	//Previous Chapter
	$sql1 = 'SELECT id, catid, alias, ROUND(chapter,1) as chapter, status FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE ROUND(chapter,1) < '.$news_contents['chapter'].' AND catid ='.$news_contents['catid'].' ORDER BY chapter DESC LIMIT 1';
	$list1 = nv_db_cache( $sql1, 'id', $module_name );
	foreach( $list1 as $previous )
	{
		$previous_chapter['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$previous['catid']]['alias'] . '/' . $previous['alias'] . '-' . $previous['id'] . $global_config['rewrite_exturl'];
		$previous_chapter['chapter'] = $previous['chapter'];
	}
	$contents = detail_theme( $news_contents, $next_chapter, $previous_chapter );

	$page_title = $global_array_cat[$catid]['title']." - ". $lang_module['chapter'] ." ". $news_contents['chapter'];
	$description = $global_array_cat[$catid]['title']." - ". $lang_module['chapter'] ." ". $news_contents['chapter'] ." - ".$global_array_cat[$catid]['description'] ;

}
else
{
	$contents = no_permission( $global_array_cat[$catid]['groups_view'] );
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';