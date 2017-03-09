var jsRouting = function () {
    var url, getUrl, generate;

    /**
     * Genere une url a partir d'une route et la stock en mémoire
     * @param route
     * @param params
     */
     generate = function (route, params) {
         $.ajax({
             async: false,
             url : '/lokisalle/get-routes/'+route+'/'+params,
             type : 'GET',
             dataType : 'html',
             success : function(returnUrl){
                url = returnUrl;
             }
         });
     };

    /**
     * Retourne l'url actuellement stocké en mémoire
     * @returns {*}
     */
    getUrl = function () {
         return url;
     };

    return {
        generate: generate,
        getUrl: getUrl
    };
}();
