<?php

//get the q parameter from URL
$q      =$_GET["q"];
$hint   ="";
if (strlen($q)>0) {
  require("configs/connection.php");
  $query = mysqli_query($connection,"SELECT * FROM products WHERE  product_name LIKE '%$q%'  LIMIT 5") or die(mysqli_error($connection));

  ?> <ul class="list-group list-group-media"> <?php
  while($data = mysqli_fetch_assoc($query))
  {
      $hint ++;
      $productId = $data["product_id"];
      ?>
        <li class="list-group-item list-group-item-action" onclick="javascript:location.href='editProduct?Id=<?php print($productId); ?>'">
        <div class="media">
            <div class="mr-3">
                <img alt="avatar" src="../<?php print($data["product_image"]); ?>" class="img-fluid rounded-circle">
            </div>
            <div class="media-body">
                <h6 class="tx-inverse"><?php print($data["product_name"]); ?></h6>
                <p class="mg-b-0 text-primary"> RWF <?php print($data["product_price"]); ?></p>
            </div>
        </div>
        </li>
  <?php
  } ?> </ul><?php
}


if ($hint=="") {
    ?> 
    <ul class="list-group list-group-media">
    <li class="list-group-item list-group-item-action">
        <div class="media">
            
            <div class="media-body">
                <p class="mg-b-0"><span class='text-primary'>No Client Found</span></p>   
            </div>
        </div>
    </li>
    </ul> 
    <?php
}

?>