<!-- BEGIN: main -->
<div class="well">
	<div class="row">
		<input type="hidden" id="action" name="action" value="1" />
		<input type="hidden" id="checkss" name="checkss" value="{CHECKSS}"/>
		<div class="col-lg-24 col-md-24 col-sm-24 col-xs-24">
			<h3 class="h3"><strong>Bước 1: Grab links của các tập</strong></h3>
			<div class="row margin-top-lg margin-bottom-lg">
				<div class="col-lg-3"><p>{LANG.select_structure}</p></div>
				<div class="col-lg-20">
					<select class="form-control" name="form_list" id="form_list">
						<option value="0">{LANG.select_structure}</option>
						<!-- BEGIN: getlist_loop_list-->
						<option value="{GETLIST.id}">{GETLIST.title}</option>
					<!-- END: getlist_loop_list-->
					</select>
				</div>
			</div>	
			<div class="row margin-top-lg margin-bottom-lg">
				<div class="col-lg-3"><p>URL của bộ truyện</p></div>
				<div class="col-lg-20">
					<input type="text" class="form-control" required="required" id="url" type="url" name="url" placeholder="http://blogtruyen.com/truyen/are-d">
				</div>
			</div>	  
			<div class="row margin-top-lg margin-bottom-lg">
				<div class="col-lg-24"> 
					<button id="button_getlist_url" onclick="nv_get_list_url();" class="btn btn-primary">{LANG.submit}</button> 
					<button id="button_reset_getlist_url" onclick="nv_reset_get_list_url();" class="btn btn-warning">{LANG.reset_form}</button> 
				</div>
			</div>
		</div>
	</div>
	<div id="url_loop" class="row"></div>
</div>

<div class="well">
	<div class="row">
		<input type="hidden"id="get_action" name="get_action" value="2" />
		<input type="hidden" id="get_checkss" name="get_checkss" value="{CHECKSS}" />
		<div class="col-lg-24 col-md-24 col-sm-24 col-xs-24">
			<h3 class="h3"><strong>Bước 2: Leech nội dung từng tập</strong></h3>
			<div class="row margin-top-lg margin-bottom-lg">
				<div class="col-lg-3"><p>{LANG.select_structure}</p></div>
				<div class="col-lg-20">
					<select id="form_chap" class="form-control" name="form_chap">
						<option value="0">{LANG.select_structure}</option>
						<!-- BEGIN: getlist_loop_chap-->
						<option value="{GETLIST.id}">{GETLIST.title}</option>
						<!-- END: getlist_loop_chap-->
					</select>
				</div>
			</div>	
			
			<div class="row margin-top-lg margin-bottom-lg">
				<div class="col-lg-3"><p>{LANG.select_method}</p></div>
				<div id="get_method" class="col-lg-20">
					<input type="radio" name="get_method" value="1">{LANG.dom}<br>
					<input type="radio" name="get_method" value="2">{LANG.preg_match}
				</div>
			</div>	
			
				<div class="row margin-top-lg margin-bottom-lg">
				<div class="col-lg-3"><p>Lưu vào</p></div>
				<div class="col-lg-20">
					<select class="form-control" name="catid" id="catid">
						<option value="0">{LANG.select_manga}</option>
						<!-- BEGIN: catloop-->
						<option value="{CAT.catid}">{CAT.title}</option>
						<!-- END: catloop-->
					</select>
				</div>
			</div>	
			
			<div class="row margin-top-lg margin-bottom-lg">
				<div class="col-lg-3"><p>URL truyện</p></div>
				<div class="col-lg-20">
					Dán những tập mà bạn muốn grab vào đây, có thể lấy link từ bước 1.
					<textarea class="form-control" rows="5" id="url_list" name="url_list" placeholder="http://"></textarea>
				</div>
			</div>
			
			<div class="row margin-top-lg margin-bottom-lg">
				<div class="col-lg-20"> 
					<button id="button_get_chap" onclick="nv_get_chap();" class="btn btn-primary">{LANG.submit}</button>
					<button id="button_reset_get_chap" onclick="nv_reset_get_chap();" class="btn btn-warning">{LANG.reset_form}</button> 
				</div>
			</div>
			
			<div id="get_chap_result"></div>
		</div>
	</div>
</div>
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css">
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#form_list").select2({
		placeholder: "{LANG.select_structure}"
	});

	$("#form_chap").select2({
		placeholder: "{LANG.select_structure}"
	});
	$("#catid").select2({
		placeholder: "{LANG.select_manga}"
	});
});
</script>
<!-- END: main -->