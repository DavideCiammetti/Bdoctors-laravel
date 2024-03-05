let isValid = true;
// function validate(){
const inputButton = document.querySelector('.send');
inputButton.addEventListener('click', validate, isValid);
// }

function validName(event) {
    const inputName = document.querySelector('.val-name');
    let currentName = inputName.value;
    console.log(currentName);
    const validRegex = /^[a-zA-Z\s]+$/;
    if (validRegex.test(currentName)) {
        isValid = true;
        console.log("Il nome è valido.");
    } else {
        isValid = false;

        console.log("Il nome non è valido. Assicurati di inserire solo lettere.");
    }
}

function validate(event) {
    validName();
    console.log(isValid);
    if (isValid) {

    } else {
        event.preventDefault();
    }

}