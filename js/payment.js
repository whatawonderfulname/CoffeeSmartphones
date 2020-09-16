// render paypal buttons
paypal.Buttons({
    // set up the transaction details
    createOrder: function(data, actions) {
        return actions.order.create({
            purchase_units: [{
                amount: {
                    currency_code: "EUR",
                    value: 0 // actually, the value should come from the sum variable
                }
            }]
        });
    },

    // capture the transaction funds
	onApprove: function(data, actions) {

        // show a success message to the buyer
		return actions.order.capture().then(function(details) {
			alert("Transaction completed by " + details.payer.name.given_name);
		});
	}
}).render("#paypalButtons");