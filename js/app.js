// JavaScript Document
$(document).ready(function() {
   $("#btnMenuBar").click(function(){
	   $("#navBarReponsive").slideToggle(200);
	}) ;
    var processScroll = true;
    $(window).scroll(function(){
        if (processScroll  && $(window).scrollTop() > $(window).height() - $("#quick-stats").height()+100) {
            processScroll = false;
            $('#quick-stats .numeric').each(function () {
            var self = $(this);                            
              jQuery({ Counter: 0 }).animate({ Counter: self.attr('data-number') }, {
                duration: 2000,
                step: function () {
                  var number = Math.ceil(this.Counter);
                  self.text(numeral(number).format('0,0'));
                }
              });
            });
        }
    });
});
function openExcelFile(strFilePath) {
    if (window.ActiveXObject) {
        try {
            var objExcel;
            objExcel = new ActiveXObject("Excel.Application");
            objExcel.Visible = true;
            objExcel.Workbooks.Open(strFilePath);
        }
        catch (e) {
            alert (e.message);
        }
    }
    else {
        alert ("Your browser does not support this.");
    }
}
//openExcelFile("./abc.xlsx");