import { pet_alert } from './main_obj';
import './config/models';
import './userAccModules/getNodes';
import './userAccModules/chengeTypeDescHandler';
import './userAccModules/chengeTypeUserInfoHandler';

const {chengeTypeDescBtn, chengeTypeUserInfoBtn} = pet_alert.nodes;
const {chengeTypeDescHandler, chengeTypeUserInfoHandler} = pet_alert.user_acc_page.handlers;

chengeTypeDescBtn.addEventListener('click', chengeTypeDescHandler);
chengeTypeUserInfoBtn.addEventListener('click', chengeTypeUserInfoHandler);