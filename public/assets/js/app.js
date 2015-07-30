function nextElementSibling(e){if(e.nextElementSibling)return e.nextElementSibling;do e=e.nextSibling;while(e&&1!==e.nodeType);return e}function previousElementSibling(e){if(e.previousElementSibling)return e.previousElementSibling;do e=e.previousSibling;while(e&&1!==e.nodeType);return e}function fireEvent(e,t){if(document.createEventObject){var n=document.createEventObject();return e.fireEvent("on"+t,n)}var n=document.createEvent("HTMLEvents");return n.initEvent(t,!0,!0),!e.dispatchEvent(n)}function findAncestor(e,t){for(;(e=e.parentElement)&&-1==e.className.indexOf(t););return e}function addEvent(e,t,n){e.addEventListener?e.addEventListener(t,n,!1):e.attachEvent("on"+t,n)}function firstToUpperCase(e){return firstChar=e.substring(0,1),firstChar.toUpperCase()+e.substring(1)}function hasClass(e,t){return!!e.className.match(new RegExp("(\\s|^)"+t+"(\\s|$)"))}function addClass(e,t){hasClass(e,t)||(e.className+=" "+t)}function removeClass(e,t){if(hasClass(e,t)){var n=new RegExp("(\\s|^)"+t+"(\\s|$)");e.className=e.className.replace(n," ")}}WebFontConfig={google:{families:["Open+Sans:400,700:latin,cyrillic"]}},function(){var e=document.createElement("script");e.src=("https:"==document.location.protocol?"https":"http")+"://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js",e.type="text/javascript",e.async="true";var t=document.getElementsByTagName("script")[0];t.parentNode.insertBefore(e,t)}(),addEvent(document.getElementById("upload-photo"),"change",function(){var e=document.getElementById("photo-preview");if(this.files&&this.files[0]){var t=new FileReader,n=this.files[0].name;t.onload=function(t){var i=n.substr(n.lastIndexOf(".")+1);return"jpg"!==i&&"gif"!==i&&"png"!==i?void addClass(e.parentNode,"hidden"):(e.src=t.target.result,void removeClass(e.parentNode,"hidden"))},t.readAsDataURL(this.files[0])}else addClass(e.parentNode,"hidden")});var Validator=function(e){this.form=e,lang=document.getElementsByTagName("html")[0].lang;var t={en:{required:"Please enter your :attribute.",email:"Please enter a valid email address.",min:":attribute must be :min characters or more.",max:":attribute must be :max characters or less.",not_image:"Uploaded file is not an image. Allowed file extensions only jpg, gif, png.",image_not_uploaded:"Please upload your photo."},ru:{required:"Пожалуйста введите :attribute.",email:"Пожалуйста укажите корректный адрес электронной почты.",min:":attribute не может быть короче :min символов.",max:":attribute не может быть длинее :max символов.",not_image:"Загружаемый файл не изображение. Допустимые форматы изображения jpg, gif, png.",image_not_uploaded:"Пожалуйста загрузите ваше фото."}};this.messages=t[lang],this.errors={},this.rules={required:function(e){""==e.value&&(label=previousElementSibling(e).innerText.toLowerCase(),this.errors[e.id].push(this.messages.required.replace(":attribute",label)))},email:function(e){var t=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;t.test(e.value)||this.errors[e.id].push(this.messages.email)},min:function(e,t){e.value.length<t&&(label=previousElementSibling(e).innerText.toLowerCase(),this.errors[e.id].push(this.messages.min.replace(":attribute",firstToUpperCase(label)).replace(":min",t)))},max:function(e,t){e.value.length>t&&(label=previousElementSibling(e).innerText.toLowerCase(),this.errors[e.id].push(this.messages.max.replace(":attribute",firstToUpperCase(label)).replace(":max",t)))},image:function(e){if(e.files&&e.files[0]){var t=e.files[0].name,n=t.substr(t.lastIndexOf(".")+1);"jpg"!==n&&"gif"!==n&&"png"!==n&&this.errors[e.id].push(this.messages.not_image)}else this.errors[e.id].push(this.messages.image_not_uploaded)}}};Validator.prototype.validate=function(e,t){var n=this,i=t.split("|"),a=findAncestor(e,"input-group").getElementsByClassName("error-message")[0];addEvent(e,"change",function(){n.errors[e.id]=[],errors=n.errors[e.id];for(var t=0;t<i.length;t++){var r=i[t].split(":"),s=r[1]||null;n.rules[r[0]].call(n,e,s)}errors.length?(a.innerText=errors[0],removeClass(e,"valid"),n.form.submit.disabled=!0):(a.innerText="",addClass(e,"valid"),n.form.submit.disabled=!1)}),addEvent(e,"keyup",function(){fireEvent(e,"change")}),addEvent(e,"input",function(){fireEvent(e,"change")}),addEvent(this.form,"submit",function(t){fireEvent(e,"change"),n.errors[e.id].length&&t.preventDefault()})},registration=new Validator(document.getElementById("registration")),registration.validate(document.getElementById("name"),"required|max:70"),registration.validate(document.getElementById("email"),"required|email|max:255"),registration.validate(document.getElementById("password"),"required|min:6|max:255"),registration.validate(document.getElementById("upload-photo"),"image"),login=new Validator(document.getElementById("login")),login.validate(document.getElementById("l_email"),"required|email|max:255"),login.validate(document.getElementById("l_password"),"required|max:255");