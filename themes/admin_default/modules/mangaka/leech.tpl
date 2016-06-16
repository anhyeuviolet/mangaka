	<!--  BEGIN: loading -->
	<div class="well" style="max-height: 500px; overflow-y: scroll;">
		<i class="fa fa-spinner fa-pulse fa-3x fa-fw center-block"></i>
	</div>	
	<!--  END: loading -->

	<!--  BEGIN: img_list -->
	<h3>Danh sách URL trong truyện</h3>
	<div class="well" style="max-height: 500px; overflow-y: scroll;">
		{IMGLIST}
	</div>	

	<!--  END: img_list -->
	
	<!--  BEGIN: missing_field -->
	<div class="well" style="max-height: 500px; overflow-y: scroll;">
		{LANG.getchap_missing_field}
	</div>	
	<!--  END: missing_field -->
	
	<!--  BEGIN: missing_data -->
	<div class="well" style="max-height: 500px; overflow-y: scroll;">
		{LANG.getchap_missing_data}
	</div>	
	<!--  END: missing_data -->
	

	<!-- BEGIN: getchap_result-->
	<div class="well" style="max-height: 500px; overflow-y: scroll;">
	Kết quả :
	<p>Tổng số chương đã xử lý: <strong>{TOTAL_LEECH}</strong></p>
	<p>Số chương đã bỏ qua: <strong>{SKIPPED}</strong></p>
	<p>Số chương mới đã lưu: <strong>{DONE}</strong></p>
	<p>Các chương đã xử lý:</p>
		<!-- BEGIN: loop-->	
		<strong>{THIS_CHAP}</strong>
		<!-- END: loop-->
	</div>
	<!-- END: getchap_result-->  
	
   <!-- BEGIN: getsinglgechap_result-->
	<p><strong>Kết quả:</strong></p>
	<textarea id="url_result" class="form-control" style="min-height: 300px;" onClick="this.setSelectionRange(0, this.value.length)" readonly="readonly">{URL_FULL}</textarea>
	<!-- END: getsinglgechap_result-->  
