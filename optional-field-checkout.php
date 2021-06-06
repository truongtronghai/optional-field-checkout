<?php
/**

 * Plugin Name: Optional Checkout Fields

 * Description: This is used to set email ( or other fields ) optional instead of required as default in woocommerce

 * Version: 1.1

 * Author: CaChepSo Ltd

 * Text Domain: OCF

 */

//Prevent Data Leaks.Add this line of code after the opening PHP tag in each PHP file:
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/** Check dependency plugin */
load_plugin_textdomain('OCF'); // using for transaltion. Location of translation: wp-content/languages/plugins/GHTK4Woo-vi.mo

if(!in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )){  
    $message = (__( 'Reason: Woocommerce plugin is not ready!!!', 'OCF' ));
    printf("<div class='error notice-error notice is-dismissible'><p>%s</p></div>",$message);
    exit;
}

/** Menu section */
function OCF_menu_view(){

    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    
    
?>
    <div class="wrap">
        <h1>Optional Checkout Fields for Woocommerce</h1>
        <p>Phiên bản này thực hiện 2 việc</p>
        <ul>
            <li>- Chuyển trường email thành không bắt buộc khi khách hàng điền form thanh toán đơn hàng</li>
            <li>- Bỏ trường "Post code" khỏi phần thanh toán đơn hàng</li>
        </ul>
        <p>Xem trang checkout trong Woocommerce để thấy sự thay đổi</p>
        <hr>
        <p>Currently, this plugin does two things:</p>
        <ul>
            <li>- Making email field optional rather than required as default</li>
            <li>- Removing post code field</li>
        </ul>
        <p>Please check your Woocommerce checkout page for result. Thanks!</p>
        <address>
        Written by <a href="mailto:truongtronghai@gmail.com">Trong Hai</a>.<br> 
        Visit us at: <a href="https://cachepso.com">CaChepSo Ltd</a><br>
        Saigon,Vietnam
        </address>
    </div>      
<?php
    
 }

add_action('admin_menu','OCF_add_menu_admin');
function OCF_add_menu_admin(){
    
    add_submenu_page( 

        'tools.php',// add to sub menu of Tools
        'Optional Checkout Field',
        'Optional Checkout Field',
        'manage_options',
        'ocf_tool',
        'OCF_menu_view'
    );

}
 
/**
 * @description: adjusting fields of checkout page of Storefront theme  
 * @hook: woocommerce_checkout_fields
 */ 
   
add_filter('woocommerce_checkout_fields','OCF_not_required_fields',9999);

function OCF_not_required_fields( $f ){
    

	$f['billing']['billing_email']['required'] = false; // make email field optional

	unset($f['billing']['billing_postcode']); // remove postcode field
    unset($f['shipping']['shipping_postcode']);

	return $f;

}

?>