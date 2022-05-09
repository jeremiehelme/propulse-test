$(document).ready(function ($) {
  $("#icon-menu-mobile").on("click", openMenu);

  $(".faq_item").on("click", toggleFaqItem);

  $(window).scroll(onScrollHandler);
  $(window).resize(onResizeHandler);
});

function onScrollHandler() {
  if ($(this).scrollTop() > 0) {
    $("body").addClass("scrolled");
  } else {
    $("body").removeClass("scrolled");
  }
}

function onResizeHandler() {
  if ($(this).innerWidth() >= 1024) {
    closeMenu();
  }
}

function toggleFaqItem(e) {
  if (e.currentTarget.classList.contains("selected"))
    e.currentTarget.classList.remove("selected");
  else e.currentTarget.classList.add("selected");
}

function openMenu() {
  $("#icon-menu-mobile").off("click", openMenu);
  $("body").addClass("menu-opened");
  //créer div menu
  let divMenu = document.createElement("div");
  divMenu.classList.add("menu-mobile");
  divMenu.appendChild(document.getElementById("site-navigation"));
  //copier menu dans div
  document.querySelector(".menu-mobile-container").append(divMenu);
  $("#icon-menu-mobile").on("click", closeMenu);
}

function closeMenu() {
  if (!$("body").hasClass("menu-opened")) return;

  $("#icon-menu-mobile").off("click", closeMenu);
  $("body").removeClass("menu-opened");
  document
    .querySelector("#menu")
    .append(document.getElementById("site-navigation"));
  document.querySelector(".menu-mobile").remove();
  $("#icon-menu-mobile").on("click", openMenu);
}
