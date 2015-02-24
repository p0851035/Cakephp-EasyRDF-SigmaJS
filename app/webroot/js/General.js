$(document).ready(function() {
    $(document).on('change', '.showOther', function(data){

        var valeur = data.target.value;

        if(valeur == "Autre") {
            $(this).parent().parent().parent().parent().find('#autre').css("display", "block");
        }else{
            $(this).parent().parent().parent().parent().find('#autre').css("display", "none");
        }
    });

    $(document).on('click', '#clickme3', function(data){   
        
        $('#info').toggle();
    
    });

    $(document).on('click', '#clickme4', function(data){
        
        $('#info').toggle();
    });
});