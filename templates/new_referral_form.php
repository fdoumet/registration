<?php
	script('registration', 'refer_friend');
?>

<style>
	table, th, td {
		border: 1px solid black;

	}
	th, td {
		padding: 15px;
		text-align: left;
	}
	th {
		font-weight: bold;
	}
</style>

<div id="security-password" class="section">
	<h2 class="inlineblock"><b><?php p($l->t('Get up to 10GB of free PixelDrive space!'));?></b></h2>
	<h3 class="inlineblock"><?php p($l->t('Invite your friends to join PixelDrive. For each new sign up, we’ll give you both 500 MB of bonus space. If you need even more space, '));?><u><a href="/index.php/settings/user/payments"><?php p($l->t('upgrade your account.'))?></a></u></h3>
	<span id="refer-error-msg" class="msg success hidden">Sent</span>
	<div class="personal-settings-setting-box">
		<form id="passwordform">
			<div class="personal-show-container">
				<label for="email" class="hidden-visually"><?php p($l->t('Email'));?>: </label>
				<input type="email" id="email" name="email"
					   placeholder="<?php p($l->t('Email')); ?>"
					   autocomplete="off" autocapitalize="none" autocorrect="off" />
			</div>

			<input id="referbutton" type="submit" value="<?php p($l->t('Submit Referral')); ?>" />

		</form>
	</div>
	<span class="msg"></span>
	<br><br>
	<button id="toggleReferrerStatus">View Referral Status</button>
</div>

<div id="referral-status" class="section" style="display: none">
	<h2 class="inlineblock"><?php p($l->t('Status'));?></h2><br>
	<?php if (!empty($_['referrals'])){ ?>
		<table>
			<thead>
				<tr>
					<th>Email</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($_['referrals'] as $referral) { ?>
					<tr>
						<td><?php p($referral->getReferreeEmail()) ?></td>
						<td><?php ($referral->getStatus() == 0) ? p('Pending') : p('Complete')?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php } else { ?>
		<span id="no-referrals-msg">No referrals found</span>
	<?php } ?>
</div>
