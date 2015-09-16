<!-- BEGIN: main -->
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/star-rating/jquery.rating.pack.js"></script>
<script src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/star-rating/jquery.MetaData.js" type="text/javascript"></script>
<link href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/star-rating/jquery.rating.css" type="text/css" rel="stylesheet"/>

<div class="news_column panel panel-default">
	<div class="panel-body">
		<h1>{DETAIL.detail_title}</h1>
		<em class="pull-left time">{DETAIL.publtime}</em>
		<hr class="clear"/>
		<!-- BEGIN: no_public -->
		<div class="alert alert-warning">
			{LANG.no_public}
		</div>
		<!-- END: no_public -->
		<!-- BEGIN: showhometext -->
		<div id="hometext">
			<!-- BEGIN: imgthumb -->
			<div class="imghome pull-left text-center" style="width:{DETAIL.image.width}px;">
				<a href="{DETAIL.homeimgfile}" title="{DETAIL.image.alt}" rel="shadowbox"><img alt="{DETAIL.image.alt}" src="{DETAIL.image.src}" alt="{DETAIL.image.note}" width="{DETAIL.image.width}" class="img-thumbnail" /></a>
				<em>{DETAIL.image.note}</em>
			</div>
			<!-- END: imgthumb -->
		</div>
		<!-- BEGIN: imgfull -->
		<div style="max-width:{DETAIL.image.width}px;margin: 10px auto 10px auto">
			<img alt="{DETAIL.image.alt}" src="{DETAIL.image.src}" width="{DETAIL.image.width}" class="img-thumbnail" />
			<p class="imgalt">
				<em>{DETAIL.image.note}</em>
			</p>
		</div>
		<!-- END: imgfull -->
		<!-- END: showhometext -->
		<div class="row" align="center">
			<div class="col-md-8">
			<!-- BEGIN: pre_top -->
			<a href="{PREV.link}" title="{PREV.chapter}"><span class="btn btn-info"><i class="fa fa-chevron-circle-left"></i>&nbsp;{LANG.pre_chapter}</span></a>
			<!-- END: pre_top -->
			</div>
			<div class="col-md-8">
			<select class="form form-control" onchange="window.location.href=$(this).val()">
			<!-- BEGIN: list_chap_top -->
			<option value="{LIST_CHAP.link}" {LIST_CHAP.selected}> {LANG.chapter} {LIST_CHAP.chapter}</option>
			<!-- END: list_chap_top -->
			</select>
			</div>
			<div class="col-md-8">
			<!-- BEGIN: next_top -->
			<a href="{NEXT.link}" title="{NEXT.chapter}"><span class="btn btn-info">{LANG.next_chapter}&nbsp;<i class="fa fa-chevron-circle-right"></i></span></a>
			<!-- END: next_top -->
			</div>
		</div>
		<div class="bodytext">
		<!-- BEGIN: body -->
			<img src="{BODY_SRC}"/><br/>
		<!-- END: body -->
		</div>
		<div class="row" align="center">
			<div class="col-md-8">
			<!-- BEGIN: pre -->
			<a href="{PREV.link}" title="{PREV.chapter}"><span class="btn btn-info"><i class="fa fa-chevron-circle-left"></i>&nbsp;{LANG.pre_chapter}</span></a>
			<!-- END: pre -->
			</div>
			<div class="col-md-8">
			<select class="form form-control" onchange="window.location.href=$(this).val()">
			<!-- BEGIN: list_chap -->
			<option value="{LIST_CHAP.link}" {LIST_CHAP.selected}> {LANG.chapter} {LIST_CHAP.chapter}</option>
			<!-- END: list_chap -->
			</select>
			</div>
			<div class="col-md-8">
			<!-- BEGIN: next -->
			<a href="{NEXT.link}" title="{NEXT.chapter}"><span class="btn btn-info">{LANG.next_chapter}&nbsp;<i class="fa fa-chevron-circle-right"></i></span></a>
			<!-- END: next -->
			</div>
		</div>
		<!-- BEGIN: author -->
		<!-- BEGIN: name -->
		<p class="text-right">
			<strong>{LANG.author}: </strong>{DETAIL.author}
		</p>
		<!-- END: name -->
		<!-- BEGIN: source -->
		<p class="text-right">
			<strong>{LANG.source}: </strong>{DETAIL.source}
		</p>
		<!-- END: source -->
		<!-- END: author -->
		<hr />
        <!-- BEGIN: socialbutton -->
        <div class="socialicon pull-left">
        	<div style="width:65px" class="fb-share-button" data-href="{SELFURL}" data-layout="button">&nbsp;</div>
	        <div class="fb-like" data-href="{SELFURL}" data-width="100" data-height="30" data-colorscheme="light" data-layout="button_count" data-action="like" data-show-faces="true" data-send="false">&nbsp;</div>
	        <div class="g-plusone" data-size="medium"></div>
	    </div>
        <!-- END: socialbutton -->
        <!-- BEGIN: adminlink -->
		<p class="text-right adminlink">
			{ADMINLINK}
		</p>
		<!-- END: adminlink -->
		<div class="clear">&nbsp;</div>
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
			               <span itemprop="rating">{DETAIL.numberrating}</span> -
			               <span itemprop="votes">{DETAIL.click_rating}</span> {LANG.rating_count}
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
								sendrating('{NEWSID}', value, '{NEWSCHECKSS}');
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
		<!-- BEGIN: fb_comment -->
		<div class="fb-comments" data-href="{SELFURL}" data-width="100%" data-numposts="5" data-colorscheme="light"></div>
		<!-- END: fb_comment -->
		<!-- BEGIN: comment -->
		<section id="section-3">
			{CONTENT_COMMENT}
		</section>
		<!-- END: comment -->		
	</div>
</div>

<!-- END: main -->
<!-- BEGIN: no_permission -->
<div class="alert alert-info">
	{NO_PERMISSION}
</div>
<!-- END: no_permission -->