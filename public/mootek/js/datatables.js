$(function(e) {
	$('#example,#example1,#example2,#example3').DataTable({

	});
	$('#table1,#table2,#table3,#table4,#table5').DataTable({
		order: [[7, 'desc']]
	});
    $('#draftSearch').DataTable({
		order: [[7, 'desc']]
	});
	$('#dbl').DataTable({
		"ordering": false
	})
} );
