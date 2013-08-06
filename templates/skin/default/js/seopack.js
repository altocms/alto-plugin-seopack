jQuery(document).ready(function($){
	$('#seopack-edit').jqm({modal: true, toTop: true});
});

var ls = ls || {};
ls.toolbar = ls.toolbar || {};

/**
 * Функционал кнопки "SEOPack"
 */
ls.toolbar.seopack = (function ($) {

	this.open = function( ) {
		$('#seopack-edit').jqmShow();
		return false;
	};	
	
	this.toggleForm = function( parameter ) {
		if($('#seopack-'+parameter+'-form-text').is(":disabled")){			
			$('#seopack-'+parameter+'-form-text').prop("disabled", false);
			$('#seopack-'+parameter+'-form-text').focus();
		}else{
			$('#seopack-'+parameter+'-form-text').prop("disabled", true);
		}
	};

	this.getValue = function ( parameter ){
		if( $('#seopack-'+parameter+'-button-remove').is(":visible")){
			value = $('#seopack-'+parameter+'-form-text').val();
		}else{
			value = null;
		}
		return value;
	};
	
	this.save = function( seo_url ) {
		var url = aRouter['seopack']+'ajax-set/';
		var params={url : seo_url,
					title : $('#seopack-title-form-text').val(),
					description : $('#seopack-description-form-text').val(),
					keywords : $('#seopack-keywords-form-text').val(),
					title_auto : $('#title_auto').prop('checked'),
					description_auto : $('#description_auto').prop('checked'),
					keywords_auto : $('#keywords_auto').prop('checked') 
					};
		ls.ajax(url, params, function(result) {
			if (result.bStateError) {
				ls.msg.error(null, result.sMsg);
			}else{
				if(result.title)document.title = result.title;
				$('#seopack-edit').jqmHide();
				ls.msg.notice(null, result.sMsg);
			}
		}.bind(this));
		return false;
	};
	
	this.cancel = function( ) {
		$('#seopack-edit').jqmHide();
		return false;
	};
	
	return this;
}).call(ls.toolbar.seopack || {},jQuery);