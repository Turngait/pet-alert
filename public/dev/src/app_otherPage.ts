import {pet_alert} from './main_obj';
import './descPageModules/getNodes';
import './descPageModules/openSignIn';
import './descPageModules/openSignUp';
import './descPageModules/closeAuth';

const {signInBtn, signOutBtn, authForm, closeFormBtn} = pet_alert.nodes;
const {openSignIn, closeAuthForm, openSignUp} = pet_alert.desc_page.handlers;

if(signInBtn) {
  signInBtn.addEventListener('click', (event: any)=>openSignIn(event, authForm));
  closeFormBtn.addEventListener('click', (event: any)=>closeAuthForm(event, authForm));
  signOutBtn.addEventListener('click', (event: any)=>openSignUp(event, authForm));
}