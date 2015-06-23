<?php

/**
 * @Project MANGA ON NUKEVIET 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 12/31/2009 0:51
 */

if( ! defined( 'NV_IS_MOD_NEWS' ) ) die( 'Stop!!!' );

function viewcat_list( $array_catpage, $array_cat_block, $catid, $page, $generate_page, $viewcat_img, $viewcat_rating, $content_comment)
{
	global $module_name, $module_file, $lang_module, $module_config, $module_info, $global_array_cat, $my_head, $client_info;
	
	$my_head .= "<script type=\"text/javascript\" src=\"" . NV_BASE_SITEURL . "js/star-rating/jquery.rating.pack.js\"></script>\n";
	$my_head .= "<script src='" . NV_BASE_SITEURL . "js/star-rating/jquery.MetaData.js' type=\"text/javascript\"></script>\n";
	$my_head .= "<link href='" . NV_BASE_SITEURL . "js/star-rating/jquery.rating.css' type=\"text/css\" rel=\"stylesheet\"/>\n";

	$xtpl = new XTemplate( 'viewcat_list.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'IMGWIDTH1', $module_config[$module_name]['homewidth'] );
	$xtpl->assign( 'SELFURL', $client_info['selfurl'] );
	$xtpl->assign( 'MODULE_FILE', $module_file );
	$xtpl->assign( 'CATID', $catid );
	$xtpl->assign( 'CHECKSS', $viewcat_rating['checkss'] );


	// Show Category Infomation
	if( $viewcat_img ) // Home image
	{
		$xtpl->assign( 'HOMEIMG1', $viewcat_img );
		$xtpl->parse( 'main.viewdescription.image' );
	}
	if( !empty($global_array_cat[$catid]['last_update'] ))
	{
		$xtpl->assign( 'LAST_UPDATE', nv_date( 'd/m/Y H:i:s', $global_array_cat[$catid]['last_update'] ));
		$xtpl->parse( 'main.viewdescription.last_update' );
	}
	if(!empty( $global_array_cat[$catid]['authors'] ))
	{
		$xtpl->assign( 'AUTHOR',$global_array_cat[$catid]['authors'] );
		
	} else {
		$global_array_cat[$catid]['authors'] = $lang_module['updating'];
		$xtpl->assign( 'AUTHOR',$global_array_cat[$catid]['authors'] );
	}
	$xtpl->parse( 'main.viewdescription.authors' );
	
	if(!empty( $global_array_cat[$catid]['translators'] ))
	{
		$xtpl->assign( 'TRANSLATOR',$global_array_cat[$catid]['translators'] );
		
	} else {
		$global_array_cat[$catid]['translators'] = $lang_module['updating'];
		$xtpl->assign( 'TRANSLATOR',$global_array_cat[$catid]['translators'] );
	}
	$xtpl->parse( 'main.viewdescription.translators' );
	if( !empty($array_cat_block) )
	{
		foreach( $array_cat_block as $array_cat_block_i )
		{
			$xtpl->assign( 'GENRE', $array_cat_block_i );
			$xtpl->parse( 'main.viewdescription.genre' );
		}
	}

	if( $global_array_cat[$catid]['allowed_rating'] == 1 ) // Rating mode
	{
		$xtpl->assign( 'LANGSTAR', $viewcat_rating['langstar'] );
		$xtpl->assign( 'STRINGRATING', $viewcat_rating['stringrating'] );
		$xtpl->assign( 'NUMBERRATING', $viewcat_rating['numberrating'] );
		$xtpl->assign( 'CLICK_RATING', $global_array_cat[$catid]['click_rating'] );

		if( $viewcat_rating['disablerating'] == 1 )
		{
			$xtpl->parse( 'main.viewdescription.allowed_rating.disablerating' );
		}

		if( $viewcat_rating['numberrating'] >= $module_config[$module_name]['allowed_rating_point'] )
		{
			$xtpl->parse( 'main.viewdescription.allowed_rating.data_rating' );
		}

		$xtpl->parse( 'main.viewdescription.allowed_rating' );
	}
	
	
	$xtpl->assign( 'CONTENT', $global_array_cat[$catid] );

	$xtpl->parse( 'main.viewdescription' );
	
	//Begin list of content
	$a = $page;
	foreach( $array_catpage as $array_row_i )
	{
		$array_row_i['publtime'] = nv_date( 'd/m/Y', $array_row_i['publtime'] );
		$array_row_i['chapter'] = round($array_row_i['chapter'],1);
		$xtpl->clear_autoreset();
		$xtpl->assign( 'NUMBER', ++$a );
		$xtpl->assign( 'CONTENT', $array_row_i );

		if( defined( 'NV_IS_MODADMIN' ) )
		{
			$xtpl->assign( 'ADMINLINK', nv_link_edit_page( $array_row_i['id'] ) . " " . nv_link_delete_page( $array_row_i['id'] ) );
			$xtpl->parse( 'main.viewcatloop.adminlink' );
		}

		$xtpl->set_autoreset();
		$xtpl->parse( 'main.viewcatloop' );
	}
	if( !empty( $content_comment ) )
	{
		$xtpl->assign( 'CONTENT_COMMENT', $content_comment );
		$xtpl->parse( 'main.comment' );
		$xtpl->parse( 'main.comment_tab' );
	}
	
	if( ! empty( $generate_page ) )
	{
		$xtpl->assign( 'GENERATE_PAGE', $generate_page );
		$xtpl->parse( 'main.generate_page' );
	}

	if( $module_config[$module_name]['showtooltip'] )
	{
		$xtpl->assign( 'TOOLTIP_POSITION', $module_config[$module_name]['tooltip_position'] );
		$xtpl->parse( 'main.tooltip' );
	}
	//Comment system
		global $meta_property;
		$lang = ( NV_LANG_DATA == 'vi' ) ? 'vi_VN' : 'en_US';
		$facebookappid = $module_config[$module_name]['facebookappid'];
		$facebookadminid = $module_config[$module_name]['facebookadminid'];
		$facebookcomment = $module_config[$module_name]['facebookcomment'];
		$xtpl->assign( 'FACEBOOK_LANG', $lang );
		$xtpl->assign( 'FACEBOOK_APPID', $facebookappid );

		if( ! empty( $facebookappid ) && ! empty( $facebookcomment ) ) // Neu co ca FB ID va cho phep comment FB
		{
			$meta_property['fb:app_id'] = $facebookappid; // MetaData cho FB ID
			$xtpl->parse( 'main.facebookjssdk' ); // Xuat SDK dung FB ID
			$xtpl->parse( 'main.fb_comment' );
			$xtpl->parse( 'main.fb_comment_tab' ); // Xuat Comment cua ID tuong ung
		} 
		else if(! empty( $facebookcomment )){   // Neu KHONG co FB ID va Cho phep comment FB
			$xtpl->parse( 'main.facebook_pubsdk' ); // Xuat SDK Public Facebook
			$xtpl->parse( 'main.fb_comment' );
			$xtpl->parse( 'main.fb_comment_tab' ); // Xuat FB Comment
		}
		if( ! empty( $facebookadminid ) ) // MetaData cho FB admin - quan ly comment
		{
			$meta_property['fb:admin_id'] = $facebookadminid;
		}
	define( 'FACEBOOK_JSSDK', true );
	if( $module_config[$module_name]['socialbutton'] ) // Neu su dung cac nut like, share MXH
	{
		$xtpl->parse( 'main.socialbutton' );
	}
	if( $module_config[$module_name]['disqus_shortname'] ) // Neu su dung binh luan Disqus
	{
		$disqus_shortname = $module_config[$module_name]['disqus_shortname'];
		$xtpl->assign( 'DISQUS_SHORTNAME', $disqus_shortname );
		$xtpl->parse( 'main.disqus' );
		$xtpl->parse( 'main.disqus_tab' );
	}
	
	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}
// Phong cach trang chu BT.com
function viewcat_full_home( $array_catpage, $generate_page )
{
	global $global_array_cat, $module_name, $module_file, $lang_module, $module_config, $module_info, $catid, $page;

	$xtpl = new XTemplate( 'viewcat_full_home.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'IMGWIDTH1', $module_config[$module_name]['homewidth'] );
 
	foreach( $array_catpage as $array_row_i )
	{
		$array_row_i['link'] = $global_array_cat[$array_row_i['catid']]['link'];
		$xtpl->clear_autoreset();
		
		$array_row_i['descriptionhtml'] = strip_tags($array_row_i['descriptionhtml']);
		$array_row_i['descriptionhtml'] = nv_clean60($array_row_i['descriptionhtml'],450);
		if( !empty($array_row_i['last_update'] ))
		{
			$xtpl->assign( 'LAST_UPDATE', nv_date( 'd/m/Y H:i:s', $array_row_i['last_update'] ));
			$xtpl->parse( 'main.viewcatloop.last_update' );
		}
		
		if(!empty( $array_row_i['authors'] ))
		{
			$xtpl->assign( 'AUTHOR',$array_row_i['authors'] );
			
		} else {
			$array_row_i['authors'] = $lang_module['updating'];
			$xtpl->assign( 'AUTHOR',$array_row_i['authors'] );
		}
		$xtpl->parse( 'main.viewcatloop.authors' );
		
		if(!empty( $array_row_i['translators'] ))
		{
			$xtpl->assign( 'TRANSLATOR',$array_row_i['translators'] );
			
		} else {
			$array_row_i['translators'] = $lang_module['updating'];
			$xtpl->assign( 'TRANSLATOR',$array_row_i['translators'] );
		}
		$xtpl->parse( 'main.viewcatloop.translators' );
		
		if( !empty($array_row_i['imghome'] ))
		{
			$xtpl->assign( 'HOMEIMG1', $array_row_i['imghome'] );
			$xtpl->parse( 'main.viewdescription.image' );
			$xtpl->parse( 'main.viewcatloop.image' );
		}
		if( !empty( $array_row_i['bid'] ) )
		{
			foreach( $array_row_i['bid'] as $bid )
			{
				$xtpl->assign( 'BID', $bid );
				$xtpl->parse( 'main.viewcatloop.block' );
			}
		}
		$xtpl->assign( 'CONTENT', $array_row_i );
		$xtpl->set_autoreset();
		$xtpl->parse( 'main.viewcatloop' );
	}

	if( ! empty( $generate_page ) )
	{
		$xtpl->assign( 'GENERATE_PAGE', $generate_page );
		$xtpl->parse( 'main.generate_page' );
	}

	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}
// Phong cach trang chu 3T.com
function viewcat_list_home( $array_catpage, $generate_page )
{
	global $global_array_cat, $module_name, $module_file, $lang_module, $module_config, $module_info, $catid, $page;

	$xtpl = new XTemplate( 'viewcat_list_home.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'IMGWIDTH1', $module_config[$module_name]['homewidth'] );
	if( ($global_array_cat[$catid]['viewdescription'] and $page == 1) OR $global_array_cat[$catid]['viewdescription'] == 2 )
	{
		$xtpl->assign( 'CONTENT', $global_array_cat[$catid] );
		if( $global_array_cat[$catid]['image'] )
		{
			$xtpl->assign( 'HOMEIMG1', NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_name . '/' . $global_array_cat[$catid]['image'] );
			$xtpl->parse( 'main.viewdescription.image' );
		}
		$xtpl->parse( 'main.viewdescription' );
	}
	$a = 0;
 
	foreach( $array_catpage as $array_row_i )
	{
 
	 
		$array_row_i['link'] = $global_array_cat[$array_row_i['catid']]['link'];
 
		$array_row_i['chapter'] = round($array_row_i['chapter'],1);
		$xtpl->clear_autoreset();
		$xtpl->assign( 'CONTENT', $array_row_i );


		if( $array_row_i['imghome'] != '' )
		{
			$xtpl->assign( 'HOMEIMG1', $array_row_i['imghome'] );
			$xtpl->assign( 'HOMEIMGALT1', ! empty( $array_row_i['homeimgalt'] ) ? $array_row_i['homeimgalt'] : $array_row_i['title'] );
			$xtpl->parse( 'main.viewcatloop.image' );
		}

		//if ( $newday >= NV_CURRENTTIME )
		//{
		//	$xtpl->parse( 'main.viewcatloop.newday' );
		//}
		
		if( !empty( $array_row_i['bid'] ) )
		{
			foreach( $array_row_i['bid'] as $bid )
			{
				$xtpl->assign( 'BID', $bid );
				$xtpl->parse( 'main.viewcatloop.block' );
			}
		}
		
		
		$xtpl->set_autoreset();
		$xtpl->parse( 'main.viewcatloop' );
		++$a;
	}

	if( ! empty( $generate_page ) )
	{
		$xtpl->assign( 'GENERATE_PAGE', $generate_page );
		$xtpl->parse( 'main.generate_page' );
	}

	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}
//
function viewcat_top( $array_catcontent, $generate_page )
{
	global $module_name, $module_file, $lang_module, $module_config, $module_info, $global_array_cat, $catid, $page;

	$xtpl = new XTemplate( 'viewcat_top.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'IMGWIDTH0', $module_config[$module_name]['homewidth'] );
	if( ($global_array_cat[$catid]['viewdescription'] and $page == 1) OR $global_array_cat[$catid]['viewdescription'] == 2 )
	{
		$xtpl->assign( 'CONTENT', $global_array_cat[$catid] );
		if( $global_array_cat[$catid]['image'] )
		{
			$xtpl->assign( 'HOMEIMG1', NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_name . '/' . $global_array_cat[$catid]['image'] );
			$xtpl->parse( 'main.viewdescription.image' );
		}
		$xtpl->parse( 'main.viewdescription' );
	}
	// Cac bai viet phan dau
	if( ! empty( $array_catcontent ) )
	{
		foreach( $array_catcontent as $key => $array_catcontent_i )
		{
			$newday = $array_catcontent_i['publtime'] + ( 86400 * $array_catcontent_i['newday'] );
			$array_catcontent_i['publtime'] = nv_date( 'd/m/Y h:i:s A', $array_catcontent_i['publtime'] );
			$xtpl->assign( 'CONTENT', $array_catcontent_i );

			if( $key == 0 )
			{
				if( $array_catcontent_i['imghome'] != '' )
				{
					$xtpl->assign( 'HOMEIMG0', $array_catcontent_i['imghome'] );
					$xtpl->assign( 'HOMEIMGALT0', $array_catcontent_i['homeimgalt'] );
					$xtpl->parse( 'main.catcontent.image' );
				}

				if( defined( 'NV_IS_MODADMIN' ) )
				{
					$xtpl->assign( 'ADMINLINK', nv_link_edit_page( $array_catcontent_i['id'] ) . " " . nv_link_delete_page( $array_catcontent_i['id'] ) );
					$xtpl->parse( 'main.catcontent.adminlink' );
				}
				if ( $newday >= NV_CURRENTTIME )
				{
					$xtpl->parse( 'main.catcontent.newday' );
				}
				$xtpl->parse( 'main.catcontent' );
			}
			else
			{
				if ( $newday >= NV_CURRENTTIME )
				{
					$xtpl->parse( 'main.catcontentloop.newday' );
				}
				$xtpl->parse( 'main.catcontentloop' );
			}
		}
	}
	// Het cac bai viet phan dau
	if( ! empty( $generate_page ) )
	{
		$xtpl->assign( 'GENERATE_PAGE', $generate_page );
		$xtpl->parse( 'main.generate_page' );
	}

	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}
// Bai viet chi tiet
function detail_theme( $news_contents, $next_chapter, $previous_chapter)
{
	global $global_config, $module_info, $lang_module, $module_name, $module_file, $module_config, $my_head, $lang_global, $user_info, $admin_info, $client_info, $global_array_cat, $catid;

	if( ! defined( 'SHADOWBOX' ) )
	{
		$my_head .= "<link type=\"text/css\" rel=\"Stylesheet\" href=\"" . NV_BASE_SITEURL . "js/shadowbox/shadowbox.css\" />\n";
		$my_head .= "<script type=\"text/javascript\" src=\"" . NV_BASE_SITEURL . "js/shadowbox/shadowbox.js\"></script>\n";
		$my_head .= "<script type=\"text/javascript\">Shadowbox.init({ handleOversize: \"drag\" });</script>";
		define( 'SHADOWBOX', true );
	}

	$my_head .= "<script type=\"text/javascript\" src=\"" . NV_BASE_SITEURL . "js/star-rating/jquery.rating.pack.js\"></script>\n";
	$my_head .= "<script src='" . NV_BASE_SITEURL . "js/star-rating/jquery.MetaData.js' type=\"text/javascript\"></script>\n";
	$my_head .= "<link href='" . NV_BASE_SITEURL . "js/star-rating/jquery.rating.css' type=\"text/css\" rel=\"stylesheet\"/>\n";

	$xtpl = new XTemplate( 'detail.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG_GLOBAL', $lang_global );
	$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
	$xtpl->assign( 'TEMPLATE', $global_config['module_theme'] );
	$xtpl->assign( 'LANG', $lang_module );
	$news_contents['detail_title'] = $global_array_cat[$catid]['title']." - ". $lang_module['chapter'] ." ". $news_contents['chapter'];

	$news_contents['addtime'] = nv_date( "d/m/Y H:i:s", $news_contents['addtime'] );

	$xtpl->assign( 'NEWSID', $news_contents['id'] );
	$xtpl->assign( 'NEWSCHECKSS', $news_contents['newscheckss'] );
	$xtpl->assign( 'DETAIL', $news_contents );
	$xtpl->assign( 'SELFURL', $client_info['selfurl'] );
	if (!empty($next_chapter))
	{
		$xtpl->assign( 'NEXT', $next_chapter );
		$xtpl->parse( 'main.next' );
	}
	if (!empty($previous_chapter))
	{
		$xtpl->assign( 'PREV', $previous_chapter );
		$xtpl->parse( 'main.pre' );
	}

	if( $news_contents['allowed_rating'] == 1 )
	{
		$xtpl->assign( 'LANGSTAR', $news_contents['langstar'] );
		$xtpl->assign( 'STRINGRATING', $news_contents['stringrating'] );
		$xtpl->assign( 'NUMBERRATING', $news_contents['numberrating'] );

		if( $news_contents['disablerating'] == 1 )
		{
			$xtpl->parse( 'main.allowed_rating.disablerating' );
		}

		if( $news_contents['numberrating'] >= $module_config[$module_name]['allowed_rating_point'] )
		{
			$xtpl->parse( 'main.allowed_rating.data_rating' );
		}

		$xtpl->parse( 'main.allowed_rating' );
	}

	if( ! empty( $news_contents['post_name'] ) )
	{
		$xtpl->parse( 'main.post_name' );
	}

	if( ! empty( $news_contents['author'] ) )
	{
		if( ! empty( $news_contents['author'] ) )
		{
			$xtpl->parse( 'main.author.name' );
		}

		$xtpl->parse( 'main.author' );
	}
	
	$src = '';
	$array_data_content = explode('http://',$news_contents['bodytext']);
	foreach ($array_data_content as $body_data)
	{
		if(!empty($body_data)){
			$src = 'http://'.$body_data;
			$xtpl->assign( 'BODY_SRC', $src );
			$xtpl->parse( 'main.body' );
		}
	
	}

	if( defined( 'NV_IS_MODADMIN' ) )
	{
		$xtpl->assign( 'ADMINLINK', nv_link_edit_page( $news_contents['id'] ) . " " . nv_link_delete_page( $news_contents['id'], 1 ) );
		$xtpl->parse( 'main.adminlink' );
	}

	global $meta_property;
	$lang = ( NV_LANG_DATA == 'vi' ) ? 'vi_VN' : 'en_US';
	$facebookappid = $module_config[$module_name]['facebookappid'];
	$facebookadminid = $module_config[$module_name]['facebookadminid'];
	$facebookcomment = $module_config[$module_name]['facebookcomment'];
	$xtpl->assign( 'FACEBOOK_LANG', $lang );
	$xtpl->assign( 'FACEBOOK_APPID', $facebookappid );
	
	if( ! empty( $facebookappid ) && ! empty( $facebookcomment ) ) // Neu co ca FB ID va cho phep comment FB
	{
		$meta_property['fb:app_id'] = $facebookappid; // MetaData cho FB ID
		$xtpl->parse( 'main.facebookjssdk' ); // Xuat SDK dung FB ID
		$xtpl->parse( 'main.fb_comment' ); // Xuat Comment cua ID tuong ung
	} 
	else if(! empty( $facebookcomment )){   // Neu KHONG co FB ID va Cho phep comment FB
		$xtpl->parse( 'main.facebook_pubsdk' ); // Xuat SDK Public Facebook
		$xtpl->parse( 'main.fb_comment' ); // Xuat FB Comment
	}
	if( ! empty( $facebookadminid ) ) // MetaData cho FB admin - quan ly comment
	{
		$meta_property['fb:admin_id'] = $facebookadminid;
	}
	define( 'FACEBOOK_JSSDK', true );
	if( $module_config[$module_name]['socialbutton'] ) // Neu su dung cac cong cu MXH
	{
		$xtpl->parse( 'main.socialbutton' );
	}

	if( $news_contents['status'] != 1 )
	{
		$xtpl->parse( 'main.no_public' );
	}

	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function no_permission()
{
	global $module_info, $module_file, $lang_module;

	$xtpl = new XTemplate( 'detail.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );

	$xtpl->assign( 'NO_PERMISSION', $lang_module['no_permission'] );
	$xtpl->parse( 'no_permission' );
	return $xtpl->text( 'no_permission' );
}
// Group (Genre cua danh muc)
function topic_theme( $topic_array, $generate_page, $page_title, $description, $topic_image, $num_items )
{
	global $lang_module, $module_info, $module_name, $module_file, $topicalias, $module_config;

	$xtpl = new XTemplate( 'groups.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'TOPIC_TITLE', $page_title );
	$xtpl->assign( 'TOPIC_NUM', $num_items );
	$xtpl->assign( 'IMGWIDTH1', $module_config[$module_name]['homewidth'] );
	if( ! empty( $page_title ) )
	{
		$xtpl->assign( 'TOPIC_DESCRIPTION', $description );
		if(!empty($topic_image))
		{
			$xtpl->assign( 'HOMEIMG1', $topic_image );
			$xtpl->parse( 'main.topicdescription.image' );
		}
		$xtpl->parse( 'main.topicdescription' );
	}
	if( ! empty( $topic_array ) )
	{
		foreach( $topic_array as $topic_array_i )
		{
			$xtpl->assign( 'TOPIC', $topic_array_i );
			
			$xtpl->assign( 'TIME', date( 'H:i', $topic_array_i['add_time'] ) );
			$xtpl->assign( 'DATE', date( 'd/m/Y', $topic_array_i['add_time'] ) );
			$xtpl->assign( 'F_LETTER', strtoupper($topic_array_i['letter']  ));
			if( ! empty( $topic_array_i['src'] ) )
			{
				$xtpl->parse( 'main.topic.homethumb' );
			}
			if( ! empty( $topic_array_i['letter'] ) )
			{
				$xtpl->parse( 'main.topic.letter' );
			}
			$xtpl->parse( 'main.topic' );
		}
	}

	if( ! empty( $generate_page ) )
	{
		$xtpl->assign( 'GENERATE_PAGE', $generate_page );
		$xtpl->parse( 'main.generate_page' );
	}

	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}


// Search
function search_theme( $key, $check_num, $date_array, $array_cat_search )
{
	global $module_name, $module_info, $module_file, $lang_module, $module_name, $my_head;

	$xtpl = new XTemplate( 'search.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'NV_LANG_VARIABLE', NV_LANG_VARIABLE );
	$xtpl->assign( 'NV_LANG_DATA', NV_LANG_DATA );
	$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
	$xtpl->assign( 'MODULE_NAME', $module_name );
	$xtpl->assign( 'BASE_URL_SITE', NV_BASE_SITEURL . 'index.php' );
	$xtpl->assign( 'TO_DATE', $date_array['to_date'] );
	$xtpl->assign( 'FROM_DATE', $date_array['from_date'] );
	$xtpl->assign( 'KEY', $key );
	$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
	$xtpl->assign( 'OP_NAME', 'search' );

	foreach( $array_cat_search as $search_cat )
	{
		$xtpl->assign( 'SEARCH_CAT', $search_cat );
		$xtpl->parse( 'main.search_cat' );
	}

	for( $i = 0; $i <= 3; ++$i )
	{
		if( $check_num == $i )
		{
			$xtpl->assign( 'CHECK' . $i, 'selected=\'selected\'' );
		}
		else
		{
			$xtpl->assign( 'CHECK' . $i, '' );
		}
	}

	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function search_result_theme( $key, $numRecord, $per_pages, $page, $array_content, $catid )
{
	global $module_file, $module_info, $lang_module, $module_name, $global_array_cat, $module_config, $global_config;

	$xtpl = new XTemplate( 'search.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'KEY', $key );
	$xtpl->assign( 'IMG_WIDTH', $module_config[$module_name]['homewidth'] );
	$xtpl->assign( 'TITLE_MOD', $lang_module['search_modul_title'] );

	if( ! empty( $array_content ) )
	{
		foreach( $array_content as $value )
		{
			$catid_i = $value['catid'];

			$xtpl->assign( 'LINK', $global_array_cat[$catid_i]['link'] . '/' . $value['alias'] . "-" . $value['id'] . $global_config['rewrite_exturl'] );
			$xtpl->assign( 'TITLEROW', strip_tags( BoldKeywordInStr( $value['title'], $key ) ) );
			$xtpl->assign( 'CONTENT', BoldKeywordInStr( $value['hometext'], $key ) . "..." );
			$xtpl->assign( 'TIME', date( 'd/m/Y h:i:s A', $value['publtime'] ) );
			$xtpl->assign( 'AUTHOR', BoldKeywordInStr( $value['author'], $key ) );
			$xtpl->assign( 'SOURCE', BoldKeywordInStr( GetSourceNews( $value['sourceid'] ), $key ) );

			if( ! empty( $value['homeimgfile'] ) )
			{
				$xtpl->assign( 'IMG_SRC', $value['homeimgfile'] );
				$xtpl->parse( 'results.result.result_img' );
			}

			$xtpl->parse( 'results.result' );
		}
	}

	if( $numRecord == 0 )
	{
		$xtpl->assign( 'KEY', $key );
		$xtpl->assign( 'INMOD', $lang_module['search_modul_title'] );
		$xtpl->parse( 'results.noneresult' );
	}

	if( $numRecord > $per_pages )// show pages
	{
		$url_link = $_SERVER['REQUEST_URI'];
		if( strpos( $url_link, '&page=' ) > 0 )
		{
			$url_link = substr( $url_link, 0, strpos( $url_link, '&page=' ) );
		}
		elseif( strpos( $url_link, '?page=' ) > 0)
		{
			$url_link = substr( $url_link, 0, strpos( $url_link, '?page=' ) );
		}
		$_array_url = array( 'link' => $url_link, 'amp' => '&page=' );
		$generate_page = nv_generate_page( $_array_url, $numRecord, $per_pages, $page );

		$xtpl->assign( 'VIEW_PAGES', $generate_page );
		$xtpl->parse( 'results.pages_result' );
	}

	$xtpl->assign( 'NUMRECORD', $numRecord );
	$xtpl->assign( 'MY_DOMAIN', NV_MY_DOMAIN );

	$xtpl->parse( 'results' );
	return $xtpl->text( 'results' );
}