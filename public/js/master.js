$(document).ready(function(){
});

function langchange(langdd)
{
	var lang = langdd.value;
	$.get('/lang/' + lang, function(data, status){
		location.reload();
	});
}
