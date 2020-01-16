$( ".removeBtn" ).click(function() {
   
    if ( confirm("Supprimer cet élément?")) {
        return true;
    } else {
        return false;
    }
});


$( ".relateEvent" ).click(function() {
   
    if ( $(this).is(':checked')) {
        $('.relateChangeBtn').html("Continuer")
    } else {
        $('.relateChangeBtn').html("Créer")
    }
});

