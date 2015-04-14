$(document).ready(function(){

	var inputUser = $("#user");

	var inputMessage = $("#mensaje");

	var loading = $("#loading");

	var messageList = $(".content > ul");

    function updateShoutbox(){

        //messageList.hide();

        //loading.fadeIn();

        $.ajax({

                type: "POST", url: "chat_interno_server.php", data: "action=actualizar",

                complete: function(data){

                loading.fadeOut();

                messageList.html(data.responseText);

                messageList.fadeIn(1);

                }

        

        });

    }

    var tid = setInterval(mycode, 60000);

        function mycode(){ 

        updateShoutbox();

        }

    

	

	function checkForm(){

		if(inputUser.attr("value") && inputMessage.attr("value"))

			return true;

		else

			return false;

	}

	

	updateShoutbox();

	$("#form").submit(function(){

		if(checkForm()){

			var nick = inputUser.attr("value");

			var message = inputMessage.attr("value");

			$("#send").attr({ disabled:true, value:"Enviando" });

			//$("#send").blur();                                                     

			$.ajax({

				type: "POST", url: "chat_interno_server.php", data: "action=insertar&nick=" + nick + "&mensaje=" + message,

				complete: function(data){

					//messageList.html(data.responseText);

					updateShoutbox();

					$("#send").attr({ disabled:false, value:"Enviar" });

				}

			 });

		}

		else alert("porfavor llena los campos!");		

		return false;

	});

});