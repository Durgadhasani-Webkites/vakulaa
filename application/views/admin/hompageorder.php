<header id="topbar" class="ph10">

    <div class="text-center">
        <h4>Homepage Order</h4>
        <hr class="alt short" />
    </div>
    <div class="topbar-left">
        <ol class="breadcrumb">
            <li class="crumb-icon">
                <a href="<?php echo base_url('admin/index/dashboard'); ?>">
                    <span class="glyphicon glyphicon-home"></span>
                </a>
            </li>
            <li class="crumb-link">
                <a href="">Homepage Order</a>
            </li>
        </ol>
    </div>
    
</header>
<!-- End: Topbar -->

<!-- Begin: Content -->
<section id="content" class="table-layout animated fadeIn">

    <div class="row">

        <div class="panel">

            <div class="panel-body">
                <form id="report_frm" method="post" action="<?php echo base_url(); ?>admin/homepage_order/process" class="form-horizontal" role="form">
                <table width="100%" cellpadding="0" cellspacing="0" class="table">
                    
                        <tr>
                            <td width="20%"><b>Section Name</b></td>
                            <td  width="20%"><b>Order</b></td>
                            <td><b>Status</b></td>
                        </tr>
                        <?php
                           /// print_r($admin_results);
                            foreach($admin_results as $key=>$val)
                            {
                                ?>
                                <tr>
                                    <td> <?php echo ucwords($admin_results[$key]['modulename']);?></td>
                                    <td> <input type="text" value="<?php echo ucwords($admin_results[$key]['sortorder']);?>" name="order[<?php echo $key; ?>]"/></td>
                                    <td> 
                                    
                                    <input type="radio" name="status[<?php echo $key; ?>]" value="1"
                                    <?php
                                    if($admin_results[$key]['status']=='1')
                                    {
                                        echo 'checked=checked';
                                    }
                                    ?>
                                    /> In Active
                                    <input type="radio" name="status[<?php echo $key; ?>]" value="2"
                                    <?php
                                    if($admin_results[$key]['status']=='2')
                                    {
                                        echo 'checked=checked';
                                    }
                                    ?>
                                    /> Active

                                    </td>
                                </tr>
                               
                               
                                <?php
                            }
                            ?>
                    </table>
                    <div class="clearfix">&nbsp;</div>
                    <input type="submit"/>
                </form>


            </div>

        </div>

    </div>
</section>
<!-- End: Content -->