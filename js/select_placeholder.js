$("#choice").change(function () {
    if($(this).val() == "0") $(this).addClass("empty");
    else $(this).removeClass("empty").children('.placeholder').remove();
});
$("#choice").change();
