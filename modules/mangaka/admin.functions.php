<?php

/**
 * @Project MANGA ON NUKEVIET 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 12/31/2009 2:29
 */

if( ! defined( 'NV_ADMIN' ) or ! defined( 'NV_MAINFILE' ) or ! defined( 'NV_IS_MODADMIN' ) )
	die( 'Stop!!!' );

if( $NV_IS_ADMIN_MODULE )
{
	define( 'NV_IS_ADMIN_MODULE', true );
}

if( $NV_IS_ADMIN_FULL_MODULE )
{
	define( 'NV_IS_ADMIN_FULL_MODULE', true );
}

$array_viewcat_full = array(
	'viewcat_list_home' => $lang_module['viewcat_list_home'],
	'viewcat_full_home' => $lang_module['viewcat_full_home'],
	'viewcat_none' => $lang_module['viewcat_none']
);

$array_allowed_comm = array(
	$lang_global['no'],
	$lang_global['level6'],
	$lang_global['level4']
);

define( 'NV_IS_FILE_ADMIN', true );
require_once NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php';

global $global_array_cat;
$global_array_cat = array();
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat ORDER BY alias ASC';
$result = $db->query( $sql );
while( $row = $result->fetch() )
{
	$global_array_cat[$row['catid']] = $row;
}
//Tao URL khong dau, xu ly cac POST co chua ky tu la
//Chi cho phep number va dot

if(!function_exists("LamDepURL")){

    function LamDepURL($str)
    {
        $coDau=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ"
        ,"ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ","ì","í","ị","ỉ","ĩ",
            "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
        ,"ờ","ớ","ợ","ở","ỡ",
            "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
            "ỳ","ý","ỵ","ỷ","ỹ",
            "đ",
            "À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
        ,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
            "È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
            "Ì","Í","Ị","Ỉ","Ĩ",
            "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
        ,"Ờ","Ớ","Ợ","Ở","Ỡ",
            "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
            "Ỳ","Ý","Ỵ","Ỷ","Ỹ",
            "Đ","ê","ù","à"
			);
        $khongDau=array("a","a","a","a","a","a","a","a","a","a","a"
        ,"a","a","a","a","a","a",
            "e","e","e","e","e","e","e","e","e","e","e",
            "i","i","i","i","i",
            "o","o","o","o","o","o","o","o","o","o","o","o"
        ,"o","o","o","o","o",
            "u","u","u","u","u","u","u","u","u","u","u",
            "y","y","y","y","y",
            "d",
            "A","A","A","A","A","A","A","A","A","A","A","A"
        ,"A","A","A","A","A",
            "E","E","E","E","E","E","E","E","E","E","E",
            "I","I","I","I","I",
            "O","O","O","O","O","O","O","O","O","O","O","O"
        ,"O","O","O","O","O",
            "U","U","U","U","U","U","U","U","U","U","U",
            "Y","Y","Y","Y","Y",
            "D","e","u","a"
			);
        return str_replace($coDau,$khongDau,$str);
    }
}  
function clean($st) {
    $st = str_replace(' ', '', $st); // Replaces all spaces with hyphens.
	$st = preg_replace('/-+/', '-', $st); // Replaces multiple hyphens with single one.
	$st = preg_replace('/,/', '.', $st); // Replaces comma by dotted.
   return preg_replace('/[^0-9\.]/', '', $st); // Removes special chars.
}
function rv($rmv) {
	$rmv = clean(LamDepURL($rmv));
	return $rmv;
}


/**
 * nv_news_fix_block()
 *
 * @param mixed $bid
 * @param bool $repairtable
 * @return
 */
function nv_news_fix_block( $bid, $repairtable = true )
{
	global $db, $module_data;
	$bid = intval( $bid );
	if( $bid > 0 )
	{
		$sql = 'SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block where bid=' . $bid . ' ORDER BY weight ASC';
		$result = $db->query( $sql );
		$weight = 0;
		while( $row = $result->fetch() )
		{
			++$weight;
			if( $weight <= 100 )
			{
				$sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_block SET weight=' . $weight . ' WHERE bid=' . $bid . ' AND id=' . $row['id'];
			}
			else
			{
				$sql = 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block WHERE bid=' . $bid . ' AND id=' . $row['id'];
			}
			$db->query( $sql );
		}
		$result->closeCursor();
		if( $repairtable )
		{
			$db->query( 'OPTIMIZE TABLE ' . NV_PREFIXLANG . '_' . $module_data . '_block' );
		}
	}
}

/**
 * nv_show_block_list()
 *
 * @param mixed $bid
 * @return
 */
