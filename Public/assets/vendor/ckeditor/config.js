/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';

    // The toolbar groups arrangement, optimized for two toolbar rows.
    config.toolbarGroups = [
        {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
        {name: 'clipboard', groups: ['undo', 'clipboard']},
        {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
        {name: 'forms', groups: ['forms']},
        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']},
        {name: 'links', groups: ['links']},
        {name: 'insert', groups: ['insert']},
        {name: 'colors', groups: ['colors']},
        {name: 'styles', groups: ['styles']},
        { name: 'tools', groups: [ 'tools' ] },
        {name: 'document', groups: [ 'mode', 'document', 'doctools' ]}
    ];

    config.removeButtons = 'CopyFormatting,RemoveFormat,Subscript,Superscript,Strike,Templates,NewPage,Preview,Print,Paste,PasteText,PasteFromWord,Replace,SelectAll,Scayt,Form,Checkbox,Radio,HiddenField,ImageButton,Button,Select,Textarea,TextField,BidiLtr,BidiRtl,Language,CreateDiv,Unlink,Flash,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,About,ShowBlocks,Save';

    // remove plugin 
    config.removePlugins = 'elementspath';

    //activate plugin

    config.extraPlugins = 'image2';
    
    config.pasteFromWordRemoveFontStyles = true;
    
    config.allowedContent = false;
    
    config.fillEmptyBlocks = false;

    config.tabSpaces = 0;
    
    config.basicEntities = false;
    config.htmlEncodeOutput = true;
    config.entities_greek = false; 
    config.entities_latin = false; 
    config.entities_additional = '';


//    config.disallowedContent = 'img{style*}';


    // config.extraPlugins = 'notification';
    // config.extraPlugins = 'notificationaggregator';
    // config.extraPlugins = 'filetools';

    // config.extraPlugins = 'uploadwidget';
    // config.extraPlugins = 'uploadimage';

};
