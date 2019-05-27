<header id="topbar" class="ph10">

    <div class="text-center">
        <h4>Sort Products</h4>
        <hr class="alt short">
    </div>
    <div class="topbar-left">
        <ul class="nav nav-list nav-list-topbar pull-left">
            <li class="active">
                <a href="<?php echo base_url(); ?>admin/sort_products">Sort Products</a>
            </li>
        </ul>
    </div>
</header>

<section id="content" class="table-layout animated fadeIn">
    <div class="tray tray-center" style="height: 510px;">

        <!-- create new order panel -->
        <div class="panel mb25 mt5">
            <div class="panel-heading">
                <span class="panel-title hidden-xs">Sort Products</span>

            </div>
            <div class="panel-body p20 pb10">
                <div class="tab-content pn br-n admin-form">
                    <div class="tab-pane active" id="tab1_1">
                        <div class="section row">
                            <div class="col-md-6">
                                <h5><small>Category</small></h5>
                                <label class="field select" for="">
                                    <select name="category_id" id="category_id">
                                        <option value="">Choose</option>
                                        <?php if(!empty($categories)){
                                            foreach($categories as  $key => $value){?>
                                                <option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
                                            <?php }  } ?>
                                    </select>
                                    <i class="arrow double"></i>
                                </label>
                            </div>
                        </div>
                        <div class="section row">
                            <div class="col-md-12">
                                <h5><small>Products</small></h5>
                                <ul id="products" class="list-group">
                                    <?php if(!empty($products)){ ?>
                                        <?php
                                        foreach($products as $k=>$v){?>
                                            <li id="item-<?php echo $v['id']; ?>" class="list-group-item-info"><?php echo $v['product_name']; ?></li>
                                        <?php }  ?>
                                    <?php } else{ ?>
                                        <li>No products found.</li>
                                    <?php  } ?>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/jquery.validate.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/additional-methods.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/jquery.validate.custom.min.js"></script>

<script type="text/javascript">
    $(function(){
        $('#category_id').change(function(){
            $.ajax({
                url:base_url+'sort_products/get_products_by_category',
                type:'post',
                data:'category_id='+$(this).val(),
                success:function(response){
                    if(response!=''){
                        $('#products').html(response);
                    }else{
                        $('#products').html('<p>No products found.</p>');
                    }
                }
            });
        });
        $('#products').sortable({
            stop: function (event, ui) {
                var data = $(this).sortable('serialize');
                console.log(data);
                $.ajax({
                    type: "POST",
                    url: base_url + 'sort_products/update_sorting',
                    data: data,
                    dataType: 'json',
                    success: function (data) {
                    }
                });
            }
        });
    })
</script>
<style>
    #products{
        margin:0;
        padding:0;
    }
    #products li{
        list-style-type: none;
        margin:10px 0;
        padding:10px;
    }
</style>