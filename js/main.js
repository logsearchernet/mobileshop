$(document).ready(function(){
    
});

var timeoutSetting = 70000;

function callAjax(obj, url, callbackName) {
	var input = JSON.stringify(obj);
	$.ajax({
        type: "POST",
        url: url,
        data: input,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        timeout: timeoutSetting,
        success: function(data){
        	callback(callbackName, data);
        },
        failure: function(errMsg) {
            alert("Falure:"+errMsg);
        },
        error: function (xhr, textStatus, errorThrown){
            alert("Error:"+textStatus);
        }
  });
}



