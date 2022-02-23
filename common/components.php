<?php
function navbar()
{
    include("website_info.php");

    echo '<nav class="navbar navbar-expand-lg" role="navigation">
	    <div class="container">
	      <a href="index.php" class="navbar-brand d-flex align-items-center">
	        <img src="images/logo.png" alt="logo" class="d-inline-block align-top">
	        <span>';
    echo $website_name;
    echo '</span>
	      </a>
	      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#myNavbar" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="navbar-toggler-icon"><i class="bi-list"></i></span>
	      </button>
	
	      <div class="collapse navbar-collapse" id="myNavbar">';
    if (isset($_SESSION['login_user1'])) { //if admin
        echo '
	            <ul class="navbar-nav ms-auto">
	            <li class="nav-item"><a class="nav-link admin-name"><span class="bi-person-fill"></span> Welcome ';
        echo $_SESSION['login_user1'];
        echo '
	            </a></li>
	            <li class="nav-item"><a href="admin-dashboard.php" class="nav-link';
        if ($page === "control") echo ' active';
        echo '"><span class="fa fa-tools"></span> MANAGER CONTROL PANEL</a></li>
	            <li class="nav-item"><a href="utils/logout_m.php" class="nav-link"><span class="bi-box-arrow-left"></span> Log Out </a></li>
	          </ul>
	          ';
    } else if (isset($_SESSION['login_user2'])) { //if student
        echo '
	        <ul class="navbar-nav ms-auto">
	        <li class="nav-item"><a href="customer_profile.php" class="nav-link';
        if ($page === "profile") echo ' active';
        echo '"><span class="bi-person-fill"></span> Welcome ';
        echo $_SESSION['login_user2'];
        echo '</a></li>
	        <li class="nav-item"><a href="foodlist.php?id=' . setDayIDURL() . '" class="nav-link';
        if ($page === "foodlist") echo ' active';
        echo '"><span class="fa fa-cutlery"></span> Food Zone </a></li>
	        <li class="nav-item"><a href="cart.php" class="nav-link';
        if ($page === "cart") echo ' active';
        echo '"><span class="bi-cart-fill"></span> Cart (';
        echo getCartCount();
        echo ')
	            </a></li>
	        <li class="nav-item"><a href="utils/logout_u.php" class="nav-link"><span class="bi-box-arrow-left"></span> Log Out </a></li>
	    </ul>';
    } else {
        echo '
	    <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Sign Up
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="admin-signup.php">Admin Sign Up</a></li>
          <li><a class="dropdown-item" href="student-signup.php">Student Sign Up</a></li>
        </ul>
         </li>
            <li class="nav-item">
            <a href="login.php" class="btn btn-primary">Login</a>
            </li>  
        </ul>';
    }
    echo '</div>
	    </div>
	    </nav>';
}
