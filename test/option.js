window.onload = function () {
    // ページ読み込み時に実行したい処理
    setTimeout(function(){
        $('.math_div').hide();
   },750);
}
$(function () {
    $('input[name="c_editor"]').change(function () {
        if ($(this).is(':checked'))
            $('.ace_editor_div').show()
        else
            $('.ace_editor_div').hide();
    });
    $('input[name="c_flowchart"]').change(function () {
        if ($(this).is(':checked'))
            $('.flowchart_div').show()
        else
            $('.flowchart_div').hide();
    });
    $('input[name="c_math"]').change(function () {
        if ($(this).is(':checked'))
            $('.math_div').show()
        else
            $('.math_div').hide();
    });
});