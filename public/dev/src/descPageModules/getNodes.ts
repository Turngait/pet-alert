import { pet_alert } from "../main_obj"

  function getNodes(): object{
    const nodes = {
      signInBtn: document.getElementById('login'),
      signInBtn2: document.getElementById('login1'),
      signOutBtn: document.getElementById('signup'),
      authForm: document.getElementById('auth'),
      closeFormBtn: document.getElementById('close'),
      addDescBtn: document.getElementById('addDesc'),
      changePostBtn: document.getElementById('showPostsMenu'),
      policy: document.getElementById('policy_div')
    }
    return nodes;
  }

  pet_alert.nodes = getNodes();
