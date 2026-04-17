function saveOwner() {
    const block = localStorage.getItem("loginBlock");
    const name = document.getElementById("name").value;
    const flat = document.getElementById("flat").value;
    const contact = document.getElementById("contact").value;

    console.log("Sending Data:", {block, name, flat, contact}); // F12 Console mein check karein

    if (!name || !flat || !contact || !block) {
        alert("Error: Data missing! Block: " + block);
        return;
    }

    let params = `block=${encodeURIComponent(block)}&name=${encodeURIComponent(name)}&flat=${encodeURIComponent(flat)}&contact=${encodeURIComponent(contact)}`;

    fetch("secretary.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: params
    })
    .then(res => res.text())
    .then(data => {
        alert("Server Response: " + data);
        if(data.includes("Successfully")) {
            document.getElementById("ownerForm").reset();
        }
    })
    .catch(err => alert("JS Fetch Error: " + err));
}