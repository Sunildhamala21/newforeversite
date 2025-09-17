$("#header-search" ).autocomplete({
  source: function( request, response ) {
    let url = '/search-ajax';
    let search_keyword = $('#header-search').val();
    $.ajax({
      url: url,
      type: 'POST',
      dataType: "json",
      data: {
        keyword: search_keyword
      },
      success: function(res) {
        response( res.data );
      }
    });
  },
  minLength: 1,
  classes: {
    "ui-autocomplete": "autocomlete-highlight"
  },
  focus: function( event, ui ) {
    $( "#header-search" ).val(ui.item.name);
    return false;
  },
  select: function( event, ui ) {
    $("#header-search").val(ui.item.name);
    $("#header-search-form").submit();
    return false;
  }
}).autocomplete("instance")._renderItem = function( ul, item ) {
  return $( "<li>" )
    .append( "<div>" + item.name + "</div>" )
    .appendTo( ul );
};

$("#banner-search" ).autocomplete({
  source: function( request, response ) {
    let url = '/search-ajax';
    let search_keyword = $('#banner-search').val();
    $.ajax({
      url: url,
      type: 'POST',
      dataType: "json",
      data: {
        keyword: search_keyword
      },
      success: function(res) {
        response( res.data );
      }
    });
  },
  minLength: 1,
  classes: {
    "ui-autocomplete": "autocomlete-highlight"
  },
  focus: function( event, ui ) {
    $( "#banner-search" ).val(ui.item.name);
    return false;
  },
  select: function( event, ui ) {
    $("#banner-search").val(ui.item.name);
    $("#banner-search-form").submit();
    return false;
  }
}).autocomplete("instance")._renderItem = function( ul, item ) {
  return $( "<li>" )
    .append( "<div>" + item.name + "</div>" )
    .appendTo( ul );
};