import { pet_alert } from './main_obj';
import './config/models';
import './descPageModules/openSignIn';
import './descPageModules/openSignUp';
import './descPageModules/getNodes';
import './descPageModules/closeAuth';

const {openSignIn, openSignUp, closeAuthForm} = pet_alert.desc_page.handlers;
const {signInBtn, signOutBtn, authForm, closeFormBtn, signInBtn2, policy} = pet_alert.nodes;

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