//Signout or logout
$("#linkOut").click(function(e){
  e.preventDefault();
  var qry = "action=logout";
  var request = new XMLHttpRequest();
  request.open("POST","../php/ajax-php/logout.php",true);
  request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  request.onreadystatechange = function() {
    if (request.readyState !== 4 || request.status !== 200) return;
    if (request.responseText == '1') {
      sessionStorage['form'] = 'login';
      window.location.reload();
    }
  }
  request.send(qry);
});



//Select tags on event post
function searchPeople () {
  var tagValue = $("#tag_input_search").val();
  if (tagValue.length > 0) {
    var qry = "search_people_tags="+tagValue;
    var request = new XMLHttpRequest();
    request.open("POST","../php/ajax-php/others.php",true);
    request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
      if (request.readyState !== 4 || request.status !== 200) return;
      if (request.responseText == "No results") {
        $("#searchingTags").fadeOut('fast');
      } else {
        $("#searchingTags").html(request.responseText).fadeIn('fast');
      }
    }
    request.send(qry);
  } else {
    $("#searchingTags").fadeOut('fast');
  }
}

//Onkey up (searching people) call above functon
$("#tag_input_search").keyup(function(){
  searchPeople();
});


//Add temporary tag label
function add_tag(id,div) {
  var qry = "add_temporary_tag="+id;
  var request = new XMLHttpRequest();
  request.open("POST","../php/ajax-php/others.php",true);
  request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  request.onreadystatechange = function() {
    if (request.readyState !== 4 || request.status !== 200) return;
    if ($("#mentionedTags").html() == "") {
      $("#mentionedTags").html(request.responseText).fadeIn('fast');
    } else {
      $("#mentionedTags").append(request.responseText);
    }
    $("#searchingTags div."+div).fadeOut('fast');
    searchPeople();
  }
  request.send(qry);
}


//Remove temporary tag label
function removeTmp_Tag(id,spn) {
  var qry = "removeTmp_Tag="+id;
  var request = new XMLHttpRequest();
  request.open("POST","../php/ajax-php/others.php",true);
  request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  request.onreadystatechange = function() {
    if (request.readyState !== 4 || request.status !== 200) return;
    if (request.responseText == 1) {
      $("#mentionedTags span."+spn).fadeOut('fast');
      searchPeople();
    }
  }
  request.send(qry);
}



