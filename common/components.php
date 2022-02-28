<?php
function head($title)
{
  include("website_info.php");
  include 'head.php';
}


function navbar($page)
{
  require_once 'navbar.php';
}

function sidebar($page)
{
  require_once('sidebar.php');
}


function resultsCandidate($position, $name, $image, $section)
{
  include 'results-candidate.php';
}
