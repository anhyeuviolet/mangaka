<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger">{error}</div>
<!-- END: error -->
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.core.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.theme.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.menu.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.autocomplete.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.datepicker.css" rel="stylesheet" />
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css">
<form class="form-inline m-bottom" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" enctype="multipart/form-data" method="post" class="confirm-reload">
	<div class="row">
		<div class="col-sm-24 col-md-16">
			<table class="table table-striped table-bordered">
				<col class="w200" />
				<col />
				<tbody>
					<tr>
						<td><strong>{LANG.chapter}: </strong></td>
						<td>
							<input class="form-control" name="chapter" id="chapter" type="text" value="{rowcontent.chapter}" maxlength="255"  style="width:350px"/>
							<input type="hidden" value="{rowcontent.chapter}" name="old_chapter" />
						</td>
					</tr>
					<tr>
						<td><strong>{LANG.name}</strong></td>
						<td>
							<input type="text" maxlength="255" value="{rowcontent.title}" id="idtitle" name="title" class="form-control"  style="width:350px" /><br/>
							<span class="text-middle"> {GLANG.length_characters}: <span id="titlelength" class="red">0</span>. {GLANG.title_suggest_max} </span>
						</td>
					</tr>
					<tr>
						<td><strong>{LANG.alias}: </strong></td>
						<td><input {rowcontent.readonly_alias} class="form-control" name="alias" id="idalias" type="text" value="{rowcontent.alias}" maxlength="255"  style="width:350px"/>&nbsp; <em class="fa fa-refresh fa-lg fa-pointer {rowcontent.hidden}" onclick="get_alias();">&nbsp;</em></td>
					</tr>
				</tbody>
			</table>

			<table class="table table-striped table-bordered table-hover">
				<tbody>

					<tr>
						<td><strong>{LANG.content_bodytext}</strong>{LANG.content_bodytext_note}</td>
					</tr>
					<tr>
						<td>
						<div style="padding:2px; background:#CCCCCC; margin:0; display:block; position:relative">
							{edit_bodytext}
						</div></td>
					</tr>

				</tbody>
			</table>
		</div>
		<div class="col-sm-24 col-md-8">
			<div class="row">
				<div class="col-sm-12 col-md-24">
					<ul style="padding-left:4px; margin:0">
						<li class="{rowcontent.hidden}">
							<p class="message_head">
								<cite>{LANG.content_cat}:</cite>
							</p>
							<div class="message_body" style="height:260px; overflow: auto">
								<table class="table table-striped table-bordered table-hover">
									<tbody>
										<tr>
											<td>						
											<select class="form-control w200" name="catids[]" id="catid">
												<option value="">{LANG.select_manga}</option>
												<!-- BEGIN: catid -->
												<option value="{CATS.catid}" {CATS.selected}>{CATS.title}</option>
												<!-- END: catid -->
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</li>
						<li>
							<p class="message_head">
								<cite>{LANG.content_publ_date}</cite><span class="timestamp">{LANG.content_notetime}</span>
							</p>
							<div class="message_body">
								<input class="form-control" name="publ_date" id="publ_date" value="{publ_date}" style="width: 90px;" maxlength="10" type="text"/>
								<select class="form-control" name="phour">
									{phour}
								</select>
								:
								<select class="form-control" name="pmin">
									{pmin}
								</select>
							</div>
						</li>
						<li>
							<p class="message_head">
								<cite>{LANG.content_exp_date}:</cite><span class="timestamp">{LANG.content_notetime}</span>
							</p>
							<div class="message_body">
								<input class="form-control" name="exp_date" id="exp_date" value="{exp_date}" style="width: 90px;" maxlength="10" type="text"/>
								<select class="form-control" name="ehour">
									{ehour}
								</select>
								:
								<select class="form-control" name="emin">
									{emin}
								</select>
								<div style="margin-top: 5px;">
									<input type="checkbox" value="1" name="archive" {archive_checked} />
									<label> {LANG.content_archive} </label>
								</div>
							</div>
						</li>
					</ul>
				</div>
				<div class="col-sm-12 col-md-24">
					<ul style="padding:4px; margin:0">
						<li>
							<p class="message_head">
								<cite>{LANG.content_extra}:</cite>
							</p>
							<div class="message_body" style="overflow: auto">
								<div style="margin-bottom: 2px;">
									<input type="checkbox" value="1" name="inhome" {inhome_checked}/>
									<label> {LANG.content_inhome} </label>
								</div>
								<div style="margin-bottom: 2px;">
									<input type="checkbox" value="1" name="allowed_rating" {allowed_rating_checked}/>
									<label> {LANG.content_allowed_rating} </label>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="text-center">
		<br/>
		<input type="hidden" value="1" name="save" />
		<input type="hidden" value="{rowcontent.id}" name="id" />
		<!-- BEGIN:status -->
		<input class="btn btn-primary" name="statussave" type="submit" value="{LANG.save}" />
		<!-- END:status -->
		<!-- BEGIN:status0 -->
		<input class="btn btn-primary" name="status4" type="submit" value="{LANG.save_temp}" />
		<input class="btn btn-primary" name="status1" type="submit" value="{LANG.publtime}" />
		<!-- END:status0 -->
        <!-- BEGIN:status1 -->
		<input class="btn btn-primary" name="status4" type="submit" value="{LANG.save_temp}" />
		<input class="btn btn-primary" name="status6" type="submit" value="{LANG.save_send_admin}" />
            <!-- BEGIN:status0 -->
            <input class="btn btn-primary" name="status0" type="submit" value="{LANG.save_send_spadmin}" />
            <!-- END:status0 -->
		<!-- END:status1 -->
		<br />
	</div>
