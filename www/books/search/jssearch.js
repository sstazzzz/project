var searchname = $('#searchname').val();
  console.log("event",searchname);

  $('.textfirst').hide();
  $('.registration').hide();
  $('.viewdevelopment').hide();
  // $('.first').removeClass('current')
  // $('.goods').addClass('current')
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