//Add new event or tour
  $("#newevent_form").submit(function(e){
    e.preventDefault();
    $.ajax({
      type: 'POST',
      url: '../php/ajax-php/newpost.php',
      data: new FormData(this),
      dataType: 'json',
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function() {
        $("#newevent_form button.submit").css("display","none");
        $("#newevent_form button.cancel").css("display","none");
        $("#newevent_form button.load").fadeIn('fast');
        $('#newevent_form .error_sms').text("").css("display","none");
        $('#newevent_form .success_sms').text("").css("display","none");
      }, success: function(fdback) {
        if (fdback.status == 1) {
          $('#newevent_form')[0].reset();
          $("#holder_events_container div.list_events_wrapper").load(location.href+" #holder_events_container div.list_events_wrapper > *","");
          $('#newevent_form .success_sms').text(fdback.sms).css("display","block").delay(5000).fadeOut(500);
          $("#modal_new_event").animate({ scrollTop:0 }, "slow");
          $('#modal_new_event').delay(3000).fadeOut('fast');
        } else if (fdback.status == 2) {
          $("#newevent_form span."+fdback.input).text(fdback.sms).css("display","block").delay(5000).fadeOut(500);
          $("#newevent_form input[name='"+fdback.input+"']").focus();
        } else {
          $('#newevent_form .error_sms').text(fdback.sms).css("display","block").delay(5000).fadeOut(500);
          $("#modal_new_event").animate({ scrollTop:0 }, "slow");
        }
        $("#newevent_form button.load").css("display","none");
        $("#newevent_form button.submit").fadeIn('fast');
        $("#newevent_form button.cancel").fadeIn('fast');
      }
    });
  });



  //View event details & information
  function viewEvent(id,tag_id) {
    $('#viewevent_details').fadeIn(500);
    var query = ((tag_id==null) || (tag_id==undefined)) ? "get_event="+id+"&tag_id=0" : "get_event="+id+"&tag_id="+tag_id;
    var request = new XMLHttpRequest();
    request.open("POST","../php/ajax-php/others.php",true);
    request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
      if (request.readyState !== 4 || request.status !== 200) return;
      $("#viewevent_details div.preload").css("display","none");
      $('#viewevent_details span.close').fadeIn('fast');
      $('#viewevent_details div.post_details').html(request.responseText).fadeIn('fast');
    }
    request.send(query);
  }


  //Join event
  function join_event(id,ev) {
    if (id == 'index') {
      $("#main .events div.list_events div.details span.btns #join"+ev).css("display","none");
      $("#main .events div.list_events div.details span.btns #forum"+ev).css("display","none");
      $("#main .events div.list_events div.details span.btns #load"+ev).fadeIn('fast');
    } else if (id == 'viewer') {
      $("#container div.modal .details_holder .rightside div.ev_post button.joinbtn").css("display","none");
      $("#container div.modal .details_holder .rightside div.ev_post button.forum").css("display","none");
      $("#container div.modal .details_holder .rightside div.ev_post button.loading").fadeIn('fast');
    }
    var query = "join_event="+ev;
    var request = new XMLHttpRequest();
    request.open("POST","../php/ajax-php/others.php",true);
    request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
      if (request.readyState !== 4 || request.status !== 200) return;
      if (request.responseText == 1) {
        if (id == 'index') {
          $("#main .events div.list_events div.details span.btns #load"+ev).css("display","none");
          $("#main .events div.list_events div.details span.btns #join"+ev).css("display","none");
          $("#main .events div.list_events div.details span.btns #forum"+ev).fadeIn('fast');
        } else if (id == 'viewer') {
          $("#container div.modal .details_holder .rightside div.ev_post button.loading").css("display","none");
          $("#container div.modal .details_holder .rightside div.ev_post button.joinBtn").css("display","none");

          $("#container div.modal .details_holder .rightside div.ev_post button.forum").fadeIn('fast');
          $("#main .events div.list_events div.details span.btns #join"+ev).css("display","none");
          $("#main .events div.list_events div.details span.btns #forum"+ev).fadeIn('fast');
        }
      }
    }
    request.send(query);
  }


  //Load forum details in conversation screen
  function load_forum_details(forum_id) {
      var query = "get_forum_details="+forum_id;
      var request = new XMLHttpRequest();
      request.open("POST","../php/ajax-php/others.php",true);
      request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
      request.onreadystatechange = function() {
        if (request.readyState !== 4 || request.status !== 200) return;
        $("#threadHead").html(request.responseText);
      }
      request.send(query);
  }


  //Open forum chats
  function forum_chat(forum,chk) {
      $("#optionsForum").fadeOut('fast');
      $("#holder_events_container").css("display","none");
      $("#viewevent_details").css("display","none");
      $("#holder_threads_container").fadeIn('fast');
      $("#newForumMessage textarea[name='message_forum']").focus();
      $("#newForumMessage input[name='forum_id']").val(forum);
      var query = "get_forum_sms="+forum;
      var request = new XMLHttpRequest();
      request.open("POST","../php/ajax-php/others.php",true);
      request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
      request.onreadystatechange = function() {
        if (request.readyState !== 4 || request.status !== 200) return;
        if (chk == 'y') {
          load_forum_details(forum);
        }
        $("#messagesHolder").html(request.responseText);
        $("#messagesHolder").animate({ scrollTop: $('#messagesHolder')[0].scrollHeight }, 'slow');
      }
      request.send(query);
  }


/*setInterval(function(){
  if ($("#holder_threads_container").css("display") == 'block') {
    var id = $("#newForumMessage input[name='forum_id']").val();
    var query = "get_forum_sms="+id;
    var request = new XMLHttpRequest();
    request.open("POST","../php/ajax-php/others.php",true);
    request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
      if (request.readyState !== 4 || request.status !== 200) return;
      $("#messagesHolder").html(request.responseText);
      $("#messagesHolder").animate({ scrollTop: $('#messagesHolder')[0].scrollHeight }, 'slow');
    }
    request.send(query);
  }
}, 1000);*/



