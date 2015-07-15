<!-- BEGIN: main -->
<div class="list-group"> 
	<!-- BEGIN: viewcatloop -->
	<div class="row panel panel-body">
		<h3 class="text-center"><a href="{CONTENT.link}" title="{CONTENT.title}">{CONTENT.title} <!-- BEGIN: last_chap -->- {LAST_CHAP}<!-- END: last_chap --></a></h3>
		<div class="col-lg-24 col-md-24 col-xs-24 info">
			<div class="col-lg-8 col-md-8 col-xs-24">
				<a href="{CONTENT.link}" title="{CONTENT.title}"><img alt="{CONTENT.title}" src="{CONTENT.imghome}" width="{IMGWIDTH1}" class="img-thumbnail imghome center-block" /></a>
			</div>
			<div class="col-lg-16 col-md-16 col-xs-24">
			<p class="text-justify">{CONTENT.descriptionhtml}</p>
			</div>
		</div>
		<div class="col-lg-24 col-md-24 col-xs-24 info">
			<div class="col-lg-16 col-md-16 col-xs-24">
				<!-- BEGIN: authors -->
				{LANG.authors} : {AUTHOR}
				<!-- END: authors -->
			</div>
			<div class="col-lg-8 col-md-8 col-xs-24">
			<!-- BEGIN: translators -->
				{LANG.translator} : {TRANSLATOR}
			<!-- END: translators -->
			</div>
			
			<div class="col-lg-16 col-md-16 col-xs-24">
			<!-- BEGIN: block_icon -->
			<i class="fa fa-tags"></i>
			<!-- END: block_icon -->
			<!-- BEGIN: block_loop -->
				<a title="{BID.title}" href="{BID.link}" class="label label-success">{BID.title}</a>
			<!-- END: block_loop -->
			</div>
			<div class="col-lg-8 col-md-8 col-xs-24">
			<!-- BEGIN: last_update -->
				<i class="fa fa-clock-o"></i>&nbsp;{LAST_UPDATE}
			<!-- END: last_update -->
			</div>
		</div>
	</div>
	<!-- END: viewcatloop -->
</div>
<!-- BEGIN: generate_page -->
<div class="text-center">
	{GENERATE_PAGE}
</div>
<!-- END: generate_page -->
<!-- BEGIN: tooltip -->
<script type="text/javascript">
	$(document).ready(function() {$("[data-rel='tooltip'][data-content!='']").tooltip({
		placement: "{TOOLTIP_POSITION}",
		html: true,
		title: function(){return ( $(this).data('img') == '' ? '' : '<img class="img-thumbnail pull-left margin_image" src="' + $(this).data('img') + '" width="90" />' ) + '<p class="text-justify">' + $(this).data('content') + '</p><div class="clearfix"></div>';}
	});});
</script>
<!-- END: tooltip -->
<!-- END: main -->