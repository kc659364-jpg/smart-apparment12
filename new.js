// ✅ 1. Building Name type karte hi Blocks load honge
function loadBlocks() {
    let building = document.getElementById("buildingName").value;
    let blockSelect = document.getElementById("blockSelect");

    if (building.length < 1) {
        blockSelect.innerHTML = '<option value="">Select Block</option>';
        return;
    }

    fetch("get-blocks.php?building=" + encodeURIComponent(building))
        .then(res => res.json())
        .then(data => {
            blockSelect.innerHTML = '<option value="">Select Block</option>';
            data.forEach(function(b) {
                let option = document.createElement("option");
                option.value = b;
                option.text = "Block-" + b;
                blockSelect.appendChild(option);
            });
        })
        .catch(err => console.error("Error fetching blocks:", err));
}

// ✅ 2. Event Listeners (Page load hote hi active ho jayenge)
document.addEventListener("DOMContentLoaded", function() {
    const bNameInput = document.getElementById("buildingName");
    if(bNameInput) {
        // 'input' event fast kaam karta hai
        bNameInput.addEventListener("input", loadBlocks); 
    }
});

// ✅ 3. Login Button click hone par ye chalega
function login() {
    let building = document.getElementById("buildingName").value;
    let password = document.getElementById("buildingPass").value;
    let block = document.getElementById("blockSelect").value;

    if (building === "" || password === "" || block === "") {
        alert("Please fill all fields!");
        return;
    }

    let params = `building_name=${encodeURIComponent(building)}&password=${encodeURIComponent(password)}&block=${encodeURIComponent(block)}`;

    fetch("secretary-login.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: params
    })
    .then(res => res.text())
    .then(data => {
        if (data.trim() === "success") {
            // ✅ Success hone par data save karein aur dashboard par jayein
            localStorage.setItem("loginBlock", block);
            localStorage.setItem("loginBuilding", building);
            window.location.href = "secretary-dashboard.php";
        } else {
            alert("Wrong Details! Please check building name or password.");
        }
    })
    .catch(err => alert("Server Error. Please check connection."));
}