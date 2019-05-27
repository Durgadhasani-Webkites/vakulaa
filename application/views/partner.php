<div class="section-bg partner-bg">
  <div class="container">
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
    
       <?php if( $this->session->flashdata('success')){ ?>
           <div class="alert alert-success">
               <?php echo $this->session->flashdata('success'); ?>
           </div>
           <div class="clearfix">&nbsp;</div>
       <?php } ?>
       <?php if( $this->session->flashdata('error')){ ?>
           <div class="alert alert-danger">
               <?php echo $this->session->flashdata('error'); ?>
           </div>
           <div class="clearfix">&nbsp;</div>
       <?php } ?>

    <div id="exTab3">	
      <ul  class="nav nav-pills">
       <li class="active">
        <a  href="#1b" data-toggle="tab">India</a>
      </li>
      <li><a href="#2b" data-toggle="tab">Overseas</a>
      </li>
      
    </ul>

    <div class="tab-content clearfix">
     <div class="tab-pane active" id="1b">
      <form method="POST" id="add_form" action="<?php echo base_url();?>partner/add_contact_details">
      <div class="col-lg-6 col-md-6 col-sm-10 col-xs-12 newlogs">
       <div class="newlog">
         <h3>Contact Details</h3><br>
        

           <div class="row form-row">

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <label for="staticEmail" class="col-form-label">Name of Organisation / Company:</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
              <input type="text" name="name"  class="form-control" id="Company_name" placeholder="Name of Organisation/Company">
            </div>

          </div>
          
          <div class="row form-row">

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <label for="staticEmail" class="col-form-label">Website:</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
              <input type="text"  class="form-control" name="website" id="website" placeholder="Website">
            </div>
            
          </div>        
          
          <div class="row form-row">

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <label for="staticEmail" class="col-form-label">First Name:</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
              <input type="text"  class="form-control" id="firstname" name="first_name" placeholder="Enter Your First Name ">
            </div>
            
          </div>

          <div class="row form-row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <label for="staticEmail" class="col-form-label">Last Name:</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
              <input type="text" class="form-control" id="lastname" name="last_name" placeholder="Enter Your Last Name ">
            </div>
          </div>

          <div class="row form-row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <label for="staticEmail" class="col-form-label">Email id:</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
              <input type="text"  class="form-control" id="email" name="email" placeholder=" Enter Your Email id ">
            </div>

          </div>

          <div class="row form-row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <label for="staticEmail" class="col-form-label">Mobile No:</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <input type="text"  class="form-control" id="mobnumber" name="mobile" placeholder="Enter Your Mobile No">
            </div>
          </div>

          
          <div class="row form-row">     
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <label for="staticEmail" class="col-form-label">Telephone No:</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
              <input type="text"  class="form-control" id="telnumber" name="telephone" placeholder="Enter Your Telephone No ">
            </div>
          </div>
          
          <div class="row form-row">   
           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label for="staticEmail" class="col-form-label">State:</label>
          </div>
          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <input type="text"  class="form-control" id="state" name="state" placeholder="Select State ">
          </div>
        </div>
        
        <div class="row form-row">     
         <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
          <label for="staticEmail" class="col-form-label">City:</label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
          <input type="text"  class="form-control" id="city" name="city" placeholder="Select City ">
        </div>
      </div>
      
      <div class="row form-row">     
       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <label for="staticEmail" class="col-form-label">Location:</label>
      </div>
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <input type="text"  class="form-control" id="location" name="location" placeholder="Location ">
      </div>
    </div>
    
    <div class="row form-row">     
     <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <label for="staticEmail" class="col-form-label">Company Address:</label>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
      <input type="text"  class="form-control" id="address" name="company_address" placeholder="Enter You Address ">
    </div>
  </div>
  
  <div class="row form-row">     
   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
    <label for="staticEmail" class="col-form-label">Pincode:</label>
  </div>
  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
    <input type="text"  class="form-control" id="pincode" name="pincode" placeholder="Enter Your Pincode">
  </div>
</div>

<!-- </form>  -->
</div>
</div>

