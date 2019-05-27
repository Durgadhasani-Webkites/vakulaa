<!-- Start: Topbar -->
<header id="topbar" class="alt">
    <div class="topbar-left">
        <ol class="breadcrumb">
            <li class="crumb-icon">
                <a href="<?php echo base_url('admin/index/dashboard'); ?>">
                    <span class="glyphicon glyphicon-home"></span>
                </a>
            </li>
            <li class="crumb-trail">Options</li>
            <li class="crumb-link">
                <a href="">Add New</a>
            </li>

        </ol>
    </div>

</header>
<!-- End: Topbar -->

<!-- Begin: Content -->
<section id="content" class="">

    <form  id="option_frm" action="<?php echo base_url('admin/options/process_add'); ?>" method="post" class="form-horizontal" role="form" >
        <!-- dashboard tiles -->
        <div class="row">
            <div class="col-md-10">
                <h4> Add Options</h4>
            </div>
            <div class="col-md-2">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Save
                    </button>
                </div>
                <div class="col-md-6">
                    <a class="btn btn-primary" href="<?php echo base_url('admin/options'); ?>">
                        <i class="fa fa-eye"></i> View all
                    </a>
                </div>
            </div>
        </div>

        <hr class="alt short">
        <br/>
        <div class="row">
            <div class="form-group">
                <label class="col-lg-2 control-label text-left" for="inputStandard">Option Name<span class="mandatory">*</span></label>
                <div class="col-lg-4">
                    <div class="bs-component">
                        <input type="text" name="option_name" placeholder="Enter option name" class="form-control" value="">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label  class="col-md-2 control-label text-left">Option Type</label>
                <div class="col-md-4 multiSelectBox">
                    <select name="option_type" class="single">
                        <option value="Checkbox">Checkbox</option>
                        <option value="Radio">Radio</option>
                        <option value="Select">Select</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label text-left" for="inputStandard">Sort Order</label>
                <div class="col-lg-4">
                    <div class="bs-component">
                        <input type="text" name="option_order" placeholder="Enter sort order" class="form-control" >
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12 text-center">
                    <table class="table">
                        <thead>
                        <tr class="info">
                            <th>Option Value</th>
                            <th>Sort Order</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="table-row">
                            <td><input type="text" name="option_value[]" placeholder="Enter option value" class="form-control" ></td>
                            <td><input type="text" name="option_value_order[]" placeholder="Enter sort order" class="form-control" ></td>
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
    </form>
</section>
<!-- End: Content -->

<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/jquery.validate.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/additional-methods.min.js"></script>


<script type="text/javascript">
    $(document).ready(function() {

        $('.multiSelectBox .single').multiselect({
            enableFiltering: false
        });

        $("#option_frm").validate({

            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",
            rules: {
                option_name: {
                    required: true
                },
                option_order:{
                    number:true
                }
            },

            highlight: function(element, errorClass, validClass) {
                $(element).closest('div').addClass(errorClass).removeClass(validClass);
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).closest('div').removeClass(errorClass).addClass(validClass);
            },
            errorPlacement: function(error, element) {
                if (element.is(":radio") || element.is(":checkbox")) {
                    element.closest('.option-group').after(error);
                } else {
                    error.insertAfter(element);
                }
            }

        });
        $(".add_more").click(function(){
            var $this=$(this),
                tableRow=$this.closest('.table-row'),
                lastTableRow=$this.closest('table').find('.table-row').filter(':last'),
                clonedEle=tableRow.clone();
            clonedEle.find('input').val('');
            clonedEle.find('button').removeClass('btn-primary').addClass('btn-danger remove_more');
            clonedEle.find('i').removeClass('fa-plus').addClass('fa-minus');
            clonedEle.insertAfter(lastTableRow);
        });
        $("table").on('click','.remove_more',function(){
            $(this).closest('.table-row').remove();
        });


    });
</script>