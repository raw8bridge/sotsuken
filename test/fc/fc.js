// 参考: jQueryを使わずにJavaScriptだけでDOM操作
// https://tech-dig.jp/jquery%e3%82%92%e4%bd%bf%e3%82%8f%e3%81%9a%e3%81%abjavascript%e3%81%a0%e3%81%91%e3%81%a7dom%e6%93%8d%e4%bd%9c/

// カウント用変数
var i = 1;
var j = 1;
function addForm() {
    // main_form要素を取得
    var main_form = document.getElementById('main_form');

    // form要素内のラジオボタングループ(name="select_symbol")を取得
    var checkList = main_form.select_symbol;

    // 選択中のシンボルを取得
    var symbol = checkList.value;
    console.log(symbol); // 確認用

    // form要素内のラジオボタングループ(name="select_line")を取得
    var radioNodeList = main_form.select_line;

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
    } else if (symbol == 'lineadd') {
        addLine(symbol, i, selected_val);
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
    label_img.src = './fc/img/line.png';

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
    // 追加するラジオボタンとラベル
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
    label_img.src = './fc/img/line.png';

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
    // 線
    var label_img = document.createElement('img');
    label_img.className = 'line2_img';
    label_img.src = './fc/img/line2.png';
    // 追加するテキストボックス
    var flex_form_div = document.createElement('div');
    flex_form_div.className = 'flex-container';
    var input_data = document.createElement('input');
    input_data.type = 'text';
    input_data.name = 'main';
    input_data.id = 'inputform_' + i;
    input_data.placeholder = 'フォーム-' + i;
    input_data.className = '' + symbol;
    // ラベル
    var input_label = document.createElement('label');
    input_label.htmlFor = 'inputform_' + i;
    input_label.appendChild(label_img);
    flex_form_div.appendChild(input_data);
    flex_form_div.appendChild(input_label);
    // 線1
    var label_img = document.createElement('img');
    label_img.className = 'line3_img';
    label_img.src = './fc/img/line3.png';
    // 線2
    var line2_img = document.createElement('img');
    line2_img.className = 'line4_img';
    line2_img.src = './fc/img/line4.png';
    // 追加するラジオボタン1（Flex外）
    var flex_radio_div1 = document.createElement('div');
    flex_radio_div1.className = 'flex-container';
    var radio_data1 = document.createElement('input');
    radio_data1.type = 'radio';
    radio_data1.name = 'select_line';
    radio_data1.id = 'under_' + i;
    radio_data1.value = 'input_' + i;
    radio_data1.className = 'select_line';
    // ラベル
    var radio_label1 = document.createElement('label');
    radio_label1.htmlFor = 'under_' + i;
    radio_label1.appendChild(label_img);
    // 線2のdiv
    var line2_div = document.createElement('div');
    line2_div.className = 'horizonal_line';
    line2_div.appendChild(line2_img);
    // 線
    var label_img = document.createElement('img');
    label_img.className = 'line_img';
    label_img.src = './fc/img/line.png';
    // 追加するラジオボタン2（Flex内、左）
    var flex_radio_div2 = document.createElement('div');
    flex_radio_div2.className = 'flex-container';
    var radio_data2 = document.createElement('input');
    radio_data2.type = 'radio';
    radio_data2.name = 'select_line';
    radio_data2.id = 'under_' + (i + 1);
    radio_data2.value = 'input_' + (i + 1);
    radio_data2.className = 'select_line';
    // ラベル
    var radio_label2 = document.createElement('label');
    radio_label2.htmlFor = 'under_' + (i + 1);
    radio_label2.className = 'left_label';
    radio_label2.appendChild(label_img);
    // 線
    var label_img = document.createElement('img');
    label_img.className = 'line_img';
    label_img.src = './fc/img/line.png';
    // 追加するラジオボタン3（Flex内、右）
    var flex_radio_div3 = document.createElement('div');
    flex_radio_div3.className = 'flex-container';
    var radio_data3 = document.createElement('input');
    radio_data3.type = 'radio';
    radio_data3.name = 'select_line';
    radio_data3.id = 'under_' + (i + 2);
    radio_data3.value = 'input_' + (i + 2);
    radio_data3.className = 'select_line';
    // ラベル
    var radio_label3 = document.createElement('label');
    radio_label3.htmlFor = 'under_' + (i + 2);
    radio_label3.appendChild(label_img);

    // divに追加
    // flexdiv < ラジオボタン, ラベル
    flex_radio_div1.appendChild(radio_data1);
    flex_radio_div1.appendChild(radio_label1);
    flex_radio_div1.appendChild(line2_div);
    flex_radio_div2.appendChild(radio_data2);
    flex_radio_div2.appendChild(radio_label2);
    flex_radio_div3.appendChild(radio_data3);
    flex_radio_div3.appendChild(radio_label3);
    // 追加div < ラジオボタン2,3
    input_div1.appendChild(flex_radio_div2);
    input_div2.appendChild(flex_radio_div3);
    // flex子要素 < 追加div
    flex_div1.appendChild(input_div1);
    flex_div2.appendChild(input_div2);
    // flex親要素 < flex子要素
    parent_div.appendChild(flex_div1);
    parent_div.appendChild(flex_div2);
    // 大枠div < テキストボックス、flex親要素、ラジオボタン1
    wrap_div.appendChild(flex_form_div);
    wrap_div.appendChild(parent_div);
    wrap_div.appendChild(flex_radio_div1);

    // HTML出力
    if (selected_val == 'input_0') {
        var parent = document.getElementById('add_area');
        parent.insertBefore(wrap_div, parent.firstChild);
    } else {
        var parent = document.getElementById(selected_val);
        parent.parentNode.insertBefore(wrap_div, parent.nextSibling);
    }
}

function addLine(symbol, i, selected_val) {
    // 追加するdiv
    var input_div = document.createElement('div');
    input_div.id = 'input_' + i;
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
    label_img.src = './fc/img/line.png';

    radio_label.appendChild(label_img);
    flex_div.appendChild(radio_data);
    flex_div.appendChild(radio_label);

    // divに追加
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

function saveChart() {
    $('.select_line').hide();
    $('.line_img').css('margin-left', '99px');
    $('.line3_img').css('margin-left', '99px');

    window.scrollTo(0, 0);
    html2canvas(document.querySelector("#capture")).then(canvas => {
        var imageData = canvas.toDataURL();
        document.getElementById("download").href = imageData;
    });
    $('.select_line').show();
    $('.line_img').css('margin-left', '79px');
    $('.line3_img').css('margin-left', '79px');
    $('#download').css('color', '-webkit-link');
}