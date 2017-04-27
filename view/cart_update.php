<?php
  session_start();
  include_once"../model/config.php";
  $config = new Config();
  $db = $config->get_Connection();

  //add product to session or create new one
  if(isset($_POST["type"]) && $_POST["type"]=='add' && $_POST["product_qty"] > 0 )
  {
    foreach($_POST as $key => $value){ //add all post vars to new_product array
      $new_product[$key] = filter_var($value, FILTER_SANITIZE_STRING);
      }
    //remove unecessary vars
    unset($new_product['type']);
    unset($new_product['return_url']); 
    
    //we need to get product name and price from database.
    
      $stmt = $db->prepare("SELECT producto, precio, imagen FROM productos WHERE idproducto = :idproducto LIMIT 1");
      $stmt->bindparam(':idproducto', $new_product['idproducto']);
      $stmt->execute();
    
    while($row=$stmt->fetch(PDO::FETCH_ASSOC))
    {   
      //fetch product name, price from db and add to new_product array
          $new_product["producto"] = $row['producto']; 
          $new_product["precio"] = $row['precio'];
          $new_product["imagen"] = $row['imagen'];
          
          if(isset($_SESSION["cart_products"]))
          {  //if session var already exist
          if(isset($_SESSION["cart_products"][$new_product['idproducto']])) //check item exist in products array
          {
              unset($_SESSION["cart_products"][$new_product['idproducto']]); //unset old array item
          }           
          }
          $_SESSION["cart_products"][$new_product['idproducto']] = $new_product; //update or create product session with new item  
      } 
  }
  //update or remove items 
  if(isset($_POST["product_qty"]) || isset($_POST["remove_code"]))
  {
    //update item quantity in product session
    if(isset($_POST["product_qty"]) && is_array($_POST["product_qty"]))
    {
      foreach($_POST["product_qty"] as $key => $value)
      {
        if(is_numeric($value))
        {
          $_SESSION["cart_products"][$key]["product_qty"] = $value;
        }
      }
    }
    //remove an item from product session
    if(isset($_POST["remove_code"]) && is_array($_POST["remove_code"]))
    {
      foreach($_POST["remove_code"] as $key)
      {
        unset($_SESSION["cart_products"][$key]);
      } 
    }
  }

  //back to return url
  $return_url = (isset($_POST["return_url"]))?urldecode($_POST["return_url"]):''; //return url
  header('Location:'.$return_url);

?>