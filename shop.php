<?php
include('./classes/products.php');

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
        /* Container styling */
        .SelectContainer {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        /* Heading styling */
        h4 {
            font-size: 1.25rem;
            color: #333;
            margin: 0;
        }

        /* Select dropdown styling */
        .form-select {
            flex-grow: 1;
            padding: 0.75rem;
            font-size: 1rem;
            color: #555;
            border: 1px solid #ddd;
            border-radius: 0.375rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        /* Hover and focus effect */
        .form-select:hover, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
            outline: none;
        }

        /* Image icon styling */
        .select-icon {
            width: 40px;
            height: 40px;
            object-fit: contain;
            display: inline-block;
            margin-right: 0.5rem;
            filter: grayscale(1); /* Optional: grayscale effect */
            transition: filter 0.3s ease;
        }

        .select-icon:hover {
            filter: grayscale(0); /* Removes grayscale on hover */
        }
        .brand-logo{
            display: flex;
            align-items: center;
            margin-bottom: 10px;
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
                        <span>Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Section Begin -->
    <section class="shop spad">
    <div class="container">
        <div class="row">
            <!-- Sidebar Section -->
            <div class="col-lg-3 col-md-3">
    <div class="shop__sidebar">
    <form id="searchForm" method="GET">
    <input class="form-control my-5" type="text" id="searchInput" name="query" placeholder="Search products...">
   
    </form>
    
        <div class="sidebar__categories">
            <div class="section-title">
                <h4>Categories</h4>
            </div>
             <!-- League Select -->
             <div class="my-3 SelectContainer">
    <!-- <img src="path/to/league-icon.png" alt="League Icon" class="select-icon"> -->
    <h4>League</h4>
    <select id="leagueSelect" class="form-select" aria-label="Select League">
        <option selected value="" disabled>Select a league</option>
        <!-- Options will be added dynamically -->
    </select>
</div>

<div class="my-3 SelectContainer">
    <!-- <img src="path/to/team-icon.png" alt="Team Icon" class="select-icon"> -->
    <h4>Teams</h4>
    <select id="teamSelect" class="form-select" aria-label="Select Team">
        <option selected value="">Select a team</option>
        <!-- Options will be populated based on the selected league -->
    </select>
</div>

        </div>

        <!-- Price Filter -->
        <div class="sidebar__filter">
            <div class="section-title">
                <h4>Shop by price</h4>
            </div>
            <div class="filter-range-wrap">
             <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
             data-min="1" data-max="200"></div>
             <div class="range-slider">
                 <div class="price-input">
                     <p>Price:</p>
                     <input type="text" id="minamount">
                     <input type="text" id="maxamount">
                 </div>
             </div>
            </div>
            <a id="apply-filters" onclick="filter()">Filter</a>
        </div>
        <button class="btn btn-danger" onclick="ResetPage()">Reset Filter</button>
    </div>
</div>


            <!-- Products Section -->
            <div class="col-lg-9 col-md-9">
            <div class="brand-logo" >
            <h3>All teams</h3><br>
            </div>
                <div class="row" id="productList">


                
                
                    <?php
                    
                    $product_obj = new Product($db);
                    $productList = $product_obj->getProducts();

                    foreach ($productList as $product) {
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
                <?php
                    $totalProducts = $product_obj->getTotalProducts();
                    $totalPages = ceil($totalProducts / 9);
                    
                    ?>
                <!-- Pagination Section -->
                <div class="col-lg-12 text-center">
                <div class="pagination__option">
                        <?php
                        for ($page = 1; $page <= $totalPages; $page++) {
                            echo '<a href="#searchForm" class="' . ($page == 1 ? 'active' : '') . '" onclick="filter(' . $page . ')">' . $page . '</a>';

                        };?>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
    <script src="js/notify.js"></script>
    <script src="js/shop.js"></script>
    <script src="js/add_to_cart.js"></script>
    <script>
    var isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;

    </script>

</body>

</html>