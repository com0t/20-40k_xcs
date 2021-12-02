<?php if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

if (!class_exists('WWP_Order')) {

    /**
     * Model that houses the logic of integrating with WooCommerce orders.
     * Be it be adding additional data/meta to orders or order items, etc..
     *
     * @since 1.3.0
     */
    class WWP_Order
    {

        /*
        |--------------------------------------------------------------------------
        | Class Properties
        |--------------------------------------------------------------------------
         */

        /**
         * Property that holds the single main instance of WWP_Order.
         *
         * @since 1.3.0
         * @access private
         * @var WWP_Order
         */
        private static $_instance;

        /**
         * Model that houses the logic of retrieving information relating to wholesale role/s of a user.
         *
         * @since 1.3.0
         * @access private
         * @var WWP_Wholesale_Roles
         */
        private $_wwp_wholesale_roles;

        /*
        |--------------------------------------------------------------------------
        | Class Methods
        |--------------------------------------------------------------------------
         */

        /**
         * WWP_Order constructor.
         *
         * @since 1.3.0
         * @access public
         *
         * @param array $dependencies Array of instance objects of all dependencies of WWP_Order model.
         */
        public function __construct($dependencies)
        {

            $this->_wwp_wholesale_roles = $dependencies['WWP_Wholesale_Roles'];

        }

        /**
         * Ensure that only one instance of WWP_Order is loaded or can be loaded (Singleton Pattern).
         *
         * @since 1.3.0
         * @access public
         *
         * @param array $dependencies Array of instance objects of all dependencies of WWP_Order model.
         * @return WWP_Order
         */
        public static function instance($dependencies)
        {

            if (!self::$_instance instanceof self) {
                self::$_instance = new self($dependencies);
            }

            return self::$_instance;

        }

        /**
         * Add order meta.
         *
         * @since 1.3.0
         * @access public
         *
         * @param int   $order_id    Order id.
         * @param array $posted_data Posted data.
         */
        public function wwp_add_order_meta($order_id, $posted_data)
        {

            $user_wholesale_role = $this->_wwp_wholesale_roles->getUserWholesaleRole();

            if (!empty($user_wholesale_role)) {

                update_post_meta($order_id, 'wwp_wholesale_role', $user_wholesale_role[0]);

                do_action('_wwp_add_order_meta', $order_id, $posted_data, $user_wholesale_role);

            }

        }

        /**
         * Add order item meta for more accurate wholesale reporting in the future.
         * For WC 2.7.x series.
         *
         * @since 1.3.1
         * @access public
         *
         * @param int    $item_id  Order item id.
         * @param Object $item     Order item object.
         * @param int    $order_id Order id.
         */
        public function add_order_item_meta_wc2_7($item_id, $item, $order_id)
        {

            // Important note : Since WC 2.7.x shipping (WC_Order_Item_Shipping) and tax (WC_Order_Item_Tax) will be treated as order item as well. Weird
            if (is_a($item, 'WC_Order_Item_Product')) {
                $this->add_order_item_meta($item_id, $item->legacy_values);
            }

            do_action('wwp_add_order_item_meta', $item_id, $item, $order_id);

        }

        /**
         * Add order item meta for more accurate wholeslae reporting in the future.
         * For WC 2.7.x series.
         *
         * @since 1.3.1
         * @access public
         *
         * @param int    $item_id          Order item id.
         * @param array  $cart_item_values Order item data.
         * @param string $cart_item_key    Cart item key.
         */
        public function add_order_item_meta_wc2_6($item_id, $cart_item_values, $cart_item_key)
        {

            $this->add_order_item_meta($item_id, $cart_item_values);

            do_action('wwp_add_order_item_meta', $item_id, $cart_item_values, $cart_item_key);

        }

        /**
         * Attach order item meta for new orders since WWP 1.3.0 for more accurate reporting in the future versions of WWPP.
         * Replaces the wwp_add_order_item_meta function of WWP 1.3.0.
         *
         * @since 1.3.1
         * @access public
         *
         * @param int   $item_id Order item id.
         * @param array $item    Array of order item data.
         */
        public function add_order_item_meta($item_id, $item)
        {

            $user_wholesale_role = $this->_wwp_wholesale_roles->getUserWholesaleRole();

            if (isset($item['data']->wwp_data) && isset($item['data']->wwp_data['wholesale_role']) &&
                !empty($user_wholesale_role) && $user_wholesale_role[0] == $item['data']->wwp_data['wholesale_role']) {

                if (isset($item['data']->wwp_data['wholesale_priced'])) {
                    wc_add_order_item_meta($item_id, '_wwp_wholesale_priced', $item['data']->wwp_data['wholesale_priced']);
                }

                if (isset($item['data']->wwp_data['wholesale_role'])) {
                    wc_add_order_item_meta($item_id, '_wwp_wholesale_role', $item['data']->wwp_data['wholesale_role']);
                }

            }

        }

        /**
         * ############################################################################################################
         * Move the Order type filtering feature from WWPP to WWP
         * @since 1.15.0
         * ##########################################################################################################*/

        /**
         * Add custom column to order listing page.
         *
         * @since 1.0.0
         * @since 1.14.0 Refactor codebase and move to its own model.
         * @access public
         *
         * @param array $columns Orders cpt listing columns.
         * @return array Filtered orders cpt listing columns.
         */
        public function add_orders_listing_custom_column($columns)
        {

            $arrayKeys = array_keys($columns);
            $lastIndex = $arrayKeys[count($arrayKeys) - 1];
            $lastValue = $columns[$lastIndex];
            array_pop($columns);

            $columns['wwpp_order_type'] = __('Order Type', 'woocommerce-wholesale-prices-premium');

            $columns[$lastIndex] = $lastValue;

            return $columns;

        }

        /**
         * Add content to the custom column on order listing page.
         *
         * @since 1.0.0
         * @since 1.14.0 Refactor codebase and move to its own model.
         * @access public
         *
         * @param string $column  Current column key.
         * @param int    $post_id Current post id.
         */
        public function add_orders_listing_custom_column_content($column, $post_id)
        {

            $allRegisteredWholesaleRoles = $this->_wwp_wholesale_roles->getAllRegisteredWholesaleRoles();

            if ($column == 'wwpp_order_type') {

                $orderType = get_post_meta($post_id, '_wwpp_order_type', true);

                if ($orderType == '' || $orderType == null || $orderType == false || $orderType == 'retail') {

                    _e("Retail", "woocommerce-wholesale-prices-premium");

                } elseif ($orderType == 'wholesale') {

                    $wholesaleOrderType = get_post_meta($post_id, '_wwpp_wholesale_order_type', true);
                    echo sprintf(__('Wholesale ( %1$s )', 'woocommerce-wholesale-prices-premium'), $allRegisteredWholesaleRoles[$wholesaleOrderType]['roleName']);

                }

            }

        }

        /**
         * Attach custom meta to orders ( the order type metadata ) to be used later for filtering orders by order type
         * on the order listing page.
         *
         * @since 1.0.0
         * @since 1.14.0 Refactor codebase and move to its own model.
         * @access public
         *
         * @param int $order_id Order id.
         */
        public function add_order_type_meta_to_wc_orders($order_id)
        {

            $all_registered_wholesale_roles = $this->_wwp_wholesale_roles->getAllRegisteredWholesaleRoles();
            $current_order = new WC_Order($order_id);
            $current_order_wp_user = get_userdata($current_order->get_user_id());
            $current_order_user_roles = array();

            if ($current_order_wp_user) {
                $current_order_user_roles = $current_order_wp_user->roles;
            }

            if (!is_array($current_order_user_roles)) {
                $current_order_user_roles = array();
            }

            $all_registered_wholesale_roles_keys = array();
            foreach ($all_registered_wholesale_roles as $roleKey => $role) {
                $all_registered_wholesale_roles_keys[] = $roleKey;
            }

            $orderUserWholesaleRole = array_values(array_intersect($current_order_user_roles, $all_registered_wholesale_roles_keys));

            if (isset($orderUserWholesaleRole[0])) {

                update_post_meta($order_id, '_wwpp_order_type', 'wholesale');
                update_post_meta($order_id, '_wwpp_wholesale_order_type', $orderUserWholesaleRole[0]);

            } else {

                update_post_meta($order_id, '_wwpp_order_type', 'retail');
                update_post_meta($order_id, '_wwpp_wholesale_order_type', '');

            }

        }

        /**
         * Add custom filter on order listing page ( order type filter ).
         *
         * @since 1.0.0
         * @since 1.14.0 Refactor codebase and move to its own model.
         * @access public
         */
        public function add_wholesale_role_order_listing_filter()
        {

            global $typenow;

            $all_registered_wholesale_roles = $this->_wwp_wholesale_roles->getAllRegisteredWholesaleRoles();

            if ($typenow == 'shop_order') {

                ob_start();

                $wwpp_fbwr = null;
                if (isset($_GET['wwpp_fbwr'])) {
                    $wwpp_fbwr = $_GET['wwpp_fbwr'];
                }

                $all_registered_wholesale_roles = array('all_wholesale_orders' => array('roleName' => __('All Wholesale Orders', 'woocommerce-wholesale-prices-premium'))) + $all_registered_wholesale_roles;
                $all_registered_wholesale_roles = array('all_retail_orders' => array('roleName' => __('All Retail Orders', 'woocommerce-wholesale-prices-premium'))) + $all_registered_wholesale_roles;
                $all_registered_wholesale_roles = array('all_order_types' => array('roleName' => __('Show all order types', 'woocommerce-wholesale-prices-premium'))) + $all_registered_wholesale_roles;

                //wwpp_fbwr = Filter By Wholesale Role ?>

<select name="wwpp_fbwr" id="filter-by-wholesale-role" class="chosen_select">

    <?php foreach ($all_registered_wholesale_roles as $roleKey => $role) {?>
    <option value="<?php echo $roleKey; ?>" <?php echo ($roleKey == $wwpp_fbwr) ? 'selected' : ''; ?>>
        <?php echo $role["roleName"]; ?></option>
    <?php }?>

</select>

<?php echo ob_get_clean();

            }

        }

        /**
         * Add functionality to the custom filter added on order listing page ( order type filter ).
         *
         * @since 1.0.0
         * @since 1.14.0 Refactor codebase and move to its own model.
         * @access public
         *
         * @param WP_Query $query WP_Query object.
         */
        public function wholesale_role_order_listing_filter($query)
        {

            global $pagenow;
            $wholesale_filter = null;

            if (isset($_GET['wwpp_fbwr'])) {
                $wholesale_filter = trim($_GET['wwpp_fbwr']);
            }

            if ($pagenow == 'edit.php' && isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'shop_order' && !is_null($wholesale_filter)) {

                switch ($wholesale_filter) {

                    case 'all_order_types':
                        // Do nothing
                        break;

                    case 'all_retail_orders':

                        $query->set(
                            'meta_query',
                            array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_wwpp_order_type',
                                    'value' => array('retail'),
                                    'compare' => 'IN',
                                ),
                                array(
                                    'key' => '_wwpp_order_type',
                                    'value' => 'gebbirish', // Pre WP 3.9 bug, must set string for NOT EXISTS to work
                                    'compare' => 'NOT EXISTS',
                                ),
                            )
                        );

                        break;

                    case 'all_wholesale_orders':

                        $query->query_vars['meta_key'] = '_wwpp_order_type';
                        $query->query_vars['meta_value'] = 'wholesale';

                        break;

                    default:

                        $query->query_vars['meta_key'] = '_wwpp_wholesale_order_type';
                        $query->query_vars['meta_value'] = $wholesale_filter;

                        break;

                }

            }

            return $query;

        }

        /**
         * Execute model.
         *
         * @since 1.3.0
         * @access public
         */
        public function run()
        {

            add_action('woocommerce_checkout_order_processed', array($this, 'wwp_add_order_meta'), 10, 2);

            $woocommerce_data = WWP_Helper_Functions::get_woocommerce_data();

            if (version_compare($woocommerce_data['Version'], '3.0.0', '>=')) {
                add_action('woocommerce_new_order_item', array($this, 'add_order_item_meta_wc2_7'), 10, 3);
            } else {
                add_action('woocommerce_add_order_item_meta', array($this, 'add_order_item_meta_wc2_6'), 10, 3);
            }

            // Execute add_filter for Order Filtering if WWPP is not active and WWPP Class does not exists, else execute WWPP's Order Filtering.
            if (is_plugin_inactive('woocommerce-wholesale-prices-premium/woocommerce-wholesale-prices-premium.bootstrap.php') && !class_exists('WooCommerceWholeSalePricesPremium')) {

                add_filter('manage_edit-shop_order_columns', array($this, 'add_orders_listing_custom_column'), 15, 1);
                add_action('manage_shop_order_posts_custom_column', array($this, 'add_orders_listing_custom_column_content'), 10, 2);

                add_action('woocommerce_checkout_order_processed', array($this, 'add_order_type_meta_to_wc_orders'), 10, 2);
                add_action('restrict_manage_posts', array($this, 'add_wholesale_role_order_listing_filter'), 10, 1);
                add_filter('parse_query', array($this, 'wholesale_role_order_listing_filter'), 10, 1);

            }
        }

    }

}