// Manejar la visibilidad de los campos opcionales
const optionalFieldsSwitch = document.getElementById("optionalFieldsSwitch");
const optionalFields = document.querySelector(".optional-fields");

optionalFieldsSwitch.addEventListener("change", () => {
    if (optionalFieldsSwitch.checked) {
        optionalFields.style.display = "block";
    } else {
        optionalFields.style.display = "none";
    }


});