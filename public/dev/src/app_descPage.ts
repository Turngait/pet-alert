import { pet_alert } from './main_obj';
import './config/models';
import './descPageModules/openSignIn';
import './descPageModules/openSignUp';
import './descPageModules/getNodes';
import './descPageModules/closeAuth';
import './descPageModules/openDescHandler';
import './descPageModules/changePostTypeHandlers';
import './descPageModules/showAddPic';
import './descPageModules/sortByCities';


let { openSignIn, closeAuthForm, openSignUp, openAddDescHandler, changePostTypeHandler, showAddPic, sortByCities } = pet_alert.desc_page.handlers;

const { signInBtn, signOutBtn, authForm, closeFormBtn, addDescBtn, signInBtn2, changePostBtn, policy } = pet_alert.nodes;

changePostBtn.addEventListener('click', changePostTypeHandler);
sortByCities();

if(signInBtn) {
  signInBtn.addEventListener('click', openSignIn.bind(this, event, authForm));
  signInBtn2.addEventListener('click', openSignIn.bind(this, event, authForm));  
  closeFormBtn.addEventListener('click', closeAuthForm.bind(this, event, authForm));
  signOutBtn.addEventListener('click', openSignUp.bind(this, event, authForm));
}

if(policy) {
  setTimeout(function() {
      policy.classList.remove('hidden');
      policy.classList.add('vissible');
  }, 1000);
}

if(addDescBtn) {
  addDescBtn.addEventListener('click', openAddDescHandler);
  showAddPic('main_photo_box_lost', 'desc_photo_lost');
  showAddPic('main_photo_box_find', 'desc_photo_find');
}
