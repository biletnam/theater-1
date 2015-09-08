<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/style.css">
<script src="<?php echo base_url(); ?>assets/js/lib/jquery-1.11.1.js"></script>
<!--<script src=".<?php echo base_url(); ?>assets/js/lib/jquery.easing-1.3.js"></script>-->
<script src="<?php echo base_url(); ?>assets/js/lib/jquery.easing.compatibility.js"></script>
<script src="<?php echo base_url(); ?>assets/js/lib/jquery.mousewheel-3.1.12.js"></script>
<script src="<?php echo base_url(); ?>assets/js/lib/jquery.jcarousellite.min.js"></script>

<script>
    $(document).ready(function () {
        $('body').on('keyup', '.item_qua', function (e) {
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
                var count = new_qua; //$('#mytxt').attr('data-qua');
                var total_price = fix_price * count;
                $('.curr_price').text(total_price);
                var uom = $('.curr_price').attr('data-uom');
                var uom_id = $('.curr_price').attr('data-uom-id');
                $.ajax({
                    url: base_url + 'admin_purchase_material/update_session',
                    type: "POST",
                    data: {product_id: product_id, add_count: count, total_product_price: total_price, product_name: product_name, fix_price: fix_price, uom: uom, uom_id: uom_id},
                    success: function (data) {

                    },
                    error: function () {
                    }
                });
                var sum = 0.0;
                $('.item_qua').each(function ()
                {
                    checkValQty = isCheckedIntOrFloat($(this).text());
//                        calcQty = checkValQty.toFixed(2);
                    //alert(calcQty);
                    sum += checkValQty;
                    //sum_qua += $(this).text();
                });
                $('.total_display').text(sum);
                //product quantity count
                var sum_qua = 0;
                $('.item_qua').each(function ()
                {
                    checkValQty = isCheckedIntOrFloat($(this).text());
//                        calcQty = checkValQty.toFixed(2);
                    //alert(calcQty);
                    sum_qua += checkValQty;
                    //sum_qua += $(this).text();
                });
                $('.tot_quantity').text(sum_qua);
                $('#mytxt').replaceWith('<a class="item_qua current qua_css" href="javascript:void(0)" onclick="myAddClass(this)">' + new_qua + '</a>');
            }
            //end mehul21-08-2015
            $('.current').hide();
            $('.abc').hide();
            $(this).parent().siblings().children().removeClass('current');
            $(this).parent().siblings().children().removeClass('curr_price');
            console.log($(this));
            var qua = $(this).text();
            $('.show').text(qua);
            $(this).replaceWith('<input id="mytxt" data-qua="' + qua + '" type="text" value="' + qua + '"></input>');
            $('#mytxt').focus();
            $('#mytxt').select();
            $('.btn_count').attr('disabled', false);
            $('.btn_count_right').attr('disabled', false);
//            console.log($('#mytxt').siblings());
            $('#mytxt').siblings().addClass('curr_price');
            $('.item_name').removeClass('curr_price');
            $('.price_tit').removeClass('curr_price');
            $('.cancel_btn').removeClass('curr_price');
            $('.append_qua').removeClass('curr_price');
            $('.uom_tit').removeClass('curr_price');
            $('.item_qua').each(function ()
            {
                checkValQty = isCheckedIntOrFloat($(this).text());
//                        calcQty = checkValQty.toFixed(2);
                //alert(calcQty);
                sum_qua += checkValQty;
                //sum_qua += $(this).text();
            });
            //alert(sum_qua);
            $('.tot_quantity').text(sum_qua);
            $('.item_qua').show();
        });
        $('body').on('keyup', '.cancel_btn', function (e) {
            var item_name = $(this).siblings('.item_name').text();
            var fix_price = $(this).siblings('.price_tit').text();
            var product_id = $(this).parent().attr('data-id');
            var uom = $(this).siblings('.uom_tit').children('#uom').find("option:selected").text();
            var uom_id = $(this).siblings('.uom_tit').children('#uom').find("option:selected").val();
            //var total_price = $(this).siblings('.item_price').text();
            //alert(total_price);
            $('.abc').empty();
            $('.append_qua').hide();
            $('.item_qua').show();
            //mehul change


            if ($('#mytxt').val()) {
                var num1 = $('#mytxt').val();
            } else {
                var num1 = $('#mytxt').attr('data-qua');
            }

            //end changes
            //var num1 = $('#mytxt').val();
            var checkVal = isCheckedIntOrFloat(num1);
            //alert(checkVal);
            var convertedQty;
            if (uom === "GM" || uom === "ML") {
                convertedQty = checkVal / 1000;
                var compareVal;
                compareVal = Math.round(convertedQty);
                if (compareVal <= 0) {
                    alert("Please Put Correct GM Qunatity");
                    location.reload();
                    return;
                }
            } else {
                convertedQty = checkVal;
            }

            var num = convertedQty.toFixed(2);
            var total_price1 = num * fix_price;
            var convertedPrice1 = total_price1.toFixed(2);
            var total_price = isCheckedIntOrFloat(convertedPrice1);
            //alert(total_price);
            $.ajax({
                url: base_url + 'admin_purchase_material/update_session',
                type: "POST",
                data: {product_id: product_id, add_count: checkVal, total_product_price: total_price, product_name: item_name, fix_price: fix_price, uom: uom, uom_id: uom_id},
                success: function (data) {
                },
                error: function () {
                }
            });
            var item_price = $('.curr_price').attr('data-fix');
            // console.log('item_price' + item_price);
            var qua_num = $('#mytxt').val();
            // console.log('qua_num' + qua_num);
            if (qua_num == "" || qua_num == ".") {
                //qua_num = 1;
                //mehul changes
                qua_num = $('#mytxt').attr('data-qua');
                //end mehul change
            }
            $('#mytxt').replaceWith('<a class="item_qua qua_css" href="javascript:void(0)" onclick="myAddClass(this)">' + qua_num + '</a>');
            //$('.abc').text(qua_num);
            $('.btn_count').attr('disabled', true);
            $('.btn_count_right').attr('disabled', true);
            var item_total_price1 = num * item_price;
            //alert(item_total_price1);
            var item_total_price = item_total_price1.toFixed(2);
            $('.current').text(num);
            $('.curr_price').text(item_total_price);
            var sum = 0.0;
            $('.item_price').each(function ()
            {
                sum += parseFloat($(this).text());
            });
            var sum1 = sum.toFixed(2);
            $('.total_display').text(sum1);
            var sum_qua = 0;
            $('.item_qua').each(function ()
            {
                checkValQty = isCheckedIntOrFloat($(this).text());
                sum_qua += checkValQty;
            });
            $('.tot_quantity').text(sum_qua);
        });
        $('body').on('keyup', '#mytxt', function (e) {
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if (keycode == '13') {
                $('.abc').empty();
                $('.append_qua').hide();
                $('.item_qua').show();
                var num = $('.show').text();
                var item_price = $('.curr_price').attr('data-price');
                var item_total_price = num * item_price;
                $('.current').text(num);
                $('.curr_price').text(item_total_price);
                var sum = 0.0;
                $('.item_price').each(function ()
                {
                    sum += parseFloat($(this).text());
                });
                $('.total_display').text(sum);
                //product quantity count
                var sum_qua = 0;
                $('.item_qua').each(function ()
                {
                    checkValQty = isCheckedIntOrFloat($(this).text());
                    sum_qua += checkValQty;
                });
                $('.tot_quantity').text(sum_qua);
                //text box add
                $('#mytxt').replaceWith('<a class="item_qua qua_css" href="javascript:void(0)" onclick="myAddClass(this)">' + $('.show').text() + '</a>');
                $('.abc').text($('.show').text());
            }
        });
        $('body').on('keyup', '#mytxt', function (e) {
//            console.log('fourth');
//            alert($('#mytxt').val());
            var stt = $('#mytxt').val();
            $(".show").text(stt);
        });
        $.ajax({
            type: "GET",
            url: base_url + 'admin_purchase_material/get_all_row_material',
            dataType: "html", //expect html to be returned
            success: function (response) {
                $('#display_product').html('<table class="item_list">' + response + '</table>');
                $('.carousel_slider').css('width', '');
                $('.carousel_slider ul').css('margin-top', '13px');
                $('.carousel_slider li').css('width', '');
                //alert(response);
                var sum_qua = 0;
                $('.item_qua').each(function ()
                {
                    checkValQty = isCheckedIntOrFloat($(this).text());
//                        calcQty = checkValQty.toFixed(2);
                    //alert(calcQty);
                    sum_qua += checkValQty;
                    // sum_qua += $(this).text();
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
            url: base_url + 'admin_purchase_material/unset_session',
            type: "POST",
            data: {data_id: data_id},
            success: function () {

            },
            error: function () {
            }
        });
    }

    function myAddClass(e) {

        //mehul changes
        if ($('#mytxt').attr('data-qua')) {
            if ($('#mytxt').val() == "") {
                var new_qua = $('#mytxt').attr('data-qua');
            } else {
                var new_qua = $('#mytxt').val();
            }
            var fix_price = $('.curr_price').attr('data-fix');
            var uom = $('.curr_price').attr('data-uom');
            var uom_id = $('.curr_price').attr('data-uom-id');
            var product_id = $('.curr_price').parents().attr('data-id');
            var product_name = $('#mytxt').siblings('.item_name').text();
            var count = new_qua; //$('#mytxt').attr('data-qua');
            var total_price = fix_price * count;
            $('.curr_price').text(total_price);
            $.ajax({
                url: base_url + 'admin_purchase_material/update_session',
                type: "POST",
                data: {product_id: product_id, add_count: count, total_product_price: total_price, product_name: product_name, fix_price: fix_price, uom: uom, uom_id: uom_id},
                success: function (data) {

                },
                error: function () {
                }
            });
            var sum = 0.0;
            $('.item_price').each(function ()
            {
                sum += parseFloat($(this).text());
            });
            $('.total_display').text(sum);
            //product quantity count

            var sum_qua = 0;
            $('.item_qua').each(function ()
            {
                checkValQty = isCheckedIntOrFloat($(this).text());
                sum_qua += checkValQty;
            });
            $('.tot_quantity').text(sum_qua);
            $('#mytxt').replaceWith('<a class="item_qua current qua_css" href="javascript:void(0)" onclick="myAddClass(this)">' + new_qua + '</a>');
        }

        $(e).addClass('current');
        $(e).siblings().addClass('curr_price');
        $('.item_name').removeClass('curr_price');
        $('.uom_tit').removeClass('curr_price');
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
        $(e).replaceWith('<input id="mytxt" class="found" type="text" value="' + before_qua + '" data-qua="' + before_qua + '"></input>');
        $('.show').text('');
        $('#mytxt').focus();
        $('#mytxt').select();
        $('.btn_count').removeAttr('disabled', false);
        $('.btn_count_right').removeAttr('disabled', false);
        //test
    }
    function isCheckedIntOrFloat(n) {
        if (n % 1 === 0) {
            return parseInt(n);
        } else {
            return parseFloat(n);
        }

    }

    function myproduct(e)
    {
        $(e).addClass('active');
        $(e).parent().siblings().children().removeClass('active');
        $('.btn_count').removeAttr('disabled');
        var id = $(e).attr('data-id');
        $.ajax({
            url: base_url + 'admin_purchase_material/get_product_by_category',
            type: "POST",
            data: {category_id: id},
            success: function (data) {
                $('#display_product').html('<table class="item_list">' + data + '</table>');
            },
            error: function () {
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
            if ($('#mytxt').val() === "" || $('#mytxt').val() === ".") {
                var new_qua = $('#mytxt').attr('data-qua');
            } else {
                var new_qua = $('#mytxt').val();
            }
            //alert(new_qua);

            var fix_price = $('.curr_price').attr('data-fix');
            var product_id = $('.curr_price').parents().attr('data-id');
            var uom = $('.curr_price').attr('data-uom');
            var uom_id = $('.curr_price').attr('data-uom-id');
            var product_name = $('#mytxt').siblings('.item_name').text();
            //alert(uom);

            if (uom === "GM" || uom === "ML") {
                convertedQty = new_qua / 1000;
            } else {
                convertedQty = new_qua;
            }

            //alert(convertedQty);
            var count = convertedQty; //$('#mytxt').attr('data-qua');
            var total_price = fix_price * count;
            $('.curr_price').text(total_price);
            $.ajax({
                url: base_url + 'admin_purchase_material/update_session',
                type: "POST",
                data: {product_id: product_id, add_count: new_qua, total_product_price: total_price, product_name: product_name, fix_price: fix_price, uom: uom, uom_id: uom_id},
                success: function (data) {

                },
                error: function () {
                }
            });
            var sum = 0.0;
            $('.item_price').each(function ()
            {
                sum += parseFloat($(this).text());
            });
            $('.total_display').text(sum);
            //product quantity count
            var sum_qua = 0;
            $('.item_qua').each(function ()
            {
                checkValQty = isCheckedIntOrFloat($(this).text());
                sum_qua += checkValQty;
            });
            $('.tot_quantity').text(sum_qua);
            $('#mytxt').replaceWith('<a class="item_qua current qua_css" href="javascript:void(0)" onclick="myAddClass(this)">' + new_qua + '</a>');
        }

        //end mehul 21-08-2015
        $("a").addClass('pro_dis');
        $('.main').addClass('load');
        //$("#load").show().delay(5000).fadeOut();

        var data_id = $(e).attr('data-id');
        if (jQuery.inArray(data_id, arr_data) != -1) {
            //arr_data.push(data_id);
        } else {
            arr_data.push(data_id);
        }
        //alert(arr_data);

        if ($(e).children().hasClass('repeat')) {
            //edit_val = $('#mytxt').val();
            //mehul changes
            edit_val = $('#mytxt').attr('data-qua');
            //end mehul changes
            if (edit_val) {
                $('#mytxt').replaceWith('<a class="item_qua current qua_css" href="javascript:void(0)" onclick="myAddClass(this)">' + edit_val + '</a>');
            }
            var product_id = $(e).attr('data-id');
            var id_name = 'product_' + product_id;
            var product_count = $('#' + id_name).children('.item_qua').text();

            var product_name = $('#' + id_name).children('.item_name').text();
            var uom = $('#' + id_name).children().children('#uom').find("option:selected").text();
            var uom_id = $('#' + id_name).children().children('#uom').find("option:selected").val();
            //product_count_float = parseFloat(product_count);
            var fixedQty;
            var product_count_value = isCheckedIntOrFloat(product_count);
            if (uom === "GM" || uom === "ML") {
                fixedQty = 1000;

            } else {
                fixedQty = 1;

            }
            var add_count = product_count_value + fixedQty;
            if (uom === "GM" || uom === "ML") {
                convertedQty = add_count / 1000;
            } else {
                convertedQty = add_count;
            }
            $('#' + id_name).children('.item_qua').text(add_count.toFixed(2));
            var fix_price = $('#' + id_name).children('.price_tit').text();
            var total_product_price = convertedQty * fix_price;
            //alert(convertedQty);
            $('#' + id_name).children('.item_price').text(total_product_price.toFixed(2));
            $.ajax({
                url: base_url + 'admin_purchase_material/update_session',
                type: "POST",
                data: {product_id: product_id, add_count: add_count, total_product_price: total_product_price, product_name: product_name, fix_price: fix_price, uom: uom, uom_id: uom_id},
                success: function (data) {
                    var sum = 0.0;
                    $('.item_price').each(function ()
                    {
                        sum += parseFloat($(this).text());
                    });
                    var sum_value = isCheckedIntOrFloat(sum);
                    $('.total_display').text(sum_value);
                    var sum_qua = 0.00;
                    $('.item_qua').each(function ()
                    {
                        checkValQty = isCheckedIntOrFloat($(this).text());
                        sum_qua += checkValQty;
                    });
                    $('.tot_quantity').text(sum_qua);
                    $('.main').removeClass('load');
                    $("a").removeClass('pro_dis');
                },
                error: function () {
                }
            });
        } else {
            //mehul changes
            edit_val = $('#mytxt').attr('data-qua');
            //end mehul changes
            if (edit_val) {
                $('#mytxt').replaceWith('<a class="item_qua current qua_css" href="javascript:void(0)" onclick="myAddClass(this)">' + edit_val + '</a>');
            }
            var qua = $(e).attr('data-id');
            $('.item_qua').removeClass('current');
            $('.item_price').removeClass('curr_price');
            $('.total_display').text();
            var product_id = $(e).attr('data-id');
            var final_total = $('.total_display').text();
            comm = "";
            $.ajax({
                url: base_url + 'admin_purchase_material/get_row_material',
                type: "POST",
                data: {products_id: product_id, final_total: final_total},
                success: function (data) {
                    $('.show').text('');
                    $(e).children().addClass('repeat');
                    $('.calculate').append('<div data-id="' + product_id + '" id="product_' + product_id + '" class="bill_item">' + data + '</div>');
                    var num = $('.current').text();
                    var item_price = $('.curr_price').attr('data-price');
                    var item_total_price = num * item_price;
                    $('.current').text(num);
                    $('.curr_price').text(item_total_price);
                    var sum = 0.0;
                    $('.item_price').each(function ()
                    {
                        sum += parseFloat($(this).text());
                    });

                    $('.total_display').text(sum);
                    //product quantity count
                    var sum_qua = 0;
                    $('.item_qua').each(function ()
                    {
                        checkValQty = isCheckedIntOrFloat($(this).text());
//                        calcQty = checkValQty.toFixed(2);
                        //alert(calcQty);
                        sum_qua += checkValQty;
                        //sum_qua += $(this).text();
                    });
                    //alert(sum_qua);
                    $('.tot_quantity').text(sum_qua);
                    $('.main').removeClass('load');
                    $("a").removeClass('pro_dis');
                },
                error: function () {
                }
            });
        }


        var product_id = $(e).attr('data-id');
        var id_name = 'product_' + data_id;
        var product_count_1 = $('#' + id_name).children('.item_qua').text();
        //alert(product_count_1);
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
        $('.current').replaceWith('<input id="mytxt" data-qua="' + item_quantity + '" type="text" value="' + item_quantity + '"></input>');
        $('#mytxt').val($('.show').text());
//        $('.show').text('');
        new_qua = $('#mytxt').val();
    }
    function okClear(e) {
        var btn_action = $(e).val();
        if (btn_action == 'OK') {
            $('.btn_count').attr('disabled', true);
            $('.btn_count_right').attr('disabled', true);

            var item_price = $('.curr_price').attr('data-price');
            var fix_price = $('.curr_price').attr('data-fix');
            var product_name = $('.curr_price').attr('data-title');
            var product_id = $('.curr_price').parent().attr('data-id');
            var uom = $('.curr_price').attr('data-uom');
            var uom_id = $('.curr_price').attr('data-uom-id');

            var curr_qua = $('.current').text();

            var textbox_qua1 = $('#mytxt').val();

            var checkVal = isCheckedIntOrFloat(textbox_qua1);
            var textbox_qua = checkVal.toFixed(2);
            if (textbox_qua1 === "" || textbox_qua1 === ".") {
                if (uom === "GM" || uom === "ML") {
                    textbox_qua1 = 1000;
                } else {
                    textbox_qua1 = 1;
                }

            } else {
                textbox_qua1 = textbox_qua;
            }
            $('.show').text(textbox_qua1);
            $('.abc').empty();
            $('.append_qua').hide();
            $('.item_qua').show();
            if (curr_qua) {
                var num = curr_qua;
            } else {
                var num = $('.show').text();
            }
            var convertedQty;
            if (uom === "GM" || uom === "ML") {
                convertedQty = num / 1000;
            } else {
                convertedQty = num;
            }
            var item_total_price;
            var convertedItemPrice;
            if (curr_qua) {
                $('.current').text(curr_qua);
                item_total_price = curr_qua * fix_price;
            } else {
                $('.current').text(convertedQty);
                item_total_price = convertedQty * fix_price;
                convertedItemPrice = item_total_price.toFixed(2);
            }

            $('.curr_price').text(convertedItemPrice);
            var sum = 0.0;
            var convertedSum;
            $('.item_price').each(function ()
            {
                sum += parseFloat($(this).text());
                convertedSum = sum.toFixed(2);
            });
            $('.total_display').text(convertedSum);
            $('#mytxt').replaceWith('<a class="item_qua current qua_css" href="javascript:void(0)" onclick="myAddClass(this)">' + $('.show').text() + '</a>');
            //product quantity count
            var sum_qua = 0;
            $('.item_qua').each(function ()
            {
                checkValQty = isCheckedIntOrFloat($(this).text());
//                        calcQty = checkValQty.toFixed(2);
                //alert(calcQty);
                sum_qua += checkValQty;
                //sum_qua += $(this).text();
            });
            $('.tot_quantity').text(sum_qua);
//text box add
            //$('#mytxt').replaceWith('<a class="item_qua" href="javascript:void(0)" onclick="myAddClass(this)">' + $('.show').text() + '</a>');
            $('.abc').text($('.show').text());
            //text box add end
            $.ajax({
                url: base_url + 'admin_purchase_material/update_session',
                type: "POST",
                data: {product_id: product_id, add_count: num, total_product_price: item_total_price, product_name: product_name, fix_price: fix_price, uom: uom, uom_id: uom_id},
                success: function (data) {

                },
                error: function () {
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
        //var grand_amount = $('.total_insert').text();
        //var discount = $('.disc_input').val();
        //var payment_mode = $('.paymet_class').val();
        var total_quantity = $('.tot_quantity').text();
        //alert(total_quantity);
        var time_date = $.now();
        if (total_amount > 0) {
            $.ajax({
                url: base_url + 'admin_purchase_material/place_order',
                type: "POST",
                data: {total_amount: total_amount, total_quantity: total_quantity},
                success: function (data) {
                    if ($('.is_print').is(':checked')) {
                        window.print('#light');
                    }
                    $('#light').css("display", "none");
                    $('#fade').css("display", "none");
                    $('.bill_item').remove();
                    $('.total_display').text('0');
                    $('.product_img').removeClass('repeat');
                    unsetMySession();
                },
                error: function () {
                }
            });
        } else {
            alert('please, select product..');
        }
    }

    function unsetMySession() {
        var total_amount = $('.total_display').text();
        $.ajax({
            url: base_url + 'admin_purchase_material/delete_session',
            type: "POST",
            data: {total_amount: total_amount},
            success: function () {

            },
            error: function () {
            }
        });
    }

    function perUom(e) {
        if ($('#mytxt').attr('data-qua')) {
            if ($('#mytxt').val() == "") {
                var new_qua = $('#mytxt').attr('data-qua');
            } else {
                var new_qua = $('#mytxt').val();
            }
            var fix_price = $('.curr_price').attr('data-fix');
            var uom = $('.curr_price').attr('data-uom');
            var uom_id = $('.curr_price').attr('data-uom-id');
            var product_id = $('.curr_price').parents().attr('data-id');
            var product_name = $('#mytxt').siblings('.item_name').text();
            var count = new_qua; //$('#mytxt').attr('data-qua');             var total_price = fix_price * count;
            $('.curr_price').text(total_price);
            $.ajax({
                url: base_url + 'admin_purchase_material/update_session',
                type: "POST",
                data: {product_id: product_id, add_count: count, total_product_price: total_price, product_name: product_name, fix_price: fix_price, uom: uom, uom_id: uom_id},
                success: function (data) {

                },
                error: function () {
                }
            });
            var sum = 0.0;
            $('.item_price').each(function ()
            {
                sum += parseFloat($(this).text());
            });
            $('.total_display').text(sum);
            //product quantity count

            var sum_qua = 0;
            $('.item_qua').each(function ()
            {
                checkValQty = isCheckedIntOrFloat($(this).text());
                sum_qua += checkValQty;
            });
            $('.tot_quantity').text(sum_qua);
            $('#mytxt').replaceWith('<a class="item_qua current qua_css" href="javascript:void(0)" onclick="myAddClass(this)">' + new_qua + '</a>');
        }
        var fixPrice = 1000;
        var convertQty;
        var subTotal;
        var priceCal;
        var fix_price;
        var checkValQty;
        var num;
        var checkVal;
        var product_id;
        var total_price;
        var item_name;
        var uom_id;
        var uom;
        var qty;
        var tot;
        qty = $(e).parent().siblings('.item_qua').text();
        uom_id = e.value;
        uom = e.options[e.selectedIndex].innerHTML;

        // alert(e.selectedIndex);

        if (uom === "GM" || uom === "ML") {
            convertQty = qty * fixPrice;
        } else {
            convertQty = qty / fixPrice;
        }
        fix_price = $(e).parent().siblings('.price_tit').text();
        tot = $(e).parent().siblings('.item_price').text();
        //alert(tot);
        priceCal = convertQty * fix_price;
        subTotal = priceCal.toFixed(2);
        // alert(subTotal);
        //Put Converted Quantity on change uom
        $(e).parent().siblings('.item_qua').html(convertQty);
        //Put Converted Sub Total on change uom
        //$(e).parent().siblings('.item_price').html(subTotal);

        var sum = 0.0;
        $('.item_price').each(function ()
        {
            sum += parseFloat($(this).text());
        });
        var sum1 = sum.toFixed(2);
        $('.total_display').text(sum1);
        var sum_qua = 0;
        $('.item_qua').each(function ()
        {
            checkValQty = isCheckedIntOrFloat($(this).text());
            sum_qua += checkValQty;
        });
        $('.tot_quantity').text(sum_qua);
        product_id = $(e).parent().parent().attr('data-id');
        //console.log();
        //replace uom and uom id on change dropdown
        $(e).parent().siblings('.item_price').attr('data-uom', uom);
        $(e).parent().siblings('.item_price').attr('data-uom-id', uom_id);
        //end replace

        item_name = $(e).parent().siblings(".item_name").text();
        checkVal = isCheckedIntOrFloat(convertQty);
        num = checkVal.toFixed(2);
        total_price = isCheckedIntOrFloat(tot);
        $.ajax({
            url: base_url + 'admin_purchase_material/update_session',
            type: "POST",
            data: {product_id: product_id, add_count: num, total_product_price: total_price, product_name: item_name, fix_price: fix_price, uom: uom, uom_id: uom_id},
            success: function (data) {
            },
            error: function () {
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
    .bill_item{ border-bottom: 1px solid #ccc;float: left;height: 24px;width: 96%;}
    .item_name{ width: 30%; float: left;  text-align: center;}
    .item_qua{ width: 17%; float: left;  text-align: center;}
    .item_price{ width: 17%; float: left;  text-align: center;}
    .uom_tit{ width:18%; float: left;  text-align: center;}
    .cal_btn{ width: 52%; float: left;}
    .btn_count{border-radius: 0; margin-left: 2px; padding: 19px 24px; font-size: 21px;}
    .btn_count:hover{ background-color: #5579b7;}
    .btn_right{ width: 20%; float: left;}
    .btn_count_right{ width: 100% !important; border-radius: 0; margin-left: 5px; padding: 19px 24px; font-size: 21px;}
    .btn_count_right:hover{ background-color: #5579b7;}
    .show, .total_insert{ display: none;}
    .tot_quantity{ display: none;}
    .order_button_class{ width: 50%; float: left; margin-left: 10px; }
    .order_button{ padding: 10px 20px; margin-top: 5px; }
    .product_img{ height: 100px; width: 100px;}
    .product_img:hover{ opacity: 0.7;}
    .current{ background-color: #FFFF00;}
    .active { background-color: #FFFF00;}
    .abc{ float: left; width: 20%; display: none; }
    .append_qua{ float: left; width: 20%;  text-align: center; display: none;}
    .carousel_slider{ float: left; height: 45px; font-size: 20px; width: 89% !important; }
    .carousel_slider li{ margin: 2px 21px 10px; }
    .prev{ float: left; height: 48px; width: 50px;}
    .next{ float: left; height: 48px; width: 50px;}
    .title_product{ float: left; width: 30%; font-weight: bold; text-align: center;}
    .title_quantity{ float: left; width: 20%; text-align: center; font-weight: bold;}
    .title_subtotal{ float: left; width: 20%; text-align: center; font-weight: bold;}
    .title_price{ float: left; width: 12%; text-align: center; font-weight: bold;}
    .title_uom{float: left;font-weight: bold;text-align: center;width: 15%;}
    .price_tit{ float: left; width: 12%; text-align: center; }
    .cancel_btn{color: red; float: left; text-align: right; }


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
    .save{ padding: 19px; font-size: 21px; border-radius: 0;}
    .save:hover{ background-color: #5579b7;}
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
    .white_content .item_price_css,.white_content .qua_css { width: 20%; float: left;  text-align: center;}
</style>

<div class="main">
    <div class="left">
        <?php
        $data = $this->session->userdata('my_order');
        $grand = 0;
        $item_quantity = 0;
        if (!empty($data)) {
            foreach ($data as $value) {
                $uom_session = $value['uom'];
                $perProductQty = $value['qty'];
                if ($uom_session == "GM" || $uom_session == "ML") {
                    $qty = $perProductQty / 1000;
                } else {
                    $qty = $perProductQty;
                }
                $grand += $value['price'] * $qty;
                $item_quantity += $value['qty'];
            }
        }
        $this->session->set_userdata('total_quantity', $item_quantity);
        ?>
        <h1 class="total">Total</h1><h2 class="total_display"><?php echo $grand ?></h2>
        <div style="float: left; width: 96%;">
            <div class="title_product">Product</div>
            <div class="title_quantity">Quantity</div>
            <div class="title_uom">UOM</div>
            <div class="title_price">Price</div>
            <div class="title_subtotal">Subtotal</div>
        </div>
        <div class="calculate">
            <div class="grand_total"></div>
            <?php
            $data = $this->session->userdata('my_order');
            if (!empty($data)) {
                foreach ($data as $data_session) {
                    $uom_val = $data_session['uom_id'];
                    $where = " AND uom_id={$uom_val}";
                    $uom_unit = $this->common_model->getFieldData('uom', 'uom', $where);

                    if ($uom_unit == "KG" || $uom_unit == "GM") {
                        $where_uom_id = " AND (uom_id='" . KG_VAL . "' OR uom_id = '" . GM_VAL . "')";
                    } else {
                        $where_uom_id = " AND (uom_id='" . LTR_VAL . "' OR uom_id = '" . ML_VAL . "')";
                    }
                    $uom_opt = $this->common_model->getDDArray('uom', 'uom_id', 'uom', $where_uom_id);
                    unset($uom_opt['']);
                    ?>
                    <div id="product_<?php echo $data_session['products_id'] ?>" class="bill_item" data-id="<?php echo $data_session['products_id'] ?>">
                        <div href="javascript:void(0)" class='item_name'><?php echo $data_session['title'] ?></div>
                        <a onclick="myAddClass(this)" href="javascript:void(0)" class='item_qua'><?php echo $data_session['qty'] ?></a><a onclick="myAddClass(this)" href="javascript:void(0)" class="append_qua abc"></a>
                        <div class="uom_tit" href="javascript:void(0)">
                            <?php
                            $js = "perUom(this)";
                            $attribute = 'id="uom"  onchange="' . $js . '"';
                            echo form_dropdown('uom', $uom_opt, $data_session['uom_id'], $attribute);
                            ?>
                        </div>
                        <div class="price_tit" href="javascript:void(0)"><?php echo $data_session['price'] ?></div>
                        <div href="javascript:void(0)" data-uom="<?php echo $data_session['uom'] ?>" data-uom-id="<?php echo $data_session['uom_id'] ?>" data-title='<?php echo $data_session['title'] ?>' data-fix='<?php echo $data_session['price'] ?>' data-price='<?php echo $data_session['total'] ?>' class='item_price curr_price'><?php echo $data_session['total'] ?></div>
                        <a onclick="removeItem(this)" class="cancel_btn" href="javascript:void(0)">X</a>
                    </div>
                    <?php
                }
            }
            ?>
        </div>

        <div class="button_all">
            <div class="cal_btn">
                <input class="btn_count" id="btn_count" disabled onclick="mynumber(this)" type="button" value="1" >
                <input class="btn_count" id="btn_count" disabled onclick="mynumber(this)"  type="button" value="2" >
                <input class="btn_count"  id="btn_count" disabled onclick="mynumber(this)" type="button" value="3" >
                <input class="btn_count" id="btn_count" disabled onclick="mynumber(this)" type="button" value="4" >
                <input class="btn_count" id="btn_count" disabled onclick="mynumber(this)" type="button" value="5" >
                <input class="btn_count" id="btn_count" disabled onclick="mynumber(this)" type="button" value="6" >
                <input class="btn_count" id="btn_count" disabled onclick="mynumber(this)" type="button" value="7" >
                <input class="btn_count" id="btn_count" disabled onclick="mynumber(this)" type="button" value="8" >
                <input class="btn_count" id="btn_count" disabled onclick="mynumber(this)" type="button" value="9" >

            </div>
            <div class="btn_right">
                <input class="btn_count_right" disabled onclick="okClear(this)" type="button" value="OK" >
                <input class="btn_count_right" disabled onclick="mynumber(this)" type="button" value="0">
                <input class="btn_count_right" disabled onclick="mynumber(this)" type="button" value=".">
<!--                <input class="btn_count_right" disabled onclick="delQua(this)" type="button" value="DEL" >-->
            </div>
            <div class="order_button_class">
                <input class="btn_clear_all" onclick="okClear(this)" type="button" value="CLR">
                <input id="order_button" class="save" onclick="orderPlace(this)" type="button" value="Save">
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
            <div id="pop_up" class="white_content">
                <div style="width: 100%; float: left;">
                    <div class="bill_close">
                        <a href = "javascript:void(0)" onclick = "document.getElementById('pop_up').style.display = 'none';
                                document.getElementById('fade').style.display = 'none'">Close</a>
                    </div>
                </div>
            </div>
            <div id="fade" class="black_overlay"></div>
        </div>
        <div class="show"></div>
        <div class="tot_quantity"><?php echo $item_quantity; ?></div>
        <div class="total_insert"></div>
    </div>
    <div class="right">
        <div id="display_product" class="display_product"></div>
    </div>
</div>