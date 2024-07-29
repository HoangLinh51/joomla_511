!function( $ ) {
$.extend( $.fn.dataTable.defaults, {
	"language": {
        "url": "/media/cbcc/js/dataTables/dataTables.vietnam.txt"
    },
   //"deferRender":true,
    "pageLength": 20,
    "lengthMenu": [[10, 20, 50, 100, -1], [10, 20, 50, 100, "Tất cả"]],
	"paginate": true,
	"processing": true,
	"dom": "<'dataTables_wrapper'<'clear'><'row-fluid'<'span3'f><'span9'C<'pull-left'BrT>>t<'row-fluid'<'span2'l><'span5'i><'span5'p>>>"	
} );
}( window.jQuery );