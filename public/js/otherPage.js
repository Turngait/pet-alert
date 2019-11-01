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
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
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
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/app_otherPage.ts");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/app_otherPage.ts":
/*!******************************!*\
  !*** ./src/app_otherPage.ts ***!
  \******************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _main_obj__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./main_obj */ \"./src/main_obj.ts\");\n/* harmony import */ var _descPageModules_getNodes__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./descPageModules/getNodes */ \"./src/descPageModules/getNodes.ts\");\n/* harmony import */ var _descPageModules_openSignIn__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./descPageModules/openSignIn */ \"./src/descPageModules/openSignIn.ts\");\n/* harmony import */ var _descPageModules_openSignUp__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./descPageModules/openSignUp */ \"./src/descPageModules/openSignUp.ts\");\n/* harmony import */ var _descPageModules_closeAuth__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./descPageModules/closeAuth */ \"./src/descPageModules/closeAuth.ts\");\n\r\n\r\n\r\n\r\n\r\nvar _a = _main_obj__WEBPACK_IMPORTED_MODULE_0__[\"pet_alert\"].nodes, signInBtn = _a.signInBtn, signOutBtn = _a.signOutBtn, authForm = _a.authForm, closeFormBtn = _a.closeFormBtn;\r\nvar _b = _main_obj__WEBPACK_IMPORTED_MODULE_0__[\"pet_alert\"].desc_page.handlers, openSignIn = _b.openSignIn, closeAuthForm = _b.closeAuthForm, openSignUp = _b.openSignUp;\r\nif (signInBtn) {\r\n    signInBtn.addEventListener('click', function (event) { return openSignIn(event, authForm); });\r\n    closeFormBtn.addEventListener('click', function (event) { return closeAuthForm(event, authForm); });\r\n    signOutBtn.addEventListener('click', function (event) { return openSignUp(event, authForm); });\r\n}\r\n\n\n//# sourceURL=webpack:///./src/app_otherPage.ts?");

/***/ }),

/***/ "./src/descPageModules/closeAuth.ts":
/*!******************************************!*\
  !*** ./src/descPageModules/closeAuth.ts ***!
  \******************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _main_obj__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../main_obj */ \"./src/main_obj.ts\");\n\r\n(function () {\r\n    function closeAuthForm(event, node) {\r\n        node.classList.remove('vissible');\r\n        node.classList.remove('slideInDown');\r\n        node.classList.add('slideOutUp');\r\n        setTimeout(function () {\r\n            document.getElementById('wrapper').innerHTML = '';\r\n            node.classList.add('hidden');\r\n        }, 1000);\r\n    }\r\n    _main_obj__WEBPACK_IMPORTED_MODULE_0__[\"pet_alert\"].desc_page.handlers.closeAuthForm = closeAuthForm;\r\n})();\r\n\n\n//# sourceURL=webpack:///./src/descPageModules/closeAuth.ts?");

/***/ }),

/***/ "./src/descPageModules/getNodes.ts":
/*!*****************************************!*\
  !*** ./src/descPageModules/getNodes.ts ***!
  \*****************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _main_obj__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../main_obj */ \"./src/main_obj.ts\");\n\r\n(function () {\r\n    function getNodes() {\r\n        var nodes = {\r\n            signInBtn: document.getElementById('login'),\r\n            signInBtn2: document.getElementById('login1'),\r\n            signOutBtn: document.getElementById('signup'),\r\n            authForm: document.getElementById('auth'),\r\n            closeFormBtn: document.getElementById('close'),\r\n            addDescBtn: document.getElementById('addDesc'),\r\n            changePostBtn: document.getElementById('showPostsMenu'),\r\n            policy: document.getElementById('policy_div')\r\n        };\r\n        return nodes;\r\n    }\r\n    _main_obj__WEBPACK_IMPORTED_MODULE_0__[\"pet_alert\"].nodes = getNodes();\r\n})();\r\n\n\n//# sourceURL=webpack:///./src/descPageModules/getNodes.ts?");

/***/ }),

