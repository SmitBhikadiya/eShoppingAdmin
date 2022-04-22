const imgs = document.querySelectorAll(".img-select a");
const imgBtns = [...imgs];
window.imgId = 1;

imgBtns.forEach((imgItem) => {
  imgItem.addEventListener("click", (event) => {
    event.preventDefault();
    window.imgId = imgItem.dataset.id;
    slideImage();
  });
});

function slideImage() {
  const displayWidth = document.querySelector(
    ".img-showcase img:first-child"
  ).clientWidth;

  document.querySelector(".img-showcase").style.transform = `translateX(${
    -(window.imgId - 1) * displayWidth
  }px)`;
}

window.addEventListener("resize", slideImage);

$(document).on("click", ".img-select a", function () {
  window.imgId = $(this).data("id");
  slideImage();
});

$(document).ready(function () {
  // DOM element(s)
  let slider = document.getElementById("slider");
  let innerSlider = document.getElementById("innerslider");

  // Slider variables
  let pressed = false,
    startX,
    x;

  // Mousedown eventlistener
  slider.addEventListener("click", (e) => {
    pressed = true;
    startX = e.offsetX - innerSlider.offsetLeft;
    if(startX < 128){
        if(window.imgId>1){
            window.imgId--;
        }
    }else{
        let length = $(".img-select a").length
        if(window.imgId<length){
            window.imgId++;
        }
    }
    slider.style.cursor = "grabbing";
    slideImage();
  });

  // mouseneter
  slider.addEventListener("mouseenter", () => {
    slider.style.cursor = "grab";
  });

  // mouseup
  slider.addEventListener("mouseup", () => {
    slider.style.cursor = "grab";
  });

  // window
  window.addEventListener("mouseup", () => {
    pressed = false;
  });

});
