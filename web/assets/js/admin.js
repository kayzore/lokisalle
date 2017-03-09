jQuery(document).ready(function () {
    var resultPost,
        resultGet;

    function post(route, data, dataType, params) {
        jsRouting.generate(route, params);
        $.ajax({
            url: '../' + jsRouting.getUrl(),
            type: "POST",
            data: data,
            dataType: dataType,
            async: false,
            timeout: 5000,
            success: function(result) {
                resultPost = result;
            },
            error: function (jqXhr, statut, errorMsg) {
                console.log(errorMsg);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }

    function get(route, data, dataType, params) {
        jsRouting.generate(route, params);
        $.ajax({
            url: '../' + jsRouting.getUrl(),
            type: "GET",
            data: data,
            dataType: dataType,
            async: false,
            timeout: 5000,
            success: function(result) {
                resultGet = result;
            },
            error: function (jqXhr, statut, errorMsg) {
                console.log(errorMsg);
            }
        });
    }

    function formatDatetime(datetime, withNotSecond) {
        if (withNotSecond) {
            return moment(datetime, 'YYYY-MM-DD HH:mm:ss').format('DD/MM/YYYY HH:mm');
        }
        return moment(datetime, 'YYYY-MM-DD HH:mm:ss').format('DD/MM/YYYY HH:mm:ss');
    }

    //=============================================================================================================
    //===============================================SALLES========================================================
    function actualiseTabSalle(listSalle) {
        var i,
            tabSalle = $('#tbodySalles');
        tabSalle.html('');
        for (i = 0; i < listSalle.length; i++) {
            var row =
                '<tr>'
                    + '<td style="vertical-align:middle" class="text-center">' + listSalle[i].id_salle + '</td>'
                    + '<td style="vertical-align:middle" class="text-center">' + listSalle[i].titre + '</td>'
                    + '<td style="vertical-align:middle" class="text-center">' + listSalle[i].description + '</td>'
                    + '<td style="vertical-align:middle">'
                        + '<a href="../web/uploads/' + listSalle[i].photo + '" data-lightbox="salle-' + listSalle[i].id_salle + '" data-title="Salle de ' + listSalle[i].categorie + '">'
                            + '<img src="../web/uploads/' + listSalle[i].photo + '" class="img-responsive center-block imgSalleAdmin" alt="Salle de ' + listSalle[i].categorie + '">'
                        + '</a>'
                    + '</td>'
                    + '<td style="vertical-align:middle" class="text-center">' + listSalle[i].pays + '</td>'
                    + '<td style="vertical-align:middle" class="text-center">' + listSalle[i].ville + '</td>'
                    + '<td style="vertical-align:middle" class="text-center">' + listSalle[i].adresse + '</td>'
                    + '<td style="vertical-align:middle" class="text-center">' + listSalle[i].cp + '</td>'
                    + '<td style="vertical-align:middle" class="text-center">' + listSalle[i].capacite + '</td>'
                    + '<td style="vertical-align:middle" class="text-center">' + listSalle[i].categorie + '</td>'
                    + '<td style="vertical-align:middle" class="text-center">'
                        + '<div class="btn-group btn-group-xs" role="group" aria-label="...">'
                            + '<a href="#" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></a>'
                            + '<a href="#" class="btnUpdateSalle btn btn-primary" data-id="' + listSalle[i].id_salle + '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'
                            + '<a href="#" class="btnDeleteSalle btn btn-danger" data-id="' + listSalle[i].id_salle + '"><i class="fa fa-trash" aria-hidden="true"></i></a>'
                        + '</div>'
                    + '</td>'
                + '</tr>';
            tabSalle.append(row);
        }
    }
    // Re-init la modal
    $('#salleModal').on('hidden.bs.modal', function () {
        var modalSalle = $('#salleModal'),
            titleModalSalle = modalSalle[0].children[0].children[0].children[0].children[1],
            formModalSalle = modalSalle[0].children[0].children[0].children[1].children[0];

        $.each(formModalSalle, function (key, value) {
            if ($(value).attr('id') == 'titreInput') {
                $(value).val('')
            } else if ($(value).attr('id') == 'descriptionTextarea') {
                $(value).val('')
            } else if ($(value).attr('id') == 'capaciteSelect') {
                $('option[value="0"]', value).prop('selected', true);
            } else if ($(value).attr('id') == 'categorieSelect') {
                $('option[value="0"]', value).prop('selected', true);
            } else if ($(value).attr('id') == 'paysSelect') {
                $('option[value="0"]', value).prop('selected', true);
            } else if ($(value).attr('id') == 'villeSelect') {
                $('option[value="0"]', value).prop('selected', true);
            } else if ($(value).attr('id') == 'adresseTextarea') {
                $(value).val('')
            } else if ($(value).attr('id') == 'cpInput') {
                $(value).val('')
            } if ($(value).is("button")) {
                $(value)[0].innerText = ''
            }
        });
        formModalSalle.dataset.type = '';
        formModalSalle.dataset.id = '';
        titleModalSalle.innerText = "";

        form.removeErrors('#salleForm .has-error', true, 'has-error');
        form.removeErrors('#salleForm .help-block');
    });
    // Bouton d'ouverture de la modal pour ajouter une salle
    $('#btnAddSalle').click(function (evt) {
        var modalSalle = $('#salleModal'),
            titleModalSalle = modalSalle[0].children[0].children[0].children[0].children[1],
            formModalSalle = modalSalle[0].children[0].children[0].children[1].children[0];
        evt.preventDefault();

        titleModalSalle.innerText = "Ajouter une salle";

        $.each(formModalSalle, function (key, value) {
            if ($(value).is("button")) {
                $(value)[0].innerText = 'Ajouter'
            }
        });
        formModalSalle.dataset.type = 'add';

        modalSalle.modal('show');
    });
    // Bouton d'ouverture de la modal pour modifier une salle
    $(document).on('click', '.btnUpdateSalle', function(evt){
        var row = $(this)[0].parentNode.parentNode.parentNode,
            idSalle = row.children[0].innerText,
            titreSalle = row.children[1].innerText,
            descriptionSalle = row.children[2].innerText,
            villeSalle = row.children[5].innerText,
            adresseSalle = row.children[6].innerText,
            cpSalle = row.children[7].innerText,
            capaciteSalle = row.children[8].innerText,
            categorieSalle = row.children[9].innerText,
            modalSalle = $('#salleModal'),
            titleModalSalle = modalSalle[0].children[0].children[0].children[0].children[1],
            formModalSalle = modalSalle[0].children[0].children[0].children[1].children[0];
        evt.preventDefault();

        titleModalSalle.innerText = "Modifier une salle";

        $.each(formModalSalle, function (key, value) {
            if ($(value).attr('id') == 'titreInput') {
                $(value).val(titreSalle)
            } else if ($(value).attr('id') == 'descriptionTextarea') {
                $(value).val(descriptionSalle)
            } else if ($(value).attr('id') == 'capaciteSelect') {
                $('option[value="' + (parseInt(capaciteSalle) - 1) + '"]', value).prop('selected', true);
            } else if ($(value).attr('id') == 'categorieSelect') {
                if (categorieSalle == 'Réunion') {
                    $('option[value="0"]', value).prop('selected', true);
                } else if (categorieSalle == 'Bureau') {
                    $('option[value="1"]', value).prop('selected', true);
                } else if (categorieSalle == 'Formation') {
                    $('option[value="2"]', value).prop('selected', true);
                }
            } else if ($(value).attr('id') == 'paysSelect') {
                $('option[value="0"]', value).prop('selected', true);
            } else if ($(value).attr('id') == 'villeSelect') {
                if (villeSalle == 'Paris') {
                    $('option[value="0"]', value).prop('selected', true);
                } else if (villeSalle == 'Lyon') {
                    $('option[value="1"]', value).prop('selected', true);
                } else if (villeSalle == 'Marseille') {
                    $('option[value="2"]', value).prop('selected', true);
                }
            } else if ($(value).attr('id') == 'adresseTextarea') {
                $(value).val(adresseSalle)
            } else if ($(value).attr('id') == 'cpInput') {
                $(value).val(cpSalle)
            } else if ($(value).is("button")) {
                $(value)[0].innerText = 'Modifier'
            }
        });
        formModalSalle.dataset.type = 'update';
        formModalSalle.dataset.id = idSalle;
        modalSalle.modal('show');
    });
    // Soumission du formulaire pour la salle
    $(document).on('submit', '#salleForm', function(evt){
        var formElement = $('#salleForm input, #salleForm select, #salleForm textarea, #salleForm button'),
            loader = $('button .loader'),
            modalSalle = $('#salleModal'),
            formModalSalle = modalSalle[0].children[0].children[0].children[1].children[0];
        evt.preventDefault();

        var formData = new FormData($(this)[0]);

        form.removeErrors('#salleForm .has-error', true, 'has-error');
        form.removeErrors('#salleForm .help-block');
        form.disableForm(formElement, loader);
        if (formModalSalle.dataset.type == 'update') {
            post('admin.sallesUpdatePost', formData, 'json', 'key:5s3df4.idSalle:' + formModalSalle.dataset.id);
             if (resultPost[0] === 'success') {
                 notification.show(
                     'Success !', 'Modification réussie !', 'success',
                     {from:'top', align:'right'}, {enter:'fadeInDown', exit:'fadeOutUp'}
                 );
             }
        } else {
            post('admin.sallesPost', formData, 'json', 'key:5s3df4');
            if (resultPost[0] === 'success') {
                notification.show(
                    'Success !', 'Ajout réussie !', 'success',
                    {from:'top', align:'right'}, {enter:'fadeInDown', exit:'fadeOutUp'}
                );
            }
        }

        if (resultPost[0] === 'success') {
            actualiseTabSalle(resultPost[1]);
            modalSalle.modal('hide');
        } else {
            form.showErrors(resultPost[1]);
        }
        form.enableForm(formElement, loader);
    });
    // Supprime une salle
    $(document).on('click', '.btnDeleteSalle', function(evt){
        evt.preventDefault();
        $('#salleDeleteModal').modal('show');
        $('#btnConfirmDelete')[0].dataset.id = this.dataset.id;
    });
    $(document).on('click', '#btnCancelDeleteSalle', function(evt){
        evt.preventDefault();
        $('#salleDeleteModal').modal('hide');
    });
    $(document).on('click', '#btnConfirmDeleteSalle', function(evt){
        evt.preventDefault();
        get('admin.salleDelete', {}, 'json', 'id:' + this.dataset.id);
        notification.show(
            'Success !', 'Suppression réussie !', 'success',
            {from:'top', align:'right'}, {enter:'fadeInDown', exit:'fadeOutUp'}
        );
        actualiseTabSalle(resultGet);
        $('#salleDeleteModal').modal('hide');
    });

    //=============================================================================================================
    //===============================================PRODUITS======================================================
    function actualiseTabProduit(listProduits) {
        var i,
            tabProduit = $('#tbodyProduit');
        tabProduit.html('');
        for (i = 0; i < listProduits.length; i++) {
            var row =
                '<tr>'
                + '<td style="vertical-align:middle" class="text-center">' + listProduits[i].id_produit + '</td>'
                + '<td style="vertical-align:middle" class="text-center">' + formatDatetime(listProduits[i].date_arrivee, false) + '</td>'
                + '<td style="vertical-align:middle" class="text-center">' + formatDatetime(listProduits[i].date_depart, false) + '</td>'
                + '<td style="vertical-align:middle" class="text-center">' + listProduits[i].id_salle + ' - ' + listProduits[i].titre + '<br><img src="../web/uploads/' + listProduits[i].photo + '" '
                + 'class="img-responsive center-block imgSalleAdmin" alt="Salle de ' + listProduits[i].categorie + '"></td>'
                + '<td style="vertical-align:middle" class="text-center">' + listProduits[i].prix + '</td>'
                + '<td style="vertical-align:middle" class="text-center">' + listProduits[i].etat + '</td>'
                + '<td style="vertical-align:middle" class="text-center">'
                    + '<div class="btn-group btn-group-xs" role="group" aria-label="...">'
                        + '<a href="#" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></a>'
                        + '<a href="#" class="btnUpdateProduit btn btn-primary" data-id="' + listProduits[i].id_produit + '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'
                        + '<a href="#" class="btnDeleteProduit btn btn-danger" data-id="' + listProduits[i].id_produit + '"><i class="fa fa-trash" aria-hidden="true"></i></a>'
                    + '</div>'
                + '</td>'
                + '</tr>';
            tabProduit.append(row);
        }
    }
    // Re-init la modal
    $('#produitModal').on('hidden.bs.modal', function () {
        var modalSalle = $('#produitModal'),
            titleModalSalle = modalSalle[0].children[0].children[0].children[0].children[1],
            formModalSalle = modalSalle[0].children[0].children[0].children[1].children[0];

        $.each(formModalSalle, function (key, value) {
            if ($(value).attr('id') == 'dateArriveeInput') {
                $(value).val('')
            } else if ($(value).attr('id') == 'dateDepartInput') {
                $(value).val('')
            } else if ($(value).attr('id') == 'salleSelect') {
                $('option:first-child', value).prop('selected', true);
            } else if ($(value).attr('id') == 'tarifInput') {
                $(value).val('')
            } else if ($(value).is("button")) {
                $(value)[0].innerText = ''
            }
        });
        formModalSalle.dataset.type = '';
        formModalSalle.dataset.id = '';
        titleModalSalle.innerText = "";

        form.removeErrors('#produitForm .has-error', true, 'has-error');
        form.removeErrors('#produitForm .help-block');
    });
    // Bouton d'ouverture de la modal pour ajouter un produit
    $('#btnAddProduit').click(function (evt) {
        var modalProduit = $('#produitModal'),
            titleModalProduit = modalProduit[0].children[0].children[0].children[0].children[1],
            formModalProduit = modalProduit[0].children[0].children[0].children[1].children[0];
        evt.preventDefault();

        titleModalProduit.innerText = "Ajouter un produit";

        $.each(formModalProduit, function (key, value) {
            if ($(value).is("button")) {
                $(value)[0].innerText = 'Ajouter'
            }
        });
        formModalProduit.dataset.type = 'add';

        modalProduit.modal('show');
    });

    // Bouton d'ouverture de la modal pour modifier un produit
    $(document).on('click', '.btnUpdateProduit', function(evt){
        var row = $(this)[0].parentNode.parentNode.parentNode,
            idProduit = row.children[0].innerText,
            dateArriveeProduit = row.children[1].innerText,
            dateDepartProduit = row.children[2].innerText,
            idSalle = row.children[3].dataset.id,
            prixProduit = row.children[4].innerText,
            modalSalle = $('#produitModal'),
            titleModalSalle = modalSalle[0].children[0].children[0].children[0].children[1],
            formModalSalle = modalSalle[0].children[0].children[0].children[1].children[0];
        evt.preventDefault();

        titleModalSalle.innerText = "Modifier un produit";

        $.each(formModalSalle, function (key, value) {
            if ($(value).attr('id') == 'dateArriveeInput') {
                $(value).val(dateArriveeProduit)
            } else if ($(value).attr('id') == 'dateDepartInput') {
                $(value).val(dateDepartProduit)
            } else if ($(value).attr('id') == 'salleSelect') {
                $('option[value="' + (parseInt(idSalle)) + '"]', value).prop('selected', true);
            } else if ($(value).attr('id') == 'tarifInput') {
                $(value).val(prixProduit)
            } else if ($(value).is("button")) {
                $(value)[0].innerText = 'Modifier'
            }
        });
        formModalSalle.dataset.type = 'update';
        formModalSalle.dataset.id = idProduit;
        modalSalle.modal('show');
    });
    // Soumission du formulaire pour le produit
    $(document).on('submit', '#produitForm', function(evt){
        var formElement = $('#produitForm input, #produitForm select, #produitForm textarea, #produitForm button'),
            loader = $('button .loader'),
            modalProduit = $('#produitModal'),
            formModalProduit = modalProduit[0].children[0].children[0].children[1].children[0];
        evt.preventDefault();

        var formData = new FormData($(this)[0]);

        form.removeErrors('#produitForm .has-error', true, 'has-error');
        form.removeErrors('#produitForm .help-block');
        form.disableForm(formElement, loader);
        if (formModalProduit.dataset.type == 'update') {
            post('admin.produitUpdatePost', formData, 'json', 'key:5s3df4.idProduit:' + formModalProduit.dataset.id);
            if (resultPost[0] === 'success') {
                notification.show(
                    'Success !', 'Modification réussie !', 'success',
                    {from:'top', align:'right'}, {enter:'fadeInDown', exit:'fadeOutUp'}
                );
            }
        } else {
            post('admin.produitsPost', formData, 'json', 'key:5s3df4');
            if (resultPost[0] === 'success') {
                form.enableForm(formElement, loader);
                notification.show(
                    'Success !', 'Ajout réussie !', 'success',
                    {from:'top', align:'right'}, {enter:'fadeInDown', exit:'fadeOutUp'}
                );
            }
        }

        if (resultPost[0] === 'success') {
            actualiseTabProduit(resultPost[1]);
            modalProduit.modal('hide');
        } else {
            form.showErrors(resultPost[1]);
        }
        form.enableForm(formElement, loader);
    });
    // Supprime une salle
    $(document).on('click', '.btnDeleteProduit', function(evt){
        evt.preventDefault();
        $('#produitDeleteModal').modal('show');
        $('#btnConfirmDeleteProduit')[0].dataset.id = this.dataset.id;
    });
    $(document).on('click', '#btnCancelDeleteProduit', function(evt){
        evt.preventDefault();
        $('#produitDeleteModal').modal('hide');
    });
    $(document).on('click', '#btnConfirmDeleteProduit', function(evt){
        evt.preventDefault();
        get('admin.produitDelete', {}, 'json', 'id:' + this.dataset.id);
        notification.show(
            'Success !', 'Suppression réussie !', 'success',
            {from:'top', align:'right'}, {enter:'fadeInDown', exit:'fadeOutUp'}
        );
        actualiseTabProduit(resultGet);
        $('#produitDeleteModal').modal('hide');
    });

    //=============================================================================================================
    //===============================================MEMBRES=======================================================
    function actualiseTabMembre(listMembres) {
        var i,
            tabMembres = $('#tbodyMembres');
        tabMembres.html('');
        for (i = 0; i < listMembres.length; i++) {
            var row, civilite, statut;
            if (listMembres[i].civilite == 'm'){
                civilite = 'Homme';
            } else {
                civilite = 'Femme';
            }
            if (listMembres[i].statut == '0'){
                statut = 'Membre';
            } else {
                statut = 'Admin';
            }
            row =
                '<tr>'
                + '<td style="vertical-align:middle" class="text-center">' + listMembres[i].id_membre + '</td>'
                + '<td style="vertical-align:middle" class="text-center">' + listMembres[i].pseudo + '</td>'
                + '<td style="vertical-align:middle" class="text-center">' + listMembres[i].nom + '</td>'
                + '<td style="vertical-align:middle" class="text-center">' + listMembres[i].prenom + '</td>'
                + '<td style="vertical-align:middle" class="text-center">' + listMembres[i].email + '</td>'
                + '<td style="vertical-align:middle" class="text-center">' + civilite + '</td>'
                + '<td style="vertical-align:middle" class="text-center">' + statut + '</td>'
                + '<td style="vertical-align:middle" class="text-center">' + formatDatetime(listMembres[i].date_enregistrement, true) + '</td>'
                + '<td style="vertical-align:middle" class="text-center">'
                    + '<div class="btn-group btn-group-xs" role="group" aria-label="...">'
                        + '<a href="#" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></a>'
                        + '<a href="#" class="btnUpdateMembre btn btn-primary" data-id="' + listMembres[i].id_membre + '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'
                        + '<a href="#" class="btnDeleteMembre btn btn-danger" data-id="' + listMembres[i].id_membre + '"><i class="fa fa-trash" aria-hidden="true"></i></a>'
                    + '</div>'
                + '</td>'
                + '</tr>'
            ;
            tabMembres.append(row);
        }
    }
    // Re-init la modal
    $('#membreModal').on('hidden.bs.modal', function () {
        var modalMembre = $('#membreModal'),
            titleModalMembre = modalMembre[0].children[0].children[0].children[0].children[1],
            formModalMembre = modalMembre[0].children[0].children[0].children[1].children[0];

        $.each(formModalMembre, function (key, value) {
            if ($(value).attr('id') == 'pseudoInput') {
                $(value).val('')
            } else if ($(value).attr('id') == 'nomInput') {
                $(value).val('')
            } else if ($(value).attr('id') == 'prenomInput') {
                $(value).val('')
            } else if ($(value).attr('id') == 'emailInput') {
                $(value).val('')
            } else if ($(value).attr('id') == 'civiliteSelect') {
                $('option[value="0"]', value).prop('selected', true);
            } else if ($(value).attr('id') == 'statutSelect') {
                $('option[value="0"]', value).prop('selected', true);
            } else if ($(value).is("button")) {
                $(value)[0].innerText = ''
            }
        });
        formModalMembre.dataset.type = '';
        formModalMembre.dataset.id = '';
        titleModalMembre.innerText = "";

        form.removeErrors('#membreForm .has-error', true, 'has-error');
        form.removeErrors('#membreForm .help-block');
    });
    // Bouton d'ouverture de la modal pour ajouter un membre
    $('#btnAddMembre').click(function (evt) {
        var modalMembre = $('#membreModal'),
            titleModalMembre = modalMembre[0].children[0].children[0].children[0].children[1],
            formModalMembre = modalMembre[0].children[0].children[0].children[1].children[0];
        evt.preventDefault();

        titleModalMembre.innerText = "Ajouter un membre";

        $.each(formModalMembre, function (key, value) {
            if ($(value).is("button")) {
                $(value)[0].innerText = 'Ajouter'
            }
        });
        formModalMembre.dataset.type = 'add';

        modalMembre.modal('show');
    });

    // Bouton d'ouverture de la modal pour modifier un membre
    $(document).on('click', '.btnUpdateMembre', function(evt){
        var row = $(this)[0].parentNode.parentNode.parentNode,
            idMembre = row.children[0].innerText,
            pseudoMembre = row.children[1].innerText,
            nomMembre = row.children[2].innerText,
            prenomMembre = row.children[3].innerText,
            emailMembre = row.children[4].innerText,
            civiliteMembre = row.children[5].innerText,
            statutMembre = row.children[6].innerText,
            modalMembre = $('#membreModal'),
            titleModalMembre = modalMembre[0].children[0].children[0].children[0].children[1],
            formModalMembre = modalMembre[0].children[0].children[0].children[1].children[0];
        evt.preventDefault();

        titleModalMembre.innerText = "Modifier un membre";

        $.each(formModalMembre, function (key, value) {
            if ($(value).attr('id') == 'pseudoInput') {
                $(value).val(pseudoMembre)
            } else if ($(value).attr('id') == 'nomInput') {
                $(value).val(nomMembre)
            } else if ($(value).attr('id') == 'prenomInput') {
                $(value).val(prenomMembre)
            } else if ($(value).attr('id') == 'emailInput') {
                $(value).val(emailMembre)
            } else if ($(value).attr('id') == 'civiliteSelect') {
                if (civiliteMembre == 'Homme') {
                    $('option[value="0"]', value).prop('selected', true);
                } else {
                    $('option[value="1"]', value).prop('selected', true);
                }
            } else if ($(value).attr('id') == 'statutSelect') {
                if (statutMembre == 'Membre') {
                    $('option[value="0"]', value).prop('selected', true);
                } else {
                    $('option[value="1"]', value).prop('selected', true);
                }
            } else if ($(value).is("button")) {
                $(value)[0].innerText = 'Modifier'
            }
        });
        formModalMembre.dataset.type = 'update';
        formModalMembre.dataset.id = idMembre;
        modalMembre.modal('show');
    });
    // Soumission du formulaire pour le membre
    $(document).on('submit', '#membreForm', function(evt){
        var formElement = $('#membreForm input, #membreForm select, #membreForm textarea, #membreForm button'),
            loader = $('button .loader'),
            modalMembre = $('#membreModal'),
            formModalMembre = modalMembre[0].children[0].children[0].children[1].children[0];
        evt.preventDefault();

        var formData = new FormData($(this)[0]);

        form.removeErrors('#membreForm .has-error', true, 'has-error');
        form.removeErrors('#membreForm .help-block');
        form.disableForm(formElement, loader);
        if (formModalMembre.dataset.type == 'update') {
            post('admin.membreUpdatePost', formData, 'json', 'key:5s3df4.idMembre:' + formModalMembre.dataset.id);
            if (resultPost[0] === 'success') {
                notification.show(
                    'Success !', 'Modification réussie !', 'success',
                    {from:'top', align:'right'}, {enter:'fadeInDown', exit:'fadeOutUp'}
                );
            }
        } else {
            post('admin.membresPost', formData, 'json', 'key:5s3df4');
            if (resultPost[0] === 'success') {
                form.enableForm(formElement, loader);
                notification.show(
                    'Success !', 'Ajout réussie !', 'success',
                    {from:'top', align:'right'}, {enter:'fadeInDown', exit:'fadeOutUp'}
                );
            }
        }

        if (resultPost[0] === 'success') {
            actualiseTabMembre(resultPost[1]);
            modalMembre.modal('hide');
        } else {
            var listErrors = {};
            $.each(resultPost[1], function (index, value) {
                listErrors[index] = [value];
            });
            form.showErrors(listErrors);
        }
        form.enableForm(formElement, loader);
    });
    // Supprime un membre
    $(document).on('click', '.btnDeleteMembre', function(evt){
        evt.preventDefault();
        $('#membreDeleteModal').modal('show');
        $('#btnConfirmDeleteMembre')[0].dataset.id = this.dataset.id;
    });
    $(document).on('click', '#btnCancelDeleteMembre', function(evt){
        evt.preventDefault();
        $('#membreDeleteModal').modal('hide');
    });
    $(document).on('click', '#btnConfirmDeleteMembre', function(evt){
        evt.preventDefault();
        get('admin.membreDelete', {}, 'json', 'id:' + this.dataset.id);
        notification.show(
            'Success !', 'Suppression réussie !', 'success',
            {from:'top', align:'right'}, {enter:'fadeInDown', exit:'fadeOutUp'}
        );
        actualiseTabMembre(resultGet);
        $('#membreDeleteModal').modal('hide');
    });

    //=============================================================================================================
    //===============================================AVIS==========================================================
    function actualiseTabAvis(listAvis) {
        var i,
            tabAvis = $('#tbodyAvis');
        tabAvis.html('');
        for (i = 0; i < listAvis.length; i++) {
            var row;
            row =
                '<tr>'
                + '<td style="vertical-align:middle" class="text-center">' + listAvis[i].id_avis + '</td>'
                + '<td style="vertical-align:middle" class="text-center" data-id="' + listAvis[i].id_membre + '">' + listAvis[i].id_membre + ' - ' + listAvis[i].email + '</td>'
                + '<td style="vertical-align:middle" class="text-center" data-id="' + listAvis[i].id_salle + '">' + listAvis[i].id_salle + ' - ' + listAvis[i].titre + '</td>'
                + '<td style="vertical-align:middle" class="text-center">' + listAvis[i].commentaire + '</td>'
                + '<td style="vertical-align:middle" class="text-center">' + listAvis[i].note + '</td>'
                + '<td style="vertical-align:middle" class="text-center">' + formatDatetime(listAvis[i].avis_date, false) + '</td>'
                + '<td style="vertical-align:middle" class="text-center">'
                    + '<div class="btn-group btn-group-xs" role="group" aria-label="...">'
                        + '<a href="#" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></a>'
                        + '<a href="#" class="btnUpdateAvis btn btn-primary" data-id="' + listAvis[i].id_avis + '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'
                        + '<a href="#" class="btnDeleteAvis btn btn-danger" data-id="' + listAvis[i].id_avis + '"><i class="fa fa-trash" aria-hidden="true"></i></a>'
                    + '</div>'
                + '</td>'
                + '</tr>'
            ;
            tabAvis.append(row);
        }
    }
    // Bouton d'ouverture de la modal pour modifier un avis
    $(document).on('click', '.btnUpdateAvis', function(evt){
        var row = $(this)[0].parentNode.parentNode.parentNode,
            idAvis = row.children[0].innerText,
            commAvis = row.children[3].innerText,
            moyenneAvis = row.children[4].innerText,
            modalAvis = $('#avisModal'),
            titleModalAvis = modalAvis[0].children[0].children[0].children[0].children[1],
            formModalAvis = modalAvis[0].children[0].children[0].children[1].children[0];
        evt.preventDefault();

        titleModalAvis.innerText = "Modifier un avis";

        $.each(formModalAvis, function (key, value) {
            if ($(value).attr('id') == 'commentaireTextarea') {
                $(value).val(commAvis);
            } else if ($(value).attr('id') == 'noteSelect') {
                $('option[value="' + moyenneAvis + '"]', value).prop('selected', true);
            } else if ($(value).is("button")) {
                $(value)[0].innerText = 'Modifier';
            }
        });
        formModalAvis.dataset.type = 'update';
        formModalAvis.dataset.id = idAvis;
        modalAvis.modal('show');
    });
    // Soumission du formulaire pour l'avis
    $(document).on('submit', '#avisForm', function(evt){
        var formElement = $('#avisForm input, #avisForm select, #avisForm textarea, #avisForm button'),
            loader = $('button .loader'),
            modalAvis = $('#avisModal'),
            formModalAvis = modalAvis[0].children[0].children[0].children[1].children[0];
        evt.preventDefault();

        var formData = new FormData($(this)[0]);

        form.removeErrors('#avisForm .has-error', true, 'has-error');
        form.removeErrors('#avisForm .help-block');
        form.disableForm(formElement, loader);
        if (formModalAvis.dataset.type == 'update') {
            post('admin.avisUpdatePost', formData, 'json', 'key:5s3df4.idAvis:' + formModalAvis.dataset.id);
            if (resultPost[0] === 'success') {
                notification.show(
                    'Success !', 'Modification réussie !', 'success',
                    {from:'top', align:'right'}, {enter:'fadeInDown', exit:'fadeOutUp'}
                );
            }
        } else {
            notification.show(
                'Erreur ', 'lors de la modification', 'danger',
                {from:'top', align:'right'}, {enter:'fadeInDown', exit:'fadeOutUp'}
            );
        }

        if (resultPost[0] === 'success') {
            actualiseTabAvis(resultPost[1]);
            modalAvis.modal('hide');
        } else {
            var listErrors = {};
            $.each(resultPost[1], function (index, value) {
                listErrors[index] = [value];
            });
            form.showErrors(listErrors);
        }
        form.enableForm(formElement, loader);
    });
    // Supprime un avis
    $(document).on('click', '.btnDeleteAvis', function(evt){
        evt.preventDefault();
        $('#avisDeleteModal').modal('show');
        $('#btnConfirmDeleteAvis')[0].dataset.id = this.dataset.id;
    });
    $(document).on('click', '#btnCancelDeleteAvis', function(evt){
        evt.preventDefault();
        $('#avisDeleteModal').modal('hide');
    });
    $(document).on('click', '#btnConfirmDeleteAvis', function(evt){
        evt.preventDefault();
        get('admin.avisDelete', {}, 'json', 'id:' + this.dataset.id);
        notification.show(
            'Success !', 'Suppression réussie !', 'success',
            {from:'top', align:'right'}, {enter:'fadeInDown', exit:'fadeOutUp'}
        );
        actualiseTabAvis(resultGet);
        $('#membreDeleteModal').modal('hide');
    });


    //=============================================================================================================
    //===============================================COMMANDES=====================================================
    function actualiseTabCommandes(listCommandes) {
        var i,
            tabCommandes = $('#tbodyCommandes');
        tabCommandes.html('');
        for (i = 0; i < listCommandes.length; i++) {
            var row;
            row =
                '<tr>'
                + '<td style="vertical-align:middle" class="text-center">' + listCommandes[i].id_commande + '</td>'
                + '<td style="vertical-align:middle" class="text-center">' + listCommandes[i].id_membre + ' - ' + listCommandes[i].email + '</td>'
                + '<td style="vertical-align:middle" class="text-center">' + listCommandes[i].id_produit + ' - ' + listCommandes[i].titre + '</td>'
                + '<td style="vertical-align:middle" class="text-center">' + listCommandes[i].date_arrivee + '</td>'
                + '<td style="vertical-align:middle" class="text-center">' + listCommandes[i].date_depart + '</td>'
                + '<td style="vertical-align:middle" class="text-center">' + listCommandes[i].prix + '</td>'
                + '<td style="vertical-align:middle" class="text-center">' + listCommandes[i].date_enregistrement + '</td>'
                + '<td style="vertical-align:middle" class="text-center">'
                    + '<div class="btn-group btn-group-xs" role="group" aria-label="...">'
                        + '<a href="#" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></a>'
                        + '<a href="#" class="btnDeleteCommande btn btn-danger" data-id="' + listCommandes[i].id_commande + '"><i class="fa fa-trash" aria-hidden="true"></i></a>'
                    + '</div>'
                + '</td>'
                + '</tr>'
            ;
            tabCommandes.append(row);
        }
    }
    // Supprime une commande
    $(document).on('click', '.btnDeleteCommande', function(evt){
        evt.preventDefault();
        $('#commandeDeleteModal').modal('show');
        $('#btnConfirmDeleteCommande')[0].dataset.id = this.dataset.id;
    });
    $(document).on('click', '#btnCancelDeleteCommande', function(evt){
        evt.preventDefault();
        $('#commandeDeleteModal').modal('hide');
    });
    $(document).on('click', '#btnConfirmDeleteCommande', function(evt){
        evt.preventDefault();
        get('admin.commandeDelete', {}, 'json', 'id:' + this.dataset.id);
        notification.show(
            'Success !', 'Suppression réussie !', 'success',
            {from:'top', align:'right'}, {enter:'fadeInDown', exit:'fadeOutUp'}
        );
        actualiseTabCommandes(resultGet);
        $('#membreDeleteModal').modal('hide');
    });
});