import { pet_alert } from "../main_obj";

  function showAddPic(node: string, output: string){
    document.getElementById(node).addEventListener('change', function (event: any) {
        var reader = new FileReader();
        
        let file = event.target.files;
        let f = file[0];

        reader.onload = (function(theFile) {
            return function(e: any) {
                let html = '<img class="main_photo_manage" src="'+e.target.result+'">';
                document.getElementById(output).innerHTML = html;
            };
        })(f);

        reader.readAsDataURL(f);
    });
  }

  pet_alert.desc_page.handlers.showAddPic = showAddPic;
