<!-- Start: Topbar -->
<header id="topbar" class="alt">
    <div class="topbar-left">
        <ol class="breadcrumb">
            <li class="crumb-icon">
                <a href="<?php echo base_url('admin/index/dashboard'); ?>">
                    <span class="glyphicon glyphicon-home"></span>
                </a>
            </li>
            <li class="crumb-trail">Products</li>
            <li class="crumb-link">
                <a href="#">Edit</a>
            </li>

        </ol>
    </div>

</header>
<!-- End: Topbar -->

<?php
if(isset($admin_results) && !empty($admin_results)) {
    foreach ($admin_results as $rows) {
        $proid=$rows['id'];
        $product_name=$rows['product_name'];
        $product_code=$rows['product_code'];
        $what_is_it=$rows['what_is_it'];
        $what_is_contains=$rows['what_is_contains'];
        $how_to_prepare=$rows['how_to_prepare'];
        $detailpage_heading1=$rows['detailpage_heading1'];
        $detailpage_heading2=$rows['detailpage_heading2'];
        $detailpage_heading3=$rows['detailpage_heading3'];
        $coupon_arr=explode(',',$rows['coupon']);
        $meta_title=$rows['meta_title'];
        $meta_description=$rows['meta_description'];
        $meta_keyword=$rows['meta_keyword'];
        $product_tags=explode(",",$rows['product_tags']);
        foreach($product_tags as $value){
            $product_tags_arr[]="'".addslashes($value)."'";
        }
        $product_tags=implode(",",$product_tags_arr);
        $product_image=$rows['product_image'];
        $hsn_number=$rows['hsn_number'];
        $sgst=$rows['sgst'];
        $cgst=$rows['cgst'];
        $price=$rows['price'];
        $actual_price_single=$rows['actual_price_single'];
        $is_product_variable=$rows['is_product_variable'];
        $weight=$rows['weight'];
        $weight_class=$rows['weight_class'];
        $weight_price=$rows['weight_price'];
        $quantity=$rows['quantity'];
        $weight_shipping_single=$rows['weight_shipping_single'];
        $minimum_quantity=$rows['minimum_quantity'];
        $stock=$rows['stock'];
        $seo_keyword=$rows['seo_keyword'];
        $sort_order=$rows['sort_order'];
        $status=$rows['status'];
       
       
    }
}
?>

<!-- Begin: Content -->
<section id="content" class="">

<form  id="product_frm" action="<?php echo base_url('admin/products/process_edit'); ?>" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
<!-- dashboard tiles -->
<input type="hidden" name="proid" id="proid" class="form-control" value="<?php echo $proid; ?>">
<?php if(isset($offset)){?>
<input type="hidden" name="offset" class="form-control" value="<?php echo $offset; ?>">
<?php } ?>
<div class="row">
    <div class="col-md-10">
        <h4> Edit Product</h4>
    </div>
    <div class="col-md-2">
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Save
            </button>
        </div>
        <div class="col-md-6">
            <?php
            $back_url='admin/products';
            if(isset($_SERVER['QUERY_STRING'])){
                $back_url .= '?'.$_SERVER['QUERY_STRING'];
             }
            ?>
            <a class="btn btn-primary" href="<?php echo base_url($back_url); ?>">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
</div>

<hr class="alt short">
<br/>
<?php echo validation_errors(); ?>
<div class="row">
<div class="col-md-12">
<div class="bs-component">
<div class="panel">
<div class="panel-heading">
    <ul class="nav panel-tabs-border panel-tabs panel-tabs-left">
        <li class="active">
            <a href="#general" data-toggle="tab">General</a>
        </li>
        <li>
            <a href="#data" data-toggle="tab">Data</a>
        </li>
        <li>
            <a href="#links" data-toggle="tab">Links</a>
        </li>

        <li>
            <a href="#attributes" data-toggle="tab">Attributes</a>
        </li>
        <li>
            <a href="#options" data-toggle="tab">Option</a>
        </li>
        <li>
            <a href="#offers" data-toggle="tab">Offers</a>
        </li>
        <li>
            <a href="#images" data-toggle="tab">Image</a>
        </li>
    </ul>
