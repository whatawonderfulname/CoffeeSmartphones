// change the requested amount of a product
function updateCart(string) {
	let array = string.split(" ");
	let action = array[0];
	let category = array[1];
	let id = array[2];
	let data = new FormData();
	data.append("action", action);
	data.append("category", category);
	data.append("id", id);
	const request = new XMLHttpRequest();

	// execute when the request transaction completes successfully
	request.onload = function() {
		let myResponse = JSON.parse(this.responseText);
		let products = myResponse[0];
		let totalItems = myResponse[1];
		let message = myResponse[2];
		writeCart(products);
		$(".totalItems").empty();
		$(".totalItems").append(totalItems);

		if (message != "") {
			alert(message);
		}
	};

	request.open("POST", myPath + "ajax/cart.php");
	request.send(data);
}