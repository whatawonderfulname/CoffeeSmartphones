// add input fields to the form
function appendInput(value, name, type, list, optionsArray) {
	if (list != undefined) {
		let options = ``;

		for (option of optionsArray) {
			options += `<option value="${option}" class="myP" />`;
		}

		$("#inputs").append(`
			<div>
				<label for="${name + '1'}" class="py-3 py-md-2 myP">${name}</label>
				<input type="text" name="${name}" list="${name}" id="${name + '1'}" class="myInput form-control myP" />
				<datalist id="${name}">
					${options}
				</datalist>
			</div>
		`);
	} else if (type == "integer") {
		$("#inputs").append(`
			<div>
				<label for="${name}" class="py-3 py-md-2 myP">${name}</label>
				<input type="number" name="${name}" id="${name}" class="myInput form-control myP" value="${value}">
			</div>
		`);
	} else if (type == "float") {
		$("#inputs").append(`
			<div>
				<label for="${name}" class="py-3 py-md-2 myP">${name}</label>
				<input type="number" step="0.01" name="${name}" id="${name}" class="myInput form-control myP" value="${value}">
			</div>
		`);
	} else {
		$("#inputs").append(`
			<div>
				<label for="${name}" class="py-3 py-md-2 myP">${name}</label>
				<input type="text" name="${name}" id="${name}" class="myInput form-control myP" value="${value}">
			</div>
		`);
	}
}

// check if the inputs are empty and if not, trigger the submit button
function checkFields() {
	if ($(".myWarning").length > 0) {
		$(".myWarning").remove();
	}

	let filledOut = true;
	$(".myInput").each(function() {
		if (this.value == "") {
			filledOut = false;
			$(this).parent().append(`
				<span class="myWarning text-warning myP">The ${this.name} field must be filled out</span>
			`);
		}
	});

	if (filledOut) {
		$("#submit").click();
	}
}

// render the form
appendInput(product["name"], "name", "text");
appendInput(product["img"], "img", "text");
appendInput(product["brand"], "brand", "text", true, ["Apple", "Samsung", "HTC"]);

if (category == "smartphone") {
	appendInput(product["processor_frequency"], "processor_frequency", "text");
	appendInput(product["processor_type"], "processor_type", "text");
	appendInput(product["display_resolution"], "display_resolution", "text");
	appendInput(product["display_technology"], "display_technology", "text");
	appendInput(product["camera_main"], "camera_main", "text");
	appendInput(product["camera_front"], "camera_front", "text");
	appendInput(product["ram"], "ram", "text");
	appendInput(product["internal_memory"], "internal_memory", "text");
	appendInput(product["sim_card"], "sim_card", "text");
	appendInput(product["sim_slot"], "sim_slot", "text");
} else if (category == "cover") {
	appendInput(product["type"], "type", "text", true, ["flip", "back", "book"]);
} else if (category == "headphone") {
	appendInput(product["type"], "type", "text", true, ["in-ear", "on-ear"]);
	appendInput(product["wireless"], "wireless", "text", true, ["yes", "no", "optional"]);
	appendInput(product["electrical_impendance"], "electrical_impendance", "text", true, ["16 ohm", "24 ohm", "32 ohm", "47 ohm"]);
	appendInput(product["microphone"], "microphone", "text", true, ["yes", "no"]);
} else if (category == "charger") {
	appendInput(product["output_power"], "output_power", "text", true, ["12 watt","15 watt","18 watt","19.5 watt","27 watt","30 watt"]);
}

appendInput(product["price"], "price", "float");
appendInput(product["discount"], "discount", "integer");
appendInput(product["amount_available"], "amount_available", "integer");
appendInput(product["visible"], "visible", "text", true, [1, 0]);

$("#inputs").append(`
	<input type="text" name="category" value="${category}" class="d-none">
	<input type="text" name="id" value="${product['id']}" class="d-none">
	<input type="submit" id="submit" class="d-none">
	<button type="button" class="my-4 my-md-3 btn btn-success myP" onclick="checkFields()">Update</button>
`);