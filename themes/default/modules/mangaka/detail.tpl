<!-- BEGIN: main -->
<link href="{NV_BASE_SITEURL}editors/ckeditor/plugins/codesnippet/lib/highlight/styles/github.css" rel="stylesheet">
<!-- BEGIN: facebookjssdk -->
<div id="fb-root"></div>
<script type="text/javascript">
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/{FACEBOOK_LANG}/all.js#xfbml=1&appId={FACEBOOK_APPID}";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<!-- END: facebookjssdk -->
<!-- BEGIN: facebook_pubsdk -->
<div id="fb-root"></div>
<script>
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/{FACEBOOK_LANG}/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<!-- END: facebook_pubsdk -->
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
		<div class="bodytext">
		<!-- BEGIN: body -->
			<img src="{BODY_SRC}"/><br/>
		<!-- END: body -->
		</div>
		<!-- BEGIN: pre -->
		<a href="{PREV.link}" title="{PREV.chapter}">{LANG.pre_chapter}</a>
		<!-- END: pre -->
		
		<!-- BEGIN: next -->
		<a href="{NEXT.link}" title="{NEXT.chapter}">{LANG.next_chapter}</a>
		<!-- END: next -->
		
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
		<!-- BEGIN: copyright -->
		<div class="alert alert-info copyright">
			{COPYRIGHT}
		</div>
		<!-- END: copyright -->

		<hr />
        <!-- BEGIN: socialbutton -->
        <div class="socialicon pull-left">
        	<div style="width:65px" class="fb-share-button" data-href="{SELFURL}" data-layout="button">&nbsp;</div>
	        <div class="fb-like" data-href="{SELFURL}" data-width="The pixel width of the plugin" data-height="The pixel height of the plugin" data-colorscheme="light" data-layout="button_count" data-action="like" data-show-faces="true" data-send="false">&nbsp;</div>
	        <div class="g-plusone" data-size="medium"></div>
	        <script type="text/javascript">
	          window.___gcfg = {lang: nv_sitelang};
	          (function() {
	            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	            po.src = 'https://apis.google.com/js/plusone.js';
	            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	          })();
	        </script>
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
		<style>.fb-comments, .fb-comments iframe[style], .fb-like-box, .fb-like-box iframe[style] {width: 100% !important;}
		.fb-comments span, .fb-comments iframe span[style], .fb-like-box span, .fb-like-box iframe span[style] {width: 100% !important;}
		</style>
		<!-- END: fb_comment -->

			<!-- BEGIN: comment -->
			<section id="section-3">
				{CONTENT_COMMENT}
			</section>
			<!-- END: comment -->		
		
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$(".bodytext img").toggleClass('img-thumbnail center-block');
});
</script>
<!-- BEGIN: replace_img_src --> 

<script type='text/javascript'>
//<![CDATA[
var images = document.getElementsByTagName("img");
for(var i=0;i<images.length;i++) {    
images[i].src = images[i].src.replace(/[0-9]+.bp.blogspot.com/,"lh4.googleusercontent.com");
}
//]]>
</script>
<!-- END: replace_img_src --> 

<!-- END: main -->
<!-- BEGIN: no_permission -->
<div class="alert alert-info">
	{NO_PERMISSION}
</div>
<!-- END: no_permission -->