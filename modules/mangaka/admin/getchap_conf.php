<?php

/**
 * @Project MANGA ON NUKEVIET 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 18 June 2015 09:47:16 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

if ( $nv_Request->isset_request( 'delete_id', 'get' ) and $nv_Request->isset_request( 'delete_checkss', 'get' ))
{
	$id = $nv_Request->get_int( 'delete_id', 'get' );
	$delete_checkss = $nv_Request->get_string( 'delete_checkss', 'get' );
	if( $id > 0 and $delete_checkss == md5( $id . NV_CACHE_PREFIX . $client_info['session_id'] ) )
	{
		$db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_get_chap  WHERE id = ' . $db->quote( $id ) );
		nv_del_moduleCache( nvtools );
		Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
		die();
	}
}

$row = array();
$error = array();
$row['id'] = $nv_Request->get_int( 'id', 'post,get', 0 );
if ( $nv_Request->isset_request( 'submit', 'post' ) )
{
	$row['title'] = $nv_Request->get_title( 'title', 'post', '' );
	$row['url_host'] = $nv_Request->get_title( 'url_host', 'post', '' );
	$row['url_html_pattern'] = $nv_Request->get_title( 'url_html_pattern', 'post', '' );
	$row['url_pattern'] = $nv_Request->get_title( 'url_pattern', 'post', '' );
	$row['img_structure'] = $nv_Request->get_title( 'img_structure', 'post', '' );
	$row['chapno_structure'] = $nv_Request->get_title( 'chapno_structure', 'post', '' );
	$row['preg_img_structure'] = $nv_Request->get_title( 'preg_img_structure', 'post', '' );
	$row['replace_1'] = $nv_Request->get_title( 'replace_1', 'post', '' );
	$row['replace_2'] = $nv_Request->get_title( 'replace_2', 'post', '' );
	$row['replace_3'] = $nv_Request->get_title( 'replace_3', 'post', '' );
	$row['numget_img'] = $nv_Request->get_title( 'numget_img', 'post', '' );
	$row['preg_chapno_structure'] = $nv_Request->get_title( 'preg_chapno_structure', 'post', '' );
	$row['numget_chap'] = $nv_Request->get_title( 'numget_chap', 'post', '' );

	if( empty( $row['title'] ) )
	{
		$error[] = $lang_module['error_required_title'];
	}

	if( empty( $error ) )
	{
		try
		{
			if( empty( $row['id'] ) )
			{

				$stmt = $db->prepare( 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_get_chap (title, url_host, url_html_pattern, url_pattern, img_structure, chapno_structure, preg_img_structure, replace_1, replace_2, replace_3, numget_img, preg_chapno_structure, numget_chap, add_time, edit_time) VALUES (:title, :url_host, :url_html_pattern, :url_pattern, :img_structure, :chapno_structure, :preg_img_structure, :replace_1, :replace_2, :replace_3, :numget_img, :preg_chapno_structure, :numget_chap, '. NV_CURRENTTIME .', '. NV_CURRENTTIME .')' );

			}
			else
			{
				$stmt = $db->prepare( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_get_chap SET title = :title, url_host = :url_host, url_html_pattern = :url_html_pattern, url_pattern = :url_pattern, img_structure = :img_structure, chapno_structure = :chapno_structure, preg_img_structure = :preg_img_structure, replace_1 = :replace_1, replace_2 = :replace_2, replace_3 = :replace_3, numget_img = :numget_img, preg_chapno_structure = :preg_chapno_structure, numget_chap = :numget_chap, edit_time ='.NV_CURRENTTIME.' WHERE id=' . $row['id'] );
			}
			$stmt->bindParam( ':title', $row['title'], PDO::PARAM_STR );
			$stmt->bindParam( ':url_host', $row['url_host'], PDO::PARAM_STR );
			$stmt->bindParam( ':url_html_pattern', $row['url_html_pattern'], PDO::PARAM_STR );
			$stmt->bindParam( ':url_pattern', $row['url_pattern'], PDO::PARAM_STR );
			$stmt->bindParam( ':img_structure', $row['img_structure'], PDO::PARAM_STR );
			$stmt->bindParam( ':chapno_structure', $row['chapno_structure'], PDO::PARAM_STR );
			$stmt->bindParam( ':preg_img_structure', $row['preg_img_structure'], PDO::PARAM_STR );
			$stmt->bindParam( ':replace_1', $row['replace_1'], PDO::PARAM_STR );
			$stmt->bindParam( ':replace_2', $row['replace_2'], PDO::PARAM_STR );
			$stmt->bindParam( ':replace_3', $row['replace_3'], PDO::PARAM_STR );
			$stmt->bindParam( ':numget_img', $row['numget_img'], PDO::PARAM_STR );
			$stmt->bindParam( ':preg_chapno_structure', $row['preg_chapno_structure'], PDO::PARAM_STR );
			$stmt->bindParam( ':numget_chap', $row['numget_chap'], PDO::PARAM_STR );

			$exc = $stmt->execute();
			if( $exc )
			{
				nv_del_moduleCache( $module_name );
				Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
				die();
			}
		}
		catch( PDOException $e )
		{
			trigger_error( $e->getMessage() );
			die( $e->getMessage() ); //Remove this line after checks finished
		}
	}
}
elseif( $row['id'] > 0 )
{
	$row = $db->query( 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_get_chap WHERE id=' . $row['id'] )->fetch();
	if( empty( $row ) )
	{
		Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
		die();
	}
}
else
{
	$row['id'] = 0;
	$row['title'] = '';
	$row['url_host'] = '';
	$row['url_html_pattern'] = '';
	$row['url_pattern'] = '';
	$row['img_structure'] = '';
	$row['chapno_structure'] = '';
	$row['preg_img_structure'] = '';
	$row['replace_1'] = '';
	$row['replace_2'] = '';
	$row['replace_3'] = '';
	$row['numget_img'] = '';
	$row['preg_chapno_structure'] = '';
	$row['numget_chap'] = '';
}

// Fetch Limit
$show_view = false;
if ( ! $nv_Request->isset_request( 'id', 'post,get' ) )
{
	$show_view = true;
	$db->sqlreset()
		->select( '*' )
		->from( '' . NV_PREFIXLANG . '_' . $module_data . '_get_chap' )
		->order( 'id DESC' );
	$sth = $db->prepare( $db->sql() );
	$sth->execute();
}

$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_LANG_VARIABLE', NV_LANG_VARIABLE );
$xtpl->assign( 'NV_LANG_DATA', NV_LANG_DATA );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
$xtpl->assign( 'ROW', $row );

if( $show_view )
{
	$number = 0;
	while( $view = $sth->fetch() )
	{
		$view['number'] = ++$number;
		$view['add_time'] = nv_date('H:i - d/m/y',$view['add_time']);
		$view['edit_time'] = nv_date('H:i - d/m/y',$view['edit_time']);
		$view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;id=' . $view['id'];
		$view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5( $view['id'] . NV_CACHE_PREFIX . $client_info['session_id'] );
		$xtpl->assign( 'VIEW', $view );
		$xtpl->parse( 'main.view.loop' );
	}
	$xtpl->parse( 'main.view' );
}

if( ! empty( $error ) )
{
	$xtpl->assign( 'ERROR', implode( '<br />', $error ) );
	$xtpl->parse( 'main.error' );
}
if( empty( $row['id'] ) )
{
	$xtpl->parse( 'main.auto_get_alias' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

$page_title = $lang_module['getchap_conf'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';