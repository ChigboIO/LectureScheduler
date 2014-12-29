<?php @session_start(); require_once("root.php"); require_once("dbopen.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Lecture Scheduler | </title>
<meta name="keywords" content="lecture schedule" />
<meta name="description" content="" />
<!--<link href="styles.css" rel="stylesheet" type="text/css" />-->
<link href="<?php echo $root; ?>style/styles.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $root; ?>style/ui-lightness/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" type="text/css" media="screen" />

</head>
<body>

<div id="main">
<!-- header begins -->
<div id="header">
    <div id="buttons">
      <div class="but"><a href="<?php echo $root ?>" class="razd_but"  title="">Students' View</a></div>
      <div class="but"><a href="<?php echo $root ?>lecturer/" class="razd_but"  title="">Lecturers' View</a></div>
      <?php if(isset($_SESSION['admin_login'])){ ?>
      <div class="but"><a href="<?php echo $root ?>admin/configure/" class="razd_but" title="">Configure</a></div>
      
      <div class="but"><a href="<?php echo $root ?>admin/generate/" class="razd_but" title="">Generate</a></div>
      <div class="but"><a href="<?php echo $root ?>admin/logout.php" class="razd_but" title="">Logout</a></div>
      <?php } ?>
    </div>
    <div id="logo">
    	<a href="#">Lecture Scheduler</a>
		<h2><a href="#" id="metamorph">...for the efficient lecture scheduling</a></h2>
	</div>
</div>
<!-- header ends -->
    <div id="cont_top">
    <div id="cont_bot">
        <!-- content begins -->
        <div id="content">
          <div id="razd">
  