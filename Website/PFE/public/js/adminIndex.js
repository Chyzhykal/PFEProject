$( document ).ready(function() {
    $( ".adminButton2" ).hover(
        function() {
          $( this, "a").attr("style",  "text-decoration: none;transition-duration: 0.2s;padding-left: 70px;");
        },
        function() {
            $( this, "a").removeAttr("style");
        }
      );
    $( ".adminButton1" ).hover(
    function() {
        $( this, "a").attr("style",  "text-decoration: none;transition-duration: 0.2s;padding-left: 70px;");
    },
    function() {
        $( this, "a").removeAttr("style");
    }
    );
    
    $( "li" ).click(
        function() {
            $(this).children()[0].click();
    });
});
