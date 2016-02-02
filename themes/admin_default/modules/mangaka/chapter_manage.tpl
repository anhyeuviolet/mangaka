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
					<th class="text-center">{LANG.numno}</th>
					<th class="text-center">{LANG.name}</th>
					<th class="text-center">{LANG.total_chapter}</th>
					<th class="text-center">{LANG.last_chapter}</th>
					<th class="text-center">{LANG.last_update}</th>
					<th class="text-center">{LANG.total_view}</th>
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
					<td>
					<a href="{ROW.link}"><strong>{ROW.title}</strong>
					</td>
					<td class="text-center">
					{ROW.total_chapter}
					</td>
					<td class="text-center">
					{ROW.last_chapter}
					</td>
					<td class="text-center">{ROW.last_update}</td>
					<td class="text-center">{ROW.total_view}</td>
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
<!-- BEGIN: chapter_main -->
<div class="row" id="show_chapter">
{SHOW_CHAPTER}
</div>
<!-- END: chapter_main -->