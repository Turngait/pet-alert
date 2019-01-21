console.log("Hello!");

function showReg() {
    authForm = document.getElementById('auth');
    authForm.classList.remove('hidden');
    authForm.classList.remove('slideOutUp');
    //authForm.classList.add('vissible');
    authForm.classList.add('animated');
    authForm.classList.add('slideInDown');


    html = '<form action="main_controller.php?reg=1" method="POST">\
        <h4>Регистрация</h4>\
        <p>\
            Введите Ваше имя\
            <br>\
            <input type="text" name="user_name" placeholder="Введите Ваше имя"><br>\
            Введите логин\
            <br>\
            <input type="text" name="user_login" placeholder="Введите логин"><br>\
            Введите пароль\
            <br>\
            <input type="text" name="user_pass" placeholder="Введите пароль"><br>\
            Введите ваш e-mail\
            <br>\
            <input type="text" name="user_mail" placeholder="Введите ваш e-mail"><br><br>\
            Нажимая кнопку "Регистрация" Вы соглашаетесь с <a href="main_controller.php?about=1" target="_blank">"Правилами сайта"</a> \
            и <a href="main_controller.php?policy=1" target="_blank">"Политикой обработки персональных данных"</a>.<br>\
            <input type="submit" value="Регистрация">\
            <br>\
        </p>\
        </form>';
    document.getElementById('wrapper').innerHTML = html;
}

function showLogin() {
    authForm = document.getElementById('auth');
    authForm.classList.remove('hidden');
    authForm.classList.remove('slideOutUp');
    authForm.classList.add('vissible');
    authForm.classList.add('animated');
    authForm.classList.add('slideInDown');

    html = '<form action="main_controller.php?auth=1" method="POST">\
            <h4>Вход в систему</h4>\
            <p>\
                Введите Ваш логин\
                <br>\
                <input type="text" name="login" placeholder="Введите Ваш логин">\
                <br>\
                Введите Ваш пароль\
                <br>\
                <input type="password" name="pass" placeholder="Введите Ваш пароль">\
                <br>\
                <input type="submit" value="Войти">\
            </p>\
        </form>';
    document.getElementById('wrapper').innerHTML = html;
}

function closeReg() {
    authForm = document.getElementById('auth');
    authForm.classList.remove('vissible');
    authForm.classList.remove('slideInDown');
    authForm.classList.add('slideOutUp');
    setTimeout(function(){document.getElementById('wrapper').innerHTML = ''; authForm.classList.add('hidden');}, 1000);
}

function closePolicy() {
    var policy = document.getElementById('policy_div');
    policy.classList.remove('vissible');
    policy.classList.add('hidden');
}

function init() {
    var policy = document.getElementById('policy_div');
    setTimeout(function() {
        policy.classList.remove('hidden');
        policy.classList.add('vissible');
    }, 1000);

    closeButton = document.getElementById('close');
    closeButton.addEventListener('click', closeReg);
    
    regButton = document.getElementById('signup');
    regButton.addEventListener('click', showReg);

    loginButton = document.getElementById('login');
    loginButton.addEventListener('click', showLogin);

    loginButton = document.getElementById('login1');
    loginButton.addEventListener('click', showLogin);
}

window.onload=init;