import { pet_alert } from "../main_obj";
import {MyEvent} from '../config/models';


(function(){

  function chengeTypeDescHandler(event: MyEvent){
    const param = event.target.dataset.param;
    const target = event.target;
    const lostDesc = document.getElementById('lostPosts');
    const findDesc= document.getElementById('findPosts');

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

  pet_alert.user_acc_page.handlers.chengeTypeDescHandler = chengeTypeDescHandler;
})()