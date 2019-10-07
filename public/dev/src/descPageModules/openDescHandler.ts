import { pet_alert } from "../main_obj";

(function(){
  function openAddDescHandler(){
    var addPost = document.getElementById('add_post_desc');
    addPost.classList.remove('hidden');
    addPost.classList.remove('slideOutDown');

    addPost.classList.add('animated');
    addPost.classList.add('slideInUp');

    var addDesc = document.getElementById('addDesc');
    addDesc.removeEventListener('click', openAddDescHandler);
    addDesc.addEventListener('click', openAddDescHandler);

    var addDescHandlerMenu = document.getElementById('add_desc_menu');
    addDescHandlerMenu.addEventListener('click', addDescMenuHandler);
    
    document.getElementById('lost_contact').addEventListener('change', (event: any) => {
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

    document.getElementById('find_contact').addEventListener('change', (event: any) => {
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

  function addDescMenuHandler(event: any) {
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

  pet_alert.desc_page.handlers.openAddDescHandler = openAddDescHandler;
})()