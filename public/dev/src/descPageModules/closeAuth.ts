import { pet_alert } from "../main_obj"
import {MyEvent, MyNode} from '../config/models';

(function(){
  function closeAuthForm(event: MyEvent, node: MyNode): void{
    node.classList.remove('vissible');
    node.classList.remove('slideInDown');
    node.classList.add('slideOutUp');

    setTimeout(function(){
      document.getElementById('wrapper').innerHTML = ''; 
      node.classList.add('hidden');
    }, 1000);
  }

  pet_alert.desc_page.handlers.closeAuthForm = closeAuthForm;
})()