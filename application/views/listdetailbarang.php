<div class="row">
	<div class="col-lg-2">Nama Pengajuan </div>
	<div class="col-lg-9">: <?= $barangmasuk->prc_nama; ?></div>
	<div class="col-lg-2">Tanggal </div>
	<div class="col-lg-9">: <?= date("d/m/Y", strtotime($barangmasuk->prc_tgl)) ?></div> 
	<div class="col-lg-2">Status Pengajuan </div>
	<?php if($barangmasuk->status_pgjf == 0) {?>
		<div class="col-lg-9">: <i class='badge bg-warning'><b>Menunggu Purchasing</b></i></div> 
	<?php }elseif($barangmasuk->status_pgjf == 1) { ?>
		<div class="col-lg-9">: <i class='badge bg-warning'><b>Sedang Purchase Request</b></i></div> 
	<?php }elseif($barangmasuk->status_pgjf == 2) { ?>
		<div class="col-lg-9">: <i class='badge bg-warning'><b>Sedang Purchase Order</b></i></div> 
	<?php }elseif($barangmasuk->status_pgjf == 3) { ?>
		<div class="col-lg-9">: <i class='badge bg-info'><b>Approve Direktur</b></i></div> 
	<?php }elseif($barangmasuk->status_pgjf == 4) { ?>
		<div class="col-lg-9">: <i class='badge bg-warning'><b>Pending</b></i></div> 
	<?php }elseif($barangmasuk->status_pgjf == 5) { ?>
		<div class="col-lg-9">: <i class='badge bg-danger'><b>Ditolak</b></i></div> 
		<?php }elseif($barangmasuk->status_pgjf == 6) { ?>
		<div class="col-lg-9">: <i class='badge bg-success'><b>Diterima Gudang</b></i></div>
		<?php }elseif($barangmasuk->status_pgjf == 7) { ?>
		<div class="col-lg-9">: <i class='badge bg-success'><b>Diluar Pengajuan</b></i></div>
	<?php } ?>
	<div class="col-lg-2">Sumber </div>
	<div class="col-lg-9">: <?= $barangmasuk->prc_sumber; ?></div>
	
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
							foreach ($barangdetail as $pgj) {
								echo "<tr>
										<td>{$n}</td>
										<td> {$pgj->brg_nama}</td>
										<td> {$pgj->prcd_jml}</td>
										<td> {$pgj->brg_satuan}</td>
										<td> {$pgj->prcd_harga_satuan}</td>
										<td> {$pgj->prcd_hrg_brg}</td>
										</tr>";
										$n++;
							}
							?>
							
						</tbody>
						
					</table>
					<?php if($barangmasuk->status_pgjf == 2 && $level == 3) {?>
						<a href="#" onClick="terimaBarang()" class="btn btn-success"> Tambah Data Barang Telah Diterima</a>
					<?php }else{  ?>
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
			
			<form role="form" name="Purchase" id="frm_barang">
				<div class="card-body">
				<div class="table-responsive">
					<input type="hidden" id="prc_id" name="prc_id" value="<?= $barangmasuk->prc_id; ?>">
					<input type="hidden" id="prcd_id" name="prcd_id">
					<input type="hidden" id="jpjd" name="jpjd">
					<input type="hidden" name="prc_pgjf_id" id="prc_pgjf_id" value="<?= $barangmasuk->prc_pgjf_id; ?>">
					<input type="hidden" name="prc_nama" id="prc_nama" value="<?= $barangmasuk->prc_nama; ?>">


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
						<tbody id="viewbarangdetail">
							
							
						</tbody>
						
					</table>
						
					<div class="col-lg-12" style="display:none;" id="input_barangdetail">
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
	function terimaBarang(){
		$("#purchasedata").show();
	}
	function inputBarangDetail() {
		event.preventDefault();
		$("#input_barangdetail").slideDown(100);
	}
	function tambahPurchaseDetail() {
		event.preventDefault();
		var barangdetail = $("#prcd_id").val();
		var pj = $("#jpjd").val();
		
		var brg = $("#prc_brg").val();
		var pjdtext = $("#prc_brg option:selected").text().replace(/-/g, "|");
		var pjdt = pjdtext.replace(/&/g, "inisimboldan");

		var jml = $("#prc_jml").val().replace(/\./g, '');
		var hargas = $("#prc_harga_satuan").val().replace(/\./g, '');
		var hrgbrg = jml*hargas;
		
		pj += "-"+"."+ pjdt +"." + brg +"_"+ jml + "." + jml + "_" + hargas + "." + hargas+ "_" + hrgbrg + "." + hrgbrg;
		barangdetail+=";"+brg+"-"+jml+"-"+hargas+"-"+hrgbrg;
		console.log(pj);		
				
				$("#jpjd").val(pj);
				$("#prcd_id").val(barangdetail);
				getBarangDetail();
				$("#prc_jml").val();
				
		
		
	}
	
	function getBarangDetail() {
		var barangdetail = $("#jpjd").val();
		// var purchasedetail = 86;
		// console.log(purchasedetail);
		// $.get('view_penjualandetail/'+requestdetail, {}, function(d) {
		// $("#view_penjualandetail").html(d);
		// });
		$.ajax({
			type: "POST",
			url: "view_brgdetail/",
			data: 'jpjd=' + barangdetail,
			success: function(d) {
				
				$("#viewbarangdetail").html(d);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});
	}
	function hapusBarangDetail(hapus) {
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
		getBarangDetail();
		toastr.success('Berhasi menghapus item');
	}
	$("#frm_barang").submit(function(e) {
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
				console.log(res);
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
	$(document).ready(function() {
		getBarangDetail();
		// drawTable();
	});
</script>