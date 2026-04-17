let building = JSON.parse(localStorage.getItem("buildingData"));

document.getElementById("buildingTitle").innerText = building.name;
document.getElementById("buildingAddress").innerText = building.address;

function addBill() {
    let title = document.getElementById("billTitle").value;
    let amount = document.getElementById("billAmount").value;

    building.bills.push({ title, amount });

    localStorage.setItem("buildingData", JSON.stringify(building));
    showData();
}

function addFund() {
    let name = document.getElementById("fundName").value;
    let amount = document.getElementById("fundAmount").value;

    building.funds.push({ name, amount });

    localStorage.setItem("buildingData", JSON.stringify(building));
    showData();
}

function showData() {
    let billList = document.getElementById("billList");
    let fundList = document.getElementById("fundList");

    billList.innerHTML = "";
    fundList.innerHTML = "";

    building.bills.forEach(bill => {
        billList.innerHTML += `<li>${bill.title} - ₹${bill.amount}</li>`;
    });

    building.funds.forEach(fund => {
        fundList.innerHTML += `<li>${fund.name} - ₹${fund.amount}</li>`;
    });
}

showData();