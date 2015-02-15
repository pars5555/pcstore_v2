<?php
exec('sh /var/www/dev_pcstore_update.sh  2>&1', $output);
var_dump($output);

?>