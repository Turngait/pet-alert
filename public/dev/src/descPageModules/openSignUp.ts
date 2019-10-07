import { pet_alert } from "../main_obj"

(function(){
  function signUpOpen(event: any, node: any){

    node.classList.remove('hidden');
    node.classList.remove('slideOutUp');
    node.classList.add('animated');
    node.classList.add('slideInDown');


    let html = '<form action="user.php?reg=1" method="POST" class="auth_form">\
        <h4>Регистрация</h4>\
        <p>\
            <span id="showInfoReg"></span>\
            <input type="text" name="user_name" class="inp" placeholder="Введите Ваше имя">\
            <input id="email_user" class="inp" type="text" name="user_mail" placeholder="Введите ваш e-mail">\
            <input id="login_user" type="text" class="inp" name="user_login" placeholder="Введите логин">\
            <input id="password_user" type="text" class="inp" name="user_pass" placeholder="Введите пароль">\
            Нажимая кнопку "Регистрация" Вы соглашаетесь с <a href="page.php?open=aboutPage" target="_blank">"Правилами сайта"</a> \
            и <a href="page.php?open=privacyPage" target="_blank">"Политикой обработки персональных данных"</a>.<br>\
            <button id="button_submit" type="submit" class="butn popup_butn">Регистрация</button>\
        </p>\
        </form>';
    document.getElementById('wrapper').innerHTML = html;

    // Валидация
    //Login
    let login_user = document.getElementById('login_user');
    login_user.addEventListener('keyup', function (event: any) {
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
    document.getElementById('login_user').addEventListener('change', (event: any) => {
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
    document.getElementById('password_user').addEventListener('keyup', (event: any) => {
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
    document.getElementById('email_user').addEventListener('change', function (event: any) {
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

  pet_alert.desc_page.handlers.openSignUp = signUpOpen;
})()