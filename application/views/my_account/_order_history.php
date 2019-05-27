<?php include_once('navigation.php'); ?>
<div class="col-lg-9 col-md-9 col-sm-6">
    <div class="right-sec">
        <?php if( $this->session->flashdata('success')){ ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php } ?>
        <?php if( $this->session->flashdata('error')){ ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php } ?>
        <div class="formhead">
            Order History
        </div>
        <div class="clearfix">&nbsp;</div>
        <table cellpadding="0" cellspacing="0" width="100%" class="table table-striped table-bordered" id="dataTable">
            <thead>
            <tr>
                <th width="6%" style="text-align:center;">SNo.</th>
                <th width="25%" style="text-align:left;">Order Id</th>
                <th width="15%" style="text-align:center;">Amount</th>
                <th width="30%" style="text-align:center;">Ordered Date</th>
                <th width="8%" style="text-align:center;">View</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if(isset($order_history)&& !empty($order_history)) {
                $sno=1;
                foreach($order_history as $order_row) {
                    $net_amount = $order_row['total_amount']+$order_row['delivery_cost']-$order_row['coupon_discount'];
                    ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $sno; ?></td>
                        <td style="text-align:left;"><?php echo $order_row['order_id']; ?></td>
                        <td style="text-align:center;">&#8377;<?php echo number_format($net_amount, 2); ?></td>
                        <td style="text-align:center;"><?php echo date('d-m-Y H:i:s', strtotime($order_row['payment_date'])); ?></td>
                        <td style="text-align:center;"><a href="<?php echo base_url('user/view_invoice'); ?>/<?php echo $order_row['id']; ?>" title="Click to view"><i class="fa fa-eye"></i> </a></td>
                    </tr>
                    <?php
                    $sno++;
                }
            }
            ?>
            </tbody>
        </table>
    </div>
    </div>

</div>
</div>
<link rel="stylesheet" href="<?php echo $this->config->item('user_js'); ?>dataTables/jquery.dataTables.min.css" />
<script type="text/javascript" src="<?php echo $this->config->item('user_js'); ?>dataTables/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(function(){
        $('#dataTable').dataTable( {
            "iDisplayLength": 10,
            "aaSorting": [[ 0, "asc" ]],
            "aoColumns": [
                { "bSortable": false },
                { "bSortable": false },
                { "bSortable": false },
                { "bSortable": false },
                { "bSortable": false }
            ]
        });
    });
</script>