<div class="col-lg-6 col-md-6 col-sm-10 col-xs-12 newlogs">
  <div class="newlog">
    <h3>Product Details</h3><br>
    <!-- <form> -->
    <div class="form-group row">
      <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col-form-label">Category :</label>
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
       <select class="form-control" name="category">
         <option value="">Select Category</option>
         <option value="1">Grocery</option>
         <option value="2">Food</option>
         <option value="3">Fresh Fruits</option>

       </select>
     </div>
   </div>

   <div class="form-group row">
    <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col-form-label">Goods/Services Being Offered :</label>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
      <input type="text"  class="form-control" id="name" name="goods" placeholder="Goods/Services Being Offered" required>
    </div>
  </div>


  <div class="form-group row">
    <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col-form-label">Pan card :</label>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
      <input type="text"  class="form-control"  name="pan" placeholder="Enter Your PAN Numbere ">
    </div>
  </div>

  <div class="form-group row">
    <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col-form-label">GST No :</label>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
      <input type="text"  class="form-control"  name="gst_no" placeholder=" Enter Your GST  Numbere">
    </div>
  </div>

  <div class="form-group row">
    <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col-form-label">GST Registration Type:</label>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
      <input type="text"  class="form-control" id="number" name="gst_register" placeholder="Select GST Registration Type ">
    </div>
  </div>

  <div class="form-group row">
    <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col-form-label">Period in Distributorship / Manufacturing /Import:</label>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
      <input type="text"  class="form-control" id="text" name="distributorship" placeholder="Period in Distributorship / Manufacturing /Import ">
    </div>
  </div>
  <div class="form-group row">
    <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col-form-label">Area Covered:</label>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
      <input type="text"  class="form-control"  name="area_covered" placeholder="Area Covered ">
    </div>
  </div>
  <div class="form-group row">
    <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col-form-label">Annual Turnover:</label>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
      <input type="text"  class="form-control"  name="annual_turnover" placeholder="Annual Turnover">
    </div>
  </div>
  <div class="form-group row">
    <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col-form-label">NMMC Cess No.(If any):</label>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
      <input type="text"  class="form-control"  name="nmmc_no" placeholder="NMMC Cess No">
    </div>
  </div>
  <div class="form-group row">
    <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col-form-label">What Products do you do?:</label>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 form">
      <textarea class="text-area w-input" id="field" maxlength="5000" name="field" placeholder="textarea" required="required"></textarea>
    </div>
  </div>


  <div class="form-group row">
    <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col-form-label">Add One+One:</label>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 form">
      <input type="text"  class="form-control" name="add_one"  placeholder="Add " > 
    </div>
  </div>


  <div class="form-group row">
    <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col-form-label">Validation Code:</label>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 form">
      <input type="text"  class="form-control"  name="validation_code" placeholder="Captcha" > 
    </div>
  </div>
  <div class="Continue">
    <input type="submit" class="btn-nowe"> 
  </div>
</form>
</div>
</div>

</div>
<div class="tab-pane" id="2b">
 <form method="POST" id="overseas" action="<?php echo base_url();?>partner/add_overseas_details">

  <div class="col-lg-6 col-md-6 col-sm-10 col-xs-12">
   <div class="newlog">
     <h3>Contact Details</h3><br>
    
      <div class="form-group row">
        <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12  col-form-label">Name of Organisation/Company:</label>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
          <input type="text"  class="form-control" id="name" name="Company_name" placeholder="Name of Organisation/Company">
        </div>
      </div>
      
      
      <div class="form-group row">
        <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12  col-form-label">Website:</label>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
          <input type="text"  class="form-control"  name="website" placeholder="Website">
        </div>
      </div>

      <div class="form-group row">
        <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12  col-form-label">First Name:</label>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
          <input type="text"  class="form-control"  name="first_name" placeholder="Enter Your First Name ">
        </div>
      </div>


      <div class="form-group row">
        <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12  col-form-label">Last Name:</label>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
          <input type="text"  class="form-control"  name="last_name" placeholder="Enter Your Last Name ">
        </div>
      </div>

      <div class="form-group row">
        <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12  col-form-label">Email id:</label>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
          <input type="text"  class="form-control"  name="email" placeholder=" Enter Your Email id">
        </div>
      </div>

      <div class="form-group row">
        <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12  col-form-label">Mobile No:</label>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
          <input type="text"  class="form-control" id="number" name="mobile" placeholder="Enter Your Mobile No ">
        </div>
      </div>
      <div class="form-group row">
        <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12  col-form-label">Telephone No:</label>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
          <input type="text"  class="form-control"  name="telephone" placeholder="Enter Your Telephone No ">
        </div>
      </div>
      
      <div class="form-group row">
        <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12  col-form-label">City:</label>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
          <input type="text"  class="form-control"  name="city" placeholder="Select City ">
        </div>
      </div>
      <div class="form-group row">
        <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12  col-form-label">Location:</label>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
          <input type="text"  class="form-control"  name="location" placeholder="Location ">
        </div>
      </div>
      <div class="form-group row">
        <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12  col-form-label">Company Address:</label>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
          <input type="text"  class="form-control"  name="company_address" placeholder="Enter You Address ">
        </div>
      </div>
      <div class="form-group row">
        <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12  col-form-label">Pincode:</label>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
          <input type="text"  class="form-control"  name="pincode" placeholder="Enter Your Pincode">
        </div>
      </div>
    <!-- </form> -->
  </div>
</div> 

