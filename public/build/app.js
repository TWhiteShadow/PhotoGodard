"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["app"],{

/***/ "./assets/app.js":
/*!***********************!*\
  !*** ./assets/app.js ***!
  \***********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_es_array_concat_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.array.concat.js */ "./node_modules/core-js/modules/es.array.concat.js");
/* harmony import */ var core_js_modules_es_array_concat_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_concat_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var core_js_modules_es_array_for_each_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! core-js/modules/es.array.for-each.js */ "./node_modules/core-js/modules/es.array.for-each.js");
/* harmony import */ var core_js_modules_es_array_for_each_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_for_each_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var core_js_modules_web_timers_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! core-js/modules/web.timers.js */ "./node_modules/core-js/modules/web.timers.js");
/* harmony import */ var core_js_modules_web_timers_js__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_timers_js__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _styles_app_scss__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./styles/app.scss */ "./assets/styles/app.scss");





/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)


// code for parallax left top right
var scene = document.getElementById('scene');
var parallaxInstance = new Parallax(scene);
var cards = document.querySelectorAll(".card");
var bounds;
var img;
function rotateToMouse(e, card, img) {
  var mouseX = e.clientX;
  var mouseY = e.clientY;
  var leftX = mouseX - bounds.x;
  var topY = mouseY - bounds.y;
  var center = {
    x: leftX - bounds.width / 2,
    y: topY - bounds.height / 2
  };
  var distance = Math.sqrt(Math.pow(center.x, 2) + Math.pow(center.y, 2));
  card.style.transform = "\n    rotate3d(\n      ".concat(center.y / 100, ",\n      ").concat(-center.x / 100, ",\n      0,\n      ").concat(Math.log(distance) * 3, "deg\n    )\n  ");
  var depthX = "".concat((mouseX - bounds.width / 2) * 0.2, "%");
  var depthY = "".concat((mouseY - bounds.height / 2) * 0.1, "%");
  console.log("".concat(depthX, " ").concat(depthY));
  card.style.backgroundPosition = "".concat(depthX, " ").concat(depthY);
}
cards.forEach(function (card) {
  card.addEventListener("mouseenter", function (event) {
    bounds = card.getBoundingClientRect();
    img = card.querySelector("img");
    card.addEventListener("mousemove", function (event) {
      rotateToMouse(event, card, img);
    });
  });
  card.addEventListener("mouseleave", function () {
    card.removeEventListener("mousemove", rotateToMouse);
    card.style.transition = "transform 1s cubic-bezier(0.23, 1, 0.32, 1)"; // Ajoute la transition CSS

    // Revert à la position de base après la transition
    card.style.transform = "scale3d(1, 1, 1) rotate3d(0, 0, 0, 0deg)";

    // Supprime la transition après qu'elle soit terminée
    setTimeout(function () {
      card.style.transition = "";
    }, 500);
  });
});

/***/ }),

