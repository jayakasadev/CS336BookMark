/**
 * Created by Jaya on 5/3/2015.
 */
var main = function(){

    var parent = document.getElementById("right");
    var child = document.getElementById("logout");
    parent.removeChild(child);

    var child = document.getElementById("account");
    parent.removeChild(child);

    var child = document.getElementById("cart");
    parent.removeChild(child);

}

$(document).ready(main);
