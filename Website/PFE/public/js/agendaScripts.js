$( ".removeBtn" ).click(function() {
   
    if ( confirm("Supprimer ce jour?")) {
        return true;
    } else {
        return false;
    }
});

