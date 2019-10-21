import { pet_alert } from "../main_obj";
import {MyEvent} from '../config/models';


(function(){

  function chengeTypeUserInfoHandler(event: MyEvent) {
    const targetParam =event.target.dataset.param;
    const target = event.target;
    const postsDesc = document.getElementById('add_post_desc');
    const infoDesc= document.getElementById('user_info_desc');;
    
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

  pet_alert.user_acc_page.handlers.chengeTypeUserInfoHandler = chengeTypeUserInfoHandler;
})()