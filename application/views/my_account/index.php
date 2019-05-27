<?php include_once('navigation.php'); ?>
<div class="col-lg-9 col-md-9 col-sm-9 ">
    <div class="right-sec">
        <?php if( $this->session->flashdata('success')){ ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php } ?>
        <?php if( $this->session->flashdata('error')){ ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php } ?>

        <div class="formhead">
            Account Information
        </div>
        <div class="clearfix">&nbsp;</div>
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => 'my_account_frm');
        echo form_open_multipart('user/process_account', $attributes);
        ?>
        <input type="hidden" name="id" value="<?php echo $user_details['id']; ?>"  />
        <div class="form-group">
            <div class="col-lg-12 ">
                <input type="text" class="form-control" id="user_name" placeholder="Enter your name" value="<?php echo set_value('user_name',(!empty($user_details['user_name']))?$user_details['user_name']:''); ?>" name="user_name">
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-12 ">
                <input type="text" class="form-control" id="user_email" placeholder="Enter your email address" value="<?php echo set_value('user_email',(!empty($user_details['user_email']))?$user_details['user_email']:''); ?>" name="user_email">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12 ">
                <input type="text" class="form-control" id="user_phone" placeholder="Enter your phone no" value="<?php echo set_value('user_phone',(!empty($user_details['user_phone']))?$user_details['user_phone']:''); ?>" name="user_phone">
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-12 ">
                <input class="btn btn-black " id='update' type="submit" value="Update">
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
</div>
</div>
<script type="text/javascript">
    $(function(){
        $('#my_account_frm').validate({
            errorClass: "error",
            ignore: [],
            rules: {
                name:{
                    required:true,
                    noTild:true
                },
                email:{
                    required:true,
                    validEmail:true
                },
                user_phone:{
                    required: true,
                    validContact:true,
                    maxlength:10,
                    minlength:10
                }
            },
             messages: {
                user_phone:{
                    minlength:'Minimum 10 number is required',
                    maxlength:'Maximum 10 number is required',
                    // remote:'This number has been already registered'
                },
            },
        });
    });
</script>
