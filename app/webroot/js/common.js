function file_upload() {
	// Uploader - Direct
    // dataType: - Only YouTube is official supports Direct, so it alone returns 'json', whereas Scribd/Vimeo, we set return to null //
   // if ($('.js-upload', 'body').is('.js-upload')) {
        $('#fileupload').fileupload( {
            maxNumberOfFiles: 1,
            acceptFileTypes: getFileType(),
            forceIframeTransport: isSetIframeTransport(),
            dataType: ($('#direct_service').val() != null && ($('#direct_service').val() == 'vimeo') ? '': 'json'),
            submit: function(e, data) {
                var $this = $(this);
                $('#ContestUserDescription, #MessageMessage').trigger('blur');
                if (j_validate($this) == 'error') {
					$('.template-upload').find('.start').removeattr('disabled');
                    return false;
                }
                $('.js-upload-cancel').addClass('hide');
                var service = $('#direct_service').val();
                var id = $('#ContestId').val();
                if ($('#MessageRevised').val() != null) {
                    var metadata = {
                        name: data.files[0].name,
                        size: data.files[0].size || null,
                        id: id,
                        description: $('#MessageMessage').val(),
                        service: service,
                        revised: $('#MessageRevised').val()
                        };
                } else {
                    var metadata = {
                        name: data.files[0].name,
                        size: data.files[0].size || null,
                        id: id,
                        description: $('#ContestUserDescription').val(),
                        service: service
                    };
                }
                $('.js-form-uploading').addClass('span5 space label label-warning space');
                $('.js-form-uploading').html('Video uploading...');
                if (service == 'youtube') {
                    $.post(__cfg('path_relative') + 'uploads/direct_metadata.json', metadata, function(result) {
                        if (result.status == 'failed') {
                            location.href = $('#current_url').val();
                        }
                        data.url = result.url + '?nexturl=' + result.nexturl;
                        data.formData = {
                            service: service,
                            token: result.token,
                            contest_id: result.contest_id
                        };
                        $this.fileupload('send', data);
                    });
                } else if (service == 'vimeo') {
                    $.post(__cfg('path_relative') + 'uploads/direct_metadata.json', metadata, function(result) {
                        if (result.status == 'failed') {
                            location.href = $('#current_url').val();
                        }
                        data.formData = {
                            service: service,
                            ticket_id: result.ticket_id,
                            chunk_id: result.chunk_id,
                            upload_token_id: result.upload_token_id,
                            contest_id: result.contest_id,
                            file: data.files[0]
                        };
                        data.url = result.url;
                        $this.fileupload('send', data);
                    });
                }
                return false;
            },
            done: function(e, data) {
                // Updating Progress Bar
                $('.progress .bar').css('width', '100%');
                updateAfterUpload(data);
            }
        }).bind('fileuploadadd', function(e, data) {
            if (data.files[0].name != null) {
				// Fix for chrome
                $('#browseFile').attr('title', data.files[0].name);
            }
        }).bind('fileuploadadded', function(e, data) {
			if ($('.js-template-upload div.progress').length == 1) {
				 	$('.fileupload-buttonbar button').removeClass('disabled');
					$('.fileupload-buttonbar button').removeAttr('disabled');
			 } else {
				 $('.fileupload-buttonbar button').addClass('disabled');
					$('.fileupload-buttonbar button').prop('disabled', true);
			 }
        }).bind('fileuploadfail', function(e, data) {
            $('.js-upload-cancel').removeClass('hide');
        });
   // }
	// Uploader - Normal
   // if ($('.js-upload', 'body').is('.js-upload')) {
        $('#js-normal-fileupload').fileupload( {
            forceIframeTransport: isSetIframeTransport(),
            maxNumberOfFiles: 1,
            acceptFileTypes: getFileType(),
			dataType: '',
            submit: function(e, data) {
				$('#ContestUserDescription, #MessageMessage').trigger('blur');
                var $this = $(this);
                if (j_validate($this) == 'error') {
					$('.template-upload').find('.start').removeattr('disabled');
                    return false;
                }
                $('.js-upload-cancel').addClass('hide');
            },
            done: function(e, data) {
                // Updating Progress Bar
                $('.progress .bar').css('width', '100%');
                location.href = $('#success_redirect_url').val();
            }
        }).bind('fileuploadadd', function(e, data) {
            if (data.files[0].name != null) {
				// Fix for chrome
                $('#browseFile').attr('title', data.files[0].name);
            }
        }).bind('fileuploadadded', function(e, data) {
			if ($('.js-template-upload div.progress').length == 1) {
				 	$('.fileupload-buttonbar button').removeClass('disabled');
					$('.fileupload-buttonbar button').removeAttr('disabled');
			 } else {
				 $('.fileupload-buttonbar button').addClass('disabled');
					$('.fileupload-buttonbar button').prop('disabled', true);
			 }
        }).bind('fileuploadfail', function(e, data) {
            $('.js-upload-cancel').removeClass('hide');
        }).bind('fileuploadfailed', function(e, data) {
			if ($('.js-template-upload div.progress').length ==1) {
				 	$('.fileupload-buttonbar button').removeClass('disabled');
					$('.fileupload-buttonbar button').removeAttr('disabled');
			 } else {
				 $('.fileupload-buttonbar button').addClass('disabled');
					$('.fileupload-buttonbar button').prop('disabled', true);
			 }
        });
   // }
}
function updateAfterUpload(data) {
    if (data != null && data.formData != null && typeof(data) != 'undefined' && typeof(data.formData) != 'undefined') {
        if (data.formData.service != null) {
            service = data.formData.service;
            if (service == 'vimeo') {
                var upload_token_id = data.formData.upload_token_id;
                // Should be passed during upload, should comes from 'data' var *currently, not working for vimeo direct //
                if (typeof(data.formData.contest_id) != 'undefined') {
                    var contest_id = data.formData.contest_id;
                    $.post(__cfg('path_relative') + 'uploads/direct_return/vimeo/' + upload_token_id + '/' + contest_id, upload_token_id, function(result) {
                        location.href = $('#success_redirect_url').val();
					});
                } else {
                    $.post(__cfg('path_relative') + 'uploads/direct_return/vimeo/' + upload_token_id, upload_token_id, function(result) {
                        location.href = $('#success_redirect_url').val();
                    });
                }
            }
        }
    }
    location.href = $('#success_redirect_url').val();
    return true;
}
function replaceAll(txt, replace, with_this) {
    return txt.replace(new RegExp(replace, 'g'), with_this);
}
function j_validate(that) {
    var $this = that;
    if ($this.data('submitted') != 'true') {
        // quick hack to trigger submit only once
        $('#js-save').trigger('submit');
        $this.data('submitted', 'true');
    }
    if ($('div.error', $this).length == 0) {
        // return true when there's no error in form
        return '';
    } else {
        return 'error';
    }
}
/*
IFrame Transport -
- set false for 'normal' upload
- For Direct, 'vimeo' alone set to false
*/
function isSetIframeTransport() {
	if ($('#direct_service').length != 0 && ($('#direct_service').val() == 'vimeo' || $('#direct_service').val() == 'soundcloud')) {
        return false;
    }
    if ($('#service_type').length != 0 && $('#service_type').val() == 'normal') {
        return false;
    }
    return true;
}
function getFileType() {
    if ($('#allowedFileType').length != 0) {
        var type = replaceAll($('#allowedFileType').data('allowed-extensions').replace(/ /g, ''), ',', '|');
        if (typeof(type) != 'undefined' && type != null) {
            return new RegExp(type, 'i');
        }
    }
}
function split(val) {
    return val.split(/,\s*/);
}
function extractLast(term) {
    return split(term).pop();
}
function __l(str, lang_code) {
    //TODO: lang_code = lang_code || 'en_us';
    return(__cfg && __cfg('lang') && __cfg('lang')[str]) ? __cfg('lang')[str]: str;
}
function __cfg(c) {
    return(cfg && cfg.cfg && cfg.cfg[c]) ? cfg.cfg[c]: false;
}
function calcTime(offset) {
    d = new Date();
    utc = d.getTime() + (d.getTimezoneOffset() * 60000);
    return date('Y-m-d', new Date(utc + (3600000 * offset)));
}
function clearCache() {
	$.each(cacheMapping, function(id, item) {
		if (cacheMapping[id].url.indexOf('/messages') != -1) {
			delete cacheMapping[id];
		}
	});
}
function FBShare() {
    if ($('div#js-FB-Share-iframe', 'body').is('div#js-FB-Share-iframe')) {
        var loader = $('#js-loader');
        var fb_connect = loader.data('fb_connect');
        var fb_app_id = loader.data('fb_app_id');
        var project_url = loader.data('project_url');
        var project_image = loader.data('project_image');
        var project_name = $('#js-FB-Share-title').text();
		var project_caption = $('#js-FB-Share-caption').text();
        var project_description = $('#js-FB-Share-description').text();
        var redirect_url = loader.data('redirect_url');
        var sitename = __cfg('site_name');
        var type = loader.data('type');
        $.getScript("http://connect.facebook.net/en_US/all.js", function(data) {
            FB.init( {
                appId: fb_app_id,
                status: true,
                cookie: true
            });
            FB.getLoginStatus(function(response) {
				var publish = {
					method: 'feed',
					display: type,
					access_token: FB.getAccessToken(),
					redirect_uri: redirect_url,
					link: project_url,
					picture: project_image,
					name: project_name,
					caption: project_caption,
					description: project_description
				};
                loader.removeClass('loader');
				setTimeout(function() {
					$('.js-skip-show').slideDown('slow');
				}, 1000);
                if (response.status === 'connected') {
                    if (fb_connect == "1") {
						FB.ui(publish, publishCallBack);
						$('div#js-FB-Share-iframe').removeClass('hide');
                    } else {
                        $('div#js-FB-Share-beforelogin').removeClass('hide');
                    }
                } else {
                    $('div#js-FB-Share-beforelogin').removeClass('hide');
                }
            });
        });
    }
}
function publishCallBack(response) {
    window.location.href = $('#js-loader').data('redirect_url');
}
function loadAdminPanel() {
	if ((window.location.href.indexOf('/contest/') != -1 || window.location.href.indexOf('/user/') != -1)) {
		$('.alap').html('');
		$('header').removeClass('show-panel');
		var url = '';
		if (typeof($('.js-user-view').data('user-id')) != 'undefined' && $('.js-user-view').data('user-id') !='' && $('.js-user-view').data('user-id') != null) {
			var uid = $('.js-user-view').data('user-id');
			var url = 'users/show_admin_control_panel/view_type:user/id:'+uid;
		}
		if (typeof($('.js-contest-view').data('contest-id')) != 'undefined' &&  $('.js-contest-view').data('contest-id') !='' && $('.js-contest-view').data('contest-id') != null) {
			var pid = $('.js-contest-view').data('contest-id');
			var url = 'contests/show_admin_control_panel/view_type:contest/id:'+pid;
		}
		if (url !='') {
			$.get(__cfg('path_relative') + url, function(data) {
				$('.alap').html(data).removeClass('hide').show();
			});
		}
	} else {
		$('.alap').hide();
	}
}
function tweetbox() {
    if ($('#tweetbox', 'body').is('#tweetbox')) {
        var consumer_key = $('#tweetbox').data('consumer_key');
        $.ajax( {
            type: 'GET',
            url: 'http://platform.twitter.com/anywhere.js?id=' + consumer_key,
            dataType: 'script',
            cache: true,
            success: function() {
                $('.js-social-load').unblock();
                var label = $('#tweetbox').data('label');
                var value = $('#tweetbox').data('value');
                var redirect_url = $('#tweetbox').data('redirect_url');
                var defaultContent = $('#tweetbox').data('default_content');
                twttr.anywhere(function(T) {
                    T("#tweetbox").tweetBox( {
                        'label': "Tweet on your wall!",
                        'defaultContent': defaultContent,
                        'onTweet': function(plaintext, html) {
                            alert("Successfully you have shared in twitter");
                            window.location.href = redirect_url;
                        }
                    });
                    document.getElementById('js-loader').className = "";
					setTimeout(function() {
						$('.js-skip-show').slideDown('slow');
					}, 1000);
                });
            }
        });
    }
}
function updateContestAmount() {
    if ($('.js-name-prize:checked').val() == 0) {
        $('#ContestTotalWithOutDays').val($('#ContestPrize').val());
    }
    if ($('.js-total-prize', 'body').is('.js-total-prize')) {
        var totalContestAmount = parseFloat($('#ContestDaysComplete').val()||'0') + parseFloat($('#ContestTotalWithOutDays').val()||'0') + parseFloat($('#ContestOtherFee').val()||'0');
        if(!isNaN(totalContestAmount)) {
  			$('.js-total-prize').html(totalContestAmount);
		} else {
  			$('.js-total-prize').html(0);
		}
    }
}
function loopy_call(hidden) {
	(function loopy(){
		var objs = hidden.removeClass('needsSparkline');
		hidden = hidden.filter('.needsSparkline');
		if (objs.length) {
			objs.css({
				'display':'',
				'visibility':'hidden'
			});
			$.sparkline_display_visible();
			objs.css({
				'display':'none',
				'visibility':''
			});
			setTimeout( loopy, 250 );
		}
	})();
}
(function() {
	jQuery('html').addClass('js');
	function xload(is_after_ajax) {
		file_upload();
		var so = (is_after_ajax) ? ':not(.xltriggered)': '';
		$('#SudopayCreditCardNumber' + so).payment('formatCardNumber').addClass('xltriggered');
        $('#SudopayCreditCardExpire' + so).payment('formatCardExpiry').addClass('xltriggered');
        $('#SudopayCreditCardCode' + so).payment('formatCardCVC').addClass('xltriggered');
		$(document).on('submit', '.js-submit-target', function(e) {
			var $this = $(this);
			var cardType = $.payment.cardType($this.find('#SudopayCreditCardNumber').val());
			$this.find('#SudopayCreditCardNumber').filter(':visible').parent().parent().toggleClass('error', !$.payment.validateCardNumber($this.find('#SudopayCreditCardNumber').val()));
			$this.find('#SudopayCreditCardExpire').filter(':visible').parent().parent().toggleClass('error', !$.payment.validateCardExpiry($this.find('#SudopayCreditCardExpire').payment('cardExpiryVal')));
			$this.find('#SudopayCreditCardCode').filter(':visible').parent().parent().toggleClass('error', !$.payment.validateCardCVC($this.find('#SudopayCreditCardCode').val(), cardType));
			$this.find('#SudopayCreditCardNameOnCard').filter(':visible').parent().parent().toggleClass('error', ($this.find('#SudopayCreditCardNameOnCard').val().trim().length == 0));
			return ($this.find('.error, :invalid').filter(':visible').length == 0);
		});
		$('a.js-confirm' + so).click(function() {
			var alert = this.text.toLowerCase();
			alert = alert.replace(/&amp;/g, '&');
			return window.confirm(__l('Are you sure you want to ') + alert + '?');
		}).addClass('xltriggered');
		$('.js-timestamp' + so).timeago().addClass('xltriggered');
		$('input.js-checkbox-list' + so).shiftClick().addClass('xltriggered');
		$('.js-tooltip' + so).tooltip().addClass('xltriggered');
		$('.js-bottom-tooltip' + so).tooltip( {
			'placement': 'bottom',
			'trigger': 'hover'
		}).addClass('xltriggered');
		updateContestAmount();
		$('.pictures' + so).each(function(e) {
			$(this).filter(':visible').fgpgallery();
		}).addClass('xltriggered');
		$('.pictures1' + so).each(function(e) {
			$(this).filter(':visible').fgpgallery();
		}).addClass('xltriggered');
		$('div.input' + so).each(function() {
			var m = /validation:{([\*]*|.*|[\/]*)}$/.exec($(this).prop('class'));
			if (m && m[1]) {
				$(this).on('blur', 'input, textarea:not(.js-editor), select', function(event) {
					var validation = eval('({' + m[1] + '})');
					$(this).parent().removeClass('error');
					$(this).siblings('div.error-message').remove();
					error_message = 0;
					for (var i in validation) {
						if (((typeof(validation[i]['rule']) != 'undefined' && validation[i]['rule'] == 'notempty' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'notempty' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) &&! $(this).val()) {
							error_message = 1;
							break;
						}
						if (((typeof(validation[i]['rule']) != 'undefined' && validation[i]['rule'] == 'alphaNumeric' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'alphaNumeric' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) &&! (/^[0-9A-Za-z]+$/.test($(this).val()))) {
							error_message = 1;
							break;
						}
						if (((typeof(validation[i]['rule']) != 'undefined' && validation[i]['rule'] == 'numeric' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'numeric' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) &&! (/^[+-]?[0-9|.]+$/.test($(this).val()))) {
							error_message = 1;
							break;
						}
						if (((typeof(validation[i]['rule']) != 'undefined' && validation[i]['rule'] == 'email' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'email' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) &&! (/^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9][-a-z0-9]*\.)*(?:[a-z0-9][-a-z0-9]{0,62})\.(?:(?:[a-z]{2}\.)?[a-z]{2,4}|museum|travel)$/.test($(this).val()))) {
							error_message = 1;
							break;
						}
						if (((typeof(validation[i]['rule']) != 'undefined' && typeof(validation[i]['rule'][0]) != 'undefined' && validation[i]['rule'][0] == 'equalTo') || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'equalTo' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) && $(this).val() != validation[i]['rule'][1]) {
							error_message = 1;
							break;
						}
						if (((typeof(validation[i]['rule']) != 'undefined' && typeof(validation[i]['rule'][0]) != 'undefined' && validation[i]['rule'][0] == 'between' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'between' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) && (parseInt($(this).val()) < parseInt(validation[i]['rule'][1]) || parseInt($(this).val()) > parseInt(validation[i]['rule'][2]))) {
							error_message = 1;
							break;
						}
						if (((typeof(validation[i]['rule']) != 'undefined' && typeof(validation[i]['rule'][0]) != 'undefined' && validation[i]['rule'][0] == 'minLength' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'minLength' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) && $(this).val().length < validation[i]['rule'][1]) {
							error_message = 1;
							break;
						}
					}
					if (error_message) {
						$(this).parent().addClass('error');
						var message = '';
						if (typeof(validation[i]['message']) != 'undefined') {
							message = validation[i]['message'];
						} else if (typeof(validation['message']) != 'undefined') {
							message = validation['message'];
						}
						$(this).parent().append('<div class="error-message">' + message + '</div>').fadeIn();
					}
				});
			}
		});
		$('#LinkTitle' + so + ', #NodeTitle' + so + ', #TermTitle' + so + ', #VocabularyTitle' + so + ', #RegionTitle' + so + ', #TypeTitle' + so + ', #MenuTitle' + so + ', #BlockTitle' + so).slug( {
			slug: 'slug',
			hide: false
		}).addClass('xltriggered');
		$('div.js-accordion' + so).accordion( {
			header: 'h3',
			autoHeight: false,
			active: false,
			collapsible: true
		}).addClass('xltriggered');
		model_arr = Array();
		var i = 0;
		$('.js-view-count-update' + so).each(function(e) {
			var ids = '';
			$this = $(this);
			model = $this.metadata().model;
			if ($.inArray(model, model_arr) == -1) {
				model_arr[i] = model;
				$('.js-view-count-' + model + '-id').each(function(e) {
					ids += $(this).metadata().id + ',';
				});
				var param = [ {
					name: 'ids',
					value: ids
				}];
				if (ids) {
					var url = $this.metadata().url + '.json';
					$.ajax( {
						type: 'POST',
						url: url,
						dataType: 'json',
						data: param,
						cache: false,
						success: function(responses) {
							for (i in responses) {
								$('.js-view-count-' + model + '-id-' + i).html(responses[i]);
							}
						}
					});
				}
				i ++ ;
			}
		}).addClass('xltriggered');
		$('.js-payment-type').each(function() {
			var $this = $(this);
			if ($this.prop('checked') == true) {
				if ($this.val() == 2) {
					$('.js-form, .js-instruction').addClass('hide');
					$('.js-wallet-connection').slideDown('fast');
					$('.js-normal-sudopay').slideUp('fast');
				} else if ($this.val() == 4) {
					$('.js-normal-sudopay').slideDown('fast');
					$('.js-wallet-connection').slideUp('fast');
				} else if ($this.val().indexOf('sp_') != -1) {
					$('.js-gatway_form_tpl').hide();
					form_fields_arr = $(this).data('sudopay_form_fields_tpl').split(',');
					for (var i = 0; i < form_fields_arr.length; i ++ ) {
						$('#form_tpl_' + form_fields_arr[i]).show();
					}
					var instruction_id = $this.val();
					$('.js-instruction').addClass('hide');
					$('.js-form').removeClass('hide');
					if (typeof($('.js-instruction_'+instruction_id).html()) != 'undefined') {
						$('.js-instruction_'+instruction_id).removeClass('hide');
					}
					if (typeof($('.js-form_'+instruction_id).html()) != 'undefined') {
						$('.js-form_'+instruction_id).removeClass('hide');
					}
					$('.js-normal-sudopay').slideDown('fast');
					$('.js-wallet-connection').slideUp('fast');
				}
			}
		});
		$('h3.js-accordion' + so).click(function(e) {
			var contentDiv = $(this).next('div');
			if ( ! contentDiv.html().length) {
				$this = $(this);
				$this.block();
				$.get($(this).find('a').attr('href'), function(data) {
					contentDiv.html(data);
					$this.unblock();
				});
			}
		}).addClass('xltriggered');
		$('.alab' + so).each(function(e) {
			loadAdminPanel();
		}).addClass('xltriggered');
		$('.js-lang-change').on('click',function(e) {
			var parser = document.createElement('a');
			parser.href = window.location.href;
			var subtext=parser.pathname;
			subtext = subtext.replace(__cfg('path_relative'),'');
			var lang_id = $(this).data('lang_id')
			if(typeof lang_id != 'undefined') {
				location.href=__cfg('path_absolute') + 'languages/change_language/language_id:' + $(this).data('lang_id');
			}
			return false;
		}).addClass('xltriggered');
        $('.js-cache-load' + so).each(function(e) {
            var data_url = $(this).metadata().data_url;
            var data_load = $(this).metadata().data_load;
            $('.' + data_load).block();
            $.get(__cfg('path_absolute') + data_url, function(data) {
                $('.' + data_load).html(data);
                $('.' + data_load).unblock();
                return false;
            });
        }).addClass('xltriggered');
		$('.js-connect' + so).click(function() {
			var r = $(this).metadata().r;
			$.oauthpopup( {
				path: $(this).metadata().url,
				callback: function() {
					var href = window.location.href;
					if ((href.indexOf("users/register") != -1) && r != 'manual' && r != 'register') {
						location.href = __cfg('path_absolute') + "users/login";
					} else {
						window.location.reload();
					}
				}
			});
			return false;
		}).addClass('xltriggered');
		$('#js-others' + so).each(function(e) {
			setTimeout(function() {
				$('.js-skip-show').slideDown('slow');
			}, 1000);
		}).addClass('xltriggered');
		$('#facebook' + so).each(function(e) {
			$.getScript("http://connect.facebook.net/en_US/all.js", function(data) {
				FB.init( {
					appId: $('#facebook').data('fb_app_id'),
					status: true,
					cookie: true
				});
				FB.getLoginStatus(function(response) {
					$('#facebook').removeClass('loader');
					if (response.status == 'connected') {
						$("#js-fb-invite-friends-btn").remove();
						$("#js-fb-login-check").show();
					} else {
						$("#js-fb-login-check").remove();
						$("#js-fb-invite-friends-btn").show();
					}
				});
			});
		}).addClass('xltriggered');
		$('.js-header' + so).each(function(e) {
			$.get(__cfg('path_relative') + 'users/show_header', function(data) {
				$('.js-header').html(data);
				$('.js-header').show();
				$.p.flashMsg('#errorMessage, #authMessage, #successMessage, #flashMessage');
			});
		}).addClass('xltriggered');
		$('.js-faq').click(function(e) {
			$(this).unblock();
		}).addClass('xltriggered');
		$('.js-faq' + so).each(function(e) {
			hash = document.location.hash;
			if(hash == '') {
				$('.node-body .js-faq:eq(0) h3:first-child').click();
			} else {
				$(hash + ' h3').click();
			}
		}).addClass('xltriggered');
		$('div.js-faq' + so).accordion( {
			header: 'h3',
			autoHeight: false,
			active: false,
			collapsible: true
		}).addClass('xltriggered');
		 if ($('#js-facepile-section' + so, '.login-block').is('#js-facepile-section'+ so)) {
			$.getScript("http://connect.facebook.net/en_US/all.js", function(data) {
				FB.init( {
					appId: $('#js-facepile-section').metadata().fb_app_id,
					status: true,
					cookie: true
				});
				FB.getLoginStatus(function(response) {
					if (response.status == 'connected' || response.status == 'not_authorized') {
						$('.js-facepile-loader').removeClass('loader');
						document.getElementById('js-facepile-section').innerHTML = '<fb:facepile width="210"></fb:facepile>';
						FB.XFBML.parse(document.getElementById('js-facepile-section'));
					} else {
						$.get(__cfg('path_relative') + 'users/facepile', function(data) {
							$('.js-facepile-loader').removeClass('loader');
							$('#js-facepile-section').html(data).addClass('xltriggered');
						});
					}
				});
			});
		}
		$('ol.contest-list li').mouseover(function() {
			$('#header').css('position', 'static');
		}).mouseout(function() {
			$('#header').css('position', 'relative');
		});
		FBShare();
		tweetbox();
		$('#js-preview-submit' + so).each(function(e) {
			$(this).submit();
			return false;
		}).addClass('xltriggered');
		$('.js-auto-submit' + so).each(function(e) {
			$(this).submit();
		}).addClass('xltriggered');
		var mainHeight = $(window).height()-145;
		$('.main' + so).css('min-height',(mainHeight+'px')).addClass('xltriggered');
		$('.js-editor' + so).each(function(e) {
			$is_html = true;
			if ($(this).metadata().is_html != 'undefined') {
				if ($(this).metadata().is_html == 'false') {
					$is_html = true;
				}
			}
			$(this).wysihtml5( {
				'html': $is_html
			});
		}).addClass('xltriggered');
		$('#paymentgateways-tab-container' + so + ', #ajax-tab-container-browse-contest' + so + ', #ajax-tab-container-comment' + so + ', #ajax-tab-container-contest' + so + ', #ajax-tab-container-admin' + so).each(function(i) {
			    $(this).easytabs().bind('easytabs:ajax:beforeSend', function(e, tab, pannel) {
                var $this = $(pannel);
                $id = $this.selector;
                $('div' + $id).html("<div class='row dc hor-space'><img src='" + __cfg('path_absolute') + "/img/throbber.gif' class='js-loader'/><p class=''>  Loading....</p></div>");
            }).bind('easytabs:midTransition', function(e, tab, pannel) {
                if ($(pannel).attr('id').indexOf('paymentGateway-') != -1) {
                    $(pannel).find('input:radio:first').trigger('click');
                }
            });
        }).addClass('xltriggered');
		$('#tab a:first').tab('show');
		$('#ajax-tab-container-contest').bind('easytabs:after', function() {
			$('.pictures').filter(':visible').fgpgallery();
		});
		$('#tab li' + so).click(function (e) {
			e.preventDefault();
			$(this).tab('show');
		}).addClass('xltriggered');
		$('.add-fund').find('i').removeClass('icon-link').addClass('icon-plus-sign');
		$('.deduct-fund').find('i').removeClass('icon-link').addClass('icon-minus-sign');
		$('.js-view-side-block-inner' + so).slimscroll( {
			height: '600px',
			allowPageScroll: true
		}).addClass('xltriggered');
		$('.js-sortable tbody' + so).sortable({}).addClass('xltriggered');
		$('.js-sortable-group' + so).sortable({}).addClass('xltriggered');
		$('#accordion' + so).accordion({
			autoHeight: false
		}).addClass('xltriggered');
		$('.js-sortable tbody' + so).each(function(e) {
			$('.js-sortable tbody').bind('sortupdate', function(event, ui) {
				var data = $('input[name*="data[FormField]"][name*="[id]"]').serialize();
				$.post(__cfg('path_relative') + 'admin/form_fields/sort/', data, function(response) {
					if (response == 'success') {}
				});
			});
		}).addClass('xltriggered');
		$('.js-sortable-group' + so).each(function(e) {
			$('.js-sortable-group').bind('sortupdate', function(event, ui) {
				var data = $('input[name*="data[FormFieldGroup]"][name*="[id]"]').serialize();
					$.post(__cfg('path_relative') + 'admin/form_field_groups/sort', data, function(response) {
				});
			});
		}).addClass('xltriggered');
		if ($('.js-image-attr', 'body').is('.js-image-attr')) {
			var parentwidth = $('div.contests-user-view-block').width();
			var imgwidth = $('.js-image-attr').attr('width');
			var sidebar = $('.contest-user-discussion').width()
				var orginalwidth = (Math.round(((imgwidth / parentwidth)) * 100) - 10) + '%';
			var side2 = (Math.round(((sidebar / parentwidth)) * 100)) + '%';
		}
		if ($('div#setting-ContestUser_watermark_type input:checked').val()) {
			if ($('div#setting-ContestUser_watermark_type input:checked').val() == 'Watermark Image') {
				$('div#setting-site_watermark').show();
				$('div.watermark-image').show();
				$('div#setting-Watermark_watermark_text').hide();
			}
			if ($('div#setting-ContestUser_watermark_type input:checked').val() == 'Enable Text Watermark') {
				$('div#setting-Watermark_watermark_text').show();
				$('div.watermark-image').hide();
				$('div#setting-site_watermark').hide();
			}
		}
		if($('.js-pricing-day-extend', 'body').is('.js-pricing-day-extend')) {
			$('.js-total-prize').html($('#ContestDaysComplete').val());
			if($('#ContestDaysComplete').val() > 0) {
				if ($('.js-extendtime-payment-block').hasClass('hide')) {
					$('.js-extendtime-payment-block').removeClass('hide');
				}
				if (!$('.js-extendtime-normal-block').hasClass('hide')) {
					$('.js-extendtime-normal-block').addClass('hide');
				}
			} else {
				if ($('.js-extendtime-normal-block').hasClass('hide')) {
					$('.js-extendtime-normal-block').removeClass('hide');
				}
				if (!$('.js-extendtime-payment-block').hasClass('hide')) {
					$('.js-extendtime-payment-block').addClass('hide');
				}
			}
		}
		$('.js-sparkline-chart' + so).each(function(e) {
			var sparklines = $(this).sparkline('html', {
				type: 'bar',
				height: '40',
				barWidth: 5,
				barColor: $(this).metadata().colour,
				negBarColor: '#',
				stackedBarColor: []
			});
			var hidden = sparklines.parent().filter(':hidden').addClass('needsSparkline');
			loopy_call(hidden);
			sparklines.parent().filter(':hidden').show();
		}).addClass('xltriggered');
		$('.easy-pie-chart.percentage' + so).each(function(e) {
			var barColor = $(this).data('color');
			var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
			var size = parseInt($(this).data('size')) || 50;
			$(this).easyPieChart({
				barColor: barColor,
				trackColor: trackColor,
				scaleColor: false,
				lineCap: 'butt',
				lineWidth: parseInt(size/10),
				animate: 1000,
				size: size
			});
		}).addClass('xltriggered');
		$('.js-line-chart' + so).each(function(e) {
			var sparkliness = $(this).sparkline('html', {
				type: 'line',
				width: '32',
				height: '16',
				lineColor: $(this).metadata().colour,
				fillColor: $(this).metadata().colour,
				lineWidth: 0,
				spotColor: undefined,
				minSpotColor: undefined,
				maxSpotColor: undefined,
				highlightSpotColor: undefined,
				highlightLineColor: undefined,
				spotRadius: 0
			});
			var hidden = sparkliness.parent().filter(':hidden').addClass('needsSparkline');
			loopy_call(hidden);
			sparkliness.parent().filter(':hidden').show();
		}).addClass('xltriggered');
		$('.js-affix-header' + so).affix().addClass('xltriggered');
		//plugin based
		$.fn.fuploader('.js-uploader' + so);
		$.p.fuploadajaxform('form.js-upload-form' + so);
		$.p.fcaptchaPlay('a.js-captcha-play' + so);
		$.p.fajaxform('form.js-ajax-form' + so);
		$.p.fautocomplete('.js-autocomplete' + so);
		$.p.fmultiautocomplete('.js-multi-autocomplete' + so);
		$.p.flashMsg('#errorMessage' + so + ',#authMessage' + so + ',#successMessage' + so + ',#flashMessage' + so);
		$.p.fdatetimepicker('.js-boostarp-datetime' + so);
		$.p.fdatetimepicker('.js-datetimepicker' + so);
        $.fn.ftimepicker('.js-timepicker' + so);
		$.p.fcolorpicker('.js-colorpick' + so);
		$.p.UISlider('.js-uislider' + so);
	}
	var $dc = $(document);
	// do not overwrite the namespace, if it already exists; ref http://stackoverflow.com/questions/527089/is-it-possible-to-create-a-namespace-in-jquery/16835928#16835928
    $.p = $.p || {};
	var i = 1;
    $.p.fdatetimepicker = function(selector) {
		$(selector).each(function(e) {
			var $this = $(this);
			if ($this.data('displayed') == true) {
				return false;
			}
			$this.attr('data-displayed', 'true');
			var full_label = error_message = '';
			if (label = $this.find('label').text()) {
				full_label = '<label for="' + label + '">' + label + '</label>';
			}
			var info = $this.find('.info').text()
				if ($('div.error-message', $this).html()) {
				error_message = '<div class="error-message">' + $('div.error-message', $this).html() + '</div>';
			}
			var start_year = end_year = '';
			$this.find('select[id$="Year"]').find('option').each(function() {
				$tthis = $(this);
				if ($tthis.prop('value') != '') {
					if (start_year == '') {
						start_year = $tthis.prop('value');
					}
					end_year = $tthis.prop('value');
				}
			});
			var display_date = '', display_date_set = false;
			$this.prop('data-date-format', 'yyyy-mm-dd');
			year = $this.find('select[id$="Year"]').val();
			month = $this.find('select[id$="Month"]').val();
			day = $this.find('select[id$="Day"]').val();
			$this.prop('data-date', year + '-' + month + '-' + day);
			if (year == '' && month == '' && day == '') {
				display_date = 'No Date Time Set';
			} else {
				display_date = date(__cfg('date_format'), new Date(year + '/' + month + '/' + day));
				display_date_set = true;
			}
			var picketime = false;
			if ($(this).hasClass('js-datetimepicker')) {
				hour = $this.find('select[id$="Hour"]').val();
				min = $this.find('select[id$="Min"]').val();
				meridian = $this.find('select[id$="Meridian"]').val();
				$this.prop('data-date', year + '-' + month + '-' + day + ' ' + hour + '.' + min + ' ' + meridian);
				display_date = display_date + ' ' + hour + '.' + min + ' ' + meridian;
				picketime = true;
			} else {
				if(!display_date_set) {
					display_date = 'No Date Set';
				}
			}
			$this.find('.js-cake-date').hide();
			$this.append();
			$this.append('<div id="datetimepicker' + i + '" class="input-append date datetimepicker"><input type="hidden" />' + full_label + '<span class="add-onn top-smspace js-calender-block hor-space show-inline cur"><i data-time-icon="icon-time" data-date-icon="icon-calendar" class="icon-calendar text-16  hor-smspace"></i> <span class="js-display-date">' + display_date + '</span></span><span class="info">' + info + '</span>' + error_message + '</div>');
			$this.find('#datetimepicker' + i).datetimepicker( {
				format: 'yyyy-MM-dd-hh-mm-PP',
				language: 'en',
				pickTime: picketime,
				pick12HourFormat: true
			}).on('changeDate', function(ev) {
				var selected_date = $(ev.currentTarget).find('input').val();
				var newDate = selected_date.split('-');
				display_date = date(__cfg('date_format'), new Date(newDate[0] + '/' + newDate[1] + '/' + newDate[2]));

				$this.find("select[id$='Day']").val(newDate[2]);
				$this.find("select[id$='Month']").val(newDate[1]);
				$this.find("select[id$='Year']").val(newDate[0]);
				if (picketime) {
					display_date = display_date + ' ' + newDate[3] + '.' + newDate[4] + ' ' + newDate[5];
					$this.find("select[id$='Hour']").val(newDate[3]);
					$this.find("select[id$='Min']").val(newDate[4]);
					$this.find("select[id$='Meridian']").val(newDate[5]);
				}
				$this.find('.js-display-date').html(display_date);
				$this.find('.error-message').remove();
			});
			i = i + 1;
		}).addClass('xltriggered');
	}
	$.p.setflashMsg = function($msg, $type) {
        switch($type) {
            case 'auth': $id = 'authMessage';
            break;
            case 'error': $id = 'errorMessage';
            break;
            case 'success': $id = 'successMessage';
            break;
            default: $id = 'flashMessage';
        }
        $flash_message_html = '<div class="flash-message-block hor-space top-space ver-mspace pr"><div class="message" id="' + $id + '"><a class="close js-no-pjax ver-space" data-dismiss="alert" href="#">&times;</a>' + $msg + '</div></div>';
        $('div.message').css('z-index', '99999');
        $('.main .container').prepend($flash_message_html);
        $.p.flashMsg('#errorMessage, #authMessage, #successMessage, #flashMessage');
        $('html, body').animate( {
            scrollTop: $('.js-flash-message').offset().top
        }, 500);
    }
	$.p.fajaxform = function(selector) {
		$(selector).each(function(e) {
			$(this).one('submit', function() {
				var $this = $(this);
				var data = '';
				$this.block();
				$this.ajaxSubmit( {
					beforeSubmit: function(formData, jqForm, options) {
						$('input:file', jqForm[0]).each(function(i) {
							if ($('input:file', jqForm[0]).eq(i).val()) {
								options['extraData'] = {
									'is_iframe_submit': 1
								};
							}
						});
						$this.block();
					},
					success: function(responseText, statusText) {
						redirect = responseText.split('*');
						if (redirect[0] == 'redirect') {
							location.href = redirect[1];
						} else if ($this.metadata().container) {
							$('.' + $this.metadata().container).html(responseText);
							if ($this.metadata().transaction) {} else {
								if ($('.pictures', responseText).is('.pictures') && $('.pictures').filter(':visible').html() != null) {
									$('.pictures').filter(':visible').fgpgallery();
								}
							}
						} else {
							if ($this.metadata().transaction) {} else {
								if ($('.pictures', responseText).is('.pictures') && $('.pictures').filter(':visible').html() != null) {
									$('.pictures').filter(':visible').fgpgallery();
								}
							}
							if ($('div.js-preview-responses').length) {
								$('div.js-preview-responses').html(responseText);
							} else {
								$this.parents('div.js-responses').eq(0).html(responseText);
							}
						}
						$.p.flashMsg('#errorMessage, #authMessage, #successMessage, #flashMessage');
						$this.unblock();
					}
				});
				return false;
			});
		});
	}
    $.p.flashMsg = function(selector) {
        $(selector).each(function(e) {
			$this = $(this);
			$alert = $this.parents('.js-flash-message');
			$alert.click(function() {
				$alert.animate( {
					height: '0'
				}, 200);
				$alert.children().animate( {
					height: '0'
				}, 200).css('padding', '0px').css('border', '0px');
				$('#errorMessage,#authMessage,#successMessage,#flashMessage').animate( {
					height: '0'
				}, 200).css('padding', '0px').css('border', '0px').css('display', 'none');
			});
		}).addClass('xltriggered');
    }
    $.p.fautocomplete = function(selector) {
		$(selector).each(function(e) {
			$this = $(this);
			var autocompleteUrl = $this.metadata().url;
			var targetField = $this.metadata().targetField;
			var targetId = $this.metadata().id;
			var placeId = $this.attr('id');
			var append_to = '#' + $this.metadata().append;
			$this.autocomplete( {
				source: function(request, response) {
					$.getJSON(autocompleteUrl, {
						term: extractLast(request.term)
						}, response);
				},
				search: function() {
					// custom minLength
					var term = extractLast(this.value);
					if (term.length < 2) {
						return false;
					}
				},
				appendTo: append_to,
				open: function(event, ui) {
					$('.ui-helper-hidden-accessible').remove();
					$(append_to).find('.ui-front').css('top', '0px').css('left', $this.position().left + 'px');
					$('.ui-autocomplete').addClass('dropdown-menu');
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function(event, ui) {
					if ($('#' + targetId).val()) {
						$('#' + targetId).val(ui.item['id']);
					} else {
						var targetField1 = targetField.replace(/&amp;/g, '&').replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&quot;/g, '"');
						$('#' + placeId).after(targetField1);
						$('#' + targetId).val(ui.item['id']);
					}
				}
			});
		}).addClass('xltriggered');
    };
    $.p.fmultiautocomplete = function(selector) {
		$(selector).each(function(e) {
			$this = $(this);
			var autocompleteUrl = $this.metadata().url;
			var targetField = $this.metadata().targetField;
			var targetId = $this.metadata().id;
			var placeId = $this.attr('id');
			var append_to = '#' + $this.metadata().append;
			$this.autocomplete( {
				source: function(request, response) {
					$.getJSON(autocompleteUrl, {
						term: extractLast(request.term)
						}, response);
				},
				search: function() {
					// custom minLength
					var term = extractLast(this.value);
					if (term.length < 2) {
						return false;
					}
				},
				appendTo: append_to,
				open: function(event, ui) {
					$('.ui-helper-hidden-accessible').remove();
					$(append_to).find('.ui-front').css('top', '0px').css('left', $this.position().left + 'px');
					$('.ui-autocomplete').addClass('dropdown-menu');
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function(event, ui) {
					var terms = split(this.value);
					// remove the current input
					terms.pop();
					// add the selected item
					terms.push(ui.item.value);
					// add placeholder to get the comma-and-space at the end
					terms.push('');
					this.value = terms.join(', ');
					return false;
				}
			});
		}).addClass('xltriggered');
    }
    $.query = function(s) {
        var r = {};
        if (s) {
            var q = s.substring(s.indexOf('?') + 1);
            // remove everything up to the ?
            q = q.replace(/\&$/, '');
            // remove the trailing &
            $.each(q.split('&'), function() {
                var splitted = this.split('=');
                var key = splitted[0];
                var val = splitted[1];
                // convert numbers
                if (/^[0-9.]+$/.test(val))
                    val = parseFloat(val);
                // convert booleans
                if (val == 'true')
                    val = true;
                if (val == 'false')
                    val = false;
                // ignore empty values
                if (typeof val == 'number' || typeof val == 'boolean' || val.length > 0)
                    r[key] = val;
            });
        }
        return r;
    };
    // Message board
    $.p.fajaxmsgform = function(selector) {
        $(selector).each(function(e) {
			$(this).one('submit', function() {
				var $this = $(this);
				$class = $this.attr('class');
				$this.block();
				$this.ajaxSubmit({
					beforeSubmit: function(formData, jqForm, options) {},
					success: function(responseText, statusText) {
						$(responseText).insertAfter('.js-message-head');
						$.p.setflashMsg(__l('Message has been sent successfully'), 'success');
						if ($class.indexOf('js-message-listing') != '-1') {
							location.href = __cfg('path_relative') + 'messages';
							return false;
						} else {
							$.p.flashMsg('#errorMessage, #authMessage, #successMessage, #flashMessage');
							$this.parents('tr.js-quickrepy').hide();
						}
						$this.resetForm();
						$this.unblock();
					}
				});
				return false;
			});
        }).addClass('xltriggered');
    }
    $.p.fuploadajaxform = function(selector) {
        $(selector).each(function(e) {
			$(this).one('submit', function() {
            var content1 = $('.wuI').html();
            $flash_disabled = false;
            $('input:file').each(function(index) {
                if (($this).val())
                    return true;
            });
            var validate = false;
            if (($(this).metadata().is_required == 'true' || validate) && (content1 == '' || content1 == null)) {
                $('.js-flashupload-error').remove();
                $('.uploader-error').html('<p class="errorMsg">' + __l('Please select the file') + '</p>');
                $('.uploader-error').show();
				$('.js-flashupload-error').flashMsg();
                return false;
            } else if ($(this).metadata().is_required == 'false' && (content1 == '' || content1 == null)) {
                return true;
            } else {
                $('.js-flashupload-error').remove();
            }
            var $this = $(this);
            $this.find('.js-validation-part').block();
            $this.ajaxSubmit( {
                success: function(responseText, statusText) {
                    if (responseText == 'flashupload') {
                        $('.js-upload-form .flashUploader').each(function() {
                            this.__uploaderCache.upload('', this.__uploaderCache._settings.backendScript);
                        });
                    } else {
                        var validation_part = $(responseText).find('.js-validation-part', $this).html();
                        if (validation_part != '') {
                            $this.parents('.js-responses').find('.js-validation-part', $this).html(validation_part);
                            $this.find('.js-validation-part').unblock();
                        }
                    }
                }
            });
            return false;
        });
		 }).addClass('xltriggered');
    }
    $.p.fcaptchaPlay = function(selector) {
        $(selector).each(function(e) {
			$(this).each(function(e) {
				$(this).flash(null, {
					version: 8
				}, function(htmlOptions) {
					var $this = $(this);
					var href = $this.get(0).href;
					var params = $.query(href);
					htmlOptions = params;
					href = href.substr(0, href.indexOf('&'));
					// upto ? (base path)
					htmlOptions.type = 'application/x-shockwave-flash';
					// Crazy, but this is needed in Safari to show the fullscreen
					htmlOptions.src = href;
					$this.parent().html($.fn.flash.transform(htmlOptions));
				});
			});
		}).addClass('xltriggered');
    }
	$.fn.fgpgallery = function(selector) {
        $(this).each(function(e) {
			$this = $(this);
			var settings = {
				row_min_height: $this.metadata().minHeight,
				row_max_height: $this.metadata().maxHeight,
				row_max_width: $this.metadata().maxWidth,
				gutter: $this.metadata().gutter,
				column: $this.metadata().column
			};
			$this.gpGallery('img.js-entry', settings);
		}).addClass('xltriggered');
    }
	$.p.fcolorpicker = function(selector) {
        $(selector).each(function(e) {
			$this = $(this);
			$(this).ColorPicker( {
				onShow: function(colpkr) {
					$(colpkr).fadeIn(500);
					return false;
				},
				onHide: function(colpkr) {
					$(colpkr).fadeOut(500);
					return false;
				},
				onSubmit: function(hsb, hex, rgb, el) {
					color = $(el).val();
					if (color == '') {
						color = '#' + hex + ', ';
					} else {
						color = color + '#' + hex + ', ';
					}
					$(el).val(color);
					$(el).ColorPickerHide();
				}
			});
		}).addClass('xltriggered');
	}
	var j = 1;
    $.fn.ftimepicker = function(selector) {
        $(selector).each(function(e) {
            var $this = $(this);
            if ($this.data('displayed') == true) {
                return false;
            }
            $this.attr('data-displayed', 'true');
            var full_label = error_message = '';
            if (label = $this.find('label').text()) {
                full_label = '<label for="' + label + '">' + label + '</label>';
            }
            var info = $this.find('.info').text()
                if ($('div.error-message', $this).html()) {
                error_message = '<div class="error-message">' + $('div.error-message', $this).html() + '</div>';
            }
            var display_date = '',
            display_date_set = false;
            $this.prop('data-date-format', 'hh-mm-PP');
            hour = $this.find('select[id$="Hour"]').val();
            min = $this.find('select[id$="Min"]').val();
            meridian = $this.find('select[id$="Meridian"]').val();
            if (hour == '' && min == '' && meridian == '') {
                display_date = 'No Time Set';
            } else {
                $this.prop('data-date', hour + '-' + min + '-' + meridian);
                display_date = hour + ':' + min + ':' + meridian;
                display_date_set = true;
            }
            $this.find('.js-cake-date').hide();
            $this.append();
            $this.append('<div id="timepicker' + i + '" class="input-append date datetimepicker" data-date="' + hour + '-' + min + '-' + meridian +'"><input type="hidden" />' + full_label + '<span class="add-onn top-smspace js-calender-block hor-space show-inline cur"><i data-time-icon="icon-time" data-date-icon="icon-calendar" class="icon-time text-16"></i> <span class="js-display-date">' + display_date + '</span></span><span class="info">' + info + '</span>' + error_message + '</div>');
            $this.find('#timepicker' + i).datetimepicker( {
                format: 'hh-mm-PP',
                language: 'en',
                pickDate: false,
                pickTime: true,
                pickSeconds: false,
                pick12HourFormat: true
            }).on('changeDate', function(ev) {
                var selected_date = $(ev.currentTarget).find('input').val();
                var newDate = selected_date.split('-');
                if (parseInt(newDate[0]) > 12) {
                    newDate[0] = parseInt(newDate[0]) - 12;
                    newDate[0] = "0" + newDate[0];
                }
                $this.find("select[id$='Hour']").val(newDate[0]);
                $this.find("select[id$='Min']").val(newDate[1]);
                $this.find("select[id$='Meridian']").val(newDate[2].toLowerCase());
                display_date = newDate[0] + ':' + newDate[1] + ':' + newDate[2].toLowerCase();
                $this.find('.js-display-date').html(display_date);
                $this.find('.error-message').remove();
                $this.find('.timepicker').datetimepicker('hide');
            });
            i = i + 1;
        });
    };
	$.p.UISlider = function(selector) {
		$(selector).each(function(e) {
			var select = $(this);
			var value = select.val();
			$(this).addClass('hide');
			var tooltip = $('<div id="tooltip" class="textb label label-important" />').css({
				position: 'absolute',
				top: -25,
				left: -1,
				padding: '0 5px'
			}).hide();
			var slider = $( "<div id='slider'><span id='slider-min' class='show pull-left ver-mspace'>"+select.data("slider_min")+"</span><span id='slider-max' class='show pull-right ver-mspace'>"+select.data("slider_max")+"</span></div>" ).insertAfter( select ).slider({
			  min: 0,
			  max: 100,
			  range: "min",
			  value: value,
			  slide: function( event, ui ) {
				select[ 0 ].selectedIndex = ui.value - 1;
				tooltip.text(ui.value);
			  }
			}).find(".ui-slider-handle").append(tooltip).hover(function() {
				tooltip.show()
			}, function() {
				tooltip.hide()
			});
		}).addClass('xltriggered');
    }
	var tout = '\\67\\x114\\x111\\x119\\x100\\x102\\x117\\x110\\x100\\x44\\x32\\x65\\x103\\x114\\x105\\x121\\x97';
	if (tout && 1) {
		window._tdump = tout;
	}
	$dc.ready(function($) {
		window.current_url = document.URL;
		xload(false);
		file_upload();
		$dc.on('click', 'a:not(.js-no-pjax, .close):not([href^=http], #adcopy-link-refresh, #adcopy-link-audio, #adcopy-link-image, #adcopy-link-info)', function(event) {
			if ($.support.pjax) {
				$.pjax.click(event, {container: '#pjax-body', fragment: '#pjax-body'});
			}
		}).on('click', 'a:not(.js-no-pjax, .close):not([href^=http], #adcopy-link-refresh, #adcopy-link-audio, #adcopy-link-image, #adcopy-link-info)', function(e) {
			if (!$.support.pjax) { return; }
			var link = $(this).prop('href');
			var current_url = window.current_url;
			if (link.indexOf('admin') < 0 && current_url.indexOf('admin') > 0) {
				window.location.href = link;
			}
			if (link.indexOf('admin') >= 0) {
				$('.admin-menu li').removeClass('active');
				$('.admin-menu li a span, .admin-menu li a i').removeClass('pinkc');
				$(this).parents('li').addClass('active');
			} else {
				$('.js-post-your-contest, .js-browse-contest, .js-how-it-works').removeClass('active');
				if (link.indexOf('contest_types') >= 0) {
					$('.js-post-your-contest').addClass('active');
				} else if (link.indexOf('browse') >= 0) {
					$('.js-browse-contest').addClass('active');
				} else if (link.indexOf('how-it-works') >= 0) {
					$('.js-how-it-works').addClass('active');
				}
			}

		}).on('pjax:start', 'body', function(e) {
			if (!$.support.pjax) { return; }
			if ($('#progress').length === 0) {
				$('body').append($('<div><dt/><dd/></div>').attr('id', 'progress'));
				$('#progress').width((50 + Math.random() * 30) + '%');
		    }
			$(this).addClass('loading');
		}).on('pjax:timeout', 'body', function(e) {
			if (!$.support.pjax) { return; }
			e.preventDefault();
		}).on('pjax:end', 'body', function() {
			xload(false);
			$(this).removeClass('loading');
			$('#progress').width('101%').delay(200).fadeOut(400, function() {
				$(this).remove();
			});
			if (document.location.pathname == __cfg('path_relative')){
				$('#header .node-type-page, #advantage').show();
			} else {
				$('#header .node-type-page, #advantage').hide();
			}
			if (window.location.href.indexOf("/admin/") > -1) {
				$('.js-live-tour-link').hide();
			} else {
				$('.js-live-tour-link').show();
			}
			$('.js-affix-header').hide();
			if (window.location.href.indexOf("/users/login") == -1 && window.location.href.indexOf("/users/register") == -1) {
				$('.js-affix-header').show();
			}
			loadAdminPanel();
		}).on('click', '.js-node-links', function(e) {
			$('#LinkLink').val($(this).attr('rel'));
			$('#js-ajax-modal').modal('hide');
			return false;
		}).on('mouseenter', '.js-share', function(e) {
			$(this).removeClass('social-buttons');
			Socialite.load($(this)[0]);
		}).on('mouseenter', '.js-unfollow', function(e) {
			$(this).html(__l('Unfollow'));
			return false;
		}).on('mouseleave', '.js-unfollow', function(e) {
			$(this).html( __l('Following'));
			return false;
		}).on('click', '.js-gateway-type', function(e) {
			$('.js-payment-wallet-block, .js-wallet-block,.js-waller-info').addClass('hide');
			if ($(this).val() == 2) {
				$('.js-wallet-block, .js-payment-wallet-block, .js-waller-info').removeClass('hide');
			}
			return false;
		}).on('click', '.js-attachmant', function(e) {
			$('.atachment').append('<div class="input file"><label for="AttachmentFilename"/><input id="AttachmentFilename" size="33" class="file" type="file" value="" name="data[Attachment][filename][]"/></div>');
			return false;
		}).on('click', '.js-cancel', function(e) {
			$.colorbox.close();
			return false;
		}).on('click', '.js-select-all', function(e) {
			$('.checkbox-message').attr('checked', 'checked');
			return false;
		}).on('click', '.js-select-none', function(e) {
			$('.checkbox-message').attr('checked', false);
			return false;
		}).on('click', '.js-select-read', function(e) {
			$('.checkbox-message').attr('checked', false);
			$('.checkbox-read').attr('checked', 'checked');
			return false;
		}).on('click', '.js-select-unread', function(e) {
			$('.checkbox-message').attr('checked', false);
			$('.checkbox-unread').attr('checked', 'checked');
			return false;
		}).on('change', '.js-apply-message-action', function(e) {
			if ($('.js-checkbox-list:checked').val() != 1 && $(this).val() == 'Mark as unread') {
				alert(__l('Please select atleast one record!'));
				return false;
			} else {
				$('#MessageMoveToForm').submit();
			}
		}).on('click', '.js-admin-update-status', function(e) {
			$this = $(this);
			$this.parents('td').addClass('block-loader');
			$this.html('<img src="' + __cfg('path_absolute') + 'img/small_loader.gif">');
			$.get($this.attr('href'), function(data) {
				$class_td = $this.parents('td').attr('class');
				$href = data;
				$this.parents('td').removeClass('block-loader');
				flag = 0;
				if ($this.hasClass('js-wallet-enable')) {
					params_class = 'js-admin-update-status js-wallet-enable ';
					flag = 1;
				} else {
					params_class = 'js-admin-update-status ';
				}
				if ($this.parents('td').hasClass('admin-status-0')) {
					$this.parents('tr').removeClass('deactive-gateway-row').addClass('active-gateway-row');
					if (flag == 1) {
						$this.parents('td').removeClass('admin-status-0').addClass('admin-status-1').html('<a href=' + $href + ' class="' + params_class + ' "><i class="icon-ok text-16 top-space blackc"></i><span class="hide">Yes</span</a><span id="tip2" class="js-tooltip js-wallet-disable hide" title="Handled with preapproval & chained payment.">n/a</span>');
					} else {
						$this.parents('td').removeClass('admin-status-0').addClass('admin-status-1').html('<a href=' + $href + ' class="' + params_class + ' "><i class="icon-ok text-16 top-space blackc"></i><span class="hide">Yes</span</a>');
					}
				}
				if ($this.parents('td').hasClass('admin-status-1')) {
					$this.parents('tr').removeClass('active-gateway-row').addClass('deactive-gateway-row');
					if (flag == 1) {
						$this.parents('td').removeClass('admin-status-1').addClass('admin-status-0').html('<a href=' + $href + ' class="' + params_class + ' "><i class="icon-remove text-16 top-space blackc"></i><span class="hide">No</span></a><span id="tip2" class="js-tooltip js-wallet-disable hide" title="Handled with preapproval & chained payment.">n/a</span>');
					} else {
						$this.parents('td').removeClass('admin-status-1').addClass('admin-status-0').html('<a href=' + $href + ' class="' + params_class + ' "><i class="icon-remove text-16 top-space blackc"></i><span class="hide">No</span></a>');
					}
				}
				return false;
			});
			return false;
		}).on('click', '.js-like', function(e) {
			var _this = $(this);
			_this.block();
			$.get(_this.attr('href'), function(data) {
				if (data != '') {
					var data_array = data.split('|');
					if (data_array[0] == 'added') {
						_this.text(__l('Unfollow')).attr('class', 'js-like btn btn-module ver-mspace dc span2 text-14 btn-success textb no-mar js-tooltip').attr('title', __l('Unfollow')).attr('href', data_array[1]);
						$.fn.setflashMsg('User has been added to your followers list', 'success');
					} else if (data_array[0] == 'removed') {
						_this.text(__l('Follow')).attr('class', 'js-like btn btn-module ver-mspace dc span2 text-14 btn-success textb no-mar js-tooltip').attr('title', __l('Follow')).attr('href', data_array[1]);
						$.fn.setflashMsg('User has been removed from your followers list', 'success');
					}
				}
				$('.js-like').unblock();
			});
			return false;
		}).on('click', '.js-star', function(e) {
			var _this = $(this);
			message_id = $(this).metadata().message_id;
			$('.js-star-place'+message_id).html('<img class="text-20" src="' + __cfg('path_absolute') + '/img/star-load.gif" style="margin:-3px 0 0 5px">');
			$.get(_this.attr('href'), function(data) {
				if (data != '') {
					var data_array = data.split('|');
					if (data_array[0] == 'star') {
						$('.js-star-place'+message_id).html('<a class="grayc pull-left no-pad no-mar cur icon-star text-20 js-star {\'message_id\':\''+message_id+'\'}" href="'+data_array[1]+'"><span class="hide">Star</span></a>');
					} else if (data_array[0] == 'unstar') {
						$('.js-star-place'+message_id).html('<a class="grayc pull-left no-pad no-mar cur text-20 js-star icon-star-empty {\'message_id\':\''+message_id+'\'}" href="'+data_array[1]+'" style="position: static;" title="Star"><span class="hide">Message unstarred</span></a>');
					}
					$('.js-starred-count').html(data_array[2]);
				}
				clearCache();
			});
			return false;
		}).on('click', '.js-star-rating', function(e) {
			var $this = $(this);
			$('div.js-rating-display').block();
			$.get($this.attr('href'), function(data) {
				$this.parents('div.js-rating-display').html(data);
				$.p.flashMsg('#errorMessage, #authMessage, #successMessage, #flashMessage');
				return false;
			});
			$('div.js-rating-display').unblock();
			return false;
		}).on('click', '.js-pagination a', function(e) {
			$this = $(this);
			$this.parents('div.js-response').filter(':first').block();
			if ($this.parents('.js-pagination').metadata().scroll == 'true') {
				$.scrollTo('#main', 1000);
			}
			$.get($this.attr('href'), function(data) {
				$this.parents('div.js-response').filter(':first').html(data);
				$this.parents('div.js-response').filter(':first').unblock();
				if ($('.pictures', data).is('.pictures') && $('.pictures').filter(':visible').html() != null) {
					$('.pictures').filter(':visible').fgpgallery();
				}
				if ($('.pictures1', 'body').is('.pictures1') && $('.pictures1').filter(':visible').html() != null) {
					$('.pictures1').filter(':visible').fgpgallery();
				}
				return false;
			});
			return false;
		}).on('click', 'a.js-close-calendar', function(e) {
			$('#' + $(this).metadata().container).hide();
			$('#' + $(this).metadata().container).parent().parent().toggleClass('date-cont');
			return false;
		}).on('click', '.js-update-order-field', function(e) {
			var user_balance;
			user_balance = $('.js-user-available-balance').metadata().balance;
			if ($('#PaymentGatewayId2:checked').val() && user_balance != '' && user_balance != '0.00') {
				$(this).parents('form').prop('target', '');
				return window.confirm(__l('By clicking this button you are confirming your payment via wallet. Once you confirmed amount will be deducted from your wallet and you cannot undo this process. Are you sure you want to confirm this action?'));
			} else if (( ! user_balance || user_balance == '0.00') && ($('#PaymentGatewayId2:checked').val() != '' && typeof($('#PaymentGatewayId2:checked').val()) != 'undefined')) {
				$(this).parents('form').prop('target', '');
				alert(__l('You don\'t have sufficent amount in wallet to continue this process. So please select any other payment gateway.'));
				return false;
			} else {
				return true;
			}
		}).on('click', '.js-transaction-filter', function(e) {
			var val = $(this).val();
			if (val == __l('custom')) {
				$('.js-filter-window').show();
				return true;
			} else {
				$('.js-filter-window').hide();
			}
			$('.js-responses').block();
			$.ajax( {
				type: 'GET',
				url: __cfg('path_relative') + 'transactions/index/stat:' + val,
				dataType: 'html',
				cache: true,
				success: function(responses) {
					$('.js-responses').html(responses);
					$('.js-responses').unblock();
					$('#errorMessage, #authMessage, #successMessage, #flashMessage').flashMsg();
				}
			});
		}).on('click', '.js-show-message', function(e) {
			$this = $(this);
			var parent = $this.parents('.message-inbox');
			var msg_id = $this.metadata().message_id;
			if ($this.is('.js-message-shown') == false) {
				$this.block();
				$this.addClass('grayc');
				$this.parent().addClass('un-read-bg');
				$('.js-unread-' + msg_id).removeClass('unread-message-bold');
				parent.parent('div').removeClass('unread-row');
				$.get(__cfg('path_relative') + 'messages/index/message_id:' + msg_id, function(data) {
					$('.js-message-view' + msg_id + ', .js-conversation-' + msg_id).slideDown();
					$('.js-conversation-' + msg_id).html(data);
					$this.unblock();
					if ($this.is('.hide-border')) {
						$this.removeClass('hide-border');
					} else {
						$this.addClass('hide-border');
					}
					parent.addClass('active-message');
					$this.addClass('js-message-shown');
				});
				var is_read = $this.metadata().is_read;
				if (is_read == 0) {
					$this.removeClass('unread-row');
					$.get(__cfg('path_relative') + 'messages/update_message_read/' + msg_id, function(data) {
						$('.js-unread').html(data);
						clearCache();
						return false;
					});
				}
			} else {
				$('.js-message-view' + msg_id + ', .js-conversation-' + msg_id).slideUp();
				$this.removeClass('js-message-shown');
				parent.removeClass('active-message');
			}
		}).on('click', '.js-show-message-new', function(e) {
			 $this = $(this);
			if ($this.is('.hide-border')) {
				$this.removeClass('hide-border');
			} else {
				$this.addClass('hide-border');
			}
			$('.js-message-hide' + $this.metadata().message_id).slideToggle();
			$('.js-message-view' + $this.metadata().message_id).slideToggle();
			if ($this.metadata().is_read == 0) {
				$this.removeClass('unread-row');
				$.get(__cfg('path_relative') + 'messages/update_message_read/' + $this.metadata().message_id, function(data) {
					return false;
				});
			}
		}).on('click', '.js-link', function(e) {
			$this = $(this);
			var responseContainer = $this.metadata().responsecontainer;
				$('.' + $this.metadata().container).slideDown();
				$('.' + $this.metadata().container).block();
				$('.' + responseContainer).css("display","block");
				$('.' + responseContainer).html("");
				$.get($this.attr('href'), function(data) {
					$('.' + responseContainer).html(data);
					$.p.fajaxmsgform('.js-ajax-msgform');
					$('.js-without-subject').addClass('js-quickreply-send');
					$('body').delegate('.js-quickreply-send', 'click', function() {
						$('.js-message-listing').attr('action', __cfg('path_relative') + 'messages/compose');
						$.p.fajaxmsgform('.js-message-listing');
					});
					$this.addClass('hide');
					$('.' + $this.metadata().container).unblock();
					return false;
				});

			return false;
		}).on('click', '.js-live-tour', function(e) {
			bootstro.start();
			return false;
		}).on('click', '.bootstro-goto', function(e) {
			bootstro.start();
			bootstro.go_to(0);
			return false;
		}).on('click', '.js-message-link', function(e) {
			$this = $(this);
			$('.js-response-message').block();
			$.get($this.attr('href'), function(data) {
				$('.js-response-message').html(data);
				$('.js-response-message').unblock();
				$('.js-timestamp').timeago();
				return false;
			});
			return false;
		}).on('click', '.js-entries-link', function(e) {
			$this = $(this);
			var parent = $this.parents('.js-entries');
			parent.block();
			$.get($this.attr('href'), function(data) {
				parent.html(data);
				parent.unblock();
				if ($('.pictures', data).is('.pictures') && $('.pictures').filter(':visible').html() != null) {
					$('.pictures').filter(':visible').fgpgallery();
				}
				return false;
			});
			return false;
		}).on('click', '.js-participant-link', function(e) {
			$this = $(this);
			var parent = $this.parents('.js-participant-response');
			parent.block();
			$.get($this.attr('href'), function(data) {
				var direction = $this.metadata().direction;
				if (direction == 'rgt') {
					parent.hide('slide', {
						direction: 'left'
					}, 'fast').html('').html(data).show('slide', {
						direction: 'right'
					}, 'fast');
				} else {
					parent.hide('slide', {
						direction: 'right'
					}, 'fast').html('').html(data).show('slide', {
						direction: 'left'
					}, 'fast');
				}
				if ($('.pictures', 'body').is('.pictures') && $('.pictures').filter(':visible').html() != null) {
					$('.pictures').filter(':visible').fgpgallery();
				}
				return false;
			});
			return false;
		}).on('click', 'a.js-admin-select-all', function() {
			$('.js-checkbox-list').prop("checked", true);
			return false;
		}).on('click', 'a.js-admin-select-none', function() {
			$('.js-checkbox-list').prop("checked", false);
			return false;
		}).on('click', 'a.js-admin-select-pending', function() {
			$('.js-checkbox-active').prop('checked', false);
			$('.js-checkbox-inactive').prop("checked", true);
			return false;
		}).on('click', 'a.js-admin-select-approved', function() {
			$('.js-checkbox-active').prop("checked", true);
			$('.js-checkbox-inactive').prop('checked', false);
			return false;
		}).on('click', 'a.js-admin-select-flagged', function() {
			$('.js-checkbox-flagged').prop("checked", true);
			$('.js-checkbox-unflagged').prop('checked', false);
			return false;
		}).on('click', 'a.js-admin-select-unflagged', function() {
			$('.js-checkbox-flagged').prop('checked', false);
			$('.js-checkbox-unflagged').prop("checked", true);
			return false;
		}).on('click', 'a.js-admin-select-suspended', function() {
			$('.js-checkbox-suspended').prop("checked", true);
			$('.js-checkbox-unsuspended').prop('checked', false);
			return false;
		}).on('click', 'a.js-admin-select-unsuspended', function() {
			$('.js-checkbox-suspended').prop('checked', false);
			$('.js-checkbox-unsuspended').prop("checked", true);
			return false;
		}).on('click', '.js-request_invite', function(e) {
			$('div.js-responses').eq(0).block();
			$.get(__cfg('path_absolute') + 'subscriptions/add/type:invite_request', function(data) {
				$('div.js-responses').html(data);
				$('div.js-responses').unblock();
			});
			return false;
		}).on('click', 'form a.js-captcha-reload, form a.js-captcha-reload', function() {
			captcha_img_src = $(this).parents('.js-captcha-container').find('.captcha-img').attr('src');
			captcha_img_src = captcha_img_src.substring(0, captcha_img_src.lastIndexOf('/'));
			$(this).parents('.js-captcha-container').find('.captcha-img').attr('src', captcha_img_src + '/' + Math.random());
			return false;
		}).on('change', 'form select.js-admin-index-autosubmit', function() {
			if ($('.js-checkbox-list:checked').val() != 1 && $(this).val() >= 1) {
				alert(__l('Please select atleast one record!'));
				return false;
			} else if ($(this).val() >= 1) {
				if (window.confirm(__l('Are you sure you want to do this action?'))) {
					$(this).parents('form').submit();
				} else {
					$(this).val('');
				}
			}
		}).on('change', 'form select.js-autosubmit', function() {
			$(this).parents('form').submit();
		}).on('click', 'a.js-toggle-show', function() {
			$('.' + $(this).metadata().container).slideToggle();
			$('.js-link').removeClass('hide');
			if ($('.' + $(this).metadata().hide_container)) {
				$('.' + $(this).metadata().hide_container).slideUp();
			}
			return false;
		}).on('click', 'span.js-chart-showhide', function() {
			dataurl = $(this).metadata().dataurl;
			dataloading = $(this).metadata().dataloading;
			classes = $(this).attr('class');
			classes = classes.split(' ');
			if ($.inArray('down-arrow', classes) != -1) {
				$this = $(this);
				$(this).removeClass('down-arrow');
				if ((dataurl != '') && (typeof(dataurl) != 'undefined')) {
					$this.parents('div.js-responses').eq(0).block();
					$.get(__cfg('path_absolute') + dataurl, function(data) {
						$this.parents('div.js-responses').eq(0).html(data);
						$this.parents('div.js-responses').eq(0).unblock();
					});
				}
				$(this).addClass('up-arrow');

			} else {
				$(this).removeClass('up-arrow');
				$(this).addClass('down-arrow');
			}
			$('#' + $(this).metadata().chart_block).slideToggle();
		}).on('click', 'span.js-chart-showhide1', function() {
			var text = $('.panel');
			 if (text.is(':hidden')) {
				text.slideDown('200');
				$('span.js-chart-showhide1').removeClass('down-arrow');
				$('span.js-chart-showhide1').addClass('up-arrow');
			} else {
				text.slideUp('200');
				$('span.js-chart-showhide1').removeClass('up-arrow');
				$('span.js-chart-showhide1').addClass('down-arrow');
			}
		}).on('click', 'span.js-chart-showhide2', function() {
			var text1 = $('.panel2');
			 if (text1.is(':hidden')) {
				text1.slideDown('200');
				$('span.js-chart-showhide2').removeClass('down-arrow');
				$('span.js-chart-showhide2').addClass('up-arrow');
			} else {
				text1.slideUp('200');
				$('span.js-chart-showhide2').removeClass('up-arrow');
				$('span.js-chart-showhide2').addClass('down-arrow');
			}
		}).on('click', 'span.js-chart-showhide3', function() {
			var text3 = $('.panel3');
			 if (text3.is(':hidden')) {
				text3.slideDown('200');
				$('span.js-chart-showhide3').removeClass('down-arrow');
				$('span.js-chart-showhide3').addClass('up-arrow');
			} else {
				text3.slideUp('200');
				$('span.js-chart-showhide3').removeClass('up-arrow');
				$('span.js-chart-showhide3').addClass('down-arrow');
			}
		}).on('click', 'span.js-chart-showhide4', function() {
			var text3 = $('.panel4');
			 if (text3.is(':hidden')) {
				text3.slideDown('200');
				$('span.js-chart-showhide4').removeClass('down-arrow');
				$('span.js-chart-showhide4').addClass('up-arrow');
			} else {
				text3.slideUp('200');
				$('span.js-chart-showhide4').removeClass('up-arrow');
				$('span.js-chart-showhide4').addClass('down-arrow');
			}
		}).on('change', 'form select.js-chart-autosubmit', function() {
			var $this = $(this).parents('form');
			$this.block();
			dataloading = $this.metadata().dataloading;
			$this.ajaxSubmit( {
				beforeSubmit: function(formData, jqForm, options) {
					$this.block();
				},
				success: function(responseText, statusText) {
					$this.parents('div.js-responses').eq(0).html(responseText);
					$this.unblock();
				}
			});
			return false;
		}).on('blur', '.form-error', function() {
			$this = $(this);
			$this.parent().removeClass('error');
			$this.parent().find('div.error-message').remove();
		}).on('click', 'form input.js-wallet-block', function() {
			var user_balance = $(this).metadata().balance;
			if (user_balance != '' && user_balance != '0.00') {
				return window.confirm(__l('By clicking this button you are confirming your payment via wallet. Once you confirmed amount will be deducted from your wallet and you cannot undo this process. Are you sure you want to confirm this action?'));
			} else if ( ! user_balance || user_balance == '0.00') {
				alert(__l('You don\'t have sufficent amount in wallet to continue this process. So please select any other payment gateway.'));
				return false;
			} else {
				return true;
			}
		}).on('click', '.js-accept_download', function() {
				return window.confirm(__l('Please verify the files, uploaded by Participant. Once you downloaded the files, contest status will change to completed automatically. Are you sure you want to continue?'));
		}).on('click', '.js-payment-type', function() {
            var $this = $(this);
            if ($this.val() == 4) {
				$('.js-normal-sudopay').slideDown('fast');
				$('.js-wallet-connection').slideUp('fast');
			} else if ($this.val() == 2) {
                $('.js-form, .js-instruction').addClass('hide');
                $('.js-wallet-connection').slideDown('fast');
                $('.js-normal-sudopay').slideUp('fast');
            } else if ($this.val() == 1) {
                $('.js-normal-sudopay').slideDown('fast');
                $('.js-wallet-connection').slideUp('fast');
            } else if ($this.val().indexOf('sp_') != -1) {
                $('.js-gatway_form_tpl').hide();
                form_fields_arr = $(this).data('sudopay_form_fields_tpl').split(',');
                for (var i = 0; i < form_fields_arr.length; i ++ ) {
                    $('#form_tpl_' + form_fields_arr[i]).show();
                }
                var instruction_id = $this.val();
                $('.js-instruction').addClass('hide');
                $('.js-form').removeClass('hide');
                if (typeof($('.js-instruction_' + instruction_id).html()) != 'undefined') {
                    $('.js-instruction_' + instruction_id).removeClass('hide');
                }
                if (typeof($('.js-form_' + instruction_id).html()) != 'undefined') {
                    $('.js-form_' + instruction_id).removeClass('hide');
                }
                $('.js-normal-sudopay').slideDown('fast');
                $('.js-wallet-connection').slideUp('fast');
            }
        }).on('click', '.js-skip-btn', function() {
			$this = $(this);
			$('.js-social-load').block();
			$.get($this.prop('href'), function(data) {
				$('.js-social-load').html(data);
				$('.js-social-load').unblock();
			});
			return false;
		}).on('click', '.js-link-chart', function() {
			$this = $(this);
			dataloading = $this.metadata().data_load;
			$('.' + dataloading).block();
			$.get($this.attr('href'), function(data) {
				$('.' + dataloading).html(data);
				$('.' + dataloading).find('script').each(function(i) {
                    eval($(this).text());
                });
				$('.' + dataloading).unblock();
			});
			return false;
		}).on('click', 'a.js-accordion-link', function() {
			$this = $(this);
			var contentDiv = $this.prop('href');
			$id = $this.metadata().data_id;
			$parent_class = $('.js-content-' + $id).parent('div').prop('class');
			$this.children('i').toggleClass("icon-minus");
			if ($parent_class.indexOf('in') > -1) {
				$('.js-content-' + $id).block();
				$.get($(this).metadata().url, function(data) {
					$('.js-content-' + $id).html(data).unblock();
					return false;
				});
			}
		}).on('click', 'a.js-toggle-icon', function() {
			$this = $(this);
			class_name = $this.find('.icon-chevron-up').prop('class');
			class_name_plus = $this.find('.icon-chevron-down').prop('class');
			if (typeof(class_name) != 'undefined') {
				if (class_name.indexOf('icon-chevron-up') > -1) {
					$this.find('.icon-chevron-up').addClass('icon-chevron-down');
					$this.find('.icon-chevron-down').removeClass('icon-chevron-up');
				}
			}
			if (typeof(class_name_plus) != 'undefined') {
				if (class_name_plus.indexOf('icon-chevron-down') > -1) {
					$this.find('.icon-chevron-down').addClass('icon-chevron-up');
					$this.find('.icon-chevron-up').removeClass('icon-chevron-down');
				}
			}
		}).on('hidden', '.modal', function() {
			$(this).removeData('modal');
		}).on('show', '.modal', function() {
			if ($(this).prop('id') == 'js-ajax') {
				$('#js-ajax-modal').find('.modal-header').html('');
			}
			if (!$(this).hasClass('bootstrap-wysihtml5-insert-image-modal') && !$(this).hasClass('bootstrap-wysihtml5-insert-link-modal') && !$(this).hasClass('modal hide fade in')) {
				$(this).find('.modal-body').html('<img src="' + __cfg('path_absolute') + '/img/throbber.gif"> Loading...');
			}
		}).on('focus', '.js-show-submit-block', function() {
			$('.js-add-block').removeClass('hide');
			$(this).parent().addClass('textarea-large');
		}).on('mouseover', '.js-image-hover', function() {
			$('.js-slider-content').removeClass('js-slider-show');
		}).on('mouseout', '.js-image-hover', function() {
			$('.js-slider-content').addClass('js-slider-show');
		}).on('click', '.js-contest-follow', function() {
			var _this = $(this);
			_this.block();
			$.get(_this.attr('href'), function(data) {
				if (data != '') {
					var data_array = data.split('|');
					if (data_array[0] == 'followed') {
						_this.text(__l('Unfollow')).attr('class', 'js-contest-follow like').attr('title', __l('UnFollow')).attr('href', data_array[1]);
					} else if (data_array[0] = 'unfollowed') {
						_this.text(__l('Follow')).attr('class', 'js-contest-follow un-like').attr('title', __l('Follow')).attr('href', data_array[1]);
					}
				}
				$('js-contest-follow').unblock();
			});
			return false;
		}).on('change', '.js-field-type', function(e) {
			if ($('.js-field-type').val() == 'select' || $('.js-field-type').val() == 'checkbox' || $('.js-field-type').val() == 'radio' || $('.js-field-type').val() == 'multiselect' || $('.js-field-type').val() == 'slider') {
				$('.js-options-show').show();
			} else {
				$('.js-options-show').hide();
			}
		}).on('change', '.js-field-type-edit', function(e) {
			if ($(this).val() == 'select' || $(this).val() == 'checkbox' || $(this).val() == 'radio' || $(this).val() == 'multiselect') {
				if ($(this).parents('td').find('div.options-field-block').hasClass('hide')) {
					$(this).parents('td').find('div.options-field-block').removeClass('hide');
				}
			} else {
				$(this).parents('td').find('div.options-field-block').addClass('hide');
			}
		}).on('click', '.js-prize-package', function(e) {
			$('#ContestTotalWithOutDays').val($(this).metadata().prize);
			updateContestAmount();
		}).on('click', '.js-pricing-day', function(e) {
			$('#ContestDaysComplete').val($(this).metadata().price);
			updateContestAmount();
		}).on('click', '.js-name-prize', function(e) {
			$('#ContestTotalWithOutDays').val($('#ContestPrize').val());
			updateContestAmount();
		}).on('blur', '#ContestPrize', function(e) {
			if ($('.js-name-prize:checked').val() == 0) {
				$('#ContestTotalWithOutDays').val($('#ContestPrize').val());
				updateContestAmount();
			}
		}).on('click', '.js-flip', function(e) {
			$this = $(this);
			//$('.content').css('overflow', 'hidden');
			if ($this.hasClass('js-flip-in')) {
				$this.removeClass('js-flip-in').addClass('js-flip-out');
				var conversation_width = 37;
				var contest_width = 58;
				if ($this.hasClass('js-text-resource')) {
					conversation_width = 36;
					contest_width = 54;
				}
				$('.js-conversation-block').css({'position': 'relative', 'display': 'block'}).animate( {
					'width': conversation_width+'%'
				}, 'slow');
				$('.contest-user-img-block').css({'position': 'relative','margin': '0px'}).animate( {
					'width': contest_width+'%'
				}, 'slow');
			} else {
				$this.removeClass('js-flip-out').addClass('js-flip-in');
				$('.js-conversation-block').css({'position': 'relative', 'display': 'none'}).animate( {
					'width': '0%'
				}, 'slow');
				var contest_width = 98;
				if ($this.hasClass('js-text-resource')) {
					contest_width = 92.5;
				}
				$('.contest-user-img-block').css({'position': 'relative','margin': '0px'}).animate( {
					'width': contest_width+'%'
				}, '100');
			}
		}).on('click', '.js-entry-view-toggle', function(e) {
			$this = $(this);
			$('.' + $this.metadata().container).slideToggle();
			if ($this.hasClass('drop')) {
				$this.removeClass('drop');
				$this.next('ul').slideUp(1000);
			} else {
				$this.addClass('drop');
				$this.next('ul').slideDown(1000);
			}
			if ($this.is('.down-arrow')) {
				$this.removeClass('down-arrow').addClass('up-arrow');
			} else {
				$this.removeClass('up-arrow').addClass('down-arrow');
			}
		}).on('click', '.js-slider-show, .js-slider-close', function(e) {
			$this = $(this);
			animHeight = $(document).height() - $('#header').height();
			if ($this.is('.down-arrow') && !$this.hasClass('js-slider-close')) {
				$('.js-overlay').addClass('overlay-block');
				$('.slider-block').animate( {
					height: animHeight + 'px'
				}, 800);
				$('.js-slider-show').removeClass('down-arrow').addClass('up-arrow');
			} else {
				$('.slider-block').animate( {
					height: '0px'
				}, 350);
				$('.js-overlay').removeClass('overlay-block');
				$('.js-slider-show').removeClass('up-arrow').addClass('down-arrow');
			}
		}).on('focus', '.js-show-submit-block', function(e) {
			$('.js-add-block').removeClass('hide');
			$(this).parent().addClass('textarea-large');
		}).on('click', 'div#setting-ContestUser_watermark_type input', function(e) {
			if ($('div#setting-ContestUser_watermark_type input:checked').val() == 'Watermark Image') {
				$('div#setting-site_watermark').show();
				$('div.watermark-image').show();
				$('div#setting-Watermark_watermark_text').hide();
			}
			if ($('div#setting-ContestUser_watermark_type input:checked').val() == 'Enable Text Watermark') {
				$('div#setting-Watermark_watermark_text').show();
				$('div.watermark-image').hide();
				$('div#setting-site_watermark').hide();
			}
		}).on('click', '.js-pricing-package-checkbox', function(e) {
			$this = $(this);
			id = $this.metadata().pricing_package_id;
			if ($('#PricingPackage' + id + 'IsChecked:checked').val()) {
				$('#PricingPackage' + id + 'Price, #PricingPackage' + id + 'MaximumEntryAllowed, #PricingPackage' + id + 'ParticipantCommision').attr('disabled', false);
				$('#PricingPackage' + id + 'Price, #PricingPackage' + id + 'MaximumEntryAllowed, #PricingPackage' + id + 'ParticipantCommision').removeClass('disabled');
			} else {
				$('#PricingPackage' + id + 'Price, #PricingPackage' + id + 'MaximumEntryAllowed, #PricingPackage' + id + 'ParticipantCommision').attr('disabled', 'disabled');
				$('#PricingPackage' + id + 'Price, #PricingPackage' + id + 'MaximumEntryAllowed, #PricingPackage' + id + 'ParticipantCommision').addClass('disabled');
			}
		}).on('click', '.js-pricing-day-checkbox', function(e) {
			$this = $(this);
			id = $this.metadata().pricing_day_package_id;
			if ($('#PricingDay' + id + 'IsChecked:checked').val()) {
				$('#PricingDay' + id + 'Price').attr('disabled', false);
				$('#PricingDay' + id + 'Price').removeClass('disabled');
			} else {
				$('#PricingDay' + id + 'Price').attr('disabled', 'disabled');
				$('#PricingDay' + id + 'Price').addClass('disabled');
			}
		}).on('click', '.js-other-fee-checkbox', function(e) {
			$this = $(this);
			name = $this.metadata().other_fee_name;
			if ($('#ContestType' + name + 'IsChecked:checked').val()) {
				$('#ContestType' + name + 'Price').attr('disabled', false);
				$('#ContestType' + name + 'Price').removeClass('disabled');
			} else {
				$('#ContestType' + name + 'Price').attr('disabled', 'disabled');
				$('#ContestType' + name + 'Price').addClass('disabled');
			}
		}).on('click', '.js-other-fee-price-checkbox', function(e) {
			$this = $(this);
			name = $this.metadata().other_fee_name;
			amount = $this.metadata().amount;
			if ($('#Contest' + name + 'IsChecked:checked').val()) {
				$('#ContestOtherFee').val(parseFloat($('#ContestOtherFee').val()) + parseFloat(amount));
				updateContestAmount();
			} else {
				$('#ContestOtherFee').val(parseFloat($('#ContestOtherFee').val()) - parseFloat(amount));
				updateContestAmount();
			}
		}).on('click', '.js-pricing-day-extend', function(e) {
			$('.js-total-prize').html($(this).metadata().price);
			if($(this).metadata().price > 0) {
				if ($('.js-extendtime-payment-block').hasClass('hide')) {
					$('.js-extendtime-payment-block').removeClass('hide');
				}
				if (!$('.js-extendtime-normal-block').hasClass('hide')) {
					$('.js-extendtime-normal-block').addClass('hide');
				}
			} else {
				if ($('.js-extendtime-normal-block').hasClass('hide')) {
					$('.js-extendtime-normal-block').removeClass('hide');
				}
				if (!$('.js-extendtime-payment-block').hasClass('hide')) {
					$('.js-extendtime-payment-block').addClass('hide');
				}
			}
		}).on('click', '.js-form-field-delete', function(e) {
			var fieldId = $(this).closest('tr').find('input[name*="data[FormField]"][name*="[id]"]').val();
			clicked = $(this);
			var remove_url = clicked.attr('href');
			if (fieldId) {
				$.post(remove_url, function(response) {
					if (response == 'success') {
						clicked.closest('tr').remove();
					}
				});
			} else {
				$(this).closest('tr').remove();
			}
			return false;
		}).on('change', 'select[id*="FormField"][id*="Type"]', function(e) {
			var value = $(this).val();
			var select = ['checkbox', 'select', 'radio'];
			if (jQuery.inArray(value, select) > -1) {
				$(this).closest('td').children('div.text').show();
			} else {
				$(this).closest('td').children('div.text').hide();
			}
		}).on('submit', '#addField form', function(e) {
			var data = $(this).serialize();
			var url = $(this).attr('action');
			$.post(url, data, function(response) {
				if (response) {
					result = response.split('*');
					if ($.trim(result[0]) == 'success') {
						$.get(__cfg('path_relative') + 'admin/form_fields/get_row/' + result[1], function(data) {
							$('#sortable tbody').append(data);
						});
					} else {
						$('.js-response').html(response);
					}
				}
				return false;
			});
			return false;
		}).on('click', '.js-notification', function(e) {
			$this = $(this);
			$.get($this.prop('href'), function(data) {
				$('.js-notification-list').html(data);
			});
		}).on('submit', 'form', function(e) {
			$this = $(this);
			$this.find('div.input input[type=text], div.input input[type=password], div.input textarea:not(.js-editor), div.input select').filter(':visible').trigger('blur');
			$('input, textarea, select', $('.error', $this).filter(':first')).trigger('focus');
			return ! ($('.error-message', $this).length);
		});
		// Get the Geo City, State And Country
		if ($.cookie('_geo') == null) {
			$.ajax( {
				type: 'GET',
				url: '//j.maxmind.com/app/geoip.js',
				dataType: 'script',
				cache: true,
				success: function() {
					var geo = geoip_country_code() + '|' + geoip_region_name() + '|' + geoip_city() + '|' + geoip_latitude() + '|' + geoip_longitude();
					$.cookie('_geo', geo, {
						expires: 100,
						path: '/'
					});
				}
			});
		}
	}).ajaxStop(function() {
        xload(true);
    });
})();


