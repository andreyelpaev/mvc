/**
 * Created with JetBrains PhpStorm.
 * User: Andrey
 * Date: 05.08.13
 * Time: 20:01
 * To change this template use File | Settings | File Templates.
 */

$(document).ready(function() {
    $('ul.left_menu ul').each(function(i) {
        if ($.cookie('submenu-' + i)) {
            $(this).show().prev().removeClass('collapsed').addClass('expanded');
        }else {
            $(this).hide().prev().removeClass('expanded').addClass('collapsed');
        }
        $(this).prev().addClass('collapsible').click(function() {
            var this_i = $('ul.left_menu ul').index($(this).next());
            if ($(this).next().css('display') == 'none') {
                $(this).next().slideDown(400, function () {
                    $(this).prev().removeClass('collapsed').addClass('expanded');
                    cookieSet(this_i);
                });
            }else {
                $(this).next().slideUp(400, function () {
                    $(this).prev().removeClass('expanded').addClass('collapsed');
                    cookieDel(this_i);
                    $(this).find('ul').each(function() {
                        $(this).hide(0, cookieDel($('ul.left_menu ul').index($(this)))).prev().removeClass('expanded').addClass('collapsed');
                    });
                });
            }
            return false;
        });
    });
});
function cookieSet(index) {
    $.cookie('submenu-' + index, 'opened', {expires: null, path: '/'});
}
function cookieDel(index) {
   $.cookie('submenu-' + index, null, {expires: -1, path: '/'});
}