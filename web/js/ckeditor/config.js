CKEDITOR.editorConfig = function( config )
{
    config.language = 'ru';
    config.extraPlugins = 'syntaxhighlight';
    config.toolbar =     [

                            ['Bold','Italic','Underline','Strike'],
                            ['NumberedList','BulletedList'],
                            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
                            ['Link','Unlink','Anchor'],
                            ['Image','Table','HorizontalRule','Smiley','SpecialChar'],
                            '/',
                            ['Format','Font','FontSize'],
                            ['TextColor','BGColor'],
                            ['Maximize'],
                            '/',
                            ['Source','Templates'],
                            ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'], ['About']
                          ];

};
