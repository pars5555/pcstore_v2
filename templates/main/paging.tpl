{if $ns.pageCount>1}
	<div class="navigation_pagination" id="f_pageingBox">
		<div id="pageBox" class="pagination">

			{if $ns.page > 1}	
				{assign var="pg" value=$ns.page-1}				
				<a id="f_prev" 	 rel="prev"		   
                                   href="{$SITE_PATH}?{$ns.itemSearchManager->getUrlParams(['pg'=> $pg])}"  class="prev-btn navbutton"><i class="glyphicon glyphicon-chevron-left"></i></a>
			{else}
				<span class="prev-btn disabled"><i class="glyphicon glyphicon-chevron-left"></i></span>
			{/if}

			{if $ns.pStart+1>1}
				<a class="f_pagenum current-page-number" id="tplPage_1" href="{$SITE_PATH}?{$ns.itemSearchManager->getUrlParams(['pg'=> 1])}">1</a>
				{if $ns.pStart+1>2}
					<span>...</span>
				{/if}
			{/if}

			{section name=pages loop=$ns.pEnd start=$ns.pStart}
				{assign var="pg" value=$smarty.section.pages.index+1}				
				{if $ns.page != $pg}		
					
					<a class="f_pagenum current-page-number" id="tplPage_{$pg}"
					   href="{$SITE_PATH}?{$ns.itemSearchManager->getUrlParams(['pg'=> $pg])}">{$pg}</a>
				{else}
					<span class="current current-page-number">{$pg}</span>
				{/if}
			{/section}

			{if $ns.pageCount > $ns.pEnd}
				{if $ns.pageCount > $ns.pEnd + 1}
					<span >...</span>
				{/if}
				<a class="f_pagenum current-page-number" id="tplPage_{$ns.pageCount}"
				    href="{$SITE_PATH}?{$ns.itemSearchManager->getUrlParams(['pg'=> $ns.pageCount])}">{$ns.pageCount}</a>
			{/if}

			{if $ns.page == $ns.pageCount}
				<span class="next-btn disabled"><i class="glyphicon glyphicon-chevron-right"></i></span>
			{else}
				{assign var="pg" value=$ns.page+1}				
				<a id="f_next"  rel="next"
				   href="{$SITE_PATH}?{$ns.itemSearchManager->getUrlParams(['pg'=> $pg])}"
				   class="next-btn navbutton"><i class="glyphicon glyphicon-chevron-right"></i></a>
			{/if}
		</div>
		<input type="hidden" id="f_curPage" value="{$ns.page}">
		<input type="hidden" id="f_pageCount" value="{$ns.pageCount}">
	</div>
{/if}