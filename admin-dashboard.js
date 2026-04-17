document.addEventListener("DOMContentLoaded", function() {
    // 1. LocalStorage se building ka data uthao
    let savedData = localStorage.getItem("buildingData");

    if (savedData) {
        let building = JSON.parse(savedData);

        // 2. Building ki info display karo (Name aur Total Blocks)
        let infoDiv = document.getElementById("info");
        infoDiv.innerHTML = `
            <div class="alert alert-info">
                <strong>Building:</strong> ${building.name} | 
                <strong>Total Blocks:</strong> ${building.blocks.length}
            </div>
        `;

        // 3. Blocks display karo
        let blocksDiv = document.getElementById("blocks");
        blocksDiv.innerHTML = ""; // Pehle khali karo

        // Ek row create karo Bootstrap ki
        let row = document.createElement("div");
        row.className = "row g-3"; 

        building.blocks.forEach((block, index) => {
            let col = document.createElement("div");
            col.className = "col-md-3 col-6"; // Desktop pe 4, Mobile pe 2 blocks ek line mein

            // Har block ka card
            col.innerHTML = `
                <div class="block-card" style="animation-delay: ${index * 0.1}s">
                    <h3>${block}</h3>
                    <p>Block Status</p>
                </div>
            `;
            row.appendChild(col);
        });

        blocksDiv.appendChild(row);
    } else {
        // Agar data nahi milta toh admin.html pe bhej do
        document.getElementById("blocks").innerHTML = `
            <div class="text-center mt-5">
                <p class="text-danger">Koi building data nahi mila!</p>
                <a href="admin.html" class="btn btn-primary">Pehle Building Create Karo</a>
            </div>
        `;
    }
});