<!-- BEGIN: main -->
<h1>{CAT_TITLE}</h1>
<!-- BEGIN: nochapter -->
<p class="alert alert-info">{NO_CHAPTER}</p>
<!-- END: nochapter -->
<!-- BEGIN: data -->
<form class="navbar-form" method="post" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}&catid={ROW.catid}">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<colgroup>
				<col span="3" />
				<col class="w250" />
			</colgroup>
			<thead>
				<tr>
					<th class="text-center"><input name="check_all[]" type="checkbox" value="yes" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);" /></th>
					<th class="w100">{LANG.chapter}</th>
					<th>{LANG.name}</th>
					<th>{LANG.status}</th>
					<th>Cập nhật</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
			<!-- BEGIN: loop -->
				<tr>
					<td class="text-center"><input type="checkbox" onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);" value="{ROW.id}" name="idcheck[]" /></td>
					<td class="text-center">{ROW.chapter}</td>
					<td class="text-left"><a target="_blank" href="{ROW.link}">{ROW.title}</a></td>
					<td class="text-center">{ROW.status}</td>
					<td class="text-center">{ROW.edittime}</td>
					<td class="text-center">{ADMINLINK}</td>
				</tr>
			<!-- END: loop -->
			</tbody>
			<tfoot>
				<tr>
					<td colspan="7">
						<select id="action" name="action" class="form-control">
							<option value="delete">Xoá</option>
						</select>
						<input onclick="return nv_main_action_chapter(this.form, '{LANG.msgnocheck}')" name="submit" type="submit" value="{LANG.action}" class="btn btn-primary w100" />
					</td>
				</tr>
			</tfoot>
		</table>
			<!-- BEGIN: generate_page -->
	<div class="text-center">
		{GENERATE_PAGE}
	</div>
<!-- END: generate_page -->
	</div>
</form>
<!-- END: data -->
<a class="btn btn-info" href="{MANAGE_CHAPTER}"><i class="fa fa-reply"></i> {LANG.back} {LANG.chapter_manage} </a> <a class="btn btn-info" href="{ADD_CHAPTER}">{LANG.add} {LANG.chapter} <i class="fa fa-share"></i></a>
<!-- END: main -->