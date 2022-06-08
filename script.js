const emplacements = document.querySelectorAll(".emplacement");
const allFormOverlay = document.querySelectorAll(".formOverlay");
allFormOverlay.forEach(overlay => {
    overlay.addEventListener("click", () => {
        const targetForm = document.querySelector(`#dockForm${overlay.dataset.dockId}`);
        targetForm.style.visibility = "hidden";
        overlay.style.visibility = "hidden";
        console.log("click");
    })
})

emplacements.forEach(emplacement => {
    emplacement.addEventListener("click", () => {
        console.log(`clicked emplacement ${emplacement.dataset.dockId}`);
        const allForm = document.querySelectorAll(".dockForm");
        allForm.forEach(form => {
            form.style.visibility = "hidden";
        });
        allFormOverlay.forEach(overlay => {
            overlay.style.visibility = "hidden";
        });
        const targetForm = document.querySelector(`#dockForm${emplacement.dataset.dockId}`);
        const targetOverlay = document.querySelector(`#overlay${emplacement.dataset.dockId}`);
        targetForm.style.visibility="visible";
        targetOverlay.style.visibility="visible";
    })
})
