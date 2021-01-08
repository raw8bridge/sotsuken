var editor = ace.edit("ace_editor");
editor.$blockScrolling = Infinity;
editor.setOptions({
    enableBasicAutocompletion: true,
    enableSnippets: true,
    enableLiveAutocompletion: true
});
editor.setTheme("ace/theme/monokai");
editor.getSession().setMode("ace/mode/python");

$('#font-size').click(function (e) {
    editor.setFontSize($(e.target).data('size'));
});
$('#language-mode').click(function (e) {
    editor.getSession().setMode("ace/mode/" + $(e.target).data('language'));
    lang.innerHTML = $(e.target).data('language');
});
$('#save').click(function (e) {
    localStorage.text = editor.getValue();
    alert("保存しました。");
});
$('#load').click(function (e) {
    if (!confirm("読み込みますか？")) return;
    editor.setValue(localStorage.text, -1);
});