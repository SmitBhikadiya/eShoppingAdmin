$(document).ready(function(){
    // get countries when country select change
    $(document).on("change", "#countrylist", function(){
        var id = $(this).val();
        $.ajax({
            type: "POST",
            dataType: "json",
            data: {countryid: id},
            url: './handler/requestHandler.php', 
            success: function(res){
                let options = '';
                res.states.forEach(state => {
                    options+=`
                        <option value='${state["id"]}'>${state["state"]}</option>
                    `;
                });
                $("#statelist").html(options);
            }
        });
    });
});