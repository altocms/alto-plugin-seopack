var ls = ls || {};
ls.toolbar = ls.toolbar || {};

/**
 * Функционал кнопки "SEOPack"
 */
ls.toolbar.seopack = (function ($) {
    "use strict";

    this.open = function () {
        $('#modal-seopack_edit').modal('show');
        return false;
    };

    this.toggleForm = function (parameter) {
        if ($('#seopack-' + parameter + '-form-text').is(":disabled")) {
            $('#seopack-' + parameter + '-form-text').prop("disabled", false);
            $('#seopack-' + parameter + '-form-text').focus();
        } else {
            $('#seopack-' + parameter + '-form-text').prop("disabled", true);
        }
    };

    this.getValue = function (parameter) {
        var value;
        if ($('#seopack-' + parameter + '-button-remove').is(":visible")) {
            value = $('#seopack-' + parameter + '-form-text').val();
        } else {
            value = null;
        }
        return value;
    };

    this.save = function (seo_url) {
        var url = ls.routerUrl('seopack') + 'ajax-set/';
        var params = {
            url: seo_url,
            title: $('#seopack-title-form-text').val(),
            description: $('#seopack-description-form-text').val(),
            keywords: $('#seopack-keywords-form-text').val(),
            title_auto: $('#title_auto').prop('checked'),
            description_auto: $('#description_auto').prop('checked'),
            keywords_auto: $('#keywords_auto').prop('checked')
        };
        ls.progressStart();
        ls.ajax(url, params, function (result) {
            ls.progressDone();
            if (result.bStateError) {
                ls.msg.error(null, result.sMsg);
            } else {
                if (result.title)document.title = result.title;
                $('#modal-seopack_edit').modal('hide');
                ls.msg.notice(null, result.sMsg);
            }
        }.bind(this));
        return false;
    };

    this.cancel = function () {
        $('#modal-seopack_edit').modal('hide');
        return false;
    };

    return this;
}).call(ls.toolbar.seopack || {},jQuery);

