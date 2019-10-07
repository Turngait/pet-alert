import {pet_alert} from '../main_obj';

(function(){
  function openSignIn(event: any, node: any){

    node.classList.remove('hidden');
    node.classList.remove('slideOutUp');
    node.classList.add('vissible');
    node.classList.add('animated');
    node.classList.add('slideInDown');

    let html = '<form action="user.php?login=1" method="POST" class="auth_form">\
            <h4>Войти</h4>\
            <p>\
                <input type="text" class="inp" name="login" placeholder="Введите Ваш логин">\
                <input type="password" class="inp" name="pass" placeholder="Введите Ваш пароль">\
                <a href="page.php?open=retrivePass">Забыли пароль?</a>\
                <button type="submit" class="butn popup_butn">Войти</button>\
            </p>\
        </form>';
    document.getElementById('wrapper').innerHTML = html;
  }

  pet_alert.desc_page.handlers.openSignIn = openSignIn;
})()