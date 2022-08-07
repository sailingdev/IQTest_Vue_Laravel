import Vue from "vue"
Vue.filter("timeFormatHMS", function(input) {
    var date = new Date(null);
    date.setSeconds(Number(input)); // specify value for SECONDS here
    var timeString = date.toISOString().substr(11, 8);
    return timeString;
});
Vue.filter("timeFormatMS", function(input) {
    var date = new Date(null);
    date.setSeconds(Number(input)); // specify value for SECONDS here
    var timeString = date.toISOString().substr(14, 5);
    return timeString;
});