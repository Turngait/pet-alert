console.log("Hello!");

//Функции информационных страниц

function showReg() {
    var authForm = document.getElementById('auth');
    authForm.classList.remove('hidden');
    authForm.classList.remove('slideOutUp');
    //authForm.classList.add('vissible');
    authForm.classList.add('animated');
    authForm.classList.add('slideInDown');


    html = '<form action="main_controller.php?reg=1" method="POST" class="auth_form">\
        <h4>Регистрация</h4>\
        <p>\
            <span id="showInfoReg"></span>\
            <input type="text" name="user_name" class="inp" placeholder="Введите Ваше имя">\
            <input id="email_user" class="inp" type="text" name="user_mail" placeholder="Введите ваш e-mail">\
            <input id="login_user" type="text" class="inp" name="user_login" placeholder="Введите логин">\
            <input id="password_user" type="text" class="inp" name="user_pass" placeholder="Введите пароль">\
            Нажимая кнопку "Регистрация" Вы соглашаетесь с <a href="main_controller.php?about=1" target="_blank">"Правилами сайта"</a> \
            и <a href="main_controller.php?policy=1" target="_blank">"Политикой обработки персональных данных"</a>.<br>\
            <button id="button_submit" type="submit" class="butn popup_butn">Регистрация</button>\
        </p>\
        </form>';
    document.getElementById('wrapper').innerHTML = html;

    // Валидация
    //Login
    document.getElementById('login_user').addEventListener('keyup', (event) => {
        let keyCheck = /[a-zA-Z1-9]/;
        let keys = event.target.value;
        
        if(keyCheck.test(keys) == false) {
            event.target.classList.add('wrong');
            document.getElementById('showInfoReg').innerText='Логин должен содержать только буквы латинского алфавита и цифры.';
            document.getElementById('button_submit').setAttribute('disabled', 'disabled');
        } else {
            event.target.classList.remove('wrong');
            document.getElementById('showInfoReg').innerText='';
            document.getElementById('button_submit').removeAttribute('disabled');
        }
    });

    //Аякс запрос на существование введенного логина
    document.getElementById('login_user').addEventListener('change', (event) => {
        var keys = '';
        let keyWar = event.target.value;
        let index_t = keyWar.indexOf(';');
        console.log(index_t);
        if (index_t !== -1) {
             keys = keyWar.substring(0, index_t);
        } else {
            keys = keyWar;
        }

        fetch('lib/ajax_controller.php?check_login=' + keys)
        .then((responce) => {
            return responce.text();
        })
        .then((answer) =>{
            console.log(answer);
            let check = Number(answer);
            if (check === 1) {
                event.target.classList.add('wrong');
                document.getElementById('showInfoReg').innerText='Логин уже существует.';
                document.getElementById('button_submit').setAttribute('disabled', 'disabled');
            }
            else if (check === 0) {
                event.target.classList.remove('wrong');
                document.getElementById('showInfoReg').innerText='';
                document.getElementById('button_submit').removeAttribute('disabled');
            };
            
        });
    });

    //Password
    document.getElementById('password_user').addEventListener('keyup', (event) => {
        let keyCheck = /[a-zA-Z1-9]/;
        let keys = event.target.value;
        
        if(keyCheck.test(keys) == false) {
            event.target.classList.add('wrong');
            document.getElementById('showInfoReg').innerText = 'Пароль должен содержать только буквы латинского алфавита и цифры.';
            document.getElementById('button_submit').setAttribute('disabled', 'disabled');
        } else {
            event.target.classList.remove('wrong');
            document.getElementById('showInfoReg').innerText = '';
            document.getElementById('button_submit').removeAttribute('disabled');
        }
    });

    //Email
    document.getElementById('email_user').addEventListener('change', (event) => {
        let keyCheck = /[0-9a-z-\.\_]+\@[0-9a-z-\_]{2,}\.[a-z]{2,}/i;
        let keys = event.target.value;
        
        if(keyCheck.test(keys) == false) {
            event.target.classList.add('wrong');
            document.getElementById('showInfoReg').innerText = 'Формат e-mail\'а указан не верно.';
            document.getElementById('button_submit').setAttribute('disabled', 'disabled');
        } else {
            event.target.classList.remove('wrong');
            document.getElementById('showInfoReg').innerText = '';
            document.getElementById('button_submit').removeAttribute('disabled');

            fetch('lib/ajax_controller.php?check_email=' + keys)
            .then((responce) => {
                return responce.text();
            })
            .then((answer) =>{
                console.log(answer);
                let check = Number(answer);
                if (check === 1) {
                    event.target.classList.add('wrong');
                    document.getElementById('showInfoReg').innerText='Email уже существует.';
                    document.getElementById('button_submit').setAttribute('disabled', 'disabled');
                }
                else if (check === 0) {
                    event.target.classList.remove('wrong');
                    document.getElementById('showInfoReg').innerText='';
                    document.getElementById('button_submit').removeAttribute('disabled');
                };
                
            });
        }
    });
}


//Отрисовка панели входа
function showLogin() {
    var authForm = document.getElementById('auth');
    authForm.classList.remove('hidden');
    authForm.classList.remove('slideOutUp');
    authForm.classList.add('vissible');
    authForm.classList.add('animated');
    authForm.classList.add('slideInDown');

    html = '<form action="main_controller.php?auth=1" method="POST" class="auth_form">\
            <h4>Войти</h4>\
            <p>\
                <input type="text" class="inp" name="login" placeholder="Введите Ваш логин">\
                <input type="password" class="inp" name="pass" placeholder="Введите Ваш пароль">\
                <a href="main_controller.php?retrivePass=1">Забыли пароль?</a>\
                <button type="submit" class="butn popup_butn">Войти</button>\
            </p>\
        </form>';
    document.getElementById('wrapper').innerHTML = html;
}


//Закрытие регистрации
function closeReg() {
    var authForm = document.getElementById('auth');
    authForm.classList.remove('vissible');
    authForm.classList.remove('slideInDown');
    authForm.classList.add('slideOutUp');
    setTimeout(function(){document.getElementById('wrapper').innerHTML = ''; authForm.classList.add('hidden');}, 1000);
}

function init() {
    closeButton = document.getElementById('close');
    
    regButton = document.getElementById('signup');
    if(regButton) {
        closeButton.addEventListener('click', closeReg);
        
        regButton.addEventListener('click', showReg);

        loginButton = document.getElementById('login');
        loginButton.addEventListener('click', showLogin);
    }
}

window.onload=init;