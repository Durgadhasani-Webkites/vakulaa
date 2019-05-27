<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Vakulaa</title>
  <link rel="stylesheet" href="<?php echo $this->config->item('user_css'); ?>bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo $this->config->item('user_css'); ?>custom.css">
  <link rel="stylesheet" href="<?php echo $this->config->item('user_css'); ?>customresponsive.css">
  <link rel="stylesheet" href="<?php echo $this->config->item('user_css'); ?>slick.css">
  <link rel="stylesheet" href="<?php echo $this->config->item('user_css'); ?>slick-theme.css">
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="<?php echo $this->config->item('user_js'); ?>common.js"></script>
  <script src='<?php echo $this->config->item('user_js'); ?>jquery.elevatezoom.js'></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
</head>
<body>
  <div class="freeshipsection hidden-lg">
   <ul class="icons-left-mb-view"> 
    <li>
      <a href="<?php echo prep_url($web_settings['facebook_uri']); ?>" target="_blank">
        <img src="<?php echo $this->config->item('user_images'); ?>face.png" alt="face-img" class="img-responsive">
      </a>
    </li>
    <li>
      <a href="<?php echo prep_url($web_settings['instagram_uri']); ?>" target="_blank">
        <img src="<?php echo $this->config->item('user_images'); ?>insta.png" alt="insta-img" class="img-responsive">
      </a>
    </li>
    <li>
      <a href="<?php echo prep_url($web_settings['youtube_uri']); ?>" target="_blank">
        <img src="<?php echo $this->config->item('user_images'); ?>you.png" alt="you-img" class="img-responsive">
      </a>
    </li>
  </ul>

  <ul class="icons-right-mb-view">
   <?php if($this->session->userdata('login_details')){ ?>
     <li>
       <a href="<?php echo base_url(); ?>user/myaccount">
        <img src="<?php echo $this->config->item('user_images'); ?>myaccount.png" alt="myaccount-img" class="img-responsive hidden-xs">
      </a> 
    </li>
  <?php } else{ ?>
    <li>
     <a href="<?php echo base_url(); ?>user/signup">
      <img src="<?php echo $this->config->item('user_images'); ?>register.png" alt="register-img" class="img-responsive hidden-xs">
    </a> 
  </li>
  <li>
   <a href="<?php echo base_url(); ?>user/signin">
    <img src="<?php echo $this->config->item('user_images'); ?>signin.png" alt="signin-img" class="img-responsive  hidden-xs">
    <img src="<?php echo $this->config->item('user_images'); ?>register-icon.png" alt="register-icon-img" class="img-responsive visible-xs">
  </a>
</li>
<?php } ?>
<li>
 <a href="<?php echo base_url(); ?>cart/view">
  <img src="<?php echo $this->config->item('user_images'); ?>cart.png" alt="cart-img" class="img-responsive cart-icon">
  <span class="cart_count"><?php echo (isset($cart_total))?$cart_total:0; ?></span>
</a>
</li>

</ul>
<?php
$path = $this->uri->segment(1);
if ($path == '') {
 $path = 'index';
}
?>
</div>
<div class="clearfix"></div>
<header class="header-bg">
  <div class="container">
    <div class="main-header">
     <div class="header-inner">
      <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 col-custom">
        <div class="logo">
          <a href="<?php echo base_url(); ?>">
            <img src="<?php echo $this->config->item('user_images'); ?>logo.png" alt="logo" class="img-responsive">
          </a>
        </div>

        <nav>
          <ul class="nav-menu">
            <li><a href="<?php echo base_url(); ?>" <?php
              if( strpos( $path,'index') !== false ) echo 'class="active"';
              ?>><span>HOME</span> </a></li>
            <li><a href="<?php echo base_url(); ?>story" <?php
            if( strpos( $path, 'story' ) !== false ) echo 'class="active"';
            ?> ><span> STORY</span></a></li>
            <li><a href="<?php echo base_url(); ?>products" <?php
            if( strpos( $path, 'products' ) !== false ) echo 'class="active"';
            ?>><span>PRODUCTS</span></a></li>
            <li><a href="<?php echo base_url(); ?>partner-with-us" <?php
            if( strpos( $path, 'partner-with-us' ) !== false ) echo 'class="active"';
            ?>><span>PARTNER WITH US</span></a></li>
            <li><a href="<?php echo base_url(); ?>contact-us" <?php
            if( strpos( $path, 'contact-us' ) !== false ) echo 'class="active"';
            ?>><span>CONTACT</span></a></li>
          </ul>
        </nav>
        <div class="btn-group mobile-menu">
          <!-- Basic dropdown -->
          <button class="btn btn-primary dropdown-toggle mr-4" type="button" data-toggle="dropdown" aria-haspopup="true"
          aria-expanded="false">
          <i class="fas fa-bars"></i>
        </button>

        <div class="dropdown-menu">
          <a class="dropdown-item" href="<?php echo base_url(); ?>">HOME</a>
          <a class="dropdown-item" href="<?php echo base_url(); ?>story">STORY</a>
          <a class="dropdown-item" href="<?php echo base_url(); ?>products">PRODUCTS</a>
          <a class="dropdown-item" href="<?php echo base_url(); ?>partner-with-us">PARTNER WITH US</a>
          <a class="dropdown-item" href="<?php echo base_url(); ?>contact-us">CONTACT</a>
        </div>
        <!-- Basic dropdown -->
      </div>

    </div>

  </div>

