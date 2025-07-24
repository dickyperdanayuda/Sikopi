<div class="row">
	<div class="col-lg-2">Nama Pengajuan </div>
	<div class="col-lg-9">: <?= $pengajuan->pgj_nama; ?></div>
	<div class="col-lg-2">Tanggal </div>
	<div class="col-lg-9">: <?= date("d/m/Y", strtotime($pengajuan->pgj_tgl)) ?></div> 
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
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if($pengajuan->pgj_status == 0){
							$n = 1;
							foreach ($pengajuandetail as $pgj) {
								echo "<tr>
										<td>{$n}</td>
										<td> {$pgj->brg_nama}</td>
										<td> {$pgj->pgjd_jml}</td>
										<td> {$pgj->brg_satuan}</td>
										<td> {$pgj->pgjd_harga_satuan}</td>
										<td> {$pgj->pgjd_hrg_brg}</td>
										<td> 
											<a href='#' onClick='edit_detail(" . $pgj->pgjd_id . ")' data-target='#modal_edit_detail' data-toggle='modal' class='btn btn-info btn-sm' title='Ubah data detail pengajuan'><i class='fa fa-edit'></i></a>
											<a href='#' onClick='hapus_detailp(" . $pgj->pgjd_id . ")' class='btn btn-danger btn-sm' title='Hapus data detail pengajuan'><i class='fa fa-trash-alt'></i></a>
										</td>
										</tr>";
										$n++;
							}
							}else{
								$n = 1;
							foreach ($pengajuandetail as $pgj) {
								echo "<tr>
										<td>{$n}</td>
										<td> {$pgj->brg_nama}</td>
										<td> {$pgj->pgjd_jml}</td>
										<td> {$pgj->brg_satuan}</td>
										<td> {$pgj->pgjd_harga_satuan}</td>
										<td> {$pgj->pgjd_hrg_brg}</td>
										<td>
										</td>
										</tr>";
										$n++;
							}
							}
							?>
							
						</tbody>
						
					</table>
					<?php  if ($pengajuan->pgj_status == 3) { ?>
					
						<a href="#" onClick="tambahPurchase()" class="btn btn-success"> Tambah Data Barang Masuk</a>
					<?php	}else{ } ?>
					
				</div>
			</div>
			<!-- ======================================================================================= -->
			
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
					<input type="hidden" id="pgj_id" name="pgj_id" value="<?= $pengajuan->pgj_id ?>">
					<input type="hidden" id="prcd_id" name="prcd_id">
					<input type="hidden" id="jpjd" name="jpjd">
					<input type="hidden" name="prc_pgjf_id" id="prc_pgjf_id" >
					<input type="hidden" name="prc_nama" id="prc_nama" >

					<div class="col-lg-12">
								<div class="form-group">
									<label>Nama Toko</label>
									<input type="text" class="form-control" name="prc_nama_toko" id="prc_nama_toko" placeholder="Nama Toko">
								</div>
					</div>
					<div class="col-lg-12">
								<div class="form-group">
									<label>Nomor Faktur</label>
									<input type="text" class="form-control" name="prc_no_faktur" id="prc_no_faktur" placeholder="Nomor Faktur">
								</div>
					</div>
					<div class="col-lg-12">
								<div class="form-group">
									<label>Foto Faktur</label>
									<input type="file" class="form-control" name="prc_foto" id="prc_foto" placeholder="">
								</div>
					</div>

					
				</div>
				<div class="modal-footer">
					<button  type="submit" id="prc_simpans" class="btn btn-success"> Validasi Barang Masuk</button>
							<a href="#" onClick="tolakPengajuan(<?= $pengajuan->pgj_id ?>)" class="btn btn-danger"> Tolak </a>	
				</div>
			</div>
			</form>
			
		</div>
	</div>
</div>

<script type="text/javascript">
		$("#frm_purchase").submit(function(e) {
		e.preventDefault();
		$("#prc_simpans").html("Menyimpan...");
		$(".btn").attr("disabled", true);

		// alert('tes');
		$.ajax({
			type: "POST",
			url: "simpan_fix",
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
				$("#prc_simpans").html("Simpan");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#prc_simpans").html("Simpan");
				$(".btn").attr("disabled", false);
				alert('Error get data from ajax');
			}
		});
	});

	
</script>