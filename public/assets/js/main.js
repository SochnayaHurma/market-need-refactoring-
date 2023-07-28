$(function () {
  $('#get-cart').on('click', function(e){
    e.preventDefault();
    $.ajax({
      url: 'cart/show',
      type: 'GET',
      success: function(resp){
        showCart(resp);
      },
      error: function(){}
    });
  });

  function showCart(cart){
    $('#cart-modal .modal-cart-content').html(cart);
    const myModalEl = document.querySelector('#cart-modal');
    const modal = bootstrap.Modal.getOrCreateInstance(myModalEl);
    modal.show();
  };

  $('.add-to-cart').on('click', function(e) {
    e.preventDefault();
    const id = $(this).data('id');
    let quantityValue = $('#input-quantity').val();
    const qty = quantityValue ? quantityValue : 1;
    const currentProd = $(this);
    $.ajax({
      url: `cart/add?id=${id}`,
      type: 'GET',
      data: {id, qty},
      success: function(resp) {
        showCart(resp);
      },
      error: function(err) {

        alert('Error!');
      }
    });
  });

  $(".open-search").click(function (e) {
    e.preventDefault();
    $("#search").addClass("active");
  });
  $(".close-search").click(function () {
    $("#search").removeClass("active");
  });

  $(window).scroll(function () {
    if ($(this).scrollTop() > 200) {
      $("#top").fadeIn();
    } else {
      $("#top").fadeOut();
    }
  });

  $("#top").click(function () {
    $("body, html").animate({ scrollTop: 0 }, 700);
  });

  $(".sidebar-toggler .btn").click(function () {
    $(".sidebar-toggle").slideToggle();
  });

  $(".thumbnails").magnificPopup({
    type: "image",
    delegate: "a",
    gallery: {
      enabled: true,
    },
    removalDelay: 500,
    callbacks: {
      beforeOpen: function () {
        this.st.image.markup = this.st.image.markup.replace(
          "mfp-figure",
          "mfp-figure mfp-with-anim"
        );
        this.st.mainClass = this.st.el.attr("data-effect");
      },
    },
  });
  $("#languages button").on("click", function () {
    const langCode = $(this).data("langcode");
    window.location = `${PATH}/language/change?lang=${langCode}`;
  });
});
