<style type="text/css">
body{
    font-family: arial, sans-serif;
}
td {
    border-right: 1px dashed #999;
    padding:0;
    margin:0;
    padding:4px;
}
#end{
    border:0;
}
.header{
    font-weight:bold;
    background-color:#FBF5EF;

}
#item:hover {
    background-color: #FBF5EF;
    cursor: crosshair;
    cursor: crosshair;
}
</style>
<?php
  
  require("src/ini.php");
  require("src/functions.php");
  $string = file_get_contents("./src/items.json");
  $json_a = json_decode($string, true);

  echo '<table class="ItemsListForm" cellspacing="0" style="width:100%;">';
  echo '<tr>';
  echo '<td class="header">type</td>';
  echo '<td class="header">meta</td>';
  echo '<td class="header">name</td>';
  echo '<td class="header">text_type</td>';
  echo '</tr>';
                    foreach ($json_a as $items => $item) {
                       echo '<tr id="item">';
                       echo '<td style="width:5%">'.$item['type'].'</td>';
                       echo '<td style="width:5%">'.$item['meta'].'</td>';
                       echo '<td style="width:45%">'.$item['name'].'</td>';
                       echo '<td style="width:45%" id="end">'.$item['text_type'].'</td>';
                       echo '</tr>';

                    }
                    echo '</table>';

?>
