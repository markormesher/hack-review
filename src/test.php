<pre><?php

require_once 'resources/_master-list.php';

$test = Events::getByOrganiserId(1);

print_r($test);

?></pre>