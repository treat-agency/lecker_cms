Eine neue Bestellung ist eingetroffen!<br/>
<br/>
<table>
	<tr>
		<td>Vorname:</td>
		<td><?= $order->firstname;?></td>
	</tr>
	<tr>
		<td>Nachname:</td>
		<td><?= $order->lastname;?></td>
	</tr>
	<tr>
		<td>Ort:</td>
		<td><?= $order->city;?></td>
	</tr>
	<tr>
		<td>PLZ:</td>
		<td><?= $order->zip;?></td>
	</tr>
	<tr>
		<td>Strasse:</td>
		<td><?= $order->street;?></td>
	</tr>
	<tr>
		<td>Email:</td>
		<td><?= $order->email;?></td>
	</tr>
	<tr>
		<td>Phone:</td>
		<td><?= $order->phone;?></td>
	</tr>
	<tr>
		<td>Datum:</td>
		<td><?= $order->order_date;?></td>
	</tr>
	
	<? if($order->diff_delivery == 1):?>
	
	<tr>
		<td>Alternative Lieferadresse!</td>
		<td></td>
	</tr>
	
	<tr>
		<td>Name:</td>
		<td><?= $order->delivery_name;?></td>
	</tr>
	
	<tr>
		<td>Ort:</td>
		<td><?= $order->delivery_city;?></td>
	</tr>
	
	<tr>
		<td>PLZ:</td>
		<td><?= $order->delivery_zip;?></td>
	</tr>
	
	<tr>
		<td>Strasse:</td>
		<td><?= $order->delivery_street;?></td>
	</tr>
	<tr>
		<td>Land:</td>
		<td><?= $order->delivery_country;?></td>
	</tr>
	
	<? endif;?>
	
</table>
<br/>
<br/>
Produkte:<br/>
<table>
	<? foreach($items as $item):?>
		<tr>
			<td><?= $item->desc?></td>
			<td style="width:20px;"></td>
			<td><?= $item->quantity;?> Stk.</td>
		</tr>
	<? endforeach;?>
</table>
<br/>
<br/>
Sie können Bestellungen über das <a href="https://cms.hdgoe.at">CMS</a> bearbeiten.