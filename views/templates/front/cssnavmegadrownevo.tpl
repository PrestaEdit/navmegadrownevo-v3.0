<style type="text/css">
	{literal}
	ul#topnavEvo {
		width: 100%;
		margin : {/literal}{$MDParameters.marginTop}{literal}px 0px {/literal}{$MDParameters.marginBottom}{literal}px 0px;
		height: {/literal}{$MDParameters.MenuHeight}{literal}px;
		font-size: {/literal}{$MDParameters.FontSizeMenu}{literal}px;
		background-color: {/literal}{$MDParameters.GeneralColor}{literal};
		padding-left : {/literal}{$MDParameters.paddingLeft}{literal}px;
	}
	ul#topnavEvo li a {
		height: {/literal}{$MDParameters.MenuHeight}{literal}px;
		line-height: {/literal}{$MDParameters.MenuHeight}{literal}px;
		color: {/literal}{$MDParameters.ColorFontMenu}{literal};
		font-size: {/literal}{$MDParameters.FontSizeMenu}{literal}px;
		min-width: {/literal}{$MDParameters.MinButtonWidth}{literal}px;
		{/literal}
		{if $MaxButtonWidthEvo > 0}
			{literal}
				max-width: {/literal}{$MDParameters.MaxButtonWidth}{literal}px;
				word-wrap: break-word;
			{/literal}
		{/if}
		{literal}
		_width: {/literal}{$MDParameters.MinButtonWidth}{literal}px;
	}
	ul#topnavEvo li:hover a, ul#topnavEvo li a:hover {
		color: {/literal}{$MDParameters.ColorFontMenuHover}{literal};
	}
	ul#topnavEvo li .sub {
		top: {/literal}{$MDParameters.MenuHeight}{literal}px;
		background-color: {/literal}{$MDParameters.GeneralColor}{literal};
	}
	.megaDrownTR1 {
		background-color:{/literal}{$MDParameters.backgroundTR1}{literal};
	}
	.megaDrownTD1 {
		background-color:{/literal}{$MDParameters.backgroundTD1}{literal};
	}
	.megaDrownTD2 {
		background-color:{/literal}{$MDParameters.backgroundTD2}{literal};
	}
	.megaDrownTD3 {
		background-color:{/literal}{$MDParameters.backgroundTD3}{literal};
	}
	ul#topnavEvo li .sub {
		padding-top: 10px;
	}
	ul#topnavEvo li .sub ul{
		width: {/literal}{$MDParameters.columnSize}{literal}px;
		margin-left: 10px;
	}
	ul#topnavEvo .sub ul li.stitle a {
		font-size: {/literal}{$MDParameters.FontSizeSubMenu}{literal}px;
		color: {/literal}{$MDParameters.ColorFontSubMenu}{literal};
	}
	ul#topnavEvo .sub ul li a:hover {
		color: {/literal}{$MDParameters.ColorFontSubSubMenuHover}{literal};
	}
	ul#topnavEvo .sub ul li.stitle a:hover {
		color: {/literal}{$MDParameters.ColorFontSubMenuHover}{literal};
	}
	ul#topnavEvo .sub ul li a {
		padding: {/literal}{$MDParameters.VerticalPadding}{literal}px 5px {/literal}{$MDParameters.VerticalPadding}{literal}px 15px;
		color: {/literal}{$MDParameters.ColorFontSubSubMenu}{literal};
		font-size: {/literal}{$MDParameters.FontSizeSubSubMenu}{literal}px;
	}
{/literal}
</style>
