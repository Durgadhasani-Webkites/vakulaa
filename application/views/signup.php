<section class="loginpage">
  <div class="section-bg">
    <div class="container">
      <div class="clearfix">&nbsp;</div>
      <div class="clearfix">&nbsp;</div>
      <div class="col-lg-12 setup ">
        <div class="col-lg-4 col-md-6 col-sm-8 col-xs-12 col-custom sigin-mb">
          <div class="sigin">
            <div class="signin-content">
             <h2>Join Vakulaa</h2>
             <span>Already Having Account?</span>
             <div class="clearfix visible-xs">&nbsp;</div>
             <a href="<?php echo base_url(); ?>user/signin">Sign in</a>
           </div>
           
           <div class="signin-account">
             <h4>Create my account</h4>
             <form method="post" action="<?php echo base_url(); ?>user/signup_process" role="form" id="signup_frm">

               <div class="form-group">
                <input type="text" class="form-control" placeholder="ENTER YOUR NAME" name="name">
              </div>

              <div class="form-group">
                <input type="text" class="form-control" placeholder="ENTER YOUR PHONE NUMBER" name="user_phone">
              </div>

              <div class="form-group">
               <input type="text" class="form-control" placeholder="ENTER YOUR EMAIL ADDRESS" name="user_email" >
             </div>

             <div class="form-group">
              <input type="password" class="form-control" placeholder="ENTER YOUR PASSWORD" name="password" >
            </div>

            <p> <button type="submit" class="btn-now">sign up</button></p> 
          </form>
        </div>

      </div>
    </div>
  </div>

</div>

</div>

</section>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix visible-xs">&nbsp;</div>

<script>
  $(function(){
    $('#signup_frm').validate({
      errorClass: "error-msg",
      ignore: [],
      errorElement:'div',

      rules: {
        name:{
          required:true
        },
        user_phone:{
          required:true,
          number:true,
          minlength:10,
          maxlength:10,
          remote: {
            url: '<?php echo base_url(); ?>user/phone_exists',
            type: "post"
          },
        },
        user_email: {
          required: true,
          email: true,
          remote: {
            url:'<?php echo base_url(); ?>user/email_exists',
            type: "post"
          }
        },
        password:{
          required:true,
        }
      },
      messages:{
        user_phone:{
          remote:'Phone number already exists'
        },
        user_email:{
          remote:'Email already exists'
        }
      },

    });

    

  });
</script>