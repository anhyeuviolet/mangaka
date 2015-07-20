<?php

/**
 * @Project MANGA ON NUKEVIET 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 15/07/2015 10:51
 */

if( ! defined( 'NV_IS_MOD_NEWS' ) ) die( 'Stop!!!' );

// $cache_file = '';
// $contents = '';
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
if( ! defined( 'NV_IS_MODADMIN' ) and $page < 5 )
{
	$cache_file = NV_LANG_DATA . '_' . $module_info['template'] . '_' . $op . '_' . $catid . '_' . $page . '_' . NV_CACHE_PREFIX . '.cache';
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
	$viewcat_rating[] = array();
	$viewcat_img = array();
	$base_url = $global_array_cat[$catid]['link'];
	$show_no_image = $module_config[$module_name]['show_no_image'];
	if (!empty($show_no_image)){
		$show_no_image = $show_no_image;
	} else {
		$show_no_image = '/themes/default/images/'.$module_name.'/no_cover.jpg';
	}

	if( $viewcat == 'viewcat_list' ) // Xem theo danh sach
	{
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
		
		// Image of Category
		if( $global_array_cat[$catid]['image_type'] == 1 ) //image thumb
		{
			$global_array_cat[$catid]['imghome'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_name . '/cover/' . $global_array_cat[$catid]['image'];
		}
		elseif( $global_array_cat[$catid]['image_type'] == 2 ) //image file
		{
			$global_array_cat[$catid]['imghome'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/cover/' . $global_array_cat[$catid]['image'];
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
		
		$viewcat_img = $global_array_cat[$catid]['imghome'];

		//Rating
		$viewcat_rating['checkss'] = md5( $catid . session_id() . $global_config['sitekey'] );
		if( $global_array_cat[$catid]['allowed_rating'] )
		{
			$time_set_rating = $nv_Request->get_int( $module_name . '_' . $op . '_' . $catid, 'cookie', 0 );
			if( $time_set_rating > 0 )
			{
				$viewcat_rating['disablerating'] = 1;
			}
			else
			{
				$viewcat_rating['disablerating'] = 0;
			}
			$viewcat_rating['stringrating'] = sprintf( $lang_module['stringrating'], $global_array_cat[$catid]['total_rating'], $global_array_cat[$catid]['click_rating'] );
			$viewcat_rating['numberrating'] = ( $global_array_cat[$catid]['click_rating'] > 0 ) ? round( $global_array_cat[$catid]['total_rating'] / $global_array_cat[$catid]['click_rating'], 1 ) : 0;
			$viewcat_rating['langstar'] = array(
				'note' => $lang_module['star_note'],
				'verypoor' => $lang_module['star_verypoor'],
				'poor' => $lang_module['star_poor'],
				'ok' => $lang_module['star_ok'],
				'good' => $lang_module['star_good}'],
				'verygood' => $lang_module['star_verygood']
			);
		}

		$contents = viewcat_list( $array_cat_block, $catid, $viewcat_img, $viewcat_rating, $content_comment);
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