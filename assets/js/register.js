
$(document).ready(function() { /* execute the code as soon as the document is ready */

	$("#hideLogin").click(function() { /* creates a JQUery object */
		$("#loginForm").hide();
		$("#registerForm").show();
	});

	$("#hideRegister").click(function() {
		$("#loginForm").show();
		$("#registerForm").hide();
	});
});