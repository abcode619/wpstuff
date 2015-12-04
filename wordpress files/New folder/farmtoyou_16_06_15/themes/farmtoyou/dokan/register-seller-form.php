<?php
function dokan_add_custom_zipcode_field() {
?>
    <p class="form-row form-group form-row-wide">
        <label for="shop-zipcode"><?php _e( 'Zipcode', 'dokan' ); ?><span class="required">*</span></label>
        <input type="text" maxlength="5" class="input-text form-control" name="zipcode" id="shop-zipcode" value="<?php if ( ! empty( $_POST['zipcode'] ) ) echo esc_attr($_POST['zipcode']); ?>" required="required" />
    </p>
<?php
}

add_action( 'dokan_seller_registration_field_after', 'dokan_add_custom_zipcode_field' );
?>