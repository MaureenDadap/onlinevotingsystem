<?php

function head($title)
{
  require_once './config/website_info.php';
  include 'head.php';
}


function navbar($page)
{
  require_once './config/website_info.php';
  require_once 'navbar.php';
}

function sidebar($page)
{
  require_once './config/website_info.php';
  require_once('sidebar.php');
}
