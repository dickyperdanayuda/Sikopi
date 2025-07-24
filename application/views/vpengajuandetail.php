<?php
$total = 0;
if (!empty($list_pengajuandetail)) {
	$data = explode("-", $list_pengajuandetail);
	$max = count($data);

	if ($max > 0) {
		for ($i = 1; $i < $max; $i++) { ?>
			<tr>
				<td><?= $i; ?></td>
				<?php
				$list = explode("_", $data[$i]);

				for ($j = 0; $j < 4; $j++) {
					$list_text = explode(".", $list[$j]);
					
					if ($j == 3) {
						$total += $list_text[1];
					}
					if ($j == 0) {
						$list_text[1] = str_replace("inisimboldan", "&", str_replace("|", "-", $list_text[1]));


					}
				?>
					<td><?= $list_text[1]; ?></td>
				<?php
				}
				?>
				<td><a href="javascript:void()" onClick="hapusPengajuanDetail('<?= $data[$i]; ?>')" class="btn btn-danger btn-circle"><i class="fa fa-times" /></a></td>
			</tr>
<?php
		}
	}
}
?>
<tr>
	<td colspan="5" align="right" style="font-size:18px;font-weight:bold;">Total<input type="hidden" id="pjl_total_belanja" name="pjl_total_belanja" value=<?= $total; ?>></td>
	<td colspan="2" style="text-align:right;font-size:18px;font-weight:bold;"><?= number_format($total, 0, ",", "."); ?></td>
</tr>
<tr>
	<td colspan="7" align="center"><a href="#" onClick="inputPengajuanDetail()" class="btn btn-success"><i class="fa fa-plus"></i> &nbsp;&nbsp;&nbsp; Tambah Detail Pengajuan</a></td>
</tr>
<script>
	
</script>