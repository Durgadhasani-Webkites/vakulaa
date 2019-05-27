<div class="col-sm-4 col-xl-3">
    <div class="panel panel-tile text-center br-a br-grey">
        <div class="panel-body">
            <h1 class="fs30 mt5 mbn total_sales">
                <?php
                $total_cost=0;
                if(!empty($results)) {
                    foreach($results as $k=>$v) {
                        $total_cost += $v['order_cost'];
                    }
                }
                echo $total_cost;
                ?>
                </h1>

        </div>
        <div class="panel-footer br-t p12">
            <h6 class="text-system">TOTAL SALES</h6>
        </div>
    </div>
</div>
<div class="col-lg-8">
    <table class="table table-bordered table-responsive">
        <tr>
            <th>Product Name</th>
            <th>Qty</th>
            <th>Cost</th>
        </tr>
        <?php
        if(!empty($results)){
            $total_cost=0; ?>
            <?php foreach($results as $k=>$v){
                $total_cost += $v['order_cost'];
                ?>
                <tr>
                    <td><?php echo $v['prod_name']; ?><br/>(<?php echo $v['prod_code']; ?>)</td>
                    <td><?php echo $v['quantity']; ?></td>
                    <td><?php echo $v['order_cost']; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="2" align="right">Total Cost</td>
                <td><?php echo $total_cost; ?></td>
            </tr>
        <?php } else{ ?>
            <tr>
                <td colspan="3">No data found.</td>
            </tr>
        <?php }?>
    </table>
</div>

