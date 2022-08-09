import MicroModal from 'micromodal';
import './main.scss';

MicroModal.init({
  openTrigger        : 'data-wsd-open', // [3]
  closeTrigger       : 'data-wsd-close', // [4]
  openClass          : 'is-open', // [5]
  disableScroll      : true, // [6]
  disableFocus       : false, // [7]
  awaitOpenAnimation : false, // [8]
  awaitCloseAnimation: false, // [9]
  debugMode          : true, // [10]
});

jQuery(document).ready(function($) {
  $('.wsd-modal-trigger').click(function() {
    $('.wsd-form').find('input[name="wsd-post_id"]').val($(this).data('post_id'));
  });

  function wsd_download_file(fileUrl, fileName) {
    var a = document.createElement('a');
    a.href = fileUrl;
    a.setAttribute('download', fileName);
    a.click();
  }

  /**
   * 提交表单操作
   */
  $('.wsd-form').submit(function() {
    let button = $(this).find('button[type=submit]');
    $.ajax({
      type      : 'POST',
      dataType  : 'json',
      url       : subscribeDownloadApiSettings.ajax_url,
      data      : {
        'action' : 'wsd_subscribe',
        'email'  : $(this).find('input[name=wsd-email]').val(),
        'post_id': $(this).find('input[name=wsd-post_id]').val(),
      },
      beforeSend: function() {
        button.addClass('wsd-loading').prop('disabled', true);
      },
      success   : function(data) {
        button.removeClass('wsd-loading').prop('disabled', false);
        if (data.success === true) {
          wsd_download_file(data.data.url, data.data.name);
          MicroModal.close('wsd-subscribe-modal');
        }
      },
      error     : function(data) {
        button.removeClass('wsd-loading').prop('disabled', false);
        $('form#modal-login div.status').html(data.message).fadeIn();
      },
    });

    return false;
  });
});