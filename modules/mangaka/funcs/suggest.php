<?php

/**
 * @Project MANGA ON NUKEVIET 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 12/31/2009 0:51
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
		$contents .= '<div class="show">';
		$contents .= '<span class="name"><a href="'. $link .'" title="'.$row['title'].'">' . $row['title'] . '</a></span>';
		$contents .= '</div>';
	}
	$contents .= '<script>function filltext( text ){ $("#keyword").val( text ) }</script>';
} else
{
	$contents .= '<div class="show text-center">';
	$contents .= '<span class="name" >'.$lang_module['no_data'].'</span>';
	$contents .= '</div>';
}

include ( NV_ROOTDIR . "/includes/header.php" );
echo $contents;
include ( NV_ROOTDIR . "/includes/footer.php" );