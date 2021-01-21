// 参考: jQueryを使わずにJavaScriptだけでDOM操作
// https://tech-dig.jp/jquery%e3%82%92%e4%bd%bf%e3%82%8f%e3%81%9a%e3%81%abjavascript%e3%81%a0%e3%81%91%e3%81%a7dom%e6%93%8d%e4%bd%9c/

// カウント用変数
var i = 1;
var j = 1;
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
    var radioNodeList = check_form.select_line;

    // 選択状態の値(value)を取得
    var selected_val = radioNodeList.value;
    console.log(selected_val); // 確認用

    if (symbol == 'process') {
        addProcess(symbol, i, selected_val);
    } else if (symbol == 'loop') {
        addLoop(symbol, i, selected_val);
        i++;
    } else if (symbol == 'decision') {
        addDecision(symbol, i, selected_val);
        i += 2;
    }

    i++;
}

function addProcess(symbol, i, selected_val) {
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
    // 追加するラジオボタンとラベル
    var flex_div = document.createElement('div');
    flex_div.className = 'flex-container';
    var radio_data = document.createElement('input');
    radio_data.type = 'radio';
    radio_data.name = 'select_line';
    radio_data.id = 'under_' + i;
    radio_data.value = 'input_' + i;
    radio_data.className = 'select_line';
    var radio_label = document.createElement('label');
    radio_label.htmlFor = 'under_' + i;
    var label_img = document.createElement('img');
    label_img.className = 'line_img';
    label_img.src = './img/line.png';

    radio_label.appendChild(label_img);
    flex_div.appendChild(radio_data);
    flex_div.appendChild(radio_label);

    // divに追加
    input_div.appendChild(input_data);
    input_div.appendChild(flex_div);

    // HTML出力
    if (selected_val == 'input_0') {
        var parent = document.getElementById('add_area');
        parent.insertBefore(input_div, parent.firstChild);
    } else {
        var parent = document.getElementById(selected_val);
        parent.parentNode.insertBefore(input_div, parent.nextSibling);
    }
}

function addLoop(symbol, i, selected_val) {
    addProcess(symbol, i, selected_val);
    // 追加するdiv
    var input_div2 = document.createElement('div');
    input_div2.id = 'input_' + (i + 1);
    // 追加するテキストボックス
    var input_data2 = document.createElement('input');
    input_data2.type = 'text';
    input_data2.name = 'main';
    input_data2.id = 'inputform_' + (i + 1);
    input_data2.placeholder = 'フォーム-' + (i + 1);
    input_data2.className = '' + symbol + '_end';
    // 追加するラジオボタン
    var flex_div = document.createElement('div');
    flex_div.className = 'flex-container';
    var radio_data2 = document.createElement('input');
    radio_data2.type = 'radio';
    radio_data2.name = 'select_line';
    radio_data2.id = 'under_' + (i + 1);
    radio_data2.value = 'input_' + (i + 1);
    radio_data2.className = 'select_line';
    var radio_label = document.createElement('label');
    radio_label.htmlFor = 'under_' + (i + 1);
    var label_img = document.createElement('img');
    label_img.className = 'line_img';
    label_img.src = './img/line.png';

    radio_label.appendChild(label_img);
    flex_div.appendChild(radio_data2);
    flex_div.appendChild(radio_label);
    // divに追加
    input_div2.appendChild(input_data2);
    input_div2.appendChild(flex_div);
    // HTML出力
    var parent = document.getElementById('input_' + i);
    parent.parentNode.insertBefore(input_div2, parent.nextSibling);
}

function addDecision(symbol, i, selected_val) {
    // 追加するdiv（大枠）
    var wrap_div = document.createElement('div');
    wrap_div.id = 'input_' + i;
    // Flexコンテナ（親要素）
    var parent_div = document.createElement('div');
    parent_div.id = 'decision_' + i;
    parent_div.className = 'decision_container';
    // 横並び要素（子要素）
    var flex_div1 = document.createElement('div');
    flex_div1.id = 'line_' + i + '_1';
    flex_div1.className = 'left_line';
    var flex_div2 = document.createElement('div');
    flex_div2.id = 'line_' + i + '_2';
    flex_div2.className = 'right_line';
    // 追加するdiv（ラジオボタン）
    var input_div1 = document.createElement('div');
    input_div1.id = 'input_' + (i + 1);
    var input_div2 = document.createElement('div');
    input_div2.id = 'input_' + (i + 2);
    // 追加するテキストボックス
    var input_data = document.createElement('input');
    input_data.type = 'text';
    input_data.name = 'main';
    input_data.id = 'inputform_' + i;
    input_data.placeholder = 'フォーム-' + i;
    input_data.className = '' + symbol;
    // 追加するラジオボタン1（Flex外）
    var radio_data1 = document.createElement('input');
    radio_data1.type = 'radio';
    radio_data1.name = 'select_line';
    radio_data1.id = 'under_' + i;
    radio_data1.value = 'input_' + i;
    radio_data1.className = 'select_line';
    // 追加するラジオボタン2（Flex内、左）
    var radio_data2 = document.createElement('input');
    radio_data2.type = 'radio';
    radio_data2.name = 'select_line';
    radio_data2.id = 'under_' + (i + 1);
    radio_data2.value = 'input_' + (i + 1);
    radio_data2.className = 'select_line';
    // 追加するラジオボタン3（Flex内、右）
    var radio_data3 = document.createElement('input');
    radio_data3.type = 'radio';
    radio_data3.name = 'select_line';
    radio_data3.id = 'under_' + (i + 2);
    radio_data3.value = 'input_' + (i + 2);
    radio_data3.className = 'select_line';

    // divに追加
    // 追加div < ラジオボタン2,3
    input_div1.appendChild(radio_data2);
    input_div2.appendChild(radio_data3);
    // flex子要素 < 追加div
    flex_div1.appendChild(input_div1);
    flex_div2.appendChild(input_div2);
    // flex親要素 < flex子要素
    parent_div.appendChild(flex_div1);
    parent_div.appendChild(flex_div2);
    // 大枠div < テキストボックス、flex親要素、ラジオボタン1
    wrap_div.appendChild(input_data);
    wrap_div.appendChild(parent_div);
    wrap_div.appendChild(radio_data1);

    // HTML出力
    if (selected_val == 'input_0') {
        var parent = document.getElementById('add_area');
        parent.insertBefore(wrap_div, parent.firstChild);
    } else {
        var parent = document.getElementById(selected_val);
        parent.parentNode.insertBefore(wrap_div, parent.nextSibling);
    }
}

function getChart() {
    $('.select_line').hide();
    $('.line_img').css('margin-left', '98px');
    html2canvas(document.querySelector("#capture")).then(canvas => {
        // document.body.appendChild(canvas)
        var imageData = canvas.toDataURL();
        // imgタグに画像として、canvasの内容を挿入
        document.getElementById('canvas-image').setAttribute("src", canvas.toDataURL());
    });
}