<div class="col-lg-6 col-md-6 col-sm-10 col-xs-12">
  <div class="newlog">
    <h3>Product Details</h3><br>
    <!-- <form> -->
      <div class="form-group row">
        <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12  col-form-label">Category :</label>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
          <select class="form-control" name="category">
           <option value="">Select Category</option>
           <option value="1">Grocery</option>
           <option value="1">Food</option>
           <option value="1">Fresh Fruits</option>
           
         </select>
       </div>
     </div>

     <div class="form-group row">
      <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12  col-form-label">Goods/Services Being Offered :</label>
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <input type="text"  class="form-control"  name="goods" placeholder="Goods/Services Being Offered" required>
      </div>
    </div>


    <div class="form-group row">
      <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12  col-form-label">Period in Distributorship / Manufacturing /Import:</label>
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <input type="text"  class="form-control"  name="distributorship" placeholder="Enter Your Telephone No" >
      </div>
    </div>
    <div class="form-group row">
      <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12  col-form-label">Area Covered:</label>
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <input type="text"  class="form-control"  name="area_covered" placeholder="Area Covered ">
      </div>
    </div>
    <div class="form-group row">
      <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12  col-form-label">Annual Turnover:</label>
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <input type="text"  class="form-control"  name="annual_turnover" placeholder="Annual Turnover">
      </div>
    </div>
    <div class="form-group row">
      <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12  col-form-label">NMMC Cess No. (If any) :</label>
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <input type="text"  class="form-control"  name="nmmc_no" placeholder="NMMC Cess No">
      </div>
    </div>
    <div class="form-group row">
      <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12  col-form-label">What Products do you do?:</label>
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 form">
        <textarea class="text-area w-input" id="field" maxlength="5000" name="products_do" placeholder="textarea" required="required"></textarea>
      </div>
    </div>

    <div class="form-group row">
      <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12  col-form-label">Add One+One:</label>
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 form">
        <input type="text"  class="form-control"  name="add_one" placeholder="Add " > 
      </div>
    </div>

    <div class="form-group row">
      <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-4 col-xs-12  col-form-label">Validation Code:</label>
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 form">
        <input type="text"  class="form-control"  name="validation_code" placeholder="Captcha" > 
      </div>
    </div>
    <div class="Continue">
      <input type="submit" class="btn-nowe"> 
    </div>
  </form>
</div>
</div>
</div>
<div class="tab-pane" id="3b">
  <h3>India</h3>
</div>
<div class="tab-pane" id="4b">
  <h3>Overseas</h3>
</div>
</div>
</div>

</div>
</div>

<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix visible-xs">&nbsp;</div>
<script type="text/javascript">
  $(function(){

    $("#add_form").validate({

      errorClass: "error-msg",
      ignore: [],
      errorElement:'div',
      rules: {
        name:{
          required: true,
        },
         website:{
          required: true,
          url:true
        },
         first_name:{
          required: true,
        },
         last_name:{
          required: true,
        },
         email:{
          email:true,
          required: true,
        },
         mobile:{
          digits:true,
          required: true,
        },
         telephone:{
          digits:true,
          required: true,
        },
         state:{
          required: true,
        },
         city:{
          required: true,
        },
         location:{
          required: true,
        },
         company_address:{
          required: true,
        },
         pincode:{
          digits:true,
          required: true,
        },
         category:{
          required: true,
        },
         goods:{
          required: true,
        },
         pan:{
          required: true,
          digits:true,
        },
         gst_no:{
          digits:true,
          required: true,
        },
         gst_register:{
          digits:true,
          required: true,
        },
         distributorship:{
          required: true,
        },
         area_covered:{
          required: true,
        },
         annual_turnover:{
          required: true,
        },
         nmmc_no:{
          required: true,
        },
         field:{
          required: true,
        },
        add_one:{
          required: true,
        },
        validation_code:{
          required: true,
        },
              
              }

            });

    $("#overseas").validate({

      errorClass: "error-msg",
      ignore: [],
      errorElement:'div',
      rules: {
        Company_name:{
          required: true,
        },
         website:{
          required: true,
          url:true
        },
         first_name:{
          required: true,
        },
         last_name:{
          required: true,
        },
         email:{
          email:true,
          required: true,
        },
         mobile:{
          digits:true,
          required: true,
        },
         telephone:{
          digits:true,
          required: true,
        },
         state:{
          required: true,
        },
         city:{
          required: true,
        },
         location:{
          required: true,
        },
         company_address:{
          required: true,
        },
         pincode:{
          digits:true,
          required: true,
        },
         category:{
          required: true,
        },
         goods:{
          required: true,
        },
         pan:{
          required: true,
        },
         gst_no:{
          required: true,
        },
         gst_register:{
          required: true,
        },
         distributorship:{
          required: true,
        },
         area_covered:{
          required: true,
        },
         annual_turnover:{
          digits:true,
          required: true,
        },
         nmmc_no:{
          required: true,
        },
         field:{
          required: true,
        },
        add_one:{
          required: true,
        },
        validation_code:{
          required: true,
        },
              
              }

            });
    
  });
</script>