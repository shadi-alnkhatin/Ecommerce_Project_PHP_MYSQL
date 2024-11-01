

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="./css/wishlist.css">
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">

</head>
<body>
<?php include('./navbar.php');?>
	<div class="cart-wrap">
		<div class="container">
	        <div class="row">
			    <div class="col-md-12">
			        <div class="main-heading mb-10">My wishlist</div>
			        <div class="table-wishlist">
				        <table cellpadding="0" cellspacing="0" border="0" width="100%">
				        	<thead>
					        	<tr>
					        		<th width="45%">Product Name</th>
					        		<th width="15%">Unit Price</th>
					        		<th width="15%">Stock Status</th>
					        		<th width="15%"></th>
					        		<th width="10%"></th>
					        	</tr>
					        </thead>
					        <tbody>
								<?php 
								include('./classes/wishlist.php');
								$database2=new Database();
								$db2=$database2->connect();
								
								$user_id = $_SESSION['user_id'];
								
								$whishlist = new Wishlist($db2, $user_id);
								$whishlist_items = $whishlist->get_wishlist();
								
						
									foreach($whishlist_items as $item){
										echo '<tr>
					        		<td width="45%">
					        			<div class="display-flex align-center">
		                                    <div class="img-product">
		                                        <img src="https://www.91-img.com/pictures/laptops/asus/asus-x552cl-sx019d-core-i3-3rd-gen-4-gb-500-gb-dos-1-gb-61721-large-1.jpg" alt="" class="mCS_img_loaded">
		                                    </div>
		                                    <div class="name-product">
		                                        <a href="#">'.$item['name'].'</a>
                                            </div>
		                                    </div>
	                                    </div>
	                                </td>
					        		<td width="15%" class="price">$'.$item['price'].'</td>
					        		<td width="15%"><span class="in-stock-box">In Stock</span></td>
					        		<td width="15%"><button class="round-black-btn small-btn">Add to Cart</button></td>
					        		<td width="10%" class="text-center"><a href="#" class="trash-icon"><i class="far fa-trash-alt"></i></a></td>
					        	</tr>
					        	';
									}
									
									?> 
									
				        	</tbody>
				        </table>
				    </div>
			    </div>
			</div>
		</div>
	</div>
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<script src="js/mixitup.min.js"></script>
	<script src="js/jquery.slicknav.js"></script>

	<script src="js/main.js"></script>
</body>
</html>