<?php
$project2=array("558462","558464","558469","558471","558472","558474","558476","558477","558479","558482","558483","561169");
require 'Client.php';

$allpositions_client = new allpositions\api\Client('key');

echo '<table class="table table-bordered">';
echo '<tr><th>Запрос</th>
<th>Частота</th>
<th>Поисковая система</th>
<th>Текущая позиция</th>
<th>Предыдущая позиция</th>
<th>Изменение позиции</th>
<th>Найденный URL</th></tr>';

$pr=0;

for($pr=0; $pr < count($project2); $pr++)
{ 

$report2 = $allpositions_client->getReport($project2[$pr], "2017-09-01", "2017-08-01");

$count2= $report2[count];
$sengines2 = $report2[sengines];
$queries2 =$report2[queries];
$positions2 = $report2[positions];


for ($i=0; $i<$count2; $i++)
echo '<tr><td rowspan="2">'.($queries2[$i][query]).'</td><td rowspan="2">'.($queries2[$i][wordstat]).'</td><td>'.$sengines2

[0][name_region].'</td><td>'.$positions2[$sengines2[0][id_se].'_'.$queries[$i][id_query]][position].'</td><td>'.$positions2

[$sengines2[0][id_se].'_'.$queries2[$i][id_query]][prev_position]
.'</td><td style="color:green; font-weight:bold;">'.$positions2[$sengines2[0][id_se].'_'.$queries2[$i][id_query]][change_position]
.'</td><td>'.$positions2[$sengines2[0][id_se].'_'.$queries2[$i][id_query]][url].'</td></tr>'
.'<tr><td>'.$sengines2[1][name_region].'</td><td>'.$positions2[$sengines2[1][id_se].'_'.$queries2[$i][id_query]]

[position].'</td><td>'.$positions2[$sengines2[0][id_se].'_'.$queries2[$i][id_query]][prev_position]
.'</td><td style="color:green; font-weight:bold;">'.$positions2[$sengines2[1][id_se].'_'.$queries2[$i][id_query]][change_position]
.'</td><td>'.$positions2[$sengines2[1][id_se].'_'.$queries2[$i][id_query]][url].'</td></tr>';

}

echo '</table>';



$group = $allpositions_client->getReportDates(558476);

echo '<pre>';
var_dump($group);
echo count($group);
echo '<table border="1">';
for ($i=0; $i< count($group); $i++);

echo '<tr><td>'.($group[$i][group]).'</td><td>'.($group[$i][id_group]).'</td></tr>';

echo '</table>';



?>