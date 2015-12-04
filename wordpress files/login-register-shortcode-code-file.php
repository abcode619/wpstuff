<?php 

add_shortcode( 'ap-register', 'renderRegisterShortCode' );
add_shortcode( 'ap-login', 'renderLoginShortCode' );

add_action( 'wp', 'ab_registration_process' );


function renderLoginShortCode( $attributes ) {

	global $ab_login_errors;

	?>   
	<?php if( !is_user_logged_in() ) { ?>

		<h2><?php echo esc_html( __( 'Login', 'esbab' ) ) ?></h2>
		
		<form action="" method="post">
			
			<div class="ab-row-fluid">
			
				<div class="ab-formGroup ab-lastGroup ab-full">
					<label class="ab-formLabel"><?php echo esc_html( __( 'Username', 'esbab' ) ) ?></label>
					<div class="ab-formField">
						<input class="ab-formElement ab-user-login ab-required" maxlength="40" type="text" name="ab_userl_login" value="<?php echo isset( $_POST['ab_userl_login'] ) ? $_POST['ab_userl_login'] : ''; ?>"/>
					</div>
					<div class="ab-user-login-error ab-label-error ab-bold">
						<?php echo !empty( $ab_login_errors['ab_userl_login'] ) ? $ab_login_errors['ab_userl_login'] : '';?>
					</div>
				</div>
				<div class="ab-formGroup ab-lastGroup ab-full">
					<label class="ab-formLabel"><?php echo esc_html( __( 'Password', 'esbab' ) ) ?></label>
					<div class="ab-formField">
						<input class="ab-formElement ab-user-pass ab-required" type="password" name="ab_userl_pass" value="" maxlength="60"/>
					</div>
					<div class="ab-user-pass-error ab-label-error ab-bold">
						<?php echo !empty( $ab_login_errors['ab_userl_pass'] ) ? $ab_login_errors['ab_userl_pass'] : '';?>
					</div>
				</div>
				
			</div>
			
			<div class="ab-row-fluid ab-nav-steps ab-clear">
				<input type="submit" name="ab_user_login" id="ab_user_login" class="ab-right ab-to-fourth-step ab-btn ladda-button orange zoom-in" value="<?php _e( 'Sign In', 'esbab' ) ?>" />
			</div>
			
		</form>

	<?php } ?>

	<?php
}

