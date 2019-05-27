<div class="modal-header">
    <button aria-label="Close" data-dismiss="modal" class="close" type="button">
        <span aria-hidden="true">×</span>
    </button>
    <h4 class="modal-title">Mark as paid</h4>
</div>

<form id="mark_as_paid_frm" action="<?php echo base_url(); ?>admin/orders/process_mark_as_paid" method="post">
    <input name="order_id" value="<?php echo $order_id; ?>" type="hidden"/>
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="control-label" for="">Comments<span class="required">*</span></label>
                    <textarea id="comments" class="form-control" name="comments" placeholder="Enter comments" ></textarea>

                </div>
            </div>
        </div>
    </div><!--/ end modal-body-->

    <div class="modal-footer">
        <button data-dismiss="modal" class="btn btn-default pull-left" type="button">Close</button>
        <button type="submit" class="btn btn-primary pull-right">Submit</button>
    </div><!--/ end modal-footer-->
</form>
