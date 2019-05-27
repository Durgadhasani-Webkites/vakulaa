$(function () {
    /* facebook js*/
    // window.fbAsyncInit = function() {
    //     FB.init({
    //         appId : fbAppId,
    //         cookie:true,
    //         status:true,
    //         xfbml:true,
    //         version:'v2.6'
    //     });
    // };
    // (function(d, s, id){
    //     var js, fjs = d.getElementsByTagName(s)[0];
    //     if (d.getElementById(id)) {return;}
    //     js = d.createElement(s); js.id = id;
    //     js.src = "//connect.facebook.net/en_US/sdk.js";
    //     fjs.parentNode.insertBefore(js, fjs);
    // }(document, 'script', 'facebook-jssdk'));


    // $('.facebook-sign-in').click(function(e) {
    //     FB.login(function(response) {
    //             if(response.authResponse) {
    //                 parent.location ='https://www.vakullaa.com/fbci/fblogin';
    //             }
    //         },{scope: 'public_profile,email,publish_actions,user_birthday,user_location,user_work_history,user_hometown,user_photos,user_friends'}
    //     );
    // });

    /*---*/

    // $('select').niceSelect();
    // $('select.no-niceSelect').niceSelect('destroy');

    // $('.searchbox').keypress(function(e) {
    //     // Enter pressed?
    //     if(e.which == 10 || e.which == 13) {
    //         this.form.submit();
    //     }
    // });

    // $('#newsletter_frm').validate({
    //     errorClass: "error",
    //     ignore: [],
    //     errorElement:'div',
    //     rules: {
    //         newsletter_email: {
    //             required: true,
    //             validEmail:true
    //         }
    //     },
    //     submitHandler:function(form) {
    //         var $form = $(form);
    //         var data = $form.serialize();
    //         $.ajax({
    //             url:base_url+'index/subscribe_to_newsletter',
    //             type:'post',
    //             data:data,
    //             dataType:'json',
    //             success:function(response){
    //                 if(response.error){
    //                     $("body").overhang({
    //                         type : "error",
    //                         message: response.error
    //                     });
    //                 }
    //                 if(response.success){
    //                     $("body").overhang({
    //                         type : "success",
    //                         message: response.success
    //                     });
    //                 }
    //             }
    //         });
    //     }
    // });

    // $(".searchbox").each(function(){
    //     $(this).autocomplete({
    //         minLength: 2,
    //         source: function(request, response) {
    //             if((request.term).trim()!=''){
    //                 $.getJSON(base_url + "search/ajax_search_results", { category: $('.search_top_cat').val(),term:request.term },
    //                     response);
    //             }
    //         },
    //         focus: function (event, ui) {
    //             return false;
    //         },
    //         select: function (event, ui) {
    //             $(".searchbox").val(ui.item.label);
    //             return false;
    //         },
    //         open: function () {
    //             $(this).data("ui-autocomplete").menu.element.addClass("search-autocomplete");
    //             $(".ui-autocomplete").mCustomScrollbar({
    //                 theme:"dark-thick"
    //             });
    //         },
    //         close:function(e,ui){
    //             $(".ui-autocomplete").mCustomScrollbar("destroy");
    //         },
    //         response:function(e,ui){
    //             $(".ui-autocomplete").mCustomScrollbar("destroy");
    //         },
    //         create: function () {
    //             $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
    //                 var $div = "<div class='search-item'><a href='"+item.product_url+"'><img src='"+item.img_url+"' height='30' /><span>"+item.label+"</span>";
    //                 $div +=" - &nbsp;&nbsp;Rs.<span>"+item.product_price+"</span></a></div>";
    //                 return $("<li>")
    //                     .append($div).data("item.autocomplete", item).appendTo(ul);
    //             };
    //         }
    //     });
    // });

    // $(document).on('change','.product_opt_select',function(){
    //     var optimage = $(this).find('option:selected').data('optimage');
    //     $(this).closest('.product_box').find('.product_place img').prop('src',optimage);
    // });

    $(document).on('click','.buy_btt',function(){
      //  alert(1);
        var $product_det = $(this).closest('.product_det'),pid=$(this).data('pid'),
          //  qty = $product_det.find('.qty option:selected').val();
            qty= $product_det.find('.quntitytnumberbox').val();
            //alert(qty1);

        var selectedOpt='';
        if($product_det.find('.product_option:checked').length){
            selectedOpt = $product_det.find('.product_option:checked').val();
        }
        if($product_det.find('.product_opt_select li.selected').length==1){
            selectedOpt = $product_det.find('.product_opt_select li.selected').data('value');
        }
        $.ajax({
            url:base_url+'cart/add_to_cart',
            type:'post',
            data:'pid='+pid+'&qty='+qty+'&selectedOpt='+selectedOpt,
            dataType:'json',
            success:function(response){
                if(response.error){
                    $("body").overhang({
                        type : "error",
                        message: response.error
                    });
                }
                if(response.success){
                    $("body").overhang({
                        type : "success",
                        message: response.success
                    });
                    $('.cart_count,.cart_count_xs').html(response.cart_total);
                }
            }
        });
    });
});
