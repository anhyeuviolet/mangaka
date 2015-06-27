<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-9-2010 14:43
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['setting'];

if( defined( 'NV_EDITOR' ) )
{
	require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
}

$savesetting = $nv_Request->get_int( 'savesetting', 'post', 0 );
if( ! empty( $savesetting ) )
{
	$array_config = array();
	$array_config['indexfile'] = $nv_Request->get_title( 'indexfile', 'post', '', 1 );
	$array_config['per_page'] = $nv_Request->get_int( 'per_page', 'post', 0 );
	$array_config['homewidth'] = $nv_Request->get_int( 'homewidth', 'post', 0 );
	$array_config['homeheight'] = $nv_Request->get_int( 'homeheight', 'post', 0 );
	$array_config['blockwidth'] = $nv_Request->get_int( 'blockwidth', 'post', 0 );
	$array_config['blockheight'] = $nv_Request->get_int( 'blockheight', 'post', 0 );
	$array_config['imagefull'] = $nv_Request->get_int( 'imagefull', 'post', 0 );

	$array_config['allowed_rating_point'] = $nv_Request->get_int( 'allowed_rating_point', 'post', 0 );


	$array_config['disqus_shortname'] = $nv_Request->get_title( 'disqus_shortname', 'post', '' );
	$array_config['facebookappid'] = $nv_Request->get_title( 'facebookappid', 'post', '' );
	$array_config['facebookadminid'] = $nv_Request->get_title( 'facebookadminid', 'post', '' );
	
	$array_config['socialbutton'] = $nv_Request->get_int( 'socialbutton', 'post', 0 );	
	$array_config['facebookcomment'] = $nv_Request->get_int( 'facebookcomment', 'post', 0 );

	$array_config['show_no_image'] = $nv_Request->get_title( 'show_no_image', 'post', '', 0 );
	$array_config['structure_upload'] = $nv_Request->get_title( 'structure_upload', 'post', '', 0 );
	$array_config['config_source'] = $nv_Request->get_int( 'config_source', 'post', 0 );
	$array_config['imgposition'] = $nv_Request->get_int( 'imgposition', 'post', 0 );
	
	
	$array_config['alias_lower'] = $nv_Request->get_int( 'alias_lower', 'post', 0 );

	if( ! nv_is_url( $array_config['show_no_image'] ) and file_exists( NV_DOCUMENT_ROOT . $array_config['show_no_image'] ) )
	{
		$lu = strlen( NV_BASE_SITEURL );
		$array_config['show_no_image'] = substr( $array_config['show_no_image'], $lu );
	}
	else
	{
		$array_config['show_no_image'] = '';
	}

	$sth = $db->prepare( "UPDATE " . NV_CONFIG_GLOBALTABLE . " SET config_value = :config_value WHERE lang = '" . NV_LANG_DATA . "' AND module = :module_name AND config_name = :config_name" );
	$sth->bindParam( ':module_name', $module_name, PDO::PARAM_STR );
	foreach( $array_config as $config_name => $config_value )
	{
		$sth->bindParam( ':config_name', $config_name, PDO::PARAM_STR );
		$sth->bindParam( ':config_value', $config_value, PDO::PARAM_STR );
		$sth->execute();
	}

	nv_del_moduleCache( 'settings' );
	nv_del_moduleCache( $module_name );
	Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&rand=' . nv_genpass() );
	die();
}

