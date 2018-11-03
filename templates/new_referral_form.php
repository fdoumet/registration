<?php
script('registration', 'refer_friend');
?>

<div id="security-password" class="section">
	<h2 class="inlineblock"><?php p($l->t('Refer a friend'));?></h2>
	<span id="refer-error-msg" class="msg success hidden">Saved</span>
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
</div>
