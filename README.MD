
## Build creation

**Before begin, your must install nodejs dependecies for grunt:**
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
