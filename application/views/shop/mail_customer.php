Liebe Empfängerin, lieber Empfänger!<br/>
<br/>
Vielen Dank für Ihre Bestellung auf <a href="<?= site_url() ?>"><?= site_url() ?></a>.<br/>
Sie haben folgende Produkte bestellt:<br/>
<br/>
<table>
	<? foreach($items as $item):?>
		<tr>
			<td><?= $item->desc?></td>
			<td style="width:20px;"></td>
			<td><?= $item->quantity;?> Stk.</td>
			<td style="width:20px;"></td>
			<td>€ <?=  number_format($item->price*$item->quantity,2,',', ' ');?></td>
		</tr>
	<? endforeach;?>
</table>
<br/>
<br/>
Im Anhang befindet sich Ihre Rechnung.