<!-- Start: Topbar -->
<header id="topbar" class="ph10">
    <div class="text-center"><h4>Products</h4>
        <hr class="alt short">
    </div>
    <div class="topbar-left">
        <ul class="nav nav-list nav-list-topbar pull-left">
            <li><a href="<?php echo base_url(); ?>admin/products/add">Add</a></li>
            <li class="active"><a href="<?php echo base_url(); ?>admin/products">View</a></li>
        </ul>
    </div>
</header><!-- End: Topbar --><!-- Begin: Content -->
<section id="content" class="table-layout animated fadeIn">
    <div class="row">
        <div class="panel">
            <div class="panel-body pn">
                <form id="search_frm" method="get" class="form-horizontal" role="form">
                    <?php  if(isset($_GET['stock'])){?>
                    <input type="hidden" name="stock" value="<?php echo $_GET['stock']; ?>" />
                    <?php } ?>

                    <div class="clearfix">&nbsp;</div>
                    <div class="row ph15 mb10">
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <h5>
                                <small>Product Code</small>
                            </h5>
                            <input type="text" name="product_code" id="product_code" class="form-control"
                                   placeholder="Search product code"
                                   value="<?php echo (isset($_GET['product_code'])) ? $_GET['product_code'] : ''; ?>">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <h5>
                                <small>Product Name</small>
                            </h5>
                            <input type="text" name="product_name" id="product_name" class="form-control"
                                   placeholder="Search product name"
                                   value="<?php echo (isset($_GET['product_name'])) ? $_GET['product_name'] : ''; ?>">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <h5>
                                <small>Status</small>
                            </h5>
                            <select name="status" id="status" class="form-control">
                                <option value="">Select</option>
                                <option
                                    value="2" <?php echo (isset($_GET['status']) && ($_GET['status'] == '2')) ? 'selected="selected"' : ''; ?>>
                                    Active
                                </option>
                                <option
                                    value="1" <?php echo (isset($_GET['status']) && ($_GET['status'] == '1')) ? 'selected="selected"' : ''; ?>>
                                    InActive
                                </option>
                            </select></div>
                        <div class="clearfix visible-sm">&nbsp;</div>
                    </div>
                    <div class="clearfix">&nbsp;</div>
                    <div class="row ph15 mb10">
                        <div class="col-lg-1 col-md-3 col-sm-6 col-xs-12"><input type="submit"
                                                                                 class="btn btn-success btn-block"
                                                                                 id="search_stud" value="Search"></div>
                        <div class="clearfix visible-xs">&nbsp;</div>
                        <?php
                        $clear_url = base_url().'admin/products';
                        if(isset($_GET['stock'])){
                            $clear_url.='?stock='.$_GET['stock'];
                         } ?>
                        <div class="col-lg-1 col-md-3 col-sm-6 col-xs-12"><a
                                href="<?php echo $clear_url; ?>" class="btn btn-default btn-block"
                                id="clear">Clear</a></div>
                    </div>
                    <div class="clearfix">&nbsp;</div>
                </form>
                <form id="action_frm" action="<?php echo base_url('admin/products/process_action'); ?>" method="post"
                      class="form-horizontal" role="form">
                    <?php if(isset($_GET['offset'])){?>
                    <input type="hidden" name="offset" value="<?php echo (isset($_GET['offset'])) ? $_GET['offset'] : ''; ?>" />
                    <?php } ?>
                    <table class="table responsive admin-form theme-warning dtr-inline fs13" id="datatable">
                        <thead>
                        <tr class="bg-light">
                            <th class="text-center mobile-l mobile-p tablet-l tablet-p desktop" width="5%"><label
                                    class="option block mn"> <input type="checkbox" id="check_all" class="mul_ch"> <span
                                        class="checkbox mn"></span> </label></th>
                            <th class="mobile-l mobile-p tablet-l tablet-p desktop">Product Name</th>
                            <th class="tablet-l tablet-p desktop">Stock</th>
                            <th class="tablet-l desktop">Created</th>
                            <th class="tablet-l desktop">Status</th>
                            <th class="tablet-l tablet-p desktop" width="10%">Action</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <div class="clearfix">&nbsp;</div>
                    <div class="col-xs-12 actions-btn">
                        <button class="btn btn-sm btn-success btn-block" type="submit" name="action" value="activate">
                            Activate
                        </button>
                    </div>
                    <div class="col-xs-12 actions-btn">
                        <button class="btn btn-sm btn-warning btn-block" type="submit" name="action" value="deactivate">
                            DeActivate
                        </button>
                    </div>
                    <div class="col-xs-12 actions-btn">
                        <button class="btn btn-sm btn-danger btn-block confirm" type="submit" name="action"
                                value="delete">Delete
                        </button>
                    </div>
                </form>
                <div class="clearfix">&nbsp;</div>
                <div class="clearfix">&nbsp;</div>
            </div>
        </div>
    </div>
</section><!-- End: Content -->
<link rel="stylesheet" type="text/css"
      href="<?php echo $this->config->item('admin_js'); ?>plugins/datatables/media/css/dataTables.bootstrap.css"><!-- Datatables -->
<script
    src="<?php echo $this->config->item('admin_js'); ?>plugins/datatables/media/js/jquery.dataTables.js"></script><!-- Datatables Bootstrap Modifications  -->
<script
    src="<?php echo $this->config->item('admin_js'); ?>plugins/datatables/media/js/dataTables.bootstrap.js"></script>
<script type="text/javascript">    $(document).ready(function () {
        var datatable = $('#datatable');
        datatable.dataTable({
            bFilter: false,
            "sDom": '<"dt-panelmenu clearfix"lfr>t<"dt-panelfooter clearfix"ip>',
            "processing": false,
            "serverSide": true,
            "aoColumnDefs": [{'bSortable': false, 'aTargets': [5]}],
            "pageLength": 10,
            "order": [],
            "displayStart": '<?php echo (!empty($_GET['offset']))?$_GET['offset']:0; ?>',
            "ajax": {
                'type': 'GET', 'url': base_url + "products/ajax_index", 'data': function (d) {
                    d.formValues = $('#search_frm').serialize();
                }
            }
        });
        $('#action_frm').on('click', '.confirm', function () {
            return confirm('Are you sure to delete?');
        });
        
        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });

        $('#action_frm').on('click', '.categoryModal', function(){
            var $globalModal = $('#globalModal');
            $globalModal.find('.modal-body').html($(this).attr('data-content'));
            $globalModal.modal('show');
        });
        $('#check_all').click(function () {
            var checkboxes = $('#datatable').find('tbody .mul_ch');
            if ($(this).is(':checked')) {
                checkboxes.prop('checked', true)
            } else {
                checkboxes.prop('checked', false)
            }
        });
    });</script>