<div class="container_users">
    <div id="f_admin_config_user_management_container">
        <div class="table_striped" id="aum_users_table" cellspacing="0" style="width:100%;">
            <div class="table_header_group">
                <div class="table-row">
                    <div class="table-cell"><span class="glyphicon" style="color:#cc0000;"></span></div>
                    <div class="table-cell">id</div>
                    <div class="table-cell">Email</div>
                    <div class="table-cell">First Name</div>
                    <div class="table-cell">Last Name</div>
                    <div class="table-cell">Phones</div>                        
                    <div class="table-cell">Points</div>
                    <div class="table-cell">Last SMS Code</div>
                </div>
            </div>
            {foreach from=$ns.users item=userDto}
                {assign var="user_id" value=$userDto->getId()}  
                <div class="table-row" title="{if isset($ns.userCompanies.$user_id)}companies: {', '|implode:$ns.userCompanies.$user_id}{/if}
                     {if isset($ns.userServiceCompanies.$user_id)} service companies: {', '|implode:$ns.userServiceCompanies.$user_id}{/if}">
                    <div class="table-cell">
                        <button class="aum_delete_user_buttons" user_id="{$userDto->getId()}"><span class="glyphicon" style="color:#cc0000;"></span></button>
                    </div>
                    <div class="table-cell">{$userDto->getId()}</div>
                    <div class="table-cell">{$userDto->getEmail()}</div>
                    <div class="table-cell">{$userDto->getName()}</div>
                    <div class="table-cell">{$userDto->getLastName()}</div>
                    <div class="table-cell">{$userDto->getPhones()}</div>
                    <div class="table-cell">{$userDto->getPoint()}</div>
                    <div class="table-cell">{$userDto->getLastSmsValidationCode()}</div>
                </div>
            {/foreach}
        </div>
    </div>
</div>