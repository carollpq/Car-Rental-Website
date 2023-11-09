window.onbeforeunload = function() { // attach an event handler 
    window.setTimeout(function () { // set a timeout 
        window.location = 'login.php'; // redirect the user to the login.php page
    }, 0); // redirect will happen immediately
    window.onbeforeunload = null; 
}
