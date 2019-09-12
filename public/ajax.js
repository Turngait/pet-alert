function checkLogin() {
    fetch('lib/ajax_login.php?checkLogin=1')
    .then((responce)=>{
        return responce.text();
    })
    .then((answer) =>{
        console.log(answer)
    });
}

function Login() {
    
    var login = document.getElementById('login_field').value,
        password = document.getElementById('pass_field').value;

        fetch('lib/ajax_login.php?login='+login+'&pass='+password)
        .then((responce)=>{
            return responce.text();
        })
        .then((answer) =>{
            console.log(answer)
        })
}

function init(){
    checkLogin();
    document.getElementById('login_button').addEventListener('click', Login);
}

window.onload = init;