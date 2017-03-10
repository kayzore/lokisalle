var jsRouting = function () {
    var liste_routes_admin,
        liste_routes_public,
        getUrl,
        replaceParams;

    $.get('web/assets/routing/routing-admin.yml').done(function (data) {
        liste_routes_admin = jsyaml.load(data);
    });
    $.get('web/assets/routing/routing.yml').done(function (data) {
        liste_routes_public = jsyaml.load(data);
    });

    /**
     * Génère une url a partir d'une route et la retourne
     */
    getUrl = function (type, route, params) {
         if (type === 'admin') {
             return replaceParams(liste_routes_admin[route].route, params);
         } else if (type === 'public') {
             return replaceParams(liste_routes_public[route].route, params);
         }
     };

    replaceParams = function (path, params) {
        $.each(params, function (k, param) {
            path = path.replace(":" + k, param);
        });
        return path;
    };

    return {
        getUrl: getUrl
    };
}();
