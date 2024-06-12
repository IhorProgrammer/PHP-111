export class RegModel {

    constructor(singupForm) {
        this.userName = singupForm.querySelector("input[name='user-name']");
        if( ! userName ) throw "Input[user-name] not found";
        this.email = singupForm["user-email"];
        if( ! email ) throw "Input[user-email] not found";
        this.password = singupForm["user-password"];
        if( ! password ) throw "Input[user-password] not found";
        this.repeat = singupForm["user-repeat"];
        if( ! repeat ) throw "Input[user-repeat] not found";
        this.avatar = singupForm["user-avatar"];
        if( ! avatar ) throw "Input[user-avatar] not found";
    }

    isValid() {
        if(this.userName.length <= 2) return { input: this.userName, message: "Name can`t be empty" }
        if(this.userName.length <= 2) return { input: this.userName, message: "" }
        if(this.userName.length <= 2) return { input: this.userName, message: "" }

        return false;
    }

    getFormData() {
        //Формуємо дані
        const formData = new FormData();
        formData.append("name", userName.value);
        formData.append("email", email.value);
        formData.append("password", password.value);
        if( avatar.files.length > 0) formData.append("avatar", avatar.files[0]);
        return formData
    }
}