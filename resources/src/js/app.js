WebFontConfig = {
	google: { families: [ 'Open+Sans:400,700:latin,cyrillic' ] }
};
(function() {
	var wf = document.createElement('script');
	wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
	'://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
	wf.type = 'text/javascript';
	wf.async = 'true';
	var s = document.getElementsByTagName('script')[0];
	s.parentNode.insertBefore(wf, s);
})();

addEvent(document.getElementById('upload-photo'), 'change', function () {

	var image = document.getElementById('photo-preview');

	if (this.files && this.files[0]) {
		var reader = new FileReader();
		var filename = this.files[0].name;
		reader.onload = function (event) {
			var extension = filename.substr((filename.lastIndexOf('.') + 1))
			if (extension !== 'jpg' && extension !== 'gif' && extension !== 'png') {
				addClass(image.parentNode, 'hidden');
				return;
			}
			image.src = event.target.result;
			removeClass(image.parentNode, 'hidden');
		};
		reader.readAsDataURL(this.files[0]);
	} else {
		addClass(image.parentNode, 'hidden');
	}



});

function nextElementSibling(el) {
	if (el.nextElementSibling) {
		return el.nextElementSibling;
	}
	do {
		el = el.nextSibling
	} while (el && el.nodeType !== 1);
	return el;
}

function previousElementSibling(el) {
	if (el.previousElementSibling) {
		return el.previousElementSibling;
	}
	do {
		el = el.previousSibling
	} while (el && el.nodeType !== 1);
	return el;
}

function fireEvent(element, event) {
	if (document.createEventObject) {
		// IE
		var evt = document.createEventObject();
		return element.fireEvent('on' + event, evt);
	} else {
		var evt = document.createEvent("HTMLEvents");
		evt.initEvent(event, true, true);
		return !element.dispatchEvent(evt);
	}
}

function findAncestor(el, cls) {
    while ((el = el.parentElement) && el.className.indexOf(cls) == -1);
    return el;
}

function addEvent(element, event, callback) {
	if (element.addEventListener) {
		element.addEventListener(event, callback, false);
	} else { //IE
		element.attachEvent('on' + event, callback);
	}
}

function firstToUpperCase(string) {
	firstChar = string.substring(0, 1);
	return firstChar.toUpperCase() + string.substring(1);
}

function hasClass(element, class) {
	return !!element.className.match(new RegExp('(\\s|^)'+ class +'(\\s|$)'));
}

function addClass(element, class) {
	if (!hasClass(element, class)) {
		element.className += " " + class;
	}
}

function removeClass(element, class) {
	if (hasClass(element, class)) {
		var reg = new RegExp('(\\s|^)'+ class +'(\\s|$)');
		element.className = element.className.replace(reg, ' ');
	}
}

var Validator = function(form) {

	this.form = form;
	lang = document.getElementsByTagName('html')[0].lang;
	var messages = {
		en: {
			required: 'Please enter your :attribute.',
			email: 'Please enter a valid email address.',
			min: ':attribute must be :min characters or more.',
			max: ':attribute must be :max characters or less.',
			'not_image': 'Uploaded file is not an image. Allowed file extensions only jpg, gif, png.',
			'image_not_uploaded': 'Please upload your photo.',
		},
		ru: {
			required: 'Пожалуйста введите :attribute.',
			email: 'Пожалуйста укажите корректный адрес электронной почты.',
			min: ':attribute не может быть короче :min символов.',
			max: ':attribute не может быть длинее :max символов.',
			'not_image': 'Загружаемый файл не изображение. Допустимые форматы изображения jpg, gif, png.',
			'image_not_uploaded': 'Пожалуйста загрузите ваше фото.',
		}
	};

	this.messages = messages[lang];
	this.errors = {};
	this.rules = {
		required: function(el) {
			if (el.value == '') {
				label = previousElementSibling(el).innerText.toLowerCase();
				this.errors[el.id].push(this.messages.required.replace(':attribute', label));
			};
		},
		email: function(el) {
			var reg = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
			if (!reg.test(el.value)) {
				this.errors[el.id].push(this.messages.email);
			};
		},
		min: function(el, min) {
			if (el.value.length < min) {
				label = previousElementSibling(el).innerText.toLowerCase();
				this.errors[el.id].push(this.messages.min.replace(':attribute', firstToUpperCase(label)).replace(':min', min));
			};
		},
		max: function(el, max) {
			if (el.value.length > max) {
				label = previousElementSibling(el).innerText.toLowerCase();
				this.errors[el.id].push(this.messages.max.replace(':attribute', firstToUpperCase(label)).replace(':max', max));
			};
		},
		image: function(el) {
			if (el.files && el.files[0]) {
				var filename = el.files[0].name;
				var extension = filename.substr((filename.lastIndexOf('.') + 1))
				if (extension !== 'jpg' && extension !== 'gif' && extension !== 'png') {
					this.errors[el.id].push(this.messages['not_image']);
				}
			} else {
				this.errors[el.id].push(this.messages['image_not_uploaded']);
			}
		},
	};

};

Validator.prototype.validate = function(element, validationRules) {
	var self = this;
	var rules = validationRules.split('|');
	var errorMessageNode = findAncestor(element, 'input-group').getElementsByClassName('error-message')[0];

	addEvent(element, 'change', function() {
		self.errors[element.id] = [];
		errors = self.errors[element.id];

		for (var i = 0; i < rules.length; i++) {
			var rule = rules[i].split(':');
			var attributes = rule[1] || null;
			self.rules[rule[0]].call(self, element, attributes);
		};

		if (errors.length) {
			errorMessageNode.innerText = errors[0];
			removeClass(element, 'valid');
			self.form.submit.disabled = true;
		} else {
			errorMessageNode.innerText = '';
			addClass(element, 'valid');
			self.form.submit.disabled = false;
		};

	});

	addEvent(element, 'keyup', function() {
		fireEvent(element, 'change');
	});

	addEvent(element, 'input', function() {
		fireEvent(element, 'change');
	});

	addEvent(this.form, 'submit', function(event) {
		fireEvent(element, 'change');
		if (self.errors[element.id].length) {
			event.preventDefault();
		}
	});

}

registration = new Validator(document.getElementById('registration'));
registration.validate(document.getElementById('name'), 'required|max:70');
registration.validate(document.getElementById('email'), 'required|email|max:255');
registration.validate(document.getElementById('password'), 'required|min:6|max:255');
registration.validate(document.getElementById('upload-photo'), 'image');


login = new Validator(document.getElementById('login'));
login.validate(document.getElementById('l_email'), 'required|email|max:255');
login.validate(document.getElementById('l_password'), 'required|max:255');