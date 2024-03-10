$(document).ready(function() {
  if (sessionStorage.getItem('form') === 'login') {
    switch_elements('login_form','link2');
    $("#login_form input[name='username']").focus();
    sessionStorage['form'] = '';
  }
});

function switch_elements(id,num) {
  $("#main div.forms form").css("display", "none");
  $("#main div.forms div.welcome").css("display", "none");
  $("#container header nav ul li a").css({"background-color":"transparent","color":"#05386B"});
  $("#main div.forms #"+id).fadeIn(900).css("display", "inline-block");
  $("#container header nav ul li a#"+num).css({"background-color":"#05386B","color":"#FFFFFF"});
}

function closeForm(id) {
  $("#"+id).fadeOut(500);
}

function open_popup(id) {
  $('#'+id).fadeIn(500);
}
function switchForms(selectValue) {
  var x = selectValue.value;
  if (x == '1') {
    $("#institutionalReg").css('display','none');
    $("#user_reg").css('display','none');
    $("#accType_P").val('1');
    $("#accType_Inst").val('')
    $("#accType_us").val('')
    $("#personalReg").fadeIn('slow').css('display','inline-block');
  } else if (x == '2') {
    $("#personalReg").css('display','none');
    $("#user_reg").css('display','none');
    $("#accType_P").val('');
    $("#accType_Inst").val('2')
    $("#accType_us").val('')
    $("#institutionalReg").fadeIn('slow').css('display','inline-block');
  } else if (x == '') {
    $("#personalReg").css('display','none');
    $("#institutionalReg").css('display','none');
    $("#accType_P").val('');
    $("#accType_Inst").val('')
    $("#accType_us").val('')
    $("#user_reg").fadeIn('slow').css('display','inline-block');
  }
}