function nv_show_block_list( $bid )
{
	global $db, $lang_module, $lang_global, $module_name, $module_data, $op, $global_array_cat, $module_file, $global_config;

	$xtpl = new XTemplate( 'block_list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'GLANG', $lang_global );
	$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
	$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
	$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
	$xtpl->assign( 'MODULE_NAME', $module_name );
	$xtpl->assign( 'OP', $op );
	$xtpl->assign( 'BID', $bid );

	$global_array_cat[0] = array( 'alias' => 'Other' );

	$sql = 'SELECT  t1.catid, t1.title, t1.alias, t2.weight FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat t1 INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_block t2 ON t1.catid = t2.catid WHERE t2.bid= ' . $bid . ' ORDER BY t2.weight ASC';
	$array_block = $db->query( $sql )->fetchAll();

	$num = sizeof( $array_block );
	if( $num > 0 )
	{
		foreach ($array_block as $row)
		{
			$xtpl->assign( 'ROW', array(
				'catid' => $row['catid'],
				'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$row['catid']]['alias'],
				'title' => $row['title']
			) );

			for( $i = 1; $i <= $num; ++$i )
			{
				$xtpl->assign( 'WEIGHT', array(
					'key' => $i,
					'title' => $i,
					'selected' => $i == $row['weight'] ? ' selected="selected"' : ''
				) );
				$xtpl->parse( 'main.loop.weight' );
			}

			$xtpl->parse( 'main.loop' );
		}

		$xtpl->parse( 'main' );
		$contents = $xtpl->text( 'main' );
	}
	else
	{
		$contents = '&nbsp;';
	}
	return $contents;
}

/**
 * GetCatidInParent()
 *
 * @param mixed $catid
 * @return
 */
function GetCatidInParent( $catid )
{
	global $global_array_cat;
	$array_cat = array();
	$array_cat[] = $catid;
	$subcatid = explode( ',', $global_array_cat[$catid]['subcatid'] );
	if( ! empty( $subcatid ) )
	{
		foreach( $subcatid as $id )
		{
			if( $id > 0 )
			{
				if( $global_array_cat[$id]['numsubcat'] == 0 )
				{
					$array_cat[] = $id;
				}
				else
				{
					$array_cat_temp = GetCatidInParent( $id );
					foreach( $array_cat_temp as $catid_i )
					{
						$array_cat[] = $catid_i;
					}
				}
			}
		}
	}
	return array_unique( $array_cat );
}

/**
 * redirect()
 *
 * @param string $msg1
 * @param string $msg2
 * @param mixed $nv_redirect
 * @return
 */
function redirect( $msg1 = '', $msg2 = '', $nv_redirect, $autoSaveKey = '' )
{
	global $global_config, $module_file, $module_name;
	$xtpl = new XTemplate( 'redirect.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );

	if( empty( $nv_redirect ) )
	{
		$nv_redirect = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name;
	}
	$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
	$xtpl->assign( 'NV_REDIRECT', $nv_redirect );
	$xtpl->assign( 'MSG1', $msg1 );
	$xtpl->assign( 'MSG2', $msg2 );

	if( ! empty( $autoSaveKey ) )
	{
		$xtpl->assign( 'AUTOSAVEKEY', $autoSaveKey );
		$xtpl->parse( 'main.removelocalstorage' );
	}

	$xtpl->parse( 'main' );
	$contents = $xtpl->text( 'main' );

	include NV_ROOTDIR . '/includes/header.php';
	echo nv_admin_theme( $contents );
	include NV_ROOTDIR . '/includes/footer.php';
	exit();
}

/**
 * nv_show_cat_list_new()
 *
 * 
 * @return
 */
function nv_show_cat_list_new()
{

	global $db, $lang_module, $lang_global, $module_name, $module_data, $array_viewcat_full, $array_viewcat_nosub, $array_cat_admin, $global_array_cat, $admin_id, $global_config, $module_file, $nv_Request;
	
	$base_url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . '&' . NV_OP_VARIABLE . '=cat';
	$page = $nv_Request->get_int( 'page', 'get', 1 );
	$per_page = 20;
	$all_page = $db->query( 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat' )->fetchColumn();

	
	$xtpl = new XTemplate( 'cat_list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'GLANG', $lang_global );

	// Cac chu de co quyen han
	$array_cat_check_content = array();
	foreach( $global_array_cat as $catid_i => $array_value )
	{
		if( defined( 'NV_IS_ADMIN_MODULE' ) )
		{
			$array_cat_check_content[] = $catid_i;
		}
		elseif( isset( $array_cat_admin[$admin_id][$catid_i] ) )
		{
			if( $array_cat_admin[$admin_id][$catid_i]['admin'] == 1 )
			{
				$array_cat_check_content[] = $catid_i;
			}
			elseif( $array_cat_admin[$admin_id][$catid_i]['add_content'] == 1 )
			{
				$array_cat_check_content[] = $catid_i;
			}
			elseif( $array_cat_admin[$admin_id][$catid_i]['pub_content'] == 1 )
			{
				$array_cat_check_content[] = $catid_i;
			}
			elseif( $array_cat_admin[$admin_id][$catid_i]['edit_content'] == 1 )
			{
				$array_cat_check_content[] = $catid_i;
			}
		}
	}

	$sql = 'SELECT catid, title, alias, add_time, last_update, inhome  FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat ORDER BY title ASC LIMIT ' .  ( $page - 1 ) * $per_page . ', ' . $per_page;
	$rowall = $db->query( $sql )->fetchAll( 3 );
	
	$num = sizeof( $rowall );
	$a = 1;
	if ($page > 1) $a = 1 + (( $page - 1 ) * $per_page);

	foreach ($rowall as $row)
	{
		list( $catid, $title, $alias, $add_time, $last_update, $inhome ) = $row;
		if( defined( 'NV_IS_ADMIN_MODULE' ) )
		{
			$check_show = 1;
		}
		else
		{
			$array_cat = GetCatidInParent( $catid );
			$check_show = array_intersect( $array_cat, $array_cat_check_content );
		}

		if( ! empty( $check_show ) )
		{
			$admin_funcs = array();
			$weight_disabled = $func_cat_disabled = true;
			if( defined( 'NV_IS_ADMIN_MODULE' ) or (isset( $array_cat_admin[$admin_id][$catid] ) and $array_cat_admin[$admin_id][$catid]['add_content'] == 1) )
			{
				$func_cat_disabled = false;
				$admin_funcs[] = "<em class=\"fa fa-plus fa-lg\">&nbsp;</em> <a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=content&amp;catid=" . $catid . "\">" . $lang_module['content_add'] . "</a>\n";
			}
			if( defined( 'NV_IS_ADMIN_MODULE' ) or ( isset( $array_cat_admin[$admin_id][$catid] ) and $array_cat_admin[$admin_id][$catid]['admin'] == 1) )
			{
				$func_cat_disabled = false;
				$admin_funcs[] = "<em class=\"fa fa-edit fa-lg\">&nbsp;</em> <a class=\"\" href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=cat&amp;catid=" . $catid . "#edit\">" . $lang_global['edit'] . "</a>\n";
			}
			if( defined( 'NV_IS_ADMIN_MODULE' ) or ( isset( $array_cat_admin[$admin_id][$catid] ) and $array_cat_admin[$admin_id][$catid]['admin'] == 1) )
			{
				$weight_disabled = false;
				$admin_funcs[] = "<em class=\"fa fa-trash-o fa-lg\">&nbsp;</em> <a href=\"javascript:void(0);\" onclick=\"nv_del_cat(" . $catid . ")\">" . $lang_global['delete'] . "</a>";
			}

			$xtpl->assign( 'ROW', array(
				'catid' => $catid,
				'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$catid]['alias'],
				'title' => $title,
				'add_time' => nv_date( "m/Y", $add_time),
				'last_update' => nv_date( "d/m/Y", $last_update),
				'adminfuncs' => implode( '&nbsp;-&nbsp;', $admin_funcs )
			) );

			$xtpl->assign( 'STT', $a );
			$xtpl->parse( 'main.data.loop.stt' );

			if( !empty($inhome) )
			{
				if ($inhome == 1)
				{ 
					$inhome = $lang_global['yes'];
				}
				else{
					$inhome = $lang_global['no'];
				}
			
				$xtpl->assign( 'INHOME', $inhome );
				$xtpl->parse( 'main.data.loop.inhome' );
			}

			$xtpl->parse( 'main.data.loop' );
			++$a;
		}
	}
	
	$generate_page = nv_generate_page( $base_url, $all_page, $per_page, $page );
	if ( ! empty( $generate_page ) )
	{
		$xtpl->assign( 'GENERATE_PAGE', $generate_page );
		$xtpl->parse( 'main.data.generate_page' );
	}

	if( $num > 0 )
	{
		$xtpl->parse( 'main.data' );
	}

	$xtpl->parse( 'main' );
	$contents = $xtpl->text( 'main' );
	return $contents;
	
}

/**
 * nv_show_block_cat_list_new()
 *
 * @return
 */
function nv_show_block_cat_list_new()
{
	global $db, $lang_module, $lang_global, $module_name, $module_data, $op, $module_file, $global_config, $module_info, $nv_Request;
	
	$base_url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . '&' . NV_OP_VARIABLE . '=groups';
	$page = $nv_Request->get_int( 'page', 'get', 1 );
	$per_page = 15;
	$all_page = $db->query( 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat' )->fetchColumn();


	$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat ORDER BY title ASC LIMIT ' .  ( $page - 1 ) * $per_page . ', ' . $per_page;
	$_array_block_cat = $db->query( $sql )->fetchAll();
	$num = sizeof( $_array_block_cat );
	$a = 1;
	if ($page > 1) $a = 1 + (( $page - 1 ) * $per_page);
	
	$generate_page = nv_generate_page( $base_url, $all_page, $per_page, $page );

	if( $num > 0 )
	{
		$array_adddefault = array(
			$lang_global['no'],
			$lang_global['yes']
		);

		$xtpl = new XTemplate( 'blockcat_lists.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );

		foreach ( $_array_block_cat as $row)
		{
			$numnews = $db->query( 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block where bid=' . $row['bid'] )->fetchColumn();

			$xtpl->assign( 'ROW', array(
				'bid' => $row['bid'],
				'title' => $row['title'],
				'numnews' => $numnews,
				'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '='. $module_info['alias']['groups'] .'&amp;bid=' . $row['bid'],
				'linksite' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['groups'] . '/' . $row['alias'],
				'url_edit' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=groups&amp;bid=' . $row['bid'] . '#edit'
			) );
			$xtpl->assign( 'STT', $a );
			$xtpl->parse( 'main.loop.stt' );

			foreach( $array_adddefault as $key => $val )
			{
				$xtpl->assign( 'ADDDEFAULT', array(
					'key' => $key,
					'title' => $val,
					'selected' => $key == $row['adddefault'] ? ' selected="selected"' : ''
				) );
				$xtpl->parse( 'main.loop.adddefault' );
			}

			for( $i = 20; $i <= 50; ++$i )
			{
				$xtpl->assign( 'NUMBER', array(
					'key' => $i,
					'title' => $i,
					'selected' => $i == $row['numbers'] ? ' selected="selected"' : ''
				) );
				$xtpl->parse( 'main.loop.number' );
			}
	
			$xtpl->parse( 'main.loop' );
			$a++;
		}
		if ( ! empty( $generate_page ) )
		{
			$xtpl->assign( 'GENERATE_PAGE', $generate_page );
			$xtpl->parse( 'main.generate_page' );
		}
	
		$xtpl->parse( 'main' );
		$contents = $xtpl->text( 'main' );
	}
	else
	{
		$contents = '&nbsp;';
	}
	return $contents;
}

/**
 * nv_fix_content_alias()
 *
 * @param integer $id
 */
function nv_fix_content_alias( $id )
{
	global $db, $module_data;
	$sql='SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id=' . intval( $id); 
	$result = $db->query( $sql );			
	$data = $result->fetch();
	$data['alias'] = "chapter-" . preg_replace('/[.]/','-',$data['chapter']) . "-" . change_alias($data['title']);

	$sth = $db->prepare( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET alias=:alias WHERE id =' . $data['id'] );
	$sth->bindParam( ':alias', $data['alias'], PDO::PARAM_STR );
	$sth->execute();	
	
	$sthi = $db->prepare( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_' . $data['catid'] . ' SET alias=:alias WHERE id =' . $data['id'] );
	$sthi->bindParam( ':alias', $data['alias'], PDO::PARAM_STR );
	$sthi->execute();
}
function nv_singlechap_content( $form, $url_chap, $method )
{
	global $db, $module_data, $module_name;
	include NV_ROOTDIR . '/modules/' . $module_name . '/dom.php';

	$sql='SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_get_chap WHERE id=' . intval($form); 
	$result = $db->query( $sql );			
	$data = $result->fetch();

	$chapter = preg_replace('/ /', '%20', $url_chap);
	$html = file_get_html($chapter);

	$img_full = NULL;
	if($method == 1)
	{
		foreach($html->find($data['img_structure']) as $element)
		{
			$img = $element->find('img');
			foreach($img as $element) 
			$img_full = $img_full.$element->src;
		}
	// Dung preg_replace 
	}else if($method == 2)
	{
		preg_match_all('/'.$data['preg_img_structure'].'/is',$html,$preg);
		if (!empty($data['numget_img'])){
			$img_full = $preg[$data['numget_img']];
		} else{
			$img_full = $preg;
		}
		
		$img_full = array_shift($img_full);
		// Xoa cac doi tuong duoc cau hinh
		if (!empty($data['replace_1'])){
			$img_full =  preg_replace('/'.htmlspecialchars_decode($data['replace_1']).'/','',$img_full);
		} 
		if (!empty($data['replace_2'])){
			$img_full = preg_replace('/'.htmlspecialchars_decode($data['replace_2']).'/','',$img_full);
		} 
		if (!empty($data['replace_3'])){
			$img_full = preg_replace('/'.htmlspecialchars_decode($data['replace_3']).'/','',$img_full);
		} 
	}
	//var_dump($data);die;
	return $img_full;
}