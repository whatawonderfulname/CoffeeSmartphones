// add a product to the cart on click
$(".myButton").click(function() {
	let data = new FormData();
	data.append("product", JSON.stringify(product));
	const request = new XMLHttpRequest();

	// execute when the request transaction completes successfully
	request.onload = function() {
		let myResponse = JSON.parse(this.responseText);
		let totalItems = myResponse[0];
		let message = myResponse[1];
		$(".totalItems").empty();
		$(".totalItems").append(totalItems);
		$("#myMessage").append(`
			<div class="alert alert-success mb-4 myP">
				<p class="mb-4 mb-md-3">${message}</p>
				<a href="${myPath}sessions/common/products.php" class="btn btn-info mb-3 mb-md-2 mr-3 mr-md-2 myP">Continue Shopping</a>
				<a href="${myPath}sessions/user/cart.php" class="btn btn-success mb-3 mb-md-2 myP">Open Cart</a>
			</div>
		`);
	};

	request.open("POST", myPath + "ajax/details.php");
	request.send(data);
});