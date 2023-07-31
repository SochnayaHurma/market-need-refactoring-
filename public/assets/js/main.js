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
    const cartQty = $('.cart-qty').text();
    const countLabel = $('#count-items');
    if (cartQty) {
      countLabel.text(cartQty);
    } else {
      countLabel.text(0);
    }
  };

  $('.add-to-cart').on('click', function(e) {
    e.preventDefault();
    const id = $(this).data('id');
    let quantityValue = $('#input-quantity').val();
    const qty = quantityValue ? quantityValue : 1;
    $.ajax({
      url: `cart/add?id=${id}&qty=${qty}`,
      type: 'GET',
      success: function(resp) {
        showCart(resp);
      },
      error: function(err) {

        alert('Error!');
      }
    });
  });

  $('#cart-modal .modal-cart-content').on('click', '.del-item', function(e) {
    e.preventDefault();
    const id = $(this).data('id');
    $.ajax({
      url: 'cart/delete',
      type: 'GET',
      data: {id},
      success: function(resp){
        showCart(resp);
      },
      error: function(resp){ console.log(resp);alert('Error')}
    });
  });

  $('#cart-modal .modal-cart-content').on('click', '#clear-cart', function() {
    $.ajax({
      url: 'cart/clear',
      type: 'GET',
      success: function(resp){
        showCart(resp);
      },
      error: function(resp){alert('Error'); console.log(resp)}
    });
  })

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
