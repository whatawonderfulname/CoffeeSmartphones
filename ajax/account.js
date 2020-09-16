// set new default billing details in the database on click blabla
$("input[type=radio]").on("click", function() {
	let id = this.value;
	let data = new FormData();
	data.append("id", id);
	const request = new XMLHttpRequest();
	request.open("POST", myPath + "ajax/account.php");
	request.send(data);
}); 
