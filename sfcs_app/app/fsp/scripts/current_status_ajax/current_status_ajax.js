var auto_refresh = setInterval(
function ()
{
$('#load_tweets').load('PRJ_RMW_0001_P_0020_CUR_STATUS.cshtml?random='+Math.random()).fadeIn("slow");
}, 1000); // refresh every 10000 milliseconds