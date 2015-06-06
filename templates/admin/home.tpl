<div class="container_home">
    <div class="visiting_statistics">
        <div>todays total visitors count: {$ns.today_visitors|@count}</div>
        <div>todays total guest visitors count: {$ns.today_guest_visitors|@count}</div>
        <div>todays total user visitors count: {$ns.today_user_visitors|@count}</div>
        <div>todays total company visitors count: {$ns.today_company_visitors|@count}</div>
        <div>todays total service company visitors count: {$ns.today_service_company_visitors|@count}</div>
        <div>todays total admin visitors count: {$ns.today_admin_visitors|@count}</div>
    </div>

    <div class="online-users">
        {foreach from=$ns.onlineusers item=ol name=cl}
            {$ol->getId()} {$ol->getEmail()} {$ol->getLoginDateTime()} {$ol->getIp()} {$ol->getCountry()}<br/>
        {/foreach}
    </div>
</div>
