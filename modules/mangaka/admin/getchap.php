<?php

/**
 * @Project MANGA ON NUKEVIET 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 05/07/2010 09:47
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
global $db, $lang_module, $lang_global, $module_name, $module_data, $array_viewcat_full, $array_viewcat_nosub, $array_cat_admin, $global_array_cat, $admin_id, $global_config, $module_file;

include NV_ROOTDIR . '/modules/' . $module_name . '/dom.php';

$action =  $nv_Request->get_int( 'action', 'post', 0 );
$checkss = $nv_Request->get_string( 'checkss', 'post', 0 );

$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_LANG_VARIABLE', NV_LANG_VARIABLE );
$xtpl->assign( 'NV_LANG_DATA', NV_LANG_DATA );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
$xtpl->assign( 'CHECKSS', $checkss );

// List of Get Chap Config
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_get_chap ORDER BY title ASC';
$result = $db->query( $sql );
while( list($str_id, $str_title) = $result->fetch( 3 ) )
{
	$get_list['id'] = $str_id;
	$get_list['title'] = $str_title;
	if(!empty($get_list))
	{
		$xtpl->assign( 'GETLIST', $get_list );
	}
	$xtpl->parse( 'main.getlist_loop_list' );
	$xtpl->parse( 'main.getlist_loop_chap' );
}
unset($sql);

if($action == '1'){
	$url = $nv_Request->get_string( 'url', 'post', 0 );
	$id = $nv_Request->get_int( 'form_list', 'post', 0 );
	if (!empty($url) && !empty($id))
	{
		$sql='SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_get_chap WHERE id=' . intval( $id); 
		$result = $db->query( $sql );			
		$data = $result->fetch();
		

		$html = file_get_html($url);
		$imglist = '';
		foreach($html->find($data ['url_html_pattern']) as $element){
			   $link = $element->find($data ['url_pattern']);
			   foreach($link as $element) 
			   $imglist = $imglist.$data ['url_host'].$element->href.'<br/>';
		}
		if (!empty($imglist))
		{
			$xtpl->assign( 'IMGLIST', $imglist );
			$xtpl->parse( 'main.img_list' );
			
		}
		unset($html);
	} else{
		Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
		die();

	}
}

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


$sql = 'SELECT catid, title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat ORDER BY title ASC';
$rowall = $db->query( $sql )->fetchAll( 3 );
foreach ($rowall as $row)
{
	list( $catid, $title ) = $row;
	if( defined( 'NV_IS_ADMIN_MODULE' ) or ( isset( $array_cat_admin[$admin_id][$catid] ) and $array_cat_admin[$admin_id][$catid]['add_content'] == 1 ) )
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
		$xtpl->assign( 'CAT', array(
			'catid' => $catid,
			'title' => $title
		) );
		$xtpl->parse( 'main.catloop' );
	}
}

if($action == '2'){
	$chapter_list = $nv_Request->get_string( 'url_list', 'post', 0 );
	$id = $nv_Request->get_int( 'form_chap', 'post', 0 );
	$catid = $nv_Request->get_int( 'catid', 'post', 0 );
	$method = $nv_Request->get_int( 'method', 'post', 0 );
	
	$sql='SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_get_chap WHERE id=' . intval( $id); 
	$result = $db->query( $sql );			
	$data = $result->fetch();

	if (!empty($chapter_list)){
		$chapters = explode("http://", $chapter_list);
		array_shift($chapters);
		$last_chapter = 0;
		
		foreach($chapters as $chapter_i)
		{
			$chapter = preg_replace('/ /', '%20', $chapter_i);
			$url_chap = 'http://'.$chapter;
			$html = file_get_html(trim($url_chap));
			
			
			foreach( $html->find($data['chapno_structure']) as $chap_num )
			{
				$str = $chap_num->plaintext; 
				$this_chapter = preg_replace('/[^0-9\.]/', '', $str);
				if($this_chapter > $last_chapter)
				{ 
					$last_chapter = $this_chapter;
				}
				$xtpl->assign( 'THIS_CHAP', $this_chapter );
				$xtpl->parse( 'main.getchap_result.loop' );
			}
			
			// Neu Chapter ton tai gia tri la so thi tien hanh. Neu chi la Ngoai truyen hay bonus thi bo qua(Leech thu cong)
			if (!empty($this_chapter)){
				$duplicate=false;
				// Kiem tra trung Chapter
				$query='SELECT id FROM '. NV_PREFIXLANG . '_' . $module_data .'_'.$catid.' WHERE chapter='.$this_chapter;
				$query_id=$db->query( $query );
				if( $query_id->fetch( 3 ) ){ $duplicate=true; }
				if(isset($data_result) and $data_result){
					foreach($data_result as $data){
						if($data['chapter']==$this_chapter){
							$duplicate=true;
						}
					}
				}
			} else {
				$duplicate=true;
			}
			
			//Neu khong co Chapter bi trung
			if(!$duplicate){
				// Dung HTML DOM get data
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
				
				if (!empty($img_full)) // Xu ly tranh gay trang trang khi khong lay duoc list link
				{
					$addtime=NV_CURRENTTIME+mt_rand(60,1000); //Tao thoi gian leech ngau nhien, do link la tu tren xuong duoi, nen link leech sau se co thoi gian lau hon
					$title_new = rand(10000,99999); // Tao tieu de ngau nhien
					$alias = "chapter-" . preg_replace('/[.]/','-',$this_chapter) . "-" . change_alias($title_new);	// Tao alias		
					$bodyhtml=$img_full;
					
					//Khoi tao cac bien de chen vao DB cho co
					$bodytext=nv_news_get_bodytext($bodyhtml);
					$src_text = $inhome = $allowed_rating = $status = 1;$exptime = $hitstotal = $total_rating = $click_rating =0;$archive=2;$author = "Manga Leecher";
					
					// Luu vao NV_PREFIXLANG."_".$module_data."_rows"
					$stht = $db->prepare( 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET
						 catid=:catid,
						 listcatid=:listcatid,
						 admin_id=:admin_id,
						 author=:author,
						 addtime=:addtime,
						 edittime=:edittime,
						 status=:status,
						 publtime=:publtime,
						 exptime=:exptime,
						 archive=:archive,
						 title=:title,
						 alias=:alias,
						 chapter=:chapter,
						 inhome=:inhome,
						 allowed_rating=:allowed_rating,
						 hitstotal=:hitstotal,
						 total_rating=:total_rating,
						 click_rating=:click_rating
						 ');

					$stht->bindParam( ':catid', $catid, PDO::PARAM_STR );
					$stht->bindParam( ':listcatid', $catid, PDO::PARAM_STR );
					$stht->bindParam( ':admin_id', $admin_id, PDO::PARAM_STR );
					$stht->bindParam( ':author', $author, PDO::PARAM_STR );
					
					$stht->bindParam( ':addtime', $addtime, PDO::PARAM_STR );
					$stht->bindParam( ':edittime', $addtime, PDO::PARAM_STR );
					$stht->bindParam( ':status', $status, PDO::PARAM_STR );
					
					$stht->bindParam( ':publtime', $addtime, PDO::PARAM_STR );
					$stht->bindParam( ':exptime', $exptime, PDO::PARAM_STR );
					$stht->bindParam( ':archive', $archive, PDO::PARAM_STR );
					$stht->bindParam( ':title', $title_new, PDO::PARAM_STR );
					$stht->bindParam( ':alias', $alias, PDO::PARAM_STR );
					$stht->bindParam( ':chapter', $this_chapter, PDO::PARAM_STR );
					$stht->bindParam( ':inhome', $inhome, PDO::PARAM_STR );
					
					$stht->bindParam( ':allowed_rating', $allowed_rating, PDO::PARAM_STR );
					$stht->bindParam( ':hitstotal', $hitstotal, PDO::PARAM_STR );
					$stht->bindParam( ':total_rating', $total_rating, PDO::PARAM_STR );
					$stht->bindParam( ':click_rating', $click_rating, PDO::PARAM_STR );
					$stht->execute();

					if( $id = $db->lastInsertId() )
					{
						// Luu vao NV_PREFIXLANG.'_'.$module_data.'_'.$catid
						$sthr = $db->prepare( 'INSERT INTO '.NV_PREFIXLANG.'_'.$module_data.'_'.$catid.'  SET
						 id=:id,
						 catid=:catid,
						 listcatid=:listcatid,
						 admin_id=:admin_id,
						 author=:author,
						 addtime=:addtime,
						 edittime=:edittime,
						 status=:status,
						 publtime=:publtime,
						 exptime=:exptime,
						 archive=:archive,
						 title=:title,
						 alias=:alias,
						 chapter=:chapter,
						 inhome=:inhome,
						 allowed_rating=:allowed_rating,
						 hitstotal=:hitstotal,
						 total_rating=:total_rating,
						 click_rating=:click_rating
						 ');
						$sthr->bindParam( ':id', $id, PDO::PARAM_STR );
						$sthr->bindParam( ':catid', $catid, PDO::PARAM_STR );
						$sthr->bindParam( ':listcatid', $catid, PDO::PARAM_STR );
						$sthr->bindParam( ':admin_id', $admin_id, PDO::PARAM_STR );
						$sthr->bindParam( ':author', $author, PDO::PARAM_STR );
						
						$sthr->bindParam( ':addtime', $addtime, PDO::PARAM_STR );
						$sthr->bindParam( ':edittime', $addtime, PDO::PARAM_STR );
						$sthr->bindParam( ':status', $status, PDO::PARAM_STR );
						
						$sthr->bindParam( ':publtime', $addtime, PDO::PARAM_STR );
						$sthr->bindParam( ':exptime', $exptime, PDO::PARAM_STR );
						$sthr->bindParam( ':archive', $archive, PDO::PARAM_STR );
						$sthr->bindParam( ':title', $title_new, PDO::PARAM_STR );
						$sthr->bindParam( ':alias', $alias, PDO::PARAM_STR );
						$sthr->bindParam( ':chapter', $this_chapter, PDO::PARAM_STR );
						$sthr->bindParam( ':inhome', $inhome, PDO::PARAM_STR );
						
						$sthr->bindParam( ':allowed_rating', $allowed_rating, PDO::PARAM_STR );
						$sthr->bindParam( ':hitstotal', $hitstotal, PDO::PARAM_STR );
						$sthr->bindParam( ':total_rating', $total_rating, PDO::PARAM_STR );
						$sthr->bindParam( ':click_rating', $click_rating, PDO::PARAM_STR );
						$sthr->execute();
						
						// Luu vao NV_PREFIXLANG.'_'.$module_data.'_bodyhtml_*'
						// check bodyhtml
						$imgposition= $copyright= $allowed_send= $allowed_print= $allowed_save= $gid = 1;
						$tbhtml = NV_PREFIXLANG . '_' . $module_data . '_bodyhtml_' . ceil( $id / 2000 );
						
						// Khoi tao neu chua co table bodyhtml
						$db->query( "CREATE TABLE IF NOT EXISTS " . $tbhtml . " (id int(11) unsigned NOT NULL, bodyhtml longtext NOT NULL, PRIMARY KEY (id)) ENGINE=MyISAM" );

						$stmt = $db->prepare( 'INSERT INTO ' . $tbhtml . ' VALUES
							(' . $id . ',
							 :bodyhtml
							 )' );
						$stmt->bindParam( ':bodyhtml', $bodyhtml, PDO::PARAM_STR, strlen( $bodyhtml ) );
						$stmt->execute();
						
						// Luu vao NV_PREFIXLANG.'_'.$module_data.'_bodytext'
						$stmt = $db->prepare( 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_bodytext VALUES (' . $id . ', :bodytext )' );
						$stmt->bindParam( ':bodytext', $bodytext, PDO::PARAM_STR, strlen( $bodytext ) );
						$stmt->execute();
						
						//Bump last_update Category
						$db->query( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_cat SET last_update ='. NV_CURRENTTIME .' WHERE catid =' . $catid );

					}
				}
			}
		} //End of each chapter
		$html->clear(); 
		unset($html);
	} else{
		Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
		die();
	}
$xtpl->parse( 'main.getchap_result' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

$page_title = $lang_module['getchap'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';