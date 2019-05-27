<section class="loginpage">
  <div class="section-bg">
    <div class="container">
      <div class="clearfix">&nbsp;</div>
      <div class="clearfix">&nbsp;</div>
      <div class="col-sm-6 setup">
        <div class="sigin" style="border:none;">
        <h2>Save time now</h2>
        <span style="font-size: 15px;">You don't need an account to check out</span>
        <center>
       <a href="<?php echo base_url(); ?>checkout"><button type="button" class="btn-now guest-account">Continue as guest</button></a> 
       </center>
     </div>
      </div>
      <div class="col-sm-6 setup sign-view">
        <div class="col-md-1"></div>
        <div class="col-md-9 col-sm-12">
          <div class="sigin">
            <div class="signin-content">
             <h2>Sign in to your account</h2>
             <span>New to Vakulla</span>
             <a href="<?php echo base_url(); ?>user/signup">Join Now</a>
           </div>
           <div class="signin-account">
             <h4>Sign in to your account</h4>
             <div style="width:100%;"><?php
                        if($this->session->flashdata('login_error')){ ?>
                            <div class="alert alert-danger alert-dismissible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $this->session->flashdata('login_error'); ?>
                            </div>

                        <?php } ?>
                    </div>
             <form method="post" action="<?php echo base_url(); ?>user/signin_process" role="form" id="signin_frm">
             <div class="form-group">
               <input type="emailid" class="form-control" placeholder="ENTER YOUR EMAIL ADDRESS" name="user_email">
             </div>
             <div class="form-group">
              <input type="password" class="form-control" placeholder="ENTER YOUR PASSWORD" name="password">
            </div>
            <p class="sign-in"><button type="submit" class="btn-now">sign in</button></p> 
          </form>
            <div class="spot">
              <a href="<?php echo base_url(); ?>user/forgot">Forgot Password?</a>
            </div>  
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
<div class="clearfix">&nbsp;</div>
<div class="clearfix visible-xs">&nbsp;</div>
<div class="clearfix visible-xs">&nbsp;</div>
<script type="text/javascript">
    $(function () {
        $("#signin_frm").validate({
            errorClass: "error-msg",
            ignore: [],
            errorElement:'div',
            rules: {
                user_email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                }
            }
        });
    });
</script>