(function($, undefined) {
  var _home = false;
  var _sidrName = 'sidr';
  var _initialHeight;
  var _$inviteContent;
  var _$requestInviteContainer;
  var _$window;
  var _$document;
  var _windowHeight;
  var _windowWidth;
  var _bounceRemoved = false;

  var TABLET_WIDTH = "768";
  var DESKTOP_WIDTH = "1024";

  //Possible input validations in order of priority.  Once we hit one we show that one.
  var ERRORS = [
    {
      key: "required",
      validate: function(val) {
        return !!val;
      }
    },
    {
      key: "email",
      validate: function(val) {
        return (/(.+)@(.+){2,}\.(.+){2,}/.test(val));
      }
    }
  ];

  function _scrollHandler(evt){
    var scrollTop = _$document.scrollTop();
    if (_windowWidth < TABLET_WIDTH) {
      return;
    }

    if (!_bounceRemoved) {
      $('.scroll-arrow').removeClass('bounce');
      _bounceRemoved = true;
      return;
    }

    var heightTest = $(".why-hero").height();
    if (heightTest < scrollTop) {
      $(".why-hero-image").addClass('fixed');

    } else {
      $(".why-hero-image").removeClass('fixed');
    }
  }

  function _pageResize () {
    _windowHeight = _$window.height();
    _windowWidth = _$window.width();
    if (_home) {
      _positionInviteContainer();
    }
  }

  function _getMinHeight(width) {
    if (_windowWidth > TABLET_WIDTH) {
      return 600;
    } else {
      return 300;
    }
  }

  function _positionInviteContainer() {
    var MIN_HEIGHT = _getMinHeight();
    var viewPortHeight = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);

    if (viewPortHeight > MIN_HEIGHT) {
      _$requestInviteContainer.height(viewPortHeight - 30);
      _$inviteContent.height(_$requestInviteContainer.height() - 20);
    } else {
      _$requestInviteContainer.height(_$requestInviteContainer.height());
    }
  }

  function _handleInviteClick() {
    var $hero;
    var height;
    _initialHeight = $('#header-request-container').height();
    $('#contactForm').show();
    if (_home) {
      $('.hero-container').addClass('opened');
      $hero = $('#hero-image');
      height = -1 * $hero.height() + "px";
      $('#hero-image').css({top: height});
      $('#invite-content').css({top: height});
    } else {
      $('#header-request-container').css({height: '790px'});
    }
  }

  function _handleInviteClose() {
    if (_home) {
      $('#hero-image').css({top: '0px'});
      $('#invite-content').css({top: '0px'});
    } else {
      $('#header-request-container').css({height: _initialHeight});
    }

    $('#email').val('');
    $('#firstName').val('');
    $('#lastName').val('');
    $("#inviteSubmit").show();
    $(".invite-success-message").hide();
  }

  function _sendInvite(evt) {
    var $form = $('form#contactForm');
    var data = $form.serializeArray();
    var orgText = $("#inviteSubmit").text();
    var error;

    evt.preventDefault();

    if (!_validateInput($("#firstName"))) {
      error = true;
    }

    if (!_validateInput($('#lastName'))) {
      error = true;
    }

    if (!_validateInput($('#email'))) {
      error = true;
    }

    if (error) {
      return;
    }

    $("#inviteSubmit").text('Submitting...');
    $.ajax({
      type: 'POST',
      data: data,
      url: '/web-to-lead',
      success: function() {
        var date = new Date();
        date.setDate(date.getDate() + 10*365);
        _gaq.push(['_trackEvent', 'account', 'request invite']);
        $("#inviteSubmit").hide();
        $(".invite-success-message").show();
        $("#inviteSubmit").text(orgText);
        setTimeout(_handleInviteClose, 1000);
      },
      error: function() {
        $form.find("#inviteFormContent").hide();
        $('.form-error-message').show();
        $("#inviteSubmit").text(orgText);
      }
    });
  }

  function _validateInput($input) {
    var $label = $input.prev('label');
    var validationErrorMsg;

    for(var i=0; i<ERRORS.length; i++) {
      validationErrorMsg = $input.data(ERRORS[i].key);
      if (validationErrorMsg && !ERRORS[i].validate($input.val())) {
        $label.text(validationErrorMsg.replace('__name__', $label.data('label')));
        $label.addClass('error');
        $input.addClass('error');
        return false;
      }
    }

    $input.removeClass('error');
    $label.removeClass('error');
    $label.text($label.data('label'));
    return true;
  }

  function _handleFormValidation(evt) {
    _validateInput($(this));
  }

  function _handleMobileRequestInvite(evt) {
    $.sidr('close', _sidrName, function() {
      _handleInviteClick();
    });
    evt.stopPropagation();
    evt.preventDefault();
  }

  function _registerEventListeners() {
    $("#request-invite").click(_handleInviteClick);
    $(".close").click(_handleInviteClose);
    $("#inviteSubmit").click(_sendInvite);
    $("input").change(_handleFormValidation);
    $('#sidr .request-invite').click(_handleMobileRequestInvite);
    _$window.bind('resize', _pageResize);
    _$window.scroll(_scrollHandler);
  }

  function _handleSidr() {
    $('#menu-affordance').sidr({
      name: _sidrName,
      side: 'right',
      onOpen: function() {
        $('body').addClass('no-scroll');
        window.onscroll = function() {window.scrollTo(0,0)};
        window.ontouchmove = function(e) {e.preventDefault();e.stopPropogation();};
        $('#sidr ul').click(function(evt) { evt.stopPropagation();});
        $('html').click(function() { $.sidr('close', 'sidr')});
      },
      onClose: function() {
        $('body').removeClass('no-scroll');
        window.onscroll = undefined;
        window.ontouchmove = undefined;
        $('html').off('click');
      }
    });
  }

  $(document).ready(function() {
    // mobile fast click handler
    FastClick.attach(document.body);

    //position the header to be 90%;
    _$window = $(window);
    _$document = $(window.document);
    _$inviteContent = $("#invite-content");
    _$requestInviteContainer = $('.request-invite-container');
    _home = location.pathname === '/';
    _registerEventListeners();
    _handleSidr();
    _pageResize();
  });
})(jQuery);

