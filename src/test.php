<pre><?php

require_once 'resources/_master-list.php';

$test = Responses::getAverageScoreByEventId(1) . " . " . Responses::getAverageScoreByQuestionId(2) . " . " . Responses::getAverageScoreByEventAndQuestionId(1, 2);

print_r($test);

?></pre>