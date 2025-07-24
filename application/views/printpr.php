<div class="inner">
	<div class="row" id="isidata">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					Data Purchase Request
				</div>
				<div class="row">
	<div class="col-lg-2">Nama Pengajuan </div>
	<div class="col-lg-9">: <?= $fix->pgjf_nama; ?></div>
	<div class="col-lg-2">Tanggal </div>
	<div class="col-lg-9">: <?= date("d/m/Y", strtotime($fix->pgjf_tgl)) ?></div> 
	<div class="col-lg-2">Status Pengajuan </div>
	<?php if($fix->status_pgjf == 0) {?>
		<div class="col-lg-9">: <i class='badge bg-warning'><b>Menunggu Purchasing</b></i></div> 
	<?php }elseif($fix->status_pgjf == 1) { ?>
		<div class="col-lg-9">: <i class='badge bg-warning'><b>Sedang Purchase Request</b></i></div> 
	<?php }elseif($fix->status_pgjf == 2) { ?>
		<div class="col-lg-9">: <i class='badge bg-warning'><b>Sedang Purchase Order</b></i></div> 
	<?php }elseif($fix->status_pgjf == 3) { ?>
		<div class="col-lg-9">: <i class='badge bg-info'><b>Approve Direktur</b></i></div> 
	<?php }elseif($fix->status_pgjf == 4) { ?>
		<div class="col-lg-9">: <i class='badge bg-warning'><b>Pending</b></i></div> 
	<?php }elseif($fix->status_pgjf == 5) { ?>
		<div class="col-lg-9">: <i class='badge bg-danger'><b>Ditolak</b></i></div> 
	<?php } ?>
	
</div>
<div class="row" id="isidata">
	<div class="col-lg-12">
		<div class="card">
			
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="tabel-detailpenjualan" width="100%" style="font-size:120%;">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Barang</th>
								<th>Jumlah</th>
								<th>Satuan</th>
								<th>Harga Satuan</th>
								<th>Total Harga</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$n = 1;
							foreach ($pengajuandetail as $pgj) {
								echo "<tr>
										<td>{$n}</td>
										<td> {$pgj->brg_nama}</td>
										<td> {$pgj->pgjfd_jml}</td>
										<td> {$pgj->brg_satuan}</td>
										<td> {$pgj->pgjfd_harga_satuan}</td>
										<td> {$pgj->pgjfd_hrg_brg}</td>
										</tr>";
										$n++;
							}
							?>
							
						</tbody>
						
					</table>
					<?php if($fix->status_pgjf == 0) {?>
						<a href="#" onClick="ajukanPr(<?= $pgj->pgjf_id ?>)" class="btn btn-success"> Ajukan Purchase Request</a>
					<?php }elseif($fix->status_pgjf == 1 && $level == 6) {  ?>
						<a href="pindahPrint" class="btn btn-success"> Cetak Faktur</a>
					<?php }elseif($fix->status_pgjf == 1 && $level == 4) {  ?>
						<a href="#" onClick="approvePr(<?= $pgj->pgjf_id ?>)" class="btn btn-success"> Aprrove Purchase Request</a>
						<a href="#" onClick="pendingPr(<?= $pgj->pgjf_id ?>)" class="btn btn-warning"> Pending Pengajuan</a>
						<a href="#" onClick="tolakPr(<?= $pgj->pgjf_id ?>)" class="btn btn-danger"> Tolak </a>
					<?php }elseif($fix->status_pgjf == 2) {  ?>
						<a href="#" onClick="" class="btn btn-success"> Cetak Faktur</a>
					<?php }elseif($fix->status_pgjf == 3 && $level == 4) {  ?>
						<a href="#" onClick="tambahPurchase()" class="btn btn-success"> Tambah Data Purchase Order</a>
						
					<?php }elseif($fix->status_pgjf == 4 && $level == 6) {  ?>
						<a href="#" onClick="approvePr(<?= $pgj->pgjf_id ?>)" class="btn btn-success"> Aprrove Purchase Request</a>
						<a href="#" onClick="tolakPr(<?= $pgj->pgjf_id ?>)" class="btn btn-danger"> Tolak </a>
						
					<?php } ?>	
					
				</div>
			</div>
			
		</div>
	</div>
</div>
			</div>
		</div>
	</div>
</div>



<!-- DataTables -->
<script src="<?= base_url("assets"); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/buttons.flash.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/buttons.colVis.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/pdfmake.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/vfs_fonts.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/jszip.min.js"></script>
<!-- date-range-picker -->
<script src="<?= base_url("assets"); ?>/plugins/moment/moment.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= base_url("assets"); ?>/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- Select 2 -->
<script src="<?= base_url("assets"); ?>/plugins/select2/js/select2.full.js"></script>