</form>

<form class="bs-example form-horizontal" method="POST" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}">
<input type="hidden" name="leech" value="1" />
<input type="hidden" name="checkss" value="{CHECKSS}" />
<fieldset>
  <div class="alert alert-info">{LANG.leech_single_tool}</div>
	<div class="form-group">
		<label class="col-lg-2 control-label">{LANG.select_structure}:</label>
		<div class="col-lg-20">
		  <select class="form-control" name="form_chap" id="form_chap" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')">
			<option value="">----- {LANG.select_structure} ----- </option>
		  <!-- BEGIN: getlist_loop_chap-->
			<option value="{GETLIST.id}">{GETLIST.title}</option>
		  <!-- END: getlist_loop_chap-->
		  </select>
		</div>
	</div>	
	<div class="form-group">
		<label class="col-lg-2 control-label">{LANG.select_method} :</label>
		<div class="col-lg-20">
			<input type="radio" name="method" value="1" checked>{LANG.dom}<br>
			<input type="radio" name="method" value="2">{LANG.preg_match} </input>
		</div>
	</div>	
  <div class="form-group">
	<label class="col-lg-2 control-label">URL truyện</label>
	<div class="col-lg-20">
	  <input class="form-control" rows="5" name="url_chap" placeholder="Dán những tập mà bạn muốn grab vào đây, có dạng : http://"></input>
	  Dán URL tập mà bạn muốn grab vào đây.
	</div>
  </div>
  <div class="clearfix form-group">
	<div class="col-lg-20 col-lg-offset-4"> 
	  <button type="submit" class="btn btn-primary">{LANG.submit}</button> 
	</div>
  </div>
   <!-- BEGIN: getchap_result-->
    Kết quả:
		 <div class="well">
			{URL_FULL}
		</div>
	<!-- END: getchap_result-->  
</fieldset>
</form>
<div id="message"></div>

<script type="text/javascript">
$(document).ready(function() {
	$("#catid").select2();
});
//<![CDATA[
var LANG = [];
var CFG = [];
CFG.uploads_dir_user = '{UPLOADS_DIR_USER}';
CFG.upload_current = '{UPLOAD_CURRENT}';
LANG.content_tags_empty = '{LANG.content_tags_empty}.<!-- BEGIN: auto_tags --> {LANG.content_tags_empty_auto}.<!-- END: auto_tags -->';
LANG.alias_empty_notice = '{LANG.alias_empty_notice}';
var content_checkcatmsg = "{LANG.content_checkcatmsg}";
<!-- BEGIN: getalias -->
$("#idtitle").change(function() {
	get_alias();
});
<!-- END: getalias -->
//]]>
</script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.menu.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.autocomplete.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.datepicker.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}themes/admin_default/js/mangaka_content.js"></script>
<!-- END:main -->