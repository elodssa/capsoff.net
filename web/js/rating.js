jQuery(document).ready(function() {

    $(".vote").click(function() {

       var href = $(this).attr("href");
       var vote_button = $(this);
       var rating_block = vote_button.parent();

       rating_block.find(".rating").hide();
       rating_block.find("#loader").show();
       $.getJSON(href,{},function(json){
           if (!json.result)
               {
                   $("#vote_notice").dialog({
                        autoOpen: false,
                        show: "drop",
                        hide: "drop",
                        draggable: false,
                        resizable: false
                    });

                    $("#vote_notice").html("Вы уже ставили оценку этому посту! Больше нельзя :)");

                    $("#vote_notice").dialog("open");
               }
           else
               {
                    rating_block.find(".rating").html(json.votes);
               }

       rating_block.find(".vote").first().replaceWith(rating_block.find(".vote").first().find("img").attr("src","/images/plus_inactive.png"));
       rating_block.find(".vote").last().replaceWith(rating_block.find(".vote").last().find("img").attr("src","/images/minus_inactive.png"));
       rating_block.find(".rating").show();
       rating_block.find("#loader").hide();
       });

       return false;
    });

});
