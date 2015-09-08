<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/style.css">
<script src="<?php echo base_url(); ?>assets/js/lib/jquery-1.11.1.js"></script>
<script src=".<?php echo base_url(); ?>assets/js/lib/jquery.easing-1.3.js"></script>
<script src="<?php echo base_url(); ?>assets/js/lib/jquery.easing.compatibility.js"></script>
<script src="<?php echo base_url(); ?>assets/js/lib/jquery.mousewheel-3.1.12.js"></script>
<script src="<?php echo base_url(); ?>assets/js/lib/jquery.jcarousellite.min.js"></script>
<script type="text/javascript">
    $(function() {
//        $(".carousel_slider").jCarouselLite({
//            btnNext: ".next",
//            btnPrev: ".prev",
//            start: -3,
//            scroll: 5
//        });
        $(".carousel_slider").jCarouselLite({
            btnNext: ".next",
            btnPrev: ".prev"
        });
    });</script>
<script>
    $(document).ready(function() {
        $('body').on('keyup', '.item_qua', function(e) {

            //mehul 21-8-2015
            if ($('#mytxt').attr('data-qua')) {
                if ($('#mytxt').val() == "") {
                    var new_qua = $('#mytxt').attr('data-qua');
                } else {
                    var new_qua = $('#mytxt').val();
                }
                var fix_price = $('.curr_price').attr('data-fix');
                var product_id = $('.curr_price').parents().attr('data-id');
                var product_name = $('#mytxt').siblings('.item_name').text();
                var count = new_qua;//$('#mytxt').attr('data-qua');
                var total_price = fix_price * count;
                $('.curr_price').text(total_price);
                $.ajax({
                    url: base_url + 'admin_operator/update_session',
                    type: "POST",
                    data: {product_id: product_id, add_count: count, total_product_price: total_price, product_name: product_name, fix_price: fix_price},
                    success: function(data) {

                    },
                    error: function() {
                    }
                });
                var sum = 0.0;
                $('.item_price').each(function()
                {
                    sum += parseFloat($(this).text());
                });
                $('.total_display').text(sum);
                //product quantity count
                var sum_qua = 0;
                $('.item_qua').each(function()
                {
                    sum_qua += parseInt($(this).text());
                });
                $('.tot_quantity').text(sum_qua);
                $('#mytxt').replaceWith('<a class="item_qua current qua_css" href="javascript:void(0)" onclick="myAddClass(this)">' + new_qua + '</a>');
            }
            //end mehul21-08-2015

            $('.current').hide();
            $('.abc').hide();
            $(this).parent().siblings().children().removeClass('current');
            $(this).parent().siblings().children().removeClass('curr_price');
            var qua = $(this).text();
            $('.show').text(qua);
            $(this).replaceWith('<input id="mytxt" data-qua="' + qua + '" class="found" type="text" value="' + qua + '"></input>');
            $('#mytxt').focus();
            $('#mytxt').select();
            $('.show').text('');
            $('.btn_count').attr('disabled', false);
            $('.btn_count_right').attr('disabled', false);
            $('#mytxt').siblings().addClass('curr_price');
            $('.item_name').removeClass('curr_price');
            $('.price_tit').removeClass('curr_price');
            $('.cancel_btn').removeClass('curr_price');
            $('.append_qua').removeClass('curr_price');
            var sum_qua = 0;
            $('.item_qua').each(function()
            {
                sum_qua += parseInt($(this).text());
            });
            //alert(sum_qua);
            $('.tot_quantity').text(sum_qua);
            $('.item_qua').show();
        });
        //$('.cancel_btn').on('keyup', function(e) {
        $('body').on('keyup', '.cancel_btn', function(e) {
            var item_name = $(this).siblings('.item_name').text();
            var fix_price = $(this).siblings('.price_tit').text();
            var product_id = $(this).parent().attr('data-id');
            //var total_price = $(this).siblings('.item_price').text();
            $('.abc').empty();
            $('.append_qua').hide();
            $('.item_qua').show();
            //var num = $('.show').text();
            if ($('#mytxt').val()) {
                var num = $('#mytxt').val();
            } else {
                var num = $('#mytxt').attr('data-qua');
            }
            var total_price = num * fix_price;
            $.ajax({
                url: base_url + 'admin_operator/update_session',
                type: "POST",
                data: {product_id: product_id, add_count: num, total_product_price: total_price, product_name: item_name, fix_price: fix_price},
                success: function(data) {
                },
                error: function() {
                }
            });
            var item_price = $('.curr_price').attr('data-fix');
            var qua_num = $('#mytxt').val();
            if (qua_num == "" || qua_num == ".") {
                qua_num = $('#mytxt').attr('data-qua');
            }
            $('#mytxt').replaceWith('<a class="item_qua qua_css" href="javascript:void(0)" onclick="myAddClass(this)">' + qua_num + '</a>');
            //$('.abc').text(qua_num);
            $('.btn_count').attr('disabled', true);
            $('.btn_count_right').attr('disabled', true);
            //alert('qua_num-' + qua_num);
            var item_total_price = qua_num * item_price;
            //alert(item_total_price);
            $('.current').text(num);
            $('.curr_price').text(item_total_price);
            var sum = 0.0;
            $('.item_price').each(function()
            {
                sum += parseFloat($(this).text());
            });
            $('.total_display').text(sum);
            //product quantity count
            var sum_qua = 0;
            $('.item_qua').each(function()
            {
                sum_qua += parseInt($(this).text());
            });
            $('.tot_quantity').text(sum_qua);
        });
        $('body').on('keyup', '#mytxt', function(e) {
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if (keycode == '13') {
                $('.abc').empty();
                $('.append_qua').hide();
                $('.item_qua').show();
                var num = $('.show').text();
                alert(num);
                var item_price = $('.curr_price').attr('data-price');
                var item_total_price = num * item_price;
                $('.current').text(num);
                $('.curr_price').text(item_total_price);
                var sum = 0.0;
                $('.item_price').each(function()
                {
                    sum += parseFloat($(this).text());
                });
                $('.total_display').text(sum);
                //product quantity count
                var sum_qua = 0;
                $('.item_qua').each(function()
                {
                    sum_qua += parseInt($(this).text());
                });
                $('.tot_quantity').text(sum_qua);
                //alert(sum_qua);
                //text box add
                $('#mytxt').replaceWith('<a class="item_qua qua_css" href="javascript:void(0)" onclick="myAddClass(this)">' + $('.show').text() + '</a>');
                $('.abc').text($('.show').text());
            }
        });
        $('body').on('keyup', '#mytxt', function(e) {
            var stt = $('#mytxt').val();
            $(".show").text(stt);
        });
        $('#operator_record').click(function() {
            operator_id = $(this).attr('data-id');
            $.ajax({
                url: base_url + 'admin_operator/get_operator_data',
                type: "POST",
                data: {operator_id: operator_id},
                success: function(data) {

                },
                error: function() {
                }
            });
        });
        $('#print_bill').click(function() {
            if ($('#mytxt').attr('data-qua')) {
                $('#mytxt').replaceWith('<a class="item_qua current qua_css" href="javascript:void(0)" onclick="myAddClass(this)">' + $('#mytxt').attr('data-qua') + '</a>');
            }
            var list = $('.calculate').html();
            var discount = $('.disc_input').val();
            var total = $('.total_display').text();
            var discount_price = parseFloat(discount * total) / 100;
            var new_total = total - discount_price;
            $('.white_content').html('<div style="width: 100%; float: left;"><div class="title_product">Product</div><div class="title_quantity">Quantity</div><div class="title_price">Price</div><div class="title_subtotal">Subtotal</div></div>' + list + '<div class="bill_label bill_label_left"><div style="float:left">Total Items :</div><div class="bill_quantity"></div></div><div class="bill_label"><div style="float:left; width:35%;">Total :</div><div class="bill_total"></div><div style="float:left; width:29%;">Disc :</div>-<div style="width: 63%; float: right;" class="desc_price"></div><div style="float:left; width:96%;">---------------------------</div><div style="float:left; width:35%;">Grand total:</div><div class="last_total"></div></div><div style="width:50%; float:left;"><select class="paymet_class" name="payment_select"><option selected="selected">Cash</option><option>Debit Card</option></select><br/><input id="order_button" class="order_button" onclick="orderPlace(this)" type="button" value="Place Order"></div><div style="width:50%; float:left;"><input class="order_button" onclick="closeBill(this)" type="button" value="Cancel"></div>');
            $('.bill_quantity').text($('.tot_quantity').text());
            $('.bill_total').text($('.total_display').text());
            $('.desc_price').text(discount_price);
            $('.last_total').text(new_total);
            $('.total_insert').text(new_total);
            $('.white_content').children().children().removeClass('current');
            //$(".item_qua").bind('click', disableLink);
            $('.item_qua').attr('disabled', true);
            $('.white_content').children().children().removeClass('item_price');
            $('.white_content').children().children().removeClass('item_qua');
            $('.white_content a').removeAttr("onclick");
        });
        $.ajax({
            type: "GET",
            url: base_url + 'admin_operator/get_all_product',
            dataType: "html", //expect html to be returned
            success: function(response) {
                $('#display_product').html('<table class="item_list">' + response + '</table>');
                $('.carousel_slider').css('width', '');
                $('.carousel_slider ul').css('margin-top', '13px');
                $('.carousel_slider li').css('width', '');
                //alert(response);
                var sum_qua = 0;
                $('.item_qua').each(function()
                {
                    sum_qua += parseInt($(this).text());
                });
                $('.tot_quantity').text(sum_qua);
<?php
$data = $this->session->userdata('my_order');
if (!empty($data)) {
    foreach ($data as $value) {
        ?>
                        $('.item_<?php echo $value['products_id'] ?> img').addClass('repeat');
        <?php
    }
}
?>
            }
        });
    });
    function closeBill(e) {
        $('#light').css("display", "none");
        $('#fade').css("display", "none");
    }

    function removeItem(e) {
        $('.btn_count').attr('disabled', true);
        $('.btn_count_right').attr('disabled', true);
        total = $('.total_display').text();
        remove_price = $(e).siblings('.item_price').text();
        ans = total - remove_price;
        $('.total_display').replaceWith('<h2 class="total_display">' + ans + '</h2>');
        total_qua = $('.tot_quantity').text();
        remove_quantity = $(e).siblings('.item_qua').text();
        ans_quantity = total_qua - remove_quantity;
        $('.tot_quantity').text(ans_quantity);
        var data_id = $(e).parent().attr('data-id');
        var item_id = 'item_' + data_id;
        $('.' + item_id).children().removeClass('repeat');
        $(e).parent().remove();
        $.ajax({
            url: base_url + 'admin_operator/unset_session',
            type: "POST",
            data: {data_id: data_id},
            success: function() {

            },
            error: function() {
            }
        });
    }

    function myAddClass(e) {
        if ($('#mytxt').attr('data-qua')) {
            if ($('#mytxt').val() == "" || $('#mytxt').val() == ".") {
                var new_qua = $('#mytxt').attr('data-qua');
            } else {
                var new_qua = $('#mytxt').val();
            }
            var fix_price = $('.curr_price').attr('data-fix');
            var product_id = $('.curr_price').parents().attr('data-id');
            var product_name = $('#mytxt').siblings('.item_name').text();
            var count = new_qua;//$('#mytxt').attr('data-qua');
            var total_price = fix_price * count;
            $('.curr_price').text(total_price);
            $.ajax({
                url: base_url + 'admin_operator/update_session',
                type: "POST",
                data: {product_id: product_id, add_count: count, total_product_price: total_price, product_name: product_name, fix_price: fix_price},
                success: function(data) {

                },
                error: function() {
                }
            });
            var sum = 0.0;
            $('.item_price').each(function()
            {
                sum += parseFloat($(this).text());
            });
            $('.total_display').text(sum);
            //product quantity count
            var sum_qua = 0;
            $('.item_qua').each(function()
            {
                sum_qua += parseInt($(this).text());
            });
            $('.tot_quantity').text(sum_qua);
            $('#mytxt').replaceWith('<a class="item_qua current qua_css" href="javascript:void(0)" onclick="myAddClass(this)">' + new_qua + '</a>');
        }
        $(e).addClass('current');
        console.log($(e).siblings());
        $(e).siblings().addClass('curr_price');
        $('.item_name').removeClass('curr_price');
        $(e).parent().siblings().children().removeClass('current');
        $(e).parent().siblings().children().removeClass('curr_price');
        $('.append_qua').removeClass('curr_price');
        $('.append_qua').addClass('abc');
        $('.price_tit').removeClass('curr_price');
        $('.cancel_btn').removeClass('curr_price');
//test
        $('.current').hide();
        $('.abc').hide();
        var before_qua = $(e).text();
//$(e).replaceWith('<input class="item_qua current" style="height:10px; width:20%; float:left;" type="text" name="mytxt" value="" id="mytxt"></input>');
        $(e).replaceWith('<input id="mytxt" data-qua="' + before_qua + '" class="found" type="text" value="' + before_qua + '"></input>');
        $('.show').text('');
        $('#mytxt').focus();
        $('#mytxt').select();
        $('.btn_count').removeAttr('disabled', false);
        $('.btn_count_right').removeAttr('disabled', false);
//test
    }

    function myproduct(e)
    {
        $(e).addClass('active');
        $(e).parent().siblings().children().removeClass('active');
        $('.btn_count').removeAttr('disabled');
        var id = $(e).attr('data-id');
        $.ajax({
            url: base_url + 'admin_operator/get_product_by_category',
            type: "POST",
            data: {category_id: id},
            success: function(data) {
                $('#display_product').html('<table class="item_list">' + data + '</table>');
            },
            error: function() {
            }
        });
    }
    var arr_data = [];
    var arr_qua = [];
    function myid(e) {
        $('.btn_count_right').attr('disabled', true);
        $('.btn_count').attr('disabled', true);
        //mehul 21-08-2015
        if ($('#mytxt').attr('data-qua')) {
            if ($('#mytxt').val() == "" || $('#mytxt').val() == ".") {
                var new_qua = $('#mytxt').attr('data-qua');
            } else {
                var new_qua = $('#mytxt').val();
            }
            var fix_price = $('.curr_price').attr('data-fix');
            var product_id = $('.curr_price').parents().attr('data-id');
            var product_name = $('#mytxt').siblings('.item_name').text();
            var count = new_qua;//$('#mytxt').attr('data-qua');
            var total_price = fix_price * count;
            $('.curr_price').text(total_price);
            $.ajax({
                url: base_url + 'admin_operator/update_session',
                type: "POST",
                data: {product_id: product_id, add_count: count, total_product_price: total_price, product_name: product_name, fix_price: fix_price},
                success: function(data) {

                },
                error: function() {
                }
            });
            var sum = 0.0;
            $('.item_price').each(function()
            {
                sum += parseFloat($(this).text());
            });
            $('.total_display').text(sum);
            //product quantity count
            var sum_qua = 0;
            $('.item_qua').each(function()
            {
                sum_qua += parseInt($(this).text());
            });
            $('.tot_quantity').text(sum_qua);
            $('#mytxt').replaceWith('<a class="item_qua current qua_css" href="javascript:void(0)" onclick="myAddClass(this)">' + new_qua + '</a>');
        }

        //end mehul 21-08-2015

        $("a").addClass('pro_dis');
        $('.main').addClass('load');
        var data_id = $(e).attr('data-id');
        if (jQuery.inArray(data_id, arr_data) != -1) {
//arr_data.push(data_id);
        } else {
            arr_data.push(data_id);
        }
//alert(arr_data);

        if ($(e).children().hasClass('repeat')) {
            edit_val = $('#mytxt').attr('data-qua');
            if (edit_val) {
                $('#mytxt').replaceWith('<a class="item_qua current qua_css" href="javascript:void(0)" onclick="myAddClass(this)">' + parseInt(edit_val) + '</a>');
            }
            var product_id = $(e).attr('data-id');
            var id_name = 'product_' + product_id;
            var product_count = $('#' + id_name).children('.item_qua').text();
            var product_name = $('#' + id_name).children('.item_name').text();
            var add_count = parseInt(product_count) + 1;
            $('#' + id_name).children('.item_qua').text(add_count);
            var fix_price = $('#' + id_name).children('.price_tit').text();
            var total_product_price = parseInt(add_count) * parseInt(fix_price);
            $('#' + id_name).children('.item_price').text(total_product_price);
            //var final_total = $('.total_display').text();

            $.ajax({
                url: base_url + 'admin_operator/update_session',
                type: "POST",
                data: {product_id: product_id, add_count: add_count, total_product_price: total_product_price, product_name: product_name, fix_price: fix_price},
                success: function(data) {
                    var sum = 0.0;
                    $('.item_price').each(function()
                    {
                        sum += parseFloat($(this).text());
                    });
                    //var discount = $('.disc_input').val();
                    //var disc_price = parseFloat(discount * sum) / 100;
                    //var grand_sum = parseFloat(sum - disc_price);
                    //alert(sum);
                    $('.total_display').text(sum);
                    var sum_qua = 0;
                    $('.item_qua').each(function()
                    {
                        sum_qua += parseInt($(this).text());
//                        alert(sum_qua);
                    });
                    $('.tot_quantity').text(sum_qua);
                    $('.main').removeClass('load');
                    $("a").removeClass('pro_dis');
                },
                error: function() {
                }
            });
        } else {
            edit_val = $('#mytxt').attr('data-qua');
            if (edit_val) {
                $('#mytxt').replaceWith('<a class="item_qua current qua_css" href="javascript:void(0)" onclick="myAddClass(this)">' + parseInt(edit_val) + '</a>');
            }
            var qua = $(e).attr('data-id');
            $('.item_qua').removeClass('current');
            $('.item_price').removeClass('curr_price');
            $('.total_display').text();
            var product_id = $(e).attr('data-id');
            var product_count = $('#' + id_name).children('.item_qua').text();
            var final_total = $('.total_display').text();
            comm = "";
            $.ajax({
                url: base_url + 'admin_operator/get_product',
                type: "POST",
                data: {products_id: product_id, final_total: final_total},
                success: function(data) {
                    $('.show').text('');
                    $(e).children().addClass('repeat');
                    $('.calculate').append('<div data-id="' + product_id + '" id="product_' + product_id + '" class="bill_item">' + data + '</div>');
                    var num = $('.current').text();
                    var item_price = $('.curr_price').attr('data-price');
                    var item_total_price = num * item_price;
                    $('.current').text(num);
                    $('.curr_price').text(item_total_price);
                    var sum = 0.0;
                    $('.item_price').each(function()
                    {
                        sum += parseFloat($(this).text());
                    });
                    //var discount = $('.disc_input').val();
                    //var disc_price = discount * sum / 100;
                    //var grand_sum = sum - disc_price;

                    $('.total_display').text(sum);
//product quantity count
                    var sum_qua = 0;
                    $('.item_qua').each(function()
                    {
                        sum_qua += parseInt($(this).text());
                    });
                    $('.tot_quantity').text(sum_qua);
                    $('.main').removeClass('load');
                    $("a").removeClass('pro_dis');
                },
                error: function() {
                }
            });
        }


        var product_id = $(e).attr('data-id');
        var id_name = 'product_' + data_id;
        var product_count_1 = $('#' + id_name).children('.item_qua').text();
        if (product_count_1 == '') {
            product_count_1 = "1";
        }

        arr_qua.push(product_count_1);
    }

    function mynumber(e) {
        $('.curr_price').parent().siblings().children().removeClass('abc');
        $('.curr_price').parent().siblings().children().find('.abc').hide();
        var item_quantity = $(e).val();
        $('.current').empty();
        $('.abc').append(item_quantity);
        $('.show').append(item_quantity);
        //$('.current').hide();
        $('.current').replaceWith('<input id="mytxt" data-qua="' + item_quantity + '" class="found" type="text" value="' + item_quantity + '"></input>');
        $('#mytxt').val($('.show').text());
        new_qua = $('#mytxt').val();
    }
    function okClear(e) {
        var btn_action = $(e).val();
        if (btn_action == 'OK') {
            $('.btn_count').attr('disabled', true);
            $('.btn_count_right').attr('disabled', true);
            var curr_qua = $('.current').text();
            var textbox_qua = $('#mytxt').val();
            $('.show').text(textbox_qua);
            $('.abc').empty();
            $('.append_qua').hide();
            $('.item_qua').show();
            if (curr_qua) {
                var num = curr_qua;
            } else {
                var num = $('.show').text();
            }
            var item_price = $('.curr_price').attr('data-price');
            var fix_price = $('.curr_price').attr('data-fix');
            var product_name = $('.curr_price').attr('data-title');
            var product_id = $('.curr_price').parent().attr('data-id');
            if (curr_qua) {
                $('.current').text(curr_qua);
                var item_total_price = curr_qua * fix_price;
            } else {
                $('.current').text(num);
                var item_total_price = num * fix_price;
            }

            $('.curr_price').text(item_total_price);
            var sum = 0.0;
            $('.item_price').each(function()
            {
                sum += parseFloat($(this).text());
            });
            $('.total_display').text(sum);
            $('#mytxt').replaceWith('<a class="item_qua current qua_css" href="javascript:void(0)" onclick="myAddClass(this)">' + $('.show').text() + '</a>');
//product quantity count             var sum_qua = 0;
            $('.item_qua').each(function()
            {
                sum_qua += parseInt($(this).text());
            });
            $('.tot_quantity').text(sum_qua);
//text box add
//$('#mytxt').replaceWith('<a class="item_qua" href="javascript:void(0)" onclick="myAddClass(this)">' + $('.show').text() + '</a>');
            $('.abc').text($('.show').text());
//text box add end
            $.ajax({
                url: base_url + 'admin_operator/update_session',
                type: "POST",
                data: {product_id: product_id, add_count: num, total_product_price: item_total_price, product_name: product_name, fix_price: fix_price},
                success: function(data) {

                },
                error: function() {
                }
            });
        }
        if (btn_action == 'CLR') {
            $('.bill_item').remove();
            $('.total_display').text('0');
            $('.product_img').removeClass('repeat');
            unsetMySession();
        }
        $('.show').empty();
    }

    function delQua(e) {
        $('#mytxt').val('');
        $('.show').empty();
    }

    function orderPlace(e) {
        var total_amount = $('.total_display').text();
        var grand_amount = $('.total_insert').text();
        var discount = $('.disc_input').val();
        var payment_mode = $('.paymet_class').val();
        var quantity = $('.tot_quantity').text();
        var time_date = $.now();
        if (total_amount > 0) {
            $.ajax({
                url: base_url + 'admin_operator/place_order',
                type: "POST",
                data: {total_amount: total_amount, time_date: time_date, discount: discount, payment_mode: payment_mode, quantity: quantity, grand_amount: grand_amount},
                success: function(data) {
                    if ($('.is_print').is(':checked')) {
                        //window.print('#light');
                        $('.title_product,.item_name').css({"width": "40%", "float": "left"});
                        $('.title_quantity,.qua_css').css({"width": "20%", "float": "left"});
                        $('.title_price,.price_tit').css({"width": "20%", "float": "left"});
                        $('.title_subtotal,.item_price_css').css({"width": "20%", "float": "left"});
                        $('.cancel_btn,.paymet_class,#order_button,.order_button').css('display', 'none');
                        $('.bill_label').css({'float': 'right', 'width': '31%'});
                        $('.bill_label_left').css('float', 'left');

                        var divContents = $("#light").html();
                        var printWindow = window.open('', '', 'height=400,width=500');
                        printWindow.document.write('<html><head><title>DIV Contents</title>');
                        printWindow.document.write('</head><body >');
                        printWindow.document.write(divContents);
                        printWindow.document.write('</body></html>');
                        printWindow.document.close();
                        printWindow.print();

                    }
                    $('#light').css("display", "none");
                    $('#fade').css("display", "none");
                    $('.bill_item').remove();
                    $('.total_display').text('0');
                    $('.product_img').removeClass('repeat');
                    unsetMySession();
                    $("#message_display").fadeIn();
                    $("#message_display").fadeOut(3000);
                },
                error: function() {
                }
            });
        } else {
            alert('please, select product..');
        }
    }

    function unsetMySession() {
        var total_amount = $('.total_display').text();
        $.ajax({
            url: base_url + 'admin_operator/delete_session',
            type: "POST",
            data: {total_amount: total_amount},
            success: function() {

            },
            error: function() {
            }
        });
    }

