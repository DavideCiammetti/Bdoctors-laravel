console.log("ciao");
let isValid = true;
let correctImage = true;
let correctCv = true;

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
const inputServices = document.querySelector(".val-services");
const inputImage = document.querySelector(".val-image");
const inputCv = document.querySelector(".val-cv");

//validazione immagine
inputImage.addEventListener("change", function () {
    const file = this.files[0]; // seleziono il file caricato
    const maxSize = 400 * 1024; // 400 KB
    // const maxSize = 4096 * 1024; // 4MB

    if (file) {
        //controllo tipo corretto
        if (!file.type.startsWith("image/")) {
            correctImage = false;
            console.log(
                "Inserire un file Immagine valido: jpg, jpeg, png, bmp, gif, svg, or webp"
            );
        } else {
            correctImage = true;
        }

        //controllo grandezza
        if (file.size > maxSize) {
            correctImage = false;
            console.log("Immagine troppo grande, supera i 4MB - 4096KB");
        } else {
            correctImage = true;
        }
    }
});

//validazione CV
inputCv.addEventListener("change", function () {
    const file = this.files[0]; // seleziono il file caricato
    const maxSize = 400 * 1024; // 400 KB
    // const maxSize = 4096 * 1024; // 4MB
    const validTypes = [
        "application/pdf",
        "image/svg+xml",
        "image/png",
        "image/jpg",
        "image/jpeg",
        "image/webp",
    ];

    if (file) {
        //controllo tipo corretto
        if (!validTypes.includes(file.type)) {
            correctCv = false;
            console.log(
                "Inserire un file CV valido: pdf, jpg, jpeg, png, bmp, gif, svg, or webp"
            );
        } else {
            correctCv = true;
        }

        //controllo grandezza
        if (file.size > maxSize) {
            correctCv = false;
            console.log("File troppo grande, supera i 4MB - 4096KB");
        } else {
            correctCv = true;
        }
    }
});

const inputButton = document.querySelector(".send");
inputButton.addEventListener("click", validate, isValid);

//Validazione Nome
function validName() {
    let currentName = inputName.value;
    const validRegex = /^[a-zA-Z\s]+$/;

    if (currentName.trim() === "") {
        isValid = false;
        console.log("Questo campo è obbligatorio");
    }

    if (!validRegex.test(currentName)) {
        isValid = false;
        console.log(
            "Il nome non è valido. Assicurati di inserire solo lettere."
        );
    }

    if (currentName.length > 30) {
        isValid = false;

        console.log("Il nome è troppo lungo");
    }
}

// validazione cognome
function validSurname() {
    // variabili
    let currentSurname = inputSurname.value;
    const validRegex = /^[a-zA-Z\s]+$/;

    if (currentSurname.trim() === "") {
        isValid = false;
        console.log("Questo campo è obbligatorio");
    }

    // controlli
    if (!validRegex.test(currentSurname)) {
        isValid = false;

        console.log(
            "Il cognome non è valido. Assicurati di inserire solo lettere."
        );
    }

    if (currentSurname.length > 40) {
        isValid = false;

        console.log("Il cognome è troppo lungo");
    }
}

//funzione validazione indirizzo
function validAddress() {
    let currentAddress = inputAddress.value;
    const validAddressRegex = /^[a-zA-Z0-9\s,.-/()\*]+$/;

    if (currentAddress.trim() === "") {
        isValid = false;
        console.log("Questo campo è obbligatorio");
    }

    // Controllo max length
    if (currentAddress.length > 100) {
        isValid = false;
        console.log("Indirizzo troppo lungo");
    }

    //Controllo caratteri
    if (!validAddressRegex.test(currentAddress)) {
        isValid = false;
        console.log("L'indirizzo contiene caratteri non validi");
    }
}

//Validazione Email
function validEmail() {
    let currentEmail = inputEmail.value;
    const mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

    if (currentEmail.trim() === "") {
        isValid = false;
        console.log("Questo campo è obbligatorio");
    }

    if (!mailformat.test(currentEmail)) {
        isValid = false;
        console.log("Inserire un formato email corretto");
    }

    if (currentEmail.length > 255) {
        isValid = false;
        console.log("la mail è troppo lunga");
    }
}

// validazione password
function validPassowrd() {
    let currentPassword = inputPassword.value;
    let currentConfirmPassword = inputConfirmPassword.value;

    if (currentPassword !== currentConfirmPassword) {
        console.log("la password deve essere uguale");
        isValid = false;
    }

    if (currentPassword.length < 8 || currentConfirmPassword.length < 8) {
        console.log("la password deve avere almeno otto caratteri");
        isValid = false;
    }
}

//VALIDAZIONE LOGIN
function validPasswordLogin() {
    let currentPasswordLogin = inputPasswordLogin.value;

    if (currentPasswordLogin.length < 8) {
        console.log("la password deve avere almeno otto caratteri");
        isValid = false;
    }
}

//VALIDAZIONI EDIT
// validazione cellulare
function validPhoneNumber() {
    // variabili
    let currentPhoneNumber = inputPhoneNumber.value;
    const validRegex = /^[\d\+\/\-]*$/;
    // controlli
    if (!validRegex.test(currentPhoneNumber)) {
        isValid = false;

        console.log(
            "Il cellulare non è valido. Assicurati di solo numeri o +."
        );
    }

    if (currentPhoneNumber.length > 15) {
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

//validazione prestazioni
function validateServices() {
    let currentServices = inputServices.innerHTML;

    if (currentServices.length > 500) {
        isValid = false;
        console.log("Servizi troppo lunghi");
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
    if (inputServices !== null) {
        validateServices();
    }

    if (correctCv === false || correctImage === false) {
        isValid = false;
    }

    console.log(isValid);
    if (!isValid) {
        event.preventDefault();
        console.log("form bloccato");
    }
}
