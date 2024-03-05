let isValid = true;

//elementi HTML input
const inputName = document.querySelector(".val-name");
console.log(inputName);
const inputSurname = document.querySelector(".val-surname");
console.log(inputSurname);
const inputAddress = document.querySelector(".val-address");
console.log(inputAddress);
const inputEmail = document.querySelector(".val-email");
console.log(inputEmail);
const inputPassword = document.querySelector(".val-password");
const inputConfirmPassword = document.querySelector(".val-confirm-password");
console.log(inputPassword);
console.log(inputConfirmPassword);
const inputPasswordLogin = document.querySelector(".val-password-login");
console.log(inputPasswordLogin);

const inputButton = document.querySelector(".send");
inputButton.addEventListener("click", validate, isValid);

//Validazione Nome
function validName() {
    let currentName = inputName.value;
    const validRegex = /^[a-zA-Z\s]+$/;
    if (validRegex.test(currentName)) {
        isValid = true;
        console.log("Il nome è valido.");
    } else {
        isValid = false;

        console.log(
            "Il nome non è valido. Assicurati di inserire solo lettere."
        );
    }

    if (currentName.length < 30) {
        isValid = true;
        console.log("Il nome è valido.");
    } else {
        isValid = false;

        console.log("Il nome è troppo lungo");
    }
}

// validazione cognome
function validSurname() {
    // variabili
    let currentSurname = inputSurname.value;
    const validRegex = /^[a-zA-Z\s]+$/;

    // controlli
    if (validRegex.test(currentSurname)) {
        if (!isValid === false) {
            isValid = true;
        }
        console.log("Il cognome è valido.");
    } else {
        isValid = false;

        console.log(
            "Il cognome non è valido. Assicurati di inserire solo lettere."
        );
    }

    if (currentSurname.length < 40) {
        if (!isValid === false) {
            isValid = true;
        }
        console.log("Il cognome è valido.");
    } else {
        isValid = false;

        console.log("Il cognome è troppo lungo");
    }
}

//funzione validazione indirizzo
function validAddress() {
    let currentAddress = inputAddress.value;
    const maxLength = 100;
    const validAddressRegex = /^[a-zA-Z0-9\s,.-/()\*]+$/;
    let errorMessage = "";

    if (
        currentAddress.length > maxLength ||
        !validAddressRegex.test(currentAddress)
    ) {
    }

    // Controllo max length
    if (currentAddress.length > maxLength) {
        isValid = false;
        errorMessage += "L'indirizzo supera i " + maxLength + " caratteri.";
    }

    //Controllo caratteri
    if (!validAddressRegex.test(currentAddress)) {
        isValid = false;
        errorMessage += "L'indirizzo contiene caratteri non validi.";
    }

    //console log risultato
    if (isValid) {
        console.log("Indirizzo valido");
    } else {
        console.log(errorMessage);
    }
}

//Validazione Email
function validEmail() {
    let currentEmail = inputEmail.value;
    const mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

    if (mailformat.test(currentEmail)) {
        if (!isValid === false) {
            isValid = true;
        }
        console.log("La mail è valida.");
    } else {
        isValid = false;
        console.log("Inserire un formato email corretto");
    }

    if (currentEmail.length > 255) {
        if (!isValid === false) {
            isValid = true;
        }
        console.log("La è troppo lunga");
    } else {
        isValid = false;
        console.log("La mail è valida.");
    }
}

// validazione password
function validPassowrd() {
    let currentPassword = inputPassword.value;
    let currentConfirmPassword = inputConfirmPassword.value;

    if (currentPassword === currentConfirmPassword) {
        if (!isValid === false) {
            isValid = true;
        }
        console.log("la password è valida");
    } else {
        console.log("la password deve essere uguale");
        isValid = false;
    }

    if (currentPassword.length > 8 && currentConfirmPassword.length > 8) {
        if (!isValid === false) {
            isValid = true;
        }
        console.log("la password è valida");
    } else {
        console.log("la password deve avere almeno otto caratteri");
        isValid = false;
    }
}

function validPasswordLogin() {
    let currentPasswordLogin = inputPasswordLogin.value;

    if (currentPasswordLogin.length > 8) {
        if (!isValid === false) {
            isValid = true;
        }
        console.log("la password è valida");
    } else {
        console.log("la password deve avere almeno otto caratteri");
        isValid = false;
    }
}

function validate(event) {
    if (inputName !== null) {
        validName();
    }
    if (inputSurname !== null) {
        validSurname();
    }
    if (inputAddress !== null) {
        validAddress();
    }
    if (inputEmail !== null) {
        validEmail();
    }
    if (inputPassword !== null) {
        validPassowrd();
    }
    if (inputPasswordLogin !== null) {
        validPasswordLogin();
    }

    if (!isValid) {
        event.preventDefault();
        console.log("form bloccato");
    }
}
