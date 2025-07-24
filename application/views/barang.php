<div class="inner">
	<div class="row">
		<div class="col-md-2 col-xs-12">
			<div class="form-group">
				<a href="javascript:log_tambah()" class="btn btn-dark btn-block"><i class="fa fa-plus"></i> &nbsp;&nbsp;&nbsp; Tambah</a>
			</div>
		</div>
		<div class="col-md-2 col-xs-12">
			<div class="form-group">
				<a href="javascript:drawTable()" class="btn btn-dark btn-block"><i class="fa fa-sync-alt"></i> &nbsp;&nbsp;&nbsp; Refresh</a>
			</div>
		</div>
	</div>
	<div class="row" id="isidata">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					Data Barang
				</div>
				<div class="card-body table-responsive">
					<table class="table table-striped table-bordered table-hover" id="tabel-request" width="100%" style="font-size:120%;">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Barang</th>
								<th>Satuan</th>
								<th>Jenis Barang</th>
								<th>Harga Pasaran</th>
								<th>Aksi</th>
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

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_barang" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title"><i class="glyphicon glyphicon-info"></i> Form Barang</h3>
			</div>
			<form role="form  col-lg-6" name="Barang" id="frm_barang">
				<div class="modal-body form">
					<div class="row">
						<input type="hidden" id="brg_id" name="brg_id" value="">
						<!-- <input type="hidden" id="id_stok" name="id_stok" value=""> -->

						<div class="col-lg-6">
							<div class="form-group">
								<label>Nama Barang</label>
								<input type="text" class="form-control" name="brg_nama" id="brg_nama" placeholder="" required>
							</div>
						</div>
						<!-- <div class="col-lg-6">
							<div class="form-group">
								<label>Jumlah</label>
								<input type="number" class="form-control" name="stk_jml" id="stk_jml" required>
							</div>
						</div> -->
						
						<div class="col-lg-6">
							<div class="form-group">
								<label>Satuan</label>
								<input type="text" class="form-control" name="brg_satuan" id="brg_satuan" required>
							</div>
						</div>

						<div class="col-lg-6">
							<div class="form-group">
								<label>Harga Pasaran</label>
								<input type="text" class="form-control" name="brg_hrg_pasaran" id="brg_hrg_pasaran" required>
							</div>
						</div>

						<!-- <div class="col-lg-6">
							<div class="form-group">
								<label>Kategori Stok</label>
								<select class="form-control" name="stk_kategori" id="stk_kategori">
									<option value="">== Pilih ==</option>
									<option value="2">Umum</option>
									<option value="1">Khusus</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Project</label>
								<select class="form-control select" name="stk_id_prj" id="stk_id_prj">
										<option value="">== Pilih ==</option>
										<?php foreach ($project as $prj) {
										?>
											<option value="<?= $prj->id_project; ?>"><?= "{$prj->nama_project}"; ?></option>
										<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Gudang</label>
								<select class="form-control select" name="stk_id_gudang" id="stk_id_gudang">
										<option value="">== Pilih ==</option>
										<?php foreach ($gudang as $gdg) {
										?>
											<option value="<?= $gdg->id_gudang; ?>"><?= "{$gdg->nama_gudang}"; ?></option>
										<?php } ?>
								</select>
							</div>
						</div> -->
						<div class="col-lg-6">
							<div class="form-group">
								<label>Jenis</label>
								<select class="form-control" name="brg_jenis" id="brg_jenis">
									<option value="">== Pilih ==</option>
									<option value="1">Material Bangunan</option>
									<option value="2">Aset</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Harga Pasaran</label>
								<input type="text" class="form-control" name="brg_hrg_pasaran" id="brg_hrg_pasaran" required>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="log_simpan" class="btn btn-dark">Simpan</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="reset_form()">Batal</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
		$('#tabel-request').DataTable({
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
				"url": "ajax_list_barang/",
				"type": "POST"
			},
			//Set column definition initialisation properties.
			"columnDefs": [
				{
					"targets": [-1], //last column
					"orderable": false, //set not orderable
				}, 
				{
					"targets": [-2], //last column
					"className": "text-right", //set not orderable
				}, 
			],
			"initComplete": function(settings, json) {
				$("#process").html("<i class='glyphicon glyphicon-search'></i> Process")
				$(".btn").attr("disabled", false);
				$("#isidata").fadeIn();
			}
		});
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
		$("#brg_id").val(id);
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
		var id = $("#brg_id").val();

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

	$(document).ready(function() {
		drawTable();
	});
</script>