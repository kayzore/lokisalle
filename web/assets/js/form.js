var form = function () {
    var removeErrors,
        showErrors,
        enableForm,
        disableForm;

    /**
     * Affiche les erreurs de champ d'un formulaire
     * @param errors array Tableau associatif des erreurs
     */
    showErrors = function (errors) {
        $.each(errors, function(index, value) {
            var indexTag = $('#' + index)[0],
                parentDivInput = $(indexTag)[0].parentNode,
                formGroup = $(indexTag)[0].parentNode.parentNode;
            if ($(indexTag).is("input") || $(indexTag).is("textarea") || $(indexTag).is("select")) {
                $(formGroup).addClass('has-error');
                $(parentDivInput).append('<span class="help-block">'+ value[0] +'</span>');
            }
        });
    };

    /**
     * Efface les erreurs de champ d'un formulaire
     * @param selector string Selecteur à rechercher
     * @param removeClass bool Indique si la fonction s'applique à une class (true) ou non (false)
     * @param className string Nom de la class à éffacer
     */
    removeErrors = function (selector, removeClass, className) {
        var errors = $(selector);
        $.each(errors, function(index, value) {
            if (removeClass) {
                $(value).removeClass(className);
            } else {
                value.parentNode.removeChild(value);
            }
        });
    };

    /**
     * Active les éléments d'un formulaire
     * @param formElement array Tableau d'element de formulaire
     * @param loader Objet loader a afficher
     */
    enableForm = function (formElement, loader) {
        var i;
        for (i = 0; i < formElement.length; i++) {
            if ($(formElement[i]).is("button")) {
                $(formElement[i]).removeClass('disabled').removeAttr('disabled');

            } else if($(formElement[i]).is("select")) {
                $(formElement[i]).removeAttr('disabled');

            } else {
                $(formElement[i]).removeAttr('disabled');
            }
        }
        loader.fadeOut('fast');
    };

    /**
     * Desactive les éléments d'un formulaire
     * @param formElement array Tableau d'element de formulaire
     * @param loader Objet loader a afficher
     */
    disableForm = function (formElement, loader) {
        var i;
        for (i = 0; i < formElement.length; i++) {
            if ($(formElement[i]).is("button")) {
                $(formElement[i]).addClass('disabled');
            }
            $(formElement[i]).attr('disabled', 'disabled');
        }
        loader.fadeIn('slow');
    };

    return {
        removeErrors: removeErrors,
        showErrors: showErrors,
        enableForm : enableForm,
        disableForm : disableForm
    };
}();