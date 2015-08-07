<!-- BEGIN: main -->
<div class="list-group"> 
	<!-- BEGIN: viewcatloop -->
	<div class="row panel panel-body">
		<h3 class="text-center manga_title"><a href="{CONTENT.link}" title="{CONTENT.title}">{CONTENT.title}<!-- BEGIN: last_chap -->&nbsp;-&nbsp;{LAST_CHAP}<!-- END: last_chap --></a></h3>
		<div class="col-lg-24 col-md-24 col-xs-24 manga_info">
			<div class="col-lg-8 col-md-8 col-xs-24">
				<a href="{CONTENT.link}" title="{CONTENT.title}"><img alt="{CONTENT.title}" src="{CONTENT.imghome}" width="{IMGWIDTH1}" class="img-thumbnail imghome center-block" /></a>
			</div>
			<div class="col-lg-16 col-md-16 col-xs-24">
			<p class="text-justify">{CONTENT.descriptionhtml}</p>
			</div>
		</div>
		<div class="col-lg-24 col-md-24 col-xs-24 manga_info">
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
			<!-- BEGIN: block_icon --><i class="fa fa-tags"></i><!-- END: block_icon -->
			<!-- BEGIN: block_loop -->
				<a title="{BID.title}" href="{BID.link}" class="label label-success genre">{BID.title}</a>
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

<!-- END: tooltip -->
<!-- END: main -->