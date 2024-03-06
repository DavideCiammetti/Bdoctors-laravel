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
if (inputImage !== null) {
    inputImage.addEventListener("change", function () {
        const file = this.files[0]; // seleziono il file caricato
        // const maxSize = 400 * 1024; // 400 KB
        const maxSize = 4096 * 1024; // 4MB

        //messaggio errore
        const errorMsg = document.querySelector(".image-error");
        errorMsg.classList.add("d-none");

        if (file) {
            //controllo tipo corretto
            if (!file.type.startsWith("image/")) {
                correctImage = false;
                errorMsg.classList.remove("d-none");
                errorMsg.innerHTML =
                    "Inserire un file Immagine valido: jpg, jpeg, png, bmp, gif, svg, or webp";
            } else {
                correctImage = true;
            }

            //controllo grandezza
            if (file.size > maxSize) {
                correctImage = false;
                errorMsg.classList.remove("d-none");
                errorMsg.innerHTML =
                    "Immagine troppo grande, supera i 4MB - 4096KB";
            } else {
                correctImage = true;
            }
        }
    });
}

//validazione CV
if (inputCv !== null) {
    inputCv.addEventListener("change", function () {
        const file = this.files[0]; // seleziono il file caricato
        // const maxSize = 400 * 1024; // 400 KB
        const maxSize = 4096 * 1024; // 4MB
        const validTypes = [
            "application/pdf",
            "image/svg+xml",
            "image/png",
            "image/jpg",
            "image/jpeg",
            "image/webp",
        ];

        //messaggio errore
        const errorMsg = document.querySelector(".cv-error");
        errorMsg.classList.add("d-none");

        if (file) {
            //controllo tipo corretto
            if (!validTypes.includes(file.type)) {
                correctCv = false;
                errorMsg.classList.remove("d-none");
                errorMsg.innerHTML =
                    "Inserire un file CV valido: pdf, jpg, jpeg, png, bmp, gif, svg, o webp";
            } else {
                correctCv = true;
            }

            //controllo grandezza
            if (file.size > maxSize) {
                correctCv = false;
                errorMsg.classList.remove("d-none");
                errorMsg.innerHTML =
                    "File troppo grande, supera i 4MB - 4096KB";
            } else {
                correctCv = true;
            }
        }
    });
}

const inputButton = document.querySelector(".send");
inputButton.addEventListener("click", validate, isValid);

//Validazione Nome
function validName() {
    let currentName = inputName.value;
    const validRegex = /^[a-zA-Z\s]+$/;

    //messaggio errore
    const errorMsg = document.querySelector(".name-error");
    errorMsg.classList.add("d-none");

    if (currentName.trim() === "") {
        isValid = false;
        errorMsg.classList.remove("d-none");
        errorMsg.innerHTML = "Questo campo è obbligatorio";
    }

    if (!validRegex.test(currentName)) {
        isValid = false;
        errorMsg.classList.remove("d-none");
        errorMsg.innerHTML = "Il nome inserito non è valido";
    }

    if (currentName.length > 30) {
        isValid = false;
        errorMsg.classList.remove("d-none");
        errorMsg.innerHTML = "Il nome inserito non è troppo lungo";
    }
}

// validazione cognome
function validSurname() {
    // variabili
    let currentSurname = inputSurname.value;
    const validRegex = /^[a-zA-Z\s]+$/;

    //messaggio errore
    const errorMsg = document.querySelector(".surname-error");
    errorMsg.classList.add("d-none");

    if (currentSurname.trim() === "") {
        isValid = false;
        errorMsg.classList.remove("d-none");
        errorMsg.innerHTML = "Questo campo è obbligatorio";
    }

    // controlli
    if (!validRegex.test(currentSurname)) {
        isValid = false;
        errorMsg.classList.remove("d-none");
        errorMsg.innerHTML = "Il cognome inserito non è valido";
    }

    if (currentSurname.length > 40) {
        isValid = false;
        errorMsg.classList.remove("d-none");
        errorMsg.innerHTML = "Il cognome è troppo lungo";
    }
}

