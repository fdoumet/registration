<?php
\OCP\Util::addStyle('registration', 'style');
#\OCP\Util::addScript('registration', 'form');
?><form action="<?php print_unescaped(\OC::$server->getURLGenerator()->linkToRoute('registration.referrals.newReferral')) ?>" method="post">
	<fieldset>
		<?php if ( !empty($_['errormsgs']) ) {?>
		<ul class="error">
			<?php foreach ( $_['errormsgs'] as $errormsg ) {
				echo "<li>$errormsg</li>";
			} ?>
		</ul>
		<?php } else { ?>
		<ul class="msg">
			<li><?php p($l->t('Welcome, you can create your referral below.'));?></li>
		</ul>
		<?php } ?>
		<p class="grouptop">
			<input type="email" name="email" id="email"/>
			<label for="email" class="infield"><?php echo $_['email']; ?></label>
			<img id="email-icon" class="svg" src="<?php print_unescaped(image_path('', 'actions/mail.svg')); ?>" alt=""/>
		</p>

		<input type="submit" id="submit" value="<?php p($l->t('Send referral')); ?>" />
	</fieldset>
</form>
