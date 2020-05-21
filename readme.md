# WP Boilerplate Plugin

Boilerplate plugin to for WordPress

## Getting started

### Minimum requirements and dependencies

WP Boilerplate Plugin requires:

* PHP 7+
* WordPress - latest
* Composer to be installed
* npm to be installed

### Installation

Fork the repo and activate it from plugins page in dashboard OR download as zip and install from plugins page in dashboard.

### Development

You'll need to create autoload files for php classes and install the npm packages. Go to plugin directory and run the following commands in the terminal:
```
composer install && npm install
```

### Javascript Files

There are 2 files used as sources: `assets/js/backend.js` and `assets/js/frontend.js`. You can either write js code in these files or requires files as follows: `require('./scripts/backend-scripts.js');` Babel core package is used to convert es6+ js code to be compatible with IE10. If you need to target a lower version, feel free to change it in the `webpack.config.js` file.

### SCSS Files

`mini-css-extract-plugin` is used to extract CSS code from js files to separate CSS files when `npm run prod` is executed. When `dev` and `watch` commands are executed, the SCSS code will be converted to CSS and injected directly in the page.

### Building JS and CSS files

To watch for live changes and build JS and CSS files in real time, run the following command in terminal:
```
npm run watch
```

To build the JS and CSS files once for development purpose, run the following command:
```
npm run dev
```

### Production

To build minified JS and CSS files run the following command in terminal:
```
npm run prod
```

## Translations

Replace all the `wp-boilerplate-plugin-text-domain` text domain with the one to match your plugin text domain.

Open the languages/wp-boilerplate-plugin.pot file in the Poedit app. Go to Catalogue -> Properties and change the Project name and version. Go to Catalogue -> Update from sources and then click on Save as .po file. Open the .po file and edit the translations to the needed language. Save as .mo file. For example, if you're translating to french, you'll have `languages/wp-boilerplate-plugin-fr_FR.po` and `languages/wp-boilerplate-plugin-fr_FR.mo`

## Changelog

### 1.0.0
* Initial release

---

## License
WP Boilerplate Plugin code is licensed under MIT license. Free to used for personal and commercial use.
