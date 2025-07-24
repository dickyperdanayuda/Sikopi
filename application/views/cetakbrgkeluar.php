<?php 
	function tanggal($a) {
		$arrBulan = array(1 => "Januari", "Februari", "Maret", "April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		$tgls = explode("-",$a);
		$tgl = $tgls[2];
		$bln = $arrBulan[(int) $tgls[1]];
		$thn = $tgls[0];
		return "$tgl $bln $thn";
	}
?>
<style>
	#cetakFaktur {
		font-family: verdana;
		font-size: 12px;
	}
	th {
		padding: 5px 5px 5px 5px;
	}
</style>
	<!-- Cetak -->
	<div id="cetakFaktur">
		<table border="0" width="100%">
			<tr>
				<td colspan="2" valign="middle" align="center" style="vertical-align:middle;text-transform:uppercase;font-size:24px;">Laporan Barang Keluar </td>
			</tr>
		</table>
		<table width="100%" style="margin-top:20px;font-size:12px;" border="1" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama Barang</th>
					<th>Jumlah</th>
					<th>Satuan</th>
					<th>Peruntukan</th>
					<th>Project</th>
				</tr>
			</thead>
			<tbody>
			<?php 
				$no = 0;
				foreach($barangkeluar as $stb) {
					$no++;
				?>
				<tr>
					<td style="padding:5px 5px 5px 5px;font-size:12px;"><?=$no;?></td>
					<td style="padding:5px 5px 5px 5px;font-size:12px;"><?= "{$stb->brg_nama}";?></td>
					<td style="padding:5px 5px 5px 5px;font-size:12px;"><?= "{$stb->rqd_jml}";?></td>
					<td style="padding:5px 5px 5px 5px;font-size:12px;"><?= "{$stb->brg_satuan}";?></td>
					<td style="padding:5px 5px 5px 5px;font-size:12px;"><?= "{$stb->rq_nama}";?></td>
					<td style="padding:5px 5px 5px 5px;font-size:12px;"><?= "{$stb->nama_project}";?></td>
					
					
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<table border="0" width="100%" style="margin-top:10px;">
			<tr>
				<td width="50%">&nbsp;</td>
				<td width="50%" align="center">Pekanbaru, <?= tanggal(date("Y-m-d"));?></td>
			</tr>
			<tr>
				<td width="50%">&nbsp;</td>
				<td align="center">Hormat Kami,</td>
			</tr>
			<tr>
				<td style="height:50px;">&nbsp;</td>
				<td style="height:50px;" align="center"></td>
			</tr>
			<tr>
				<td width="50%">&nbsp;</td>
				<td align="center">( <?=$this->session->userdata("username");?> )</td>
			</tr>
		</table>
	</div>
	<script>
		window.print();		
		setTimeout(function() {
			window.close();
		}, 1000);
	</script>