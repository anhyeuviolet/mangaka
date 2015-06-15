<!-- BEGIN: main -->
<div id="show_cat">
	<!-- BEGIN: cat_title -->
	<div style="background:#eee;padding:10px">
		{CAT_TITLE}
	</div>
	<!-- END: cat_title -->
	<!-- BEGIN: data -->
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<col span="5" style="white-space: nowrap;" />
			<col class="w250" />
			<col style="white-space: nowrap;" />
			<thead>
				<tr>
					<th class="text-center">{LANG.stt} </th>
					<th class="text-center">{LANG.name}</th>
					<th class="text-center">{LANG.inhome}</th>
					<th class="text-center">{LANG.add_time}</th>
					<th class="text-center">{LANG.last_update}</th>
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
					<td><strong><a href="{ROW.link}" target="_blank">{ROW.title}</a></strong>
					<!-- BEGIN: numsubcat -->
					<span class="red">({NUMSUBCAT})</span>
					<!-- END: numsubcat -->
					</a></td>
					<td class="text-center">
					<!-- BEGIN: inhome -->
						{INHOME}
					<!-- END: inhome -->
					</td>
					<td class="text-center">{ROW.add_time}</td>
					<td class="text-center">{ROW.last_update}</td>
					<td class="text-center">{ROW.adminfuncs}</td>
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
	<!-- END: data -->
</div>
<!-- END: main -->