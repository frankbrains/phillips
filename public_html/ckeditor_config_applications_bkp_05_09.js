/*
Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
    config.width = "700";
    config.height = "250";
    config.resize_enabled = false;
    config.toolbar = 'MyToolbar';
    config.docType = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">';
    config.entities = false;
    config.ignoreEmptyParagraph = true;
    config.ShowBorders = true;
    //config.contentsCss = 'style_backend.css' ;
    config.stylesCombo_stylesSet = 'my_styles';
    config.enterMode = CKEDITOR.ENTER_BR;

config.toolbar_MyToolbar = 
      [ 
        ['Source','-'], 
        ['Cut','Copy','Paste','PasteText','PasteFromWord','-','SpellChecker', 'Scayt'], 
        ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],     
        '/', 
        ['Styles','Bold','Italic','Underline','Strike','-','Subscript','Superscript'], 
        ['NumberedList','BulletedList'], 
        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'], 
        ['Link','Unlink','Anchor'], 
        ['Image','Table','HorizontalRule','SpecialChar'], 
        ['Maximize', 'ShowBlocks'] 
    ]; 
};