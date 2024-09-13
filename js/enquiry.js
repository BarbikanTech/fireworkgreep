function SendEnquiry(event, form_name, submit_button, post_send_file) {
    event.preventDefault();
			
    if(jQuery('span.infos').length > 0) {
        jQuery('span.infos').remove();
    }
    if(jQuery('.valid_error').length > 0) {
        jQuery('.valid_error').remove();
    }
    if(jQuery('div.alert').length > 0) {
        jQuery('div.alert').remove();
    }

    if(jQuery('.success-box').length > 0) {
        if(jQuery('.success-box').hasClass('d-none') == false) {
            jQuery('.success-box').addClass('d-none');
        }
    }
    if(jQuery('.error-box').length > 0) {
        if(jQuery('.error-box').hasClass('d-none') == false) {
            jQuery('.error-box').addClass('d-none');
        }
    }

    if(jQuery('form[name="'+form_name+'"]').find('.'+submit_button).length > 0) {
        jQuery('form[name="'+form_name+'"]').find('.'+submit_button).attr('disabled', true);
    }

    jQuery('html, body').animate({
        scrollTop: (jQuery('form[name="'+form_name+'"]').offset().top)
    }, 500);

    var form_content = "";
    form_content = jQuery('form[name="'+form_name+'"]').serialize();

	jQuery.ajax({
		url: post_send_file,
		type: "post",
		async: true,
		data: form_content,
		dataType: 'html',
		contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
		success: function(data) {
			//console.log(data);
			if(typeof data == "undefined" || data == "" || data == null) {
				if(jQuery('form[name="'+form_name+'"]').find('.submit_button').length > 0) {
					jQuery('form[name="'+form_name+'"]').find('.submit_button').attr('disabled', false);
				}
				if(jQuery('div.alert').length > 0) {
					jQuery('div.alert').remove();
				}
			}

			try {
				var x = JSON.parse(data);
			} catch (e) {
				return false;
			}
			//console.log(x);
			
			if(x.number == '1') {
                //jQuery('form[name="'+form_name+'"]').find('.row:first').before('<div class="alert alert-success"> <button type="button" class="close" data-dismiss="alert">&times;</button> '+x.msg+' </div>');
                if(jQuery('.success-box').find('.success_msg').length > 0) {
                    jQuery('.success-box').find('.success_msg').html(x.msg);   
                }
                if(jQuery('.success-box').length > 0) {
                    if(jQuery('.success-box').hasClass('d-none')) {
                        jQuery('.success-box').removeClass('d-none');
                    }
                }
                setTimeout(function(){
                    if(jQuery('.success-box').length > 0) {
                        if(jQuery('.success-box').hasClass('d-none') == false) {
                            jQuery('.success-box').addClass('d-none');
                        }
                    }
                }, 2000);
                if(jQuery('form[name="'+form_name+'"]').find('.'+submit_button).length > 0) {
					jQuery('form[name="'+form_name+'"]').find('.'+submit_button).attr('disabled', false);
				}
			}
			
			if(x.number == '2') {
				//jQuery('form[name="'+form_name+'"]').find('.row:first').before('<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert">&times;</button> '+x.msg+' </div>');
                if(jQuery('.error-box').find('.error_msg').length > 0) {
                    jQuery('.error-box').find('.error_msg').html(x.msg);   
                }
                if(jQuery('.error-box').length > 0) {
                    if(jQuery('.error-box').hasClass('d-none')) {
                        jQuery('.error-box').removeClass('d-none');
                    }
                }
                setTimeout(function(){
                    if(jQuery('.error-box').length > 0) {
                        if(jQuery('.error-box').hasClass('d-none') == false) {
                            jQuery('.error-box').addClass('d-none');
                        }
                    }
                }, 2000);
				if(jQuery('form[name="'+form_name+'"]').find('.'+submit_button).length > 0) {
					jQuery('form[name="'+form_name+'"]').find('.'+submit_button).attr('disabled', false);
				}
			}
			
			if(x.number == '3') {
				jQuery('form[name="'+form_name+'"]').append('<div class="valid_error"> <script type="text/javascript"> '+x.msg+' </script> </div>');
                if(jQuery('form[name="'+form_name+'"]').find('.'+submit_button).length > 0) {
					jQuery('form[name="'+form_name+'"]').find('.'+submit_button).attr('disabled', false);
				}
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
		}
	});
}