<?php

/**
 * @Project MANGA ON NUKEVIET 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 05/07/2010 09:47
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$contents = '';

if( $nv_Request->isset_request( 'loading', 'post,get' ) ){
	$xtpl = new XTemplate( 'leech.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );

	$xtpl->parse( 'loading' );
	$contents = $xtpl->text( 'loading' );
	echo $contents;
}

if( $nv_Request->isset_request( 'action', 'post,get' ) ){
	include NV_ROOTDIR . '/modules/' . $module_name . '/dom.php';

	$action =  $nv_Request->get_int( 'action', 'get,post', 0 );
	$checkss = $nv_Request->get_string( 'checkss', 'get,post', 0 );

	if($action == '1' and $checkss == md5( $admin_info['userid'] . session_id() . $global_config['sitekey'] ) ){
		
		$xtpl = new XTemplate( 'leech.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
		$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
		$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
		$xtpl->assign( 'MODULE_NAME', $module_name );
		
		$xtpl->parse( 'loading' );
		$contents = $xtpl->text( 'loading' );

		$url = $nv_Request->get_string( 'url', 'get,post', 0 );
		$id = $nv_Request->get_int( 'form_list', 'get,post', 0 );

		if (!empty($url) AND !empty($id))
		{
			$sql='SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_get_chap WHERE id=' . intval( $id); 
			$result = $db->query( $sql );			
			$data = $result->fetch();

			$html = file_get_html($url);
			$imglist = '';
			foreach($html->find($data ['url_html_pattern']) as $element)
			{
			   $link = $element->find($data ['url_pattern']);
			   foreach($link as $element)
			   {
					$imglist = $imglist . check_link($element->href, $data ['url_host']) . '<br/>';
			   }
			}
			if (!empty($imglist))
			{
				$xtpl->assign( 'IMGLIST', $imglist );
				$xtpl->parse( 'img_list' );
				$contents = $xtpl->text( 'img_list' );
			}else{
				$xtpl->parse( 'missing_data' );
				$contents = $xtpl->text( 'missing_data' );
			}
			unset($html);
		}else{
			$xtpl->parse( 'missing_field' );
			$contents = $xtpl->text( 'missing_field' );
		}
	}elseif($action == '2' and $checkss == md5( $admin_info['userid'] . session_id() . $global_config['sitekey'] ) ){
		$chapter_list = $nv_Request->get_string( 'url_list', 'post,get' );
		$id = $nv_Request->get_int( 'form_chap', 'post,get', 0 );
		$catid = $nv_Request->get_int( 'catid', 'post,get', 0 );
		$method = $nv_Request->get_int( 'method', 'post,get', 0 );
		
		$xtpl = new XTemplate( 'leech.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
		$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
		$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
		$xtpl->assign( 'MODULE_NAME', $module_name );
		
		$xtpl->parse( 'loading' );
		$contents = $xtpl->text( 'loading' );
		
		$sql='SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_get_chap WHERE id=' . intval( $id); 
		$result = $db->query( $sql );			
		$data = $result->fetch();

		if( !empty($chapter_list) AND !empty($catid) ){
			$chapters = explode("http://", $chapter_list);
			array_shift($chapters);
			$last_chapter = 0;
			
			$total = $skipped = $done = 0;
			foreach($chapters as $chapter_i)
			{
				$chapter = preg_replace('/ /', '%20', $chapter_i);
				$url_chap = 'http://'.$chapter;
				$html = file_get_html(trim($url_chap));
				
				foreach( $html->find(html_entity_decode($data['chapno_structure'])) as $chap_num )
				{
					$str = $chap_num->plaintext; 
					$this_chapter = preg_replace('/[^0-9\.]/', '', $str);
					if($this_chapter > $last_chapter)
					{ 
						$last_chapter = $this_chapter;
					}
					$xtpl->assign( 'THIS_CHAP', $this_chapter );
					$xtpl->parse( 'getchap_result.loop' );
				}

				// Neu Chapter ton tai gia tri la so thi tien hanh. Neu chi la Ngoai truyen hay bonus thi bo qua(Leech thu cong)
				if (!empty($this_chapter)){
					$duplicate=false;
					// Kiem tra trung Chapter
					$check_id=$db->query('SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_' . intval( $catid ) . ' WHERE chapter=' . $this_chapter)->fetchColumn();
					if( $check_id ){ $duplicate = true; $skipped++;}
				}
				else 
				{
					$duplicate = true;
					$skipped++;
				}
				
				//Neu khong co Chapter bi trung
				if(!$duplicate){
					// Dung HTML DOM get data
					$img_full = NULL;
					if($method == 1)
					{
						foreach($html->find(html_entity_decode($data['img_structure'])) as $element)
						{
							$img = $element->find('img');
							foreach($img as $element) 
							$img_full = $img_full.$element->src;
						}
					// Dung preg_replace 
					}else if($method == 2)
					{
						preg_match_all('/' . html_entity_decode($data['preg_img_structure']) . '/is',$html,$preg);
						if (!empty($data['numget_img'])){
							$img_full = $preg[$data['numget_img']];
						} else{
							$img_full = $preg;
						}
						
						$img_full = array_shift($img_full);
						// Xoa cac doi tuong duoc cau hinh
						if (!empty($data['replace_1'])){
							$img_full =  preg_replace('/'.html_entity_decode($data['replace_1']).'/','',$img_full);
						} 
						if (!empty($data['replace_2'])){
							$img_full = preg_replace('/'.html_entity_decode($data['replace_2']).'/','',$img_full);
						} 
						if (!empty($data['replace_3'])){
							$img_full = preg_replace('/'.html_entity_decode($data['replace_3']).'/','',$img_full);
						} 
						
					}
					if (!empty($img_full)) // Xu ly tranh gay trang trang khi khong lay duoc list link
					{
						//$title_new = $catid.rand(10000,99999); // Tao tieu de ngau nhien
						$title_new = '';
						$addtime = NV_CURRENTTIME;
						$alias = "chapter-" . preg_replace('/[.]/','-',$this_chapter);	// Tao alias		
						$bodyhtml = $img_full;
						
						//Khoi tao cac bien de chen vao DB cho co
						$src_text = $inhome = $allowed_rating = $status = 1;$exptime = $hitstotal = $total_rating = $click_rating = 0;$archive = 2;$author = "Manga Leecher";
						$chapter_sort = ($db->query('SELECT max(chapter_sort) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_' . intval( $catid ))->fetchColumn() ) + 1;
						
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
							 chapter_sort=:chapter_sort,
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
						$stht->bindParam( ':chapter_sort', $chapter_sort, PDO::PARAM_STR );
						$stht->bindParam( ':inhome', $inhome, PDO::PARAM_STR );
						
						$stht->bindParam( ':allowed_rating', $allowed_rating, PDO::PARAM_STR );
						$stht->bindParam( ':hitstotal', $hitstotal, PDO::PARAM_STR );
						$stht->bindParam( ':total_rating', $total_rating, PDO::PARAM_STR );
						$stht->bindParam( ':click_rating', $click_rating, PDO::PARAM_STR );
						$stht->execute();

						if( $id = $db->lastInsertId() )
						{
							$done++;
							// Luu vao NV_PREFIXLANG.'_'.$module_data.'_'.$catid
							$db->exec('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_' . $catid . ' SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id=' . $id);

							$stmt = $db->prepare( 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_detail VALUES	(' . $id . ',:bodyhtml)' );
							$stmt->bindParam( ':bodyhtml', $bodyhtml, PDO::PARAM_STR, strlen( $bodyhtml ) );
							$stmt->execute();
							
							//Bump last_update Category
							$db->query( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_cat SET last_update ='. NV_CURRENTTIME .' WHERE catid =' . $catid );
						}
					}else{
						$xtpl->parse( 'missing_data' );
						$contents = $xtpl->text( 'missing_data' );
					}
				}
				$total++;
			} //End of each chapter
			$html->clear(); 
			unset($html);
				
			$xtpl->assign( 'TOTAL_LEECH', $total );
			$xtpl->assign( 'SKIPPED', $skipped );
			$xtpl->assign( 'DONE', $done );
			$xtpl->parse( 'getchap_result' );
			$contents = $xtpl->text( 'getchap_result' );
			
		}else{
			$xtpl->parse( 'missing_field' );
			$contents = $xtpl->text( 'missing_field' );
		}
	}elseif($action == '3' and $checkss == md5( $admin_info['userid'] . session_id() . $global_config['sitekey'] ) ){
		
		$xtpl = new XTemplate( 'leech.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
		$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
		$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
		$xtpl->assign( 'MODULE_NAME', $module_name );
		
		$xtpl->parse( 'loading' );
		$contents = $xtpl->text( 'loading' );

		$url_chap = $nv_Request->get_string( 'url_chap', 'post,get' );
		$form = $nv_Request->get_int( 'form_chap', 'post,get', 0 );
		$method = $nv_Request->get_int( 'method', 'post,get', 0 );
		
		if( !empty($url_chap) AND !empty($form) AND !empty($method) ){
			$sql='SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_get_chap WHERE id=' . intval($form); 
			$result = $db->query( $sql );			
			$data = $result->fetch();

			$chapter = preg_replace('/ /', '%20', $url_chap);
			$html = file_get_html($chapter);

			$img_full = NULL;
			if($method == 1)
			{
				foreach($html->find(html_entity_decode($data['img_structure'])) as $element)
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
					$img_full =  preg_replace('/'.html_entity_decode($data['replace_1']).'/','',$img_full);
				} 
				if (!empty($data['replace_2'])){
					$img_full = preg_replace('/'.html_entity_decode($data['replace_2']).'/','',$img_full);
				} 
				if (!empty($data['replace_3'])){
					$img_full = preg_replace('/'.html_entity_decode($data['replace_3']).'/','',$img_full);
				} 
			}
			
			if( !empty($img_full) ){
				$xtpl->assign( 'URL_FULL', $img_full );
				$xtpl->parse( 'getsinglgechap_result' );
				$contents = $xtpl->text( 'getsinglgechap_result' );
			}else{
				$xtpl->parse( 'missing_data' );
				$contents = $xtpl->text( 'missing_data' );
			}
		}else{
			$xtpl->parse( 'missing_field' );
			$contents = $xtpl->text( 'missing_field' );
		}
	}
	echo $contents;
}