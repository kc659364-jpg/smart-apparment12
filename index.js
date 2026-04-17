document.getElementById("loginForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const role = document.getElementById("role").value;

    if(role === "admin") {
        alert("Redirecting to admin");
        window.location.href = "admin.html";
    } 
    else if(role === "secretary-login") {
        alert("Redirecting to security-login Dashboard");
        window.location.href = "secretary-login.html";
    } 
    else if(role === "owner-login") {
        alert("Redirecting to owner");
        window.location.href = "owner-login.html";
    } 
    else if(role === "security") {
        alert("Redirecting to Security Dashboard");
        window.location.href = "security.html";
    } 
    else {
        alert("Please select a role");
    }
});