function renderRegisterShortCode( $attributes ) {
	
	global $ab_errors, $user_ID;

		$user_id = $user_ID;
		
		$remind_options = array(
                                            ''      => __( 'None', 'esbab' ),
                                            '1'     => __( '1 hour before', 'esbab' ),
                                            '12'    => __( '12 hours before', 'esbab' ),
                                            '24'    => __( '24 hours before', 'esbab' ),
                                        );

		//Personal Information
		$fullname       = get_user_meta( $user_id, 'ab_user_full_name', true ); //get user full name
		$userphone      = get_user_meta( $user_id, 'ab_user_phone', true ); //get user home phone number
		$userworkphone  = get_user_meta( $user_id, 'ab_user_work_phone', true ); //get user work phone number
		$usercellphone  = get_user_meta( $user_id, 'ab_user_cell_phone', true ); //get user cell phone number
		
		$userstreet     = get_user_meta( $user_id, 'ab_user_street', true ); //get user street
		$usercity       = get_user_meta( $user_id, 'ab_user_city', true ); //get user city
		$userstate      = get_user_meta( $user_id, 'ab_user_state', true ); //get user state
		$userzip        = get_user_meta( $user_id, 'ab_user_zip', true ); //get user zip
		
		$userworkstreet = get_user_meta( $user_id, 'ab_user_work_street', true ); //get user work street
		$userworkcity   = get_user_meta( $user_id, 'ab_user_work_city', true ); //get user work city
		$userworkstate  = get_user_meta( $user_id, 'ab_user_work_state', true ); //get user work state
		$userworkzip    = get_user_meta( $user_id, 'ab_user_work_zip', true ); //get user work zip
		$user_billing_address_choice    = get_user_meta( $user_id, 'ab_user_billing_address_choice', true ); //get user billing address choice
		
		$userdob        = get_user_meta( $user_id, 'ab_user_dob', true ); //get user date of birth
		$userage        = get_user_meta( $user_id, 'ab_user_age', true ); //get user age
		$usersex        = get_user_meta( $user_id, 'ab_user_sex', true ); //get user sex
		$useremergencycontactname     = get_user_meta( $user_id, 'ab_user_emergency_contact_name', true ); //get user emergency contact name
		$useremergencycontact   = get_user_meta( $user_id, 'ab_user_emergency_contact', true ); //get user emergency contact
		$userresponsibleparty   = get_user_meta( $user_id, 'ab_user_responsible_party', true ); //get user responsible party
		
		$useresignature = get_user_meta( $user_id, 'ab_user_esignature', true ); //get user esignature
		$userremind     = get_user_meta( $user_id, 'ab_user_remind', true ); //get user remind

		//Credit Card Information
		$cardnumber     = get_user_meta( $user_id, 'ab_card_number', true ); //get user credit card number
		$cardmonth      = get_user_meta( $user_id, 'ab_card_month', true ); //get user credit card expiration month
		$cardyear       = get_user_meta( $user_id, 'ab_card_year', true ); //get user credit card expiration year
		$cardcode       = get_user_meta( $user_id, 'ab_card_code', true ); //get user credit card security code
	
		$ab_user_fname          = isset( $_POST['ab_user_fname'] ) ? $_POST['ab_user_fname'] : $fullname;
		$ab_user_phone          = isset( $_POST['ab_user_phone'] ) ? $_POST['ab_user_phone'] : $userphone;
		$ab_user_work_phone     = isset( $_POST['ab_user_work_phone'] ) ? $_POST['ab_user_work_phone'] : $userworkphone;
		$ab_user_cell_phone     = isset( $_POST['ab_user_cell_phone'] ) ? $_POST['ab_user_cell_phone'] : $usercellphone;
		
		$ab_user_street = isset( $_POST['ab_user_street'] ) ? $_POST['ab_user_street'] : $userstreet;
		$ab_user_city   = isset( $_POST['ab_user_city'] ) ? $_POST['ab_user_city'] : $usercity;
		$ab_user_state  = isset( $_POST['ab_user_state'] ) ? $_POST['ab_user_state'] : $userstate;
		$ab_user_zip    = isset( $_POST['ab_user_zip'] ) ? $_POST['ab_user_zip'] : $userzip;
		
		$ab_user_work_street    = isset( $_POST['ab_user_work_street'] ) ? $_POST['ab_user_work_street'] : $userworkstreet;
		$ab_user_work_city      = isset( $_POST['ab_user_work_city'] ) ? $_POST['ab_user_work_city'] : $userworkcity;
		$ab_user_work_state     = isset( $_POST['ab_user_work_state'] ) ? $_POST['ab_user_work_state'] : $userworkstate;
		$ab_user_work_zip       = isset( $_POST['ab_user_work_zip'] ) ? $_POST['ab_user_work_zip'] : $userworkzip;
		$ab_user_billing_address_choice       = isset( $_POST['ab_user_billing_address_choice'] ) ? $_POST['ab_user_billing_address_choice'] : $user_billing_address_choice;
		
		$ab_user_dob            = isset( $_POST['ab_user_dob'] ) ? $_POST['ab_user_dob'] : $userdob;
		$ab_user_age            = isset( $_POST['ab_user_age'] ) ? $_POST['ab_user_age'] : $userage;
		$ab_user_sex            = isset( $_POST['ab_user_sex'] ) ? $_POST['ab_user_sex'] : $usersex;
		$ab_user_emergency_contact_name  = isset( $_POST['ab_user_emergency_contact_name'] ) ? $_POST['ab_user_emergency_contact_name'] : $useremergencycontactname;
		$ab_user_emergency_contact  = isset( $_POST['ab_user_emergency_contact'] ) ? $_POST['ab_user_emergency_contact'] : $useremergencycontact;
		$ab_user_responsible_party  = isset( $_POST['ab_user_responsible_party'] ) ? $_POST['ab_user_responsible_party'] : $userresponsibleparty;
	
		$ab_user_login          = isset( $_POST['ab_user_login'] ) ? $_POST['ab_user_login'] : '';
		$ab_user_email          = isset( $_POST['ab_user_email'] ) ? $_POST['ab_user_email'] : '';
		
		$ab_user_esignature     = isset( $_POST['ab_user_esignature'] ) ? $_POST['ab_user_esignature'] : $useresignature;
		$ab_user_remind         = isset( $_POST['ab_user_remind'] ) ? $_POST['ab_user_remind'] : $userremind;
	?>
		<h2><?php echo esc_html( __( 'Register', 'esbab' ) ) ?></h2>

		<form action="" method="post">
			
			<div class="ab-row-fluid">
				<div class="ab-formGroup ab-left ab-w-50">
					<label class="ab-formLabel"><?php echo esc_html( __( 'Full Name', 'esbab' ) ) ?></label>
					<div class="ab-formField">
						<input class="ab-formElement ab-full-fname ab-required" type="text" name="ab_user_fname" value="<?php echo $ab_user_fname; ?>" maxlength="60"/>
					</div>
					<div class="ab-user-fname-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_user_fname'] ) ? $ab_errors['ab_user_fname'] : '';?>
					</div>
				</div>
				<div class="ab-formGroup ab-left ab-lastGroup ab-w-50">
					<label class="ab-formLabel"><?php echo esc_html( __( 'Home Phone', 'esbab' ) ) ?></label>
					<div class="ab-formField">
						<input class="ab-formElement ab-user-phone" maxlength="14" type="text" name="ab_user_phone" value="<?php echo $ab_user_phone; ?>" placeholder="(XXX) XXX-XXXX" />
					</div>
					<div class="ab-user-phone-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_user_phone'] ) ? $ab_errors['ab_user_phone'] : '';?>
					</div>
				</div>
				<div class="ab-formGroup ab-left ab-w-50">
					<label class="ab-formLabel"><?php echo esc_html( __( 'Work Phone', 'esbab' ) ) ?></label>
					<div class="ab-formField">
						<input class="ab-formElement ab-work-phone" type="text" name="ab_user_work_phone" value="<?php echo $ab_user_work_phone; ?>" maxlength="14" placeholder="(XXX) XXX-XXXX" />
					</div>
					<div class="ab-user-work-phone-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_user_work_phone'] ) ? $ab_errors['ab_user_work_phone'] : '';?>
					</div>
				</div>
				<div class="ab-formGroup ab-left ab-lastGroup ab-w-50">
					<label class="ab-formLabel"><?php echo esc_html( __( 'Cell Phone', 'esbab' ) ) ?></label>
					<div class="aDate of BirthDate of Birthb-formField">
						<input class="ab-formElement ab-cell-phone ab-required ab-numeric" type="text" name="ab_user_cell_phone" value="<?php echo $ab_user_cell_phone; ?>" maxlength="14" placeholder="(XXX) XXX-XXXX" />
					</div>
					<div class="ab-user-cell-phone-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_user_cell_phone'] ) ? $ab_errors['ab_user_cell_phone'] : '';?>
					</div>
				</div>
			</div>
			
			<div class="ab-row-fluid">
				<h4><label class="ab-formLabel"><?php echo esc_html( __( 'Home Address:', 'esbab' ) ) ?></label></h4>
				<div class="ab-formGroup ab-left ab-w-50">
					<label class="ab-formLabel"><?php echo esc_html( __( 'Street', 'esbab' ) ) ?></label>
					<div class="ab-formField">
						<input class="ab-formElement ab-user-street" type="text" name="ab_user_street" value="<?php echo $ab_user_street; ?>" />
					</div>
					<div class="ab-user-street-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_user_street'] ) ? $ab_errors['ab_user_street'] : '';?>
					</div>
				</div>
				<div class="ab-formGroup ab-left ab-lastGroup ab-w-50">
					<label class="ab-formLabel"><?php echo esc_html( __( 'City', 'esbab' ) ) ?></label>
					<div class="ab-formField">
						<input class="ab-formElement ab-user-city" type="text" name="ab_user_city" value="<?php echo $ab_user_city; ?>" />
					</div>
					<div class="ab-user-city-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_user_city'] ) ? $ab_errors['ab_user_city'] : '';?>
					</div>
				</div>
				<div class="ab-formGroup ab-left ab-w-50">
					<label class="ab-formLabel"><?php echo esc_html( __( 'State', 'esbab' ) ) ?></label>
					<div class="ab-formField">
						<input class="ab-formElement ab-user-state" type="text" name="ab_user_state" value="<?php echo $ab_user_state; ?>" />
					</div>
					<div class="ab-user-state-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_user_state'] ) ? $ab_errors['ab_user_state'] : '';?>
					</div>
				</div>
				<div class="ab-formGroup ab-left ab-lastGroup ab-w-50">
					<label class="ab-formLabel"><?php echo esc_html( __( 'Zip', 'esbab' ) ) ?></label>
					<div class="ab-formField">
						<input class="ab-formElement ab-user-zip" type="text" name="ab_user_zip" value="<?php echo $ab_user_zip; ?>" maxlength="6"/>
					</div>
					<div class="ab-user-zip-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_user_zip'] ) ? $ab_errors['ab_user_zip'] : '';?>
					</div>
				</div>
			</div>
			
			<div class="ab-row-fluid">
				<h4><label class="ab-formLabel"><?php echo esc_html( __( 'Work Address:', 'esbab' ) ) ?></label></h4>
				<div class="ab-formGroup ab-left ab-w-50">
					<label class="ab-formLabel"><?php echo esc_html( __( 'Street', 'esbab' ) ) ?></label>
					<div class="ab-formField">
						<input class="ab-formElement ab-user-work-street" type="text" name="ab_user_work_street" value="<?php echo $ab_user_work_street; ?>" />
					</div>
					<div class="ab-user-work-street-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_user_work_street'] ) ? $ab_errors['ab_user_work_street'] : '';?>
					</div>
				</div>
				<div class="ab-formGroup ab-left ab-lastGroup ab-w-50">
					<label class="ab-formLabel"><?php echo esc_html( __( 'City', 'esbab' ) ) ?></label>
					<div class="ab-formField">
						<input class="ab-formElement ab-user-work-city" type="text" name="ab_user_work_city" value="<?php echo $ab_user_work_city; ?>" />
					</div>
					<div class="ab-user-work-city-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_user_work_city'] ) ? $ab_errors['ab_user_work_city'] : '';?>
					</div>
				</div>
				<div class="ab-formGroup ab-left ab-w-50">
					<label class="ab-formLabel"><?php echo esc_html( __( 'State', 'esbab' ) ) ?></label>
					<div class="ab-formField">
						<input class="ab-formElement ab-user-work-state" type="text" name="ab_user_work_state" value="<?php echo $ab_user_work_state; ?>" />
					</div>
					<div class="ab-user-work-state-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_user_work_state'] ) ? $ab_errors['ab_user_work_state'] : '';?>
					</div>
				</div>
				<div class="ab-formGroup ab-left ab-lastGroup ab-w-50">
					<label class="ab-formLabel"><?php echo esc_html( __( 'Zip', 'esbab' ) ) ?></label>
					<div class="ab-formField">
						<input class="ab-formElement ab-user-work-zip" type="text" name="ab_user_work_zip" value="<?php echo $ab_user_work_zip; ?>" maxlength="6"/>
					</div>
					<div class="ab-user-work-zip-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_user_work_zip'] ) ? $ab_errors['ab_user_work_zip'] : '';?>
					</div>
				</div>
				<div class="ab-formGroup ab-left ab-w-50">
					<label class="ab-formLabel"><?php echo esc_html( __( 'Billing Address', 'esbab' ) ) ?></label>
					<div class="ab-formField">
						<select class="ab-formElement ab-user-billing-address-choice" name="ab_user_billing_address_choice">
							<option value="Home" <?php selected( $ab_user_billing_address_choice, 'Home' ) ?>><?php echo __( 'Home', 'esbab' ); ?></option>
							<option value="Work" <?php selected( $ab_user_billing_address_choice, 'Work' ) ?>><?php echo __( 'Work', 'esbab' ); ?></option>
						</select>
					</div>
					<div class="ab-user-billing-address-choice-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_user_billing_address_choice'] ) ? $ab_errors['ab_user_billing_address_choice'] : '';?>
					</div>
				</div>
			</div>
			
			<div class="ab-row-fluid">
				<div class="ab-formGroup ab-left ab-w-50">
					<label class="ab-formLabel"><?php echo esc_html( __( 'Date of Birth', 'esbab' ) ) ?></label>
					<div class="ab-formField">
						<input id="datepicker" class="ab-formElement ab-user-dob ab-required" type="text" name="ab_user_dob" value="<?php echo $ab_user_dob; ?>" placeholder="XX/XX/XXXX" />
					</div>
					<div class="ab-user-dob-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_user_dob'] ) ? $ab_errors['ab_user_dob'] : '';?>
					</div>
				</div>
				<div class="ab-formGroup ab-left ab-lastGroup ab-w-50">
					<label class="ab-formLabel"><?php echo esc_html( __( 'Age', 'esbab' ) ) ?></label>
					<div class="ab-formField">
						<input class="ab-formElement ab-user-age ab-required" type="text" name="ab_user_age" value="<?php echo $ab_user_age; ?>" maxlength="3"/>
					</div>
					<div class="ab-user-age-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_user_age'] ) ? $ab_errors['ab_user_age'] : '';?>
					</div>
				</div>
				<div class="ab-formGroup ab-left ab-w-50">
					<label class="ab-formLabel"><?php echo esc_html( __( 'Sex', 'esbab' ) ) ?></label>
					<div class="ab-formField">
						<select class="ab-formElement ab-user-sex" style="float: left;" name="ab_user_sex">
							<option value="Male" <?php selected( $ab_user_sex, 'Male' ) ?>><?php echo __( 'Male', 'esbab' ); ?></option>
							<option value="Female" <?php selected( $ab_user_sex, 'Female' ) ?>><?php echo __( 'Female', 'esbab' ); ?></option>
						</select>
					</div>
					<div class="ab-user-sex-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_user_sex'] ) ? $ab_errors['ab_user_sex'] : '';?>
					</div>
				</div>
				<div class="ab-formGroup ab-left ab-lastGroup ab-w-50">
					<label class="ab-formLabel"><?php echo esc_html( __( 'Responsible Party (If Minor)', 'esbab' ) ) ?></label>
					<div class="ab-formField">
						<input class="ab-formElement ab-user-responsible-party" type="text" name="ab_user_responsible_party" value="<?php echo $ab_user_responsible_party; ?>" />
					</div>
					<div class="ab-user-responsible-party-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_user_responsible_party'] ) ? $ab_errors['ab_user_responsible_party'] : '';?>
					</div>
				</div>
			</div>
			
			<div class="ab-row-fluid">
				<div class="ab-formGroup ab-left ab-w-50">
					<label class="ab-formLabel"><?php echo esc_html( __( 'Emergency Contact Name', 'esbab' ) ) ?></label>
					<div class="ab-formField">
						<input class="ab-formElement ab-user-emergency-contact-name ab-required" type="text" name="ab_user_emergency_contact_name" value="<?php echo $ab_user_emergency_contact_name; ?>" />
					</div>
					<div class="ab-user-emergency-contact-name-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_user_emergency_contact_name'] ) ? $ab_errors['ab_user_emergency_contact_name'] : '';?>
					</div>
				</div>
				<div class="ab-formGroup ab-left ab-lastGroup ab-w-50">
					<label class="ab-formLabel"><?php echo esc_html( __( 'Emergency Contact Phone', 'esbab' ) ) ?></label>
					<div class="ab-formField">
						<input class="ab-formElement ab-user-emergency-contact ab-required ab-numeric" type="text" name="ab_user_emergency_contact" value="<?php echo $ab_user_emergency_contact; ?>" maxlength="14" placeholder="(XXX) XXX-XXXX" />
					</div>
					<div class="ab-user-emergency-contact-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_user_emergency_contact'] ) ? $ab_errors['ab_user_emergency_contact'] : '';?>
					</div>
				</div>
			</div>
			
		<?php if( !is_user_logged_in() ) { ?>
			<div class="ab-row-fluid">
				<div class="ab-formGroup ab-left ab-w-50">
					<label class="ab-formLabel"><?php echo esc_html( __( 'Username', 'esbab' ) ) ?></label>
					<div class="ab-formField">
						<input class="ab-formElement ab-user-login ab-required" maxlength="40" type="text" name="ab_user_login" value="<?php echo $ab_user_login; ?>"/>
					</div>
					<div class="ab-user-login-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_user_login'] ) ? $ab_errors['ab_user_login'] : '';?>
					</div>
				</div>
				<div class="ab-formGroup ab-left ab-lastGroup ab-w-50">
					<label class="ab-formLabel"><?php echo esc_html( __( 'Email', 'esbab' ) ) ?></label>
					<div class="ab-formField">
						<input id="ab_user_email" class="ab-formElement ab-user-email ab-required" maxlength="40" type="text" name="ab_user_email" value="<?php echo $ab_user_email; ?>"/>
					</div>
					<div class="ab-user-email-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_user_email'] ) ? $ab_errors['ab_user_email'] : '';?>
					</div>
				</div>
				<div class="ab-formGroup ab-left ab-w-50">
					<label class="ab-formLabel"><?php echo esc_html( __( 'Password', 'esbab' ) ) ?></label>
					<div class="ab-formField">
						<input class="ab-formElement ab-user-pass ab-required" type="password" name="ab_user_pass" value="" maxlength="60"/>
					</div>
					<div class="ab-user-pass-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_user_pass'] ) ? $ab_errors['ab_user_pass'] : '';?>
					</div>
				</div>
				<div class="ab-formGroup ab-left ab-lastGroup ab-w-50">
					<label class="ab-formLabel"><?php echo esc_html( __( 'Confirm Password', 'esbab' ) ) ?></label>
					<div class="ab-formField">
						<input class="ab-formElement ab-user-confirm-pass ab-required" type="password" name="ab_user_confirm_pass" value="" maxlength="60"/>
					</div>
					<div class="ab-user-confirm-pass-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_user_confirm_pass'] ) ? $ab_errors['ab_user_confirm_pass'] : '';?>
					</div>
				</div>
			</div>
		<?php } ?>
			
			<div class="ab-row-fluid">
			<?php
			/**  
				$esignature_agree_text  = get_option( 'ab_settings_esignature_agree_text' );
				$term_condition_url     = get_option( 'ab_settings_term_condition_url' );
				$term_condition_text    = get_option( 'ab_settings_term_condition_text' );
				$term_condition_text    = !empty( $term_condition_text ) ? $term_condition_text : __( 'Terms & Conditions', 'esbab' );
				
				echo $esignature_agree_text;
				echo ' '.$term_condition_text;
			   if( !empty( $term_condition_url ) ) {
			?>
					 <a class="ab-terms-condition" href="<?php echo $term_condition_url ?>" target="_blank">
						  <?php echo $term_condition_text ?>
					 </a>
				<div class="ab-formGroup ab-lastGroup ab-full">
					<label class="ab-formLabel"><?php echo esc_html( __( 'eSignature', 'esbab' ) ) ?></label>
					<div class="ab-formField">
						<textarea class="ab-formElement ab-user-esignature ab-required" name="ab_user_esignature"><?php echo $ab_user_esignature; ?></textarea>
					</div>
					<div class="ab-user-esignature-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_user_esignature'] ) ? $ab_errors['ab_user_esignature'] : '';?>
					</div>
				</div>
			<?php } */ ?>
				<div class="ab-formGroup ab-left ab-w-50">
					<label class="ab-formLabel"><?php echo esc_html( __( 'Select the time interval for your appointment email reminders', 'esbab' ) ) ?></label>
					<div class="ab-formField">
						<select class="ab-formElement ab-user-remind" name="ab_user_remind">
							<?php foreach ( $remind_options as $remind_option_key => $remind_option_name ) { ?>
								<option value="<?php echo $remind_option_key ?>" <?php selected( $ab_user_remind, $remind_option_key ) ?>><?php echo $remind_option_name ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="ab-user-remind-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_user_remind'] ) ? $ab_errors['ab_user_remind'] : '';?>
					</div>
				</div>
			</div>
		
			<div class="ab-row-fluid">
				<strong><?php echo esc_html( __( 'Credit Card Details', 'esbab' ) ) ?></strong>
			</div>
			<div class="ab-row-fluid">
				<div class="ab-formGroup ab-left ab-w-50">
					<label class="ab-formLabel"><?php _e( 'Credit Card', 'esbab' ) ?></label>
					<span class="ab-credit-card-type"></span>
					<div class="ab-formField">
						<input class="ab-formElement ab-credit-card-number ab-numeric ab-required" type="text" name="ab_card_number"  maxlength="16" value="" />
					</div>
					<div class="ab-card-number-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_card_number'] ) ? $ab_errors['ab_card_number'] : '';?>
					</div>
				</div>
				<div class="ab-formGroup ab-left ab-w-50" style="width: auto;">
					<label class="ab-formLabel"><?php _e( 'Expiration Date', 'esbab' ) ?></label>
					<div class="ab-formField">
						<select class="ab-formElement ab-expire-card-month ab-required" style="width: 45px;float: left;" name="ab_card_month">
							<?php for ( $i = 1; $i <= 12; ++ $i ): ?>
								<option value="<?php echo ($i < 10)? '0' . $i : $i;?>"><?php echo $i;?></option>
							<?php endfor; ?>
						</select>
						<select class="ab-formElement ab-expire-card-year ab-required" style="width: 70px;float: left; margin-left: 10px;" name="ab_card_year">
							<?php for ( $i = date('Y'); $i <= date('Y')+10; ++ $i ): ?>
								<option value="<?php echo substr($i, 2, 2);?>"><?php echo $i;?></option>
							<?php endfor ?>
						</select>
					</div>
					<div class="ab-card-expiration-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_card_expiration'] ) ? $ab_errors['ab_card_expiration'] : '';?>
					</div>
				</div>
			</div>
			<div class="ab-row-fluid">
				<div class="ab-formGroup ab-left ab-w-50">
					<label class="ab-formLabel"><?php _e( 'Card Security Code', 'esbab' ) ?></label>
					<div class="ab-formField">
						<input class="ab-formElement ab-card-security-code ab-numeric ab-required" style="width: 50px;float: left;" type="text" name="ab_card_code" maxlength="4" />
					</div>
					<div class="ab-clear"></div>
					<div class="ab-card-code-error ab-label-error ab-bold">
						<?php echo !empty( $ab_errors['ab_card_code'] ) ? $ab_errors['ab_card_code'] : '';?>
					</div>
				</div>
			</div>
		 
			<div class="ab-row-fluid ab-nav-steps ab-clear">
				<input type="submit" name="ab_user_register" id="ab_user_register" class="ab-right ab-to-fourth-step ab-btn ladda-button orange zoom-in" value="<?php _e( 'Register', 'esbab' ) ?>" />
			</div>
			
		</form>
	<?php
}

/**
 * Process for registration
 */
function ab_registration_process() {
	
	global $ab_login_errors, $ab_errors;

	$ab_login_errors = array();
	$ab_errors = array();
	
	// Check register button is click
	if( !empty( $_POST['ab_user_login'] ) ) {
		
		$username = $password = '';
		$error = false;

		if( !is_user_logged_in() ) {
			
			$creds = array();
			$error = false;

			if( !empty( $_POST['ab_userl_login'] ) ) { //check user name
				$creds['user_login'] = $_POST['ab_userl_login'];
			} else {
				$ab_login_errors['ab_userl_login'] = __( '<span>Please enter your username.', 'wpsdeals' );
				$error = true;
			}
			if( !empty( $_POST['ab_userl_pass'] ) ) { //check user password
				$creds['user_password'] = $_POST['ab_userl_pass'];
			} else {
				$ab_login_errors['ab_userl_pass'] = __( '<span>Please enter your password.', 'wpsdeals' );
				$error = true;
			}
			$creds['remember'] = false;

			if( !$error ) { // Check username and password are not empty

				$user = wp_signon( $creds, false );

				if ( is_wp_error( $user ) ) { //check error given by wordpress

					if( isset( $user->errors['invalid_username'] ) && !empty( $user->errors['invalid_username'] ) ) { //check user name is invalid
						$ab_login_errors['ab_userl_login'] = __( '<span>Invalid username.', 'wpsdeals' );
					} 

					if( isset( $user->errors['incorrect_password'] ) && !empty( $user->errors['incorrect_password'] ) ) { //check user password is incorrect
						$ab_login_errors['ab_userl_pass'] = __( '<span>The password you entered for username <strong>'.$creds['user_login'].'</strong> is incorrect.', 'wpsdeals' );
					}
				} else {

					$appointment_page_url = get_option( 'ab_settings_appointment_page_url' );
					if( empty( $appointment_page_url ) ) {

						if( is_front_page() ) {
							$appointment_page_url = site_url();
						} else {
							$appointment_page_url = get_permalink();
						}
					}

					wp_redirect( $appointment_page_url );
					exit;
				}
			}
		}
	}
	
	// Check register button is click
	if( !empty( $_POST['ab_user_register'] ) ) {

		$firstname = $userphone = $userworkphone = $usercellphone = '';
		$userstreet = $usercity = $userstate = $userzip = $userbillingaddr = '';
		$userdob = $userage = $usersex = $useremergencycontactname = $useremergencycontact = $userresponsibleparty = $useresignature = $userremind = '';
		$username = $password = $email = '';
		$cardnumber = $cardmonth = $cardyear = $cardcode = '';
		$error = false;

		if( !empty( $_POST['ab_user_fname'] ) ) { //check user first anme
			$firstname = $_POST['ab_user_fname'];
		} else {
			$ab_errors['ab_user_fname'] = __( '<span>Please enter full name.</span>', 'esbab' );
			$error = true;
		}

		if( isset( $_POST['ab_user_phone'] ) ) {
			if( !empty( $_POST['ab_user_phone'] ) ) { //check user home phone
				$userphone = $_POST['ab_user_phone'];
			}
		}
		if( isset( $_POST['ab_user_work_phone'] ) ) {
			if( !empty( $_POST['ab_user_work_phone'] ) ) { //check user work phone
				$userworkphone = $_POST['ab_user_work_phone'];
			}
		}
		if( isset( $_POST['ab_user_cell_phone'] ) ) {
			if( !empty( $_POST['ab_user_cell_phone'] ) ) { //check user cell phone
				$usercellphone = $_POST['ab_user_cell_phone'];
			} else {
				$ab_errors['ab_user_cell_phone'] = __( '<span>Please enter your cell phone number.</span>', 'esbab' );
				$error = true;
			}
		}
		
		if( isset( $_POST['ab_user_street'] ) ) {
			if( !empty( $_POST['ab_user_street'] ) ) {
				$userstreet = $_POST['ab_user_street'];
			}
		}
		if( isset( $_POST['ab_user_city'] ) ) {
			if( !empty( $_POST['ab_user_city'] ) ) {
				$usercity = $_POST['ab_user_city'];
			}
		}
		if( isset( $_POST['ab_user_state'] ) ) {
			if( !empty( $_POST['ab_user_state'] ) ) {
				$userstate = $_POST['ab_user_state'];
			}
		}
		if( isset( $_POST['ab_user_zip'] ) ) {
			if( !empty( $_POST['ab_user_zip'] ) ) {
				$userzip = $_POST['ab_user_zip'];
			}
		}
		
		if( isset( $_POST['ab_user_work_street'] ) ) {
			if( !empty( $_POST['ab_user_work_street'] ) ) {
				$userworkstreet = $_POST['ab_user_work_street'];
			}
		}
		if( isset( $_POST['ab_user_work_city'] ) ) {
			if( !empty( $_POST['ab_user_work_city'] ) ) {
				$userworkcity = $_POST['ab_user_work_city'];
			}
		}
		if( isset( $_POST['ab_user_work_state'] ) ) {
			if( !empty( $_POST['ab_user_work_state'] ) ) {
				$userworkstate = $_POST['ab_user_work_state'];
			}
		}
		if( isset( $_POST['ab_user_work_zip'] ) ) {
			if( !empty( $_POST['ab_user_work_zip'] ) ) {
				$userworkzip = $_POST['ab_user_work_zip'];
			}
		}
		if( isset( $_POST['ab_user_billing_address_choice'] ) ) {
			if( !empty( $_POST['ab_user_billing_address_choice'] ) ) {
				$user_billing_address_choice = $_POST['ab_user_billing_address_choice'];
			}
		}
		
		if( isset( $_POST['ab_user_dob'] ) ) {
			if( !empty( $_POST['ab_user_dob'] ) ) { //check user date of birth
				$userdob = $_POST['ab_user_dob'];
				
				$today = current_time( 'm/d/Y' );
				
				$diff = abs(strtotime($today) - strtotime($userdob));
				$years = floor($diff / (365*60*60*24));
				
//                    if( $years < 18 ) {
//                        $ab_errors['ab_user_dob'] = __( '<span>Must be at least 18 years of age to consent to use of the website.</span>', 'esbab' );
//                        $error = true;
//                    }
				
			} else {
				$ab_errors['ab_user_dob'] = __( '<span>Please enter your date of birth.</span>', 'esbab' );
				$error = true;
			}
		}
		if( isset( $_POST['ab_user_age'] ) ) {
			if( !empty( $_POST['ab_user_age'] ) ) { //check user age
				$userage = $_POST['ab_user_age'];
			} else {
				$ab_errors['ab_user_age'] = __( '<span>Please enter your age.</span>', 'esbab' );
				$error = true;
			}
		}
		if( isset( $_POST['ab_user_responsible_party'] ) ) {
			if( !empty( $_POST['ab_user_responsible_party'] ) ) { //check user responsible party
				$userresponsibleparty = $_POST['ab_user_responsible_party'];
			} else if( empty ( $_POST['ab_user_responsible_party'] ) && !empty( $_POST['ab_user_age'] ) && $_POST['ab_user_age'] < 18 ) {
				$ab_errors['ab_user_responsible_party'] = __( '<span>Please enter responsible party.</span>', 'esbab' );
				$error = true;
			}
		}
		
		if( isset( $_POST['ab_user_sex'] ) ) {
			if( !empty( $_POST['ab_user_sex'] ) ) { //check user sex
				$usersex = $_POST['ab_user_sex'];
			}
		}
		if( isset( $_POST['ab_user_emergency_contact_name'] ) ) {
			if( !empty( $_POST['ab_user_emergency_contact_name'] ) ) { //check user emergency contact name
				$useremergencycontactname = $_POST['ab_user_emergency_contact_name'];
			} else {
				$ab_errors['ab_user_emergency_contact_name'] = __( '<span>Please enter your emergency contact name.</span>', 'esbab' );
				$error = true;
			}
		}
		if( isset( $_POST['ab_user_emergency_contact'] ) ) {
			if( !empty( $_POST['ab_user_emergency_contact'] ) ) { //check user emergency contact
				$useremergencycontact = $_POST['ab_user_emergency_contact'];
			} else {
				$ab_errors['ab_user_emergency_contact'] = __( '<span>Please enter your emergency contact number.</span>', 'esbab' );
				$error = true;
			}
		}
		
		/*
		if( isset( $_POST['ab_user_esignature'] ) ) {
			if( !empty( $_POST['ab_user_esignature'] ) ) { //check user eSignature
				$useresignature = $_POST['ab_user_esignature'];
			} else {
				$ab_errors['ab_user_esignature'] = __( '<span>Please enter your eSignature.</span>', 'esbab' );
				$error = true;
			}
		}
		*/
		if( isset( $_POST['ab_user_remind'] ) ) {
			if( !empty( $_POST['ab_user_remind'] ) ) { //check user remind
				$userremind = $_POST['ab_user_remind'];
			}
		}
		
		if( !is_user_logged_in() ) {
			
			if( !empty( $_POST['ab_user_login'] ) ) { //check user name
				$username = $_POST['ab_user_login'];
			} else {
				$ab_errors['ab_user_login'] = __( '<span>Please enter username.</span>', 'esbab' );
				$error = true;
			}
			if( !empty( $_POST['ab_user_email'] ) ) { //check user email
				if( is_email( $_POST['ab_user_email'] ) ) { //check user email is valid
					$email = $_POST['ab_user_email'];
				} else {
					$ab_errors['ab_user_email'] = __( '<span>Please enter valid e-mail address.</span>', 'esbab' );
					$error = true;
				}
			} else {
				$ab_errors['ab_user_email'] = __( '<span>Please enter e-mail address.</span>', 'esbab' );
				$error = true;
			}
			if( !( isset( $_POST['ab_user_pass'] ) && !empty( $_POST['ab_user_pass'] ) ) ) { //check user password is empty
					$ab_errors['ab_user_pass'] = __( '<span>Please enter password.', 'esbab' );
					$error = true;
			}
			if( !( isset( $_POST['ab_user_confirm_pass'] ) && !empty( $_POST['ab_user_confirm_pass'] ) ) ) { //check user confirm password is empty
					$ab_errors['ab_user_confirm_pass'] = __( '<span>Please enter confirm password.', 'esbab' );
					$error = true;
			}
			if( isset( $_POST['ab_user_pass'] ) && !empty( $_POST['ab_user_pass'] )
				&& isset( $_POST['ab_user_confirm_pass'] ) && !empty( $_POST['ab_user_confirm_pass'] ) ) { //check password & confirm password
				if( $_POST['ab_user_pass'] == $_POST['ab_user_confirm_pass'] ) { //check both password are metch

					$password = $_POST['ab_user_pass'];
					
				} else {
					$ab_errors['ab_user_confirm_pass'] = __( '<span>Password and confirm password must be same.', 'esbab' );
					$error = true;
				}
			} else { 
					$error = true;
			}
		}
		
		if( !empty( $_POST['ab_card_number'] ) ) { //check credit card number
			$cardnumber = $_POST['ab_card_number'];
		} else {
			$ab_errors['ab_card_number'] = __( '<span>Please enter credit card number.</span>', 'esbab' );
			$error = true;
		}
		if( !empty( $_POST['ab_card_code'] ) ) { //check credit card security number
			$cardcode = $_POST['ab_card_code'];
		} else {
			$ab_errors['ab_card_code'] = __( '<span>Please enter card security code.</span>', 'esbab' );
			$error = true;
		}
		if( !empty( $_POST['ab_card_month'] ) && !empty( $_POST['ab_card_year'] ) ) { //check expiration date
			$cardmonth = isset( $_POST['ab_card_month'] ) ? $_POST['ab_card_month'] : '';
			$cardyear  = isset( $_POST['ab_card_year'] ) ? $_POST['ab_card_year'] : '';
		} else {
			$ab_errors['ab_card_expiration'] = __( '<span>Please select expiration date.</span>', 'esbab' );
			$error = true;
		}

		$current_date = current_time( 'timestamp' );
		$current_month = date( 'm', $current_date );
		$current_year = date( 'y', $current_date );
		
		if( $cardyear < $current_year || ( $cardyear == $current_year && $cardmonth < $current_month ) ) {
			$ab_errors['ab_card_number'] = __( '<span>Please enter proper credit card number, expire date or security code.</span>', 'esbab' );
			$error = true;
		}
		
		if( !$error ) { // Check username, password, confirm password and email are not empty

			if( !is_user_logged_in() ) {

				if( username_exists( $username ) ) {

					$ab_errors['ab_user_login'] = __( '<span>This username is already registered. Please choose another one.</span>', 'esbab' );

				} else if( email_exists( $email ) ) {

					$ab_errors['ab_user_email'] = __( '<span>This email is already registered, please choose another one.</span>', 'esbab' );

				} else {

					$user_id = wp_create_user( $username, $password, $email );

					if( !empty( $user_id ) ) {
						
						//make user to logged in
						wp_set_auth_cookie( $user_id, false); 
					}
				}
				
			} else {
				
				global $user_ID;
				$user_id = $user_ID;
			}

			if( !empty( $user_id ) ) {
				
				//Personal Information
				update_user_meta( $user_id, 'first_name', $firstname ); //update user first name
				update_user_meta( $user_id, 'ab_user_full_name', $firstname ); //update user full name
				update_user_meta( $user_id, 'ab_user_phone', $userphone ); //update user home phone number
				update_user_meta( $user_id, 'ab_user_work_phone', $userworkphone ); //update user work phone number
				update_user_meta( $user_id, 'ab_user_cell_phone', $usercellphone ); //update user cell phone number
				
				update_user_meta( $user_id, 'ab_user_street', $userstreet ); //update user street
				update_user_meta( $user_id, 'ab_user_city', $usercity ); //update user city
				update_user_meta( $user_id, 'ab_user_state', $userstate ); //update user state
				update_user_meta( $user_id, 'ab_user_zip', $userzip ); //update user zip
				
				update_user_meta( $user_id, 'ab_user_work_street', $userworkstreet ); //update user work street
				update_user_meta( $user_id, 'ab_user_work_city', $userworkcity ); //update user work city
				update_user_meta( $user_id, 'ab_user_work_state', $userworkstate ); //update user work state
				update_user_meta( $user_id, 'ab_user_work_zip', $userworkzip ); //update user work zip
				update_user_meta( $user_id, 'ab_user_billing_address_choice', $user_billing_address_choice ); //update user billing address choice
				
				update_user_meta( $user_id, 'ab_user_dob', $userdob ); //update user date of birth
				update_user_meta( $user_id, 'ab_user_age', $userage ); //update user age
				update_user_meta( $user_id, 'ab_user_sex', $usersex ); //update user sex
				update_user_meta( $user_id, 'ab_user_emergency_contact_name', $useremergencycontactname ); //update user emergency contact name
				update_user_meta( $user_id, 'ab_user_emergency_contact', $useremergencycontact ); //update user emergency contact
				update_user_meta( $user_id, 'ab_user_responsible_party', $userresponsibleparty ); //update user responsible party
				
				//update_user_meta( $user_id, 'ab_user_esignature', $useresignature ); //update user eSignature
				update_user_meta( $user_id, 'ab_user_remind', $userremind ); //update user remind

				//Credit Card Information
				update_user_meta( $user_id, 'ab_card_number', $cardnumber ); //update user credit card number
				update_user_meta( $user_id, 'ab_card_month', $cardmonth ); //update user credit card expiration month
				update_user_meta( $user_id, 'ab_card_year', $cardyear ); //update user credit card expiration year
				update_user_meta( $user_id, 'ab_card_code', $cardcode ); //update user credit card security code
				
				if( isset( $_POST['ab_user_billing_address_choice'] ) && $_POST['ab_user_billing_address_choice'] == 'Home' ) {

					if( isset( $_POST['ab_user_street'] ) ) {
						update_user_meta( $user_id, 'billing_address_1', $userstreet );
						update_user_meta( $user_id, 'shipping_address_1', $userstreet );
					}
					if( isset( $_POST['ab_user_city'] ) ) {
						update_user_meta( $user_id, 'billing_city', $usercity );
						update_user_meta( $user_id, 'shipping_city', $usercity );
					}
					if( isset( $_POST['ab_user_state'] ) ) {
						update_user_meta( $user_id, 'billing_state', $userstate );
						update_user_meta( $user_id, 'shipping_state', $userstate );
					}
					if( isset( $_POST['ab_user_zip'] ) ) {
						update_user_meta( $user_id, 'billing_postcode', $userzip );
						update_user_meta( $user_id, 'shipping_postcode', $userzip );
					}

				} else if( isset( $_POST['ab_user_billing_address_choice'] ) && $_POST['ab_user_billing_address_choice'] == 'Work' ) {

					if( isset( $_POST['ab_user_work_street'] ) ) {
						update_user_meta( $user_id, 'billing_address_1', $userworkstreet );
						update_user_meta( $user_id, 'shipping_address_1', $userworkstreet );
					}
					if( isset( $_POST['ab_user_work_city'] ) ) {
						update_user_meta( $user_id, 'billing_city', $userworkcity );
						update_user_meta( $user_id, 'shipping_city', $userworkcity );
					}
					if( isset( $_POST['ab_user_work_state'] ) ) {
						update_user_meta( $user_id, 'billing_state', $userworkstate );
						update_user_meta( $user_id, 'shipping_state', $userworkstate );
					}
					if( isset( $_POST['ab_user_work_zip'] ) ) {
						update_user_meta( $user_id, 'billing_postcode', $userworkzip );
						update_user_meta( $user_id, 'shipping_postcode', $userworkzip );
					}
				}
				
				$appointment_page_url = get_option( 'ab_settings_appointment_page_url' );
				if( empty( $appointment_page_url ) ) {

					if( is_front_page() ) {
						$appointment_page_url = site_url();
					} else {
						$appointment_page_url = get_permalink();
					}
				}

				wp_redirect( $appointment_page_url );
				exit;

			} else {

				$ab_errors['ab_error_message'] = __( '<span>User Registration Failed.</span>', 'esbab' );
			}
		}
	}
}

?>