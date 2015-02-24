$("#basket").click(
    function()
    {                
        $.ajax({
            type:'POST',
            async: true,
            cache: false,
            url: "rdfRequests/SessionSave/", 
            data: {data},
            success: function(response) {
               $("#showBasket").show();
                alert('Les triplets ont été ajoutés à la mémoire / Triples have been added to memory');
            } 
        });
        return false;
    }
);


$("#DeleteMemory").click(
    function()
    {     

        $.ajax({
            url: "rdfRequests/SessionDelete/", 
            success: function(response) {
               $("#showBasket").hide();
               alert('La mémoire a été vidée / Memory is empty');
            } 
        });
        return false;
    }
);
