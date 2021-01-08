function post(id, params) {
    var parent = document.getElementById(id);
    for (const key in params) {
        if (params.hasOwnProperty(key)) {
            const hiddenField = document.createElement('input');
            hiddenField.type = 'hidden';
            hiddenField.id = id;
            hiddenField.name = key;
            hiddenField.value = params[key];
            
            // parent.appendChild(hiddenField);
            parent.replaceWith(hiddenField);
        }
    }
}
// 参考: https://oc-technote.com/javascript/javascript-post-params-move-to-page/