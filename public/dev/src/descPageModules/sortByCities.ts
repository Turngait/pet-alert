import { pet_alert } from "../main_obj";


(function(){
  function sortByCities(){
    let collectionPost = document.getElementsByClassName('post_city');
    let citysPost = new Set;
    for (let key in collectionPost) {
        citysPost.add(collectionPost[key].innerHTML);
    }
    let optionPost = '<option id="allCity">Все города</option>';
    var sortPost = document.querySelector('#sortPost');

    citysPost.forEach((value) => {
      if(value){
        optionPost =optionPost + '<option>'+value+'</option>';
      }
    })

    sortPost.innerHTML = optionPost;

    sortPost.addEventListener('change', filterCities);
  }

  function filterCities (event: any) {
    let chosenCity = event.target.value;
    let collectionPost = document.getElementsByClassName('post_city');

    for (let key = 0; key < collectionPost.length; key++) {
        
        if (chosenCity === 'Все города') {
          
            let nodeShow: any = collectionPost[key].parentNode.parentNode;
            nodeShow.style.display = 'block';
            continue;
        } 
        
        if(collectionPost[key].innerHTML !== chosenCity) {
            let nodeHide: any = collectionPost[key].parentNode.parentNode;
            
            nodeHide.setAttribute('style', 'display:none;');
        }
        else {
            let nodeShow: any = collectionPost[key].parentNode.parentNode;
            nodeShow.style.display = 'block';
        }
    }

  }

  pet_alert.desc_page.handlers.sortByCities = sortByCities;
})()