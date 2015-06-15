<!-- BEGIN: main -->
<div class="well">
	<form class="bs-example form-horizontal" method="POST" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}">
	<input type="hidden" name="action" value="1" />
	<input type="hidden" name="checkss" value="{CHECKSS}" />
	<fieldset>
	  <legend>Bước 1: Grab links của các tập</legend>
	  	<div class="form-group">
			<label class="col-lg-2 control-label">Chọn mẫu cấu trúc:</label>
			<div class="col-lg-20">
			  <select class="form-control" name="form_list" id="form_list">
				<option value="">{LANG.select_leech_form} ----- Chọn mẫu cấu trúc -----</option>
			  <!-- BEGIN: getlist_loop_list-->
				<option value="{GETLIST.id}">{GETLIST.title}</option>
			  <!-- END: getlist_loop_list-->
			  </select>
			</div>
		</div>	
	  <div class="form-group">
		<label class="col-lg-2 control-label">URL của bộ truyện</label>
		<div class="col-lg-20">
		  <input type="text" class="form-control" name="url" placeholder="http://blogtruyen.com/truyen/are-d">
		  Dán URL của bộ truyện vào để lấy link tập trong đó!
		</div>
	  </div>	  
	  <div class="form-group">
		<div class="col-lg-20 col-lg-offset-4"> 
		  <button type="submit" class="btn btn-primary">{LANG.submit}</button> 
		</div>
	  </div>
	</fieldset>
  </form>
<!--  BEGIN: img_list -->
  <h3>Danh sách URL trong truyện</h3>
  <div class="well" style="max-height: 500px; overflow-y: scroll;">
    <!--  BEGIN: img_list.loop -->
  {IMGLIST}<br/>
    <!--  END: img_list.loop -->
  </div>
  <!--  END: img_list -->
</div>

<div class="well">
  <form class="bs-example form-horizontal" method="POST" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}">
	<input type="hidden" name="action" value="2" />
	<input type="hidden" name="checkss" value="{CHECKSS}" />
	<fieldset>
	  <legend>Bước 2: Leech nội dung từng tập</legend>
	  	<div class="form-group">
			<label class="col-lg-2 control-label">Chọn mẫu cấu trúc:</label>
			<div class="col-lg-20">
			  <select class="form-control" name="form_chap" id="form_chap" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')">
				<option value="">{LANG.select_manga} ----- Chọn cấu trúc -----</option>
			  <!-- BEGIN: getlist_loop_chap-->
				<option value="{GETLIST.id}">{GETLIST.title}</option>
			  <!-- END: getlist_loop_chap-->
			  </select>
			</div>
		</div>	
		<div class="form-group">
			<label class="col-lg-2 control-label">Lưu vào:</label>
			<div class="col-lg-20">
			  <select class="form-control" name="catid" id="catid">
				<option value="">{LANG.select_manga} ----- Chọn truyện -----</option>
			  <!-- BEGIN: catloop-->
				<option value="{CAT.catid}">{CAT.title}</option>
			  <!-- END: catloop-->
			  </select>
			</div>
		</div>	  
	  <div class="form-group">
		<label class="col-lg-2 control-label">URL truyện</label>
		<div class="col-lg-20">
		  <textarea class="form-control" rows="5" name="url_list" placeholder="Dán những tập mà bạn muốn grab vào đây, có thể lấy link từ bước 1 có dạng : http://"></textarea>
		  Dán những tập mà bạn muốn grab vào đây, có thể lấy link từ bước 1
		</div>
	  </div>
	  <div class="clearfix form-group">
		<div class="col-lg-20 col-lg-offset-4"> 
		Hãy kiểm tra cẩn thận xem đã đúng cả chưa rồi Submit, nếu sai thì sẽ phải sửa rất nhiều<br /><br />
		  <button type="submit" class="btn btn-primary">{LANG.submit}</button> 
		</div>
	  </div>
	   <!-- BEGIN: getchap_result-->
			 <div class="form-group">
			 Kết quả
			
				<!-- BEGIN: loop-->	
					{THIS_CHAP}
				<!-- END: loop-->
			
			</div>
			<!-- END: getchap_result-->  
	</fieldset>
  </form>
</div>
<!-- END: main -->