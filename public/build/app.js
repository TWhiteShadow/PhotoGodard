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

// Function to check if the element has non-zero height and width
var hasNonZeroDimensions = function hasNonZeroDimensions(element) {
  return element.offsetHeight > 0 && element.offsetWidth > 0;
};

// Function to set up parallax effect
var setupParallax = function setupParallax(element) {
  var state = {
    mouseX: 0,
    mouseY: 0,
    height: element.offsetHeight,
    width: element.offsetWidth
  };
  console.log(state);
  element.addEventListener("mousemove", function (ele) {
    console.log("I'm hovered");
    var card = element.querySelector(".card");
    state.mouseX = ele.pageX - element.offsetLeft - state.width / 2;
    state.mouseY = ele.pageY - element.offsetTop - state.height / 2;

    // parallax angle in card
    var angleX = state.mouseX / state.width * 30;
    var angleY = state.mouseY / state.height * -30;
    card.style.transform = "rotateY(".concat(angleX, "deg) rotateX(").concat(angleY, "deg) ");
  });
  element.addEventListener("mouseout", function () {
    var card = element.querySelector(".card");
    card.style.transform = "rotateY(0deg) rotateX(0deg) ";
  });
};

// code for parallax of each image
var wrapper = document.querySelectorAll(".cardWrap");
wrapper.forEach(function (element) {
  var checkAndSetup = function checkAndSetup() {
    if (hasNonZeroDimensions(element)) {
      setupParallax(element);
      clearInterval(intervalId);
    }
  };
  var intervalId = setInterval(checkAndSetup, 100); // Adjust the interval as needed
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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiYXBwLmpzIiwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7O0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQzJCOztBQUczQjtBQUNBLElBQUlBLEtBQUssR0FBR0MsUUFBUSxDQUFDQyxjQUFjLENBQUMsT0FBTyxDQUFDO0FBQzVDLElBQUlDLGdCQUFnQixHQUFHLElBQUlDLFFBQVEsQ0FBQ0osS0FBSyxDQUFDOztBQUUxQztBQUNBLElBQU1LLG9CQUFvQixHQUFHLFNBQXZCQSxvQkFBb0JBLENBQUlDLE9BQU8sRUFBSztFQUN0QyxPQUFPQSxPQUFPLENBQUNDLFlBQVksR0FBRyxDQUFDLElBQUlELE9BQU8sQ0FBQ0UsV0FBVyxHQUFHLENBQUM7QUFDOUQsQ0FBQzs7QUFFRDtBQUNBLElBQU1DLGFBQWEsR0FBRyxTQUFoQkEsYUFBYUEsQ0FBSUgsT0FBTyxFQUFLO0VBQy9CLElBQUlJLEtBQUssR0FBRztJQUNSQyxNQUFNLEVBQUUsQ0FBQztJQUNUQyxNQUFNLEVBQUUsQ0FBQztJQUNUQyxNQUFNLEVBQUVQLE9BQU8sQ0FBQ0MsWUFBWTtJQUM1Qk8sS0FBSyxFQUFFUixPQUFPLENBQUNFO0VBQ25CLENBQUM7RUFFRE8sT0FBTyxDQUFDQyxHQUFHLENBQUNOLEtBQUssQ0FBQztFQUVsQkosT0FBTyxDQUFDVyxnQkFBZ0IsQ0FBQyxXQUFXLEVBQUUsVUFBQ0MsR0FBRyxFQUFLO0lBQzNDSCxPQUFPLENBQUNDLEdBQUcsQ0FBQyxhQUFhLENBQUM7SUFDMUIsSUFBTUcsSUFBSSxHQUFHYixPQUFPLENBQUNjLGFBQWEsQ0FBQyxPQUFPLENBQUM7SUFDM0NWLEtBQUssQ0FBQ0MsTUFBTSxHQUFHTyxHQUFHLENBQUNHLEtBQUssR0FBR2YsT0FBTyxDQUFDZ0IsVUFBVSxHQUFHWixLQUFLLENBQUNJLEtBQUssR0FBRyxDQUFDO0lBQy9ESixLQUFLLENBQUNFLE1BQU0sR0FBR00sR0FBRyxDQUFDSyxLQUFLLEdBQUdqQixPQUFPLENBQUNrQixTQUFTLEdBQUdkLEtBQUssQ0FBQ0csTUFBTSxHQUFHLENBQUM7O0lBRS9EO0lBQ0EsSUFBTVksTUFBTSxHQUFJZixLQUFLLENBQUNDLE1BQU0sR0FBR0QsS0FBSyxDQUFDSSxLQUFLLEdBQUksRUFBRTtJQUNoRCxJQUFNWSxNQUFNLEdBQUloQixLQUFLLENBQUNFLE1BQU0sR0FBR0YsS0FBSyxDQUFDRyxNQUFNLEdBQUksQ0FBQyxFQUFFO0lBQ2xETSxJQUFJLENBQUNRLEtBQUssQ0FBQ0MsU0FBUyxjQUFBQyxNQUFBLENBQWNKLE1BQU0sbUJBQUFJLE1BQUEsQ0FBZ0JILE1BQU0sVUFBTztFQUN6RSxDQUFDLENBQUM7RUFFRnBCLE9BQU8sQ0FBQ1csZ0JBQWdCLENBQUMsVUFBVSxFQUFFLFlBQU07SUFDdkMsSUFBTUUsSUFBSSxHQUFHYixPQUFPLENBQUNjLGFBQWEsQ0FBQyxPQUFPLENBQUM7SUFDM0NELElBQUksQ0FBQ1EsS0FBSyxDQUFDQyxTQUFTLGlDQUFpQztFQUN6RCxDQUFDLENBQUM7QUFDTixDQUFDOztBQUVEO0FBQ0EsSUFBTUUsT0FBTyxHQUFHN0IsUUFBUSxDQUFDOEIsZ0JBQWdCLENBQUMsV0FBVyxDQUFDO0FBRXRERCxPQUFPLENBQUNFLE9BQU8sQ0FBQyxVQUFDMUIsT0FBTyxFQUFLO0VBQ3pCLElBQU0yQixhQUFhLEdBQUcsU0FBaEJBLGFBQWFBLENBQUEsRUFBUztJQUN4QixJQUFJNUIsb0JBQW9CLENBQUNDLE9BQU8sQ0FBQyxFQUFFO01BQy9CRyxhQUFhLENBQUNILE9BQU8sQ0FBQztNQUN0QjRCLGFBQWEsQ0FBQ0MsVUFBVSxDQUFDO0lBQzdCO0VBQ0osQ0FBQztFQUVELElBQU1BLFVBQVUsR0FBR0MsV0FBVyxDQUFDSCxhQUFhLEVBQUUsR0FBRyxDQUFDLENBQUMsQ0FBQztBQUN4RCxDQUFDLENBQUM7Ozs7Ozs7Ozs7O0FDN0RGIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vYXNzZXRzL2FwcC5qcyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvc3R5bGVzL2FwcC5zY3NzIl0sInNvdXJjZXNDb250ZW50IjpbIi8qXG4gKiBXZWxjb21lIHRvIHlvdXIgYXBwJ3MgbWFpbiBKYXZhU2NyaXB0IGZpbGUhXG4gKlxuICogV2UgcmVjb21tZW5kIGluY2x1ZGluZyB0aGUgYnVpbHQgdmVyc2lvbiBvZiB0aGlzIEphdmFTY3JpcHQgZmlsZVxuICogKGFuZCBpdHMgQ1NTIGZpbGUpIGluIHlvdXIgYmFzZSBsYXlvdXQgKGJhc2UuaHRtbC50d2lnKS5cbiAqL1xuXG4vLyBhbnkgQ1NTIHlvdSBpbXBvcnQgd2lsbCBvdXRwdXQgaW50byBhIHNpbmdsZSBjc3MgZmlsZSAoYXBwLmNzcyBpbiB0aGlzIGNhc2UpXG5pbXBvcnQgJy4vc3R5bGVzL2FwcC5zY3NzJztcblxuXG4vLyBjb2RlIGZvciBwYXJhbGxheCBsZWZ0IHRvcCByaWdodFxudmFyIHNjZW5lID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ3NjZW5lJyk7XG52YXIgcGFyYWxsYXhJbnN0YW5jZSA9IG5ldyBQYXJhbGxheChzY2VuZSk7XG5cbi8vIEZ1bmN0aW9uIHRvIGNoZWNrIGlmIHRoZSBlbGVtZW50IGhhcyBub24temVybyBoZWlnaHQgYW5kIHdpZHRoXG5jb25zdCBoYXNOb25aZXJvRGltZW5zaW9ucyA9IChlbGVtZW50KSA9PiB7XG4gICAgcmV0dXJuIGVsZW1lbnQub2Zmc2V0SGVpZ2h0ID4gMCAmJiBlbGVtZW50Lm9mZnNldFdpZHRoID4gMDtcbn07XG5cbi8vIEZ1bmN0aW9uIHRvIHNldCB1cCBwYXJhbGxheCBlZmZlY3RcbmNvbnN0IHNldHVwUGFyYWxsYXggPSAoZWxlbWVudCkgPT4ge1xuICAgIGxldCBzdGF0ZSA9IHtcbiAgICAgICAgbW91c2VYOiAwLFxuICAgICAgICBtb3VzZVk6IDAsXG4gICAgICAgIGhlaWdodDogZWxlbWVudC5vZmZzZXRIZWlnaHQsXG4gICAgICAgIHdpZHRoOiBlbGVtZW50Lm9mZnNldFdpZHRoLFxuICAgIH07XG5cbiAgICBjb25zb2xlLmxvZyhzdGF0ZSk7XG5cbiAgICBlbGVtZW50LmFkZEV2ZW50TGlzdGVuZXIoXCJtb3VzZW1vdmVcIiwgKGVsZSkgPT4ge1xuICAgICAgICBjb25zb2xlLmxvZyhcIkknbSBob3ZlcmVkXCIpO1xuICAgICAgICBjb25zdCBjYXJkID0gZWxlbWVudC5xdWVyeVNlbGVjdG9yKFwiLmNhcmRcIik7XG4gICAgICAgIHN0YXRlLm1vdXNlWCA9IGVsZS5wYWdlWCAtIGVsZW1lbnQub2Zmc2V0TGVmdCAtIHN0YXRlLndpZHRoIC8gMjtcbiAgICAgICAgc3RhdGUubW91c2VZID0gZWxlLnBhZ2VZIC0gZWxlbWVudC5vZmZzZXRUb3AgLSBzdGF0ZS5oZWlnaHQgLyAyO1xuXG4gICAgICAgIC8vIHBhcmFsbGF4IGFuZ2xlIGluIGNhcmRcbiAgICAgICAgY29uc3QgYW5nbGVYID0gKHN0YXRlLm1vdXNlWCAvIHN0YXRlLndpZHRoKSAqIDMwO1xuICAgICAgICBjb25zdCBhbmdsZVkgPSAoc3RhdGUubW91c2VZIC8gc3RhdGUuaGVpZ2h0KSAqIC0zMDtcbiAgICAgICAgY2FyZC5zdHlsZS50cmFuc2Zvcm0gPSBgcm90YXRlWSgke2FuZ2xlWH1kZWcpIHJvdGF0ZVgoJHthbmdsZVl9ZGVnKSBgO1xuICAgIH0pO1xuXG4gICAgZWxlbWVudC5hZGRFdmVudExpc3RlbmVyKFwibW91c2VvdXRcIiwgKCkgPT4ge1xuICAgICAgICBjb25zdCBjYXJkID0gZWxlbWVudC5xdWVyeVNlbGVjdG9yKFwiLmNhcmRcIik7XG4gICAgICAgIGNhcmQuc3R5bGUudHJhbnNmb3JtID0gYHJvdGF0ZVkoMGRlZykgcm90YXRlWCgwZGVnKSBgO1xuICAgIH0pO1xufTtcblxuLy8gY29kZSBmb3IgcGFyYWxsYXggb2YgZWFjaCBpbWFnZVxuY29uc3Qgd3JhcHBlciA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoXCIuY2FyZFdyYXBcIik7XG5cbndyYXBwZXIuZm9yRWFjaCgoZWxlbWVudCkgPT4ge1xuICAgIGNvbnN0IGNoZWNrQW5kU2V0dXAgPSAoKSA9PiB7XG4gICAgICAgIGlmIChoYXNOb25aZXJvRGltZW5zaW9ucyhlbGVtZW50KSkge1xuICAgICAgICAgICAgc2V0dXBQYXJhbGxheChlbGVtZW50KTtcbiAgICAgICAgICAgIGNsZWFySW50ZXJ2YWwoaW50ZXJ2YWxJZCk7XG4gICAgICAgIH1cbiAgICB9O1xuXG4gICAgY29uc3QgaW50ZXJ2YWxJZCA9IHNldEludGVydmFsKGNoZWNrQW5kU2V0dXAsIDEwMCk7IC8vIEFkanVzdCB0aGUgaW50ZXJ2YWwgYXMgbmVlZGVkXG59KTtcbiIsIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpblxuZXhwb3J0IHt9OyJdLCJuYW1lcyI6WyJzY2VuZSIsImRvY3VtZW50IiwiZ2V0RWxlbWVudEJ5SWQiLCJwYXJhbGxheEluc3RhbmNlIiwiUGFyYWxsYXgiLCJoYXNOb25aZXJvRGltZW5zaW9ucyIsImVsZW1lbnQiLCJvZmZzZXRIZWlnaHQiLCJvZmZzZXRXaWR0aCIsInNldHVwUGFyYWxsYXgiLCJzdGF0ZSIsIm1vdXNlWCIsIm1vdXNlWSIsImhlaWdodCIsIndpZHRoIiwiY29uc29sZSIsImxvZyIsImFkZEV2ZW50TGlzdGVuZXIiLCJlbGUiLCJjYXJkIiwicXVlcnlTZWxlY3RvciIsInBhZ2VYIiwib2Zmc2V0TGVmdCIsInBhZ2VZIiwib2Zmc2V0VG9wIiwiYW5nbGVYIiwiYW5nbGVZIiwic3R5bGUiLCJ0cmFuc2Zvcm0iLCJjb25jYXQiLCJ3cmFwcGVyIiwicXVlcnlTZWxlY3RvckFsbCIsImZvckVhY2giLCJjaGVja0FuZFNldHVwIiwiY2xlYXJJbnRlcnZhbCIsImludGVydmFsSWQiLCJzZXRJbnRlcnZhbCJdLCJzb3VyY2VSb290IjoiIn0=