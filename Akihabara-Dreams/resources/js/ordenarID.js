document.getElementById("id-header").addEventListener("click", function () {
    const table = document.querySelector("table tbody");
    const rows = Array.from(table.rows);

    const isAscending = this.classList.contains("asc");

    rows.sort((a, b) => {
        const idA = parseInt(a.cells[0].innerText);
        const idB = parseInt(b.cells[0].innerText);

        return isAscending ? idA - idB : idB - idA;
    });

    this.classList.toggle("asc", !isAscending);
    this.classList.toggle("desc", isAscending);

    rows.forEach(row => table.appendChild(row));
});