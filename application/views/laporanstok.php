<div class="inner">
	<div class="row">
		<div class="col-md-2 col-xs-12">
			<div class="form-group">
				<select name="id_gudang" id="id_gudang" class="form-control">
					<option value=0>== Filter gudang ==</option>
					<?php
					foreach ($gudang as $gdg) {
					?>
						<option nama="<?= $gdg->nama_gudang; ?>" value="<?= $gdg->id_gudang; ?>"><?= $gdg->nama_gudang; ?></option>
					<?php }
					?>
				</select>
			</div>
		</div>
		<div class="col-md-2 col-xs-12">
			<div class="form-group">
				<a href="#" class="btn btn-dark btn-block"  id="stk_cari"><i class="fa fa-list"></i> &nbsp;&nbsp;&nbsp; Tampilkan</a>
			</div>
		</div>

		<div class="col-md-2 col-xs-12">
			<div class="form-group">
				<a href="#" onclick="cetak()" class="btn btn-dark btn-block"><i class="fa fa-print"></i> &nbsp;&nbsp;&nbsp; Cetak</a>
			</div>
		</div>
	</div>
	<div class="row" id="loading"></div>
	<div class="row" id="isidata">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					Data Barang
				</div>
				<div class="card-body table-responsive">
					<table class="table table-striped table-bordered table-hover" id="tabel-laporanstok" width="100%" style="font-size:120%;">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Barang</th>
								<th>Stok</th>
								<th>Satuan</th>
								<th>Kategori stok</th>
								<th>Project</th>
								<th>Jenis Barang</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="3" align="center">Tidak ada data</td>
							</tr>
						</tbody>
					</table>
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
	// $("#isidata").hide();
	var save_method; //for save method string
	var table;
	var gdg;

	$("#isidata").hide();
	$("#stk_cari").click(function() {
		
		
			gdg = $("#id_gudang").val();
		// var nama_gdg=$("#id_gudang option:selected").attr("nama");
		// $("#gudanghead").append(nama_gdg);
		// console.log(nama_gdg);
		table = $('#tabel-laporanstok').DataTable({
			"destroy": true,
			dom: 'Bfrtip',
			buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
			],
			// "oLanguage": {
			// "sProcessing": '<center><img src="<?= base_url("assets/"); ?>assets/img/fb.gif" style="width:2%;"> Loading Data</center>',
			// },
			"responsive": true,
			"paging": false,
			"sort": false,
			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.
			// Load data for the table's content from an Ajax source
			"ajax": {
				"url": "ajax_list_laporanstok/" + gdg ,
				"type": "POST"
			},
			//Set column definition initialisation properties.
			"columnDefs": [{
					"targets": [-1], //last column
					"orderable": false, //set not orderable
				},
				{
					"targets": [4, 5, 6], //last column
					"className": "text-right", //set not orderable
				},
			],
			"initComplete": function(settings, json) {
				
				$(".btn").attr("disabled", false);
				$("#isidata").fadeIn();
			}
		});
	});

	function cetak() {
		event.preventDefault();

		gdg = $("#id_gudang").val();
		window.open("<?= base_url('LaporanStok/cetak_stok/') ?>"+gdg, "_blank");
	}


	function log_tambah() {
		reset_form();
		$("#brg_id").val(0);
		$("frm_barang").trigger("reset");
		$('#modal_barang').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	$("#frm_barang").submit(function(e) {
		e.preventDefault();
		$("#log_simpan").html("Menyimpan...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "POST",
			url: "simpan",
			data: new FormData(this),
			processData: false,
			contentType: false,
			success: function(d) {
				var res = JSON.parse(d);
				var msg = "";
				if (res.status == 1) {
					toastr.success(res.desc);
					drawTable();
					reset_form();
					$("#modal_barang").modal("hide");
				} else {
					toastr.error(res.desc);
				}
				$("#log_simpan").html("Simpan");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#log_simpan").html("Simpan");
				$(".btn").attr("disabled", false);
				alert('Error get data from ajax');
			}
		});
	});

	$("#ok_info_ok").click(function() {
		$("#info_ok").modal("hide");
		drawTable();
	});

	$("#okKonfirm").click(function() {
		$(".utama").show();;
		$(".cadangan").hide();
		drawTable();
	});

	function hapus_barang(id) {
		event.preventDefault();
		$("#id_stok").val(id);
		$("#jdlKonfirm").html("Konfirmasi hapus data");
		$("#isiKonfirm").html("Yakin ingin menghapus data ini ?");
		$("#frmKonfirm").modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	function ubah_barang(id) {
		event.preventDefault();
		$("#brg_id").val(id);
		$.ajax({
			type: "POST",
			url: "cari",
			data: "brg_id=" + id,
			dataType: "json",
			success: function(data) {
				var obj = Object.entries(data);
				// console.log(obj);
				obj.map((dt) => {
					$("#" + dt[0]).val(dt[1]);
				});
				$(".inputan").attr("disabled", false);
				$("#modal_barang").modal({
					show: true,
					keyboard: false,
					backdrop: 'static'
				});
				return false;
			}
		});
	}

	function reset_form() {
		$("#brg_id").val(0);
		$("#frm_barang")[0].reset();
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

	$("#yaKonfirm").click(function() {
		var id = $("#id_stok").val();

		$("#isiKonfirm").html("Sedang menghapus data...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "GET",
			url: "hapus/" + id,
			success: function(d) {
				var res = JSON.parse(d);
				console.log(res);
				var msg = "";
				if (res.status == 1) {
					toastr.success(res.desc);
					$("#frmKonfirm").modal("hide");
					drawTable();
				} else {
					toastr.error(res.desc + "[" + res.err + "]");
				}
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});
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

	// $(document).ready(function() {
	// 	drawTable();
	// });
</script>