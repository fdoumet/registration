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
	<h2 class="inlineblock"><?php p($l->t('Refer a friend'));?></h2>
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
	<table>
		<tr>
			<th>Email</th>
			<th>Status</th>
		</tr>
		<?php foreach ($_['referrals'] as $referral) { ?>
			<tr>
				<td><?php p($referral->getReferreeEmail()) ?></td>
				<td><?php ($referral->getStatus() == 0) ? p('Pending') : p('Complete')?></td>
			</tr>
		<?php } ?>
	</table>
</div>
