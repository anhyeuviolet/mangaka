<!-- BEGIN: main -->
<!-- BEGIN: groupdescription -->
<div class="news_column">
	<div class="alert alert-info clearfix">
		<h3>{GROUP_TITLE}</h3>
		<!-- BEGIN: image -->
		<img alt="{GROUP_TITLE}" src="{HOMEIMG1}" width="{IMGWIDTH1}" class="img-thumbnail pull-left imghome" />
		<!-- END: image -->
		<p class="text-justify">{GROUP_DESCRIPTION}</p>
	</div>
</div>
<!-- END: groupdescription -->

<!-- BEGIN: group -->
<div class="news_column panel panel-default">
	<div class="panel-body">
		<a href="{GROUP.link}" title="{GROUP.title}"><img alt="{GROUP.alt}" src="{GROUP.src}" width="{GROUP.width}" class="img-thumbnail pull-left imghome" /></a>
		<!-- BEGIN: letter -->
		{F_LETTER}
		<!-- END: letter -->
		<h3><a href="{GROUP.link}" title="{GROUP.title}">{GROUP.title}</a></h3>
		<!-- BEGIN: time -->
		<p>
			<em class="fa fa-clock-o">&nbsp;</em><em>{TIME} {DATE}</em>
		</p>
		<!-- END: time -->
		<p class="text-justify">
			{GROUP.hometext}
		</p>
	</div>
</div>
<!-- END: group -->
<!-- BEGIN: generate_page -->
<div class="text-center">
	{GENERATE_PAGE}
</div>
<!-- END: generate_page -->
<!-- END: main -->