/***/ "./src/descPageModules/openSignIn.ts":
/*!*******************************************!*\
  !*** ./src/descPageModules/openSignIn.ts ***!
  \*******************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _main_obj__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../main_obj */ \"./src/main_obj.ts\");\n\r\n(function () {\r\n    function openSignIn(event, node) {\r\n        node.classList.remove('hidden');\r\n        node.classList.remove('slideOutUp');\r\n        node.classList.add('vissible');\r\n        node.classList.add('animated');\r\n        node.classList.add('slideInDown');\r\n        var html = '<form action=\"user.php?login=1\" method=\"POST\" class=\"auth_form\">\\\n            <h4>Войти</h4>\\\n            <p>\\\n                <input type=\"text\" class=\"inp\" name=\"login\" placeholder=\"Введите Ваш логин\">\\\n                <input type=\"password\" class=\"inp\" name=\"pass\" placeholder=\"Введите Ваш пароль\">\\\n                <a href=\"page.php?open=retrivePass\">Забыли пароль?</a>\\\n                <button type=\"submit\" class=\"butn popup_butn\">Войти</button>\\\n            </p>\\\n        </form>';\r\n        document.getElementById('wrapper').innerHTML = html;\r\n    }\r\n    _main_obj__WEBPACK_IMPORTED_MODULE_0__[\"pet_alert\"].desc_page.handlers.openSignIn = openSignIn;\r\n})();\r\n\n\n//# sourceURL=webpack:///./src/descPageModules/openSignIn.ts?");

/***/ }),

