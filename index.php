<!--
	David, Dynamic Shop: Web Viewer
	Copyright (C) 2014  Xevo Trends

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
-->
<html>
	<header>
		<?php
			//error_reporting(0);
			require("./src/ini.php");
			require("./src/functions.php");
			if (!conn()){
				die("<span style='font-family:arial, sans-serif;font-size:12px;'>An unexpected database error occurred. Please try again later.</span>");
			}
		?>

		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<meta name="Author" content="ti07shadow" />
		<meta name="Description" content="Dynamic Shop Web Viewer" />
		<meta name="Keywords" content="TimGaming, TG, Dynamic Shop" />
		<meta name="Robots" content="All" />
		<script type='text/javascript' src='http://code.jquery.com/jquery-1.8.3.js'></script>
		<script type='text/javascript'>
			$(document).ready(function(){
				$("#search").removeAttr('disabled'); 
			});

			function capitalizeFirstLetter(string) {
			    return string.charAt(0).toUpperCase() + string.slice(1);
			}

			function isNumber(n) {
			  return !isNaN(parseFloat(n)) && isFinite(n);
			}


			//<![CDATA[ 
			$(window).load(function(){
				$("#search").on("keyup", function() {
					var key = capitalizeFirstLetter(this.value);
					if (!isNumber(key)){
						$(".tosearch").each(function() {
						var $this = $(this);
						$this.toggle($(this).text().indexOf(key) >= 0);
						});
					}
					
				});
			});//]]>  
		</script>

	</header>
	<body>
		
		<div>
			<script>
				if (window.self === window.top) {
					document.write('<div class="logo"><img src="./src/img/banner.png" alt="logo" /></div>');
					document.write('<link rel="stylesheet" href="./src/style.css" />');
				} else {
					document.write('<link rel="stylesheet" href="./src/styleframe.css" />');
				}
			</script>
			<div class="content">
				<?php
					$string = file_get_contents("./src/items.json");
					$json_a = json_decode($string, true);

					echo "<table style='text-align:left;width:100%;font-size:12px;margin-bottom:8px;padding:8px;background-color:#0C0C12;border:1px dashed #333;'>
							<tr>
								<td style='width:50px;'><img src='./src/img/buy.png' alt='Buy At' /></td>
								<td><span style='color:#CCCCCC;'>The current buying value in <b>/shop</b></span></td>
							</tr>
							<tr>
								<td style='width:50px;'><img src='./src/img/sell.png' alt='Sell At' /></td>
								<td><span style='color:#CCCCCC;'>The current selling value in <b>/shop</b></span></td>
							</tr>
							<tr>
								<td style='width:50px;'><img src='./src/img/stock.png' alt='Stock' /></td>
								<td><span style='color:#CCCCCC;'>How many the <b>/shop</b> has in stock. (More stock lower price)</span></td>
							</tr>
							<tr>
								<td style='width:50px;'><img src='./src/img/stocklvl.png' alt='Stock Level' /></td>
								<td><span style='color:#CCCCCC;'>Percent price difference from original value. (Hover mouse over % to see base value)</span></td>
							</tr>
							<tr>
								<td colspan='2'><hr /></td>
							</tr>
							<tr>
								<td><img src='./src/img/nonbuy.png' alt='NONBUY' /></td>
								<td><span style='color:#CCCCCC;'>Doesn't list unbuyable items</span></td>
							</tr>
							<tr>
								<td><img src='./src/img/nonsell.png' alt='NONSELL' /></td>
								<td><span style='color:#CCCCCC;'>Doesn't list unsellable items</span></td>
							</tr>
							<tr>
								<td><img src='./src/img/all.png' alt='ALL' /></td>
								<td><span style='color:#CCCCCC;'>List all items possible that exists in the shop</span></td>
							</tr>
							<tr>
								<td><img src='./src/img/op_all.png' alt='OP_ALL' /></td>
								<td><span style='color:#CCCCCC;'>Shows every item in Minecraft, even if it's not in the shop</span></td>
							</tr>
						</table>";


					echo "<table style='text-align:left;width:100%;font-size:12px;margin-bottom:8px;padding:8px;background-color:#0C0C12;border:1px dashed #333;'>
							<tr>
								<td colspan='2' style='width:50px;text-align:center;font-weight:bold;color:#FF3300;'>Dynamic Market Web Viewer updates every 10 Minutes</span></td>
							</tr>
					</table>";
					echo '<hr style="margin-bottom:14px;" />';

					echo "<div style='verticle-align:middle;'><strong>Search: </strong><input id='search' class='searchBox' disabled='disabled' ></input> 
					<strong style='padding-right:4px;margin-left:20px;'>List Types: </strong>";

					if (isset($_GET['define']) && $_GET['define'] == "NONBUY" || !isset($_GET['define'])){
						echo "<a class='button2'/>NONBUY</a>";
					}else{
						echo "<a href='./index.php?define=NONBUY' class='button'/>NONBUY</a>";
					}

					if (isset($_GET['define']) && $_GET['define'] == "NONSELL"){
						echo "<a class='button2'/>NONSELL</a>";
					}else{
						echo "<a href='./index.php?define=NONSELL' class='button'/>NONSELL</a>";
					}

					if (isset($_GET['define']) && $_GET['define'] == "ALL"){
						echo "<a class='button2'/>ALL</a>";
					}else{
						echo "<a href='./index.php?define=ALL' class='button'/>ALL</a>";
					}

					if (isset($_GET['define']) && $_GET['define'] == "OP_ALL"){
						echo "<a class='button2'/>OP_ALL</a>";
					}else{
						echo "<a href='./index.php?define=OP_ALL' class='button'/>OP_ALL</a>";
					}

					echo "</div>";
					echo '<hr />';
					echo '<table class="ItemsListForm" cellspacing="0" style="width:100%;">';
					foreach ($json_a as $items => $item) {
						echo '<tr class="tosearch">';
						if (itemAllowed($item['name'])){
							if ($item['meta'] == 0 ){
								echo '<td class="items" style="width:35px;text-align:right;font-size:12px;font-weight:bold;padding-right:4px;">'.$item['type'].'</td>';							
							}else{
								echo '<td class="items" style="width:35px;text-align:right;font-size:12px;font-weight:bold;padding-right:4px;">'.$item['type'].':'.$item['meta'].'</td>';	
							}
							if (shopAvailability($item['name'])){
								echo '<td class="items" style="width:40px;"><img src="./src/items/'.$item["type"].'-'.$item['meta'].'.png" style="width:32px; height:32px;" alt="placeholder" /></td>';
								echo '<td class="items"><span style="color:#E6E6E6;font-size:14px;font-weight:bold;">'.$item['name'].'</span><br /><span style="font-size:12px;">(Minecraft:'.$item['text_type'].')</span></td>';
								echo '<td class="items" style="width:50px;"><img src="./src/img/buy.png" alt="Buy At" /></td>';
								echo '<td class="items" style="padding-left:4px;text-align:left;">'.purchasable($item['name']).'</td>';
								echo '<td class="items" style="width:50px;"><img src="./src/img/sell.png" alt="Sell At" /></td>';
								echo '<td class="items" style="padding-left:4px;text-align:left;">'.sellable($item['name']).'</td>';
								echo '<td class="items" style="width:50px;"><img src="./src/img/stock.png" alt="Stock" /></td>';
								echo '<td class="items" style="padding-left:4px;text-align:left;">'.stock($item['name']).'</td>';
								echo '<td class="items" style="width:50px;"><img src="./src/img/stocklvl.png" alt="Stock Level" /></td>';
								echo '<td class="items" style="padding-left:4px;text-align:left;">'.stocklvl($item['name']).'</td>';
							}else{
								echo '<td class="items" style="width:40px;"><img src="./src/items/'.$item["type"].'-'.$item['meta'].'.png" style="width:32px; height:32px;" alt="placeholder" /></td>';
								echo '<td class="items"><span style="color:#E6E6E6;font-size:14px;font-weight:bold;">'.$item['name'].'</span><br /><span style="font-size:12px;">(Minecraft:'.$item['text_type'].')</span></td>';

								echo '<td colspan="8" class="items"><span style="color:#848484;font-size:12px;font-weight:bold;">This item is not available for buy or sell in /shop</span></td>';
							}

						}
						echo '</tr>';
					}
					echo '</table>';
				?>
			</div>
		</div>



	</body>
	<footer>
		<div class="copyright">
			Dynamic Shop Web Viewer Designed and Coded by David, Copyright &copy;2014<br />
			"Minecraft" content and materials are trademarks and copyrights of Mojang and its licensors.
		</div>
	</footer>
</html>
