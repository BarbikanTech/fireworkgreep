var price_regex = /^(\d*\.)?\d+$/;
var numbers_regex = /^\d+$/;

function CalProductAmount(obj) {
    var all_errors_check = 1;

    var selected_quantity = "";
    selected_quantity = jQuery(obj).val();
    selected_quantity = selected_quantity.replace(/ /g, '');
    selected_quantity = selected_quantity.trim();
    if (selected_quantity.charAt(0) == 0) {
        selected_quantity = selected_quantity.slice(1);
        selected_quantity = selected_quantity.trim();
    }

    if (typeof selected_quantity != "undefined" && selected_quantity != "" && selected_quantity != 0) {
        if (numbers_regex.test(selected_quantity) == false) {
            all_errors_check = 0;
        }
        else {
            if (parseInt(selected_quantity) >= 10000) {
                selected_quantity = 1;
            }
            jQuery(obj).val(selected_quantity);
        }
    }
    else {
        all_errors_check = 0;
    }

    var selected_rate = "";
    if (jQuery(obj).parent().parent().find('.price').length > 0) {
        selected_rate = jQuery(obj).parent().parent().find('.price').html();
        selected_rate = selected_rate.replace(/ /g, '');
        selected_rate = selected_rate.replace(/,/g, '');
        selected_rate = selected_rate.trim();
        if (typeof selected_rate != "undefined" && selected_rate != "" && selected_rate != 0) {
            if (price_regex.test(selected_rate) == false) {
                all_errors_check = 0;
            }
            else {
                selected_rate = CheckDecimal(selected_rate);
            }
        }
    }

    if (all_errors_check == 1) {

        if ((parseInt(selected_quantity) > 0 && numbers_regex.test(selected_quantity) == true) && price_regex.test(selected_rate) == true) {

            var selected_amount = parseInt(selected_quantity) * parseFloat(selected_rate);
            selected_amount = CheckDecimal(selected_amount);
            if (jQuery(obj).parent().parent().find('.product_name').length > 0) {

                var product_id = "";
                product_id = jQuery(obj).parent().parent().find('.product_name').attr('id');
                if (typeof product_id != "undefined" && product_id != "") {
                    if (jQuery('.amount_' + product_id).length > 0) {
                        jQuery('.amount_' + product_id).val(selected_amount);
                    }
                    if (jQuery('.quantity_' + product_id).length > 0) {
                        jQuery('.quantity_' + product_id).val(selected_quantity);
                    }
                    if (jQuery('form[name="order_form"]').find('.product' + product_id).length > 0) {
                        jQuery('form[name="order_form"]').find('.product' + product_id).val(product_id + '/' + selected_quantity);
                    }
                    else {
                        jQuery('form[name="order_form"]').append('<input type="hidden" name="product_quantity[]" class="product' + product_id + '" value="' + product_id + '/' + selected_quantity + '">');
                    }
                }
            }
        }
        else {
            if (jQuery(obj).parent().parent().find('.product_name').length > 0) {
                var product_id = "";
                product_id = jQuery(obj).parent().parent().find('.product_name').attr('id');
                if (typeof product_id != "undefined" && product_id != "") {
                    if (jQuery('.amount_' + product_id).length > 0) {
                        jQuery('.amount_' + product_id).val('');
                    }
                    if (jQuery('.quantity_' + product_id).length > 0) {
                        jQuery('.quantity_' + product_id).html('');
                    }
                    if (jQuery('form[name="order_form"]').find('.product' + product_id).length > 0) {
                        jQuery('form[name="order_form"]').find('.product' + product_id).remove();
                    }
                }
            }
        }
    }
    else {
        if (jQuery(obj).parent().parent().find('.product_name').length > 0) {
            var product_id = "";
            product_id = jQuery(obj).parent().parent().find('.product_name').attr('id');
            if (typeof product_id != "undefined" && product_id != "") {
                if (jQuery('.amount_' + product_id).length > 0) {
                    jQuery('.amount_' + product_id).val('');
                }
                if (jQuery('.quantity_' + product_id).length > 0) {
                    jQuery('.quantity_' + product_id).html('');
                }
                if (jQuery('form[name="order_form"]').find('.product' + product_id).length > 0) {
                    jQuery('form[name="order_form"]').find('.product' + product_id).remove();
                }
            }
        }
    }

    calOverallTotal();
}

