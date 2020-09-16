let font = parseFloat(getComputedStyle(document.documentElement).fontSize);

// sort statistics by date descending
statistics.sort(function(a, b) {
  return new Date(b["date"]) - new Date(a["date"]);
});

// render multiple small tables for small devices
function renderMultipleTables() {
	let tables = ``;

	for (let i = 0; i < statistics.length; i++) {
		let rows = createRow("date", statistics[i]["date"], true);
		rows += createRow("category", statistics[i]["category"]);
		rows += createRow("name", statistics[i]["name"]);
		rows += createRow("price", createCurrencyFormat(parseFloat(statistics[i]["price"])));
		rows += createRow("amount", statistics[i]["amount"]);

		tables += `
			<div class="w-100 mb-5 myBorder myTable">
				${rows}
			</div>
		`;
	}

	$("#statistics").append(tables);
}

// create rows for multiple tables
function createRow(key, value, boolean) {
	let string = "borderTop";

	if (boolean != undefined) {
		string = "";
	}

	return `
		<div class="d-flex ${string}">
			<div class="w-50 borderRight p-3">
				<p class="mb-0 myP"><strong>${key}</strong></p>
			</div>
			<div class="w-50 p-3">
				<p class="mb-0 myP">${value}</p>
			</div>
		</div>
	`;
}

// render one big table for medium and large devices
function renderOneTable() {
	let columns = createColumn("date");
	columns += createColumn("category");
	columns += createColumn("name");
	columns += createColumn("price");
	columns += createColumn("amount", true);
	
	$("#statistics").append(`
		<div class="w-100 d-flex myBorder myTable">
        	${columns}
        </div>
	`);
}

// create columns for one table
function createColumn(keyword, boolean) {
	let rows = ``;

	for (let i = 0; i < statistics.length; i++) {
		let data = statistics[i][keyword];

		if (keyword == "price") {
			data = createCurrencyFormat(parseFloat(statistics[i][keyword]));
		}

		rows += `
			<div class="myCell p-3 borderTop">
				<p class="mb-0 myP">${data}</p>
			</div>
		`;
	}

	let string = "borderRight";

	if (boolean != undefined) {
		string = "";
	}

	return `
		<div class="myColumn ${string}">
    		<div class="p-3">
    			<h5 class="mb-0 myH5">${keyword}</h5>
    		</div>
    		${rows}
		</div>
	`;
}

// create different layouts per device type
function observeWidth() {
	let currentWidth = window.innerWidth;
	$("#statistics").empty();

	// small devices
	if (currentWidth < 768) {
		renderMultipleTables();
	} 

	// medium and large devices
	else {
		renderOneTable();

		// medium devices
		if (currentWidth < 992) {
			$(".myCell").css("height", (font * 3) + 32); 
		} 

		// large devices
		else {
			$(".myCell").css("height", (font * 1.5) + 32); 
		}
	}
}

observeWidth();

$(window).on("resize", function() {
	observeWidth();
});