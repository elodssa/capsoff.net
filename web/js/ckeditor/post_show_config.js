CKEDITOR.editorConfig = function( config )
{
    config.language = 'ru';
    config.extraPlugins = 'syntaxhighlight';
    config.toolbar =     [
                            ['Font','FontSize','Bold','Italic','Underline','Strike','TextColor','BGColor'],
                            ['NumberedList','BulletedList'],
                            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
                            ['Link','Unlink'],
                            ['Image','Smiley','SpecialChar'],
                            ['About']];

    config.resize_enabled = false;
};

