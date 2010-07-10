jQuery(document).ready(function(){
    var has_form = false;
    var editor;

    function createEditor()
    {
      if ( editor ) return;
      editor = CKEDITOR.replace("answer_text",{ customConfig : '/js/ckeditor/post_show_config.js'});
    }

    function removeEditor()
    {
      if ( !editor ) return;

      editor.destroy();
      editor = null;
    }
    
    $("#comment_post").click(function(){
        if (!has_form)
            {
                var comment_button = $(this);
                $("#post_commenting img").attr("src","/images/loader.gif");
                $.get(comment_button.attr('href'),{},function(data){
                    $("#post_commenting img").attr("src","/images/comment.png");
                    $(data).insertAfter(".post_preview");
                    comment_button.html("Заркыть форму");
                    has_form = true;
                    createEditor();
                });
            }
        else
            {
                $("#comment_post").html("Комментировать");
                $(".comment_answer").html("Ответить");
                removeEditor();
                $("#form").remove();
                has_form = false;
            }

        return false;
    });

    $(".comment_answer").click(function(){
        if (!has_form)
            {
                var comment_button = $(this);
                comment_button.prepend("<img src='/images/loader.gif'>");
                $.get(comment_button.attr('href'),{},function(data){
                    comment_button.find("img").remove();
                    $(data).insertAfter(comment_button.parents(".comment_container"));
                    comment_button.html("Заркыть форму");
                    has_form = true;
                    createEditor();
                });
            }
        else
            {
                $("#comment_post").html("Комментировать");
                $(".comment_answer").html("Ответить");
                removeEditor();
                $("#form").remove();
                has_form = false;
            }

        return false;
    });
});
