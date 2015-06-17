<div class="container_banners">
    {if isset($ns.error_message)}
        {$ns.error_message}
    {/if}
    {if isset($ns.success_message)}
        {$ns.success_message}
    {/if}
    <table>
        <thead>
            <tr>
                <th>banner</th>
                <th>path</th>
                <th>active</th>
                <th>delete</th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$ns.bannersDtos item=banner}
                <tr>                   
                    <td>
                        <img src="{$SITE_PATH}/img/banners/{$banner->getId()}.jpg" style="width: 100px"/>
                    </td>
                    <td>
                        {$banner->getPath()}
                    </td>
                    <td>
                        <input type="checkbox" {if $banner->getActive()==1}checked{/if}/>
                    </td>
                    <td>
                        <a href="{$SITE_PATH}/dyn/admin/do_delete_banner?banner_id={$banner->getId()}">delete</a>
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>


    <form enctype="multipart/form-data" method="post" action="{$SITE_PATH}/dyn/admin/do_add_banner" autocomplete="off">        
        <input type="file" name="banner_image" accept="image/*"/>
        <input type="text" name="path"/>
        <button class="button blue" type="submit">Add Banner</button>
    </form>
</div>