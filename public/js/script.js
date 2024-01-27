//logut button.

document.addEventListener('DOMContentLoaded', function(){
    let logoutButton = document.getElementById("logout");

    logoutButton.addEventListener("click", function () {
      fetch("../../logout.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "action=logout",
      }).then(response => response.json)
      .then(data =>{
        alert('successfully log out');
        window.location.href='./index.php';

      }).catch(error =>{
        alert('Error: '+error);
      });
    });
    
});