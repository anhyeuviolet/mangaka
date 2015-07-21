<!-- BEGIN: main -->
<!-- BEGIN: nodata -->
<p class="alert alert-info">{NO_MANGA}</p>
<a class="btn btn-warning" href="{ADD_CAT}">{LANG.add_cat}&nbsp;<i class="fa fa-share"></i></a>
<!-- END: nodata -->

<div id="show_cat">
	<!-- BEGIN: data -->
<a class="btn btn-warning" href="{ADD_CAT}">{LANG.add_cat}&nbsp;<i class="fa fa-share"></i></a>
<hr/>
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
					<th class="text-center">{LANG.content_allowed_rating}</th>
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
					<td>
						<strong><a href="{ROW.link}" target="_blank">{ROW.title}</a></strong>
					</td>

				<td class="text-center">
				<!-- BEGIN: disabled_inhome -->
				{INHOME}
				<!-- END: disabled_inhome -->
				<!-- BEGIN: inhome -->
				<select class="form-control" id="id_inhome_{ROW.catid}" onchange="nv_chang_cat('{ROW.catid}','inhome');">
					<!-- BEGIN: loop -->
					<option value="{INHOME.key}"{INHOME.selected}>{INHOME.title}</option>
					<!-- END: loop -->
				</select>
				<!-- END: inhome -->
				</td>
				
				<td class="text-center">
				<!-- BEGIN: disabled_rating -->
				{RATING}
				<!-- END: disabled_rating -->
				<!-- BEGIN: rating -->
				<select class="form-control" id="id_rating_{ROW.catid}" onchange="nv_chang_cat('{ROW.catid}','rating');">
					<!-- BEGIN: loop -->
					<option value="{RATING.key}"{RATING.selected}>{RATING.title}</option>
					<!-- END: loop -->
				</select>
				<!-- END: rating -->
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
<hr/>
<a class="btn btn-warning" href="{ADD_CAT}">{LANG.add_cat}&nbsp;<i class="fa fa-share"></i></a>
<!-- END: data -->
</div>
<!-- END: main -->