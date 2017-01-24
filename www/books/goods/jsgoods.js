var hrefsearch=window.location.search;
var id= hrefsearch.substr(4);
$('.title').html('') 
$('.textfirst').hide();
$('.registration').hide();
$('.viewdevelopment').hide();
$('.viewgoodsfull').html('');
$('.viewgoodsfull').show();

if(hrefsearch.indexOf("?id=") !== -1) 
{
  $('#linktext').html('');  
  dp.Request('GetGoodsid', {id: id},function (_data) 
  {
    if (_data.length > 0) 
    {
      $.each(_data, function (index, item) 
      {
        $('#linktext,.title').append(item.name);
        $('.viewgoodsfull').append('<a href=/books/goods/?id='+item.id+'><img src='+item.images+" align=left></a>"+
        '<div class="description">'+item.description+'</div></div><span class=price>'+item.price+' руб.</span>'
        );
      });
    }
  }
  , function (_error) 
  {
    console.log("error", _error);
  }
  );
}
else
{
  dp.Request('GetGoods', {},function (_data) 
  {
    $('.title').html('')
    $('.title').html('Все товары')
    if (_data.length > 0) 
    {
      $.each(_data, function (index, item) 
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
  }
  );
}

  dp.Request('Page', {}, function(_page) 
  {
    var p = parseInt(_page);
    $('.viewpagination').html('');
    if (p > 0)
    {
      var pageHtml = '';
      for (var i = 1; i <= p; i++)
      {
        pageHtml += '<a href="#!!"> '  + i + ' </a>';
      }
      $('.viewpagination').append('<div class="pagination">'+pageHtml+'</div>');
    }
  });
