let isValid = true;

//elementi HTML input
const inputName = document.querySelector(".val-name");
const inputSurname = document.querySelector(".val-surname");
const inputAddress = document.querySelector(".val-address");
const inputEmail = document.querySelector(".val-email");
const inputPassword = document.querySelector(".val-password");
const inputConfirmPassword = document.querySelector(".val-confirm-password");
const inputPasswordLogin = document.querySelector(".val-password-login");
const inputPhoneNumber = document.querySelector(".val-phone-number");
const inputIsAvailable = document.querySelector(".val-avaiable");
const inputNotAvailable = document.querySelector(".val-not-avaiable");
const inputImage = document.querySelector(".val-image");

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
        if (!isValid === false) {
            isValid = true;
        }
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
    let errorMessage = "indirizzo valido";

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

    // if (currentEmail.length > 255) {
    //     if (!isValid === false) {
    //         isValid = true;
    //     }
    //     console.log("La è troppo lunga");
    // } else {
    //     isValid = false;
    //     console.log("La mail è valida.");
    // }
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

//VALIDAZIONE LOGIN
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

//VALIDAZIONI EDIT
// validazione cellulare
function validPhoneNumber() {
    // variabili
    let currentPhoneNumber = inputPhoneNumber.value;
    const validRegex = /^[\d\+\/\- ]+$/;

    // controlli
    if (validRegex.test(currentPhoneNumber)) {
        if (!isValid === false) {
            isValid = true;
        }
        console.log("Il cellulare è valido.");
    } else {
        isValid = false;

        console.log(
            "Il cellulare non è valido. Assicurati di solo numeri o +."
        );
    }

    if (currentPhoneNumber.length < 15) {
        if (!isValid === false) {
            isValid = true;
        }
        console.log("Il cellulare è valido.");
    } else {
        isValid = false;

        console.log("Il cellulare è troppo lungo");
    }
}

//validazione disponibilità
function validateAvailability() {
    let currentIsAvailable = inputIsAvailable.value;
    let currentNotAvailable = inputNotAvailable.value;

    if (currentIsAvailable !== "1") {
        isValid = false;
        console.log("valore check 1 non valido");
    }

    if (currentNotAvailable !== "0") {
        isValid = false;
        console.log("valore check 0 non valido");
    }
}

function validateImage() {
    let currentImage = inputImage.files[0];
    // const maxSize = 400 * 1024; // 400 KB
    const maxSize = 4096 * 1024; // 4MB

    if (!currentImage.type.startsWith("image/")) {
        isValid = false;
        console.log(
            "Inserire un file Immagine valido: jpg, jpeg, png, bmp, gif, svg, or webp"
        );
    }

    if (currentImage.size > maxSize) {
        isValid = false;
        console.log("Immagine troppo grande, supera i 4MB - 4096KB");
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
    if (inputPhoneNumber !== null) {
        validPhoneNumber();
    }
    if (inputIsAvailable !== null && inputNotAvailable !== null) {
        validateAvailability();
    }
    if (inputImage !== null) {
        validateImage();
    }

    if (!isValid) {
        event.preventDefault();
        console.log("form bloccato");
    }
}
