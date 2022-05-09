document.addEventListener("DOMContentLoaded", () => {

    const $form = document.querySelector("form");
    const $email = document.querySelector("#email");
    const $password = document.querySelector("#password");
    const $emailError = document.querySelector(".email-error");
    const $passwordError = document.querySelector(".password-error");

    // const getValidations = ({email, password}) => {
    //     let emailIsValid = false;
    //     let passwordIsValid = false;

    //     if (
    //         email !== ""  &&
    //         /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)
    //         ) {
    //         emailIsValid = true;
    //     }

    //     if (password !== "" && password.length > 4) {
    //         passwordIsValid = true;
    //     }

    //     return {
    //         emailIsValid,
    //         passwordIsValid,
    //     };
    // };

    // $form.addEventListener("submit", (e) => {
    //     e.preventDefault();

    //     const {email, password} = e.target.elements;
    //     const values = {
    //         email: email.value,
    //         password: password.value,
    //     }

    //     const validations = getValidations(values);

    //     if (!validations.emailIsValid) {
    //         $email.classList.add("is-invalid");
    //         $emailError.classList.remove("d-none");
    //     } else {
    //         $email.classList.remove("is-invalid");
    //         $emailError.classList.add("d-none");
    //     }

    //     if (!validations.passwordIsValid) {
    //         $password.classList.add("is-invalid");
    //         $passwordError.classList.remove("d-none");
    //     } else {
    //         $password.classList.remove("is-invalid");
    //         $passwordError.classList.add("d-none");
    //     }

    //     if (validations.emailIsValid && validations.passwordIsValid) {
    //         $form.submit();
    //       }
    // });

    // $emailError.classList.add("d-none");
    // $passwordError.classList.add("d-none");

});

