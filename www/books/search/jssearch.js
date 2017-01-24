var searchname = $('#searchname').val();
$('.textfirst').hide();
$('.registration').hide();
$('.viewdevelopment').hide();
$('.viewgoods').html(' ');
$('.viewgoods').show();

  dp.Request('SearchSite', {searchname: searchname},function (_datasearch) 
  {
    console.log("_datasearch",_datasearch);
    if (_datasearch.length > 0) 
    {
      $.each(_datasearch, function (index, item) 
      {
        $('.viewgoods').append('<li>'+item.name+
          "<p><img src="+item.images+"></p>"+
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