<!-- Toastr -->
<script src="<?= base_url("assets"); ?>/plugins/toastr/toastr.min.js"></script>

<!-- Custom Java Script -->
<script>
	var save_method; //for save method string
	var table;

	function drawTable() {
		$('#tabel-pengajuan').DataTable({
			"destroy": true,
			dom: 'Bfrtip',
			lengthMenu: [
				[10, 25, 50, -1],
				['10 rows', '25 rows', '50 rows', 'Show all']
			],
			buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
			],
			// "oLanguage": {
			// "sProcessing": '<center><img src="<?= base_url("assets/"); ?>assets/img/fb.gif" style="width:2%;"> Loading Data</center>',
			// },
			"responsive": true,
			"sort": true,
			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.
			// Load data for the table's content from an Ajax source
			"ajax": {
				"url": "ajax_list_fix/",
				"type": "POST"
			},
			//Set column definition initialisation properties.
			"columnDefs": [{
				"targets": [-1], //last column
				"orderable": false, //set not orderable
			}, ],
			"initComplete": function(settings, json) {
				$("#process").html("<i class='glyphicon glyphicon-search'></i> Process")
				$(".btn").attr("disabled", false);
				$("#isidata").fadeIn();
			}
		});
	}
	function printdiv() {
	
	}

	function log_tambah() {
		reset_form();
		$("#pgjf_id").val(0);
		$("frm_pengajuan").trigger("reset");
		$('#modal_Pengajuan').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}
	function inputPurchaseDetail() {
		event.preventDefault();
		$("#input_purchasedetail").slideDown(100);
	}
	function list_detail(id) {
		$.get("list_detail/" + id, {}, function(d) {
			$("#list_purchasedetail").html(d);
		});
	}
	function addCommas(nStr) {
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? ',' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + '.' + '$2');
		}
		return x1 + x2;
	}
	function kasikoma(id) {
		var isi = $("#" + id).val().replace(/\./g, '');
		$("#" + id).val(addCommas(isi));
	}

	function hapuskoma(id) {
		var isis = $("#" + id).val().split(",");
		var isi = isis[0].replace(/\./g, "");
		$("#" + id).val(isi);
		$("#" + id).select();
	}
	
	


	$("#ok_info_ok").click(function() {
		$("#info_ok").modal("hide");
		drawTable();
	});

	$("#okKonfirm").click(function() {
		$(".utama").show();;
		$(".cadangan").hide();
		drawTable();
	});

	function hapus_pengajuan(id) {
		event.preventDefault();
		$("#pgjf_id").val(id);
		console.log(id);
		$("#jdlKonfirm").html("Konfirmasi hapus data");
		$("#isiKonfirm").html("Yakin ingin menghapus data ini ?");
		$("#frmKonfirm").modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

function getPurchaseDetail() {
		var purchasedetail = $("#jpjd").val();
		// var purchasedetail = 86;
		// console.log(purchasedetail);
		// $.get('view_penjualandetail/'+requestdetail, {}, function(d) {
		// $("#view_penjualandetail").html(d);
		// });
		$.ajax({
			type: "POST",
			url: "view_purchasedetail/",
			data: 'jpjd=' + purchasedetail,
			success: function(d) {
				
				$("#viewpurchasedetail").html(d);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});
	}
	function hapusPurchaseDetail(hapus) {
		event.preventDefault();

		var sr = $("#jpjd").val();
		var srs = $("#prc_id").val();
		var data = hapus.split("_");
		var ids = data[0].split(".");
		var jml = data[1].split(".");
		var newList = sr.replace("-" + hapus, "");
		var newLists = srs.replace(";" + ids[0] + "-" + jml[0], "");
		$("#jpjd").val(newList);
		$("#prc_id").val(newLists);
		getPurchaseDetail();
		toastr.success('Berhasi menghapus item');
	}

	function reset_form() {
		$("#prc_id").val(0);
		$("#frm_purchase")[0].reset();
	}

	$("#showPass").click(function() {
		var st = $(this).attr("st");
		if (st == 0) {
			$("#brg_satuannya").attr("type", "text");
			$("#matanya").removeClass("fa-eye");
			$("#matanya").addClass("fa-eye-slash");
			$(this).attr("st", 1);
		} else {
			$("#brg_satuannya").attr("type", "password");
			$("#matanya").removeClass("fa-eye-slash");
			$("#matanya").addClass("fa-eye");
			$(this).attr("st", 0);
		}
	});

	

	$('.tgl').daterangepicker({
		locale: {
			format: 'DD/MM/YYYY'
		},
		showDropdowns: true,
		singleDatePicker: true,
		"autoAplog": true,
		opens: 'left'
	});

	$('.select2').select2({
		className: "form-control"
	});

	$(document).ready(function() {
		getPurchaseDetail();
		drawTable();
	});
</script>