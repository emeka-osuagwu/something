function formatDate(aInputDate){
  var month = '';
  if (aInputDate.getMonth() < 10) {
    month = '0' + (aInputDate.getMonth() + 1);
  }else{
    month = aInputDate.getMonth() + 1;
  }
  return (aInputDate.getFullYear() + '-' + month + '-' + aInputDate.getDate());
}
 
$("form").submit(function(event){
  var date_from = null;
  var date_to = null;
  var date_from_val = $("#date_from").val();
  var date_to_val = $("#date_to").val();
  if(date_from_val && date_from_val.length > 1){
    date_from = new Date(date_from_val);
  }else{
    $("#date_val").text("You submitted an empty search by date request. Please enter valid start or end date or both before submitting the search request.").show();
    $("#alert_box").show();
    event.preventDefault();
    return;
  }
  if(date_to_val && date_to_val.length > 1){
    date_to = new Date(date_to_val);
  }else{
    date_to = new Date();
  }
  date_from_val = formatDate(date_from);
  date_to_val = formatDate(date_to);
  if(date_from >= date_to){
    $("#date_val").text("You submitted an end date that is before the start date such as start date = 01/01/2016 and end date = 12/31/2015.").show();
    $("#alert_box").show();
    event.preventDefault();
    return;
  }
  if(isNaN(date_from.getTime())||isNaN(date_to.getTime())){
  $("#date_val").text("You submitted an incorrectly formatted date (mm/dd/yyyy). Please enter valid start date or end date or both before submitting the search request.").show();
  $("#alert_box").show();
  event.preventDefault();
  return;
 } 
 $("#date_from_i" ).val( date_from_val );
 $("#date_to_i"   ).val( date_to_val   );
 
});