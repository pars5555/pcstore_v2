<?php
exec('sh /var/www/dev_pcstore_update.sh  2>&1', $output);
if (is_array($output))
{
    foreach($output as $out)
    echo $out ."\r\n";
}else
{
var_dump($output);
}


?>