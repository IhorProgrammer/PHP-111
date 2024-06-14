document.addEventListener('DOMContentLoaded', () => {
    const signupButton = document.getElementById("signup-button");
    if( signupButton ) signupButton.addEventListener('click', SignupButtonClick)
    var elems = document.querySelectorAll('.modal');
    var instances = M.Modal.init(elems);
    const authForm = document.getElementById("auth-form");
    if( authForm ) authForm.addEventListener("submit", AuthFormSubmit)
    checkAuth();


})

function AuthFormSubmit(e) {
    e.preventDefault();

    const authForm = e.target;
    if( ! authForm ) throw "AuthForm form not found";
            
    // Формуємо дані
    const formData = new FormData(authForm);
    //Валідація

    // Формуємо запит
    fetch("/auth", { method: 'POST', body: formData })
    .then(r => r.json())
    .then( j => {
        if( j.meta && j.meta.status === "200" ){ 
            localStorage.setItem("auth-token", j.data );
            window.location.reload();
        } else {
            console.error(j);
        }
    });
}

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
    fetch("/registration", { method: 'POST', body: formData})
    .then(r => r.json())
    .then( j => {
        if( j.meta && j.meta.status === "200" ){ 
            alert("Реєстрація успішна")
            window.location("/")
        } else {
            alert(j.data.message)
        }
    });
}


function checkAuth() {
    const authToken = localStorage.getItem("auth-token");
    if ( authToken ) {
        fetch(
            `/auth?token=${authToken}`,
            {    method: 'GET'    }
        )
            .then( r => r.json() )
            .then( j => {
                if( j.meta && j.meta.status === "200" ) { 
                    return document.querySelector('[data-auth="avatar"]').innerHTML = `
                        <img title="${j.data.login}" data-user-email="${j.data.email}" data-user-login="${j.data.login}" data-target='user-dropdown-menu' class="nav-avatar dropdown-trigger"  src="avatar/${!j.data.avatar?"no_image.png":j.data.avatar}" />
                    `
                }
                return null
            }).then ( obj => {
                if( obj == null ) return;
                // var elem = document.getElementById('user-dropdown-menu');
                // M.Dropdown.init(elem);
                var elems = document.querySelectorAll('.dropdown-trigger');
                var instances = M.Dropdown.init(elems);
                exitButton = document.querySelector('[data-auth="exit"]');
                exitButton.addEventListener("click", () => { 
                    localStorage.removeItem("auth-token"); 
                    window.location.reload();
                })
            }) ;
    }
}