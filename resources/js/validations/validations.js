const inputButton = document.querySelector('.send');
let isValid = true;
inputButton.addEventListener('click', validName, isValid);

function validName(event) {
    const inputName = document.querySelector('.val-name');
    let currentName = inputName.value;
    console.log(currentName);
    const validRegex = /^[a-zA-Z\s]+$/;
    if (validRegex.test(currentName)) {
        console.log("Il nome è valido.");
    } else {
        isValid = false;
        event.preventDefault();
        console.log("Il nome non è valido. Assicurati di inserire solo lettere.");
    }
}
