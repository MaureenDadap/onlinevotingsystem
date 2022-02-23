<?php
function head($title)
{
  include("website_info.php");
  echo '
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>' . $title . ' - ' . $website_name . '</title>

<link rel="icon" href="images/logo.png  ">
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/styles.css">
</head>';
}


function navbar($page)
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
  if (isset($_SESSION['user_type'])) {
    if ($_SESSION['user_type'] === 'admin') { //if admin
      echo '
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
        <a href="admin-dashboard.php" class="nav-link ';
      if ($page === "dashboard") echo ' active';
      echo '"><span class="bi-speedometer"></span> Admin Dashboard</a>
        </li>  
          <li class="nav-item">
          <a href="utils/logout.php" class="btn btn-danger">Log out</a>
          </li>  
        </ul>';
    } else if ($_SESSION['user_type'] === 'student') { //if student
      echo '
	        <ul class="navbar-nav ms-auto">
	        <li class="nav-item"><a href="candidates-list.php" class="nav-link ';
      if ($page === "candidates") echo ' active';
      echo '"><span class="bi-list"></span> Candidates</a></li>
	        <li class="nav-item"><a href="voting.php" class="nav-link ';
      if ($page === "voting") echo ' active';
      echo '"><span class="bi-person-fill"></span> Voting Ballot 
	            </a></li>
              <li class="nav-item">
              <a href="utils/logout.php" class="btn btn-danger">Log out</a>
              </li>  
            </ul>';
    }
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

function footer()
{
  include("website_info.php");
  echo '<footer>
  <div class="container">
      <div class="row justify-content-center py-5 text-center">
          <h4 class="display-3">' . $website_name . '</h4>
          <p class="lead">We bring the elections closer to you.</p>
      </div>
  </div>
</footer>';
}
