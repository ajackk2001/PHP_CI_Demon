var waitingDialog = waitingDialog || (function($) {
    'use strict';
    // Creating dialog's DOM
    var $dialog =
        `
        <div class="loadingContainer">
            <div class="loadingContent">
                <i class="fas fa-spinner fa-spin fa-5x"></i>
            </div>
        </div>
        `

    return {
        show: function() {
            // Opening dialog
            $('body').append($dialog);
            // $('body, .modal').append('sdasdadjasdkalsdjalsdkalsdjalsdjaksdlaskdla');
        },
        /**
         * Closes dialog
         */
        hide: function() {
            $('.loadingContainer').remove();
            //$dialog.remove();
        }
    };

})(jQuery);