window.$ = window.jQuery = require('jquery');

require('./fontawesome-all');

$(document).ready(function() {
    if (typeof UseScripts !== 'undefined' && UseScripts.includes('loadDataAjax')) {
        require('./loadDataAjax');
    }
});