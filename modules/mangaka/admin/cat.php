<?php

/**
 * @Project MANGA ON NUKEVIET 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 05/07/2010 09:47
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['categories'];

if( defined( 'NV_EDITOR' ) )
{
	require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
}

$error = $admins = '';
$savecat = 0;
list( $catid, $title, $titlesite, $alias, $description, $descriptionhtml, $keywords, $authors, $translators, $groups_view, $block_id, $image, $image_type, $progress, $inhome, $allowed_rating ) = array( 0, '', '', '', '', '', '', '', '', '6','', '','', '', 1,1 );

$groups_list = nv_groups_list();
$allowed_comm = $module_config[$module_name]['setcomm'];

$catid = $nv_Request->get_int( 'catid', 'get', 0 );

if( $catid > 0 and isset( $global_array_cat[$catid] ) )
{
	$title = $global_array_cat[$catid]['title'];
	$titlesite = $global_array_cat[$catid]['titlesite'];
	$alias = $global_array_cat[$catid]['alias'];
	$description = $global_array_cat[$catid]['description'];
	$descriptionhtml = $global_array_cat[$catid]['descriptionhtml'];
	$progress = $global_array_cat[$catid]['progress'];
	$inhome = $global_array_cat[$catid]['inhome'];
	$allowed_rating = $global_array_cat[$catid]['allowed_rating'];
	$image = $global_array_cat[$catid]['image'];
	$image_type = $global_array_cat[$catid]['image_type'];
	$keywords = $global_array_cat[$catid]['keywords'];
	$authors = $global_array_cat[$catid]['authors'];
	$translators = $global_array_cat[$catid]['translators'];
	$groups_view = $global_array_cat[$catid]['groups_view'];
	$block_id = $global_array_cat[$catid]['bid'];

	if( ! defined( 'NV_IS_ADMIN_MODULE' ) )
	{
		if( ! ( isset( $array_cat_admin[$admin_id] ) and $array_cat_admin[$admin_id]['admin'] == 1 ) )
		{
			Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
			die();
		}
	}

	$caption = $lang_module['edit_cat'];
}
else
{
	$caption = $lang_module['add_cat'];
}

$array_block_cat_module = array();
$sql = 'SELECT bid, title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat ORDER BY title ASC';
$result = $db->query( $sql );
while( list( $bid_i, $title_i ) = $result->fetch( 3 ) )
{
	$array_block_cat_module[$bid_i] = $title_i;

}

$savecat = $nv_Request->get_int( 'savecat', 'post', 0 );

if( ! empty( $savecat ) )
{
	$catid = $nv_Request->get_int( 'catid', 'post', 0 );
	$title = $nv_Request->get_title( 'title', 'post', '', 1 );
	$titlesite = $nv_Request->get_title( 'titlesite', 'post', '', 1 );
	$keywords = $nv_Request->get_title( 'keywords', 'post', '', 1 );
	$authors = $nv_Request->get_title( 'authors', 'post', '', 1 );
	$translators = $nv_Request->get_title( 'translators', 'post', '', 1 );
	$description = $nv_Request->get_string( 'description', 'post', '' );
	$description = nv_nl2br( nv_htmlspecialchars( strip_tags( $description ) ), '<br />' );
	$descriptionhtml = $nv_Request->get_editor( 'descriptionhtml', '', NV_ALLOWED_HTML_TAGS );

	$progress = $nv_Request->get_int( 'progress', 'post', 0 );
	$inhome = $nv_Request->get_int( 'inhome', 'post', 0 );
	$allowed_rating = $nv_Request->get_int( 'allowed_rating', 'post', 0 );

	// Xu ly lien ket tinh
	$_alias = $nv_Request->get_title( 'alias', 'post', '' );
	$_alias = ( $_alias == '' ) ? change_alias( $title ) : change_alias( $_alias );
	
	//Cau hinh binh luan
	$_groups_comm = $nv_Request->get_array( 'allowed_comm', 'post', array() );
	$allowed_comm = ! empty( $_groups_comm ) ? implode( ',', nv_groups_post( array_intersect( $_groups_comm, array_keys( $groups_list ) ) ) ) : '';


	if( empty( $_alias ) or ! preg_match( "/^([a-zA-Z0-9\_\-]+)$/", $_alias ) )
	{
		if( empty( $alias ) )
		{
			if( $catid )
			{
				$alias = 'cat-' . $catid;
			}
			else
			{
				$_m_catid = $db->query( 'SELECT MAX(catid) AS cid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat' )->fetchColumn();

				if( empty( $_m_catid ) )
				{
					$alias = 'cat-1';
				}
				else
				{
					$alias = 'cat-' . ( intval( $_m_catid ) + 1 );
				}
			}
		}
	}
	else
	{
		$alias = $_alias;
	}

	$_groups_post = $nv_Request->get_array( 'groups_view', 'post', array() );
	$groups_view = ! empty( $_groups_post ) ? implode( ',', nv_groups_post( array_intersect( $_groups_post, array_keys( $groups_list ) ) ) ) : '';
	
	// Nhan gia tri truyen tu HTML bids
	$_block_id_post = $nv_Request->get_array( 'bids', 'post', array() );
	$block_id = implode( ',', $_block_id_post );
	// Xu ly anh minh hoa
	$image = $nv_Request->get_string( 'image', 'post', '' );
	$image_type = 0;
	if( ! nv_is_url( $image ) and is_file( NV_DOCUMENT_ROOT . $image ) )
	{
		$lu = strlen( NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/cover/' );
		$image = substr( $image, $lu );
		if( file_exists( NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_name . '/cover/' . $image ) )
		{
			$image_type = 1;
		}
		else
		{
			$image_type = 2;
		}
	}
	elseif( nv_is_url( $image ) )
	{
		$image_type = 3;
	}
	else
	{
		$image = '';
	}

	if( ! defined( 'NV_IS_ADMIN_MODULE' ) )
	{
		if( ! ( isset( $array_cat_admin[$admin_id] ) and $array_cat_admin[$admin_id]['admin'] == 1 ) )
		{
			Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
			die();
		}
	}
	if( empty( $error ) )
	{
		if( $catid == 0 and $title != '' )
		{
			$viewcat = 'viewcat_list';

			$sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_cat ( title, titlesite, alias, description, descriptionhtml, image, image_type, progress, viewcat, inhome, allowed_rating, keywords, authors, translators, admins, add_time, edit_time, groups_view, allowed_comm, bid, last_update) VALUES
				(:title, :titlesite, :alias, :description, :descriptionhtml, :image, :image_type, '" . $progress . "', :viewcat, '" . $inhome . "', '" . $allowed_rating . "', :keywords, :authors, :translators, :admins, " . NV_CURRENTTIME . ", " . NV_CURRENTTIME . ", :groups_view, :allowed_comm, :bid, " . NV_CURRENTTIME . " )";

			$data_insert = array();
			$data_insert['title'] = $title;
			$data_insert['titlesite'] = $titlesite;
			$data_insert['alias'] = $alias;
			$data_insert['description'] = $description;
			$data_insert['descriptionhtml'] = $descriptionhtml;
			$data_insert['image'] = $image;
			$data_insert['image_type'] = $image_type;
			$data_insert['viewcat'] = $viewcat;
			$data_insert['keywords'] = $keywords;
			$data_insert['authors'] = $authors;
			$data_insert['translators'] = $translators;
			$data_insert['admins'] = $admins;
			$data_insert['groups_view'] = $groups_view;
			$data_insert['allowed_comm'] = $allowed_comm;
			$data_insert['bid'] = $block_id;
			$newcatid = $db->insert_id( $sql, 'catid', $data_insert );
			if( $newcatid > 0 )
			{
				require_once NV_ROOTDIR . '/includes/action_' . $db->dbtype . '.php';
				// Them moi bid khi them moi Cat
				foreach( $_block_id_post as $gb_id_add )
				{
					$db->query( 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_block (bid, catid) VALUES (' . $gb_id_add . ', ' . $newcatid . ')' );
				}
				nv_copy_structure_table( NV_PREFIXLANG . '_' . $module_data . '_' . $newcatid , NV_PREFIXLANG . '_' . $module_data . '_rows' );
				//nv_fix_cat_order();
				if( ! defined( 'NV_IS_ADMIN_MODULE' ) )
				{
					$db->query( 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_admins (userid, catid, admin, add_content, pub_content, edit_content, del_content) VALUES (' . $admin_id . ', ' . $newcatid . ', 1, 1, 1, 1, 1)' );
				}
				nv_del_moduleCache( $module_name );
				nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['add_cat'], $title, $admin_info['userid'] );
			}
			else
			{
				$error = $lang_module['errorsave'];
			}
		}
		elseif( $catid > 0 and $title != '' )
		{
			$stmt = $db->prepare( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_cat SET title= :title, titlesite=:titlesite, alias = :alias, description = :description, descriptionhtml = :descriptionhtml, image= :image, image_type= :image_type, progress= :progress, inhome= :inhome, allowed_rating= :allowed_rating, keywords= :keywords, authors= :authors, translators= :translators, groups_view= :groups_view, allowed_comm= :allowed_comm, bid= :bid, edit_time=' . NV_CURRENTTIME . ' WHERE catid =' . $catid );
			$stmt->bindParam( ':title', $title, PDO::PARAM_STR );
			$stmt->bindParam( ':titlesite', $titlesite, PDO::PARAM_STR );
			$stmt->bindParam( ':alias', $alias, PDO::PARAM_STR );
			$stmt->bindParam( ':image', $image, PDO::PARAM_STR );
			$stmt->bindParam( ':image_type', $image_type, PDO::PARAM_STR );
			$stmt->bindParam( ':progress', $progress, PDO::PARAM_STR );
			$stmt->bindParam( ':inhome', $inhome, PDO::PARAM_STR );
			$stmt->bindParam( ':allowed_rating', $allowed_rating, PDO::PARAM_STR );
			$stmt->bindParam( ':keywords', $keywords, PDO::PARAM_STR );
			$stmt->bindParam( ':authors', $authors, PDO::PARAM_STR );
			$stmt->bindParam( ':translators', $translators, PDO::PARAM_STR );
			$stmt->bindParam( ':description', $description, PDO::PARAM_STR, strlen( $description ) );
			$stmt->bindParam( ':descriptionhtml', $descriptionhtml, PDO::PARAM_STR, strlen( $descriptionhtml ) );
			$stmt->bindParam( ':groups_view', $groups_view, PDO::PARAM_STR );
			$stmt->bindParam( ':allowed_comm', $allowed_comm, PDO::PARAM_STR );
			$stmt->bindParam( ':bid', $block_id, PDO::PARAM_STR );
			$stmt->execute();

			if( $stmt->rowCount() )
			{
				//Xoa bid cua cat tuong ung va chen vao bid moi
				$db->query( 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block WHERE catid = ' . $catid );
				foreach( $_block_id_post as $gb_id_add )
				{
					$db->query( 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_block (bid, catid) VALUES (' . $gb_id_add . ', ' . $catid . ')' );
				}
				nv_del_moduleCache( $module_name );
			}
			else
			{
				$error = $lang_module['errorsave'];
			}
		}
		nv_set_status_module();
		if( empty( $error ) )
		{
			$url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=cat_manage';
			$msg1 = $lang_module['content_saveok'];
			$msg2 = $lang_module['back']. ' ' .$lang_module['categories_list'];
			redirect( $msg1, $msg2, $url, '' );
		}
	}
	else
	{
		$error = $lang_module['error_name'];
	}
}
$groups_view = explode( ',', $groups_view );
// Tach bids de truy van
$block_id = explode( ',', $block_id );

$array_cat_list = array();
if( defined( 'NV_IS_ADMIN_MODULE' ) )
{
	$array_cat_list[0] = $lang_module['cat_sub_sl'];
}

if( ! empty( $array_cat_list ) )
{

	$groups_views = array();
	foreach( $groups_list as $group_id => $grtl )
	{
		$groups_views[] = array(
			'value' => $group_id,
			'checked' => in_array( $group_id, $groups_view ) ? ' checked="checked"' : '',
			'title' => $grtl
		);
	}
}

$lang_global['title_suggest_max'] = sprintf( $lang_global['length_suggest_max'], 65 );
$lang_global['description_suggest_max'] = sprintf( $lang_global['length_suggest_max'], 160 );

$xtpl = new XTemplate( 'cat.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'GLANG', $lang_global );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
$xtpl->assign( 'TO_CAT_LIST',  NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . '&' . NV_OP_VARIABLE . '=cat_manage' );

$xtpl->assign( 'caption', $caption );
$xtpl->assign( 'catid', $catid );
$xtpl->assign( 'title', $title );
$xtpl->assign( 'titlesite', $titlesite );
$xtpl->assign( 'alias', $alias );
$xtpl->assign( 'keywords', $keywords );
$xtpl->assign( 'authors', $authors );
$xtpl->assign( 'translators', $translators );
$xtpl->assign( 'description', nv_htmlspecialchars( nv_br2nl( $description ) ) );

$xtpl->assign( 'UPLOAD_CURRENT', NV_UPLOADS_DIR . '/' . $module_name . '/cover/' );
if( ! empty( $image ) and file_exists( NV_UPLOADS_REAL_DIR . '/' . $module_name . '/cover/' . $image ) )
{
	$image = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/cover/' . $image;
}
$xtpl->assign( 'image', $image );

//Allow Comment
$allowed_comm = explode( ',', $allowed_comm );
foreach( $groups_list as $_group_id => $_title )
{
	$xtpl->assign( 'ALLOWED_COMM', array(
		'value' => $_group_id,
		'checked' => in_array( $_group_id, $allowed_comm ) ? ' checked="checked"' : '',
		'title' => $_title
	) );
	$xtpl->parse( 'main.content.allowed_comm' );
}
if( $module_config[$module_name]['allowed_comm'] != '-1' )
{
	$xtpl->parse( 'main.content.content_note_comm' );
}


// Tien do thuc hien
for( $i = 1; $i <= 3; $i++ )
{
	$data_prg = array(
		'value' => $i,
		'selected' => ( $progress == $i ) ? ' selected="selected"' : '',
		'title' => $lang_module['progress_' . $i]
	);
	$xtpl->assign( 'PROGRESS', $data_prg );
	$xtpl->parse( 'main.content.progress' );
}
// Hien thi trang chu
for( $a = 0; $a <= 1; $a++ )
{
	$data_inh = array(
		'value' => $a,
		'selected' => ( $inhome == $a ) ? ' selected="selected"' : '',
		'title' => $lang_module['inhome_' . $a]
	);
	$xtpl->assign( 'INHOME', $data_inh );
	$xtpl->parse( 'main.content.inhome' );
}

$allowed_rating_checked = ( $allowed_rating ) ? ' checked="checked"' : '';
$xtpl->assign( 'allowed_rating_checked', $allowed_rating_checked );

//Truy van lay du lieu bid tu DB
if( sizeof( $array_block_cat_module ) )
{
	foreach( $array_block_cat_module as $bid_i => $bid_title )
	{
		$xtpl->assign( 'BLOCKS', array( 'title' => $bid_title, 'bid' => $bid_i, 'selected' =>  in_array( $bid_i, $block_id ) ? 'selected="selected"' : '' ) );
		$xtpl->parse( 'main.content.block_cat.loop' );
	}
	$xtpl->parse( 'main.content.block_cat' );
}

if( ! empty( $error ) )
{
	$xtpl->assign( 'ERROR', $error );
	$xtpl->parse( 'main.error' );
}

if( ! empty( $array_cat_list ) )
{
	if( empty( $alias ) )
	{
		$xtpl->parse( 'main.content.getalias' );
	}
	foreach( $groups_views as $data )
	{
		$xtpl->assign( 'groups_views', $data );
		$xtpl->parse( 'main.content.groups_views' );
	}

	$descriptionhtml = nv_htmlspecialchars( nv_editor_br2nl( $descriptionhtml ) );
	if( defined( 'NV_EDITOR' ) and nv_function_exists( 'nv_aleditor' ) )
	{
		$_uploads_dir = NV_UPLOADS_DIR . '/' . $module_name.'/cover/';
		$descriptionhtml = nv_aleditor( 'descriptionhtml', '100%', '200px', $descriptionhtml, 'Basic', $_uploads_dir, $_uploads_dir );
	}
	else
	{
		$descriptionhtml = "<textarea style=\"width: 100%\" name=\"descriptionhtml\" id=\"descriptionhtml\" cols=\"20\" rows=\"15\">" . $descriptionhtml . "</textarea>";
	}
	$xtpl->assign( 'DESCRIPTIONHTML', $descriptionhtml );
	
		$xtpl->parse( 'main.content' );

}
$xtpl->parse( 'main' );
$contents .= $xtpl->text( 'main' );

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';