<?php include_once('navigation.php'); ?>
<div class="col-lg-9 col-md-9 col-sm-9">
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
            Change Password
        </div>
        <div class="clearfix">&nbsp;</div>
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => 'change_pass_frm');
        echo form_open_multipart('user/process_change_password', $attributes);
        ?>
        <div class="form-group">
            <div class="col-lg-12 ">
                <input type="password" class="form-control" id="old_password" placeholder="Enter your old password" name="old_password">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12 ">
                <input type="password" class="form-control" id="new_password" placeholder="Enter your new password" name="new_password">
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-12 ">
                <input type="password" class="form-control" id="confirm_pass" placeholder="Enter your confirm password" name="confirm_pass">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12 ">
                <input class="btn btn-black " id='update' type="submit" value="Update">
            </div>
        </div>
        <?php form_close(); ?>
    </div>
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
</div>
</div>
</div>
<script type="text/javascript">
    $(function(){
        $('#change_pass_frm').validate({
            errorClass: "error-msg",
            ignore: [],
            errorElement:'div',
            rules: {
                old_password:{
                    required:true,
                    remote: '<?php echo base_url(); ?>user/check_old_pass'
                },
                new_password:{
                    required:true,
                },
                confirm_pass:{
                    required:true,
                    equalTo:'#new_password'
                }
            },
            messages: {
                confirm_pass: {
                    equalTo: "Confirm password doesn\'t match"
                },
                old_password:{
                    remote:'Incorrect old password'
                }
            }
        });
    });
</script>