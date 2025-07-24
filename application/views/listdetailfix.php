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
					<?php }elseif($fix->status_pgjf == 1 && $level == 4) {  ?>
						<a href="<?php echo base_url();?>Fix/pindahPrint(<?= $fix->pgjf_id ?>)" class="btn btn-success"> Cetak Faktur</a>
					<?php }elseif($fix->status_pgjf == 1 && $level == 6) {  ?>
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

<!-- ======================================================================== -->
<div class="row" id="purchasedata" style="display:none">
	<div class="col-lg-12">
		<div class="card">
			
			<form role="form" name="Purchase" id="frm_purchase">
				<div class="card-body">
				<div class="table-responsive">
					<input type="hidden" id="prcd_id" name="prcd_id">
					<input type="hidden" id="jpjd" name="jpjd">
					<input type="hidden" name="prc_pgjf_id" id="prc_pgjf_id" value="<?= $fix->pgjf_id; ?>">
					<input type="hidden" name="prc_nama" id="prc_nama" value="<?= $fix->pgjf_nama; ?>">


					<h4>Data barang yang telah dibeli</h4>
					<table class="table table-striped table-bordered table-hover" id="tabel-detailpurchase" width="100%" style="font-size:120%;">
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
						<tbody id="viewpurchasedetail">
							
							
						</tbody>
						
					</table>
						
					<div class="col-lg-12" style="display:none;" id="input_purchasedetail">
							<div class="col-lg-12">
								<div class="form-group">
									<label>Nama Barang</label>
									<select class="form-control select" name="prc_brg" id="prc_brg">
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
									<input type="number" min=0 class="form-control rp text-right" onChange="kasikoma('prc_jml')" onKeyUp="kasikoma('prc_jml')" name="prc_jml" id="prc_jml" placeholder="Jumlah Barang" value=0>
								</div>
							</div>
							
							<div class="col-lg-12">
								<div class="form-group">
									<label>Harga Satuan</label>
									<input type="text" class="form-control rp text-right" onChange="kasikoma('prc_harga_satuan')" onKeyUp="kasikoma('prc_harga_satuan')" name="prc_harga_satuan" id="prc_harga_satuan" placeholder="Harga Satuan" value=0>
								</div>
							</div>
							<div class="col-lg-12" style="text-align:center;">
								<a href="#" onClick="batalrequestdetail()" class="btn btn-danger">Batal</a>
								<a href="#" onClick="tambahPurchaseDetail()" class="btn btn-success">Tambah</a>
							</div>
						</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="prc_simpan" class="btn btn-success">Simpan</a>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
				</div>
			</div>
			</form>
			
		</div>
	</div>
</div>

<script type="text/javascript">
	function tambahPurchase(){
		$("#purchasedata").show();
	}
	function tambahPurchaseDetail() {
		event.preventDefault();
		var purchasedetail = $("#prcd_id").val();
		var pj = $("#jpjd").val();
		
		var brg = $("#prc_brg").val();
		var pjdtext = $("#prc_brg option:selected").text().replace(/-/g, "|");
		var pjdt = pjdtext.replace(/&/g, "inisimboldan");

		var jml = $("#prc_jml").val().replace(/\./g, '');
		var hargas = $("#prc_harga_satuan").val().replace(/\./g, '');
		var hrgbrg = jml*hargas;
		
		pj += "-"+"."+ pjdt +"." + brg +"_"+ jml + "." + jml + "_" + hargas + "." + hargas+ "_" + hrgbrg + "." + hrgbrg;
		purchasedetail+=";"+brg+"-"+jml+"-"+hargas+"-"+hrgbrg;
		console.log(pj);		
				
				$("#jpjd").val(pj);
				$("#prcd_id").val(purchasedetail);
				getPurchaseDetail();
				$("#prc_jml").val(0);
				
		
		
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
		var srs = $("#prcd_id").val();
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
	$("#frm_purchase").submit(function(e) {
		e.preventDefault();
		$("#prc_simpan").html("Menyimpan...");
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
					$("#modal_list_detail").modal("hide");
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
	function ajukanPr(id) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "update_pr",
			data: "pgjf_id=" + id,
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
	function approvePr(id) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "approve_pr",
			data: "pgjf_id=" + id,
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

	function pendingPr(id) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "pending_pr",
			data: "pgjf_id=" + id,
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

	function tolakPr(id) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "tolak_pr",
			data: "pgjf_id=" + id,
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

	$(document).ready(function() {
		getPurchaseDetail();
		// drawTable();
	});
</script>