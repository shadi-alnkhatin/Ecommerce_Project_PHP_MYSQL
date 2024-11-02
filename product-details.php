<?php 
include ('./classes/products.php');
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ashion Template">
    <meta name="keywords" content="Ashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ashion | Template</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap"
    rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <style>
         .size__btn{
	        display: flex;
	        flex-direction: row;
	        gap: 10px;
        }

    </style>
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

   <?php include('./navbar.php')?>
    <!-- Header Section End -->

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./index.html"><i class="fa fa-home"></i> Home</a>
                        <a href="#">Women’s </a>
                        <span>Essential structured blazer</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
    <?php
if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $product = new Product($db);
    $productDetails = $product->getProductsDetails($productId);
    $ProductImages= $product->getProductImages($productId);
}
?>
    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
            <?php if ($productDetails): ?>
                <div class="col-lg-6">
                    <div class="product__details__pic">
                    <div class="product__details__pic__left product__thumb nice-scroll">
                            <a class="pt active" href="#product-0">
                                <img src="images<?php echo htmlspecialchars($productDetails['cover']); ?>" alt="">
                            </a>
                            <?php foreach ($ProductImages as $key => $image): ?>
                                <a class="pt" href="#product-<?php echo $key + 1; ?>">
                                    <img src="images/<?php echo htmlspecialchars($image['image_url']); ?>" alt="">
                                </a>
                            <?php endforeach; ?>
                        </div>
                        <div class="product__details__slider__content">
                            <div class="product__details__pic__slider owl-carousel">
                                <img data-hash="product-0" class="product__big__img" src="images/<?php echo htmlspecialchars($productDetails['cover']); ?>" alt="">

                                <?php foreach ($ProductImages as $key => $image): ?>
                                    <img data-hash="product-<?php echo $key + 1; ?>" class="product__big__img" src="images/<?php echo htmlspecialchars($image['image_url']); ?>" alt="">
                                <?php endforeach; ?>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product__details__text">
                    <h3><?php echo htmlspecialchars($productDetails['name']); ?> </h3>

                       
                        
                        <!-- Price Section -->
                        <div class="product__details__price">$ <?php echo htmlspecialchars($productDetails['price']); ?></div>
                        
                        <!-- Description -->
                        <p><?php echo htmlspecialchars($productDetails['description']); ?></p>
                        
                        <!-- Quantity & Add to Cart Button -->
                        <div class="product__details__button">
                            <div class="quantity">
                                <span>Quantity:</span>
                                <div class="pro-qty">
                                    <input id="item_quantity" type="number" value="1" min="1">
                                </div>
                            </div>
                            <?php
                            if($productDetails['quantity']>1){
                                echo '<a class="addToCart cart-btn"  data-product-id="'.$productId.'" ><span class="icon_bag_alt"></span> Add to cart</a>';
                            }
                             ?>
                            <ul>
                                <li><a class="addToWishlist" data-product-id="<?php echo $productId ?>"><span class="icon_heart_alt"></span></a></li>
                                
                            </ul>
                        </div>
                        
                        <!-- Product Details Widget (Availability, Colors, Sizes) -->
                        <div class="product__details__widget">
                            <ul>
                                <li><span>Availability:</span> <?php echo $productDetails['quantity'] ? 'In Stock' : 'Out of Stock'; ?></li>
                                
                                <!-- Colors Section -->
                               
                                <!-- Sizes Section -->
                                <li><span>Available size:</span> 
                                    <div class="size__btn ">
                                        
                                    </div>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <p>Product details not found.</p>
            <?php endif; ?>
                <!-- REVIEWS SECTION -->
              
            </div>
            <!-- RELATED PRODUCTS Section -->
            <div class="row related" style="margin-top: 100px;">
                <div class="col-lg-12 text-center">
                    <div class="related__title">
                        <h5>RELATED PRODUCTS</h5>
                    </div>
                </div>
                <?php
                 $related_products = $product->getRelatedProducts($productId);
                 foreach ($related_products as $product) {
                    ?>
                    <div class="col-lg-4 col-md-6">
                        
                         <div class="product__item sale">
                         <div class="product__item__pic set-bg" data-setbg="images/<?php echo $product['cover']; ?>"> 
                         
                         <?php
                         if($product['quantity']<=1){
                             echo'<div class="label stockout stockblue">Out Of Stock</div>';
                         }
                        
                        ?>
                         <ul class="product__hover">
                             <li><a href="images/<?php echo $product['cover']; ?>" class="image-popup"><span class="arrow_expand"></span></a></li>
                             <li><a class="addToWishlist" data-product-id="<?php echo $product['id']; ?>"><span class="icon_heart_alt"></span></a></li>
                            <?php
                             if(!($product['quantity']<=1)){
                                echo' <li><a class="addToCart"   data-product-id="'.$product['id'].'"><span class="icon_bag_alt"></span></a></li>';
                             }
                            ?>
                         </ul>
                    </div>
                            <div class="product__item__text">
                                <h6><a href="./product-details.php?id=<?php echo $product['id'] ?>"><?php echo htmlspecialchars($product['name']); ?></a></h6>
                              
                                <div class="product__price">$<?php echo htmlspecialchars($product['price']); ?></div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                
               
               
              
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->


    <!-- Footer Section Begin -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-7">
                    <div class="footer__about">
                        <div class="footer__logo">
                            <a href="./index.html"><img src="img/logo.png" alt=""></a>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                        cilisis.</p>
                        <div class="footer__payment">
                            <a href="#"><img src="img/payment/payment-1.png" alt=""></a>
                            <a href="#"><img src="img/payment/payment-2.png" alt=""></a>
                            <a href="#"><img src="img/payment/payment-3.png" alt=""></a>
                            <a href="#"><img src="img/payment/payment-4.png" alt=""></a>
                            <a href="#"><img src="img/payment/payment-5.png" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-5">
                    <div class="footer__widget">
                        <h6>Quick links</h6>
                        <ul>
                            <li><a href="#">About</a></li>
                            <li><a href="#">Blogs</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">FAQ</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4">
                    <div class="footer__widget">
                        <h6>Account</h6>
                        <ul>
                            <li><a href="#">My Account</a></li>
                            <li><a href="#">Orders Tracking</a></li>
                            <li><a href="#">Checkout</a></li>
                            <li><a href="#">Wishlist</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8 col-sm-8">
                    <div class="footer__newslatter">
                        <h6>NEWSLETTER</h6>
                        <form action="#">
                            <input type="text" placeholder="Email">
                            <button type="submit" class="site-btn">Subscribe</button>
                        </form>
                        <div class="footer__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-youtube-play"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-pinterest"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    <div class="footer__copyright__text">
                        <p>Copyright &copy; <script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a></p>
                    </div>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

  
    <!-- Search End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.nicescroll.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/notify.js" ></script>
    <script src="js/add_to_cart.js"></script>
    <script>

        var isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
document.addEventListener('DOMContentLoaded', function () {
    const itemSizeSelects = document.querySelector('.size__btn');

    const productId = <?php echo json_encode($_GET['id']); ?>;
    console.log("Product ID:", productId);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', './helper_functions/get_item_size.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            console.log("Response Text:", xhr.responseText);
            
            try {
                const response = JSON.parse(xhr.responseText);
                
                if (response.success) {
                    // Populate each size select dropdown
                   
                    response.sizes.forEach((size, index) => {
                     const sizeBtn = `
                     <div class="form-check">
                         <input class="form-check-input" type="radio" name="size" id="size-${size}" value="${size}" ${index === 0 ? 'checked' : ''}>
                         <label class="form-check-label" for="size-${size}">${size}</label>
                     </div>
                     `;
                     itemSizeSelects.innerHTML += sizeBtn;
});
console.log("Sizes added to DOM:", document.querySelectorAll('input[name="size"]'));

                  
                } else {
                    console.error("Failed to retrieve sizes:", response.error);
                }
            } catch (e) {
                console.error("Invalid JSON response:", xhr.responseText);
            }
        }
    };

    xhr.send('product_id=' + encodeURIComponent(productId));
});
</script>

</body>

</html>