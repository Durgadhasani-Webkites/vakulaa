<?php $base_url=base_url('admin').'/'; ?>
<!DOCTYPE html>
<html>

<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <title><?php echo (isset($meta_title))? $meta_title:'Admin Panel'; ?></title>
    <meta name="keywords" content="<?php echo (isset($meta_description))? $meta_description:''; ?>" />
    <meta name="description" content="<?php echo (isset($meta_keywords))? $meta_keywords:''; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font CSS (Via CDN) -->
    <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>

    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_css');?>theme.css">

    <!-- Admin Forms CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_css');?>admin-forms.css">

<!--    custom css-->
    <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_css');?>custom.css">

    <script src="<?php echo $this->config->item('admin_js');?>jquery/jquery-1.11.1.min.js"></script>
    <script src="<?php echo $this->config->item('admin_js');?>jquery/jquery_ui/jquery-ui.min.js"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/img/favicon.ico">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        var base_url='<?php echo $base_url; ?>';
        $(function(){
            var getUnseen = function(){
                $.ajax({
                    type: "post",
                    url: base_url + 'orders/get_unseen_orders_ajax',
                    dataType: 'JSON',
                    success: function (result) {
                        $('.unseen-total').html(result.unseen_total);
                        $('.unseen-list').html(result.unseen_list);
                    }
                });
            };
            setInterval(getUnseen,60000);
            $('.refresh-unseen').click(function(){
                getUnseen() ;
            });
            $('.mark_all_as_seen').click(function(){
                $.ajax({
                    type: "post",
                    url: base_url + 'orders/mark_all_as_seen',
                    success: function (result) {
                        $('.unseen-total').html(0);
                        $('.unseen-list').html('');
                    }
                });
            })
        });
    </script>
</head>
<body class="dashboard-page">

<?php
$privileges=$this->session->userdata('privileges');
$privileges_arr=explode(",",$privileges);
?>

