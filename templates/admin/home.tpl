{include file="$TEMPLATE_DIR/admin/left_panel.tpl"} 


todays total visitors count: {$ns.today_visitors|@count}</br>
todays total guest visitors count: {$ns.today_guest_visitors|@count}</br>
todays total user visitors count: {$ns.today_user_visitors|@count}</br>
todays total company visitors count: {$ns.today_company_visitors|@count}</br>
todays total service company visitors count: {$ns.today_service_company_visitors|@count}</br>
todays total admin visitors count: {$ns.today_admin_visitors|@count}</br></br>

{foreach from=$ns.onlineusers item=ol name=cl}
    {$ol->getId()} {$ol->getEmail()} {$ol->getLoginDateTime()} {$ol->getIp()} {$ol->getCountry()}<br/>
{/foreach}
