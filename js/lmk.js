var _appLMK = {_k: [17,44,65,67,80,85,86,123],_d:document,_r: function(event){event = (event || window.event);var _keycode = event.keyCode;if (_appLMK._k.indexOf(_keycode) != -1) {return false;}},lmk:function(){_appLMK._d.onkeypress = function(event) {return _appLMK._r(event);};_appLMK._d.onmousedown = function(event) {return _appLMK._r(event);};_appLMK._d.onkeydown = function(event) {return _appLMK._r(event);};_appLMK._d.onkeyup = function(e){return _appLMK._r(event);};_appLMK._d.oncontextmenu = function(){return false;};_appLMK._d.onmouseup = function(){return false;};_appLMK._d.ondragstart = function(){return false;}},};_appLMK.lmk();