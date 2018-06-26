$(document).ready(function()
{
	//CheckBox All Selected
	checkAll();

	//Display Modal Box
	modalBox();

	//Display MAP Box
	mapBox();

	//Confirm Delete Modal
	$('#confirm-delete').on('show.bs.modal', function(e) {
		$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
	});

	//Delay Alert
	setTimeout(function()
	{
		$('.alert').fadeIn('slow');
	}, 500);
	setTimeout(function()
	{
		$('.alert').fadeOut('slow');
	}, 2000);

	// Select2 dengan fitur pencarian
	$('.select2').select2();

	//File Upload
	$('#file_browser').click(function(e)
	{
		e.preventDefault();
		$('#file').click();
	});
	$('#file').change(function()
	{
		$('#file_path').val($(this).val());
	});
	$('#file_path').click(function()
	{
		$('#file_browser').click();
	});

	$('#file_browser1').click(function(e)
	{
		e.preventDefault();
		$('#file1').click();
	});
	$('#file1').change(function()
	{
		$('#file_path1').val($(this).val());
	});
	$('#file_path1').click(function()
	{
		$('#file_browser1').click();
	});

	$('#file_browser2').click(function(e)
	{
		e.preventDefault();
		$('#file2').click();
	});
	$('#file2').change(function()
	{
		$('#file_path2').val($(this).val());
	});
	$('#file_path2').click(function()
	{
		$('#file_browser2').click();
	});

	$('#file_browser3').click(function(e)
	{
		e.preventDefault();
		$('#file3').click();
	});
	$('#file3').change(function()
	{
		$('#file_path3').val($(this).val());
	});
	$('#file_path3').click(function()
	{
		$('#file_browser3').click();
	});

	$('#file_browser4').click(function(e)
	{
		e.preventDefault();
		$('#file4').click();
	});
	$('#file4').change(function()
	{
		$('#file_path4').val($(this).val());
	});
	$('#file_path4').click(function()
	{
		$('#file_browser4').click();
	});

	//Fortmat Tanggal
	$('#tgl_jam').datetimepicker(
	{
		format: 'DD-MM-YYYY HH:mm:ss'
	});
	$('#tgl_1').datetimepicker(
	{
		format: 'DD-MM-YYYY'
	});
	$('#tgl_2').datetimepicker(
	{
		format: 'DD-MM-YYYY'
	});
	$('#tgl_3').datetimepicker(
	{
		format: 'DD-MM-YYYY'
	});
	$('#tgl_4').datetimepicker(
	{
		format: 'DD-MM-YYYY'
	});
	$('#tgl_5').datetimepicker(
	{
		format: 'DD-MM-YYYY'
	});

	//Fortmat Tabel
  $('#tabel1').DataTable();
  $('#tabel2').DataTable({
		'paging'      : false,
    'lengthChange': false,
    'searching'   : false,
    'ordering'    : false,
    'info'        : false,
		'autoWidth'   : false,
		'scrollX'			: true
  });
	$('#tabel3').DataTable({
    'paging'      : true,
    'lengthChange': true,
    'searching'   : true,
    'ordering'    : true,
    'info'        : true,
    'autoWidth'   : false,
		'scrollX'	: true
  });

	//color picker with addon
  $('.my-colorpicker2').colorpicker();
	//Text Editor with addon
	$('#min-textarea').wysihtml5();
});

function checkAll()
{
	$("#checkall").click(function ()
	{
		if ($(".table #checkall").is(':checked'))
		{
			$(".table input[type=checkbox]").each(function ()
			{
				$(this).prop("checked", true);
			});

		}
		else
		{
			$(".table input[type=checkbox]").each(function ()
			{
				$(this).prop("checked", false);
			});
		}
	});
	$("[data-toggle=tooltip]").tooltip();
}

function deleteAllBox(idForm, action)
{
	$('#confirm-delete').modal('show');
	$('#ok-delete').click(function ()
	{
		$('#' + idForm).attr('action', action);
        $('#' + idForm).submit();
	});
	return false;
}

function modalBox()
{
	$('#modalBox').on('show.bs.modal', function(e)
	{
		var link = $(e.relatedTarget);
		$('.modal-header #myModalLabel').html(link.attr('data-title'));
		$(this).find('.fetched-data').load(link.attr('href'));
	});
	return false;
}
function mapBox()
{
	$('#mapBox').on('show.bs.modal', function(e){
		$.getScript('<?php echo base_url()?>assets/css/leaflet.css');
		$.getScript('<?php echo base_url()?>assets/css/leaflet.pm.css');
		$.getScript('<?php echo base_url()?>assets/js/leaflet.js');
		$.getScript('<?php echo base_url()?>assets/js/leaflet.pm.min.js');
		$.getScript('<?php echo base_url()?>assets/bootstrap/js/jquery.min.js');
		setTimeout(function(e)
		{
		  map.invalidateSize(e);
		}, 10);
		var link = $(e.relatedTarget);
		$('.modal-header #myModalLabel').html(link.attr('data-title'));
		$(this).find('.fetched-data').load(link.attr('href'));
	});
}
function formAction(idForm, action)
{
	$('#'+idForm).attr('action', action);
	$('#'+idForm).submit();
}

function notification(type, message)
{
	if ( type =='') {return};
	$('#maincontent').prepend(''
		+'<div id="notification" class="alert alert-'+type+' alert-dismissible">'
		+'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
		+ message+''
		+'</div>'
		+''
	);
}

function cari_nik()
{
	$('#cari_nik').change(function()
	{
		$('#'+'main').submit();
	});

	$('#cari_nik_suami').change(function()
	{
		$('#'+'main').submit();
	});

	$('#cari_nik_istri').change(function()
	{
		$('#'+'main').submit();
	});
}

