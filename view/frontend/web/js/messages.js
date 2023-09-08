define([
    'uiCollection',
    'ko'
], function (uiCollection, ko) {
    'use strict';

    return uiCollection.extend({
        defaults: {
            messages: ko.observableArray([])
        },
        addMessage: function (message, type) {
            this.messages.push({
                message: message,
                type: type
            });
        },
        clearMessages: function () {
            this.messages.removeAll();
        }
    });
});