</div>
<div class="panel-body">
<div class="tab-content pn br-n">
<div id="general" class="tab-pane active">
    <div class="form-group">
        <label class="col-lg-2 control-label text-left">Product Name<span class="mandatory">*</span> </label>
        <div class="col-lg-10">
            <input type="text" name="product_name" placeholder="Enter product name" class="form-control" value="<?php echo $product_name; ?>" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label text-left">Product Code<span class="mandatory">*</span></label>
        <div class="col-lg-10">
            <input type="text" name="product_code" placeholder="Enter product code" class="form-control" value="<?php echo $product_code; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label text-left"><?php echo $detailpage_heading1 ?>
            <input type="text" name="detailpage_heading1" value="<?php echo $detailpage_heading1 ?>">
        </label>
        <div class="col-lg-10">
            <textarea name="what_is_it" class="summernote form-control"  rows="3"><?php echo $what_is_it; ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label text-left"><?php echo $detailpage_heading2 ?>
            <input type="text" name="detailpage_heading2" value="<?php echo $detailpage_heading2 ?>">
        </label>
        <div class="col-lg-10">
            <textarea name="what_is_contains" class="summernote form-control"  rows="3"><?php echo $what_is_contains; ?></textarea>
        </div>
    </div>
    <div class="form-group">
            <label class="col-lg-2 control-label text-left"><?php echo $detailpage_heading3 ?>
                <input type="text" name="detailpage_heading3" value="<?php echo $detailpage_heading3 ?>">
            </label>
            <div class="col-lg-10">
                <textarea name="how_to_prepare" class="summernote form-control"  rows="3"><?php echo $how_to_prepare; ?></textarea>
            </div>
        </div>
    <div class="form-group">
        <label class="col-lg-2 control-label text-left">Meta title</label>
        <div class="col-lg-10">
            <input type="text" name="meta_title" placeholder="Enter meta title" class="form-control" value="<?php echo $meta_title; ?>" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label text-left">Meta description</label>
        <div class="col-lg-10">
            <textarea name="meta_description" class="form-control"  rows="3"><?php echo $meta_description; ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label text-left">Meta keywords</label>
        <div class="col-lg-10">
            <textarea name="meta_keywords" class="form-control"  rows="3"><?php echo $meta_keyword; ?></textarea>
        </div>
    </div>
