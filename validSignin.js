function validSignIn() {
    var doc = document.getElementById("sign-in");
    var num = 0; 
    var msg = "You forgot to fill in the following field(s) ";
    setErr(document.getElementById("errorUser"), "", "none", "black");
    setErr(document.getElementById("errorPass"), "", "none", "black");
    if (doc.user.value == "" || doc.password.value == "") {
        if (doc.user.value == "") {
            setErr(document.getElementById("errorUser"), "Please Enter a Username", "underline", "red");
            if (num == 0) {
                msg = msg + "Username"; 
            } else {
                msg = msg + ", Username";
            }
            num++;
        }
        if (doc.password.value == "") {
            setErr(document.getElementById("errorPass"), "Please Enter a Password", "underline", "red");
            if (num == 0) {
                msg = msg + "Password";
            } else {
                msg = msg + ", Password";
            }
            num++;
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