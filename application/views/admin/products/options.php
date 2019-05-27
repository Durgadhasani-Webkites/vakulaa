<table class="table">
    <thead>
    <tr class="primary">
        <td width="20%" height="45"><strong>Option</strong></td>
        <td width="15%" height="45"><strong>Option Code</strong></td>
        <td width="8%"><strong>Availability</strong></td>
        <td width="8%"><strong>Quantity</strong></td>
        <td width="25%">Images</td>
        <td width="8%"><strong>Actual Price</strong></td>
        <td width="8%"><strong>Selling Price</strong></td>
    </tr>
    </thead>
    <tbody>
    <?php
    if(!empty($options_view)) {
        foreach ($options_view as $k=>$options) {
            $availability = (!empty($open_optionsedit_exists[$options['id']]['availability']))?$open_optionsedit_exists[$options['id']]['availability']:'';
            $option_code = (!empty($open_optionsedit_exists[$options['id']]['option_code']))?$open_optionsedit_exists[$options['id']]['option_code']:'';
            $option_qty = (!empty($open_optionsedit_exists[$options['id']]['option_qty']))?$open_optionsedit_exists[$options['id']]['option_qty']:'';
            $option_weightingrams = (!empty($open_optionsedit_exists[$options['id']]['weightingrams']))?$open_optionsedit_exists[$options['id']]['weightingrams']:'';

            $opt_hsn_number = (!empty($open_optionsedit_exists[$options['id']]['hsn_number']))?$open_optionsedit_exists[$options['id']]['hsn_number']:'';
            $actual_price = (!empty($open_optionsedit_exists[$options['id']]['actual_price']))?$open_optionsedit_exists[$options['id']]['actual_price']:'';
            $selling_price = (!empty($open_optionsedit_exists[$options['id']]['selling_price']))?$open_optionsedit_exists[$options['id']]['selling_price']:'';
            $product_option_images = (!empty($open_optionsedit_exists[$options['id']]['product_option_images']))?$open_optionsedit_exists[$options['id']]['product_option_images']:'';
            $product_option_thumb_images = (!empty($open_optionsedit_exists[$options['id']]['product_option_thumb_images']))?$open_optionsedit_exists[$options['id']]['product_option_thumb_images']:'';
            $product_option_medium_images = (!empty($open_optionsedit_exists[$options['id']]['product_option_medium_images']))?$open_optionsedit_exists[$options['id']]['product_option_medium_images']:'';

            ?>
            <tr>
                <td height="45"><?php echo $options['option_value_name']; ?><br/>
                    <label><input type="radio" name="default_option" value="<?php echo $options['id']; ?>" <?php echo (!empty($open_optionsedit_exists[$options['id']]['default_option']))?'checked="checked"':(($k==0)?'checked="checked"':''); ?>/>Default option</label>
                    <input type="hidden" name="option_id[]" id="option_id" class="form-control" style="width:100px;" value="<?php echo $options['id']; ?>" />
                </td>
                <td>
                    <input type="text" name="option_code[<?php echo $options['id']; ?>]" id="option_code" class="form-control" style="width:100px;" placeholder="Option Code" value="<?php echo $option_code; ?>"/><br/>
                    <input type="text" name="opt_hsn_number[<?php echo $options['id']; ?>]" id="opt_hsn_number" class="form-control" style="width:100px;" placeholder="HSN No" value="<?php echo $opt_hsn_number; ?>"/>
                </td>
                <td>
                    <select class="form-control" name="availability[<?php echo $options['id']; ?>]" id="availability" style="width:100px;" >
                        <option value="" <?php echo set_select('availability', ''); ?> >--Select</option>
                        <option value="Yes" <?php echo set_select('availability', 'Yes',($availability=='Yes')?true:false); ?> >Yes</option>
                        <option value="No" <?php echo set_select('availability', 'No',($availability=='No')?true:false); ?> >No</option>
                    </select>
                </td>
                <td>
                    <input type="text" name="option_qty[<?php echo $options['id']; ?>]" id="option_qty" class="form-control" style="width:100px;" value="<?php echo $option_qty; ?>" placeholder="quantity"/><br/>
                    <input type="text" name="weightingrams[<?php echo $options['id']; ?>]" id="weightingrams" class="form-control" style="width:100px;" value="<?php echo $option_weightingrams;?>" placeholder="weight" />
                    Note:Mention in grams/quantity

                </td>
                <td>
                    <?php
                    if(!empty($product_option_thumb_images)){
                        $product_option_images_arr = explode('__&&__',$product_option_images);
                        $product_option_thumb_images_arr = explode('__&&__',$product_option_thumb_images);
                        $product_option_medium_images_arr = explode('__&&__',$product_option_medium_images);
                    foreach($product_option_thumb_images_arr as $k=>$thumb_image){

                    ?>
                    <div class="row">
                        <input type="hidden" name="product_option_images[<?php echo $options['id']; ?>]" value="<?php echo $product_option_images_arr[$k]; ?>" />
                        <input type="hidden" name="product_option_thumb_images[<?php echo $options['id']; ?>]" value="<?php echo $thumb_image; ?>" />
                        <input type="hidden" name="product_option_medium_images[<?php echo $options['id']; ?>]" value="<?php echo $product_option_medium_images_arr[$k]; ?>" />
                        <div class="col-lg-10 admin-form">
                           <img src="<?php echo $this->config->item('upload'); ?>product_option_images/<?php echo $thumb_image; ?>"/>
                        </div>
                        <div class="col-lg-2">
                            <div class="clearfix">&nbsp;</div>
                            <div class="clearfix">&nbsp;</div>
                            <button type="button" class="btn btn-danger remove_more">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <?php  } } ?>
                    <div class="row">
                        <div class="col-lg-10 admin-form">
                            <label class="field prepend-icon append-button file">
                                <span class="button">Choose File</span>
                                <input type="file" class="gui-file" name="product_option_images[<?php echo $options['id']; ?>][]" id="product_option_images_<?php echo $options['id']; ?>">
                                <input type="text" class="gui-input" id="product_option_images_uploader1" placeholder="Please Select A File">
                                <label class="field-icon">
                                    <i class="fa fa-upload"></i>
                                </label>
                            </label>
                            <em class="state-error" for="product_option_images"></em>
                        </div>
                        <div class="col-lg-2">
                            <button type="button" class="btn btn-primary add_more">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </td>
                <td><input type="text" name="actual_price[<?php echo $options['id']; ?>]" id="actual_price" class="form-control" style="width:100px;" value="<?php echo $actual_price; ?>"/></td>
                <td><input type="text" name="selling_price[<?php echo $options['id']; ?>]" id="selling_price" class="form-control" style="width:100px;" value="<?php echo $selling_price; ?>" /></td>

            </tr>
        <?php
        }
    }
    ?>
    </tbody>
</table>