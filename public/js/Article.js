/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 7);
/******/ })
/************************************************************************/
/******/ ({

/***/ 7:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(8);


/***/ }),

/***/ 8:
/***/ (function(module, exports) {


var articleBox = document.querySelector('.article-box');
var articleId = articleBox.id.slice(8);

function Article(id) {
    this.id = id;
}

Article.prototype.viewSource = function () {
    location.href = articleBox.dataset.source;
};

Article.prototype.increaseFontSize = function (e) {
    e.preventDefault();
    var articleBody = document.querySelector('.box-content');
    var currentFontSize = parseFloat(window.getComputedStyle(articleBody, null).getPropertyValue('font-size'));
    articleBody.style.fontSize = currentFontSize + 1 + 'px';
};

Article.prototype.decreaseFontSize = function (e) {
    e.preventDefault();
    var articleBody = document.querySelector('.box-content');
    var currentFontSize = parseFloat(window.getComputedStyle(articleBody, null).getPropertyValue('font-size'));
    articleBody.style.fontSize = currentFontSize - 1 + 'px';
};

Article.prototype.displaySaveForLaterNotif = function () {
    var notif = document.querySelector('.notif');
    var notifText = document.querySelector('.notif-text');
    notif.style.display = "block";
    notifText.innerHTML = Lang.notifSuccess;
};

Article.prototype.displayAlreadySavedNotif = function () {
    var notif = document.querySelector('.notif');
    var notifText = document.querySelector('.notif-text');
    notif.style.display = "block";
    notif.className += " notif-warning";
    notifText.innerHTML = Lang.notifFailed;
};

Article.prototype.notifClose = function () {
    var notif = document.querySelector('.notif');
    notif.style.display = "none";
    notif.className = "notif";
};

Article.prototype.saveForLater = function (e) {
    e.preventDefault();
    if (typeof Laravel.apiToken !== 'undefined') {
        fetch('/api/article/' + articleId + '/save-for-later', {
            method: 'POST',
            body: JSON.stringify({
                api_token: Laravel.apiToken
            }),
            headers: { "Content-Type": "application/json" }
        }).then(function (res) {
            return res.json();
        }).then(function (j) {
            if (j == "Already added") {
                Article.prototype.displayAlreadySavedNotif();
            } else if (j == "Added successfully") {
                Article.prototype.displaySaveForLaterNotif();
            }
        }).catch(function (err) {
            console.log(err);
        });
    }
};

var article = new Article(articleId);

var viewSourceLink = document.querySelector('#view-source-link');
var increaseFontSizeLink = document.querySelector('#increase-font-size-link');
var decreaseFontSizeLink = document.querySelector('#decrease-font-size-link');
var saveForLaterLink = document.querySelector('#save-for-later');
var notifClose = document.querySelector('#notif-close');

viewSourceLink.addEventListener('click', article.viewSource);
increaseFontSizeLink.addEventListener('click', article.increaseFontSize);
decreaseFontSizeLink.addEventListener('click', article.decreaseFontSize);
saveForLaterLink.addEventListener('click', article.saveForLater);
notifClose.addEventListener('click', Article.prototype.notifClose);

/***/ })

/******/ });