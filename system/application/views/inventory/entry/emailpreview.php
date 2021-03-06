<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Email - <?php echo $current_entry_type['name']; ?> Entry Number <?php echo full_entry_number($entry_type_id, $cur_entry->number); ?></title>
</head>
<body>
	<p><?php echo $this->config->item('account_name'); ?></p>
	<p><?php echo $this->config->item('account_address'); ?></p>
	<p><strong><?php echo $current_entry_type['name']; ?> Entry</strong></p>
	<p><?php echo $current_entry_type['name']; ?> Entry Number : <strong><?php echo full_entry_number($entry_type_id, $cur_entry->number); ?></strong></p>
	<p><?php echo $current_entry_type['name']; ?> Entry Date : <strong><?php echo date_mysql_to_php_display($cur_entry->date); ?></strong></p>

	<table border=1 cellpadding=6>
		<tr>
			<td align=\"right\">
				<?php
					if ($current_entry_type['inventory_entry_type'] == '1')
						echo "Purchase Ledger :";
					else
						echo "Sale Ledger :";
				?>
			</td>
			<td>
				<?php
					$main_account = $cur_entry_main_account->row();
					echo "<span class=\"bold\">" . $this->Ledger_model->get_name($main_account->ledger_id) . "</span>";
				?>
			</td>
		</tr>
		<tr>
			<td align=\"right\">
				<?php
					if ($current_entry_type['inventory_entry_type'] == '1')
						echo "Creditor (Supplier) :";
					else
						echo "Debtor (Customer) :";
				?>
			</td>
			<td>
				<?php
					$main_entity = $cur_entry_main_entity->row();
					echo "<span class=\"bold\">" . $this->Ledger_model->get_name($main_entity->ledger_id) . "</span>";
				?>
			</td>
		</tr>
	</table>

	<br />

	<table border=1 cellpadding=6>
		<thead>
			<tr><th align="left">Inventory Item</th><th>Quantity</th><th>Rate</th><th>Discount</th><th>Total</th></tr>
		</thead>
		<tbody>
			<?php
				foreach ($cur_entry_inventory_items->result() as $row)
				{
					echo "<tr>";
					echo "<td>" . $this->Inventory_Item_model->get_name($row->inventory_item_id) . "</td>";
					echo "<td>" . $row->quantity . "</td>";
					echo "<td>" . $row->rate_per_unit . "</td>";
					echo "<td>" . $row->discount . "</td>";
					echo "<td>" . $row->total . "</td>";
					echo "</tr>";
				}
			?>
		</tbody>
	</table>

	<br />

	<table border=1 cellpadding=6>
		<thead>
			<tr><th align="left">Ledger Account</th><th>Rate</th><th>Dr Amount</th><th>Cr Amount</th></tr>
		</thead>
		<tbody>
		<?php
			$currency = $this->config->item('account_currency_symbol');
			foreach ($cur_entry_ledgers->result() as $row)
			{
				echo "<tr>";
				if ($row->dc == "D")
				{
					echo "<td>Dr " . $this->Ledger_model->get_name($row->ledger_id) . "</td>";
				} else {
					echo "<td>Cr " . $this->Ledger_model->get_name($row->ledger_id) . "</td>";
				}
				echo "<td>" . $row->inventory_rate . "</td>";
				if ($row->dc == "D")
				{
					echo "<td>" . $currency . " " . $row->amount . "</td>";
					echo "<td></td>";
				} else {
					echo "<td></td>";
					echo "<td>" . $currency . " " . $row->amount . "</td>";
				}
				echo "</tr>";
			}
			echo "<tr><td colspan=\"2\">Total</td><td>" . $currency . " " .  $cur_entry->dr_total . "</td><td>" . $currency . " " . $cur_entry->cr_total . "</td></tr>";
		?>
		</tbody>
	</table>
	<br />
	<p>Narration : <span class="value"><?php echo $cur_entry->narration; ?></p>
	<br />
</body>
</html>
