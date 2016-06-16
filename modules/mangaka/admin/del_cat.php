<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-10-2010 18:49
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$catid = $nv_Request->get_int( 'catid', 'post', 0 );
$contents = "NO_" . $catid;

list( $catid, $title ) = $db->query( "SELECT catid, title FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE catid=" . intval( $catid ) )->fetch( 3 );
if( $catid > 0 )
{
	if( ( defined( 'NV_IS_ADMIN_MODULE' ) or ( $catid > 0 and isset( $array_cat_admin[$admin_id][$catid] ) and $array_cat_admin[$admin_id][$catid]['admin'] == 1 ) ) )
	{
		$delallcheckss = $nv_Request->get_string( 'delallcheckss', 'post', '' );
		if( $delallcheckss == md5( $catid . session_id() . $global_config['sitekey'] ) )
		{
			nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['delcatandrows'], $title, $admin_info['userid'] );
			
			$sql = $db->query('SELECT id, catid, listcatid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_' . $catid);
			while ($row = $sql->fetch()) {
				if ($row['catid'] == $row['listcatid']) {
					nv_del_content_module($row['id']);
				} else {
					$arr_catid_old = explode(',', $row['listcatid']);
					$arr_catid_i = array( $catid );
					$arr_catid_news = array_diff($arr_catid_old, $arr_catid_i);
					if ($catid == $row['catid']) {
						$row['catid'] = $arr_catid_news[0];
					}
					foreach ($arr_catid_news as $catid_i) {
						if (isset($global_array_cat[$catid_i])) {
							$db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_" . $catid_i . " SET catid=" . $row['catid'] . ", listcatid = '" . implode(',', $arr_catid_news) . "' WHERE id =" . $row['id']);
						}
					}
					$db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_rows SET catid=" . $row['catid'] . ", listcatid = '" . implode(',', $arr_catid_news) . "' WHERE id =" . $row['id']);
				}
			}
			
			$db->query( "DROP TABLE " . NV_PREFIXLANG . "_" . $module_data . "_" . $catid );
			$db->query( "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE catid=" . $catid );
			$db->query( "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_rows WHERE catid=" . $catid );
			$db->query( "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_block WHERE catid=" . $catid );
			$db->query( 'DELETE FROM ' . NV_PREFIXLANG . '_comment WHERE module=' . $db->quote( $module_name ) . ' AND id = ' . $catid );
			$db->query( "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_admins WHERE catid=" . $catid );
			
			$nv_Cache->delMod( $module_name );
			
			$contents = "OK_" . $catid;
		}
		else
		{
			$contents = "ERR_ROWS_" . $catid . "_" . md5( $catid . session_id() . $global_config['sitekey'] ) . "_" . sprintf( $lang_module['delcat_msg_rows'], $check_rows );
		}
	}
	else
	{
		$contents = "ERR_CAT_" . $lang_module['delcat_msg_cat_permissions'];
	}
}

if( defined( 'NV_IS_AJAX' ) )
{
	include NV_ROOTDIR . '/includes/header.php';
	echo $contents;
	include NV_ROOTDIR . '/includes/footer.php';
}
else
{
	Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=cat' );
	die();
}