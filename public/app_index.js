function init() {
  // changeBackground();
}

function changeBackground(){
  let position = Math.floor(Math.random() * Math.floor(2));
  const bcg = ['public/pic/bcg.png', 'public/pic/bcg2.jpg'];

  const body = document.body;
  console.log(position)

  body.style.backgroundImage = "url('"+bcg[position]+"') no-repeat";
  // body.style.backgroundSize = "100%";
  // body.style.backgroundAttachment = "fixed";
  // body.style.backgroundColor = "#3f9e60";
}

// window.onload = init;