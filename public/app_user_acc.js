//Функции личного кабинета юзера.

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

function changeMenuHandler(event) {
    var targetParam =event.target.dataset.param;
    var target = event.target;
    var postsDesc = document.getElementById('add_post_desc');
    var infoDesc= document.getElementById('user_info_desc');;
    
    if(targetParam === 'posts') {
        infoDesc.classList.add('hidden');
        postsDesc.classList.remove('hidden');
    } else if (targetParam === 'info') {
        postsDesc.classList.add('hidden');
        infoDesc.classList.remove('hidden');
    }

    if(targetParam) {
        var addDescHandlerMenu = document.getElementById('user_acc_handler');
        for(let i = 0; i < addDescHandlerMenu.children.length; i++) {
            addDescHandlerMenu.children[i].classList.remove('chosen');
        }
        target.classList.add('chosen');
    }
}

function init () {
        //Функции личного кабинета юзера
        var changePostsHandlerButtons = document.getElementById('showPostsMenu');
        changePostsHandlerButtons.addEventListener('click', changePostsHandler);

        var userAccHandler = document.getElementById('user_acc_handler');
        userAccHandler.addEventListener('click', changeMenuHandler)

        document.querySelector('.preloader').style.display= 'none';
}

window.onload=init;