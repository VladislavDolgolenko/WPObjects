
## Introduction

**Use case and example plugin will be done in the nearest future.**

## Plugins built on the WPObjects

[MSP - MultiSport & eSport WordPress plugin with 90 Visual Composer addons](https://codecanyon.net/item/msp-multisport-esport-wordpress-plugin-with-90-visual-composer-addons/20954667)

[WordPress Demo Content Manager](https://codecanyon.net/item/wordpress-demo-content-manager/20669604)

[WordPress Layouts Builder](https://codecanyon.net/item/wordpress-layouts-builder/20968348)

## Compatibility

**WordPress 5.0-alpha-42201**

**PHP v5.3 - v7.1.15**

## Build creation

**Before begin, your must install nodejs dependencies for grunt:**
```
$ npm install
```


**Create build:**
```
$ grunt --namespace=PLUGIN_NAMESPACE
```
Build will be in derectory ./build


**Create build to plugin vendor directory:**
```
$ grunt --namespace=PLUGIN_NAMESPACE --dest=PLUGIN_FOLDER/includes/vendor/WPObjects
```
Build will be in directory PLUGIN_FOLDER/includes/vendor
