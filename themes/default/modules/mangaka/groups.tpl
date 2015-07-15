<!-- BEGIN: main -->
<!-- BEGIN: groupdescription -->
<div class="news_column">
	<div class="alert alert-info clearfix">
		<h3>{GROUP_TITLE}</h3>
		<div class="col-md-7">
			<!-- BEGIN: image -->
			<img alt="{GROUP_TITLE}" src="{HOMEIMG1}" width="120" class="img-thumbnail pull-left imghome" />
			<!-- END: image -->
		</div>
		<div class="col-md-16">
			<p class="text-justify">{GROUP_DESCRIPTION}</p>
		</div>
	</div>
</div>
<!-- END: groupdescription -->

<!-- BEGIN: group -->
	<!-- BEGIN: letter -->
	{F_LETTER}
	<!-- END: letter -->
<div class="news_column panel panel-default">
	<div class="panel-body">
		<div class="col-md-7">
			<a href="{GROUP.link}" title="{GROUP.title}"><img alt="{GROUP.alt}" src="{GROUP.src}" width="120" class="img-thumbnail pull-left imghome" /></a>
		</div>
		<h3><a href="{GROUP.link}" title="{GROUP.title}">{GROUP.title}</a></h3>
		<div class="col-md-16">
			<p>
				<em class="fa fa-clock-o">&nbsp;</em><em>{TIME} {DATE}</em>
			</p>
			<p class="text-justify">
				{GROUP.hometext}
			</p>
		</div>
	</div>
</div>
<!-- END: group -->
<!-- BEGIN: generate_page -->
<div class="text-center">
	{GENERATE_PAGE}
</div>
<!-- END: generate_page -->
<!-- END: main -->