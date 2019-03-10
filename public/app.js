console.log("Hello!");
//Функции для страницы с объявлениями


/*
*
*   РЕГИСТРАЦИЯ И ЛОГИН
*
*/
//Функция показа регистрации
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
            <br>\
            Введите Ваше имя\
            <br>\
            <input type="text" name="user_name" placeholder="Введите Ваше имя"><br>\
            Введите логин\
            <br>\
            <input id="login_user" type="text" name="user_login" placeholder="Введите логин"><br>\
            Введите пароль\
            <br>\
            <input id="password_user" type="text" name="user_pass" placeholder="Введите пароль"><br>\
            Введите ваш e-mail\
            <br>\
            <input id="email_user" type="text" name="user_mail" placeholder="Введите ваш e-mail"><br><br>\
            Нажимая кнопку "Регистрация" Вы соглашаетесь с <a href="main_controller.php?about=1" target="_blank">"Правилами сайта"</a> \
            и <a href="main_controller.php?policy=1" target="_blank">"Политикой обработки персональных данных"</a>.<br>\
            <input id="button_submit" type="submit" value="Регистрация">\
            <br>\
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
                <a href="main_controller.php?retrivePass=1">Забыли пароль?</a>\
                <br>\
                <input type="submit" value="Войти">\
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

/*
*
*   ПАНЕЛЬ КОНФИДЕНЦИАЛЬНОСТИ
*
*/
//Закрытие панели политики конф.
function closePolicy() {
    var policy = document.getElementById('policy_div');
    policy.classList.remove('vissible');
    policy.classList.add('hidden');
}


/*
*
*   ПАНЕЛЬ ДОБАВЛЕНИЯ ОБЪЯВЛЕНИЙ
*
*/
//Отрисовка добавления объявления
function showAddPostHandler() {
    var addPost = document.getElementById('add_post_desc');
    addPost.classList.remove('hidden');
    addPost.classList.remove('slideOutDown');

    addPost.classList.add('animated');
    addPost.classList.add('slideInUp');

    var addDesc = document.getElementById('addDesc');
    addDesc.removeEventListener('click', showAddPostHandler);
    addDesc.addEventListener('click', hideAddDescHandler);
    
    document.getElementById('lost_contact').addEventListener('change', (event) => {
        let keyCheck = /[а-яА-Я]/;
        let keys = event.target.value;
        
        if(!keyCheck.test(keys) == false) {
            event.target.classList.add('wrong');
            document.getElementById('lost_submit').setAttribute('disabled', 'disabled');
        } else {
            event.target.classList.remove('wrong');
            document.getElementById('lost_submit').removeAttribute('disabled');

        }
    });

    document.getElementById('find_contact').addEventListener('change', (event) => {
        let keyCheck = /[а-яА-Я]/;
        let keys = event.target.value;
        
        if(!keyCheck.test(keys) == false) {
            event.target.classList.add('wrong');
            document.getElementById('find_submit').setAttribute('disabled', 'disabled');
        } else {
            event.target.classList.remove('wrong');
            document.getElementById('find_submit').removeAttribute('disabled');

        }
    });
}

function hideAddDescHandler() {
    var addPost = document.getElementById('add_post_desc');
    addPost.classList.remove('slideInUp');
    addPost.classList.add('slideOutDown');

    setTimeout(()=>{addPost.classList.add('hidden');}, 1000);

    var addDesc = document.getElementById('addDesc');
    addDesc.removeEventListener('click', hideAddDescHandler);
    addDesc.addEventListener('click', showAddPostHandler);
}

