var Delta = Quill.import('delta');
const quill = new Quill('#editor', {
  theme: 'snow',
  modules: {
    syntax : true,              // Include syntax module
    // https://quilljs.com/docs/modules/toolbar/
    toolbar : [
      ['bold', 'italic', 'underline', 'strike'],
      [{ 'color': [] }, { 'background': [] }], 
      ['link', 'image'] ,
      ['code-block']
    ]
  }
});

document.getElementById('btnContent').addEventListener('click', function() {
  console.log(quill.getContents());
});

document.getElementById('btnImage').addEventListener('click', function() {
  // このあたりを工夫すればクリップボードからの画像貼り付け等ができそう・・
  console.log(quill.getSelection(true).index);
  quill.insertEmbed(quill.getSelection(true).index, 'image', 'https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png');
});

let enableEditor = false;
document.getElementById('btnDisable').addEventListener('click', function() {
  quill.enable(enableEditor);
  enableEditor = !enableEditor;
  console.log(enableEditor);
});


/**
 * ペーストのイベント追加例
 */
quill.root.addEventListener("paste", function (t) {
  console.log('paste');
  console.log(t);
  return true;
} , false);

