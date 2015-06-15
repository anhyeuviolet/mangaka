<!-- BEGIN: main -->
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<colgroup>
			<col span="2" class="w100">
			<col span="2">
			<col class="w100">
			<col class="w150">
		</colgroup>
		<thead>
			<tr>
				<th>{LANG.stt}</th>
				<th>{LANG.name}</th>
				<td class="text-center">{LANG.adddefaultblock}</th>
				<td class="text-center" >{LANG.link_per_page}</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<!-- BEGIN: loop -->
			<tr>
				<td class="text-center">
					<!-- BEGIN: stt -->
					{STT}
					<!-- END: stt -->
				</td>
				<td class="w500"><a href="{ROW.linksite}" target="_blank"><strong>{ROW.title}</strong></a> ({ROW.numnews} {LANG.genre_nums})</td>
				<td class="text-center">
				<select class="form-control w200" id="id_adddefault_{ROW.bid}" onchange="nv_chang_block_cat('{ROW.bid}','adddefault');">
					<!-- BEGIN: adddefault -->
					<option value="{ADDDEFAULT.key}"{ADDDEFAULT.selected}>{ADDDEFAULT.title}</option>
					<!-- END: adddefault -->
				</select></td>
				<td class="text-center">
				<select class="form-control w200" id="id_numlinks_{ROW.bid}" onchange="nv_chang_block_cat('{ROW.bid}','numlinks');">
					<!-- BEGIN: number -->
					<option value="{NUMBER.key}"{NUMBER.selected}>{NUMBER.title}</option>
					<!-- END: number -->
				</select></td>
				<td class="text-center w200">
					<em class="fa fa-edit fa-lg">&nbsp;</em> <a href="{ROW.url_edit}">{GLANG.edit}</a> &nbsp;
					<em class="fa fa-trash-o fa-lg">&nbsp;</em> <a href="javascript:void(0);" onclick="nv_del_block_cat({ROW.bid})">{GLANG.delete}</a>
				</td>
			</tr>
			<!-- END: loop -->
		</tbody>
	</table>
</div>
	<!-- BEGIN: generate_page -->
<div class="text-center">
	{GENERATE_PAGE}
</div>
<!-- END: generate_page -->
<!-- END: main -->