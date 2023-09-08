/* global grecaptcha */
define([
    'jquery',
    'uiCollection',
    'Magenable_Popup/js/popup-config',
    'Magenable_Popup/js/messages',
    'mage/storage',
    'Magento_ReCaptchaFrontendUi/js/registry',
    'mage/validation',
    'mage/cookies'
], function ($, uiCollection, getPopupConfiguration, messages, storage, recaptchaRegistry) {
    'use strict';

    const popupConfig = getPopupConfiguration();

    return uiCollection.extend({
        defaults: {
            isNewsletterEnabled: popupConfig.isNewsletterEnabled,
            cssClass: popupConfig.cssClass + '__form',
            cssClassActions: popupConfig.cssClass + '__actions',
            cssClassAdditional: popupConfig.cssClass + '__additional',
            actionUrl: popupConfig.formActionUrl,
            buttonText: popupConfig.buttonText,
            buttonTextColor: popupConfig.buttonTextColor,
            buttonBackground: popupConfig.buttonBackground,
            messages: messages(),
            $form: null,
            recaptchaWidgetId: null
        },
        afterRenderForm: function (form) {
            this.$form = $(form);
        },
        afterRenderAdditionalData: function (additionalData) {
            $('#' + popupConfig.formAdditionalInfoId).appendTo(additionalData);
        },
        handleSubmit: function () {
            this.messages.clearMessages();
            if (!this.$form.validation('isValid')) {
                this.resetReCaptcha();
                return false;
            }
            this.loaderShow();

            storage.post(
                this.$form.attr('action'),
                this.$form.serialize(),
                true,
                'application/x-www-form-urlencoded'
            ).done(result => {
                if (result.error) {
                    result.error.forEach(message => {
                        this.messages.addMessage(message, 'error');
                    });
                }
                if (result.success) {
                    result.success.forEach(message => {
                        this.messages.addMessage(message, 'success');
                    });

                    this.$form.find('[name="email"]').val('');
                }

                this.loaderHide();
                this.resetReCaptcha();
            });

            return false;
        },
        resetReCaptcha: function () {
            if (!this.recaptchaWidgetId) {
                const recaptchaId = this.$form.find('.g-recaptcha').attr('id');

                recaptchaRegistry.ids().forEach((e, i) => {
                    if (recaptchaId === e) {
                        this.recaptchaWidgetId = i;
                    }
                });
            }

            if (this.recaptchaWidgetId && window.grecaptcha) {
                grecaptcha.reset(this.recaptchaWidgetId);
                this.$form.find('[name="g-recaptcha-response"], [name="token"]').val('');
                this.$form.find('.required-captcha.checkbox').prop('checked', false);
            }
        },
        getFormKey: function () {
            return $.mage.cookies.get('form_key');
        },
        loaderShow: function () {
            $('body').loader('show');
        },
        loaderHide: function () {
            $('body').loader('hide');
        }
    });
});
