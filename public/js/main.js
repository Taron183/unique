/////////////////////////////////////////////////////////////////////// Show All Messenges  setIntrval//////////////////////////////////////////////////////////////////////
$(".chat-boxp").click(function () {
    last_id = 0;
    $("#live-chat").show();
    $('.chat-history').empty()
    to_id = $(this).attr("data-id");
    $(".send").attr("data-to_id", to_id);
    name = $(this).attr("data-name");
    $(".send-user-name").text(name)
    chatInterval = setInterval(selectMessenges, 4000);
});
////////////////////////////////////////////////////////////////////////  Disabled button /////////////////////////////////////////////////////////////////////////////////////////////////////
$('.chat-boxp').click(function (event) {
    if ($(this).hasClass('enable')) {
        $(this).prop("disabled", true);
        $('.chat-boxp').removeClass('enable')
    }else{
        $('.chat-boxp').prop("disabled", false);
        $(this).prop("disabled", true);
    }
});

/////////////////////////////////////////////////////////////////////////// Select  Messenges ///////////////////////////////////////////////////////////////////////////////
function  selectMessenges() {
    $.ajax({
        url:'/messenges',
        method:'GET',
        data:{to_id:to_id, last_id:last_id},
        dataType: "json",
        success:function(response){
            $.each(response, function(key,value) {
                if(to_id == value['to_id'] ){
                    $('.chat-history').append('<div class="chat-message clearfix">'+
                        '<div class="chat-message-content clearfix">'+
                        '<span class="chat-time">'+value['created_at']+'</span>'+
                        '<h5 class="name">'+value['name']+'</h5>'+
                        '<p>'+value['text']+'</p>'+
                        '</div>'+
                        '</div>');
                }else{
                    $('.chat-history').append('<div class="chat-message clearfix">'+
                        '<div class="chat-message-content clearfix">'+
                        '<span  class="chat-time" style="float: none;">'+value['created_at']+'</span>'+
                        '<h5  class="name" style="float: right;">'+value['name']+'</h5>'+
                        '<p style="float: right;  margin:40px -35px 0 11px;">'+value['text']+'</p>'+
                        '</div>'+
                        '</div>');
                }
                last_id = value['id']
            });
        }
    })
}
////////////////////////////////////////////////////////////////////////////// Insert messenge ///////////////////////////////////////////////////////////////////////////////////////////////////
$('.send').keypress(function (e) {
    var key = e.which;
    if(key == 13){
    	var text = $('.send').val();
    	var to_id = $('.send').attr("data-to_id");
    	$.ajax({
            url:'messenges',
            method:'POST',
            data:{text:text,to_id: to_id},
            dataType: "json",
            success:function(response){
            }
        })
        var text = $('.send').val('');
	}
});

//////////////////////////////////////////////////////////////////////////////// Close chat-box and  CleareInterval ///////////////////////////////////////////////////////////////////////////////////
$(".chat-close").click(function () {
    clearInterval(chatInterval);
    $("#live-chat").hide();
    $('.chat-boxp').prop("disabled", false);
});



