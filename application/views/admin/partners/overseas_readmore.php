<!-- Start: Topbar -->
<style type="text/css">
    .
</style>
<header id="topbar" class="ph10">
<div class="topbar-left">

        <ul class="nav nav-list nav-list-topbar pull-left">
            <li class="active">
                <a href="<?php echo base_url(); ?>admin/partners/overseas">Overseas Details</a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>admin/partners">Contact Details</a>
            </li>
        </ul>

    </div>
</header><!-- End: Topbar --><!-- Begin: Content -->


<!-- Begin: Content -->
<section id="content" style="background-color: white;">

    <!-- dashboard tiles     color: black;
    font-weight: 600;-->

<div class="container">
<div class="col-md-6">
         <table class="table table-striped table-bordered">
                <tbody>
        <?php 
            foreach($admin_results as $admin_details){ ?>
                 
                  <tr>
                      <th class="">Organistaion</th>
                      <td class=""><?php echo $admin_details['Company_name']?></td>
                  </tr>
                  <tr>
                      <th class="">Website</th>
                      <td class=""><?php echo $admin_details['website']?></td>
                  </tr>
                   <tr>
                      <th class="">First_Name</th>
                      <td class=""><?php echo $admin_details['first_name']?></td>
                  </tr>
                  <tr>
                      <th class="">Last_Name</th>
                      <td class=""><?php echo $admin_details['last_name']?></td>
                  </tr>
                  <tr>
                      <th class="">Email</th>
                      <td class=""><?php echo $admin_details['email']?></td>
                  </tr>
                  <tr>
                      <th class="">Mobile</th>
                      <td class=""><?php echo $admin_details['mobile']?></td>
                  </tr>
                  <tr>
                      <th class="">Telephone</th>
                      <td class=""><?php echo $admin_details['telephone']?></td>
                  </tr>
     <!--              <tr>
                      <th class="">State</th>
                      <td class=""><?php echo $admin_details['state']?></td>
                  </tr> -->
                   <tr>
                      <th class="">City</th>
                      <td class=""><?php echo $admin_details['city']?></td>
                  </tr>
                  <tr>
                      <th class="">Company Address</th>
                      <td class=""><?php echo $admin_details['company_address']?></td>
                  </tr>
                  <tr>
                      <th class="">Pincode</th>
                      <td class=""><?php echo $admin_details['pincode']?></td>
                  </tr>

                        </tbody>
                  </table>
                  </div>
                   <?php
                   }
                   ?>
                  <div class="col-md-6">
                    <table class="table table-striped table-bordered">
                <tbody>
                  <?php 
                  foreach($admin_results as $admin_details){ ?>
                  <tr>
                      <th class="">Category</th>
                      <td class=""><?php echo $admin_details['category']?></td>
                  </tr>
                  <tr>
                      <th class="">Goods</th>
                      <td class=""><?php echo $admin_details['goods']?></td>
                  </tr>
                   <tr>
                      <th class="">Location</th>
                      <td class=""><?php echo $admin_details['location']?></td>
                  </tr>
                  <tr>
                      <th class="">Distributorship</th>
                      <td class=""><?php echo $admin_details['distributorship']?></td>
                  </tr>
                  <tr>
                      <th class="">Area Covered</th>
                      <td class=""><?php echo $admin_details['area_covered']?></td>
                  </tr>
                  <tr>
                      <th class="">Annual Turn Over</th>
                      <td class=""><?php echo $admin_details['annual_turnover']?></td>
                  </tr>
                   <tr>
                      <th class="">Field</th>
                      <td class=""><?php echo $admin_details['products_do']?></td>
                  </tr>
                  <tr>
                      <th class="">Nmmc No</th>
                      <td class=""><?php echo $admin_details['nmmc_no']?></td>
                  </tr>
                  <tr>
                      <th class="">Add_One</th>
                      <td class=""><?php echo $admin_details['add_one']?></td>
                  </tr>
                  <tr>
                      <th class="">Validation Code</th>
                      <td class=""><?php echo $admin_details['validation_code']?></td>
                  </tr>
             
</div>
        <?php
        }
        ?>
    

        </tbody>
    </table>
   </div>

</section>

