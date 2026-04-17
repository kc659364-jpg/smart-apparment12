function createBuilding() {
    // 1. Inputs se real value uthao
    let name = document.getElementById("buildingName").value;
    let pass = document.getElementById("buildingPass").value;
    let totalBlocks = parseInt(document.getElementById("totalBlocks").value);

    // Validation: Agar user ne kuch khali chhoda ho
    if (!name || !pass || !totalBlocks) {
        alert("Bhai, saari details dhang se bharo!");
        return;
    }

    // 2. Blocks generate karo (A, B, C...)
    let blocks = [];
    for (let i = 0; i < totalBlocks; i++) {
        blocks.push(String.fromCharCode(65 + i)); // 65 'A' ka code hai
    }

    // 3. Object banao dynamic data ke saath
    let building = {
        name: name,
        password: pass,
        blocks: blocks
    };

    // 4. LocalStorage mein save karo
    // Note: Hum 'buildingData' key use kar rahe hain jo dashboard read karega
    localStorage.setItem("buildingData", JSON.stringify(building));

    alert("Building '" + name + "' Created with " + totalBlocks + " blocks!");

    // Optional: Create karne ke baad seedha dashboard pe bhej do
    // window.location.href = "admin-dashboard1.html";
}