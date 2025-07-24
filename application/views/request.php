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
					Data Request

				</div>
				<div class="card-body table-responsive">
					<table class="table table-striped table-bordered table-hover" id="tabel-request" width="100%" style="font-size:120%;">
						<thead>
							<tr>
								<th>No</th>
								<th>Gambar</th>
								<th>Tanggal Request</th>
								<th>Tanggal Dibutuhkan</th>
								<th>Nama Request</th>
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
				<h3 class="modal-title"><i class="glyphicon glyphicon-info"></i> Detail Barang Keluar</h3>
			</div>
			<div class="modal-body form" id="list_requestdetail">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_list_proses" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title"><i class="glyphicon glyphicon-info"></i> Detail Proses Barang Keluar</h3>
			</div>
			<div class="modal-body form" id="list_prosesdetail">

				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_Request" role="dialog">
	<div class="modal-dialog ">
		<div class="modal-content">
			
			<div class="modal-header">
				<h3 class="modal-title"><i class="glyphicon glyphicon-info"></i> Form Request Barang</h3>

			</div>
			<form role="form col-lg-6" name="Penjualan" id="frm_request">
				<div class="modal-body form">
					<div class="row">
						<input type="hidden" id="rq_id" name="rq_id" value="">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nama Project</label>
								<select class="form-control select" name="id_prj" id="id_prj">
									<option value="">== Pilih Project ==</option>
										<?php foreach ($project as $prj) {
										?>
											<option value="<?= $prj->id_project; ?>"><?= "{$prj->nama_project}"; ?></option>
										<?php } ?>
								</select>
								
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Tanggal Request</label>
								<input type="text" class="form-control tgl" name="rq_tgl" id="rq_tgl" placeholder="Tanggal Penjualan" value="<?= date('d/m/Y'); ?>">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Tanggal Dibutuhkan</label>
								<input type="text" class="form-control tgl" name="rq_tgl_butuh" id="rq_tgl_butuh" placeholder="Tanggal Dibutuhkan" value="<?= date('d/m/Y'); ?>">
							</div>
						</div>
						
						<div class="col-lg-6">
							<div class="form-group">
								<label>Peruntukan Request</label>
								<input type="text" class="form-control" name="rq_nama" id="rq_nama" placeholder="Peruntukan Request" value="">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Gudang</label>
								<select class="form-control select" name="rq_id_gudang" id="rq_id_gudang">
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
								<label>Gambar</label>
								<input type="file" class="form-control" name="rq_pic" id="rq_pic"  placeholder="Pic" value="">
							</div>
						</div>

						<?php
							if($level == 5){
						?>	
						<input type="hidden" id="rq_status_ket" name="rq_status_ket" value="Diajukan oleh Mandor">
						<?php	}elseif ($level == 3){?>
						<input type="hidden" id="rq_status_ket" name="rq_status_ket" value="Diajukan oleh Gudang">	
						<?php	}elseif ($level == 2){?>
						<input type="hidden" id="rq_status_ket" name="rq_status_ket" value="Diajukan oleh Manager">	
						<?php	}?>
						
					</div>
					<hr />
					<div class="row">
						<input type="hidden" id="rqd_id" name="rqd_id">
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
									<tbody id="view_requestdetail">
									
									
									
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-lg-12" style="display:none;" id="input_requestdetail">
							<div class="col-lg-12">
								<div class="form-group">
									<label>Nama Barang</label>
									<select class="form-control select" name="rqd_nama" id="rqd_nama">
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
									<input type="number" min=0 class="form-control rp text-right" onChange="kasikoma('rqd_jml')" onKeyUp="kasikoma('rqd_jml')" name="rqd_jml" id="rqd_jml" placeholder="Jumlah Barang" value=0>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<label>Harga Satuan</label>
									<input type="text" class="form-control rp text-right" onChange="kasikoma('rqd_harga_satuan')" onKeyUp="kasikoma('rqd_harga_satuan')" name="rqd_harga_satuan" id="rqd_harga_satuan" placeholder="Harga Satuan" value=0>
								</div>
							</div>
							<div class="col-lg-12" style="text-align:center;">
								<a href="#" onClick="batalrequestdetail()" class="btn btn-danger">Batal</a>
								<a href="#" onClick="tambahRequestDetail()" class="btn btn-success">Tambah</a>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="rq_simpan" class="btn btn-success">Simpan</a>
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
				"url": "ajax_list_request/",
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
		$("#rq_id").val(0);
		$("#frm_request").trigger("reset");
		$('#modal_Request').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}
	function inputRequestDetail() {
		event.preventDefault();
		$("#input_requestdetail").slideDown(100);
	}
	function list_detail(id) {
		$.get("list_detail/" + id, {}, function(d) {
			$("#list_requestdetail").html(d);

		});

		
		
	}
	function list_proses(id) {
		$.get("list_proses/" + id, {}, function(d) {
			$("#list_prosesdetail").html(d);

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
	function tambahRequestDetail() {
		event.preventDefault();
		var requestdetail = $("#rqd_id").val();
		var pj = $("#jpjd").val();
		
		var brg = $("#rqd_nama").val();
		var pjdtext = $("#rqd_nama option:selected").text().replace(/-/g, "|");
		var pjdt = pjdtext.replace(/&/g, "inisimboldan");

		var jml = $("#rqd_jml").val().replace(/\./g, '');
		var hargas = $("#rqd_harga_satuan").val().replace(/\./g, '');
		var hrgbrg = jml*hargas;
		
		pj += "-"+"."+ pjdt +"." + brg +"_"+ jml + "." + jml + "_" + hargas + "." + hargas+ "_" + hrgbrg + "." + hrgbrg;
		requestdetail+=";"+brg+"-"+jml+"-"+hargas+"-"+hrgbrg;
		console.log(pj);		
				
				$("#jpjd").val(pj);
				$("#rqd_id").val(requestdetail);
				getRequestDetail();
				$("#rqd_jml").val(0);
				
		
		
	}
	function getRequestDetail() {
		var requestdetail = $("#jpjd").val();
		// $.get('view_penjualandetail/'+requestdetail, {}, function(d) {
		// $("#view_penjualandetail").html(d);
		// });
		$.ajax({
			type: "POST",
			url: "view_requestdetail/",
			data: 'jpjd=' + requestdetail,
			success: function(d) {
				$("#view_requestdetail").html(d);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});
	}
	function hapusRequestDetail(hapus) {
		event.preventDefault();

		var sr = $("#jpjd").val();
		var srs = $("#rqd_id").val();
		var data = hapus.split("_");
		var ids = data[0].split(".");
		var jml = data[1].split(".");
		var newList = sr.replace("-" + hapus, "");
		var newLists = srs.replace(";" + ids[0] + "-" + jml[0], "");
		$("#jpjd").val(newList);
		$("#rqd_id").val(newLists);
		getRequestDetail();
		toastr.success('Berhasi menghapus item');
	}

	$("#frm_request").submit(function(e) {
		e.preventDefault();
		$("#rq_simpan").html("Menyimpan...");
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
					$("#modal_Request").modal("hide");
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

	function hapus_Request(id) {
		event.preventDefault();
		$("#rq_id").val(id);
		$("#jdlKonfirm").html("Konfirmasi hapus data");
		$("#isiKonfirm").html("Yakin ingin menghapus data ini ?");
		$("#frmKonfirm").modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}
	function hapus_Detail(id) {
		event.preventDefault();

		var dtid = $("#listdt").val();
		
		
		toastr.success('Berhasi menghapus item');
	}
	function simpanRequest(id) {
		event.preventDefault();
	

		 var ceknya = $(".checkboxInp:checkbox:checked").map(function() {
	      return this.value;
	    }).get();



		var accbrg = ceknya;
		console.log(accbrg);
	

		$.ajax({
			type: "POST",
			url: "simpan_detailacc",
			data: {
				rq_id:  id, 
				accbrg: accbrg
			},
			dataType: "json",
			success: function(d) {
				var res = JSON.parse(JSON.stringify(d));
				var msg = "";
				if (res.status == 1) {
					toastr.success(res.desc);
					$("#modal_list_detail").modal("hide");
					drawTable();
				} else {
					// toastr.error(res.desc + "[" + res.upt + "]");
					toastr.success(res.desc);
					$("#modal_list_detail").modal("hide");
					drawTable();
				}
				$(".btn").attr("disabled", false);
			}
			
		});
	}
	function ajukanRequest(id) {
		event.preventDefault();
		// cek_pilih();

		 var ceknya = $(".checkboxInp:checkbox:checked").map(function() {
	      return this.value;
	    }).get();
		 // console.log(ceknya);



		var accbrg = ceknya;
		console.log(accbrg);
		// $('.checkboxInp').on('change',function(){
		// 	if($(this.checked)){
		// 		$(this).val();
		// 	} else {
		// 		$(this).val();
		// 	}
			// else {
			// 	accbrg.slice($.inArray(checked, accbrg),0);
			// }
		// });

// var checked=$(".checkboxInp").val();
// 		$('.checkboxInp').each(function(){
// 			if($(this).is(":checked")){
// 				accbrg.push($(this).val());
// 			} 
			// else {
			// 	accbrg.slice($.inArray(checked, accbrg),1);
			// }
		// });
		// accbrg=accbrg.toString();

		$.ajax({
			type: "POST",
			url: "simpan_pengajuan",
			data: {
				rq_id:  id, 
				accbrg: accbrg
			},
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
	// function cek_pilih()
	// {
		
	    // var ceknya = $(".checkbox:checkbox:checked").map(function() {
	    //   return this.value;
	    // }).get();
	    
	//     if (ceknya.length > 0)
	//     {
	//       $("#barangtmbl").removeClass("disabled");
	//     }
	//     else
	//     {
	//       $("#barangtmbl").addClass("disabled");  
	//     }
	//     $("#barangtmbl").attr("onClick","barangtmbl('"+ceknya.join("-")+"')");
	    
	// }
	function terimaRequest(id) {
		event.preventDefault();
		
		$.ajax({
			type: "POST",
			url: "terima_pengajuan",
			data: "rq_id=" + id,
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
		$("#rq_id").val(0);
		$("#frm_request").trigger('reset');
	}

	$("#showPass").click(function() {
		var st = $(this).attr("st");
		if (st == 0) {
			$("#log_passnya").attr("type", "text");
			$("#matanya").removeClass("fa-eye");
			$("#matanya").addClass("fa-eye-slash");
			$(this).attr("st", 1);
		} else {
			$("#log_passnya").attr("type", "password");
			$("#matanya").removeClass("fa-eye-slash");
			$("#matanya").addClass("fa-eye");
			$(this).attr("st", 0);
		}
	});

	$("#yaKonfirm").click(function() {
		var id = $("#rq_id").val();

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
		getRequestDetail();
		drawTable();
			
	});
</script>