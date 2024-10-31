(function($) {
    $(document).ready(function(){
        //Replace all function//
        String.prototype.replaceAll = function(search, replacement) {
            var target = this;
            return target.replace(new RegExp(search, 'g'), replacement);
        };
        
        /* Add Logo to Metabox */
        var meta_header = $('#rel-meta > .ui-sortable-handle');
        var cs_link = 'https://customscripts.tech';
        var logourl = '/wordpress/wp-content/plugins/re-lister/assets/images/logo.png';
        var logocode = '<a href="'+cs_link+'"><img id="cs-logo" src="' + logourl + '" /></a>';
        meta_header.css("min-height", "30px");
        meta_header.append(logocode);
        var logo = $('#cs-logo');
        logo.css({
            height: "30px",
            float: "right",
        });
        
        /* Enable Sliding Panels */
        var hidden = $('.rel-panel-hidden').children('.rel-body');
        hidden.hide();
        var titles = $('.rel-panel-heading');
        titles.click(function(){
            var title = $(this);
            var par = title.parent();
            var sub_body = par.children('.rel-body');
            if(par.hasClass('rel-panel-hidden')){
                sub_body.slideDown(500, function(){
                    par.removeClass('rel-panel-hidden');
                    par.addClass('rel-panel-visible');
                });
            } else {
                sub_body.slideUp(250, function(){
                    par.removeClass('rel-panel-visible');
                    par.addClass('rel-panel-hidden');
                });
            }
        });
        
        /* Shortcode Descriptions on Hover */
        var lbl_req = $('.rel-lbl-required');
        var lbl_opt = $('.rel-lbl-optional');
        var lbl;
        var lblStr;
        lbl_req.hover(function(){
            lbl = $(this);
            lblStr = lbl.text();
            lblStr = lblStr.replace(':','');
            lblStr = lblStr.replaceAll(' ','');
            var codeStr = '<div id="lbl-'+lblStr+'" style="position: absolute; margin-top: -18px; color: #cccccc;">[' + lblStr + ']</div>';
            lbl.prepend(codeStr);
        },function(){
            var lblId = '#lbl-' + lblStr;
            $(lblId).remove();
        });        
        lbl_opt.hover(function(){
            lbl = $(this);
            lblStr = lbl.text();
            lblStr = lblStr.replace(':','');
            lblStr = lblStr.replaceAll(' ','');
            var codeStr = '<div id="lbl-'+lblStr+'" style="position: absolute; margin-top: -18px; color: #cccccc;">[' + lblStr + ']</div>';
            lbl.prepend(codeStr);
        },function(){
            var lblId = '#lbl-' + lblStr;
            $(lblId).remove();
        });
    });
})( jQuery );