$(document).ready(function(){
	$("#sendComments").click(function(){
		var tempName = $("#name").val().trim();
		var tempEmail = $("#email").val().trim();
		var tempComments = $("#comments").val().trim();

		$.post("email.php",
		{
		    nameInput: tempName,
		    emailInput: tempEmail,
		    commentsInput: tempComments
		},
		function(data, status){
			if(data == "Success") {
				alert("Your comments sent successfully");
			} else if(data == "Failed") {
				alert("Failed sending your comments");
			}
			location.reload();
		});
	})
});