</div>
<div id="data" class="tab-pane">
    <?php if($product_image!="") { ?>
        <div class="col-lg-2">&nbsp;</div>
        <div class="col-lg-10">
            <img src="<?php echo $this->config->item('upload');?>products/<?php echo $product_image; ?>" height="100" />
        </div>
    <?php } ?>
    <div class="form-group">
        <label class="col-lg-2 control-label text-left">Thumb Image<span class="mandatory">*</span></label>
        <div class="col-lg-10 admin-form">
            <label class="field prepend-icon append-button file">
                <span class="button">Choose File</span>
                <input type="file" class="gui-file" name="thumb_image" id="thumb_image" />
                <input type="text" class="gui-input" id="thumb_image_uploader" placeholder="Please Select A File">
                <label class="field-icon">
                    <i class="fa fa-upload"></i>
                </label>
            </label>
            <span class="note">(Note: Upload image of width greater than 400px and height greater than 400px )</span>
            <em class="state-error" for="thumb_image"></em>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label text-left">Quantity<span class="mandatory">*</span></label>
        <div class="col-lg-10">
            <div class="input-group">
                <input name="quantity" class="form-control" value="<?php echo $quantity; ?>" />
                <b> Note: </b>. Fill this only if there is no options for this product

            </div>
        </div>
    </div>

      <div class="form-group">
            <label class="col-lg-2 control-label text-left">Weight for shipping<span class="mandatory">*</span></label>
            <div class="col-lg-4">
              <input name="weight_shipping_single" class="form-control"  value="<?php echo $weight_shipping_single; ?>" />
              <b> Note: </b>Mention weight in grams. Fill this only if there is no options for this product

            </div>
        </div>
    <div class="form-group">
        <label class="col-lg-2 control-label text-left">HSN Number<span class="mandatory">*</span></label>
        <div class="col-lg-10">
            <input type="text" name="hsn_number" placeholder="Enter HSN Number" class="form-control" value="<?php echo $hsn_number; ?>">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-md-2 control-label text-left">SGST<span class="mandatory">*</span></label>
        <div class="col-md-4 multiSelectBox">
            <select name="sgst" class="single">
                <option value="">---Select---</option>
                <?php if(!empty($sgst_res)){
                    foreach($sgst_res as $k=>$v){?>
                        <option value="<?php echo $v['id']; ?>" <?php echo($sgst==$v['id'])?'selected="selected"':''; ?>><?php echo $v['tax_name']; ?></option>
                    <?php } } ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label  class="col-md-2 control-label text-left">CGST<span class="mandatory">*</span></label>
        <div class="col-md-4 multiSelectBox">
            <select name="cgst" class="single">
                <option value="">---Select---</option>
                <?php if(!empty($cgst_res)){
                    foreach($cgst_res as $k=>$v){?>
                        <option value="<?php echo $v['id']; ?>" <?php echo($cgst==$v['id'])?'selected="selected"':''; ?>><?php echo $v['tax_name']; ?></option>
                    <?php } } ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label text-left">Price  (This is  selling price)<span class="mandatory">*</span></label>
        <div class="col-lg-4">
            <input type="text" name="price" placeholder="Enter price" class="form-control" value="<?php echo $price; ?>" />
        </div>
    </div>
    <div class="form-group">
            <label class="col-lg-2 control-label text-left">Actual Price (This is not selling price)<span class="mandatory">*</span></label>
            <div class="col-lg-4">
                <input type="text" name="actual_price_single" placeholder="Enter actual price" class="form-control"  value="<?php echo $actual_price_single; ?>">
            </div>
        </div>


    <!-- <div class="form-group">
        <div class="col-md-12">
            <input type="checkbox" name="is_product_variable" id="is_product_variable" value="1" <?php echo ($is_product_variable==1)?'checked="checked"':''; ?>>
            <label  for="is_product_variable" class="control-label text-left">Is this product is variable?</label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label text-left">Weight</label>
        <div class="col-lg-4">
            <input type="text" name="weight" placeholder="Enter Weight" class="form-control" value="<?php echo $weight; ?>" >
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label text-left">Weight Class</label>
        <div class="col-lg-4 multiSelectBox">
            <select name="weight_class" class="single">
                <option value="">---Select---</option>
                <option value="g" <?php echo ($weight_class=='g')?'selected="selected"':''; ?>>Gram</option>
                <option value="kg" <?php echo ($weight_class=='kg')?'selected="selected"':''; ?>>Kilogram</option>
                <option value="ml" <?php echo ($weight_class=='ml')?'selected="selected"':''; ?>>Millilitre</option>
                <option value="l" <?php echo ($weight_class=='l')?'selected="selected"':''; ?>>Litre</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label text-left">Weight Price</label>
        <div class="col-lg-4">
            <input type="text" name="weight_price" placeholder="Enter Weight Price" class="form-control" value="<?php echo $weight_price; ?>">
        </div>
    </div> -->
    <div class="form-group">
        <label  class="col-md-2 control-label text-left">Stock</label>
        <div class="col-md-4 multiSelectBox">
            <select name="stock" class="single">
                <option value="yes" <?php echo($stock=='yes')?'selected="selected"':''; ?>>Yes</option>
                <option value="no"  <?php echo($stock=='no')?'selected="selected"':''; ?>>No</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label text-left">Tags</label>
        <div class="col-lg-10">
            <input type="text" name="tags" id="tagmanager" class="form-control tm-input" placeholder="Enter tags">
            <div class="tag-container tags"></div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label text-left">Sort Order</label>
        <div class="col-lg-10">
            <input type="text" name="sort_order" placeholder="Enter sort order" class="form-control" value="<?php echo $sort_order; ?>">
        </div>
    </div>

    <div class="form-group">
        <label  class="col-md-2 control-label text-left">Status</label>
        <div class="col-md-4 multiSelectBox">
            <select name="status" class="single" >
                <option value="2" <?php echo ($status==2)?'selected="selected"':''; ?> >Enabled</option>
                <option value="1" <?php echo ($status==1)?'selected="selected"':''; ?> >Disabled</option>
            </select>
        </div>
    </div>
  
