<!-- BEGIN: main -->
<div class="list-group"> 
	<!-- BEGIN: viewcatloop -->
	<table class="table">
		<colgroup>
			<col span="3" />
			<col class="w250" />
		</colgroup>
		<thead>
			<tr>
				<th class="text-center w250"><a href="{CONTENT.link}" title="{CONTENT.title}"><h3 class="text-center">{CONTENT.title}</h3></a></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<div class="info clearfix">
						<div class="col-lg-8 col-md-8 col-xs-24">
							<!-- BEGIN: image -->
							<img alt="{CONTENT.title}" src="{HOMEIMG1}" width="{IMGWIDTH1}" class="img-thumbnail imghome center-block" />
							<!-- END: image -->
						</div>
						<div class="col-lg-16 col-md-16 col-xs-24">
						<p class="text-justify">{CONTENT.descriptionhtml}</p>
						</div>
					</div>
				</td>
			</tr>
		</tbody>
		<tfoot>
			<tr class="info">
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
			<tr class="info">
				<td>
					<div class="col-lg-16 col-md-16 col-xs-24">
					<i class="fa fa-tags"></i>
						<!-- BEGIN: block -->
						<a title="{BID.title}" href="{BID.link}" class="label label-success">{BID.title}</a>
						<!-- END: block -->
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