</script>
<style>
    #footer{ display: none;}
    /*    .navbar{ display: none;}*/
    .main{width: 100%; margin-top: 40px; overflow: hidden;}
    .left{ width: 390px; float: left; background-color: #f9f9f9; border: 1px solid #CCC;}
    .right{ width: 70%; float: left}
    .dissplay_category{ width: 100%;}
    .dissplay_category img{ width: 20px; height: 20px;}
    .dissplay_category ul{ margin: 0px; padding: 0px;}
    .dissplay_category li{ float: left; list-style: none;  font-weight: bold; font-size: 20px; padding-right: 20px; margin: 10px 0 0 10px;}
    .display_product{ width: 100%; float: left; margin-top: 10px; margin-left: 1%;}
    .item_list tr{ float: left; margin-right: 15px; margin-bottom: 10px;}
    .total{ width: 50%; border-bottom: 2px solid; float: left;}
    .total_display{ width: 50%; border-bottom: 2px solid; float: left; }
    .calculate{ width: 100%; height: 260px; overflow: auto; background-color: #fff;}
    .bill_item{ width: 96%; margin-left: 2%; float: left; height: 24px;}
    .item_name{ width: 40%; float: left; border-bottom: 1px solid #ccc;}
    .item_qua{ width: 20%; float: left; border-bottom: 1px solid #ccc; text-align: center;}
    .item_price{ width: 20%; float: left; border-bottom: 1px solid #ccc; text-align: center;}
    .cal_btn{ width: 60%; float: left; margin-left: 15px; }
    .btn_count{border-radius: 0; margin-left: 2px; padding: 21px 27px; font-size: 21px;}
    .btn_count:hover{ background-color: #5579b7;}
    .btn_right{ width: 20%; float: left;}
    .btn_count_right{ width: 100% !important; border-radius: 0; margin-left: 5px; padding: 21px 0px; font-size: 21px;}
    .btn_count_right:hover{ background-color: #5579b7;}
    .show, .total_insert{ display: none; }
    .tot_quantity{ display: none; }
    .order_button_class{ width: 50%; float: left; margin-left: 10px; }
    .order_button{ padding: 10px 20px; margin-top: 5px; }
    .product_img{ height: 100px; width: 100px;}
    .product_img:hover{ opacity: 0.7;}
    .current{ background-color: #FFFF00;}
    .active { background-color: #FFFF00;}
    .abc{ float: left; width: 20%; display: none; }
    .append_qua{ float: left; width: 20%; border-bottom: 1px solid #ccc; text-align: center; display: none;}
    .carousel_slider{ float: left; height: 45px; font-size: 20px; width: 89% !important; }
    .carousel_slider li{ margin: 2px 21px 10px; }
    .prev{ float: left; height: 48px; width: 50px;}
    .next{ float: left; height: 48px; width: 50px;}
    .title_product{ float: left; width: 40%; font-weight: bold; text-align: center;}
    .title_quantity{ float: left; width: 20%; text-align: center; font-weight: bold;}
    .title_subtotal{ float: left; width: 20%; text-align: center; font-weight: bold;}
    .title_price{ float: left; width: 12%; text-align: center; font-weight: bold;}
    .price_tit{ float: left; width: 12%; text-align: center; border-bottom: 1px solid #CCC;}
    .cancel_btn{color: red; float: left; text-align: right; width: 8%; }


    .black_overlay{
        display: none;
        position: absolute;
        top: 0%;
        left: 0%;
        width: 100%;
        height: 100%;
        background-color: black;
        z-index:1001;
        -moz-opacity: 0.8;
        opacity:.80;
        filter: alpha(opacity=80);
    }
    .white_content {
        display: none;
        position: absolute;
        top: 25%;
        left: 25%;
        width: 50%;
        height: 50%;
        padding: 16px;
        border: 16px solid orange;
        background-color: white;
        z-index:1002;
        overflow: auto;
    }
    .bill_title{ float: left; font-size: 24px; font-weight: bold; width: 94%; text-align: center; border-bottom: 2px solid; padding-bottom: 5px; }
    .bill_close{ float: left; font-size: 17px; font-weight: bold; width: 6%; border-bottom: 2px solid; padding-bottom: 5px; }
    .bill_label{ float: left; width: 50%; font-weight: bold; font-size: 18px; border-top: 2px solid; margin-top: 20px;}
    #print_bill{ padding: 19px; font-size: 21px; border-radius: 0;}
    #print_bill:hover{ background-color: #5579b7;}
    #mytxt{ float: left; height: 10px; width: 17%; text-align: center; }
    .white_content .cancel_btn{ display: none;}
    .nav{ display: none !important;}
    .btn_clear_all{border-radius: 0; margin-left: 5px; padding: 19px 24px; font-size: 21px;}
    .btn_clear_all:hover{ background-color: #5579b7;}
    .discount{ float: left; }
    .discount input{ width: 50px; text-align: right; }
    .print_bill{ float: left; margin: 0 10px 0 10px; }
    .print_bill span{ margin-left: 5px;}
    .item_list td{ width: 100%; text-align: center; }
    .paymet_class{ margin-top: 7px; width: 100px; }

    .operator_detail{ color: #fff; font-weight: bold;}
    /*    #load{ background: url(../loading.gif) no-repeat; display: none; position: relative; z-index: 1000; background-position: center center; }*/
    .load{background: url(../loading.gif) no-repeat; position: relative; z-index: 1000; background-position: center center; }
    .pro_dis{ pointer-events: none; cursor: default; }
    .white_content .item_price_css,.white_content .qua_css { width: 20%; float: left; border-bottom: 1px solid #ccc; text-align: center;}
    #message_display{ float: right; bottom: 0; display: none; background-color: #00FF00; padding: 5px 15px; font-weight: bold;}
</style>

<div class="main">
    <div class="left">
        <?php
        $data = $this->session->userdata('my_order');
        $grand = 0;
        $item_quantity = 0;
        if (!empty($data)) {
            foreach ($data as $value) {
                $grand += $value['price'] * $value['quantity'];
                $item_quantity += $value['quantity'];
            }
        }
        $this->session->set_userdata('total_quantity', $item_quantity);
        ?>
        <h1 class="total">Total</h1><h2 class="total_display"><?php echo $grand ?></h2>
        <div style="float: left; width: 100%;">
            <div class="title_product">Product</div>
            <div class="title_quantity">Quantity</div>
            <div class="title_price">Price</div>
            <div class="title_subtotal">Subtotal</div>
        </div>
        <div class="calculate">
            <div class="grand_total"></div>
            <?php
            $data = $this->session->userdata('my_order');

            if (!empty($data)) {
                foreach ($data as $data_session) {
//                    echo "<pre>";
//                    print_r($data_session);
//                    echo "</pre>";
                    ?>
                    <div id="product_<?php echo $data_session['products_id'] ?>" class="bill_item" data-id="<?php echo $data_session['products_id'] ?>">
                        <div href="javascript:void(0)" class='item_name'><?php echo $data_session['title'] ?></div>
                        <a onclick="myAddClass(this)" href="javascript:void(0)" class='item_qua'><?php echo $data_session['quantity'] ?></a><a onclick="myAddClass(this)" href="javascript:void(0)" class="append_qua abc"></a>
                        <div class="price_tit" href="javascript:void(0)"><?php echo $data_session['price'] ?></div>
                        <div href="javascript:void(0)" data-title='<?php echo $data_session['title'] ?>' data-fix='<?php echo $data_session['price'] ?>' data-price='<?php echo $data_session['total'] ?>' class='item_price curr_price'><?php echo $data_session['total'] ?></div>
                        <a onclick="removeItem(this)" class="cancel_btn" href="javascript:void(0)">X</a>
                    </div>
                    <?php
                }
            }
            ?>
        </div>

        <div class="button_all">
            <div class="cal_btn">
                <input class="btn_count" disabled onclick="mynumber(this)" accesskey="49" type="button" value="1">
                <input class="btn_count" disabled onclick="mynumber(this)" accesskey="50" type="button" value="2">
                <input class="btn_count" disabled onclick="mynumber(this)" type="button" value="3">
                <input class="btn_count" disabled onclick="mynumber(this)" type="button" value="4">
                <input class="btn_count" disabled onclick="mynumber(this)" type="button" value="5">
                <input class="btn_count" disabled onclick="mynumber(this)" type="button" value="6">
                <input class="btn_count" disabled onclick="mynumber(this)" type="button" value="7">
                <input class="btn_count" disabled onclick="mynumber(this)" type="button" value="8">
                <input class="btn_count" disabled onclick="mynumber(this)" type="button" value="9">
            </div>
            <div class="btn_right">
                <input class="btn_count_right" disabled onclick="okClear(this)" type="button" value="OK">
                <input class="btn_count_right" disabled onclick="delQua(this)" type="button" value="DEL">
                <input class="btn_count_right" disabled onclick="mynumber(this)" type="button" value="0">
            </div>
            <div class="discount">
                Discount:<input class="disc_input" type="text" name="discount" value="0">%
            </div>
            <div class="order_button_class">
                <input id="print_bill" type="button" value="Order" onclick = "document.getElementById('light').style.display = 'block';
                        document.getElementById('fade').style.display = 'block'">
                <input class="btn_clear_all" onclick="okClear(this)" type="button" value="CLR">
            </div>

            <div class="print_bill">
                <input class="is_print" type="checkbox" name="check_bill"><span>Print Bill</span>
            </div>
            <div id="light" class="white_content">
                <div style="width: 100%; float: left;">
                    <div class="bill_title">Billing</div>
                    <div class="bill_close">
                        <a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display = 'none';
                                document.getElementById('fade').style.display = 'none'">Close</a>
                    </div>
                </div>

                <input id="order_button" class="order_button" onclick="orderPlace(this)" type="button" value="Place Order">
            </div>

            <!--            <div id="pop_up" class="white_content">
                            <div style="width: 100%; float: left;">
                                <div class="bill_close">
                                    <a href = "javascript:void(0)" onclick = "document.getElementById('pop_up').style.display = 'none';
                                            document.getElementById('fade').style.display = 'none'">Close</a>
                                </div>
                            </div>
                        </div>-->



            <div id="fade" class="black_overlay"></div>
        </div>
        <div class="show"></div>
        <div class="tot_quantity"><?php echo $item_quantity; ?></div>
        <div class="total_insert"></div>
    </div>
    <div class="right" id="jcl-demo">
        <button class="prev">«</button>
        <div class="carousel_slider">
            <ul>

                <?php for ($i = 0; $i < count($category); $i++) { ?>
                    <li style="height:20px"><a href="javascript:void(0);" data-id="<?php echo $category[$i]['category_id'] ?>" onclick="myproduct(this)" ><?php echo $category[$i]['category_name'] ?></a></li>
                <?php } ?>

                <?php //foreach ($category as $category_data) {       ?>
<!--                <li style="height:20px"><a href="javascript:void(0);" data-id="<?php echo $category_data['category_id'] ?>" onclick="myproduct(this)" ><?php echo $category_data['category_name'] ?></a></li>-->
                <?php //}         ?>

            </ul>
        </div>
        <button class="next">»</button>
        <div id="display_product" class="display_product">

        </div>
        <div id="message_display">Order Completed</div>
    </div>
</div>