function calOverallTotal() {
    var sub_total = 0; var packing_charges = 0; var packing_charges_value = 0; var overall_total = 0; var product_count = 0; var net_total = 0;
    if (jQuery('.sub_total').length > 0) {
        jQuery('.sub_total').html('');
    }
    if (jQuery('.packing_charges_value').length > 0) {
        jQuery('.packing_charges_value').html('');
    }
    if (jQuery('.round_off').length > 0) {
        jQuery('.round_off').html('');
    }
    if (jQuery('.overall_total').length > 0) {
        jQuery('.overall_total').html('');
    }
    if (jQuery('.product_count').length > 0) {
        jQuery('.product_count').html('');
    }
    if (jQuery('.net_total').length > 0) {
        jQuery('.net_total').html('');

    }

    if (jQuery('.pricelist_products').find('.strike').length > 0) {
        jQuery('.pricelist_products').find('.strike').each(function () {
            var amount = jQuery(this).html();
            var product_id = jQuery(this).parent().parent().find('.product_name').attr('id')
            if (typeof amount != "undefined" && amount != "") {
                amount = amount.replace(/ /g, '');
                amount = amount.trim();
                if (price_regex.test(amount) != false) {
                    // amount = CheckDecimal(amount);
                    // sub_total = parseFloat(sub_total) + parseFloat(amount);
                    // product_count = parseInt(product_count) + 1;
                    var qty = 0;
                    if (jQuery('.quantity_' + product_id).length > 0) {
                        qty = jQuery('.quantity_' + product_id).val();
                    }
                    if (typeof qty != "undefined" && qty != "") {
                        console.log("product qty " + qty);
                        net_total = net_total + (parseFloat(amount) * parseInt(qty));
                    }

                }
            }
        });
    }
    if (net_total > 0) {
        jQuery('.net_total').html("Rs." + net_total);
    }

    if (jQuery('.pricelist_products').find('.product_row').length > 0) {
        jQuery('.pricelist_products').find('.product_row').each(function () {
            var amount = jQuery(this).find('.amount').find('input[type="text"]').val();
            console.log(amount);
            if (typeof amount != "undefined" && amount != "") {
                amount = amount.replace(/ /g, '');
                amount = amount.trim();
                if (price_regex.test(amount) != false) {
                    amount = CheckDecimal(amount);
                    sub_total = parseFloat(sub_total) + parseFloat(amount);
                    product_count = parseInt(product_count) + 1;
                }
            }
        });
        if (typeof product_count != "undefined" && product_count != "" && product_count != 0) {
            if (jQuery('.product_count').length > 0) {
                jQuery('.product_count').html(product_count);
            }
        }
        if (typeof sub_total != "undefined" && sub_total != "" && sub_total != 0) {
            sub_total = CheckDecimal(sub_total);
            overall_total = sub_total;
            if (jQuery('.sub_total').length > 0) {
                jQuery('.sub_total').html('Rs.' + sub_total);
            }
        }

        if (jQuery('.packing_charges').length > 0) {
            packing_charges = jQuery('.packing_charges').html();
            packing_charges = packing_charges.replace(/ /g, '');
            packing_charges = packing_charges.trim();
            if (typeof packing_charges != "undefined" && packing_charges != "" && packing_charges != 0) {
                if (packing_charges.indexOf('%') != -1) {
                    packing_charges = packing_charges.replace("%", "");
                    packing_charges = packing_charges.trim();
                    if (numbers_regex.test(packing_charges) != false) {
                        packing_charges_value = (parseFloat(sub_total) * parseFloat(packing_charges)) / 100;
                        packing_charges_value = CheckDecimal(packing_charges_value);
                    }
                }
                else {
                    if (numbers_regex.test(packing_charges) != false) {
                        packing_charges_value = parseFloat(packing_charges);
                        packing_charges_value = CheckDecimal(packing_charges_value);
                    }
                }

                if (typeof packing_charges_value != "undefined" && packing_charges_value != "" && packing_charges_value != 0) {
                    overall_total = parseFloat(overall_total) + parseFloat(packing_charges_value);
                    if (jQuery('.packing_charges_value').length > 0) {
                        jQuery('.packing_charges_value').html('Rs.' + packing_charges_value);
                    }
                }
            }
        }

        if (typeof overall_total != "undefined" && overall_total != "" && overall_total != 0) {
            overall_total = CheckDecimal(overall_total);
            if (jQuery('.overall_total').length > 0) {
                var decimal = ""; var round_off = '';
                var numbers = overall_total.toString().split('.');
                if (typeof numbers[1] != 'undefined') {
                    decimal = numbers[1];
                }
                if (decimal != "" && decimal != 0) {
                    if (decimal.length == 1) {
                        decimal = decimal + '0';
                    }
                    var round_off = 100 - parseFloat(decimal);
                    if (round_off < 10) {
                        round_off = "0.0" + round_off;
                    }
                    else {
                        round_off = "0." + round_off;
                    }
                    if (typeof round_off != 'undefined' && round_off != '') {
                        jQuery('.round_off').html(round_off);
                        overall_total = parseFloat(overall_total) + parseFloat(round_off);
                    }
                }
                jQuery('.overall_total').html('Rs.' + overall_total);
            }
        }
    }
    var min_total = 2000;
                    
    if(sub_total >= min_total){
     jQuery("#button-enq").html("<span class='btn btn-success'>Confirm Estimate</span>");
      jQuery("#warningMessage").html("");
    }else{
     jQuery("#button-enq").html("");
     jQuery("#warningMessage").html("Your order must be at least ₹2000.");
    }
}

