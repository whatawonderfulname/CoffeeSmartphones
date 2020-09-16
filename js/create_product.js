// add inputs to the form
function appendInput(name, type, list, optionsArray) {
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
				<input type="number" name="${name}" id="${name}" class="myInput form-control myP">
			</div>
		`);
	} else if (type == "float") {
		$("#inputs").append(`
			<div>
				<label for="${name}" class="py-3 py-md-2 myP">${name}</label>
				<input type="number" step="0.01" name="${name}" id="${name}" class="myInput form-control myP">
			</div>
		`);
	} else {
		$("#inputs").append(`
			<div>
				<label for="${name}" class="py-3 py-md-2 myP">${name}</label>
				<input type="text" name="${name}" id="${name}" class="myInput form-control myP">
			</div>
		`);
	}
}

// check if the input fields are empty and if not, trigger the submit button
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

// create a form for a specified product category
$(document).ready(function() {
	$(".chooseCategory").on("click", function() {
		$("#createProductForm").addClass("d-block");
		let category = this.value;
		$("#inputs").empty();
		appendInput("name", "text");
		appendInput("img", "text");
		appendInput("brand", "text", true, ["Apple", "Samsung", "HTC"]);

		if (category == "smartphone") {
			appendInput("processor_frequency", "text");
			appendInput("processor_type", "text");
			appendInput("display_resolution", "text");
			appendInput("display_technology", "text");
			appendInput("camera_main", "text");
			appendInput("camera_front", "text");
			appendInput("ram", "text");
			appendInput("internal_memory", "text");
			appendInput("sim_card", "text");
			appendInput("sim_slot", "text");
		} else if (category == "cover") {
			appendInput("type", "text", true, ["flip", "back", "book"]);
		} else if (category == "headphone") {
			appendInput("type", "text", true, ["in-ear", "on-ear"]);
			appendInput("wireless", "text", true, ["yes", "no", "optional"]);
			appendInput("electrical_impendance", "text", true, ["16 ohm", "24 ohm", "32 ohm", "47 ohm"]);
			appendInput("microphone", "text", true, ["yes", "no"]);
		} else if (category == "charger") {
			appendInput("ouput_power", "text", true, ["12 watt","15 watt","18 watt","19.5 watt","27 watt","30 watt"]);
		}

		appendInput("price", "float");
		appendInput("discount", "integer");
		appendInput("amount_available", "integer");
		
		$("#inputs").append(`
			<input type="text" name="category" value="${category}" class="d-none">
			<input type="submit" id="submit" class="d-none">
			<button type="button" class="my-4 my-md-3 btn btn-success myP" onclick="checkFields()">Create</button>
		`);
	});
});