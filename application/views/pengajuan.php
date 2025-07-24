<div class="inner">
	<div class="row">
		<!-- <div class="col-md-2 col-xs-12">
			<div class="form-group">
				<a href="javascript:log_tambah()" class="btn btn-dark btn-block"><i class="fa fa-plus"></i> &nbsp;&nbsp;&nbsp; Tambah</a>
			</div>
		</div> -->
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
					Data Pengajuan
				</div>
				<div class="card-body table-responsive">
					<table class="table table-striped table-bordered table-hover" id="tabel-pengajuan" width="100%" style="font-size:120%;">
						<thead>
							<tr>
								<th>No</th>
								<th>Tanggal Pengajuan</th>
								<th>Nama Pengajuan</th>
								<th>Status</th>
								<th>Keterangan</th>
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
<div class="modal fade" id="modal_list_detail" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title"><i class="glyphicon glyphicon-info"></i> Detail Pengajuan</h3>
			</div>
			<div class="modal-body form" id="list_pengajuandetail">
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_edit_detail" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title"><i class="glyphicon glyphicon-info"></i> Ubah Detail Pengajuan</h3>
			</div>
			<form role="form  col-lg-6" name="Detail" id="frm_detailpengajuan">
			<div class="modal-body form" id="list_editdetail">
				<input type="hidden" id="pgjd_id" name="pgjd_id" value="">
				<input type="hidden" id="pgjd_pgj_id" name="pgjd_pgj_id" value="">
				<div class="col-lg-12">
					<div class="form-group">
						<label>Nama Barang</label>
						<input type="text" disabled class="form-control" name="brg_nama" id="brg_nama" placeholder="" required>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="form-group">
						<label>Jumlah</label>
						<input type="number" min=0 class="form-control rp text-right" onChange="kasikoma('pgjd_jml')" onKeyUp="kasikoma('pgjd_jml')" name="pgjd_jml" id="pgjd_jml" placeholder="Jumlah Barang" value="">
					</div>
				</div>
				<div class="col-lg-12">
					<div class="form-group">
						<label>Harga Satuan</label>
						<input type="text" class="form-control rp text-right"  name="pgjd_harga_satuan" id="pgjd_harga_satuan" placeholder="Harga Satuan" value="">
					</div>
				</div>
				<div class="col-lg-12" style="text-align:center;">
						<a href="#" onClick="batalrequestdetail()" class="btn btn-danger">Batal</a>
						<button type="submit" class="btn btn-success" id="pgjd_ubh">Ubah</button>
				</div>
			</div>
			</form>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_Pengajuan" role="dialog">
	<div class="modal-dialog ">
		<div class="modal-content">
			
			<div class="modal-header">
				<h3 class="modal-title"><i class="glyphicon glyphicon-info"></i> Form Pengajuan Barang</h3>
			</div>
			<form role="form col-lg-6" name="Pengajuan" id="frm_pengajuan">
				<div class="modal-body form">
					<div class="row">
						<input type="hidden" id="pgj_id" name="pgj_id" value="">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Tanggal Pengajuan</label>
								<input type="text" class="form-control tgl" name="pgj_tgl" id="pgj_tgl" placeholder="Tanggal Penjualan" value="<?= date('d/m/Y'); ?>">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nama Pengajuan</label>
								<input type="text" class="form-control" name="pgj_nama" id="pgj_nama" placeholder="Nama Pengajuan" value="">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Gudang</label>
								<select class="form-control select" name="pgj_id_gudang" id="pgj_id_gudang">
										<option value="">== Pilih ==</option>
										<?php foreach ($gudang as $gdg) {
										?>
											<option value="<?= $gdg->id_gudang; ?>"><?= "{$gdg->nama_gudang}"; ?></option>
										<?php } ?>
								</select>
							</div>
						</div>	
						<?php
							if($level = 3){
						?>	
						<input type="hidden" id="pgj_status_ket" name="pgj_status_ket" value="Diajukan oleh gudang">	
						<?php	}else{?>
						<input type="hidden" id="pgj_status_ket" name="pgj_status_ket" value="Diajukan oleh pengelola">	
						<?php	}?>
						
					</div>
					<hr />
					<div class="row">
						<input type="hidden" id="pgjd_id_1" name="pgjd_id">
						<input type="hidden" id="jpjd" name="jpjd">
						<div class="col-lg-12">
							<div class="form-group">
								<label>Detail Barang</label>
								<table width="100%" class="table table-responsive table-striped">
									<thead>
										<tr>
											<th>No</th>
											<th>Nama Barang</th>
											<th>Jumlah</th>
											<th>Harga Satuan</th>
											<th>Total Harga</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody id="view_pengajuandetail">
									
									
									
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-lg-12" style="display:none;" id="input_pengajuandetail">
							<div class="col-lg-12">
								<div class="form-group">
									<label>Nama Barang</label>
									<select class="form-control select" name="pgjd_nama" id="pgjd_nama">
										<option value="">== Pilih Barang ==</option>
										<?php foreach ($barang as $item) {
										?>
											<option value="<?= $item->brg_id; ?>"><?= "{$item->brg_nama}"; ?></option>
										<?php } ?>
									</select>

								</div>
							</div>
							
							<div class="col-lg-12">
								<div class="form-group">
									<label>Jumlah</label>
									<input type="number" min=0 class="form-control rp text-right" name="pgjd_jml" 
									id="pgjd_jml_1" placeholder="Jumlah Barang" value="">
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<label>Harga Satuan</label>
									<input type="text" class="form-control rp text-right" onChange="kasikoma('pgjd_harga_satuan')" onKeyUp="kasikoma('pgjd_harga_satuan')" name="pgjd_harga_satuan" id="pgjd_harga_satuan_1" placeholder="Harga Satuan" value="">
								</div>
							</div>
							<div class="col-lg-12" style="text-align:center;">
								<a href="#" onClick="batalpengajuandetail()" class="btn btn-danger">Batal</a>
								<a href="#" onClick="tambahPengajuanDetail()" class="btn btn-success">Tambah</a>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="pgj_simpan" class="btn btn-success">Simpan</a>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
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
	function tambahPurchase(){
		$("#purchasedata").show();
	}
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
				"url": "ajax_list_pengajuan/",
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

	function log_tambah() {
		reset_form();
		$("#pgj_id").val(0);
		$("frm_pengajuan").trigger("reset");
		$('#modal_Pengajuan').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}
	function inputPengajuanDetail() {
		event.preventDefault();
		$("#input_pengajuandetail").slideDown(100);
	}
	function tampilPerbandingan(){
		document.getElementById("tbl_pembanding").style.display = "block";
	}
	function list_detail(id) {
		$.get("list_detail/" + id, {}, function(d) {
			$("#list_pengajuandetail").html(d);
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
	function tambahPengajuanDetail() {
		event.preventDefault();
		var pengajuandetail = $("#pgjd_id_1").val();
		var pj = $("#jpjd").val();
		
		var brg = $("#pgjd_nama").val();
		var pjdtext = $("#pgjd_nama option:selected").text().replace(/-/g, "|");
		var pjdt = pjdtext.replace(/&/g, "inisimboldan");

		var jml = $("#pgjd_jml_1").val().replace(/\./g, '');
		var hargas = $("#pgjd_harga_satuan_1").val().replace(/\./g, '');
		var hrgbrg = jml*hargas;
		
		pj += "-"+"."+ pjdt +"." + brg +"_"+ jml + "." + jml + "_" + hargas + "." + hargas+ "_" + hrgbrg + "." + hrgbrg;
		pengajuandetail+=";"+brg+"-"+jml+"-"+hargas+"-"+hrgbrg;
		console.log(pj);		
				
				$("#jpjd").val(pj);
				$("#pgjd_id_1").val(pengajuandetail);
				getPengajuanDetail();
				$("#pgjd_jml").val(0);
				
		
		
	}
	function getPengajuanDetail() {
		var pengajuandetail = $("#jpjd").val();
		// $.get('view_penjualandetail/'+requestdetail, {}, function(d) {
		// $("#view_penjualandetail").html(d);
		// });
		$.ajax({
			type: "POST",
			url: "view_pengajuandetail/",
			data: 'jpjd=' + pengajuandetail,
			success: function(d) {
				$("#view_pengajuandetail").html(d);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});
	}
	function edit_detail(id) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "carib",
			data: "pgjd_id=" + id,
			dataType: "json",
			success: function(data) {
				var obj = Object.entries(data);
				// console.log(obj);
				obj.map((dt) => {
					$("#" + dt[0]).val(dt[1]);
					// console.log(dt[0]);
				});
				$(".inputan").attr("disabled", false);
				$("#modal_edit_detail").modal({
					show: true,
					keyboard: false,
					backdrop: 'static'
				});
				return false;
			}
		});
	}
	$("#frm_detailpengajuan").submit(function(e) {
		e.preventDefault();
		$("#pgjd_ubh").html("Mengubah...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "POST",
			url: "ubahpgjd",
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
					$("#modal_edit_detail").modal("hide");
				} else {
					toastr.error(res.desc);
				}
				$("#pgjd_ubh").html("Simpan");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#pgjd_ubh").html("Simpan");
				$(".btn").attr("disabled", false);
				alert('Error get data from ajax');
			}
		});
	});
	function hapus_detailp(id) {
		event.preventDefault();
		$("#isiKonfirm").html("Sedang menghapus data...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "GET",
			url: "hapusp/" + id,
			success: function(d) {
				var res = JSON.parse(d);
				var msg = "";
				if (res.status == 1) {
					toastr.success(res.desc);
					
					$("#modal_list_detail").modal("hide");
				} else {
					toastr.error(res.desc);
				}
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				
				alert('Error get data from ajax');
			}
		});
	}
	function hapusPengajuanDetail(hapus) {
		event.preventDefault();

		var sr = $("#jpjd").val();
		var srs = $("#pgjd_id").val();
		var data = hapus.split("_");
		var ids = data[0].split(".");
		var jml = data[1].split(".");
		var newList = sr.replace("-" + hapus, "");
		var newLists = srs.replace(";" + ids[0] + "-" + jml[0], "");
		$("#jpjd").val(newList);
		$("#pgjd_id").val(newLists);
		getPengajuanDetail();
		toastr.success('Berhasi menghapus item');
	}

	$("#frm_pengajuan").submit(function(e) {
		e.preventDefault();
		$("#pgj_simpan").html("Menyimpan...");
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
					$("#modal_Pengajuan").modal("hide");
				} else {
					toastr.error(res.desc);
				}
				$("#pgj_simpan").html("Simpan");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#pgj_simpan").html("Simpan");
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
		$(".utama").show();
		$(".cadangan").hide();
		drawTable();
	});

	function hapus_pengajuan(id) {
		event.preventDefault();
		$("#pgj_id").val(id);
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
		$("#prc_simpans").html("Mengubah...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "POST",
			url: "cari",
			data: "pgj_id=" + id,
			dataType: "json",
			success: function(data) {
				var obj = Object.entries(data);
				obj.map((dt) => {
					$("#" + dt[0]).val(dt[1]);
				});
				$(".inputan").attr("disabled", false);
				$("#modal_pengajuan").modal({
					show: true,
					keyboard: false,
					backdrop: 'static'
				});
				return false;
			}
		});
	}

	// function accPengajuan() {
	// 	event.preventDefault();
	// 	var nama = $("#prc_nama_toko").val();
	// 	var nofak = $("#prc_no_faktur").val();
	// 	var fot = $("#prc_foto").val();
	// 	$.ajax({
	// 		type: "POST",
	// 		url: "simpan_fix",
	// 		data: {
	// 			pgj_id: id,
	// 			prc_nama_toko:  nama,
	// 			prc_no_faktur:  nofak,
	// 			prc_foto:  fot,

	// 		},
	// 		dataType: "json",

	// 		data : new FormData(this),
	// 		processData: false,
	// 		contentType: false,

	// 		success: function(d) {
	// 			var res = JSON.parse(d); 
	// 			var msg = "";
	// 			if (res.status == 1) {
	// 				toastr.success(res.desc);
	// 				$("#modal_list_detail").modal("hide");
	// 				drawTable();
	// 			} else {
	// 				toastr.error(res.desc + "[" + res.err + "]");
	// 			}
	// 			$(".btn").attr("disabled", false);
	// 		}
			
	// 	});
	// }

	function accPengajuanM(id) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "update_fix",
			data: "pgj_id=" + id,
			dataType: "json",
			success: function(d) {
				var res = JSON.parse(JSON.stringify(d));
				var msg = "";
				if (res.status == 1) {
					toastr.success(res.desc);
					$("#modal_list_detail").modal("hide");
					drawTable();
				} else {
					toastr.error(res.desc + "[" + res.err + "]");
				}
				$(".btn").attr("disabled", false);
			}
			
		});
	}
	function pendingPengajuan(id) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "pending_pengajuan",
			data: "pgj_id=" + id,
			dataType: "json",
			success: function(d) {
				var res = JSON.parse(JSON.stringify(d));
				var msg = "";
				if (res.status == 1) {
					toastr.success(res.desc);
					$("#modal_list_detail").modal("hide");
					drawTable();
				} else {
					toastr.error(res.desc + "[" + res.err + "]");
				}
				$(".btn").attr("disabled", false);
			}
			
		});
	}
	function tolakPengajuan(id) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "tolak_pengajuan",
			data: "pgj_id=" + id,
			dataType: "json",
			success: function(d) {
				var res = JSON.parse(JSON.stringify(d));
				var msg = "";
				if (res.status == 1) {
					toastr.success(res.desc);
					$("#modal_list_detail").modal("hide");
					drawTable();
				} else {
					toastr.error(res.desc + "[" + res.err + "]");
				}
				$(".btn").attr("disabled", false);
			}
			
		});
	}

	function reset_form() {
		$("#pgj_id").val(0);
		$("#frm_pengajuan")[0].reset();
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
		var id = $("#pgj_id").val();

		$("#isiKonfirm").html("Sedang menghapus data...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "GET",
			url: "hapus/" + id,
			success: function(d) {
				var res = JSON.parse(d);
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
		getPengajuanDetail();
		drawTable();
	});
</script>