function ShowCart() {
    if (jQuery('.card_products_table').find('tr.product_row').length > 0) {
        jQuery('.card_products_table').find('tr.product_row').each(function () { jQuery(this).remove(); });
    }


    if (jQuery('.pricelist_products').find('.product_row').length > 0) {
        jQuery('.pricelist_products').find('.product_row').each(function () {
            var amount = jQuery(this).find('.amount').find('input[type="text"]').val();
            if (typeof amount != "undefined" && amount != "") {
                var product_id = ""; var quantity = "";
                product_id = jQuery(this).find('.product_name').attr('id');
                if (typeof product_id != "undefined" && product_id != "") {
                    var quantity = jQuery('.quantity_' + product_id).val();
                    quantity = quantity.replace(/ /g, '');
                    quantity = quantity.trim();
                    if (quantity.charAt(0) == 0) {
                        quantity = quantity.slice(1);
                        quantity = quantity.trim();
                    }
                }
                if (typeof quantity != "undefined" && quantity != "" && quantity != 0) {
                    var product_row_content = "";
                    product_row_content = jQuery(this).html();
                    if (product_row_content != "undefined" && product_row_content != "") {
                        if (jQuery('.card_products_table').length > 0) {
                            product_row_content = product_row_content + '<td class="text-center"><a href="Javascript:DeleteCartProduct(' + "'" + product_id + "'" + ');"><img src="order/delete.png" class=" rounded w-75 mx-auto"></a></td>';
                            jQuery('.card_products_table').find('tbody').append('<tr class="product_row cart_product_' + product_id + '">' + product_row_content + '</tr>');
                        }
                        if (jQuery('.card_products_table').find('.quantity_' + product_id).length > 0) {
                            jQuery('.card_products_table').find('.quantity_' + product_id).val(quantity);
                        }
                        if (jQuery('.card_products_table').find('.amount_' + product_id).length > 0) {
                            jQuery('.card_products_table').find('.amount_' + product_id).find('input[type="text"]').val(amount);
                        }
                        jQuery('.card_products_table').find('tr.product_row').each(function () {
                            if (jQuery(this).find('td.product_image').length > 0) {
                                jQuery(this).find('td.product_image').remove();
                            }
                            if (jQuery(this).find('td.product_code').length > 0) {
                                jQuery(this).find('td.product_code').remove();
                            }
                            if (jQuery(this).find('span.xsmall_visible').length > 0) {
                                jQuery(this).find('span.xsmall_visible').remove();
                            }
                            if (jQuery(this).find('td.product_content').length > 0) {
                                jQuery(this).find('td.product_content').remove();
                            }
                        });
                    }
                }
            }
        });
    }

    if (jQuery('.cart_modal_button').length > 0) {
        jQuery('.cart_modal_button').trigger("click");
    }
}

function DeleteCartProduct(product_id) {
    if (typeof product_id != "undefined" && product_id != "") {
        if (jQuery('table.pricelist_products').find('.quantity_' + product_id).length > 0) {
            jQuery('table.pricelist_products').find('.quantity_' + product_id).val('');
        }
        if (jQuery('table.pricelist_products').find('.amount_' + product_id).length > 0) {
            jQuery('table.pricelist_products').find('.amount_' + product_id).find('input[type="text"]').val('');
        }
        if (jQuery('table.card_products_table').find('.quantity_' + product_id).length > 0) {
            jQuery('table.card_products_table').find('.quantity_' + product_id).parent().parent().remove();
        }
         if (jQuery('form[name="order_form"]').find('.product' + product_id).length > 0) {
                    jQuery('form[name="order_form"]').find('.product' + product_id).remove();
                }
        calOverallTotal();
    }
}

function GoToSubmit() {
    if (jQuery('.close_cart').length > 0) {
        jQuery('.close_cart').trigger("click");
    }
    if (jQuery('.submit_button').length > 0) {
        jQuery('.submit_button').trigger("click");
    }

    var top = parseFloat(jQuery('form[name="order_form"]').offset().top) - 100;

    jQuery('html, body').animate({
        scrollTop: (top)
    }, 500);
}

