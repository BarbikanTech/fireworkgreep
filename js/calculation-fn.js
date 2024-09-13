var price_regex = /^(\d*\.)?\d+$/;
var numbers_regex = /^\d+$/;

function qntAmountCal(obj) {
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
        console.log(selected_rate);
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
    } else {
        console.log("its not Worked");
    }
}


function CheckDecimal(check_number) {
    if (check_number != '' && check_number != 0) {
        var decimal = ""; var numbers = "";
        numbers = check_number.toString().split('.');
        if (typeof numbers[1] != 'undefined') {
            decimal = numbers[1];
            if (decimal != "" && decimal != 0) {
                if (decimal.length == 1) {
                    decimal = decimal + '0';
                    check_number = numbers[0] + '.' + decimal;
                }
                if (decimal.length > 2) {
                    check_number = check_number.toFixed(2);
                }
            }
            else {
                check_number = numbers[0] + '.00';
            }
        }
    }
    return check_number;
}