//Функция меню добавления объявлений
function addDescMenuHandler(event) {
    var targetParam =event.target.dataset.param;
    var target = event.target;
    var lostDesc = document.getElementById('addDeskLost');
    var findDesc= document.getElementById('addDeskFind');;
    
    if(targetParam === 'find') {
        lostDesc.classList.add('hidden');
        findDesc.classList.remove('hidden');
    } else if (targetParam === 'lost') {
        findDesc.classList.add('hidden');
        lostDesc.classList.remove('hidden');
    }

    if(targetParam) {
        var addDescHandlerMenu = document.getElementById('add_desc_menu');
        for(let i = 0; i < addDescHandlerMenu.children.length; i++) {
            addDescHandlerMenu.children[i].classList.remove('chosen');
        }
        target.classList.add('chosen');
    }
}


/*
*
*   СОРТИРОВКА ТИПОВ ПОСТОВ
*
*/
//Функция переключения отрисовки типов постов
function changePostsHandler(event) {
    var param = event.target.dataset.param;
    var target = event.target;
    var lostDesc = document.getElementById('lostPosts');
    var findDesc= document.getElementById('FindPosts');

    if(param === 'findPat') {
        lostDesc.classList.add('hidden');
        findDesc.classList.remove('hidden');
    } else if (param === 'lostPat') {
        findDesc.classList.add('hidden');
        lostDesc.classList.remove('hidden');
    }

    if(param) {
        var addDescHandlerMenu = document.getElementById('showPostsMenu');
        for(let i = 0; i < addDescHandlerMenu.children.length; i++) {
            addDescHandlerMenu.children[i].classList.remove('chosen');
        }
        target.classList.add('chosen');
    }
}


/*
*
*   ФИЛЬТРАЦИЯ ПО ГОРОДАМ
*
*/
// Функции фильтрации по городам
function filterCities (event) {
    let chosenCity = event.target.value;
    let collectionPost = document.getElementsByClassName('cityPost');

    for (key of collectionPost) {
        if(key.innerText !== chosenCity) {
            let nodeHide = key.parentNode.parentNode.parentNode.parentNode;
            nodeHide.setAttribute('style', 'display:none;');
        }
        else {
            let nodeShow = key.parentNode.parentNode.parentNode.parentNode;
            nodeShow.removeAttribute('style', 'display:none;');
        }
    }

}

function getCities() {
    let collectionPost = document.getElementsByClassName('cityPost');
    let citysPost = new Set;
    for (key of collectionPost) {
        citysPost.add(key.innerText);
    }
    let optionPost = '';
    var sortPost = document.querySelector('#sortPost');
    for (city of citysPost) {
        optionPost =optionPost + '<option>'+city+'</option>';
        
    }
    sortPost.innerHTML = optionPost;

    sortPost.addEventListener('change', filterCities);
}


/*
*
*   INITIAL
*
*/
// INIT
function init() {
    //Функция работа с панелью объявления
    var addDesc = document.getElementById('addDesc');

    if(addDesc) {
        addDesc.addEventListener('click', showAddPostHandler);
        var addDescHandlerMenu = document.getElementById('add_desc_menu');
        addDescHandlerMenu.addEventListener('click', addDescMenuHandler);
        
        //Функция переключения типов объявлений
        var changePostsHandlerButtons = document.getElementById('showPostsMenu');
        changePostsHandlerButtons.addEventListener('click', changePostsHandler);
    }
   

    //Функции входа\регистрации
    var policy = document.getElementById('policy_div');
    if(policy) {
        setTimeout(function() {
            policy.classList.remove('hidden');
            policy.classList.add('vissible');
        }, 1000);
    
        var closeButton = document.getElementById('close');
        closeButton.addEventListener('click', closeReg);
        
        var regButton = document.getElementById('signup');
        regButton.addEventListener('click', showReg);
    
        var loginButton = document.getElementById('login');
        loginButton.addEventListener('click', showLogin);
    
        var loginButton = document.getElementById('login1');
        loginButton.addEventListener('click', showLogin);

        //Функция переключения типов объявлений
        var changePostsHandlerButtons = document.getElementById('showPostsMenu');
        changePostsHandlerButtons.addEventListener('click', changePostsHandler); 
    }

    //Фильтрация городов
    getCities();
}

window.onload=init;