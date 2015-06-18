<!-- BEGIN: main -->
<!-- BEGIN: view -->
<form class="form-inline" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>{LANG.number}</th>
					<th>{LANG.title}</th>
					<th>{LANG.url_host}</th>
					<th>{LANG.add_time}</th>
					<th>{LANG.edit_time}</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<!-- BEGIN: loop -->
				<tr>
					<td> {VIEW.number} </td>
					<td> {VIEW.title} </td>
					<td> {VIEW.url_host} </td>
					<td> {VIEW.add_time} </td>
					<td> {VIEW.edit_time} </td>
					<td class="text-center"><i class="fa fa-edit fa-lg">&nbsp;</i> <a href="{VIEW.link_edit}">{LANG.edit}</a> - <em class="fa fa-trash-o fa-lg">&nbsp;</em> <a href="{VIEW.link_delete}" onclick="return confirm(nv_is_del_confirm[0]);">{LANG.delete}</a></td>
				</tr>
				<!-- END: loop -->
			</tbody>
		</table>
	</div>
</form>
<!-- END: view -->

<!-- BEGIN: error -->
<div class="alert alert-warning">{ERROR}</div>
<!-- END: error -->
<form class="form-inline" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
	<input type="hidden" name="id" value="{ROW.id}" />
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<tbody>
				<tr>
					<td> {LANG.title} </td>
					<td><input class="form-control" type="text" name="title" value="{ROW.title}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" /></td>
				</tr>
				<tr>
					<td> {LANG.url_host} </td>
					<td><input class="form-control" type="text" name="url_host" value="{ROW.url_host}" /></td>
				</tr>
				
				<tr class="info">
					<td> Chú ý </td>
					<td>Cấu trúc lấy danh sách URL (DOM)</td>
				</tr>
				
				<tr>
					<td> {LANG.url_html_pattern} </td>
					<td><input class="form-control" type="text" name="url_html_pattern" value="{ROW.url_html_pattern}" /></td>
				</tr>
				<tr>
					<td> {LANG.url_pattern} </td>
					<td><input class="form-control" type="text" name="url_pattern" value="{ROW.url_pattern}" /></td>
				</tr>
				
				<tr class="info">
					<td> Chú ý </td>
					<td>Cấu trúc lấy nội dung trang con (DOM)</td>
				</tr>
				
				<tr>
					<td> {LANG.img_structure} </td>
					<td><input class="form-control" type="text" name="img_structure" value="{ROW.img_structure}" /></td>
				</tr>
				<tr>
					<td> {LANG.chapno_structure} </td>
					<td><input class="form-control" type="text" name="chapno_structure" value="{ROW.chapno_structure}" /></td>
				</tr>
				<tr class="info">
					<td> Chú ý </td>
					<td>Cấu trúc lấy nội dung trang con (Preg_Replace)</td>
				</tr>
				<tr>
					<td> {LANG.preg_img_structure} </td>
					<td><input class="form-control" type="text" name="preg_img_structure" value="{ROW.preg_img_structure}" /></td>
				</tr>
				<tr>
					<td> {LANG.replace_1} </td>
					<td><input class="form-control" type="text" name="replace_1" value="{ROW.replace_1}" /></td>
				</tr>
				<tr>
					<td> {LANG.replace_2} </td>
					<td><input class="form-control" type="text" name="replace_2" value="{ROW.replace_2}" /></td>
				</tr>
				<tr>
					<td> {LANG.replace_3} </td>
					<td><input class="form-control" type="text" name="replace_3" value="{ROW.replace_3}" /></td>
				</tr>
				<tr>
					<td> {LANG.numget_img} </td>
					<td><input class="form-control" type="text" name="numget_img" value="{ROW.numget_img}" /></td>
				</tr>
				<tr>
					<td> {LANG.preg_chapno_structure} </td>
					<td><input class="form-control" type="text" name="preg_chapno_structure" value="{ROW.preg_chapno_structure}" /></td>
				</tr>
				<tr>
					<td> {LANG.numget_chap} </td>
					<td><input class="form-control" type="text" name="numget_chap" value="{ROW.numget_chap}" /></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div style="text-align: center"><input class="btn btn-primary" name="submit" type="submit" value="{LANG.save}" /></div>
</form>
<!-- END: main -->