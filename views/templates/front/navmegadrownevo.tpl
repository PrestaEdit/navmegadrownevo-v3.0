<!-- MeGa DrOwN mEnU Evolution v3.0 -->
	{*<div style="padding-bottom: {$MarginBottomEvo}px; padding-top: {$MarginTopEvo}px ">*}
	<style type="text/css">
		{$css_megadrownevo}
	</style>
	<div>
		<div class="container">
			<ul id="topnavEvo">
				{$menuMDEvo}
				{if $search_bar}
				<li class="sf-search noBack" style="float:right">
					<form id="searchbox" action="{$link->getPageLink('search')|escape:'html'}" method="get">
						<p>
							<input type="hidden" name="controller" value="search" />
							<input type="hidden" value="position" name="orderby"/>
							<input type="hidden" value="desc" name="orderway"/>
							<input type="text" name="search_query" value="{if isset($smarty.get.search_query)}{$smarty.get.search_query|escape:'htmlall':'UTF-8'}{/if}" />
						</p>
					</form>
				</li>
				{/if}
			</ul>
		</div>
	</div>
<!-- /MeGa DrOwN mEnU Evolution v3.0 -->

