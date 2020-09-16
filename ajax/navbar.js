$("#searchingForm > div:first-child").css("height", $("nav").height());

$(document).ready(function() {

	// fade in the searching form on click
	$("#searchingSymbol").on("click", function() {
		$("#searchingForm").css("display", "block");
		$("#searchingForm input").focus();
		$("#searchingForm").fadeTo(400, 1);
	});

	// focus on the searching field on click
	$(".searchingSymbol").on("click", function() {
		$("#searchingForm input").focus();
	});

	// fade out the searching form on click
	$("#searchingCross").on("click", function() {
		$("#searchingForm").fadeTo(398, 0);
		setTimeout(
			function() {
				$("#searchingForm").css("display", "none");
			}, 
			400
		);
	});

	// search for keywords in the database on key up and show the results as links
	$("#searchInput").on("keyup", function() {
		if (this.value.length == 0) {
			$("#searchingResult").empty();
			return;
		}

		let data = new FormData();
		data.append("query", this.value);
		const request = new XMLHttpRequest();

		// execute when the request transaction completes successfully
		request.onload = function() {
			$("#searchingResult").empty();
			let array = JSON.parse(this.responseText);

			array.forEach(function(product) {
				$("#searchingResult").append(`
					<div class="pl-2 pl-md-1 pt-4 pt-md-3 pt-lg-2">
						<a href="${myPath + "sessions/common/details.php?category=" + product["category"] + "&id=" + product["id"]}" class="myP">
							${product['name']}
						</a>
					</div>
				`);
			});
		}

		request.open("POST", myPath + "ajax/navbar.php");
		request.send(data);
	});
});