$xtpl = new XTemplate( 'settings.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'GLANG', $lang_global );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
$xtpl->assign( 'DATA', $module_config[$module_name] );

// Cach hien thi tren trang chu
foreach( $array_viewcat_full as $key => $val )
{
	$xtpl->assign( 'INDEXFILE', array(
		'key' => $key,
		'title' => $val,
		'selected' => $key == $module_config[$module_name]['indexfile'] ? ' selected="selected"' : ''
	) );
	$xtpl->parse( 'main.indexfile' );
}

// So bai viet tren mot trang
for( $i = 5; $i <= 30; ++$i )
{
	$xtpl->assign( 'PER_PAGE', array(
		'key' => $i,
		'title' => $i,
		'selected' => $i == $module_config[$module_name]['per_page'] ? ' selected="selected"' : ''
	) );
	$xtpl->parse( 'main.per_page' );
}


// Show points rating article on google
for( $i = 0; $i <= 6; ++$i )
{
	$xtpl->assign( 'RATING_POINT', array(
		'key' => $i,
		'title' => ($i == 6) ? $lang_module['no_allowed_rating'] : $i,
		"selected" => $i == $module_config[$module_name]['allowed_rating_point'] ? " selected=\"selected\"" : ""
	) );
	$xtpl->parse( 'main.allowed_rating_point' );
}

$xtpl->assign( 'SOCIALBUTTON', $module_config[$module_name]['socialbutton'] ? ' checked="checked"' : '' );
$xtpl->assign( 'FB_COMM', $module_config[$module_name]['facebookcomment'] ? ' checked="checked"' : '' );
$xtpl->assign( 'ALIAS_LOWER', $module_config[$module_name]['alias_lower'] ? ' checked="checked"' : '' );
$xtpl->assign( 'SHOW_NO_IMAGE', ( !empty( $module_config[$module_name]['show_no_image'] ) ) ? NV_BASE_SITEURL . $module_config[$module_name]['show_no_image'] : '' );

$array_structure_image = array();
$array_structure_image[''] = NV_UPLOADS_DIR . '/' . $module_name;
$array_structure_image['Y'] = NV_UPLOADS_DIR . '/' . $module_name . '/' . date( 'Y' );
$array_structure_image['Ym'] = NV_UPLOADS_DIR . '/' . $module_name . '/' . date( 'Y_m' );
$array_structure_image['Y_m'] = NV_UPLOADS_DIR . '/' . $module_name . '/' . date( 'Y/m' );
$array_structure_image['Ym_d'] = NV_UPLOADS_DIR . '/' . $module_name . '/' . date( 'Y_m/d' );
$array_structure_image['Y_m_d'] = NV_UPLOADS_DIR . '/' . $module_name . '/' . date( 'Y/m/d' );
$array_structure_image['username'] = NV_UPLOADS_DIR . '/' . $module_name . '/username_admin';

$array_structure_image['username_Y'] = NV_UPLOADS_DIR . '/' . $module_name . '/username_admin/' . date( 'Y' );
$array_structure_image['username_Ym'] = NV_UPLOADS_DIR . '/' . $module_name . '/username_admin/' . date( 'Y_m' );
$array_structure_image['username_Y_m'] = NV_UPLOADS_DIR . '/' . $module_name . '/username_admin/' . date( 'Y/m' );
$array_structure_image['username_Ym_d'] = NV_UPLOADS_DIR . '/' . $module_name . '/username_admin/' . date( 'Y_m/d' );
$array_structure_image['username_Y_m_d'] = NV_UPLOADS_DIR . '/' . $module_name . '/username_admin/' . date( 'Y/m/d' );

$structure_image_upload = isset( $module_config[$module_name]['structure_upload'] ) ? $module_config[$module_name]['structure_upload'] : "Ym";

// Thu muc uploads
foreach( $array_structure_image as $type => $dir )
{
	$xtpl->assign( 'STRUCTURE_UPLOAD', array(
		'key' => $type,
		'title' => $dir,
		'selected' => $type == $structure_image_upload ? ' selected="selected"' : ''
	) );
	$xtpl->parse( 'main.structure_upload' );
}

// Cau hinh hien thi nguon tin
$array_config_source = array( $lang_module['config_source_title'], $lang_module['config_source_link'], $lang_module['config_source_logo'] );
foreach( $array_config_source as $key => $val )
{
	$xtpl->assign( 'CONFIG_SOURCE', array(
		'key' => $key,
		'title' => $val,
		'selected' => $key == $module_config[$module_name]['config_source'] ? ' selected="selected"' : ''
	) );
	$xtpl->parse( 'main.config_source' );
}



$xtpl->assign( 'PATH', defined( 'NV_IS_SPADMIN' ) ? "" : NV_UPLOADS_DIR . '/' . $module_name );
$xtpl->assign( 'CURRENTPATH', defined( 'NV_IS_SPADMIN' ) ? "images" : NV_UPLOADS_DIR . '/' . $module_name );

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';