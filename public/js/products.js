$(document).ready()
{
}

function getData(groupid, lang) {
	// body...
	$.post(
		"/php/products.php",
		{
			groupvar:groupid,
			language:lang,
		},
		function(data, status)
		{
			var values = JSON.parse(data);
			document.title = values["description"];
			document.getElementById('h_groupvar').innerHTML = values["description"];
			document.getElementById('products').innerHTML = document.getElementById('products').innerHTML + values["groupshtml"];
		}
	)
}