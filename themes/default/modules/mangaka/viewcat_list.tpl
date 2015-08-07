<!-- BEGIN: viewcat_ajax -->
<table class="table table-bordered table-hover">
		<tbody>
		<!-- BEGIN: loop -->
			<tr>
				<td class="text-center col-md-15 col-lg-15 col-xs-12 col-sm-15">
					<a href="{CONTENT.link}">{LANG.chapter} {CONTENT.chapter}</a>
					<a target="_blank" href="{CONTENT.link}"><i class="fa fa-external-link">&nbsp;</i></a>
				</td>
				<td class="text-center col-md-9 col-lg-9 col-xs-12 col-sm-9">{CONTENT.publtime}</td>
			</tr>
		<!-- END: loop -->
		</tbody>
</table>
	<!-- BEGIN: generate_page -->
	<div class="text-center">
		{PAGE}
	</div>
	<!-- END: generate_page -->
<!-- END: viewcat_ajax -->

<!-- BEGIN: main -->
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/star-rating/jquery.rating.pack.js"></script>
<script src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/star-rating/jquery.MetaData.js" type="text/javascript"></script>
<link href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/star-rating/jquery.rating.css" type="text/css" rel="stylesheet"/>

<div class="news_content clearfix">
	<!-- BEGIN: viewdescription -->
	<table class="table">
		<colgroup>
			<col span="3" />
			<col class="w250" />
		</colgroup>
		<thead>
			<tr>
				<th class="text-center w250"><h3 class="text-center">{CONTENT.title}</h3></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<div class="manga_info clearfix">
						<div class="col-lg-8 col-md-8 col-xs-24">
							<!-- BEGIN: image -->
							<img alt="{CONTENT.title}" src="{HOMEIMG1}" width="250" class="img-thumbnail imghome center-block" />
							<!-- END: image -->
						</div>
						<div class="col-lg-16 col-md-16 col-xs-24">
						<!-- BEGIN: titlesite -->
						<h4>{LANG.titlesite} : {TITLESITE}</h4>
						<!-- END: titlesite -->
						<p class="text-justify">{CONTENT.description}</p>
						</div>
					</div>
				</td>
			</tr>
		</tbody>
		<tfoot>
			<tr class="active">
				<td>
					<div class="col-lg-16 col-md-16 col-xs-24">
						<!-- BEGIN: authors -->
						{LANG.authors} : {AUTHOR}
						<!-- END: authors -->
					</div>
					<div class="col-lg-8 col-md-8 col-xs-24 pull-right">
					<!-- BEGIN: translators -->
						{LANG.translator} : {TRANSLATOR}
					<!-- END: translators -->
					</div>
				</td>
			</tr>
			<tr class="active">
				<td>
					<div class="col-lg-16 col-md-16 col-xs-24">
					<!-- BEGIN: genre -->
					{LANG.genre} :
						<!-- BEGIN: genre_loop -->
						<a title="{GENRE.title}" href="{GENRE.link}" class="label label-success genre">{GENRE.title}</a>
						<!-- END: genre_loop -->
					<!-- END: genre -->
					</div>
					<div class="col-lg-8 col-md-8 col-xs-24 pull-right">
					<!-- BEGIN: last_update -->
						<i class="fa fa-clock-o"></i>&nbsp;{LAST_UPDATE}
					<!-- END: last_update -->
					</div>
				</td>
			</tr>
		</tfoot>
	</table>
			<div class="row">
			<div class="col-md-12">
			<!-- BEGIN: allowed_rating -->
				<form id="form3B" action="">
					<div class="clearfix">
						<div id="stringrating">
							{STRINGRATING}
						</div>
			            <!-- BEGIN: data_rating -->
			            <span itemscope itemtype="http://data-vocabulary.org/Review-aggregate">
			               {LANG.rating_average}:
			               <span itemprop="rating">{NUMBERRATING}</span> -
			               <span itemprop="votes">{CLICK_RATING}</span> {LANG.rating_count}
			            </span>
			            <!-- END: data_rating -->
						<div style="padding: 5px;">
							<input class="hover-star" type="radio" value="1" title="{LANGSTAR.verypoor}" /><input class="hover-star" type="radio" value="2" title="{LANGSTAR.poor}" /><input class="hover-star" type="radio" value="3" title="{LANGSTAR.ok}" /><input class="hover-star" type="radio" value="4" title="{LANGSTAR.good}" /><input class="hover-star" type="radio" value="5" title="{LANGSTAR.verygood}" /><span id="hover-test" style="margin: 0 0 0 20px;">{LANGSTAR.note}</span>
						</div>
					</div>
				</form>
				<script type="text/javascript">
					var sr = 0;
					$('.hover-star').rating({
						focus : function(value, link) {
							var tip = $('#hover-test');
							if (sr != 2) {
								tip[0].data = tip[0].data || tip.html();
								tip.html(link.title || 'value: ' + value);
								sr = 1;
							}
						},
						blur : function(value, link) {
							var tip = $('#hover-test');
							if (sr != 2) {
								$('#hover-test').html(tip[0].data || '');
								sr = 1;
							}
						},
						callback : function(value, link) {
							if (sr == 1) {
								sr = 2;
								$('.hover-star').rating('disable');
								sendrating_cat('{CATID}', value, '{CHECKSS}');
							}
						}
					});

					$('.hover-star').rating('select', '{NUMBERRATING}');
				</script>
				<!-- BEGIN: disablerating -->
				<script type="text/javascript">
					$(".hover-star").rating('disable');
					sr = 2;
				</script>
				<!-- END: disablerating -->
				<!-- END: allowed_rating -->
			</div>
		</div>
	<!-- END: viewdescription -->
	<div class="chapter_content_head">
	<table class="table">
		<thead>
			<tr class="manga_info">
				<th class="text-center col-md-15 col-lg-15 col-xs-24 col-sm-15">{LANG.chapter}</th>
				<th class="text-center col-md-9 col-lg-9 col-xs-24 col-sm-9">{LANG.last_update}</th>
			</tr>
		</thead>
	</table>
	</div>
	<div class="chapter_content" id="chapter_content"></div>
	<div id="tabs" class="tabs">
		<nav>
			<ul>
				<!-- BEGIN: disqus_tab -->
				<li>
					<a href="#section-1"><em class="fa fa-comment-o">&nbsp;</em><span>{LANG.disqus_comment}</span></a>
				</li>
				<!-- END: disqus_tab -->

				<!-- BEGIN: fb_comment_tab -->
				<li>
					<a href="#section-2"><i class="fa fa-facebook-square"></i>&nbsp;</em><span>{LANG.fb_comment}</span></a>
				</li>
				<!-- END: fb_comment_tab -->

				<!-- BEGIN: comment_tab -->
				<li>
					<a href="#section-3"><em class="fa fa-comments-o">&nbsp;</em><span>{LANG.comment}</span></a>
				</li>
				<!-- END: comment_tab -->
			</ul>
		</nav>
		<div class="content">
			<!-- BEGIN: disqus -->
			<section id="section-1">
				<div id="disqus_thread"></div>
					<script type="text/javascript">
						var disqus_shortname = '{DISQUS_SHORTNAME}'; 
						(function() {
							var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
							dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
							(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
						})();
					</script>
			<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
			</section>
			<!-- END: disqus -->
			<!-- BEGIN: fb_comment -->
			<section id="section-2">
				<div class="fb-comments" data-href="{SELFURL}" data-numposts="5" data-colorscheme="light"></div>
				<style>.fb-comments, .fb-comments iframe[style], .fb-like-box, .fb-like-box iframe[style] {width: 100% !important;}
				.fb-comments span, .fb-comments iframe span[style], .fb-like-box span, .fb-like-box iframe span[style] {width: 100% !important;}
				</style>
			</section>
			<!-- END: fb_comment -->
			<!-- BEGIN: comment -->
			<section id="section-3">
				{CONTENT_COMMENT}
			</section>
			<!-- END: comment -->
		</div>
	</div>
</div>
<!-- BEGIN: tooltip -->

<!-- END: tooltip -->
<script type="text/javascript" src="{NV_BASE_SITEURL}themes/{MODULE_THEME}/js/mangaka_tab.js"></script>
<script type="text/javascript">
	var detail_error_group = '{LANG.detail_error_group}';
	new CBPFWTabs(document.getElementById('tabs'));
</script>
<script type="text/javascript">
	$('#chapter_content').load( nv_siteroot + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=viewcat_ajax&ajax=1&catid={CATID}&per_page={PER_PAGE}' );
</script>
<!-- END: main -->