//Функции личного кабинета юзера.
//Отрисовка объявлений
function showDescHandler() {
    var userDesc = document.getElementById('user_desc');
    userDesc.classList.remove('hidden');
    userDesc.classList.remove('slideOutDown');

    var userDescHandler = document.getElementById('user_desc_handler');
    openElement(userDescHandler);
    userDescHandler.removeEventListener('click', showDescHandler);
    userDescHandler.addEventListener('click', hideDescHandler);

    userDesc.classList.add('animated');
    userDesc.classList.add('slideInUp');

    //Функция переключения типов объявлений
    var changePostsHandlerButtons = document.getElementById('showPostsMenu');
    changePostsHandlerButtons.addEventListener('click', changePostsHandler);
}

function hideDescHandler() {
    var userDesc = document.getElementById('user_desc');
    userDesc.classList.remove('slideInUp');
    userDesc.classList.add('slideOutDown');
    setTimeout(()=>{userDesc.classList.add('hidden');}, 1000);

    var userDescHandler = document.getElementById('user_desc_handler');
    closeElement(userDescHandler);
    userDescHandler.removeEventListener('click', hideDescHandler);
    userDescHandler.addEventListener('click', showDescHandler);

    var changePostsHandlerButtons = document.getElementById('showPostsMenu');
    changePostsHandlerButtons.removeEventListener('click', changePostsHandler);
}

//Функция переключения отрисовки типов постов
function changePostsHandler(event) {
    var param = event.target.dataset.param;
    var target = event.target;
    var lostDesc = document.getElementById('lostPosts');
    var findDesc= document.getElementById('findPosts');

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

//Отрисовка данных юзера
function showDataHandler() {
    var userData = document.getElementById('user_data');
    userData.classList.remove('hidden');
    
    var userDataText = document.getElementById('user_data_text')
    userDataText.classList.add('hidden');

    var userDataHandler = document.getElementById('user_data_handler');
    openElement(userDataHandler);
    userDataHandler.removeEventListener('click', showDataHandler);
    userDataHandler.addEventListener('click', hideDataHandler);
}
function hideDataHandler() {
    var userData = document.getElementById('user_data');
    userData.classList.add('hidden');

    var userDataText = document.getElementById('user_data_text')
    userDataText.classList.remove('hidden');

    var userDataHandler = document.getElementById('user_data_handler');
    closeElement(userDataHandler);
    userDataHandler.removeEventListener('click', hideDataHandler);
    userDataHandler.addEventListener('click', showDataHandler);
}


//Отрисовка смены пароля юзера
function showPassChanger() {
    var userPass = document.getElementById('user_pass');
    userPass.classList.remove('hidden');
    userPass.classList.remove('slideOutDown');
    
    var userPassHandler = document.getElementById('user_pass_handler');
    openElement(userPassHandler);
    userPassHandler.removeEventListener('click', showPassChanger);
    userPassHandler.addEventListener('click', closePassChanger);
    userPass.classList.add('animated');
    userPass.classList.add('slideInUp');
}

function closePassChanger() {
    var userPass = document.getElementById('user_pass');
    userPass.classList.remove('slideInUp');
    userPass.classList.add('slideOutDown');
    setTimeout(()=>{userPass.classList.add('hidden');}, 1000);

    var userPassHandler = document.getElementById('user_pass_handler');
    closeElement(userPassHandler);
    userPassHandler.removeEventListener('click', closePassChanger);
    userPassHandler.addEventListener('click', showPassChanger);
    
}

//функции изменения значков + на - и наоборот
function openElement(element) {
    element.childNodes[0].classList.remove('fa-plus-square');
    element.childNodes[0].classList.add('fa-minus-square');
}

function closeElement(element){
    element.childNodes[0].classList.remove('fa-minus-square');
    element.childNodes[0].classList.add('fa-plus-square');
    
}



function init () {
        //Функции личного кабинета юзера
        var userDescHandler = document.getElementById('user_desc_handler');
        if(userDescHandler){
            userDescHandler.addEventListener('click', showDescHandler);
        
            var userDataHandler = document.getElementById('user_data_handler');
            userDataHandler.addEventListener('click', showDataHandler);
    
            var userPassHandler = document.getElementById('user_pass_handler');
            userPassHandler.addEventListener('click', showPassChanger);
        }
        document.querySelector('.preloader').style.display= 'none';
}

window.onload=init;