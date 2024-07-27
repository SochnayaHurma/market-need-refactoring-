// Block ADD-TO-CART
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
    const $this = $(this);
    $.ajax({
      url: `cart/add`,
      type: 'GET',
      data: {id, qty},
      success: function(resp) {
        showCart(resp);
        $this.find('i')
          .removeClass('fa-shopping-cart')
          .addClass('fa-luggage-cart');
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
        let url = window.location.toString();
        if (url.indexOf('cart/view') !== -1) {
          window.location = url;
        } else {
          showCart(resp);
        }
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
// END BLOCK ADD TO CART

// START BLOCK SEARCH

  $("#input-sort").on('change', function(e){
    window.location = `${PATH}${window.location.pathname}?${$(this).val()}`;
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
  // START ADD IN WISH LIST

  $(".product-card").on('click', '.add-to-wishlist', function(e){
    e.preventDefault();
    const id = $(this).data('id');
    let $this = $(this);
    $.ajax({
      type: 'GET',
      url: 'wishlist/add',
      data: {id},
      success: function(resp){
        const response = JSON.parse(resp);
        $this.removeClass('add-to-wishlist').addClass('delete-to-wishlist');
        $this.find('i').removeClass('far fa-heart').addClass('fas fa-hand-holding-heart');
        if (response.result == 'success') {
          Swal.fire({
            title: response.text,
            text: '',
            icon: 'success',
            confirmButtonText: 'Ok'
          });
        }
      },
      error: function(resp){
        const response = JSON.parse(resp);
        Swal.fire({
          title: response.text,
          text: '',
          icon: 'error',
          confirmButtonText: 'Ok'
        });
      },
    })
  })
  $(".product-card").on('click', '.delete-to-wishlist', function(e) {
    e.preventDefault();
    const id = $(this).data('id');
    let $this = $(this);
    $.ajax({
      type: 'GET',
      url: 'wishlist/delete',
      data: {id},
      success: function(resp){
        const url = window.location.toString();
        if (url.indexOf('wishlist') !== -1) {
          window.location = url;
        } else {
          const response = JSON.parse(resp);

          if (response.result == 'success') {
            Swal.fire({
              title: response.text,
              text: '',
              icon: 'info',
              confirmButtonText: 'Ok'
            })
            $this.removeClass('delete-from-wishlist').addClass('add-to-wishlist');
            $this.find('i').removeClass('fas fa-hand-holding-heart').addClass('far fa-heart');
          }
        }
      },
      error: function(resp){},
    });
  })
});
