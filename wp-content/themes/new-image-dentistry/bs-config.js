const urlapi = require('url');
const siteUrl = 'http://ready-for-feedback3.com/lp-creative-co/new-image-dentistry/', // example `http://ready-for-feedback.com/client/project-name/`
	themeName = 'new-image-dentistry'; // example `project-name`
const URL = urlapi.parse(siteUrl);

module.exports = {
	"files": ["css/*.css","*.php", "parts/**/*.php", "templates/*.php", "js/global.js"],
	"proxy": siteUrl,
	"serveStatic": ["./"],

	rewriteRules: [
		{
			match: new RegExp( URL.path.substr(1) + "wp-content/themes/" + themeName + "/css" ),
			fn: function () {
				return "css"
			}
		},
		{
			match: new RegExp( URL.path.substr(1) + "wp-content/themes/" + themeName + "/css/custom.css" ),
			fn: function () {
				return "css/custom.css"
			}
		}
	],
};
