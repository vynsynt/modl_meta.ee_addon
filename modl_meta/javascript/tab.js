(function($) {

    var _reset_meta_inputs = function() {
        var lang = 'en';
        if( arguments.length ) {
            lang = arguments[0];
        }

        $('div[id*="modl_meta_title_"]').hide();
        $('div[id*="modl_meta_keywords_"]').hide();
        $('div[id*="modl_meta_description_"]').hide();

        $('div[id*="modl_meta_title_'+lang+'"]').show();
        $('div[id*="modl_meta_keywords_'+lang+'"]').show();
        $('div[id*="modl_meta_description_'+lang+'"]').show();
    };

    $(function() {
        _reset_meta_inputs();
        $('#modl_meta__modl_media_lang_cc').change(function(e) {
            var cc = $(this).val();
            _reset_meta_inputs(cc);
        });

    });
})(jQuery);