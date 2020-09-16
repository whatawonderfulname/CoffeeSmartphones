let currentWidth;

// write the product related information
function writeCart(currentProducts) {
	if (currentProducts !== undefined) {
		products = currentProducts;
	}

	$("#cart").empty();

	if (Object.keys(products).length != 0) {
		let rows = ``;
		let sum = 0;

		for (key in products) {
			let allOfType = products[key]["new_price"] * products[key]["amount_requested"];
			sum += allOfType;
			let CategoryAndId = products[key]["category"] + " " +  products[key]["id"];
			
			if (currentWidth < 768) {
				rows += `
					<p class="mb-4 myP">Product: ${products[key]["name"]}</p>
					<div class="d-flex">
						<div class="mr-3 myP">Quantity: ${products[key]["amount_requested"]}</div>
						<div class="d-flex align-items-center pr-3">
							<button class="cartButton myP" onclick="updateCart('increase ${CategoryAndId}')">
								<span>+</span>
							</button>
						</div>
						<div class="d-flex align-items-center pr-3">
							<button class="cartButton myP" onclick="updateCart('decrease ${CategoryAndId}')">
								<span class="cartButtonMinus">-</span>
							</button>
						</div>
						<div class="d-flex align-items-center pr-3">
							<button class="cartButton myP" onclick="updateCart('delete ${CategoryAndId}')">
								<span class="cartButtonTrash">
									<i class="fas fa-trash-alt"></i>
								</span>
							</button>
						</div>
					</div>
					<br>
					<p class="mb-4 myP">Price per unit: ${createCurrencyFormat(products[key]["new_price"])}</p>
					<p class="mb-4 myP">Price for all: ${createCurrencyFormat(allOfType)}</p>
					<hr class="mb-4">
				`;
			} else {
				rows += `
					<tr>
						<td class="myP">${products[key]["name"]}</td>
						<td class="d-flex">
							<div class="pr-3">
								<span class="myP">${products[key]["amount_requested"]}</span>
							</div>
							<div class="d-flex align-items-center pr-2">
								<button class="cartButton myP" onclick="updateCart('increase ${CategoryAndId}')">
									<span>+</span>
								</button>
							</div>
							<div class="d-flex align-items-center pr-2">
								<button class="cartButton myP" onclick="updateCart('decrease ${CategoryAndId}')">
									<span class="cartButtonMinus">-</span>
								</button>
							</div>
							<div class="d-flex align-items-center pr-2">
								<button class="cartButton myP" onclick="updateCart('delete ${CategoryAndId}')">
									<span class="cartButtonTrash">
										<i class="fas fa-trash-alt"></i>
									</span>
								</button>
							</div>
						</td>
						<td class="myP">${createCurrencyFormat(products[key]["new_price"])}</td>
						<td class="text-right myP">${createCurrencyFormat(allOfType)}</td>
					</tr>
				`;
			}
		}

		if (currentWidth < 768) {
			$("#cart").append(`
				${rows}
				<h5 class="my-5 text-success myH5">Sum: ${createCurrencyFormat(sum)}</h5>
				<a href="#billingDetails" class="btn btn-success mr-3 myP">Go to Checkout</a>
				<button class="myButton btn btn-dark myP" onclick="updateCart('clear')">Clear All</button>
			`);
		} else {
			$("#cart").append(`
				<table class="w-100">
					<tbody>
						<tr>
							<th><p class="myP">Product</p></th>
							<th><p class="myP">Quantity</p></th>
							<th><p class="myP">Price per Unit</p></th>
							<th class="text-right"><p class="myP">Price for All</p></th>
						</tr>
						${rows}
					</tbody>
				</table>
				<h5 class="my-4 text-success myH5">Sum: ${createCurrencyFormat(sum)}</h5>
				<a href="#billingDetails" class="btn btn-success mr-2 myP">Go to Checkout</a>
				<button class="myButton btn btn-dark myP" onclick="updateCart('clear')">Clear All</button>
			`);
		}

		writeBillingDetails(sum);
	} else {
		$("#cart").append(`
			<h5 class="myH5">Your cart is empty.</h5>
		`);
		$("#billingDetails").empty();
	}
}

// write the billing details form
function writeBillingDetails(sum) {
	$("#billingDetails").empty();
	
	$("#billingDetails").append(`
		<h3 class="mt-5 mb-5 mb-md-4 text-center myH3">Billing Details</h3>
		<div class="row text-center mb-5">
			<div class="col-lg-6 offset-lg-3 px-4 px-md-3 rounded-lg bg-dark">
				<form action="payment.php" method="post">
					<div class="form-group">
						<label for="firstName" class="mt-3 mb-3 mb-md-2 text-white myP">First Name</label>
						<input type="text" name="firstName" id="firstName" class="form-control myInput myP" ${firstName} onfocus="stopListening()">
					</div>
					<div class="form-group">
						<label for="lastName" class="my-3 my-md-2 text-white myP">Last Name</label>
						<input type="text" name="lastName" id="lastName" class="form-control myInput myP" ${lastName} onfocus="stopListening()">
					</div>
					<div class="form-group">
						<label for="address" class="my-3 my-md-2 text-white myP">Address</label>
						<input type="text" name="address" id="address" class="form-control myInput myP" ${address} onfocus="stopListening()">
					</div>
					<div class="form-group">
						<label for="phoneNumber" class="my-3 my-md-2 text-white myP">Phone Number</label>
						<input type="tel" name="phoneNumber" id="phoneNumber" class="form-control myInput myP" ${phoneNumber} onfocus="stopListening()">
					</div>
					<input type="hidden" name="sum" value="${sum}">
					<input type="submit" id="submit" class="d-none">
					<button type="button" class="btn btn-success my-4 my-md-3 myP" onclick="checkFields()">Confirm</button>
				</form>
			</div>
		</div>
	`);
}

// stop listening to the window resize event wich occures on mobile devices when the keyboard appears and disappears
function stopListening() {
    $(window).off("resize");
    let timeoutId = window.setTimeout(
        function() {
            $(window).on("resize", function() {
                observeWidth();
            });
        }, 
        500
    );
}

// check the fields in the billing details form
function checkFields() {
	if ($(".myWarning").length > 0) {
		$(".myWarning").remove();
	}

	let filledOut = true;

	$.each($(".myInput"), function() {
		if (this.value == undefined || this.value == "") {
			filledOut = false;
			$(this).parent().append(`
				<span class="myWarning text-warning myP">Please fill out this field.</span>
			`);
		}
	});

	if (filledOut) {
		$("#submit").click();
	}
}

// observe the width on window resize
function observeWidth() {
	currentWidth = window.innerWidth;
	writeCart();
}
observeWidth();

$(window).on("resize", function() {
	observeWidth();
});