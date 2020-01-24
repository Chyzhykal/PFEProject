/**
 * ETML
 * Author : Chyzhyk Aleh
 * Date : 16.01.2020
 * Description : scripts file for agenda templates
 */

 //Used for delete confirmation
$( ".removeBtn" ).click(function() {
    if ( confirm("Supprimer cet élément?")) {
        return true;
    } else {
        return false;
    }
});

//Used for button text changement if event is related, not used anymore but leaving it just in case
$( ".relateEvent" ).click(function() {
   
    if ( $(this).is(':checked')) {
        $('.relateChangeBtn').html("Continuer")
    } else {
        $('.relateChangeBtn').html("Créer")
    }
});