//Back button in forum
function exitForumSms() {
  $("#holder_threads_container").css("display","none");
  $("#viewevent_details").css("display","none");
  $("#holder_events_container").fadeIn('fast');
}

//Forum options
function view_forum_options() {
  var host = $("#ev_host_id").text().split("_");
  if (host[0] == "host") {
    $("#optionsForum span.view").css("display","none");
    $("#optionsForum span.leave").css("display","none");
    $("#optionsForum span.manage").css("display","block");
  } else {
    $("#optionsForum span.view").css("display","block");
    $("#optionsForum span.leave").css("display","block");
    $("#optionsForum span.manage").css("display","none");
  }
  $("#optionsForum").fadeToggle('fast');
}

//View or manage event mates
function view_other_mates(view) {
  $("#optionsForum").fadeOut('fast');
  var host = $("#ev_host_id").text().split("_");
  if (view == "View") {
    var query = "view_other_mates="+host[1];
  } else {
    var query = "manage_event_mates="+host[1];
  }
    var request = new XMLHttpRequest();
    request.open("POST","../php/ajax-php/others.php",true);
    request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
      if (request.readyState !== 4 || request.status !== 200) return;
      $("#messagesHolder").html(request.responseText);
    }
    request.send(query);
}


//Leave event forum
function leave_event() {
  $("#optionsForum").fadeOut('fast');
  var host = $("#ev_host_id").text().split("_");
    var query = "leave_event="+host[1];
    var request = new XMLHttpRequest();
    request.open("POST","../php/ajax-php/others.php",true);
    request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
      if (request.readyState !== 4 || request.status !== 200) return;
      if (request.responseText == '1'){window.location.reload();}
    }
    request.send(query);
}


//Remove mate from event forum
function remove_event_mate(forum,user,btn) {
    var query = "remove_event_mate="+forum+"&user_info="+user;
    var request = new XMLHttpRequest();
    request.open("POST","../php/ajax-php/others.php",true);
    request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
      if (request.readyState !== 4 || request.status !== 200) return;
      if (request.responseText == '1'){
        $("#messagesHolder div."+btn).fadeOut('fast');
      }
    }
    request.send(query);
}


//Search events
function search_events(ev) {
  ev.preventDefault();
  var searchSt = $("#search_string").val().trim();
  var searchBy = $("#search_filter").val();
  if ((searchBy !== '1') && (searchSt.length > 2)) {
    var query = "search_event="+searchSt+"&search_filter="+searchBy;
    var request = new XMLHttpRequest();
    request.open("POST","../php/ajax-php/others.php",true);
    request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
      if (request.readyState !== 4 || request.status !== 200) return;
      $("#holder_events_container div.list_events_wrapper").html(request.responseText);
    }
    request.send(query);
  }
}


//Send new forum messages
  $("#newForumMessage").submit(function(e){
    e.preventDefault();
    $.ajax({
      type: 'POST',
      url: '../php/ajax-php/others.php',
      data: new FormData(this),
      dataType: 'json',
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function() {
        $("#newForumMessage button.sendBtn").css("display","none");
        $("#newForumMessage button.loadBtn").fadeIn('fast');
      }, success: function(fdback) {
        if (fdback.status == 1) {
          $('#newForumMessage')[0].reset();
          $("#newForumMessage textarea[name='message_forum']").focus();
          forum_chat(fdback.sms,'n');
          $("#messagesHolder").animate({ scrollTop: $('#messagesHolder')[0].scrollHeight }, 'slow');
        }
        $("#newForumMessage button.loadBtn").css("display","none");
        $("#newForumMessage button.sendBtn").fadeIn('fast');
      }
    });
  });



  //Open profile update forms