/***/ "./src/descPageModules/openSignUp.ts":
/*!*******************************************!*\
  !*** ./src/descPageModules/openSignUp.ts ***!
  \*******************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _main_obj__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../main_obj */ \"./src/main_obj.ts\");\n\r\n(function () {\r\n    function signUpOpen(event, node) {\r\n        node.classList.remove('hidden');\r\n        node.classList.remove('slideOutUp');\r\n        node.classList.add('animated');\r\n        node.classList.add('slideInDown');\r\n        var html = '<form action=\"user.php?reg=1\" method=\"POST\" class=\"auth_form\">\\\n        <h4>Регистрация</h4>\\\n        <p>\\\n            <span id=\"showInfoReg\"></span>\\\n            <input type=\"text\" name=\"user_name\" class=\"inp\" placeholder=\"Введите Ваше имя\">\\\n            <input id=\"email_user\" class=\"inp\" type=\"text\" name=\"user_mail\" placeholder=\"Введите ваш e-mail\">\\\n            <input id=\"login_user\" type=\"text\" class=\"inp\" name=\"user_login\" placeholder=\"Введите логин\">\\\n            <input id=\"password_user\" type=\"text\" class=\"inp\" name=\"user_pass\" placeholder=\"Введите пароль\">\\\n            Нажимая кнопку \"Регистрация\" Вы соглашаетесь с <a href=\"page.php?open=aboutPage\" target=\"_blank\">\"Правилами сайта\"</a> \\\n            и <a href=\"page.php?open=privacyPage\" target=\"_blank\">\"Политикой обработки персональных данных\"</a>.<br>\\\n            <button id=\"button_submit\" type=\"submit\" class=\"butn popup_butn\">Регистрация</button>\\\n        </p>\\\n        </form>';\r\n        document.getElementById('wrapper').innerHTML = html;\r\n        // Валидация\r\n        //Login\r\n        var login_user = document.getElementById('login_user');\r\n        login_user.addEventListener('keyup', function (event) {\r\n            var keyCheck = /[a-zA-Z1-9]/;\r\n            var keys = event.target.value;\r\n            if (keyCheck.test(keys) == false) {\r\n                event.target.classList.add('wrong');\r\n                document.getElementById('showInfoReg').innerText = 'Логин должен содержать только буквы латинского алфавита и цифры.';\r\n                document.getElementById('button_submit').setAttribute('disabled', 'disabled');\r\n            }\r\n            else {\r\n                event.target.classList.remove('wrong');\r\n                document.getElementById('showInfoReg').innerText = '';\r\n                document.getElementById('button_submit').removeAttribute('disabled');\r\n            }\r\n        });\r\n        //Аякс запрос на существование введенного логина\r\n        document.getElementById('login_user').addEventListener('change', function (event) {\r\n            var keys = '';\r\n            var keyWar = event.target.value;\r\n            var index_t = keyWar.indexOf(';');\r\n            console.log(index_t);\r\n            if (index_t !== -1) {\r\n                keys = keyWar.substring(0, index_t);\r\n            }\r\n            else {\r\n                keys = keyWar;\r\n            }\r\n            fetch('lib/ajax_controller.php?check_login=' + keys)\r\n                .then(function (responce) {\r\n                return responce.text();\r\n            })\r\n                .then(function (answer) {\r\n                var check = Number(answer);\r\n                if (check === 1) {\r\n                    event.target.classList.add('wrong');\r\n                    document.getElementById('showInfoReg').innerText = 'Логин уже существует.';\r\n                    document.getElementById('button_submit').setAttribute('disabled', 'disabled');\r\n                }\r\n                else if (check === 0) {\r\n                    event.target.classList.remove('wrong');\r\n                    document.getElementById('showInfoReg').innerText = '';\r\n                    document.getElementById('button_submit').removeAttribute('disabled');\r\n                }\r\n                ;\r\n            });\r\n        });\r\n        //Password\r\n        document.getElementById('password_user').addEventListener('keyup', function (event) {\r\n            var keyCheck = /[a-zA-Z1-9]/;\r\n            var keys = event.target.value;\r\n            if (keyCheck.test(keys) == false) {\r\n                event.target.classList.add('wrong');\r\n                document.getElementById('showInfoReg').innerText = 'Пароль должен содержать только буквы латинского алфавита и цифры.';\r\n                document.getElementById('button_submit').setAttribute('disabled', 'disabled');\r\n            }\r\n            else {\r\n                event.target.classList.remove('wrong');\r\n                document.getElementById('showInfoReg').innerText = '';\r\n                document.getElementById('button_submit').removeAttribute('disabled');\r\n            }\r\n        });\r\n        //Email\r\n        document.getElementById('email_user').addEventListener('change', function (event) {\r\n            var keyCheck = /[0-9a-z-\\.\\_]+\\@[0-9a-z-\\_]{2,}\\.[a-z]{2,}/i;\r\n            var keys = event.target.value;\r\n            if (keyCheck.test(keys) == false) {\r\n                event.target.classList.add('wrong');\r\n                document.getElementById('showInfoReg').innerText = 'Формат e-mail\\'а указан не верно.';\r\n                document.getElementById('button_submit').setAttribute('disabled', 'disabled');\r\n            }\r\n            else {\r\n                event.target.classList.remove('wrong');\r\n                document.getElementById('showInfoReg').innerText = '';\r\n                document.getElementById('button_submit').removeAttribute('disabled');\r\n                fetch('lib/ajax_controller.php?check_email=' + keys)\r\n                    .then(function (responce) {\r\n                    return responce.text();\r\n                })\r\n                    .then(function (answer) {\r\n                    console.log(answer);\r\n                    var check = Number(answer);\r\n                    if (check === 1) {\r\n                        event.target.classList.add('wrong');\r\n                        document.getElementById('showInfoReg').innerText = 'Email уже существует.';\r\n                        document.getElementById('button_submit').setAttribute('disabled', 'disabled');\r\n                    }\r\n                    else if (check === 0) {\r\n                        event.target.classList.remove('wrong');\r\n                        document.getElementById('showInfoReg').innerText = '';\r\n                        document.getElementById('button_submit').removeAttribute('disabled');\r\n                    }\r\n                    ;\r\n                });\r\n            }\r\n        });\r\n    }\r\n    _main_obj__WEBPACK_IMPORTED_MODULE_0__[\"pet_alert\"].desc_page.handlers.openSignUp = signUpOpen;\r\n})();\r\n\n\n//# sourceURL=webpack:///./src/descPageModules/openSignUp.ts?");

/***/ }),

/***/ "./src/main_obj.ts":
/*!*************************!*\
  !*** ./src/main_obj.ts ***!
  \*************************/
/*! exports provided: pet_alert */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"pet_alert\", function() { return pet_alert; });\nvar pet_alert = {\r\n    nodes: null,\r\n    desc_page: {\r\n        handlers: {\r\n            openSignIn: null,\r\n            openSignUp: null,\r\n            closeAuthForm: null,\r\n            openAddDescHandler: null,\r\n            changePostTypeHandler: null,\r\n            showAddPic: null,\r\n            sortByCities: null\r\n        }\r\n    },\r\n    user_acc_page: {\r\n        handlers: {\r\n            chengeTypeDescHandler: null,\r\n            chengeTypeUserInfoHandler: null\r\n        }\r\n    }\r\n};\r\n\n\n//# sourceURL=webpack:///./src/main_obj.ts?");

/***/ })

/******/ });