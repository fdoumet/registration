<?php
\OCP\Util::addStyle('registration', 'style');
\OCP\Util::addScript('registration', 'form');
\OCP\Util::addScript('registration', 'track');
if ( \OCP\Util::getVersion()[0] >= 12 )
	\OCP\Util::addStyle('core', 'guest');
?><form action="<?php print_unescaped(\OC::$server->getURLGenerator()->getBaseUrl() . $_SERVER['REQUEST_URI']) ?>" method="post">
	<input type="hidden" name="requesttoken" value="<?php p($_['requesttoken']) ?>" />
	<fieldset>
		<?php if ( !empty($_['errormsgs']) ) {?>
		<ul class="error">
			<?php foreach ( $_['errormsgs'] as $errormsg ) {
				echo "<li>$errormsg</li>";
			} ?>
		</ul>
		<?php } else { ?>
		<ul class="msg">
			<li><?php p($l->t('Welcome, you can create your account below.'));?></li>
		</ul>
		<?php } ?>
		<p class="grouptop">
			<input type="email" name="email" id="email" value="<?php echo $_['email']; ?>" disabled />
			<label for="email" class="infield"><?php echo $_['email']; ?></label>
			<img id="email-icon" class="svg" src="<?php print_unescaped(image_path('', 'actions/mail.svg')); ?>" alt=""/>
		</p>

		<p class="groupmiddle">
			<input type="text" name="displayname" id="displayname" placeholder="<?php p($l->t('Full name')); ?>" />
			<label for="displayname" class="infield"><?php p($l->t('Full name')); ?></label>
			<img id="username-icon" class="svg" src="<?php print_unescaped(image_path('', 'actions/user.svg')); ?>" alt=""/>
		</p>

		<p class="groupmiddle">
			<input type="text" name="username" id="username" value="<?php echo !empty($_['entered_data']['user']) ? $_['entered_data']['user'] : ''; ?>" placeholder="<?php p($l->t('Username')); ?>" />
			<label for="username" class="infield"><?php p($l->t('Username')); ?></label>
			<img id="username-icon" class="svg" src="<?php print_unescaped(image_path('', 'actions/user.svg')); ?>" alt=""/>
		</p>

		<p class="groupbottom">
			<input type="password" name="password" id="password" placeholder="<?php p($l->t('Password')); ?>"/>
			<label for="password" class="infield"><?php p($l->t( 'Password' )); ?></label>
			<img id="password-icon" class="svg" src="<?php print_unescaped(image_path('', 'actions/password.svg')); ?>" alt=""/>
			<input id="show" name="show" type="checkbox">
			<label id="show-password" style="display: inline;" for="show"></label>
		</p>

		<p style="color:white">
			<label for="terms">
				<input class="registration-checkbox" type="checkbox" id="terms" name="terms">
				I agree to the Terms and Conditions
			</label><br/>
		</p>
		<p style="color:white">
			<label for="privacy">
				<input class="registration-checkbox" type="checkbox" id="privacy" name="terms">
				I have read the Privacy Policy
			</label>
		</p><br>

		<input type="submit" id="submit" value="<?php p($l->t('Create account')); ?>" />
	</fieldset>
</form>
