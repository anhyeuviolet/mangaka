<?php

/**
 * @Project MANGA ON NUKEVIET 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 03-05-2010
 */

if( ! defined( 'NV_IS_MOD_SEARCH' ) ) die( 'Stop!!!' );

$db->sqlreset()
	->select( 'COUNT(*)' )
	->from( NV_PREFIXLANG . '_' . $m_values['module_data'] . '_cat')
	->where('(' . nv_like_logic( 'title', $dbkeywordhtml, $logic ) . ' OR ' . nv_like_logic( 'description', $dbkeyword, $logic ) . ') OR ' . nv_like_logic( 'descriptionhtml', $dbkeyword, $logic ) . '	AND inhome= 1' );

$num_items = $db->query( $db->sql() )->fetchColumn();

if( $num_items )
{
	$array_cat_alias = array();
	$array_cat_alias[0] = 'other';

	$sql_cat = 'SELECT catid, alias FROM ' . NV_PREFIXLANG . '_' . $m_values['module_data'] . '_cat';
	$re_cat = $db->query( $sql_cat );
	while( list( $catid, $alias ) = $re_cat->fetch( 3 ) )
	{
		$array_cat_alias[$catid] = $alias;
	}

	$link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $m_values['module_name'] . '&amp;' . NV_OP_VARIABLE . '=';

	$db->select( 'catid, title, alias, description, descriptionhtml' )
		->order( 'alias ASC' )
		->limit( $limit )
		->offset( ( $page - 1 ) * $limit );
	$result = $db->query( $db->sql() );
	while( list( $catid, $tilterow, $alias, $description, $descriptionhtml ) = $result->fetch( 3 ) )
	{

		$url = $link . $array_cat_alias[$catid];

		$result_array[] = array(
			'link' => $url,
			'title' => BoldKeywordInStr( $tilterow, $key, $logic ),
			'content' => BoldKeywordInStr( $descriptionhtml, $key, $logic )
		);
	}
}