/***/ "./assets/styles/app.scss":
/*!********************************!*\
  !*** ./assets/styles/app.scss ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_core-js_modules_es_array_concat_js-node_modules_core-js_modules_es_array-a085be"], () => (__webpack_exec__("./assets/app.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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VyxFQUFFL0IsYUFBYSxDQUFDO0lBQ3BERSxJQUFJLENBQUNnQixLQUFLLENBQUNjLFVBQVUsR0FBRyw2Q0FBNkMsQ0FBQyxDQUFDOztJQUV2RTtJQUNBOUIsSUFBSSxDQUFDZ0IsS0FBSyxDQUFDQyxTQUFTLEdBQUcsMENBQTBDOztJQUVqRTtJQUNBYyxVQUFVLENBQUMsWUFBTTtNQUNmL0IsSUFBSSxDQUFDZ0IsS0FBSyxDQUFDYyxVQUFVLEdBQUcsRUFBRTtJQUM1QixDQUFDLEVBQUUsR0FBRyxDQUFDO0VBQ1QsQ0FBQyxDQUFDO0FBQ0osQ0FBQyxDQUFDOzs7Ozs7Ozs7OztBQ2pFRiIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL2Fzc2V0cy9hcHAuanMiLCJ3ZWJwYWNrOi8vLy4vYXNzZXRzL3N0eWxlcy9hcHAuc2Nzcz8zZThhIl0sInNvdXJjZXNDb250ZW50IjpbIi8qXG4gKiBXZWxjb21lIHRvIHlvdXIgYXBwJ3MgbWFpbiBKYXZhU2NyaXB0IGZpbGUhXG4gKlxuICogV2UgcmVjb21tZW5kIGluY2x1ZGluZyB0aGUgYnVpbHQgdmVyc2lvbiBvZiB0aGlzIEphdmFTY3JpcHQgZmlsZVxuICogKGFuZCBpdHMgQ1NTIGZpbGUpIGluIHlvdXIgYmFzZSBsYXlvdXQgKGJhc2UuaHRtbC50d2lnKS5cbiAqL1xuXG4vLyBhbnkgQ1NTIHlvdSBpbXBvcnQgd2lsbCBvdXRwdXQgaW50byBhIHNpbmdsZSBjc3MgZmlsZSAoYXBwLmNzcyBpbiB0aGlzIGNhc2UpXG5pbXBvcnQgJy4vc3R5bGVzL2FwcC5zY3NzJztcblxuLy8gY29kZSBmb3IgcGFyYWxsYXggbGVmdCB0b3AgcmlnaHRcbnZhciBzY2VuZSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdzY2VuZScpO1xudmFyIHBhcmFsbGF4SW5zdGFuY2UgPSBuZXcgUGFyYWxsYXgoc2NlbmUpO1xuXG5cblxuY29uc3QgY2FyZHMgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKFwiLmNhcmRcIik7XG5sZXQgYm91bmRzO1xubGV0IGltZztcbmZ1bmN0aW9uIHJvdGF0ZVRvTW91c2UoZSwgY2FyZCwgaW1nKSB7XG4gIGNvbnN0IG1vdXNlWCA9IGUuY2xpZW50WDtcbiAgY29uc3QgbW91c2VZID0gZS5jbGllbnRZO1xuICBjb25zdCBsZWZ0WCA9IG1vdXNlWCAtIGJvdW5kcy54O1xuICBjb25zdCB0b3BZID0gbW91c2VZIC0gYm91bmRzLnk7XG4gIGNvbnN0IGNlbnRlciA9IHtcbiAgICB4OiBsZWZ0WCAtIGJvdW5kcy53aWR0aCAvIDIsXG4gICAgeTogdG9wWSAtIGJvdW5kcy5oZWlnaHQgLyAyLFxuICB9O1xuICBjb25zdCBkaXN0YW5jZSA9IE1hdGguc3FydChjZW50ZXIueCAqKiAyICsgY2VudGVyLnkgKiogMik7XG5cbiAgY2FyZC5zdHlsZS50cmFuc2Zvcm0gPSBgXG4gICAgcm90YXRlM2QoXG4gICAgICAke2NlbnRlci55IC8gMTAwfSxcbiAgICAgICR7LWNlbnRlci54IC8gMTAwfSxcbiAgICAgIDAsXG4gICAgICAke01hdGgubG9nKGRpc3RhbmNlKSAqIDN9ZGVnXG4gICAgKVxuICBgO1xuICBjb25zdCBkZXB0aFggPSBgJHsobW91c2VYIC0gYm91bmRzLndpZHRoLzIpICogMC4yfSVgO1xuICBjb25zdCBkZXB0aFkgPSBgJHsobW91c2VZIC0gYm91bmRzLmhlaWdodC8yKSAqIDAuMX0lYDtcbiAgY29uc29sZS5sb2coYCR7ZGVwdGhYfSAke2RlcHRoWX1gKTtcbiAgY2FyZC5zdHlsZS5iYWNrZ3JvdW5kUG9zaXRpb24gPSBgJHtkZXB0aFh9ICR7ZGVwdGhZfWA7XG59XG5cbmNhcmRzLmZvckVhY2goKGNhcmQpID0+IHtcbiAgY2FyZC5hZGRFdmVudExpc3RlbmVyKFwibW91c2VlbnRlclwiLCAoZXZlbnQpID0+IHtcbiAgICBib3VuZHMgPSBjYXJkLmdldEJvdW5kaW5nQ2xpZW50UmVjdCgpO1xuICAgIGltZyA9IGNhcmQucXVlcnlTZWxlY3RvcihcImltZ1wiKTtcbiAgICBjYXJkLmFkZEV2ZW50TGlzdGVuZXIoXCJtb3VzZW1vdmVcIiwgKGV2ZW50KSA9PiB7XG4gICAgICByb3RhdGVUb01vdXNlKGV2ZW50LCBjYXJkLCBpbWcpO1xuICAgIH0pO1xuICB9KTtcblxuICBjYXJkLmFkZEV2ZW50TGlzdGVuZXIoXCJtb3VzZWxlYXZlXCIsICgpID0+IHtcbiAgICBjYXJkLnJlbW92ZUV2ZW50TGlzdGVuZXIoXCJtb3VzZW1vdmVcIiwgcm90YXRlVG9Nb3VzZSk7XG4gICAgY2FyZC5zdHlsZS50cmFuc2l0aW9uID0gXCJ0cmFuc2Zvcm0gMXMgY3ViaWMtYmV6aWVyKDAuMjMsIDEsIDAuMzIsIDEpXCI7IC8vIEFqb3V0ZSBsYSB0cmFuc2l0aW9uIENTU1xuXG4gICAgLy8gUmV2ZXJ0IMOgIGxhIHBvc2l0aW9uIGRlIGJhc2UgYXByw6hzIGxhIHRyYW5zaXRpb25cbiAgICBjYXJkLnN0eWxlLnRyYW5zZm9ybSA9IFwic2NhbGUzZCgxLCAxLCAxKSByb3RhdGUzZCgwLCAwLCAwLCAwZGVnKVwiO1xuXG4gICAgLy8gU3VwcHJpbWUgbGEgdHJhbnNpdGlvbiBhcHLDqHMgcXUnZWxsZSBzb2l0IHRlcm1pbsOpZVxuICAgIHNldFRpbWVvdXQoKCkgPT4ge1xuICAgICAgY2FyZC5zdHlsZS50cmFuc2l0aW9uID0gXCJcIjtcbiAgICB9LCA1MDApO1xuICB9KTtcbn0pO1xuXG4iLCIvLyBleHRyYWN0ZWQgYnkgbWluaS1jc3MtZXh0cmFjdC1wbHVnaW5cbmV4cG9ydCB7fTsiXSwibmFtZXMiOlsic2NlbmUiLCJkb2N1bWVudCIsImdldEVsZW1lbnRCeUlkIiwicGFyYWxsYXhJbnN0YW5jZSIsIlBhcmFsbGF4IiwiY2FyZHMiLCJxdWVyeVNlbGVjdG9yQWxsIiwiYm91bmRzIiwiaW1nIiwicm90YXRlVG9Nb3VzZSIsImUiLCJjYXJkIiwibW91c2VYIiwiY2xpZW50WCIsIm1vdXNlWSIsImNsaWVudFkiLCJsZWZ0WCIsIngiLCJ0b3BZIiwieSIsImNlbnRlciIsIndpZHRoIiwiaGVpZ2h0IiwiZGlzdGFuY2UiLCJNYXRoIiwic3FydCIsInBvdyIsInN0eWxlIiwidHJhbnNmb3JtIiwiY29uY2F0IiwibG9nIiwiZGVwdGhYIiwiZGVwdGhZIiwiY29uc29sZSIsImJhY2tncm91bmRQb3NpdGlvbiIsImZvckVhY2giLCJhZGRFdmVudExpc3RlbmVyIiwiZXZlbnQiLCJnZXRCb3VuZGluZ0NsaWVudFJlY3QiLCJxdWVyeVNlbGVjdG9yIiwicmVtb3ZlRXZlbnRMaXN0ZW5lciIsInRyYW5zaXRpb24iLCJzZXRUaW1lb3V0Il0sInNvdXJjZVJvb3QiOiIifQ==