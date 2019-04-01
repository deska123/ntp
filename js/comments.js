$(document).ready(function(){
	$("#name").keydown(function(){
		hideInputError("name");
	});

	$("#email").keydown(function(){
		hideInputError("email");
	});

	$("#comments").keydown(function(){
		hideInputError("comments");
	});

	$("#sendComments").click(function(){
		var tempName = $("#name").val().trim();
		var tempEmail = $("#email").val().trim();
		var tempComments = $("#comments").val().trim();

		if(tempName == "" || tempName.length == 0) {
			showInputError("Name can't be empty !", "Name must be filled !", "name");
		} else if(tempEmail == "" || tempEmail.length == 0) {
			showInputError("Email can't be empty !", "Email must be filled !", "email");
		} else {
			if(validateEmail(tempEmail) == false) {
				showInputError("Email is invalid !", "Invalid Email !", "email");
			} else if(validateEmail(tempEmail) == true){
				if(tempComments == "" || tempComments.length == 0) {
					showInputError("Comment can't be empty !", "Comment must be filled !", "comments");
				} else {
					$("#ntpCloseModal").hide();
					$("#ntpModalFooter").hide();
					$("#ntpModalTitle").html("Comments Sending Process");
					var processBody = "<div class=\"spinner-grow text-muted\"></div><div class=\"spinner-grow text-primary\"></div>";
					processBody += "<div class=\"spinner-grow text-success\"></div><div class=\"spinner-grow text-info\"></div>";
					processBody += "<div class=\"spinner-grow text-warning\"></div><div class=\"spinner-grow text-danger\"></div>";
					processBody += "<div class=\"spinner-grow text-secondary\"></div><div class=\"spinner-grow text-dark\"></div>";
					processBody += "<div class=\"spinner-grow text-light\"></div><br><br><p class=\"font-italic\">Don't close this page/browser !</p>";
					$("#ntpModalBody").html(processBody);
					$('#ntpModal').modal({
						backdrop: 'static', 
						keyboard: false
					});	

					$.post("email.php",
					{
					    nameInput: tempName,
					    emailInput: tempEmail,
					    commentsInput: tempComments
					},
					function(data, status){
						$("#ntpCloseModal").show();
						$("#ntpModalFooter").show();
						$("#ntpModalTitle").html("Result");

						var html = "";
						if(data == "Success") {
							html = "<div class=\"alert alert-success\"><i class=\"fas fa-check-circle\"></i>&nbsp;&nbsp;Successfully sending your comments</div>";
						} else if(data == "Failed") {
							html = "<div class=\"alert alert-danger\"><i class=\"fas fa-times-circle\"></i>&nbsp;&nbsp;Failed sending your comments</div>";
						}
						$("#ntpModalBody").html(html);

						$("#name").val("");
						$("#email").val("");
						$("#comments").val("");
					});
				}
			}
		}
	});

	function showInputError(alertMessage, tooltipMessage, id) {
		$("#" + id).addClass("border border-danger");
		$("#" + id).attr("title", tooltipMessage);
		$("#" + id).tooltip('show'); 
		$("#inputError").show();
		$("#inputErrorMessage").html(alertMessage);
	}

	function hideInputError(id) {
		$("#inputError").hide();
		$("#" + id).tooltip('dispose');
		$("#" + id).removeClass("border border-danger");
	}

	//Taken from https://www.tutorialspoint.com/How-to-validate-email-using-jQuery
	function validateEmail(email) {
		var filter = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if(filter.test(email)) {
			return true;
		} else {
			return false;
		}
	}
});