<div class="inner">
	<div class="row">
		<?php if($level == 2){ ?>
		<div class="col-md-2 col-xs-12">
			<div class="form-group">
				<a href="javascript:log_tambah()" class="btn btn-dark btn-block"><i class="fa fa-plus"></i> &nbsp;&nbsp;&nbsp; Tambah</a>
			</div>
		</div>
		<?php } ?>
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
					Data Barang Masuk
				</div>
				<div class="card-body table-responsive">
					<table class="table table-striped table-bordered table-hover" id="tabel-pengajuan" width="100%" style="font-size:120%;">
						<thead>
							<tr>
								<th>No</th>
								<th>Tanggal Barang Masuk</th>
								<th>Nama Barang Masuk</th>
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
				<h3 class="modal-title"><i class="glyphicon glyphicon-info"></i> Detail Barang Masuk</h3>
			</div>
			<div class="modal-body form" id="list_barangdetail">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Bootstrap modal -->
<div class="modal fade" id="modal_barang_masuk" role="dialog">
	<div class="modal-dialog ">
		<div class="modal-content">
			
			<div class="modal-header">
				<h3 class="modal-title"><i class="glyphicon glyphicon-info"></i> Form Barang Masuk</h3>
			</div>
			<form role="form col-lg-6" name="barang" id="frm_barangmasuk">
				<div class="modal-body form">
					<div class="row">
						<input type="hidden" id="prc_id_1" name="prc_id" value="">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Tanggal Barang Masuk</label>
								<input type="text" class="form-control tgl" name="prc_tgl_1" id="prc_tgl" placeholder="Tanggal Barang Masuk" value="<?= date('d/m/Y'); ?>">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nama Barang Masuk</label>
								<input type="text" class="form-control" name="prc_nama_1" id="prc_nama" placeholder="Nama Barang Masuk" value="">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Kategori Stok</label>
								<select class="form-control" name="stk_kategori_1" id="stk_kategori">
									<option value="">== Pilih ==</option>
									<option value="2">Umum</option>
									<option value="1">Khusus</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Project</label>
								<select class="form-control select" name="stk_id_prj_1" id="stk_id_prj">
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
								<select class="form-control select" name="stk_id_gudang_1" id="stk_id_gudang_1">
										<option value="">== Pilih ==</option>
										<?php foreach ($gudang as $gdg) {
										?>
											<option value="<?= $gdg->id_gudang; ?>"><?= "{$gdg->nama_gudang}"; ?></option>
										<?php } ?>
								</select>
							</div>
						</div>	
						<div class="col-lg-6">
							<div class="form-group">
								<label>Sumber</label>
								<input type="text" class="form-control" name="prc_sumber" id="prc_sumber" placeholder="Sumber" value="">
							</div>
						</div>
						

						
					</div>
					<hr />
					<div class="row">
						<input type="hidden" id="prcd_id_1" name="prcd_id_1">
						<input type="hidden" id="jpjd_1" name="jpjd_1">
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
									<tbody id="view_brgmasukdetail">
									
									
									
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-lg-12" style="display:none;" id="input_brgmasukdetail">
							<div class="col-lg-12">
								<div class="form-group">
									<label>Nama Barang</label>
									<select class="form-control select" name="prcd_nama" id="prcd_nama_1">
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
									<input type="number" min=0 class="form-control rp text-right"  name="prcd_jml" id="prcd_jml_1" placeholder="Jumlah Barang" value=0>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<label>Harga Satuan</label>
									<input type="text" class="form-control rp text-right" name="prcd_harga_satuan" id="prcd_harga_satuan_1" placeholder="Harga Satuan" value=0>
								</div>
							</div>
							<div class="col-lg-12" style="text-align:center;">
								<a href="#" onClick="batalpengajuandetail()" class="btn btn-danger">Batal</a>
								<a href="#" onClick="tambahBarangMasukDetail()" class="btn btn-success">Tambah</a>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="bm_simpan" class="btn btn-success">Simpan</a>
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
				"url": "ajax_list_barang/",
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
		$("#bm_simpan").val(0);
		$("frm_barangmasuk").trigger("reset");
		$('#modal_barang_masuk').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	function tambahBarangMasukDetail() {
		event.preventDefault();
		var brgmasukdetail = $("#prcd_id_1").val();
		var pj = $("#jpjd_1").val();
		
		var brg = $("#prcd_nama_1").val();
		var pjdtext = $("#prcd_nama_1 option:selected").text().replace(/-/g, "|");
		var pjdt = pjdtext.replace(/&/g, "inisimboldan");

		var jml = $("#prcd_jml_1").val().replace(/\./g, '');
		var hargas = $("#prcd_harga_satuan_1").val().replace(/\./g, '');
		var hrgbrg = jml*hargas;
		
		pj += "-"+"."+ pjdt +"." + brg +"_"+ jml + "." + jml + "_" + hargas + "." + hargas+ "_" + hrgbrg + "." + hrgbrg;
		brgmasukdetail+=";"+brg+"-"+jml+"-"+hargas+"-"+hrgbrg;
		console.log(brgmasukdetail);		
				
				$("#jpjd_1").val(pj);
				$("#prcd_id_1").val(brgmasukdetail);
				getBarangMasukDetail();
				$("#prcd_jml_1").val(0);
				
		
		
	}

	$("#frm_barangmasuk").submit(function(e) {
		e.preventDefault();
		$("#bm_simpan").html("Menyimpan...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "POST",
			url: "simpanBm",
			data: new FormData(this),
			processData: false,
			contentType: false,
			success: function(d) {
				var res = JSON.parse(d);
				var msg = "";
				if (res.status == 1) {
					toastr.success(res.desc);
					reset_form();
					drawTable();
					$("#modal_barang_masuk").modal("hide");
				} else {
					toastr.error(res.desc);
				}
				$("#prc_simpan").html("Simpan");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#prc_simpan").html("Simpan");
				$(".btn").attr("disabled", false);
				alert('Error get data from ajax');
			}
		});
	});
	function inputBarangMasukDetail() {
		event.preventDefault();
		$("#input_brgmasukdetail").slideDown(100);
	}
	
	function list_detail(id) {
		$.get("list_detail/" + id, {}, function(d) {
			$("#list_barangdetail").html(d);
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
		$("#prc_id_1").val(id);
		console.log(id);
		$("#jdlKonfirm").html("Konfirmasi hapus data");
		$("#isiKonfirm").html("Yakin ingin menghapus data ini ?");
		$("#frmKonfirm").modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}
	$("#yaKonfirm").click(function() {
		var id = $("#prc_id_1").val();

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

	function getBrgMasukDetail() {
		var pengajuandetail = $("#jpjd_1").val();
		// $.get('view_penjualandetail/'+brgmasukdetail, {}, function(d) {
		// $("#view_penjualandetail").html(d);
		// });
		$.ajax({
			type: "POST",
			url: "view_brgmasukdetail/",
			data: 'jpjd_1=' + pengajuandetail,
			success: function(d) {
				$("#view_brgmasukdetail").html(d);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});
	}
	function hapusBarangMasukDetail(hapus) {
		event.preventDefault();

		var sr = $("#jpjd_1").val();
		var srs = $("#prc_id_1").val();
		var data = hapus.split("_");
		var ids = data[0].split(".");
		var jml = data[1].split(".");
		var newList = sr.replace("-" + hapus, "");
		var newLists = srs.replace(";" + ids[0] + "-" + jml[0], "");
		$("#jpjd_1").val(newList);
		$("#prc_id_1").val(newLists);
		getBarangMasukDetail();
		toastr.success('Berhasi menghapus item');
	}

	function reset_form() {
		$("#prc_id_1").val(0);
		$("#frm_barangmasuk")[0].reset();
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

	function getBarangMasukDetail() {
		var brgmasukdetail = $("#jpjd_1").val();
		// $.get('view_penjualandetail/'+brgmasukdetail, {}, function(d) {
		// $("#view_penjualandetail").html(d);
		// });
		$.ajax({
			type: "POST",
			url: "view_brgmasukdetail/",
			data: 'jpjd_1=' + brgmasukdetail,
			success: function(d) {
				$("#view_brgmasukdetail").html(d);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});
	}

	$(document).ready(function() {
		getBarangMasukDetail();
		drawTable();
	});
</script>