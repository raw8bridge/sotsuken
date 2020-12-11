// 参考: jQueryを使わずにJavaScriptだけでDOM操作
// https://tech-dig.jp/jquery%e3%82%92%e4%bd%bf%e3%82%8f%e3%81%9a%e3%81%abjavascript%e3%81%a0%e3%81%91%e3%81%a7dom%e6%93%8d%e4%bd%9c/

var i = 1;
function addForm() {
    // form要素を取得
    var element = document.getElementById('main_form');

    // form要素内のラジオボタングループ(name="select")を取得
    var radioNodeList = element.select;

    // 選択状態の値(id)を取得
    var selected_val = radioNodeList.value;
    console.log(selected_val);

    var input_div = document.createElement('div');
    input_div.id = 'input_' + i;

    var input_data = document.createElement('input');
    input_data.type = 'text';
    input_data.name = 'main';
    input_data.id = 'inputform_' + i;
    input_data.placeholder = 'フォーム-' + i;

    var radio_data = document.createElement('input');
    radio_data.type = 'radio';
    radio_data.name = 'select';
    radio_data.id = 'under_' + i;
    radio_data.value = 'input_' + i;

    input_div.appendChild(input_data);
    input_div.appendChild(radio_data);

    if (selected_val == 'input_0') {
        var parent = document.getElementById('add_area');
        parent.insertBefore(input_div, parent.firstChild);
    } else {
        var parent = document.getElementById(selected_val);
        parent.parentNode.insertBefore(input_div, parent.nextSibling);
    }
    i++;
}
