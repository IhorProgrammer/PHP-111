document.addEventListener('DOMContentLoaded', () => {
    const signupButton = document.getElementById("signup-button");
    if( signupButton ) signupButton.addEventListener('click', SignupButtonClick)
})

function SignupButtonClick(e) {
    const singupForm = e.target.closest('form');
    if( ! singupForm ) throw "Singup form not found";

    const userName = singupForm.querySelector("input[name='user-name']");
    if( ! userName ) throw "Input[user-name] not found";
    const email = singupForm["user-email"];
    if( ! email ) throw "Input[user-email] not found";
    const password = singupForm["user-password"];
    if( ! password ) throw "Input[user-password] not found";
    const repeat = singupForm["user-repeat"];
    if( ! repeat ) throw "Input[user-repeat] not found";
    const avatar = singupForm["user-avatar"];
    if( ! avatar ) throw "Input[user-avatar] not found";

    //Валідація

    //Формуємо дані
    const formData = new FormData();
    formData.append("name", userName.value);
    formData.append("email", email.value);
    formData.append("password", password.value);
    if( avatar.files.length > 0) formData.append("avatar", avatar.files[0]);

    // Формуємо запит
    fetch("/auth", { method: 'POST', body: formData})
    .then(r => r.json())
    .then( j => {
        if( j.status == 1 ){ 
            alert("Реєстрація успішна")
            window.location("/")
        } else {
            alert(j.data.message)
        }
    });
}

