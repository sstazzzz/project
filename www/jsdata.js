var dp=new ODataPointGate('/datapoint.php');
var isAuth = false;
var isRegUser = false;
var editGoodIndex = null;
var searchname="";

$(document).on('click', '.button-logout', function()
{
 $('.unauth').show();
 $('.auth').hide();
});

function funlogout(event)
{
 $('.auth').hide();
 $('.unauth').show();
 event.preventDefault();
 return false;
};

function funregistration(event)
{
  $('#linktext').hide();
  $('.viewpagination').hide();
  $('.viewgoods').hide();
  $('.textfirst').hide();
  $('.regnew').hide();
  $('.viewdevelopment').hide();
  $('.viewgoodsfull').hide();
  $('.registration').show();
  event.preventDefault();
}
  
$(document).on('click', '#search_button', function(event)
{
  var searchname = $('#searchname').val();
  var slider = parseInt($('#contentSlider').text());
  var sliderTo = parseInt($('#contentSliderTo').text());
  var searchname = $('#searchname').val();
  console.log(typeof slider);
  console.log("1slider",slider);  
  console.log("2sliderTo",sliderTo); 
  $('#texterror').html('');
  if (slider>sliderTo)
  {
    $('#texterror').html('Неправильная цена отбора');
    return false;
  }

  console.log("slider",slider);  
  console.log("sliderTo",sliderTo);  
  $('.textfirst').hide();
  $('.registration').hide();
  $('.viewdevelopment').hide();
  $('.viewgoods').html(' ');
  $('.viewgoods').show();
  $('#linktext').html('Поиск товаров');

  dp.Request('SearchSite', {searchname: searchname,slider: slider, sliderTo: sliderTo},function (_datasearch) 
  {
    if (_datasearch.length > 0) 
    {
      $.each(_datasearch, function (index, item) 
      {
        $('.viewgoods').append('<li>'+item.name+
        '<p><a href=/books/goods/?id='+item.id+'><img src='+item.images+"></a></p>"+
        '<p class=price>'+item.price+' руб.</p>'
        );
      });
    }
  }
  ,function (_error) 
  {
    console.log("error", _error);
  }
  );

 event.preventDefault();
});


$(document).ready(function ()
{
  var href=window.location.pathname;
  var hrefsearch=window.location.search;
  
  if(href=="/")
  {
     $('.first').addClass('current');
  }
  else if(href=="/books/goods/")
  {
     $('.goods').addClass('current');
  }
  else if(href=="/development/")
  {
     $('.development').addClass('current');
  }
  else if(href=="/service/")
  {
     $('.service').addClass('current');
  }
  else if(href=="/other/")
  {
     $('.other').addClass('current');
  }
  else if(href=="/contact/")
  {
    $('.contact').addClass('current');  
  }

  dp.Request('GetCategory', {}, function(_data) 
  {
    if (_data.length > 0)
    {
      $.each(_data, function(_index, _item)
      {
        $('.ulcategory').append('<ul ' + _index + '" data-index="'+ _index + '">'+
          '<li><a href="/books/'+_item.alias+'" class="link">' +_item.name +'</a></li>'  +
          '</ul>');
      });
    }
  });

//slider От
  $("#slider").slider(
  {
    value : 0,//Значение, которое будет выставлено слайдеру при загрузке
    min : 0,//Минимально возможное значение на ползунке
    max : 5000,//Максимально возможное значение на ползунке
    step : 100,//Шаг, с которым будет двигаться ползунок
    create: function(event,ui) 
    {
      val = $("#slider").slider("value");//При создании слайдера, получаем его значение в перемен. val
      $("#contentSlider").html(val);//Заполняем этим значением элемент с id contentSlider
    },
    slide: function(event,ui) 
    {
      $("#contentSlider").html(ui.value);//При изменении значения ползунка заполняем элемент с id contentSlider
    }
  });

  //slider До
  $("#sliderTo").slider(
  {
    value : 5000,//Значение, которое будет выставлено слайдеру при загрузке
    min : 0,//Минимально возможное значение на ползунке
    max : 5000,//Максимально возможное значение на ползунке
    step : 100,//Шаг, с которым будет двигаться ползунок
    create: function(event,uito) 
    {
      val = $("#sliderTo").slider("value");//При создании слайдера, получаем его значение в перемен. val
      $("#contentSliderTo").html(val);//Заполняем этим значением элемент с id contentSlider
    },
    slide: function(event,uito) 
    {
      $("#contentSliderTo").html(uito.value);//При изменении значения ползунка заполняем элемент с id contentSlider
    }
  });


if(hrefsearch.indexOf("?id=") !== -1) 
{
      
}
  else(href.indexOf("/books/") !== -1)  
  {
    $('.textfirst').hide();
    $('.registration').hide();
    $('.viewdevelopment').hide();
    $('.viewgoods').html(' ');
    $('.viewgoods').show();
    dp.Request('GetGoodsCategory', {Href: href},function(_goods) 
    {
      if (_goods.length > 0) 
      {
        $.each(_goods, function (index, item) 
        {
          $('.viewgoods').append('<li>'+item.name+
          '<p><a href=/books/goods/?id='+item.id+'><img src='+item.images+"></a></p>"+
          '<p class=price>'+item.price+' руб.</p>'
          );
        });
      }
    }
    , function (_error) 
    {
      console.log("error", _error);
    }); 
  }

   return false;
});

//РЕГИСТРАЦИЯ / АВТОРИЗАЦИЯ
$(document).on('click', '.submit_button_input', function(event)
{
  var login = $('.input-login').val();
  var password = $('.input-password').val();
  console.log(login, password);
  if (login != '' && password != '') 
  {
    dp.Request('Authorization', {Login: login, Password: password}, function (_data) 
    {
      console.log("success", _data);
      $('.unauth').hide();
      $('.authlogin').html('');
      $('.authlogin').append(login);
      $('.auth').show();
    }, function (_error) 
    {
      console.log("error", _error);
    });
  }
  event.preventDefault();
});

 $(document).on('click', '.submit_button_regnew', function(event)
 {
  var login = $('.input-loginreg').val();
  var password = $('.input-passwordreg').val();
  var passwordto = $('.input-passwordregto').val();
  $('.regnew').show();
  $('.regnew').html('');
  console.log(password, passwordto);
  if (login != '' && password != '' && passwordto != '') 
  {
    if (password == passwordto)
    { 
      dp.Request('RegisterUser', {Login: login, Password: password}, function (_data) 
      {
        console.log("success", _data);
        $('.regnew').append('Новый пользователь зарегистрирован!');
      }, function (_error) 
      {
        console.log("error", _error);
      });
    }
    else
    {
      $('.regnew').append('Не совпадают пароли!');
    }
    event.preventDefault();
  }
});
