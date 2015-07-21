<!-- BEGIN: main -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}js/select2/select2.min.css">

<script type="text/javascript" src="{NV_BASE_SITEURL}js/select2/select2.min.js"></script>
<a class="btn btn-warning" href="{TO_CAT_LIST}"><i class="fa fa-reply"></i>&nbsp;{LANG.back}&nbsp;{LANG.categories_list}</a><hr/>
<br/>

<div id="edit">
	<!-- BEGIN: error -->
	<div class="alert alert-warning">{ERROR}</div>
	<!-- END: error -->
	
	<!-- BEGIN: content -->
	<form action="{NV_BASE_ADMINURL}index.php" method="post">
		<input type="hidden" name ="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
		<input type="hidden" name ="{NV_OP_VARIABLE}" value="{OP}" />
		<input type="hidden" name ="catid" value="{catid}" />
		<input type="hidden" name ="parentid_old" value="{parentid}" />
		<input name="savecat" type="hidden" value="1" />
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
				<caption><em class="fa fa-file-text-o">&nbsp;</em>{caption}</caption>
				<tbody>
					<tr>
						<th class="col-md-4 text-right">{LANG.name}: </th>
						<td class="col-md-20 text-left"><input class="form-control w500" name="title" type="text" value="{title}" maxlength="255" id="idtitle"/><span class="text-middle"> {GLANG.length_characters}: <span id="titlelength" class="red">0</span>. {GLANG.title_suggest_max} </span></td>
					</tr>
					<tr>
						<th class="text-right">{LANG.alias}: </th>
						<td>
							<input class="form-control w500 pull-left" name="alias" type="text" value="{alias}" maxlength="255" id="idalias"/>
							&nbsp;<em class="fa fa-refresh fa-lg fa-pointer text-middle" onclick="get_alias('cat', {catid});">&nbsp;</em>
						</td>
					</tr>
					<tr>
						<th class="text-right">{LANG.titlesite}: </th>
						<td><input class="form-control w500" name="titlesite" type="text" value="{titlesite}" maxlength="255" id="titlesite"/><span class="text-middle"> {GLANG.length_characters}: <span id="titlesitelength" class="red">0</span>. {GLANG.title_suggest_max} </span></td>
					</tr>
					
					<!-- BEGIN: hide_subcat -->
					<tr>
						<th class="text-right">{LANG.cat_sub}: </th>
						<td>
						<select class="form-control w200" name="parentid" id="parentid">
							<!-- BEGIN: cat_listsub -->
							<option value="{cat_listsub.value}" {cat_listsub.selected}>{cat_listsub.title}</option>
							<!-- END: cat_listsub -->
						</select></td>
					</tr>
					<!-- END: hide_subcat -->
					
					<tr>
						<th class="text-right">{LANG.progress}: </th>
						<td>
						<select class="form-control w200" name="progress" id="progress">
							<!-- BEGIN: progress -->
							<option value="{PROGRESS.value}" {PROGRESS.selected}>{PROGRESS.title}</option>
							<!-- END: progress -->
						</select></td>
					</tr>
					<tr><th class="text-right">{LANG.inhome}: </th>
						<td>
						<select class="form-control w200" name="inhome" id="inhome">
						<!-- BEGIN: inhome -->
							<option value="{INHOME.value}"{INHOME.selected}>{INHOME.title}</option>
						<!-- END: inhome -->
						</select>
						</td>
					</tr>
					<tr><th class="text-right">{LANG.content_allowed_rating} </th>
						<td>
									<input type="checkbox" value="1" name="allowed_rating" {allowed_rating_checked}/>
						</td>
					</tr>
					
					<tr>
						<th class="text-right">{LANG.keywords}: </th>
						<td><input class="form-control w500" name="keywords" type="text" value="{keywords}" maxlength="255" /></td>
					</tr>					
					<tr>
						<th class="text-right">{LANG.author}: </th>
						<td><input class="form-control w500" name="authors" type="text" value="{authors}" maxlength="255" /></td>
					</tr>					
					<tr>
						<th class="text-right">{LANG.translator}: </th>
						<td><input class="form-control w500" name="translators" type="text" value="{translators}" maxlength="255" /></td>
					</tr>
						<!-- BEGIN:block_cat -->
						<tr>
							<th class="text-right">
								{LANG.content_block}:
							</th>
							<td>
							<div class="message_body" style="overflow: auto">
								<div class="group_list">
									<select name="bids[]" id="bids" class="form-control" style="width: 100%" multiple="multiple">
										<!-- BEGIN: loop -->
										<option value="{BLOCKS.bid}" {BLOCKS.selected}>{BLOCKS.title}</option>
										<!-- END: loop -->
									</select>
								</div>
							</div>
							</td>
						</tr>
						<!-- END:block_cat -->
					<tr>
						<td class="text-right">
						<br />
						<strong>{LANG.description} </th>
						<td >
							<textarea class="form-control" id="description" name="description" cols="100" rows="5">{description}</textarea><br />
							<span class="text-middle"> {GLANG.length_characters}: <span id="descriptionlength" class="red">0</span>. {GLANG.description_suggest_max} </span>
						</td>
					</tr>
					<tr>
						<th class="text-right">{LANG.content_homeimg}</th>
						<td>
							<input class="form-control w500 pull-left" type="text" name="image" id="image" value="{image}"/>
							&nbsp;<input type="button" value="Browse server" name="selectimg" class="btn btn-info" />
						</td>
					</tr>
					<tr>
						<th class="text-right">
						<br />
						<strong>{LANG.viewcat_detail} </th>
						<td>
							<!-- BEGIN: groups_views -->
							<div class="row">
								<label><input name="groups_view[]" type="checkbox" value="{groups_views.value}" {groups_views.checked} />{groups_views.title}</label>
							</div>
							<!-- END: groups_views -->
						</td>
					</tr>
					
					<tr>
						<th class="text-right">
						<strong>{LANG.content_allowed_comm} </th>
						<td>
							<!-- BEGIN: allowed_comm -->
							<div class="row">
								<label><input name="allowed_comm[]" type="checkbox" value="{ALLOWED_COMM.value}" {ALLOWED_COMM.checked} />{ALLOWED_COMM.title}</label>
							</div>
							<!-- END: allowed_comm -->
							<!-- BEGIN: content_note_comm -->
								<div class="alert alert-info">{LANG.content_note_comm}</div>
							<!-- END: content_note_comm -->
						</td>
					</tr>
					<tr>
						<th class="text-right">{LANG.description_html}: </th>
						<td>{DESCRIPTIONHTML}</td>
					</tr>
				</tbody>
			</table>
		</div>
		<br />
		<div class="text-center">
			<input class="btn btn-primary" name="submit1" type="submit" value="{LANG.save}" />
		</div>
	</form>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$("#parentid").select2();
	});
	$("#bids").select2({
		placeholder: "{LANG.content_block}"
	});
	$("#titlelength").html($("#idtitle").val().length);
	$("#idtitle").bind("keyup paste", function() {
		$("#titlelength").html($(this).val().length);
	});

	$("#titlesitelength").html($("#titlesite").val().length);
	$("#titlesite").bind("keyup paste", function() {
		$("#titlesitelength").html($(this).val().length);
	});

	$("#descriptionlength").html($("#description").val().length);
	$("#description").bind("keyup paste", function() {
		$("#descriptionlength").html($(this).val().length);
	});
	$("input[name=selectimg]").click(function() {
		var area = "image";
		var path = "{UPLOAD_CURRENT}";
		var currentpath = "{UPLOAD_CURRENT}";
		var type = "image";
		nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
		return false;
	});
</script>
<!-- BEGIN: getalias -->
<script type="text/javascript">
	$("#idtitle").change(function() {
		get_alias("cat", 0);
	});
	
	$("#gotoedit").click(function() {
    $('html, body').animate({
        scrollTop: $("#edit").offset().top
    }, 500);
});
</script>
<!-- END: getalias -->
<!-- END: content -->
<!-- END: main -->