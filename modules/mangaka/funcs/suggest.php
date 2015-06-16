<?php

/**
 * @Project NUKEVIET 3.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES., JSC. All rights reserved
 * @Createdate 3-6-2010 0:14
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );
global $global_array_cat, $catid;
$keywords = $nv_Request->get_title( 'keywords', 'post', '' );
$contents = '';

$sql = 'SELECT catid, title, alias FROM ' . $db_config['prefix'] . '_' .NV_LANG_DATA. '_' .$module_data . '_cat WHERE title like "%' . $keywords . '%" OR keywords like "%' . $keywords . '%" OR description like "%' . $keywords . '%"';
$result = $db->query( $sql );
$num = $result->rowCount();
if( $num > 0 )
{
	while( $row = $result->fetch() )
	{
		$title = $row['title'];
		$title_s = '<strong>' . $row['title'] . '</strong>';
		$link = $global_array_cat[$row['catid']]['link'];
		$contents .= '<div class="show" align="left">';
		$contents .= '<span class="name" onclick="filltext( $(this).text() );"><a href="'. $link .'" title="">' . $row['title'] . '</a></span>';
		$contents .= '</div>';
	}
	$contents .= '<script>function filltext( text ){ $("#keyword").val( text ) }</script>';
}

include ( NV_ROOTDIR . "/includes/header.php" );
echo $contents;
include ( NV_ROOTDIR . "/includes/footer.php" );