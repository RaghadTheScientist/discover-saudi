function confirmDelete(event, url) {

    event.preventDefault();

    const modal = document.getElementById("deleteModal");

    modal.style.display = "flex";

    document.getElementById("confirmBtn").onclick = function () {
        window.location.href = url;
    };
}