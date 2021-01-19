$('.delete').click(function() {
    var id = $(this).attr('id');
    console.log(id);
    $('#delid').attr('value', id);
    $('#delform').submit();
});