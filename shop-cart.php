
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
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <link rel="stylesheet" href="css/style.css" type="text/css">

    <style>
        .truncate-multi-line {
    display: -webkit-box;           /* Necessary for multi-line truncation */
    -webkit-box-orient: vertical;   /* Sets the orientation to vertical */
    overflow: hidden;               /* Hides overflowed text */
    -webkit-line-clamp: 3;          /* Limits text to 3 lines */
}

@media (max-width: 768px) {
    .table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
}

.table-responsive table {
    width: 100%; /* Ensures the table takes full width */
    min-width: 600px; /* Adjust based on the minimum width needed for your table */
}

}
    </style>
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Begin -->
    <?php include('./navbar.php');?>
    <!-- Header Section End -->

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./index.html"><i class="fa fa-home"></i> Home</a>
                        <span>Shopping cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Cart Section Begin -->
    <section class="shop-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shop__cart__table table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Size</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Check if the user is logged in
                            if (!isLoggedIn()) {
                                echo "<tr><td colspan='6' class='text-center'>Please log in to view your cart.</td></tr>";
                            } else {
                                // Create database connection
                                $database = new Database();
                                $db = $database->connect();

                                if (!$db) {
                                    echo "<tr><td colspan='6' class='text-center'>Database connection failed.</td></tr>";
                                } else {
                                    // Create Cart instance to fetch items
                                    $cart = new Cart($db, $_SESSION['user_id']);
                                    $cart_items = $cart->getCartItems();
                                    $total_price = $cart->calculateTotal();

                                    // Check if the cart contains any items
                                    if (count($cart_items) > 0) {
                                        $total = 0;
                                        foreach ($cart_items as $item) {
                                            $productTotal = $item['product_price'] * $item['quantity'];
                                            $total += $productTotal;
                            ?>
                                            <tr data-product-id="<?php echo $item['id']; ?>">
                                                <td class="cart__product__item mr-3">
                                                    <img src="images/<?php echo $item['cover'] ?>" alt="" width="60px">
                                                    <div class="cart__product__item__title">
                                                        <h6 class="truncate-multi-line "><?php echo $item['name']; ?></h6>
                                                    </div>
                                                </td>
                                                <td>
                                                    <select class="item_size mr-5 select-form">
                                                        <!-- Add size options dynamically as needed -->
                                                        <option value="<?php echo $item['size']; ?>"><?php echo $item['size']; ?></option>
                                                    </select>
                                                </td>
                                                <td class="cart__price">$<?php echo $item['product_price']; ?></td>
                                                <td class="cart__quantity">
                                                    <div class="pro-qty">
                                                        <input type="number" class="quantity-input" value="<?php echo $item['quantity']; ?>" min="1">
                                                    </div>


                                                </td>
                                                <td class="cart__total">$<span class="product-total"><?php echo $productTotal; ?></span></td>
                                                <td class="cart__close"><span class="icon_close"></span></td>
                                            </tr>
                            <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='6' class='text-center'>Your cart is empty!</td></tr>";
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Additional cart footer sections -->
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="cart__btn">
                    <a href="./index.php">Continue Shopping</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="discount__content" <?php if(!isLoggedIn()){echo 'style="display:none"';} ?>>
                    <h6>Discount codes</h6>
                    <form >
                    <input id="couponCode" type="text" placeholder="Enter your coupon code" >
                    <button id="applyCoupon" type="button" class="site-btn" <?php if($total_price<=0){echo 'disabled';} ?>>Apply</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-4 offset-lg-2" <?php if(!isLoggedIn()){echo 'style="display:none"';}?>>
                <div class="cart__total__procced">
                    <h6>Cart total</h6>
                    <ul>
                        <li>Total <span id="cart-total">$<?php echo $total_price ? $total_price : 0; ?></span></li>
                    </ul>
                    <?php if(!$total_price<=0){
                      echo'  <a href="./checkout.php" class="primary-btn" >Proceed to checkout</a>';
                    }?>
                    
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Shop Cart Section End -->

  

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
    <script src="js/notify.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/cart.js"></script> 
    <script>
        document.getElementById('applyCoupon').addEventListener('click', function() {
        const couponCode = document.getElementById('couponCode').value;
        if (couponCode.trim() === '') {
            $.notify("Please enter a coupon code.", "error");
            return;
        }

    fetch('helper_functions/apply_coupon.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'coupon_code=' + encodeURIComponent(couponCode)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('cart-total').textContent = `$${data.discountedTotal}`;
            $.notify("Coupon applied!", "success");
        } else {
            $.notify("Invalid or expired coupon.", "error");
        }
    });
});
    </script>
</body>

</html>