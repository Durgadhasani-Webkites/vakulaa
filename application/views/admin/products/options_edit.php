<table class="table">
    <thead>
    <tr class="primary">
        <td width="27%" height="45"><strong>Option Value</strong></td>
        <td width="22%"><strong>Stock</strong></td>
        <td width="10%" align="right"><strong>Price</strong></td>
        <td width="41%">&nbsp;</td>
    </tr>
    </thead>
    <tbody>
    <?php
    if(!empty($options_view)) {
        foreach ($options_view as $key=>$options) {
            if(isset($open_optionsedit_exists[$key]['stock'])) {
                $openstock=$open_optionsedit_exists[$key]['stock'];
            } else {
                $openstock="Yes";
            }

            if(isset($open_optionsedit_exists[$key]['price_prefix'])) {
                $openprefix=$open_optionsedit_exists[$key]['price_prefix'];
            } else {
                $openprefix="+";
            }

            if(isset($open_optionsedit_exists[$key]['price'])) {
                $openprice=$open_optionsedit_exists[$key]['price'];
            } else {
                $openprice="";
            }
            ?>
            <tr>
                <td height="45"><?php echo $options['option_value_name']; ?>
                    <input type="hidden" name="option_id[]" id="option_id" class="form-control" style="width:100px;" value="<?php echo $options['id']; ?>" />
                </td>
                <td>
                    <select class="form-control" name="stockopt[]" id="stockopt" style="width:100px;" >
                        <option value="Yes" <?php if($openstock=='Yes') { ?>selected="selected"<?php } ?> >Yes</option>
                        <option value="No" <?php if($openstock=='No') { ?>selected="selected"<?php } ?> >No</option>
                    </select>            </td>
                <td>
                    <select class="form-control" name="price_prefix[]" id="price_prefix" style="width:100px;" >
                        <option value="+" <?php if($openprefix=='+') { ?>selected="selected"<?php } ?> >+</option>
                        <option value="-" <?php if($openprefix=='-') { ?>selected="selected"<?php } ?> >-</option>
                    </select></td>
                <td><input type="text" name="priceopt[]" id="priceopt" value="<?php echo $openprice; ?>" class="form-control" style="width:100px;" /></td>
            </tr>
        <?php
        }
    }
    ?>
    </tbody>
</table>
