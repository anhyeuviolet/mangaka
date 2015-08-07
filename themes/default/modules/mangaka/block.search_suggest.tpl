<!-- BEGIN: main -->
<link href="{NV_BASE_SITEURL}themes/{MODULE_THEME}/css/mangaka_perfect-scrollbar.min.css" rel="stylesheet">
<script type="text/javascript">
	$(document).ready(function($) {
		$("#scrolling").hide();
		$('#scrolling').perfectScrollbar();
	});

	$(function() {
		$(".search").keyup(function() {
			var keywords = $(this).val();
			var dataString = 'keywords=' + keywords;
			var myLength = $("#keyword").val().length;
			if( keyword != '' )	
			{
				if (myLength >=3 ) {
					$.ajax({
						type : "POST",
						url : "{SEARCH_URL}",
						data : dataString,
						cache : false,
						success : function(html) {
							if (html != '') {
								$("#scrolling").show();
								$("#result").html(html).show();
							} else {
								$("#result").hide();
								$("#scrolling").hide();
							}
						}
					});
				} 
				else 
				if (myLength < 3 ) 
				{
					$("#result").hide();
					$("#scrolling").hide();
				}
			}
		});

		jQuery(document).on("click", function(e) {
			var $clicked = $(e.target);
			if (! $clicked.hasClass("search")) {
				jQuery("#result").fadeOut();
			}
		});

		$('#keyword').click(function() {
			jQuery("#result").fadeIn();
		});
	});
</script>

<div class="search-widget">
	<form action="{NV_BASE_SITEURL}" method="get" name="frm_search" onsubmit="return onsubmitsearch();" class="search-box" _lpchecked="1" onkeypress="return event.keyCode!=13">
		<input autocomplete="off" class="search" id="keyword" type="text" value="{value_keyword}" name="keyword" placeholder="{LANG.search}" />
		<button type="button" type="button" name="submit" id="submit" onclick="onsubmitsearch('{MODULE_NAME}')">
			<i class="fa fa-search"></i>
		</button>
		<br />
		<div id="scrolling" class="wrapper">
			<div id="result"></div>
		</div>
	</form>
</div>
<script src="{NV_BASE_SITEURL}themes/{MODULE_THEME}/js/mangaka_jquery.mousewheel.js"></script>
<script src="{NV_BASE_SITEURL}themes/{MODULE_THEME}/js/mangaka_perfect-scrollbar.min.js"></script>
<!-- END: main -->