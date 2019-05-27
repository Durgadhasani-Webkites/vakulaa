<div class="modal-header">
    <button aria-label="Close" data-dismiss="modal" class="close" type="button">
        <span aria-hidden="true">×</span>
    </button>
    <h4 class="modal-title">Export Order</h4>
</div>

<form id="export_frm" action="<?php echo base_url(); ?>admin/orders/process_export_order" method="post">
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label" for="">From Date<span class="required">*</span></label>
                    <input id="order_from_date" class="form-control datepicker" name="order_from_date" placeholder="Enter Order From date" type="text">

                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label" for="">To Date<span class="required">*</span></label>
                    <input id="order_to_date" class="form-control datepicker" name="order_to_date" placeholder="Enter Order To date" type="text">

                </div>
            </div>
        </div>
    </div><!--/ end modal-body-->

    <div class="modal-footer">
        <button data-dismiss="modal" class="btn btn-default pull-left" type="button">Close</button>
        <button type="submit" class="btn btn-primary pull-right">Submit</button>
    </div><!--/ end modal-footer-->
</form>
