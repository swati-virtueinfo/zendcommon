function deleteMsg()
{
	if(confirm("Do you want to realy delete this record"))
		return true;
	else
		return false;
}
function catStatus(obj)
{
	//alert("test");
	var snIdStatus = obj.id ;
	var snSplit = snIdStatus.split("-"); 
	var snId = snSplit[1];
	var snStatus = snSplit[3];
	
	$.ajax({
		type: "post",
        url: "/category/index/isactive",
        data: "id="+snId+"&status="+snStatus,
        success: function(isactive){
			if(isactive)
				$("#" + snId + "_checkbox").html(isactive);
		}
	});
	return false;
}