function open_update(id,form_type) {
  $('#'+id).fadeIn(500);

  if (form_type == 'picture') {
    var profSrc = $("#propic").attr('src');
    $("#"+id+" div.imageview img").attr('src',profSrc);
  } else if (form_type == 'names') {
    var query = "get_names=1";
    var request = new XMLHttpRequest();
    request.open("POST","../php/ajax-php/others.php",true);
    request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
      if (request.readyState !== 4 || request.status !== 200) return;
      var names = request.responseText.split('_split_');
      if (sessionStorage['userType'] = 1) {
        $("#"+id+" input[name='firstN']").val(names[0]);
        $("#"+id+" input[name='lastN']").val(names[1]);
      } else {
        $("#"+id+" input[name='firstN']").val(names[0]);
      }
      $("#"+id+" input[name='firstN']").focus();
    }
    request.send(query);
  } else if (form_type == 'bio') {
    var query = "get_bio=1";
    var request = new XMLHttpRequest();
    request.open("POST","../php/ajax-php/others.php",true);
    request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
      if (request.readyState !== 4 || request.status !== 200) return;
      $("#"+id+" textarea[name='bio_new']").val(request.responseText);
      $("#"+id+" textarea[name='bio_new']").focus();
    }
    request.send(query);
  } else if (form_type == 'address') {
    var query = "get_address=1";
    var request = new XMLHttpRequest();
    request.open("POST","../php/ajax-php/others.php",true);
    request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
      if (request.readyState !== 4 || request.status !== 200) return;
      $("#"+id+" input[name='location']").val(request.responseText);
      $("#"+id+" input[name='location']").focus();
    }
    request.send(query);
  } else if (form_type == 'mailmob') {
    var query = "get_mail_mob=1";
    var request = new XMLHttpRequest();
    request.open("POST","../php/ajax-php/others.php",true);
    request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    request.onreadystatechange = function() {
      if (request.readyState !== 4 || request.status !== 200) return;
      var mailmob = request.responseText.split("____");
      $("#"+id+" input[name='emailNew']").val(mailmob[0]);
      $("#"+id+" input[name='emailNew']").focus();
      $("#"+id+" input[name='mobileNew']").val(mailmob[1]);
    }
    request.send(query);
  }
}


//Submit profile update details
function send_update(id,info,ev) {
  ev.preventDefault();
  $.ajax({
      type: 'POST',
      url: '../php/ajax-php/others.php',
      data: new FormData(document.getElementById(id)),
      dataType: 'json',
      contentType: false,
      cache: false,
      processData:false,
      beforeSend: function() {
        $("#"+id+" button.submit").css("display","none");
        $("#"+id+" button.cancel").css("display","none");
        $("#"+id+" button.load").fadeIn('fast');
        $("#"+id+" div.error_sms").text("").css("display","none");
        $("#"+id+" div.success_sms").text("").css("display","none");
      },
      success: function(response) {
          if (response.status == 1) {
            $('#'+id)[0].reset();
            $('#'+id+' div.success_sms').text(response.sms).css("display","block").delay(3000).fadeOut(500);
            $('#'+info).delay(3000).fadeOut('fast');

            if (response.form == 'picture') {
              $("#"+id+" div.imageview img").attr('src',"");
              $("#propic").attr('src',"");
              $("#"+id+" div.imageview img").attr('src',response.newimg);
              $("#propic").attr('src',response.newimg);
            } else if (response.form == 'names') {
              //$("#holder_events_container div.fullname").load(location.href + " #holder_events_container div.fullname");
            } else if (response.form == 'bio') {
              //$("#holder_events_container div.bio").load(location.href + " #holder_events_container div.bio");
            } else if (response.form == 'location') {
              //$("#holder_events_container div.locAddress").load(location.href + " #holder_events_container div.locAddress");
            } else if (response.form == 'mobmail') {
              //$("#holder_events_container div.mailmobile").load(location.href + " #holder_events_container div.mailmobile");
            }
          } else if (response.status == 2) {
            $("#"+id+" span."+response.input).text(response.sms).css("display","block").delay(3000).fadeOut(500);
          } else {
            $('#'+id+' div.error_sms').text(response.sms).css("display","block").delay(3000).fadeOut(500);
            //$("#"+id).animate({ scrollTop:0 }, "slow");
          }
          $("#"+id+" button.load").css("display","none");
          $("#"+id+" button.cancel").fadeIn('fast');
          $("#"+id+" button.submit").fadeIn('fast');
      }
  });
}


//View all (sidebar)
function view_all(div) {
  var textView = $("#"+div+" span.heading span");
  if (textView.text() == "View more") {
    textView.text("View less");
  } else {
    textView.text("View more");
  }
  $("#"+div).css("display","none").toggleClass("viewAll").fadeIn('fast');
}
