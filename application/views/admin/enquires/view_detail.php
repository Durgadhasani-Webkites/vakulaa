<header id="topbar" class="ph10">

    <div class="text-center">
        <h4>Enquiry details</h4>
        <hr class="alt short">
    </div>
    <div class="topbar-left">
        <ul class="nav nav-list nav-list-topbar pull-left">
            <li class="active">
                <a href="javascript:">Edit</a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>admin/enquires">View</a>
            </li>

        </ul>
    </div>
</header>

<section id="content" class="table-layout animated fadeIn">
<div class="tray tray-center" style="height: 510px;">

<!-- create new order panel -->
<div class="panel mb25 mt5">
<div class="panel-heading">
    <span class="panel-title hidden-xs"> View enquiry info</span>

</div>
<div class="panel-body p20 pb10">
<div class="tab-content pn br-n admin-form">
<div class="tab-pane active" id="tab1_1">

<div class="section row">
    <div class="col-md-9">
        <h5><small>Name</small></h5>
        <?php echo $user_name; ?>
    </div>
</div>

<div class="section row">
    <div class="col-md-9">
        <h5><small>Phone</small></h5>
        <?php echo $user_mobile; ?>
    </div>
</div>
<div class="section row">
    <div class="col-md-9">
        <h5><small>Email</small></h5>
        <?php echo $user_email; ?>
    </div>
</div>
<div class="section row">
    <div class="col-md-9">
        <h5><small>Message</small></h5>
        <?php echo $user_message; ?>
    </div>
</div>
<div class="section row">
    <div class="col-md-9">
        <h5><small>Created</small></h5>
        <?php echo date('d/m/Y',strtotime($created)); ?>
    </div>
</div>

</div>
</div>
</div>
</div>
</div>
</section>

