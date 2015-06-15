<!-- BEGIN: main -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}js/select2/select2.min.css">
<script type="text/javascript" src="{NV_BASE_SITEURL}js/select2/select2.min.js"></script>

<div class="row">
	<div class="alert-info">
		<h1>{LANG.manga_statistic}</h1>
		<p>{LANG.total_manga} : {TOTAL_MANGA}</p>
		<p>{LANG.total_chapter} : {TOTAL_CHAP}</p>
		<p>{LANG.total_view} : {TOTAL_VIEW}</p>
	</div>
	<div class="row">
			<h2>{LANG.choose_admin_act} </h2>

		<a href="{LINK.manage_manga}" class="btn btn-info btn-lg"> {LANG.manga_manage}</a>
		<a href="{LINK.manage_chapter}" class="btn btn-primary btn-lg"> {LANG.chapter_manage}</a>
		<a href="{LINK.add_chapter}" class="btn btn-warning btn-lg"> {LANG.add} {LANG.chapter}</a>
		<a href="{LINK.manage_genre}" class="btn btn-danger btn-lg"> {LANG.genre_manage}</a>
		<a href="#" class="btn btn-default btn-lg"> {LANG.tool_upload}</a>
		<a href="#" class="btn btn-success btn-lg"> {LANG.tool_leech}</a>

	</div>
</div>
<!-- END: main -->
