define(function () {
    'use strict';

    let popupConfiguration;

    return function (config) {
        if (config) {
            popupConfiguration = config;
        }

        return popupConfiguration;
    };
});
