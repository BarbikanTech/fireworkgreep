var price_regex = /^(\d*\.)?\d+$/;
var numbers_regex = /^\d+$/;


function showCartPage() {

    if (jQuery('.card_products_table').find('tr.product_row').length > 0) {
        jQuery('.card_products_table').find('tr.product_row').each(function () { jQuery(this).remove(); });
    }



    if (jQuery('.pricelist_products').find('.product_row').length > 0) {
        jQuery('.pricelist_products').find('.product_row').each(function () {
            var amount = jQuery(this).find('.amount').find('input[type="text"]').val();
            if (typeof amount != "undefined" && amount != "") {
                var product_id = ""; var quantity = "";
                var product_name = "";
                var product_content = "";
                var product_amount = "";
                var product_total_amount = "";
                var product_img = "";

                product_id = jQuery(this).find('.product_name').attr('id');
                product_img = jQuery(this).find('.product-img').html();
                product_name = jQuery(this).find('.product_name').html();
                product_content = jQuery(this).find('.product-content').html().trim();
                product_amount = jQuery(this).find('.price').html().trim();
                var quantity = jQuery('.quantity_' + product_id).val();
                product_total_amount = product_amount * quantity;
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
                    var product_row_content = '<tr class="product_row"><td class="text-center"><div class="product-img text-center pb-2">' + product_img + '</div></td><td class="product_name text-left" style="width:100%" id="' + product_id + '"> ' + product_name + ' (' + product_content + ')</td><td class="quantity text-center"><Form><input type="text" class="prdct-box quantity_' + product_id + '" placeholder="Qty" value="' + quantity + '" onFocus="Javascript:CartProductCalculation(this);" onBlur="Javascript:CartProductCalculation(this);" onKeyup="Javascript:CartProductCalculation(this);" onChange="Javascript:CartProductCalculation(this);">\n<span class="actual_price">' + product_amount + '</span></Form></td><td class="amount text-center"><span class="pro_total_price_' + product_id + '">' + product_total_amount + '</span></td><td class="amount text-center"><span class="fa fa-times"></span></td></tr>';
                    product_row_content = jQuery("#demo").append(product_row_content);
                    // if (product_row_content != "undefined" && product_row_content != "") {
                    //     if (jQuery('.card_products_table').length > 0) {
                    //         product_row_content = product_row_content + '<td class="text-center"><a href="Javascript:DeleteCartProduct(' + "'" + product_id + "'" + ');"><span class="fa fa-times"></span></a></td>';
                    //         jQuery('.card_products_table').find('tbody').append('<tr class="product_row cart_product_' + product_id + '">' + product_row_content + '</tr>');
                    //     }
                    //     if (jQuery('.card_products_table').find('.quantity_' + product_id).length > 0) {
                    //         jQuery('.card_products_table').find('.quantity_' + product_id).val(quantity);
                    //     }
                    //     if (jQuery('.card_products_table').find('.amount_' + product_id).length > 0) {
                    //         jQuery('.card_products_table').find('.amount_' + product_id).find('input[type="text"]').val(amount);
                    //     }
                    //     jQuery('.card_products_table').find('tr.product_row').each(function () {
                    //         if (jQuery(this).find('td.product_image').length > 0) {
                    //             jQuery(this).find('td.product_image').remove();
                    //         }
                    //         if (jQuery(this).find('td.product_code').length > 0) {
                    //             jQuery(this).find('td.product_code').remove();
                    //         }
                    //         if (jQuery(this).find('span.xsmall_visible').length > 0) {
                    //             jQuery(this).find('span.xsmall_visible').remove();
                    //         }
                    //         if (jQuery(this).find('td.product_content').length > 0) {
                    //             jQuery(this).find('td.product_content').remove();
                    //         }
                    //     });
                    // }
                }
            }
        });
    }

    if (jQuery('.cart_modal_button').length > 0) {
        jQuery('.cart_modal_button').trigger("click");
    }
}

function CartProductCalculation(obj) {
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

    if (jQuery(obj).parent().parent().find('.actual_price').length > 0) {
        selected_rate = jQuery(obj).parent().parent().find('.actual_price').html();

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
            console.log("product length - " + jQuery(obj).parent().parent().parent().find('.product_name').length);
            if (jQuery(obj).parent().parent().parent().find('.product_name').length > 0) {

                var product_id = "";
                product_id = jQuery(obj).parent().parent().parent().find('.product_name').attr('id');

                if (typeof product_id != "undefined" && product_id != "") {
                    if (jQuery('.pro_total_price_' + product_id).length > 0) {
                        jQuery('.pro_total_price_' + product_id).html(selected_amount);
                    }
                    if (jQuery('.quantity_' + product_id).length > 0) {
                        jQuery('.quantity_' + product_id).val(selected_quantity);
                    }
                    if (jQuery('.amount_' + product_id).length > 0) {
                        jQuery('.amount_' + product_id).val(selected_amount);
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
            if (jQuery(obj).parent().parent().parent().find('.product_name').length > 0) {
                var product_id = "";
                product_id = jQuery(obj).parent().parent().parent().find('.product_name').attr('id');
                if (typeof product_id != "undefined" && product_id != "") {
                    if (jQuery('.pro_total_price_' + product_id).length > 0) {
                        jQuery('.pro_total_price_' + product_id).html('');
                    }
                    if (jQuery('.quantity_' + product_id).length > 0) {
                        jQuery('.quantity_' + product_id).html('');
                    }
                    if (jQuery('form[name="order_form"]').find('.product' + product_id).length > 0) {
                        jQuery('form[name="order_form"]').find('.product' + product_id).remove();
                    }
                    if (jQuery('.amount_' + product_id).length > 0) {
                        jQuery('.amount_' + product_id).val('');
                    }
                }
            }
        }
    }
    else {
        if (jQuery(obj).parent().parent().parent().find('.product_name').length > 0) {
            var product_id = "";
            product_id = jQuery(obj).parent().parent().parent().find('.product_name').attr('id');
            if (typeof product_id != "undefined" && product_id != "") {
                if (jQuery('.pro_total_price_' + product_id).length > 0) {
                    jQuery('.pro_total_price_' + product_id).html('');
                }
                if (jQuery('.quantity_' + product_id).length > 0) {
                    jQuery('.quantity_' + product_id).val('');
                }
                if (jQuery('form[name="order_form"]').find('.product' + product_id).length > 0) {
                    jQuery('form[name="order_form"]').find('.product' + product_id).remove();
                }
                if (jQuery('.amount_' + product_id).length > 0) {
                    jQuery('.amount_' + product_id).val('');
                }
            }
        }
    }
    calOverallTotal();
}

function SaveEnquiryForm(event) {
    event.preventDefault();

    var state = document.forms["order_form"]["state"].value;
    var city = document.forms["order_form"]["city"].value;
    var customer_name = document.forms["order_form"]["name"].value;
    var phone = document.forms["order_form"]["Mobile Number"].value;
    var email = document.forms["order_form"]["email"].value;
    var address = document.forms["order_form"]["address"].value;

    var formData = {
        state: state,
        city: city,
        customer_name: customer_name,
        phone: phone,
        email: email,
        address: address
    };

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "submit_form.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                alert("Enquiry form submitted successfully!");
            } else {
                alert("Error submitting enquiry form. Please try again.");
            }
        }
    };
    xhr.send(JSON.stringify(formData));
}