<table class="tickets" data-type="<?php echo $type ?>">
	<thead>
		<tr>
			<th class="status"></th>
			<th class="star"></th>
			<th class="id"><a href="#">#</a></th>
			<th class="summary"><a href="#">Summary</a></th>
			<th class="assigned"><a href="#">Assigned</a></th>
			<th class="last"><a href="#">Last</a></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="7">
				<form class="filter">
					Showing
					<select name="status">
						<?php foreach ($statuses as $status): ?>
						<option value="<?php echo $status['type']; ?>"<?php echo $status['sel'] ? ' selected' : ''; ?>><?php echo strtolower($status['name']); ?></option>
						<?php endforeach; ?>
					</select>
					tickets
				</form>
			</td>
		</tr>
	</tfoot>
	<tbody>
	<?php foreach ($issues as $issue): ?>
	
	<tr class="ticket<?php echo $issue['pinned'] ? ' pinned' : '' ?>" data-id="<?php echo $issue['id'] ?>">
		<td class="status"><div style="background:<?php echo $issue['status_color'] ?>"></div></td>
		<td class="favorite"><a href="javascript:;"><img src="<?php echo $location['images']; ?>/star-<?php echo $issue['favorite'] ? 'on' : 'off' ?>.png" alt="<?php echo $issue['favorite'] ? '&#9733;' : '&#9734;' ?>" /></a></td>
		<td class="id"><?php echo $issue['id']; ?></td>
		<td class="summary">
			<a href="ticket.php?id=<?php echo $issue['id'] ?>"><?php echo $issue['name'] ?></a>
			
			<?php
			$tags = explode(' ', $issue['tags']); // todo: use the separate table for tags instead of one long string
			foreach ($tags as $tag)
			{
				echo '<span class="tag"><a href="#">' . $tag . '</a></span>';
			}
			?>
			
		</td>
		<td class="assigned<?php echo $issue['assign'] == $_SESSION['uid'] && $issue['status'] < 3 ? ' you' : '' ?>"><?php echo $issue['assign'] > 0 ? '<a href="profile.php?id=' . $issue['assign'] . '">' . getunm($issue['assign']) . '</a>' : '--' ?></td>
		<td class="last"><?php echo timeago($issue['when_updated'], false, true) ?></td>
	</tr>
	
	<?php endforeach; ?>
	</tbody>
</table>