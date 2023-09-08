define([
    'jquery',
    'uiCollection',
    'Magenable_Popup/js/popup-config'
], function ($, uiCollection, getPopupConfiguration) {
    'use strict';

    const popupConfig = getPopupConfiguration();

    return uiCollection.extend({
        defaults: {
            content: popupConfig.popupContent,
            cssClass: popupConfig.cssClass + '__content'
        },
        afterRenderContent: function (content) {
            $('#' + popupConfig.popupContentId).appendTo(content);
        }
    });
});
