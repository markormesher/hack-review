<pre><?php

require_once 'resources/_master-list.php';

$test = Questions::getByEventId(1);

print_r($test);

?></pre>