<div id="main">

    <!-- Start: Header -->
    <header class="navbar navbar-fixed-top navbar-shadow">
        <div class="navbar-branding">
            <a class="navbar-brand" href="<?php echo $base_url.'index/dashboard'; ?>">
                <img src="<?php echo $this->config->item('admin_images'); ?>logo.png" style="height:38px;" />
            </a>
            <span id="toggle_sidemenu_l" class="ad ad-lines"></span>
        </div>

        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown menu-merge">
                <div class="navbar-btn btn-group">

                    <button data-toggle="dropdown" class="btn btn-sm dropdown-toggle">
                        <span class="fa fa-shopping-cart fs14 va-m"></span>
                        <span class="badge badge-danger unseen-total"><?php echo $unseen_orders['count']; ?></span>
                    </button>
                    <div class="dropdown-menu dropdown-persist w350 animated animated-shorter fadeIn" role="menu">
                        <div class="panel mbn">
                            <div class="panel-menu">
                                <span class="panel-icon"><i class="fa fa-clock-o"></i></span>
                                <span class="panel-title fw600"> Recent Orders&nbsp;&nbsp;<label class="mark_all_as_seen label label-success ">Mark all as seen</label></span>

                                <button class="btn btn-default light btn-xs pull-right refresh-unseen" type="button"><i class="fa fa-refresh"></i></button>
                            </div>
                            <div class="panel-body panel-scroller scroller-navbar scroller-overlay scroller-pn pn">
                                <ol class="timeline-list unseen-list">
                                <?php if(!empty($unseen_orders['list'])){
                                    foreach($unseen_orders['list'] as $k=>$v){
                                        $order_time = date('d/m/Y h:i:s A',strtotime($v['created']));
                                        $order_id=$v['order_id'];
                                        $user_name=$v['shipping_user_name'];
                                        $view_url=base_url().'admin/orders/view_invoice/'.$v['id'];
                                        ?>
                                        <li class="timeline-item">
                                            <div class="timeline-icon bg-dark light">
                                                <span class="fa fa-tags"></span>
                                            </div>
                                            <div class="timeline-desc">
                                                <b><?php echo $user_name; ?></b>
                                                <br/>
                                                <a target="_blank" href="<?php echo $view_url; ?>"><?php echo $order_id; ?></a>
                                            </div>
                                            <div class="timeline-date"><?php echo $order_time; ?></div>
                                        </li>
                                <?php } } ?>
                                </ol>

                            </div>
                            <div class="panel-footer text-center p7">
                                <a target="_blank" href="<?php echo base_url(); ?>admin/orders?list=today" class="link-unstyled"> View All </a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="dropdown menu-merge">
                <a href="#" class="dropdown-toggle fw600 p15" data-toggle="dropdown">
                    <img src="<?php echo $this->config->item('admin_images');?>nopic.jpg" alt="avatar" class="mw30 br64">
                    <span class="hidden-xs pl15"> <?php echo  ucfirst($this->session->userdata('username')); ?></span>
                    <span class="caret caret-tp hidden-xs"></span>
                </a>
                <ul class="dropdown-menu list-group dropdown-persist w250" role="menu">
                    <li class="list-group-item">
                        <a href="<?php echo $base_url.'profile'; ?>" class="animated animated-short fadeInUp">
                            <span class="fa fa-user"></span> Profile
                        </a>
                    </li>
                    <li class="dropdown-footer">
                        <a href="<?php echo $base_url.'index/logout'; ?>" class="">
                            <span class="fa fa-power-off pr5"></span> Logout </a>
                    </li>
                </ul>
            </li>
        </ul>
    </header>
    <!-- End: Header -->

    <aside id="sidebar_left" class="nano nano-light affix">

    <!-- Start: Sidebar Left Content -->
    <div class="sidebar-left-content nano-content">

    <!-- Start: Sidebar Header -->
    <header class="sidebar-header">

        <!-- Sidebar Widget - Author -->
        <div class="sidebar-widget author-widget">
            <div class="media">
                <a class="media-left" href="#">
                    <img src="<?php echo $this->config->item('admin_images');?>nopic.jpg" class="img-responsive">
                </a>
                <div class="media-body">
                    <div class="media-links">
                        <a href="<?php echo $base_url.'index/logout'; ?>">Logout</a>
                    </div>
                    <div class="media-author">
                        <a href="<?php echo $base_url.'profile'; ?>" style="color: #ffffff">
                            <?php echo ucfirst($this->session->userdata('username')); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- End: Sidebar Header -->

    <!-- Start: Sidebar Menu -->
    <ul class="nav sidebar-menu">
        <li class="sidebar-label pt20">Menu</li>
        <li class="active">
            <a href="<?php echo $base_url.'index/dashboard'; ?>">
                <span class="glyphicon glyphicon-home"></span>
                <span class="sidebar-title">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="<?php echo $base_url.'profile'; ?>">
                <span class="fa fa-user"></span>
                <span class="sidebar-title">Profile</span>
            </a>
        </li>
    </ul>
        <?php
        if($this->session->userdata('privileges')){
            $privileges=$this->session->userdata('privileges');
            $privileges_arr= explode(",",$privileges);
            $new_privileges_arr=array();
            foreach($privileges_arr as $k=>$v){
                if(strpos($v,'-')){
                    $sub_prev_arr=explode("-",$v);
                    if(!in_array($sub_prev_arr[0],$new_privileges_arr)){
                        $new_privileges_arr[]=$sub_prev_arr[0];
                    }
                    $new_privileges_arr[]=$sub_prev_arr[1];
                }else{
                    $new_privileges_arr[]=$v;
                }
            }
        }
        //print_r($modules);die;
            ?>
        <?php if(!empty($modules)){ ?>
            <ul class="nav sidebar-menu">
                <li class="sidebar-label">Catalog</li>
                <?php foreach($modules as $k=>$v){
                    $active_class='';
                    $link_class='';
                    $module_id=$v['id'];
                    $module_link = $v['link'];
                    $module_icon=$v['icon'];
                    $module_name=$v['name'];
                    $sub_modules=$v['sub_modules'];
                        if(!empty($new_privileges_arr) && in_array($module_id,$new_privileges_arr)) {

                            if (empty($module_link)) {
                                $module_link='#';
                                $link_class = 'accordion-toggle';
                            }
                            if ($this->uri->segment(2) == $module_link) {
                                $active_class = 'active';
                            }
                            //for checking parent
                            if(!empty($sub_modules)){
                                $module_link_arr=array();
                                foreach($sub_modules as $k2=>$v2){
                                    $module_id=$v2['id'];
                                    $sub_module_link = $v2['link'];
                                    if(!empty($new_privileges_arr) && in_array($module_id,$new_privileges_arr)) {
                                        if (strpos($sub_module_link, '/')) {
                                            $link_arr = explode("/", $sub_module_link);
                                            $sub_module_link = $link_arr[0];
                                        }
                                        $module_link_arr[] = $sub_module_link;
                                    }
                                }
                            }
                            ?>
                        <li class="<?php echo $active_class; ?>">
                                <a class="<?php echo $link_class; ?> <?php echo (!empty($module_link_arr) && in_array($this->uri->segment(2),$module_link_arr))? 'menu-open':''; ?>" href="<?php echo $base_url.$module_link; ?>">
                                    <?php echo $module_icon; ?>
                                    <span class="sidebar-title"><?php echo $module_name; ?></span>
                                    <?php if(!empty($sub_modules)){ ?>
                                        <span class="caret"></span>
                                    <?php } ?>
                                </a>
                            <?php  if(!empty($sub_modules)){?>
                                <ul class="nav sub-nav">
                                    <?php
                                    foreach($sub_modules as $k1=>$v1){
                                        $active_class='';
                                        $link_class='';
                                        $module_id=$v1['id'];
                                        $module_link = $v1['link'];
                                        $module_icon=$v1['icon'];
                                        $module_name=$v1['name'];
                                        if(!empty($new_privileges_arr) && in_array($module_id,$new_privileges_arr)) {

                                            if(empty($module_link)) {
                                                $link_class = 'accordion-toggle';
                                            }
                                            if($this->uri->segment(2)==$module_link){
                                                $active_class='active';
                                            }
                                            ?>
                                            <li class="<?php echo $active_class; ?>">
                                                <a href="<?php echo $base_url.$module_link; ?>"><?php echo $module_icon; ?><?php echo $module_name; ?></a>
                                            </li>
                                        <?php  } } ?>
                                </ul>
                            <?php } ?>
                            <?php
                            }
                            ?>
                        </li>
                        <?php
                } ?>
            </ul>
        <?php  } ?>
    <!-- End: Sidebar Menu -->

    </div>
    <!-- End: Sidebar Left Content -->

    </aside>

    <!-- Start: Content-Wrapper -->
    <section id="content_wrapper">
        <!-- notification section -->
        <div class="notification notify_success" data-note-stack="stack_top_right" data-note-style="success" style="display:none;">
            <?php echo ($this->session->flashdata('notify_success'))?$this->session->flashdata('notify_success'):''; ?>
        </div>
        <?php if($this->session->flashdata('notify_success')){ ?>
            <script type="text/javascript">
                $(function(){
                    setTimeout(function() {
                        $('.notify_success').trigger('click');
                    },10);

                });
            </script>
        <?php } ?>
        <div class="notification notify_error" data-note-stack="stack_top_right" data-note-style="danger" style="display:none;">
            <?php echo ($this->session->flashdata('notify_error'))?$this->session->flashdata('notify_error'):""; ?>
        </div>
        <?php if($this->session->flashdata('notify_error')){ ?>
            <script type="text/javascript">
                $(function(){
                    setTimeout(function() {
                        $('.notify_error').trigger('click');
                    },10);
                });
            </script>
        <?php } ?>

        <div class="notification notify_info" data-note-stack="stack_bar_top" data-note-style="info" style="display:none;">
            <?php echo ($this->session->flashdata('notify_info'))?$this->session->flashdata('notify_info'):""; ?>
        </div>
    <?php if($this->session->flashdata('notify_info')){ ?>
        <script type="text/javascript">
            $(function(){
                setTimeout(function() {
                    $('.notify_info').trigger('click');
                },10);
            });
        </script>
    <?php } ?>