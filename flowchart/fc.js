// 参考: jQueryを使わずにJavaScriptだけでDOM操作
// https://tech-dig.jp/jquery%e3%82%92%e4%bd%bf%e3%82%8f%e3%81%9a%e3%81%abjavascript%e3%81%a0%e3%81%91%e3%81%a7dom%e6%93%8d%e4%bd%9c/

// カウント用変数
var i = 1;
function addForm() {
    // check_form要素を取得
    var check_form = document.getElementById('check_form');

    // form要素内のラジオボタングループ(name="select_symbol")を取得
    var checkList = check_form.select_symbol;

    // 選択中のシンボルを取得
    var symbol = checkList.value;
    console.log(symbol); // 確認用

    // main_form要素を取得
    var element = document.getElementById('main_form');


    // form要素内のラジオボタングループ(name="select_line")を取得
    var radioNodeList = element.select_line;

    // 選択状態の値(value)を取得
    var selected_val = radioNodeList.value;
    // console.log(selected_val); // 確認用

    // 追加するdiv
    var input_div = document.createElement('div');
    input_div.id = 'input_' + i;
    // 追加するテキストボックス
    var input_data = document.createElement('input');
    input_data.type = 'text';
    input_data.name = 'main';
    input_data.id = 'inputform_' + i;
    input_data.placeholder = 'フォーム-' + i;
    input_data.className = '' + symbol;
    // 追加するラジオボタン
    var radio_data = document.createElement('input');
    radio_data.type = 'radio';
    radio_data.name = 'select_line';
    radio_data.id = 'under_' + i;
    radio_data.value = 'input_' + i;
    radio_data.className = 'select_line';

    // divに追加
    input_div.appendChild(input_data);
    input_div.appendChild(radio_data);

    // HTML出力
    if (selected_val == 'input_0') {
        var parent = document.getElementById('add_area');
        parent.insertBefore(input_div, parent.firstChild);
    } else {
        var parent = document.getElementById(selected_val);
        parent.parentNode.insertBefore(input_div, parent.nextSibling);
    }
    i++;
}
