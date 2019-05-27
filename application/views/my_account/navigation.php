<div class="container">
    <div class="clearfix">&nbsp;</div>
    <div class="col-lg-12 nopadding myacc-content">
        <div class="col-lg-3 col-md-3 col-sm-3 nopadding">
            <div class="left-sidebar">
                <ul class="navigation">
                    <li>
                        <a class="nav-head" href="javascript:">
                            <span><i class="fa fa-user"></i>&nbsp;My Profile</span>
                        </a>
                        <ul>
                            <li <?php echo($this->uri->segment(2) && $this->uri->segment(2)=='myaccount')?'class="active"':'';?> >
                                <a href="<?php echo base_url(); ?>user/myaccount">
                                    <span class="text"><i class="fa fa-info-circle fa-lg"></i>&nbsp;Account Information</span>
                                </a>
                            </li>
                            <li <?php echo($this->uri->segment(2) && $this->uri->segment(2)=='change_password')?'class="active"':'';?> >
                                <a  href="<?php echo base_url(); ?>user/change_password">
                                    <span class="text"><i class="fa fa-key fa-lg"></i>&nbsp;Change Password</span>
                                </a>
                            </li>
                            <li <?php echo($this->uri->segment(2) && $this->uri->segment(2)=='shipping_address')?'class="active"':'';?> >
                                <a href="<?php echo base_url(); ?>user/shipping_address">
                                    <span class="text"><i class="fa fa-truck fa-lg"></i>&nbsp;My Shipping Address</span>
                                </a>
                            </li>
                            <li <?php echo($this->uri->segment(2) && $this->uri->segment(2)=='order_history')?'class="active"':'';?> >
                                <a href="<?php echo base_url(); ?>user/order_history">
                                    <span class="text"><i class="fa fa-list fa-lg"></i>&nbsp;Order history</span>
                                </a>
                            </li>
                            <li <?php echo($this->uri->segment(2) && $this->uri->segment(2)=='logout')?'class="active"':'';?> >
                                <a href="<?php echo base_url(); ?>user/logout">
                                    <span class="text"><i class="fa fa-sign-out fa-lg"></i>&nbsp;Logout</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="clearfix visible-xs">&nbsp;</div>
        
       
 