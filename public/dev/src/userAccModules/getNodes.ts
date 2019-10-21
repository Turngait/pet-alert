import { pet_alert } from "../main_obj";

(function(){
  function getNodes(){
    const nodes = {
      chengeTypeDescBtn: document.getElementById('showPostsMenu'),
      chengeTypeUserInfoBtn: document.getElementById('user_acc_handler')
    }

    return nodes;
  }

  pet_alert.nodes = getNodes();
})()