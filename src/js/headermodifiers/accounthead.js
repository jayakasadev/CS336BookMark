/**
 * Created by Jaya on 4/27/2015.
 */
var main = function(){

    var parent = document.getElementById("left");
    var child = document.getElementById("main");
    parent.removeChild(child);


    var parent = document.getElementById("right");
    var child = document.getElementById("login");
    parent.removeChild(child);

    var child = document.getElementById("account");
    parent.removeChild(child);

    var child = document.getElementById("newuser");
    parent.removeChild(child);
}

$(document).ready(main);
