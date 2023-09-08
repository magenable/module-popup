define([
    'jquery',
    'uiCollection',
    'Magenable_Popup/js/popup-config',
    'Magento_Ui/js/modal/modal',
    'mage/cookies'
], function ($, uiCollection, getPopupConfiguration) {
    'use strict';

    const popupConfig = getPopupConfiguration();

    return uiCollection.extend({
        defaults: {
            cookieName: 'magenable-popup-closed',
            $popup: null,
            recaptchaWidgetId: null
        },
        initialize: function () {
            const result = this._super();

            if ($.mage.cookies.get(this.cookieName)) {
                return result;
            }

            this.$popup = $('.' + popupConfig.cssClass);
            this.initModal();

            return result;
        },
        afterRenderPopup: function () {
            const magenablePopupInnerWrap = document.querySelector(
                '.' + popupConfig.modalCssClass +  ' .modal-inner-wrap'
            );

            if (magenablePopupInnerWrap) {
                magenablePopupInnerWrap.style.maxWidth = popupConfig.popupMaxWidth + 'px';
            }
        },
        initModal: function () {
            this.$popup.modal({
                type: 'popup',
                responsive: true,
                innerScroll: false,
                title: popupConfig.title,
                modalClass: popupConfig.modalCssClass,
                buttons: [],
                opened: () => {
                    this.$popup.css('display', 'initial');
                },
                closed: () => {
                    const cookieDate = new Date;

                    cookieDate.setFullYear(cookieDate.getFullYear() + 1);
                    $.mage.cookies.set(
                        this.cookieName,
                        '1',
                        {
                            expires: cookieDate
                        }
                    );
                }
            });

            setTimeout(() => {
                this.showPopup();
            }, popupConfig.delay * 1000);
        },
        showPopup: function () {
            this.$popup.modal('openModal');
        },
        closePopup: function () {
            this.$popup.modal('closeModal');
        }
    });
});