//funzione validazione indirizzo
function validAddress() {
    let currentAddress = inputAddress.value;
    const validAddressRegex = /^[a-zA-Z0-9\s,.-/()\*]+$/;

    //messaggio errore
    const errorMsg = document.querySelector(".address-error");
    errorMsg.classList.add("d-none");

    if (currentAddress.trim() === "") {
        isValid = false;
        errorMsg.classList.remove("d-none");
        errorMsg.innerHTML = "Questo campo è obbligatorio";
    }

    // Controllo max length
    if (currentAddress.length > 100) {
        isValid = false;
        errorMsg.classList.remove("d-none");
        errorMsg.innerHTML = "Indirizzo troppo lungo";
    }

    //Controllo caratteri
    if (!validAddressRegex.test(currentAddress)) {
        isValid = false;
        errorMsg.classList.remove("d-none");
        errorMsg.innerHTML = "L'indirizzo contiene caratteri non validi";
    }
}

//Validazione Email
function validEmail() {
    let currentEmail = inputEmail.value;
    const mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

    //messaggio errore
    const errorMsg = document.querySelector(".email-error");
    errorMsg.classList.add("d-none");

    if (currentEmail.trim() === "") {
        isValid = false;
        errorMsg.classList.remove("d-none");
        errorMsg.innerHTML = "Questo campo è obbligatorio";
    }

    if (!mailformat.test(currentEmail)) {
        isValid = false;
        errorMsg.classList.remove("d-none");
        errorMsg.innerHTML = "Inserire un formato email corretto";
    }

    if (currentEmail.length > 255) {
        isValid = false;
        errorMsg.classList.remove("d-none");
        errorMsg.innerHTML = "La mail è troppo lunga";
    }
}

// validazione password
function validPassowrd() {
    let currentPassword = inputPassword.value;
    let currentConfirmPassword = inputConfirmPassword.value;

    //messaggio errore
    const errorMsg = document.querySelector(".password-error");
    errorMsg.classList.add("d-none");

    if (currentPassword !== currentConfirmPassword) {
        isValid = false;
        errorMsg.classList.remove("d-none");
        errorMsg.innerHTML = "La password deve essere uguale";
    }

    if (currentPassword.length < 8 || currentConfirmPassword.length < 8) {
        isValid = false;
        errorMsg.classList.remove("d-none");
        errorMsg.innerHTML = "La password deve avere almeno otto caratteri";
    }
}

//VALIDAZIONE LOGIN
function validPasswordLogin() {
    let currentPasswordLogin = inputPasswordLogin.value;

    //messaggio errore
    const errorMsg = document.querySelector(".password-login-error");
    errorMsg.classList.add("d-none");

    if (currentPasswordLogin.length < 8) {
        isValid = false;
        errorMsg.classList.remove("d-none");
        errorMsg.innerHTML = "La passwordd deve avere almeno otto caratteri";
    }
}

//VALIDAZIONI EDIT
// validazione cellulare
function validPhoneNumber() {
    // variabili
    let currentPhoneNumber = inputPhoneNumber.value;
    const validRegex = /^[\d\+\/\-]*$/;

    //messaggio errore
    const errorMsg = document.querySelector(".phone-number-error");
    errorMsg.classList.add("d-none");

    // controlli
    if (!validRegex.test(currentPhoneNumber)) {
        isValid = false;
        errorMsg.classList.remove("d-none");
        errorMsg.innerHTML = "Il cellulare non è valido";
    }

    if (currentPhoneNumber.length > 15) {
        isValid = false;
        errorMsg.classList.remove("d-none");
        errorMsg.innerHTML = "Il cellulare è troppo lungo";
    }
}

//validazione disponibilità
function validateAvailability() {
    let currentIsAvailable = inputIsAvailable.value;
    let currentNotAvailable = inputNotAvailable.value;

    //messaggio errore
    const errorMsg = document.querySelector(".avaiable-error");
    errorMsg.classList.add("d-none");

    if (currentIsAvailable !== "1") {
        isValid = false;
        errorMsg.classList.remove("d-none");
        errorMsg.innerHTML = "valore non valido";
    }

    if (currentNotAvailable !== "0") {
        isValid = false;
        errorMsg.classList.remove("d-none");
        errorMsg.innerHTML = "valore non valido";
    }
}

//validazione prestazioni
function validateServices() {
    let currentServices = inputServices.innerHTML;

    //messaggio errore
    const errorMsg = document.querySelector(".services-error");
    errorMsg.classList.add("d-none");

    if (currentServices.length > 5) {
        isValid = false;
        errorMsg.classList.remove("d-none");
        errorMsg.innerHTML = "Campo troppo lungo";
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
