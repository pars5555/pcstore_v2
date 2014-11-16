{include file="$TEMPLATE_DIR/admin/left_panel.tpl"} 
<div id="f_admin_config_user_management_container">
    <table id="aum_users_table" cellspacing="0" style="width:100%;">
        <thead>
            <tr>
                <th></th>
                <th>id</th>
                <th>Email</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phones</th>                        
                <th>Points</th>
                <th>Last SMS Code</th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$ns.users item=userDto}
                {assign var="user_id" value=$userDto->getId()}  
                <tr title="{if isset($ns.userCompanies.$user_id)}companies: {', '|implode:$ns.userCompanies.$user_id}{/if}
                    {if isset($ns.userServiceCompanies.$user_id)} service companies: {', '|implode:$ns.userServiceCompanies.$user_id}{/if}">
                    <td>
                        <button class="aum_delete_user_buttons" user_id="{$userDto->getId()}">X</button>
                    </td>
                    <td>{$userDto->getId()}</td>
                    <td>{$userDto->getEmail()}</td>
                    <td>{$userDto->getName()}</td>
                    <td>{$userDto->getLastName()}</td>
                    <td>{$userDto->getPhones()}</td>
                    <td>{$userDto->getPoint()}</td>
                    <td>{$userDto->getLastSmsValidationCode()}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>
</div>