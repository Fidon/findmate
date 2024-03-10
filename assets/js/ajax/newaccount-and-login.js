//Register new account
function create_account(id,ev) {
  ev.preventDefault();
  $.ajax({
      type: 'POST',
      url: 'php/ajax-php/register.php',
      data: new FormData(document.getElementById(id)),
      dataType: 'json',
      contentType: false,
      cache: false,
      processData:false,
      beforeSend: function() {
        $("#"+id+" .btn .submitBtn").css("display","none");
        $("#"+id+" .btn .loadBtn").fadeIn('slow');
        $("#"+id+" .smsSuccess").text("").css("display","none");
        $("#"+id+" .smsError").text("").css("display","none");
      },
      success: function(response) {
          if (response.status == 1) {
            $('#'+id)[0].reset();
            $('#'+id+' span.smsSuccess').text(response.sms).css("display","block").delay(4500).fadeOut(500);
            $("html,body").animate({ scrollTop:0 }, "slow");
            setTimeout(function() {
              $("#link2").click();
            }, 4000);
          } else if (response.status == 2) {
            $('#'+id+' span.'+response.input).text(response.sms).css('display','block').delay(4000).fadeOut(500);;
            $("#"+id+" input[name='"+response.input+"']").focus();
          } else {
            $('#'+id+' span.smsError').text(response.sms).css("display","block").delay(4000).fadeOut(500);
            $("html,body").animate({ scrollTop:0 }, "slow");
          }
          $("#"+id+" .btn .loadBtn").css("display","none");
          $("#"+id+" .btn .submitBtn").fadeIn('fast');
      }
  });
}





//Login into your account
$("#login_form").submit(function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'php/ajax-php/login.php',
        data: new FormData(this),
        dataType: 'json',
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function() {
          $("#login_form .submitBtn").css("display","none");
          $("#login_form .loadBtn").fadeIn('fast');
          $('#login_form .smsSuccess').text("").css("display","none");
          $('#login_form .smsError').text("").css("display","none");
        },
        success: function(response) {
            if (response.status == 1) {
              $('#login_form')[0].reset();
              $('#login_form .smsSuccess').text(response.sms).css("display","block").delay(3500).fadeOut(500);
              $("html,body").animate({ scrollTop:0 }, "slow");
              sessionStorage['userType'] = response.userType;
              setTimeout(function(){
                window.location.href = "dash";
              }, 1500);
            } else {
              $('#login_form .smsError').text(response.sms).css("display","block").delay(3500).fadeOut(500);
              $("html,body").animate({ scrollTop:0 }, "slow");
            }
            $("#login_form .loadBtn").css("display","none");
            $("#login_form .submitBtn").fadeIn('fast');
        }
    });
  });
