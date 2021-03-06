// // Modal
// reset les données contenu dans le modal
$('body').on('hidden.bs.modal', '.modal', function(){
    $(this).removeData('bs.modal');
});

// RECHERCHE DYNAMIQUE
$('#search').keyup(function () {
   var value = $('#search').val(); // on récupère la valeur de la recherche

   $.ajax({
        url: 'inc/searchDyn.php',
        type: 'POST',
        data: {search: value, type: type},
        dataType: 'json',
        success: function (data, statut) {
            console.log("Success");
            $('#liste').html('');
            // pour chaque data
            $.each(data, function(index, element) {
                console.log("INDEX : "+index+", ID : "+element.id+", IMG : "+element.img+", NOM : "+element.nom);
                if(type == 'films' || type == 'series')
                {
                    // on affiche le résultat sous forme de lien avec les bonnes infos
                    $('#liste').append('<a data-toggle="modal" data-target="#descModal" href="'+type+'_infos.php?id='+element.id+'" class="affiche"><img src="img/affiches/'+element.img+'" alt="'+element.nom+'" title="'+element.nom+'" /></a>');
                }
                else
                {
                    // on affiche le résultat sous forme de lien avec les bonnes infos
                    $('#liste').append('<a data-toggle="modal" data-target="#descModal" href="'+type+'_infos.php?id='+element.id+'" class="affiche"><img src="img/affiches/'+element.img+'" alt="'+element.nom+'" title="'+element.nom+'" /></a>');
                }
            });
        },
        error: function (data, statut) {
            console.log("Error");
        }
   });
});

var $deleteBtn = $('.delete-btn');
var $annuleBtn = $('.annule-btn');
var $footerToggleFirst = $('.footer-toggle-first');
var $footerToggleSecond = $('.footer-toggle-second');

$deleteBtn.on('click', function () {
    $footerToggleFirst.addClass('hide');
    $footerToggleSecond.removeClass('hide');
});

$annuleBtn.on('click', function () {
    $footerToggleSecond.addClass('hide');
    $footerToggleFirst.removeClass('hide');
});

$('.label-global[data-toggle="tooltip"]').tooltip();

$('#medias_annee_month').hide();
$('#medias_annee_day').hide();

    /*
    $('.js-datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });*/
