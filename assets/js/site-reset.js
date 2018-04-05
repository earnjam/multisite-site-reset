(function( $ ) {
  'use strict';

  var tables = $( '#wp-tables' );

  tables.bsmSelect({
    animate: true,
    title: dbReset.selectTable,
    plugins: [$.bsmSelect.plugins.compatibility()]
  });

  $( '#select-all' ).on('click', function(e) {
    e.preventDefault();

    tables.children()
      .attr( 'selected', 'selected' )
      .end()
      .change();
  });

  tables.on( 'change', function() {
    $( '#reactivate' ).showIfSelected( 'options' );
    $( '#uploads' ).showIfSelected( 'posts' );
  });

  $( '#db-reset-code-confirm' ).on( 'change keyup paste', function() {
    $( '#db-reset-submit' ).prop( 'disabled', $( this ).val() !== $( "#security-code" ).text() );
  });

  $( '#db-reset-submit' ).on('click', function(e) {
    e.preventDefault();

    if ( confirm( dbReset.confirmAlert ) ) {
      $( '#db-reset-form' ).submit();
      $( '#loader' ).show();
    }
  });

  $.fn.showIfSelected = function( selectValue ) {
    console.log("selectvalue = " + selectValue);
    var reg = new RegExp( '.*' + selectValue );
    console.log("reg = " + reg);
    var selectOption = tables.children().filter(function() {
        var str = $(this).val();
        return str.match(reg);
    }).prop('selected');
    console.log("selectoption = " + selectOption);
    $( this ).toggle( $( selectOption ).length > 0 );
  }

})( jQuery );
