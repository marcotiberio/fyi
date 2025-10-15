import $ from 'jquery'

$(document).ready(function () {
  $('#showcontactFormWrapper').click(function () {
    $('#contactFormWrapper').toggle()
  })
  $('#hidecontactFormWrapper').click(function () {
    $('#contactFormWrapper').hide()
  })
})

$('.hamburger').on('click', function () {
  $('.menu').toggleClass('menuIsOpen')
  $('body').toggleClass('overflow-y-hidden')
})

$('.menu a').on('click', function () {
  $('.menu').removeClass('menuIsOpen')
  $('body').removeClass('overflow-y-hidden')
})

$(document).ready(function () {
  let lastScrollTop = 0
  const $navbar = $('.wrapper--menu')

  $(window).scroll(function () {
    const scrollTop = $(this).scrollTop()

    if (scrollTop > lastScrollTop && scrollTop > 100) {
      $navbar.slideUp(250)
    } else {
      $navbar.slideDown(250)
    }

    lastScrollTop = scrollTop
  })
})
