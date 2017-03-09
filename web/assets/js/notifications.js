var notification = function () {
    var show,
        example;

    // Fichier a inclure :
    // <link href="{{ assets('web/assets/css/animate.css')}}" rel="stylesheet" />
    // <script src="{{ assets('web/assets/js/bootstrap-notify.min.js'}}"></script>
    // <script src="{{ assets('web/assets/js/notifications.js'}}"></script>

    /**
     * Affiche une notification
     * @param title string
     * @param message string
     * @param type string
     * @param placement object
     * @param animate object
     */
    show = function (title, message, type, placement, animate) {
        $.notify({
            title: '<strong>' + title + '</strong>',
            message: message
        },{
            type: type,
            placement: {
                from: placement.from,
                align: placement.align
            },
            animate: {
                enter: 'animated ' + animate.enter,
                exit: 'animated ' + animate.exit
            }
        });
    };

    // Example d'utilisation
    example = function () {
        show(
            'Success !', 'Ajout dans le panier réussi !', 'success',
            {from:'top', align:'right'}, {enter:'fadeInDown', exit:'fadeOutUp'}
        );
    };

    return {
        show: show,
        example: example
    }
}();