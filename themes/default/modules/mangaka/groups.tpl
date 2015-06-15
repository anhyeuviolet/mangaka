<!-- BEGIN: main -->
<!-- BEGIN: topicdescription -->
<div class="news_column">
	<div class="alert alert-info clearfix">
		<h3>{TOPIC_TITLE}</h3> {TOPIC_NUM}
		<!-- BEGIN: image -->
		<img alt="{TOPIC_TITLE}" src="{HOMEIMG1}" width="{IMGWIDTH1}" class="img-thumbnail pull-left imghome" />
		<!-- END: image -->
		<p class="text-justify">{TOPIC_DESCRIPTION}</p>
	</div>
</div>
<!-- END: topicdescription -->

<!-- BEGIN: topic -->
<div class="news_column panel panel-default">
	<div class="panel-body">
		<!-- BEGIN: hide_homethumb -->
		<a href="{TOPIC.link}" title="{TOPIC.title}"><img alt="{TOPIC.alt}" src="{TOPIC.src}" width="{TOPIC.width}" class="img-thumbnail pull-left imghome" /></a>
		<!-- END: hide_homethumb -->
		<!-- BEGIN: letter -->
		{F_LETTER}
		<!-- END: letter -->
		<h3><a href="{TOPIC.link}" title="{TOPIC.title}">{TOPIC.title}</a></h3>
		<!-- BEGIN: time -->
		<p>
			<em class="fa fa-clock-o">&nbsp;</em><em>{TIME} {DATE}</em>
		</p>
		<!-- END: time -->
		<p class="text-justify">
			{TOPIC.hometext}
		</p>
	</div>
</div>
<!-- END: topic -->
<!-- BEGIN: generate_page -->
<div class="text-center">
	{GENERATE_PAGE}
</div>
<!-- END: generate_page -->
<!-- END: main -->