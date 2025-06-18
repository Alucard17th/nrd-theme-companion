document.addEventListener("DOMContentLoaded", function () {

  new Swiper(".mtc-testimonials-swiper", {
    loop: false,
    initialSlide: 1,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    centeredSlides: true,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    breakpoints: {
      // when window width is >= 320px
      320: {
        slidesPerView: 1,
        spaceBetween: 20,
      },
      // when window width is >= 480px
      480: {
        slidesPerView: 2,
        spaceBetween: 30,
      },
      // when window width is >= 640px
      640: {
        slidesPerView: 2,
        spaceBetween: 40,
      },
    },
  });
});
