# Magenable Popup

**Magenable Popup** is a Magento 2 module that adds popup with selected CMS Block as content, also there is possibility to add newsletter subscription functional on popup window, Google ReCaptcha v2 and v3 is supported.

![](README/1.png)

## Installation

### Composer:

Run the following command in Magento 2 root folder

```
composer require magenable/module-popup
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento setup:static-content:deploy
```
## Upgrade

### Composer:

Run the following command in Magento 2 root folder

```
composer update magenable/module-popup
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento setup:static-content:deploy
```

## User Guide

### Configuration:

Go to **Stores** > **Settings** > **Configuration** > **Magenable Extensions** > **Popup**.

#### General

- `Enabled` - Enable or Disable the popup
- `Title` - Title of the popup
- `CMS Block` - You can select CMS Block for popup content
- `Button Text` - Newsletter subscription button text
- `Popup Delay` - You can specify number of seconds when popup should arise

#### Visibility

- `Visibility Type` - You can select show popup on all pages excluding specified pages or only show popup on specified pages
- `Pages` - You can specify urls of pages (without base url) for previous configuration

#### Newsletter Subscription

- `Add Newsletter Subscription Form` - You can add newsletter subscription form to the popup

#### Design

- `Max Width of Popup` - Max width of popup in pixels
- `Button Text Color` - Newsletter subscription button color
- `Button Background` - Newsletter subscription button background

![](README/2.png)
