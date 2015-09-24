<?php
// Provides database connection stuff
function conn()
  {
    return mysqli_connect(HOSTADDR, USERNAME, PASSWORD, DATABASE);
  }
// Clean out unwanted inputs
function clean($string)
  {
    $clean = trim($string);
    $clean = htmlentities($clean);
    return $clean;
  }
// Checks if the item is listable
function itemAllowed($item)
  {
    $define = LIST_ITEMS; //default to config
    //check if user used a list items option. *Usuaully used for listing shiz.
    if (isset($_GET['define']))
      {
        $d = clean($_GET['define']);
        if ($d == "OP_ALL" || $d == "ALL" || $d == "NONBUY" || $d == "NONSELL")
          {
            $define = $d;
          } //$d == "OP_ALL" || $d == "ALL" || $d == "NONBUY" || $d == "NONSELL"
      } //isset($_GET['define'])
    if ($define != "OP_ALL")
      {
        $item = str_replace(" ", "", $item);
        $sql  = mysqli_query(conn(), "SELECT * FROM items WHERE name = '" . $item . "' OR alias = '" . $item . "'");
        if ($sql)
          {
            if (mysqli_num_rows($sql) != 0)
              {
                $fetch = mysqli_fetch_assoc($sql);
                if ($define == "ALL")
                  {
                    return true;
                  } //$define == "ALL"
                if ($define == "NONBUY")
                  {
                    if ((int) $fetch['purchasable'] == 0)
                      {
                        return false;
                      } //(int) $fetch['purchasable'] == 0
                    else
                      {
                        return true;
                      }
                  } //$define == "NONBUY"
                if ($define == "NONSELL")
                  {
                    if ((int) $fetch['sellable'] == 0)
                      {
                        return false;
                      } //(int) $fetch['sellable'] == 0
                    else
                      {
                        return true;
                      }
                  } //$define == "NONSELL"
              } //mysqli_num_rows($sql) != 0
            else
              {
                return false;
              }
          } //$sql
      } //$define != "OP_ALL"
    else
      {
        return true;
      }
  }
// Checks if the item is purchasable
function purchasable($item)
  {
    $item = str_replace(" ", "", $item);
    $sql  = mysqli_query(conn(), "SELECT * FROM items WHERE name = '" . $item . "' OR alias = '" . $item . "'");
    if (@mysqli_num_rows($sql) != 0)
      {
        $getItem = mysqli_fetch_assoc($sql);
        if ((int) $getItem['purchasable'] == 1)
          {
            return "<span style='color:#F2F2F2;font-size:12px;'>$" . number_format((float) $getItem['previousPrice'], 2, '.', '') . "</span>";
          } //(int) $getItem['purchasable'] == 1
        else
          {
            return "<span style='color:#848484;font-size:12px;'>Not Purchasable</span>";
          }
      } //@mysqli_num_rows($sql) != 0
    else
      {
        return "<span style='color:#848484;font-size:12px;'>Not Purchasable</span>";
      }
  }
// Checks if the item is sellable
function sellable($item)
  {
    $item = str_replace(" ", "", $item);
    $sql  = mysqli_query(conn(), "SELECT * FROM items WHERE name = '" . $item . "' OR alias = '" . $item . "'");
    if (@mysqli_num_rows($sql) != 0)
      {
        $getItem = mysqli_fetch_assoc($sql);
        if ((int) $getItem['sellable'] == 1)
          {
            if ($getItem['salesTax'] == 0)
              {
                $sellPrice = $getItem['previousPrice'];
              } //$getItem['salesTax'] == 0
            else
              {
                $sellPrice = $getItem['previousPrice'] - ($getItem['previousPrice'] * .5);
              }
            return "<span style='color:#F2F2F2;font-size:12px;'>$" . number_format((float) $sellPrice, 2, '.', '') . "</span>";
          } //(int) $getItem['sellable'] == 1
        else
          {
            return "<span style='color:#848484;font-size:12px;'>Not Sellable</span>";
          }
      } //@mysqli_num_rows($sql) != 0
    else
      {
        return "<span style='color:#848484;font-size:12px;'>Not Sellable</span>";
      }
  }
// checks in stock
function stock($item)
  {
    $item = str_replace(" ", "", $item);
    $sql  = mysqli_query(conn(), "SELECT * FROM items WHERE name = '" . $item . "' OR alias = '" . $item . "'");
    if (@mysqli_num_rows($sql) != 0)
      {
        $getItem = mysqli_fetch_assoc($sql);
        if ($getItem['stock'] >= 1)
          {
            return "<span style='color:#00FF00;font-size:12px;'>+" . $getItem['stock'] . "</span>";
          } //$getItem['stock'] >= 1
        else
          {
            return "<span style='color:#F78181;font-size:12px;'>" . $getItem['stock'] . "</span>";
          }
      } //@mysqli_num_rows($sql) != 0
    else
      {
        return "<span style='color:#848484;font-size:12px;'>No In-Stock</span>";
      }
  }
// Gets full stock level
function stocklvl($item)
  {
    $item = str_replace(" ", "", $item);
    $sql  = mysqli_query(conn(), "SELECT * FROM items WHERE name = '" . $item . "' OR alias = '" . $item . "'");
    if (@mysqli_num_rows($sql) != 0)
      {
        $getItem = mysqli_fetch_assoc($sql);
        $value   = ($getItem['previousPrice'] / $getItem['basePrice']) * 100;
        return "<span style='color:#ccc;font-size:12px;' title='Base Price: " . $getItem['basePrice'] . "'>" . number_format((float) $value, 2, '.', '') . "%</span>";
      } //@mysqli_num_rows($sql) != 0
    else
      {
        return "<span style='color:#848484;font-size:12px;'>No In-Stock</span>";
      }
  }
// Checks if item is available in shop for buy or sell
function shopAvailability($item)
  {
    $item = str_replace(" ", "", $item);
    $sql  = mysqli_query(conn(), "SELECT * FROM items WHERE name = '" . $item . "' OR alias = '" . $item . "'");
    if (@mysqli_num_rows($sql) != 0)
      {
        $getItem = mysqli_fetch_assoc($sql);
        if ($getItem['sellable'] == 0 && $getItem['purchasable'] == 0)
          {
            return false;
          } //$getItem['sellable'] == 0 && $getItem['purchasable'] == 0
        else
          {
            return true;
          }
      } //@mysqli_num_rows($sql) != 0
    else
      {
        return false;
      }
  }

?>