</div>

<span class="top-layer"> <img src="<?php echo $this->config->item('user_images'); ?>bg-top.png" alt="top-bg" class="img-responsive"></span></center>

<div class="nav-icons-right hidden-md hidden-sm hidden-xs"> 
  <?php if($this->session->userdata('login_details')){ ?>
    <a href="<?php echo base_url(); ?>user/myaccount">
      <img src="<?php echo $this->config->item('user_images'); ?>myaccount.png" alt="signin-img" class="img-responsive nav-icon-img">
    </a>
  <?php } else{ ?>
    <a href="<?php echo base_url(); ?>user/signup">
      <img src="<?php echo $this->config->item('user_images'); ?>register.png" alt="register-img" class="img-responsive nav-icon-img">
    </a>
    <a href="<?php echo base_url(); ?>user/signin">
      <img src="<?php echo $this->config->item('user_images'); ?>signin.png" alt="signin-img" class="img-responsive nav-icon-img">
    </a>
  <?php } ?>
  <a href="<?php echo base_url(); ?>cart/view">
    <img src="<?php echo $this->config->item('user_images'); ?>cart.png" alt="cart-img" class="img-responsive nav-icon-img cart-icon">
    <span class="cart_count"><?php echo (isset($cart_total))?$cart_total:0; ?></span>
  </a>
</div>

<div class="nav-icons-left hidden-md hidden-sm hidden-xs"> 
  <a href="<?php echo prep_url($web_settings['facebook_uri']); ?>"  target="_blank">
    <img src="<?php echo $this->config->item('user_images'); ?>face.png" alt="face-img" class="img-responsive nav-icon-img">
  </a>
  <a href="<?php echo prep_url($web_settings['instagram_uri']); ?>"  target="_blank">
    <img src="<?php echo $this->config->item('user_images'); ?>insta.png" alt="insta-img" class="img-responsive nav-icon-img">
  </a>
  <a href="<?php echo prep_url($web_settings['youtube_uri']); ?>"  target="_blank">
    <img src="<?php echo $this->config->item('user_images'); ?>you.png" alt="you-img" class="img-responsive nav-icon-img">
  </a>
</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>

<div class="slider-box">

 <div class="doodle-box">
  <div class="doodle-left">
    <img src="<?php echo $this->config->item('user_images'); ?>doodle-left.png" alt="doodle" class="img-responsive">
  </div>
  <div class="doodle-right">
    <img src="<?php echo $this->config->item('user_images'); ?>doodle-right.png" alt="doodle" class="img-responsive">
  </div>
</div>


<div id="myCarousel" div class="carousel slide carousel-fade" data-ride="carousel" data-interval="6000">

 <!-- Indicators -->
 <ol class="carousel-indicators">
   <?php
   if (!empty($banners)) {
     $i = 0;
     foreach($banners as $k=>$v){
      ?>
      <li data-target="#myCarousel" data-slide-to="<?php echo $i ?>" class="dots"></li>
      <?php
      $i++;
    }
  }
  ?>
</ol>

<!-- Wrapper for slides -->
<div class="carousel-inner">

  <?php
  if (!empty($banners)) {
    foreach($banners as $k=>$v){
      $image_link='javascript:';
      if($v['image_link']!='#'){
        $image_link = prep_url($v['image_link']);
      }
      $image = "{$this->config->item('upload')}banners/{$v['image']}";
      $image_name = $v['image_name'];
      ?>
      <div class="item">
        <a href="detailpage.php">
         <img src="<?php echo $image; ?>" alt="Los Angeles">
       </a>
     </div>
     <?php
   }
 }
 ?>
</div>

<!-- Left and right controls -->
<a class="left carousel-control" href="#myCarousel" data-slide="prev">
  <span class="glyphicon glyphicon-chevron-left"></span>
  <span class="sr-only">Previous</span>
</a>
<a class="right carousel-control" href="#myCarousel" data-slide="next">
  <span class="glyphicon glyphicon-chevron-right"></span>
  <span class="sr-only">Next</span>
</a>
</div>

</div>


</div>

</header>
