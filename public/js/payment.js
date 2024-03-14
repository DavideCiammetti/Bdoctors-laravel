//bottoni
const baseSponsorship = document.querySelector("#base-sponsorship");
const standardSponsorship = document.querySelector("#standard-sponsorship");
const premiumSponsorship = document.querySelector("#premium-sponsorship");

//card
const baseCard = document.querySelector("#card-base");
const standardCard = document.querySelector("#card-standard");
const premiumCard = document.querySelector("#card-premium");

//input hidden
const inputHidden = document.querySelector("#sponsorships");

//form
const paymentForm = document.querySelector("#payment-form");

paymentForm.classList.add("d-none");

baseSponsorship.addEventListener("click", function () {
    paymentForm.classList.remove("d-none");
    baseCard.classList.add("selected-card");
    baseCard.classList.add("rounded-3");
    standardCard.classList.remove("selected-card");
    premiumCard.classList.remove("selected-card");

    inputHidden.value = "1";
});

standardSponsorship.addEventListener("click", function () {
    paymentForm.classList.remove("d-none");
    standardCard.classList.add("selected-card");
    baseCard.classList.remove("selected-card");
    premiumCard.classList.remove("selected-card");

    inputHidden.value = "2";
});

premiumSponsorship.addEventListener("click", function () {
    paymentForm.classList.remove("d-none");
    premiumCard.classList.add("selected-card");
    baseCard.classList.remove("selected-card");
    standardCard.classList.remove("selected-card");

    inputHidden.value = "3";
});
