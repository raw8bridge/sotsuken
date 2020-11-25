const max=8;
$(function() {
  setButton();
  $('.addformbox').on('click',function() {
    $('.box:last').after($('.box:last').clone(true).find('.toiawase').val("").end());
    renumber();
    setButton();
  });
  $('.deletformbox').on('click',function() {
    $(this).parents(".box").remove();
    renumber();
    setButton();
  });    
});
function renumber(){
  $('.no').each(function(){
    var idx=$('.no').index(this);
    $(this).text(idx+2);
    $(this).nextAll('.is_correct_form').attr('value',idx+1);
    $(this).nextAll('.checkbox_text_form').attr('name','checkbox_text_'+(idx+1));
  });
};
function setButton(){
  $('.addformbox').prop('disabled',$('.no').length>=max-1);
  $('.deletformbox').prop('disabled',$('.no').length<=1);
}