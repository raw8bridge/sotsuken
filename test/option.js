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
});