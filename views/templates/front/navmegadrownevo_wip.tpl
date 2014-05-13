<!-- MeGa DrOwN mEnU Evolution v3.0 -->
	{*<div style="padding-bottom: {$MarginBottomEvo}px; padding-top: {$MarginTopEvo}px ">*}
	<style type="text/css">
		{$css_megadrownevo}
	</style>
	<ul id="topnavEvo">
		{foreach $menu.li item=li key=b}
			<li class="liBouton liBouton{$b}">
				<div style="{$li.decal}">
					<a href="{$li.link_button}" {if $li.onclick}"onclick='return false'"{/if} class="buttons" {if $li.style}"style={$li.style}"{/if}>
						{$li.name}
					</a>
				</div>
				{if isset($li.sub) && $li.sub}
				<div class="sub" style="width: {$menu.parameters.MenuWidth - 2}px;  background-color: {$li.sub.bg_color};">
					<table class="megaDrownTable" cellpadding="0" cellspacing="0" width="100%">
						{if isset($li.tr1) && $li.tr1}
						<tr style="height: {$menu.parameters.heightTR1}px">
								<td class="megaDrownTR1" valign="top" colspan="{if $menu.parameters.stateTD1}2{else}1{/if}">
									{$li.tr1.details.sub_tr}
								</td>
								<td rowspan="2" class="megaDrownTD3" valign="top" style="width: {$menu.parameters.widthTD3}px">
									{$li.tr1.details.sub}
								</td>
						</tr>
						{/if}
						<tr>
							{if isset($li.td1) && $li.td1}
							<td class="megaDrownTD1" valign="top" style="width:{$menu.parameters.widthTD1}px">
								{if isset($li.td1.img) && $li.td1.img}
							 		{if isset($li.td1.img.link) && $li.td1.img.link != ''}
										<a href="{$li.td1.img.link}" style="float: none; margin: 0; padding: 0">
											<img src="{$_path}views/img/menu/{$li.td1.img.name}" style="border:0px" alt="{$li.td1.img.name}" />
										</a>
									{else}
										<img src="{$_path}views/img/menu/{$li.td1.img.name}" style="border: 0px" alt="{$li.td1.img.name}" />
									{/if}
								{/if}
								<br />
								{$li.td1.details}
							</td>
							{/if}

							<td class="megaDrownTD2" valign="top">
								<table class="MegaEvoLinks" style="border: 0px">
									<tr>
										{* TO CONTINUE: boucle FOR *}
									</tr>
								</table>
							</td>

							{if isset($li.td3) && $li.td3}
								<td class="megaDrownTD3" valign="top" style="width:{$menu.parameters.widthTD3}px">
									{$li.td3.details}
								</td>
							{/if}
						</tr>
					</table>
				</div>
				{/if}
			</li>
		{/foreach}
		{if $menu.search_bar}
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
<!-- /MeGa DrOwN mEnU Evolution v3.0 -->

