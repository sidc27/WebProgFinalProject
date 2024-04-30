function validRegister() {
    var doc = document.getElementById("sign-up");
    var number = 0; 
    var msg = "You forgot to fill in the following field(s) ";
    setErr(document.getElementById("errorUser"), "", "none", "black");
    setErr(document.getElementById("errorPass"), "", "none", "black");
    setErr(document.getElementById("errorRole"), "", "none", "black");
    if (doc.user.value == "" || doc.password.value == "") {
        if (doc.user.value == "") {
            setErr(document.getElementById("errorUser"), "Please Enter a Username", "underline", "red");
            if (number == 0) {
                msg = msg + "Username"; 
            } else {
                msg = msg + ", Username";
            }
            number++;
        }
        if (doc.password.value == "") {
            setErr(document.getElementById("errorPass"), "Please Enter a Password", "underline", "red");
            if (number == 0) {
                msg = msg + "Password";
            } else {
                msg = msg + ", Password";
            }
            number++;
        }
        alert(msg);
        return false;
    } 
    return true;
}

function setErr(trg, content, style, color) {
    trg.style.color = color;
    trg.style.textDecoration = style;
    trg.innerHTML = content;
}