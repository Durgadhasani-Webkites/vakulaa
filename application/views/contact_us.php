    <section class="contact">
      <div class="section-bg">
        <div class="container">

         <div class="clearfix">&nbsp;</div>
         <div class="clearfix">&nbsp;</div>
         <div class="col-lg-10 col-md-12 col-sm-12 col-xs-12 col-custom">
          <?php
          if (!empty($contact_address['map'])) {
            ?>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 map-box">
              <iframe src="<?php echo $contact_address['map'] ?>" width="400" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
            <?php
          }
          ?>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 outer ">

            <div class="contact-page inner">
              <address>
               <?php
               if (!empty($contact_address['address'])) {
                 echo $contact_address['address'];
               }
               ?>
               <br>
               <?php
               if (!empty($contact_address['city'])) {
                 echo $contact_address['city'];
               }
               ?>
               -
               <?php
               if (!empty($contact_address['pincode'])) {
                 echo $contact_address['pincode'].',';
               }
               ?>
               <?php
               if (!empty($contact_address['state'])) {
                 echo $contact_address['state'];
               }
               ?>
               <br>
               <?php
               if (!empty($contact_address['country'])) {
                 echo $contact_address['country'];
                 ?>
                 <br>
                 <?php
               }
               ?>

               <?php
               if (!empty($contact_address['phone_no'])) {
                 echo $contact_address['phone_no'];
               }
               ?>
               <br>
               <?php
               if (!empty($contact_address['email_address'])) {
                 echo $contact_address['email_address'];
               }
               ?>
               <br>
               <?php
               if (!empty($contact_address['website'])) {
                 echo $contact_address['website'];
               }
               ?>
             </address>
             <div class="clearfix">&nbsp;</div>
             <address>
               <?php
               if (!empty($position_details['position1'])) {
                 echo $position_details['position1'];
               }
               ?><br>
               <?php
               if (!empty($position_details['name1'])) {
                 echo $position_details['name1'];
               }
               ?><br>
               <?php
               if (!empty($position_details['phone_no1'])) {
                 echo $position_details['phone_no1'];
               }
               ?><br>
               <?php
               if (!empty($position_details['email1'])) {
                 echo $position_details['email1'];
               }
               ?><br>
            </address>
            <div class="clearfix">&nbsp;</div>
            <address>
               <?php
               if (!empty($position_details['position2'])) {
                 echo $position_details['position2'];
               }
               ?><br>
               <?php
               if (!empty($position_details['name2'])) {
                 echo $position_details['name2'];
               }
               ?><br>
               <?php
               if (!empty($position_details['phone_no2'])) {
                 echo $position_details['phone_no2'];
               }
               ?><br>
               <?php
               if (!empty($position_details['email2'])) {
                 echo $position_details['email2'];
               }
               ?><br>
            </address>
          </div>
        </div>



        <div class="clearfix">&nbsp;</div>
        <div class="clearfix">&nbsp;</div>

        <div class="find-vendor">
          <span>
            Find your local Vendor
          </span>
          <select name="country" id="country">
            <option value="">Select Your Country</option>
            <?php foreach ($country as $value) { ?>
            <option value="<?php echo $value['id']; ?>"><?php echo $value['country']; ?></option>
            <?php
            } ?>
            
          </select>

        </div>


        <div class="clearfix">&nbsp;</div>
        <div class="clearfix">&nbsp;</div>

        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 map-box">
          <iframe id="map" src="" width="300" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>

        </div>


        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 contact-page map-box">

          <address id="result">
          
          </address>
          <br>
        </div>
<br>
      </div>
<br>
      <!-- container -->     
    </div>
    <!-- section-bg -->
  </section>

<script type="text/javascript">
$("#country").change(function(){
   var country = $(this).val();

   $.ajax({
     url:'<?php echo site_url('contact_us/get_details'); ?>',
     type: 'post',
     data: {country:country},
     dataType: 'json',
     success:function(response){
       var len = response.length;
       $("#result").empty();
       for( var i = 0; i<len; i++){
        var designation = response[i]['designation'];
         var name = response[i]['name'];
         var email = response[i]['email'];
         var mobile = response[i]['mobile'];
         // var google = response[i]['google'];
          // $("#map").append("<iframe src='"+google+"'>"+google+"</option>");
          $("#result").append("<div value='"+designation+"'>"+designation+"</option>");
          $("#result").append("<div value='"+name+"'>"+name+"</option>");
         $("#result").append("<div value='"+email+"'>"+email+"</option>");
         $("#result").append("<div value='"+mobile+"'>"+mobile+"</option>");
         $("#result").append("<div class='clearfix'>&nbsp;");
       }
     }
   });
 });
</script>