</div>
<div id="links" class="tab-pane">
    <?php
    $categoryexists=[];
   
    if(!empty($category_view_exists)){
        foreach($category_view_exists as $categoryviewexists){
            $categoryexists[]=$categoryviewexists['category_id'];
        }
    }
   
    ?>
    <?php
    $filterexists=[];
    if(!empty($filter_view_exists)){
        foreach($filter_view_exists as $filterviewexists){
            $filterexists[]=$filterviewexists['filter_group_id']."_".$filterviewexists['filter_id'];
        }
    }
    ?>
    <div class="form-group">
        <label  class="col-md-2 control-label text-left">Categories<span class="mandatory">*</span></label>
       
        <div class="col-md-8 multiSelectBox">
            <select name="categories[]" class="multiple categories" multiple="multiple">
            
                <?php
                if(!empty($category_view)) {

                    foreach ($category_view as $key => $value) {
                        ?>
                        <option value="<?php echo $key; ?>" <?php echo(!empty($categoryexists) && in_array($key, $categoryexists))?'selected="selected"':''; ?> ><?php echo $value; ?></option>
                    <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label  class="col-md-2 control-label text-left">Filters</label>
        <div class="col-md-8 multiSelectBox">
            <select name="filters[]" class="multiple filterslist" multiple="multiple">
                <?php
                if(!empty($filter_view)) {
                    foreach($filter_view as $filter) {
                        $filterid=$filter['filter_group_id']."_".$filter['filter_id'];
                        ?>
                        <option value="<?php echo $filterid; ?>" <?php echo(!empty($filterexists) && in_array($filterid, $filterexists))?'selected="selected"':''; ?> ><?php echo $filter['filter_group_name']; ?> - <?php echo $filter['filter_name']; ?></option>
                    <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label  class="col-md-2 control-label text-left">Coupon</label>
        <div class="col-md-8 multiSelectBox">
            <select name="coupon[]" class="multiple" multiple="multiple">
                <?php
                if(!empty($special_coupons)) {
                    foreach ($special_coupons as $k => $v) {
                        ?>
                        <option value="<?php echo $v['id']; ?>" <?php echo(!empty($coupon_arr) && in_array($v['id'],$coupon_arr))?'selected="selected"':''; ?>><?php echo $v['coupon_code']; ?></option>
                    <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>

</div>
<div id="attributes" class="tab-pane">
    <div class="form-group">
        <div class="col-md-12 text-center">
            <table class="table">
                <thead>
                <tr class="info">
                    <th>Attribute</th>
                    <th>Text</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($attribute_view_exists)){
                foreach($attribute_view_exists as $attributeviewexists){
                $attributeexistsid=$attributeviewexists['id'];
                $attributeidexists=$attributeviewexists['attribute_group_id']."_".$attributeviewexists['attribute_id'];
                $attributetextexists=$attributeviewexists['attribute_text'];
                ?>
                <tr class="table-row">
                    <td>
                        <div class="multiSelectBox">
                            <select name="attribute_label[]" class="single">
                                <?php
                                if(!empty($attribute_view)) {
                                    foreach($attribute_view as $attribute) {
                                        $attributeid=$attribute['attribute_group_id']."_".$attribute['id'];
                                        ?>
                                        <option value="<?php echo $attributeid; ?>" <?php echo($attributeid==$attributeidexists)?'selected="selected"':''; ?> ><?php echo $attribute['attribute_group_name']; ?> - <?php echo $attribute['attribute_name']; ?></option>
                                    <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </td>
                    <td>
                        <textarea name="attribute_desc[]" class="form-control"  rows="3"><?php echo $attributetextexists; ?></textarea>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger remove_more">
                            <i class="fa fa-minus"></i>
                        </button>
                    </td>
                </tr>
                <?php } } ?>
                <tr class="table-row">
                    <td>
                        <div class="multiSelectBox">
                            <select name="attribute_label[]" class="single">
                                <option value="">--none--</option>
                                <?php
                                if(!empty($attribute_view)) {
                                    foreach($attribute_view as $attribute) {
                                        ?>
                                        <option value="<?php echo $attribute['attribute_group_id']; ?>_<?php echo $attribute['id']; ?>" <?php echo set_select('attributes', $attribute['id']); ?> ><?php echo $attribute['attribute_group_name']; ?> - <?php echo $attribute['attribute_name']; ?></option>
                                    <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </td>
                    <td>
                        <textarea name="attribute_desc[]" class="form-control"  rows="3"></textarea>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary add_more">
                            <i class="fa fa-plus"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>
<div id="options" class="tab-pane">
    <?php
    $optionid="0";
    $mainoptionid="0";
    if(!empty($option_view_exists)){
        foreach($option_view_exists as $optionviewexists){
            $optionid=$optionviewexists['id'];
            $mainoptionid=$optionviewexists['option_id'];
        }
    }
    ?>
    <div class="form-group">
        <input type="hidden" name="idopt" id="idopt" class="form-control" value="<?php echo $optionid; ?>">
        <label  class="col-md-2 control-label text-left">Option Name</label>
        <div class="col-md-4 multiSelectBox">
            <select name="option" class="single selectoption">
                <option value="">--none--</option>
                <?php
                if(!empty($option_view)) {
                    foreach($option_view as $option) {
                        ?>
                        <option value="<?php echo $option['id']; ?>" <?php echo($mainoptionid==$option['id'])?'selected="selected"':''; ?> ><?php echo $option['option_name']; ?></option>
                    <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="options_data">

        </div>
    </div>

</div>
<div id="offers" class="tab-pane">
    <div class="form-group">
        <div class="col-md-12 text-center">
            <table class="table">
                <thead>
                <tr class="info">
                    <th>Product Option</th>
                    <th>Offer Product</th>
                    <th>Offer Option</th>
                    <th>Offer Quantity</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($offer_products)){
                    foreach($offer_products as $k=>$v){
                        ?>
                        <tr class="offers-row">
                            <td>
                                <select name="product_option_id[]" class="select2-single product_option_select2 form-control">
                                    <option value="<?php echo $v['product_option_id']; ?>" selected="selected" ><?php echo $v['option_value_name']; ?></option>
                                </select>
                            </td>
                            <td>
                                <select name="offer_product_id[]" class="select2-single offer_product_select2 form-control">
                                    <option value="">--none--</option>
                                    <option value="<?php echo $v['offer_product_id']; ?>" selected="selected" ><?php echo $v['offer_product_name']; ?></option>
                                </select>
                            </td>
                            <td>
                                <select name="offer_option_id[]" class="select2-single offer_option_select2 form-control">
                                    <option value="">--none--</option>
                                    <option value="<?php echo $v['offer_option_id']; ?>" selected="selected" ><?php echo $v['offer_option_name']; ?></option>
                                </select>
                            </td>
                            <td>
                                <input name="offer_quantity[]" class="form-control" value="<?php echo $v['offer_quantity'] ?>"  />
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger remove_more_offers">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </td>
                        </tr>
                    <?php } } ?>
                <tr class="offers-row">
                    <td>
                        <select name="product_option_id[]" class="select2-single product_option_select2 form-control">
                            <option value="">--none--</option>
                        </select>
                    </td>
                    <td>
                        <select name="offer_product_id[]" class="select2-single offer_product_select2 form-control">
                            <option value="">--none--</option>
                        </select>
                    </td>
                   <td>
                       <select name="offer_option_id[]" class="select2-single offer_option_select2 form-control">
                           <option value="">--none--</option>
                       </select>
                    </td>
                    <td>
                        <input name="offer_quantity[]" class="form-control"  />
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary add_more_offers">
                            <i class="fa fa-plus"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        </div>
</div>
<div id="images" class="tab-pane">
    <div class="form-group">
        <div class="col-md-12">
            <table class="table">
                <thead>
                <tr class="info">
                    <th>Image(size above 700px)</th>
                    <th>Sort Order</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($image_view_exists)){
                foreach($image_view_exists as $imageviewexists){
                $imageid=$imageviewexists['id'];
                $thumb_image=$imageviewexists['thumb_image'];
                $imagesort_order=$imageviewexists['sort_order'];
                ?>
                    <tr class="table-row">
                        <td>
                            <img src="<?php echo $this->config->item('upload');?>products/<?php echo $thumb_image; ?>" />
                        </td>
                        <td>
                            <?php echo $imagesort_order; ?>
                        </td>

                        <td>
                            <button type="button" class="btn btn-danger delete_image" data-ref="<?php echo $imageid; ?>">
                                <i class="fa fa-minus"></i>
                            </button>
                        </td>
                    </tr>
                <?php }
                }
                ?>
                <tr class="table-row">
                    <td>
                        <div class="col-lg-10 admin-form">
                            <label class="field prepend-icon append-button file">
                                <span class="button">Choose File</span>
                                <input type="file" class="gui-file" name="product_images[]" id="product_images" />
                                <input type="text" class="gui-input" id="product_images_uploader1" placeholder="Please Select A File">
                                <label class="field-icon">
                                    <i class="fa fa-upload"></i>
                                </label>
                            </label>
                            <em class="state-error" for="product_images"></em>
                        </div>
                    </td>
                    <td><input type="text" name="product_image_order[]" placeholder="Enter sort order" class="form-control" ></td>
                    <td>
                        <button type="button" class="btn btn-primary add_more">
                            <i class="fa fa-plus"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>
</div>
</div>
</div>
</div>

</div>
</div>

</form>
</section>
<!-- End: Content -->

<!-- Summernote CSS  -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_js');?>plugins/summernote/summernote.css">

<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_js');?>plugins/tagmanager/tagmanager.css">

<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_js');?>plugins/datepicker/css/bootstrap-datetimepicker.css">

<!-- Time/Date Plugin Dependencies -->
<script src="<?php echo $this->config->item('admin_js');?>plugins/globalize/globalize.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/moment/moment.min.js"></script>

<!-- DateTime Plugin -->
<script src="<?php echo $this->config->item('admin_js');?>plugins/datepicker/js/bootstrap-datetimepicker.js"></script>

<!-- Summernote Plugin -->
<script src="<?php echo $this->config->item('admin_js');?>plugins/summernote/summernote.min.js"></script>

<!-- TagManager Plugin -->
<script src="<?php echo $this->config->item('admin_js');?>plugins/tagmanager/tagmanager.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_js');?>plugins/select2/select2.min.css">
<script src="<?php echo $this->config->item('admin_js');?>plugins/select2/select2.min.js"></script>

<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/jquery.validate.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/additional-methods.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        $('.multiSelectBox .multiple').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            allSelectedText: 'All',
            maxHeight: 200,
            includeSelectAllOption: true
        });
        $('.multiSelectBox .single').multiselect({
            enableFiltering: false
        });

        $(document).on('keypress',":input",function(event){
            if (event.which == '10' || event.which == '13') {
                event.preventDefault();
            }
        });

        var _URL = window.URL || window.webkitURL;
        $("#thumb_image").change(function(){
            var  $this=$(this),image, file;

            if ((file = this.files[0])) {

                image = new Image();

                image.onload = function() {

                    $this.siblings('.gui-input').val($this.val());
                };
                image.src = _URL.createObjectURL(file);

            }

        });

        $('.summernote').summernote({
            height: 255,
            focus: false,
            oninit: function() {},
            onChange: function(contents, $editable) {}
        });

        $(".tm-input").tagsManager({
            tagsContainer: '.tags',
            prefilled: [<?php echo $product_tags; ?>],
            tagClass: 'tm-tag-info'
        });

        $('.datetimepicker').datetimepicker({
            format: 'DD-MM-YYYY',
            pickTime:false
        });

        $('.datetimepick').datetimepicker({
            format: 'DD-MM-YYYY hh:mm:ss a',
            pickTime:true
        });


        $("#product_frm").validate({

            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",

            rules: {
                product_name: {
                    required: true
                },
                what_is_it:{
                    required: true
                },
                thumb_image:{
                    extension: "jpg|jpeg|png|JPG|JPEG|PNG"
                },
                'product_images[]':{
                    extension: "jpg|jpeg|png|JPG|JPEG|PNG"
                },
                quantity:{
                    required: true,
                    number:true
                },
                hsn_number:{
                    required: true,
                    alphanumeric:true
                },
                sgst:{
                    required: true
                },
                cgst:{
                    required: true
                },
                price:{
                    required: true
                },
                'categories[]':{
                    required: true
                }
            },
            messages:{
                thumb_image:{
                    extension: "Please upload valid jpg or png images"
                },
                'product_images[]':{
                    extension: "Please upload valid jpg or png images"
                }
            }

        });

        $.ajax({
            type:'post',
            url:'<?php echo base_url('admin/products/open_optionsedit'); ?>',
            data:'id=<?php echo $mainoptionid; ?>&optid=<?php echo $optionid; ?>',
            dataType:'html',
            success: function(response){
                $('.options_data').html(response);
            }
        });

        $('.selectoption').change(function(){
            var option = $(this).find('option:selected').val(),
                urllink='',
                ajaxdata='';
            if(option!=<?php echo $mainoptionid; ?>) {
                urllink='<?php echo base_url('admin/products/open_options'); ?>';
                ajaxdata='id='+option;
            } else {
                urllink='<?php echo base_url('admin/products/open_optionsedit'); ?>';
                ajaxdata='id=<?php echo $mainoptionid; ?>&optid=<?php echo $optionid; ?>';
            }

            $.ajax({
                type:'post',
                url:urllink,
                data:ajaxdata,
                dataType:'html',
                success: function(response){
                    $('.options_data').html(response);
                }
            });

        });

        var $options_data = $(".options_data"),add_images_click=2;
        $options_data.on('click','.add_more',function() {
            var $this=$(this),
                td=$this.closest('td'),
                lastRow=td.find('.row').filter(':last'),
                clonedEle=lastRow.clone(),
                guiFile= clonedEle.find('.gui-file');

            clonedEle.find('input').val('');
            guiFile.attr('id','product_option_images'+add_images_click);
            clonedEle.find("label.file").siblings("em").attr('for','product_option_images'+add_images_click);
            clonedEle.find('.gui-input').attr('id','product_option_images_uploader'+add_images_click);
            clonedEle.find('i').removeClass('fa-plus').addClass('fa-minus');
            clonedEle.find('.add_more').addClass('btn-danger remove_more').removeClass('btn-primary add_more');

            clonedEle.insertAfter(lastRow);
            add_images_click++;
        });

        $options_data.on('click','.remove_more',function() {
            $(this).closest('.row').remove();
        });

        $options_data.on('change','.gui-file',function(){
            var  $this=$(this);
            $this.siblings('.gui-input').val($this.val());
        });


        var product_opt_select2_opt={
            placeholder:'Search for option',
            ajax: {
                url: base_url+"products/get_all_options",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page,
                        limit:20,
                        option_id:$('#options').find('select[name="option"]').val()
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 20) < data.total_count
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) { return markup; },
            minimumInputLength: 0,
            templateResult: formatResult,
            templateSelection: formatSelection
        };
        $(".product_option_select2").select2(product_opt_select2_opt);

        var offer_product_select2_opt={
            placeholder:'Search for product',
            ajax: {
                url: base_url+"products/get_all_products",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page,
                        limit:20
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 20) < data.total_count
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) { return markup; },
            minimumInputLength: 0,
            templateResult: formatResult,
            templateSelection: formatSelection
        };
        $(".offer_product_select2").select2(offer_product_select2_opt).on('select2:select',function(event){
            var value = $(event.currentTarget).find("option:selected").val();
            var selector = $(this).closest('.offers-row').find('.offer_option_select2');
            offer_option_select2_fn(selector,value);
        });


        var offer_option_select2_fn = function($selector,product_id){
            var offer_option_select2_opt={
                placeholder:'Search for option',
                ajax: {
                    url: base_url+"products/get_all_product_options",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term,
                            page: params.page,
                            limit:20,
                            product_id:product_id
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;

                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * 20) < data.total_count
                            }
                        };
                    },
                    cache: true
                },
                escapeMarkup: function (markup) { return markup; },
                minimumInputLength: 0,
                templateResult: formatResult,
                templateSelection: formatSelection
            };
            $selector.select2(offer_option_select2_opt);
        };

        $('.offers-row').find('.offer_option_select2').each(function(){
            var offer_product_select2_val = $(this).closest('.offers-row').find('.offer_product_select2').val();
            offer_option_select2_fn($(this),offer_product_select2_val);

        });


        $(".add_more_offers").click(function(){
            var $this=$(this),
                offersRow=$this.closest('.offers-row'),
                lastoffersRow=$this.closest('table').find('.offers-row').filter(':last'),
                clonedEle=offersRow.clone();
            clonedEle.find('input').val('');
            clonedEle.find('button').removeClass('btn-primary').addClass('btn-danger remove_more_offers');
            clonedEle.find('i').removeClass('fa-plus').addClass('fa-minus');

            var product_option_select2 = '<select name="product_option_id[]"  class="select2-single product_option_select2 form-control"><option value="">---Select Option---</option> </select>';
            var offer_product_select2 = '<select name="offer_product_id[]"  class="select2-single offer_product_select2 form-control"><option value="">---Select Product---</option> </select>';
            var offer_option_select2 = '<select name="offer_option_id[]"  class="select2-single offer_option_select2 form-control"><option value="">---Select Option---</option> </select>';
            clonedEle.find('td:eq(0)').html(product_option_select2);
            clonedEle.find('td:eq(1)').html(offer_product_select2);
            clonedEle.find('td:eq(2)').html(offer_option_select2);
            clonedEle.find(".product_option_select2").select2(product_opt_select2_opt);
            clonedEle.find(".offer_product_select2").select2(offer_product_select2_opt).on('select2:select',function(event){
                var value = $(event.currentTarget).find("option:selected").val();
                var selector = $(this).closest('.offers-row').find('.offer_option_select2');
                offer_option_select2_fn(selector,value);
            });
            var $offer_option_select2 = clonedEle.find(".offer_option_select2");
            var offer_product_select2_val = clonedEle.find(".offer_product_select2").val();

            offer_option_select2_fn($offer_option_select2,offer_product_select2_val);

            clonedEle.insertAfter(lastoffersRow);
        });

        $("table").on('click','.remove_more_offers',function(){
            $(this).closest('.offers-row').remove();
        });


        $(".add_more").click(function(){
            var $this=$(this),
                tableRow=$this.closest('.table-row'),
                lastTableRow=$this.closest('table').find('.table-row').filter(':last'),
                clonedEle=tableRow.clone(),
                guiFile= clonedEle.find('.gui-file');
            clonedEle.find('input').val('');
            clonedEle.find('button').not('.multiselect').removeClass('btn-primary').addClass('btn-danger remove_more');
            clonedEle.find('.multiSelectBox .btn-group').remove();
            clonedEle.find('i').removeClass('fa-plus').addClass('fa-minus');

            guiFile.attr('id','product_images'+add_images_click);
            clonedEle.find("label.file").siblings("em").attr('for','product_images'+add_images_click);
            clonedEle.find('.gui-input').attr('id','product_images_uploader'+add_images_click);

            clonedEle.insertAfter(lastTableRow);
            clonedEle.find('.multiSelectBox .single').multiselect("refresh");
            add_images_click++;
        });

        $("table").on('change','.gui-file',function(){
            var  $this=$(this);
            $this.siblings('.gui-input').val($this.val());
        });

        $("table").on('click','.remove_more',function(){
            $(this).closest('.table-row').remove();
        });


        $('.delete_image').click(function(){
            var $this = $(this),
            status = confirm("Are you sure to delete?");
            if(status==true) {
                var id = $this.attr('data-ref');
                $.ajax({
                    url:'<?php echo base_url(); ?>admin/products/remove_image',
                    type:'post',
                    data:'id='+id,
                    dataType:'json',
                    success:function(response){
                        $('.notify_success').text('Successfully deleted').trigger('click');
                        $this.closest('tr').remove();
                    }
                });

                return true;

            } else {
                return false;
            }
        });


        $(".categories").change(function(){
            var $this=$(this),
                $selectedCat=$this.val(),
                brandSelectBox=$('.brand'),
                filtersSelectBox=$('.filterslist');
            if($selectedCat){
                $.ajax({
                    type:'post',
                    url:'<?php echo base_url('admin/products/get_product_filters_brands'); ?>',
                    data:'cid='+$selectedCat,
                    dataType:'json',
                    success: function(response){
                        if(response){
                            if(response.hasOwnProperty('brands')){
                                brandSelectBox.multiselect();
                                brandSelectBox.multiselect('dataprovider', response.brands);
                            }
                            if(response.hasOwnProperty('filters')){
                                filtersSelectBox.multiselect();
                                filtersSelectBox.multiselect('dataprovider', response.filters);
                            }

                        }else{
                            brandSelectBox.multiselect('dataprovider', '');
                        }

                    }
                });
            }else{
                brandSelectBox.multiselect('dataprovider', '');
            }

        });

    });
    function formatResult (data) {
        return data.name;
    }
    function formatSelection (data) {
        return data.name || data.text;
    }
</script>
<style>
    .select2{
        width:100% !important;
    }
</style>
<!-- END: PAGE SCRIPTS