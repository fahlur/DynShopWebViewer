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
  require_once("src/ini.php");
  require_once("src/functions.php");

  
  $sql  = mysqli_query(conn(), "SELECT * FROM items ORDER BY idItems ASC");
  echo "<table style='border:0;'>";
  echo "<tr>
            <td class='header'>idItems</td>
            <td class='header'>name</td>
            <td class='header'>alias</td>
            <td class='header'>purchasable</td>
            <td class='header'>sellable</td>
            <td class='header'>basePrice</td>
            <td class='header'>priceCeiling</td>
            <td class='header'>priceFloor</td>
            <td class='header'>stockCeiling</td>
            <td class='header'>stockFloor</td>
            <td class='header'>stock</td>
            <td class='header'>volatility</td>
            <td class='header'>salesTax</td>
            <td class='header'>previousPrice</td>
            <td class='header'>item</td>
        </tr>";
  while ($i = mysqli_fetch_assoc($sql)){
    echo "<tr id='item'>";
    echo "<td>".$i['idItems']."</td>";
    echo "<td>".$i['name']."</td>";
    echo "<td>".$i['alias']."</td>";
    echo "<td>".$i['purchasable']."</td>";
    echo "<td>".$i['sellable']."</td>";
    echo "<td>".$i['basePrice']."</td>";
    echo "<td>".$i['priceCeiling']."</td>";
    echo "<td>".$i['priceFloor']."</td>";
    echo "<td>".$i['stockCeiling']."</td>";
    echo "<td>".$i['stockFloor']."</td>";
    echo "<td>".$i['stock']."</td>";
    echo "<td>".$i['volatility']."</td>";
    echo "<td>".$i['salesTax']."</td>";
    echo "<td>".$i['previousPrice']."</td>";
    echo "<td id='end'>".$i['item']."</td>";

    echo "</tr>";
  }
  echo "</table>";

?>
