<?php 
class AppSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $acl_link_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $acl_links = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'controller' => array('type' => 'string', 'null' => true, 'default' => null),
		'action' => array('type' => 'string', 'null' => true, 'default' => null),
		'named_key' => array('type' => 'string', 'null' => true, 'default' => null),
		'named_value' => array('type' => 'string', 'null' => true, 'default' => null),
		'pass_value' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'acl_links_action_idx' => array('unique' => false, 'column' => 'action'),
			'acl_links_controller_idx' => array('unique' => false, 'column' => 'controller')
		),
		'tableParameters' => array()
	);
	public $acl_links_roles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'role_id' => array('type' => 'integer', 'null' => true),
		'acl_link_id' => array('type' => 'integer', 'null' => true),
		'acl_link_status_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'acl_links_roles_acl_link_id_idx' => array('unique' => false, 'column' => 'acl_link_id'),
			'acl_links_roles_acl_link_status_id_idx' => array('unique' => false, 'column' => 'acl_link_status_id'),
			'acl_links_roles_role_id_idx' => array('unique' => false, 'column' => 'role_id')
		),
		'tableParameters' => array()
	);
	public $affiliate_cash_withdrawal_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $affiliate_cash_withdrawals = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'affiliate_cash_withdrawal_status_id' => array('type' => 'integer', 'null' => true),
		'amount' => array('type' => 'float', 'null' => true),
		'commission_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'payment_gateway_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'affiliate_cash_withdrawals_payment_gateway_id_idx' => array('unique' => false, 'column' => 'payment_gateway_id'),
			'affiliate_cash_withdrawals_user_id_idx' => array('unique' => false, 'column' => 'user_id'),
			'iliate_cash_withdrawals_affiliate_cash_withdrawal_status_id_idx' => array('unique' => false, 'column' => 'affiliate_cash_withdrawal_status_id')
		),
		'tableParameters' => array()
	);
	public $affiliate_commission_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'description' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $affiliate_requests = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'site_name' => array('type' => 'string', 'null' => true, 'default' => null),
		'site_description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'site_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'site_category_id' => array('type' => 'integer', 'null' => true),
		'why_do_you_want_affiliate' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'is_web_site_marketing' => array('type' => 'boolean', 'null' => true),
		'is_search_engine_marketing' => array('type' => 'boolean', 'null' => true),
		'is_email_marketing' => array('type' => 'boolean', 'null' => true),
		'special_promotional_method' => array('type' => 'string', 'null' => true, 'default' => null),
		'special_promotional_description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'is_approved' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'affiliate_requests_site_category_id_idx' => array('unique' => false, 'column' => 'site_category_id'),
			'affiliate_requests_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $affiliate_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'date', 'null' => true),
		'modified' => array('type' => 'date', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $affiliate_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'model_name' => array('type' => 'string', 'null' => true, 'default' => null),
		'commission' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'affiliate_commission_type_id' => array('type' => 'integer', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true),
		'plugin_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 220),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'affiliate_types_affiliate_commission_type_id_idx' => array('unique' => false, 'column' => 'affiliate_commission_type_id'),
			'affiliate_types_plugin_name_idx' => array('unique' => false, 'column' => 'plugin_name')
		),
		'tableParameters' => array()
	);
	public $affiliates = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'class' => array('type' => 'string', 'null' => true, 'default' => null),
		'foreign_id' => array('type' => 'integer', 'null' => true),
		'affiliate_type_id' => array('type' => 'integer', 'null' => true),
		'affliate_user_id' => array('type' => 'integer', 'null' => true),
		'affiliate_status_id' => array('type' => 'integer', 'null' => true),
		'commission_amount' => array('type' => 'float', 'null' => true),
		'commission_holding_start_date' => array('type' => 'date', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'affiliates_affiliate_status_id_idx' => array('unique' => false, 'column' => 'affiliate_status_id'),
			'affiliates_affiliate_type_id_idx' => array('unique' => false, 'column' => 'affiliate_type_id'),
			'affiliates_affliate_user_id_idx' => array('unique' => false, 'column' => 'affliate_user_id'),
			'affiliates_class_idx' => array('unique' => false, 'column' => 'class'),
			'affiliates_foreign_id_idx' => array('unique' => false, 'column' => 'foreign_id')
		),
		'tableParameters' => array()
	);
	public $attachments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'class' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'foreign_id' => array('type' => 'integer', 'null' => true),
		'message_id' => array('type' => 'integer', 'null' => true),
		'vimeo_video_id' => array('type' => 'string', 'null' => true, 'default' => null),
		'vimeo_thumbnail_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'youtube_video_id' => array('type' => 'string', 'null' => true, 'default' => null),
		'youtube_thumbnail_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'filename' => array('type' => 'string', 'null' => true, 'default' => null),
		'dir' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'mimetype' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'filesize' => array('type' => 'integer', 'null' => true),
		'height' => array('type' => 'integer', 'null' => true),
		'width' => array('type' => 'integer', 'null' => true),
		'thumb' => array('type' => 'boolean', 'null' => true),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'amazon_s3_thumb_url' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'amazon_s3_original_url' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'attachments_class_idx' => array('unique' => false, 'column' => 'class'),
			'attachments_foreign_id_idx' => array('unique' => false, 'column' => 'foreign_id'),
			'attachments_message_id_idx' => array('unique' => false, 'column' => 'message_id'),
			'attachments_vimeo_video_id_idx' => array('unique' => false, 'column' => 'vimeo_video_id'),
			'attachments_youtube_video_id_idx' => array('unique' => false, 'column' => 'youtube_video_id')
		),
		'tableParameters' => array()
	);
	public $banned_ips = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'address' => array('type' => 'string', 'null' => true, 'default' => null),
		'range' => array('type' => 'string', 'null' => true, 'default' => null),
		'referer_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'reason' => array('type' => 'string', 'null' => true, 'default' => null),
		'redirect' => array('type' => 'string', 'null' => true, 'default' => null),
		'thetime' => array('type' => 'integer', 'null' => true),
		'timespan' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'banned_ips_address_idx' => array('unique' => false, 'column' => 'address'),
			'banned_ips_range_idx' => array('unique' => false, 'column' => 'range')
		),
		'tableParameters' => array()
	);
	public $blocks = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'region_id' => array('type' => 'integer', 'null' => true),
		'title' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'alias' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'body' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'show_title' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'class' => array('type' => 'string', 'null' => true, 'default' => null),
		'status' => array('type' => 'boolean', 'null' => true),
		'weight' => array('type' => 'integer', 'null' => true),
		'element' => array('type' => 'string', 'null' => true, 'default' => null),
		'visibility_roles' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'visibility_paths' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'visibility_php' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'params' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'updated' => array('type' => 'datetime', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'blocks_alias_key' => array('unique' => true, 'column' => 'alias'),
			'blocks_class_idx' => array('unique' => false, 'column' => 'class'),
			'blocks_region_id_idx' => array('unique' => false, 'column' => 'region_id')
		),
		'tableParameters' => array()
	);
	public $cake_sessions = array(
		'id' => array('type' => 'string', 'null' => false, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'data' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'expires' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'cake_sessions_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $cities = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'country_id' => array('type' => 'integer', 'null' => true),
		'state_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45),
		'latitude' => array('type' => 'float', 'null' => true),
		'longitude' => array('type' => 'float', 'null' => true),
		'timezone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10),
		'dma_id' => array('type' => 'integer', 'null' => true),
		'county' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 25),
		'code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 4),
		'is_approved' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'cities_country_id_idx' => array('unique' => false, 'column' => 'country_id'),
			'cities_dma_id_idx' => array('unique' => false, 'column' => 'dma_id'),
			'cities_slug_idx' => array('unique' => false, 'column' => 'slug'),
			'cities_state_id_idx' => array('unique' => false, 'column' => 'state_id')
		),
		'tableParameters' => array()
	);
	public $comments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true),
		'node_id' => array('type' => 'integer', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'website' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200),
		'ip' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'title' => array('type' => 'string', 'null' => true, 'default' => null),
		'body' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'rating' => array('type' => 'integer', 'null' => true),
		'status' => array('type' => 'boolean', 'null' => true),
		'notify' => array('type' => 'boolean', 'null' => true),
		'type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'comment_type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'lft' => array('type' => 'integer', 'null' => true),
		'rght' => array('type' => 'integer', 'null' => true),
		'updated' => array('type' => 'datetime', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'comments_lft_idx' => array('unique' => false, 'column' => 'lft'),
			'comments_node_id_idx' => array('unique' => false, 'column' => 'node_id'),
			'comments_parent_id_idx' => array('unique' => false, 'column' => 'parent_id'),
			'comments_rght_idx' => array('unique' => false, 'column' => 'rght'),
			'comments_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $contacts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'first_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'last_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'email' => array('type' => 'string', 'null' => true, 'default' => null),
		'subject' => array('type' => 'string', 'null' => true, 'default' => null),
		'message' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'telephone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'contacts_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $contest_flag_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'date', 'null' => true),
		'modified' => array('type' => 'date', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250),
		'contest_flag_count' => array('type' => 'integer', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'contest_flag_categories_name_idx' => array('unique' => false, 'column' => 'name'),
			'contest_flag_categories_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $contest_flags = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'contest_id' => array('type' => 'integer', 'null' => true),
		'contest_flag_category_id' => array('type' => 'integer', 'null' => true),
		'message' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'contest_flags_contest_flag_category_id_idx' => array('unique' => false, 'column' => 'contest_flag_category_id'),
			'contest_flags_contest_id_idx' => array('unique' => false, 'column' => 'contest_id'),
			'contest_flags_ip_id_idx' => array('unique' => false, 'column' => 'ip_id'),
			'contest_flags_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $contest_followers = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'contest_id' => array('type' => 'integer', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'contest_followers_contest_id_idx' => array('unique' => false, 'column' => 'contest_id'),
			'contest_followers_ip_id_idx' => array('unique' => false, 'column' => 'ip_id'),
			'contest_followers_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $contest_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null),
		'message' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'contest_statuses_slug_idx' => array('unique' => false, 'column' => 'slug')
		),
		'tableParameters' => array()
	);
	public $contest_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'resource_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'next' => array('type' => 'integer', 'null' => true),
		'contest_count' => array('type' => 'integer', 'null' => true),
		'form_field_count' => array('type' => 'integer', 'null' => true),
		'contest_user_count' => array('type' => 'integer', 'null' => true),
		'minimum_prize' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'blind_fee' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'private_fee' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'featured_fee' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'highlight_fee' => array('type' => 'float', 'null' => true),
		'site_revenue' => array('type' => 'float', 'null' => true),
		'is_watermarked' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_template' => array('type' => 'boolean', 'null' => true),
		'is_blind' => array('type' => 'boolean', 'null' => true),
		'is_featured' => array('type' => 'boolean', 'null' => true),
		'is_highlight' => array('type' => 'boolean', 'null' => true),
		'is_private' => array('type' => 'boolean', 'null' => true),
		'maximum_entries_allowed' => array('type' => 'integer', 'null' => true, 'default' => '40'),
		'maximum_entries_allowed_per_user' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'contest_types_resource_id_idx' => array('unique' => false, 'column' => 'resource_id')
		),
		'tableParameters' => array()
	);
	public $contest_types_pricing_days = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'contest_type_id' => array('type' => 'integer', 'null' => true),
		'pricing_day_id' => array('type' => 'integer', 'null' => true),
		'price' => array('type' => 'float', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'contest_types_pricing_days_contest_type_id_idx' => array('unique' => false, 'column' => 'contest_type_id'),
			'contest_types_pricing_days_pricing_day_id_idx' => array('unique' => false, 'column' => 'pricing_day_id')
		),
		'tableParameters' => array()
	);
	public $contest_types_pricing_packages = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'contest_type_id' => array('type' => 'integer', 'null' => true),
		'pricing_package_id' => array('type' => 'integer', 'null' => true),
		'price' => array('type' => 'float', 'null' => true),
		'participant_commision' => array('type' => 'float', 'null' => true),
		'maximum_entry_allowed' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'contest_types_pricing_packages_contest_type_id_idx' => array('unique' => false, 'column' => 'contest_type_id'),
			'contest_types_pricing_packages_pricing_package_id_idx' => array('unique' => false, 'column' => 'pricing_package_id')
		),
		'tableParameters' => array()
	);
	public $contest_user_downloads = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'contest_user_id' => array('type' => 'integer', 'null' => true),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'contest_user_downloads_contest_user_id_idx' => array('unique' => false, 'column' => 'contest_user_id'),
			'contest_user_downloads_ip_id_idx' => array('unique' => false, 'column' => 'ip_id'),
			'contest_user_downloads_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $contest_user_flag_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'date', 'null' => true),
		'modified' => array('type' => 'date', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250),
		'contest_user_flag_count' => array('type' => 'integer', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'contest_user_flag_categories_name_idx' => array('unique' => false, 'column' => 'name'),
			'contest_user_flag_categories_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $contest_user_flags = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'date', 'null' => true),
		'modified' => array('type' => 'date', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'contest_user_id' => array('type' => 'integer', 'null' => true),
		'contest_user_flag_category_id' => array('type' => 'integer', 'null' => true),
		'message' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'contest_user_flags_contest_user_flag_category_id_idx' => array('unique' => false, 'column' => 'contest_user_flag_category_id'),
			'contest_user_flags_contest_user_id_idx' => array('unique' => false, 'column' => 'contest_user_id'),
			'contest_user_flags_ip_id_idx' => array('unique' => false, 'column' => 'ip_id'),
			'contest_user_flags_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $contest_user_ratings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'contest_user_id' => array('type' => 'integer', 'null' => true),
		'rating' => array('type' => 'integer', 'null' => true),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'contest_user_ratings_contest_user_id_idx' => array('unique' => false, 'column' => 'contest_user_id'),
			'contest_user_ratings_ip_id_idx' => array('unique' => false, 'column' => 'ip_id'),
			'contest_user_ratings_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $contest_user_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'description' => array('type' => 'string', 'null' => true, 'default' => null),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'contest_user_statuses_slug_idx' => array('unique' => false, 'column' => 'slug')
		),
		'tableParameters' => array()
	);
	public $contest_user_views = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'contest_user_id' => array('type' => 'integer', 'null' => true),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'contest_user_views_contest_user_id_idx' => array('unique' => false, 'column' => 'contest_user_id'),
			'contest_user_views_ip_id_idx' => array('unique' => false, 'column' => 'ip_id'),
			'contest_user_views_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $contest_users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'contest_owner_user_id' => array('type' => 'integer', 'null' => true),
		'referred_by_user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_id' => array('type' => 'integer', 'null' => true),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'copyright_note' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'entry_no' => array('type' => 'integer', 'null' => true),
		'contest_user_status_id' => array('type' => 'integer', 'null' => true, 'default' => '1'),
		'contest_user_total_ratings' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_user_rating_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'average_rating' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'contest_user_view_count' => array('type' => 'integer', 'null' => true),
		'message_count' => array('type' => 'integer', 'null' => true),
		'site_revenue' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'is_system_flagged' => array('type' => 'boolean', 'null' => true),
		'is_user_flagged' => array('type' => 'boolean', 'null' => true),
		'admin_suspend' => array('type' => 'boolean', 'null' => true),
		'is_active' => array('type' => 'integer', 'null' => true, 'default' => '1'),
		'sudopay_gateway_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'contest_users_contest_id_idx' => array('unique' => false, 'column' => 'contest_id'),
			'contest_users_contest_owner_user_id_idx' => array('unique' => false, 'column' => 'contest_owner_user_id'),
			'contest_users_contest_user_status_id_idx' => array('unique' => false, 'column' => 'contest_user_status_id'),
			'contest_users_referred_by_user_id_idx' => array('unique' => false, 'column' => 'referred_by_user_id'),
			'contest_users_sudopay_gateway_id_idx' => array('unique' => false, 'column' => 'sudopay_gateway_id'),
			'contest_users_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $contest_views = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'contest_id' => array('type' => 'integer', 'null' => true),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'contest_views_contest_id_idx' => array('unique' => false, 'column' => 'contest_id'),
			'contest_views_ip_id_idx' => array('unique' => false, 'column' => 'ip_id'),
			'contest_views_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $contests = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'referred_by_user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_type_id' => array('type' => 'integer', 'null' => true),
		'contest_status_id' => array('type' => 'integer', 'null' => true),
		'is_send_payment_notification' => array('type' => 'boolean', 'null' => true),
		'contest_view_count' => array('type' => 'integer', 'null' => true),
		'resource_id' => array('type' => 'integer', 'null' => true),
		'pricing_package_id' => array('type' => 'integer', 'null' => true),
		'pricing_day_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'maximum_entry_allowed' => array('type' => 'integer', 'null' => true),
		'maximum_entry_allowed_per_user' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'reason_for_cancelation' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'prize' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'creation_cost' => array('type' => 'float', 'null' => true),
		'actual_end_date' => array('type' => 'datetime', 'null' => true),
		'end_date' => array('type' => 'datetime', 'null' => true),
		'start_date' => array('type' => 'datetime', 'null' => true),
		'refund_request_date' => array('type' => 'datetime', 'null' => true),
		'canceled_by_admin_date' => array('type' => 'datetime', 'null' => true),
		'winner_selected_date' => array('type' => 'datetime', 'null' => true),
		'judging_date' => array('type' => 'datetime', 'null' => true),
		'pending_action_to_admin_date' => array('type' => 'datetime', 'null' => true),
		'change_requested_date' => array('type' => 'datetime', 'null' => true),
		'change_completed_date' => array('type' => 'datetime', 'null' => true),
		'paid_to_participant_date' => array('type' => 'datetime', 'null' => true),
		'completed_date' => array('type' => 'datetime', 'null' => true),
		'files_expectation_date' => array('type' => 'datetime', 'null' => true),
		'partcipant_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_user_count' => array('type' => 'integer', 'null' => true),
		'contest_comment_count' => array('type' => 'integer', 'null' => true),
		'contest_follower_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_user_won_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_user_eliminated_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_user_withdrawn_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_user_active_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'message_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'total_site_revenue' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'winner_user_id' => array('type' => 'integer', 'null' => true),
		'payment_gateway_id' => array('type' => 'integer', 'null' => true),
		'last_contest_user_entry_no' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'is_system_flagged' => array('type' => 'boolean', 'null' => true),
		'is_user_flagged' => array('type' => 'boolean', 'null' => true),
		'is_admin_complete' => array('type' => 'boolean', 'null' => true),
		'admin_suspend' => array('type' => 'boolean', 'null' => true),
		'is_winner_selected_by_admin' => array('type' => 'boolean', 'null' => true),
		'is_pending_action_to_admin' => array('type' => 'boolean', 'null' => true),
		'is_blind' => array('type' => 'boolean', 'null' => true),
		'is_private' => array('type' => 'boolean', 'null' => true),
		'is_featured' => array('type' => 'boolean', 'null' => true),
		'is_highlight' => array('type' => 'boolean', 'null' => true),
		'blind_contest_fee' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'private_contest_fee' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'featured_contest_fee' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'highlight_contest_fee' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'detected_suspicious_words' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'reason_for_calcelation' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'site_commision' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'is_paid' => array('type' => 'boolean', 'null' => true),
		'is_uploaded_entry_design' => array('type' => 'boolean', 'null' => true),
		'admin_commission_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'affiliate_commission_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'sudopay_gateway_id' => array('type' => 'integer', 'null' => true),
		'sudopay_payment_id' => array('type' => 'integer', 'null' => true),
		'sudopay_pay_key' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250),
		'sudopay_revised_amount' => array('type' => 'float', 'null' => true),
		'sudopay_token' => array('type' => 'string', 'null' => true, 'default' => null),
		'upgrade' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'contests_contest_status_id_idx' => array('unique' => false, 'column' => 'contest_status_id'),
			'contests_contest_type_id_idx' => array('unique' => false, 'column' => 'contest_type_id'),
			'contests_payment_gateway_id_idx' => array('unique' => false, 'column' => 'payment_gateway_id'),
			'contests_pricing_day_id_idx' => array('unique' => false, 'column' => 'pricing_day_id'),
			'contests_pricing_package_id_idx' => array('unique' => false, 'column' => 'pricing_package_id'),
			'contests_referred_by_user_id_idx' => array('unique' => false, 'column' => 'referred_by_user_id'),
			'contests_resource_id_idx' => array('unique' => false, 'column' => 'resource_id'),
			'contests_slug_idx' => array('unique' => false, 'column' => 'slug'),
			'contests_sudopay_gateway_id_idx' => array('unique' => false, 'column' => 'sudopay_gateway_id'),
			'contests_sudopay_payment_id_idx' => array('unique' => false, 'column' => 'sudopay_payment_id'),
			'contests_user_id_idx' => array('unique' => false, 'column' => 'user_id'),
			'contests_winner_user_id_idx' => array('unique' => false, 'column' => 'winner_user_id')
		),
		'tableParameters' => array()
	);
	public $countries = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'iso_alpha2' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 2),
		'iso_alpha3' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 3),
		'iso_numeric' => array('type' => 'integer', 'null' => true),
		'fips_code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 3),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200),
		'capital' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200),
		'areainsqkm' => array('type' => 'float', 'null' => true),
		'population' => array('type' => 'integer', 'null' => true),
		'continent' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 2),
		'tld' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 3),
		'currency' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 3),
		'currencyname' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'phone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10),
		'postalcodeformat' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'postalcoderegex' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'languages' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200),
		'geonameid' => array('type' => 'integer', 'null' => true),
		'neighbours' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'equivalentfipscode' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $educations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'education' => array('type' => 'string', 'null' => true, 'default' => null),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $email_templates = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'from' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500),
		'reply_to' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'subject' => array('type' => 'string', 'null' => true, 'default' => null),
		'email_content' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'email_html_content' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'email_variables' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1000),
		'is_html' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'email_templates_name_idx' => array('unique' => false, 'column' => 'name')
		),
		'tableParameters' => array()
	);
	public $employments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'employment' => array('type' => 'string', 'null' => true, 'default' => null),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $form_field_groups = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null),
		'contest_type_id' => array('type' => 'integer', 'null' => true),
		'info' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'order' => array('type' => 'integer', 'null' => true),
		'class' => array('type' => 'string', 'null' => true, 'default' => null),
		'is_deletable' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_editable' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'form_field_groups_class_idx' => array('unique' => false, 'column' => 'class'),
			'form_field_groups_contest_type_id_idx' => array('unique' => false, 'column' => 'contest_type_id'),
			'form_field_groups_slug_idx' => array('unique' => false, 'column' => 'slug')
		),
		'tableParameters' => array()
	);
	public $form_fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'display_text' => array('type' => 'string', 'null' => true, 'default' => null),
		'label' => array('type' => 'string', 'null' => true, 'default' => null),
		'type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45),
		'info' => array('type' => 'string', 'null' => true, 'default' => null),
		'length' => array('type' => 'integer', 'null' => true),
		'null' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45),
		'default' => array('type' => 'string', 'null' => true, 'default' => null),
		'resource_id' => array('type' => 'integer', 'null' => true),
		'contest_type_id' => array('type' => 'integer', 'null' => true),
		'required' => array('type' => 'boolean', 'null' => true),
		'order' => array('type' => 'integer', 'null' => true),
		'options' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'depends_on' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45),
		'depends_value' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45),
		'form_field_group_id' => array('type' => 'integer', 'null' => true),
		'is_editable' => array('type' => 'boolean', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'form_fields_contest_type_id_idx' => array('unique' => false, 'column' => 'contest_type_id'),
			'form_fields_form_field_group_id_idx' => array('unique' => false, 'column' => 'form_field_group_id'),
			'form_fields_resource_id_idx' => array('unique' => false, 'column' => 'resource_id')
		),
		'tableParameters' => array()
	);
	public $form_fields_validation_rules = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'form_field_id' => array('type' => 'integer', 'null' => true),
		'validation_rule_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'form_fields_validation_rules_form_field_id_idx' => array('unique' => false, 'column' => 'form_field_id'),
			'form_fields_validation_rules_validation_rule_id_idx' => array('unique' => false, 'column' => 'validation_rule_id')
		),
		'tableParameters' => array()
	);
	public $genders = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $i18n = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'locale' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 6),
		'model' => array('type' => 'string', 'null' => true, 'default' => null),
		'foreign_key' => array('type' => 'integer', 'null' => true),
		'field' => array('type' => 'string', 'null' => true, 'default' => null),
		'content' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'i18n_field_idx' => array('unique' => false, 'column' => 'field'),
			'i18n_foreign_key_idx' => array('unique' => false, 'column' => 'foreign_key'),
			'i18n_locale_idx' => array('unique' => false, 'column' => 'locale'),
			'i18n_model_idx' => array('unique' => false, 'column' => 'model')
		),
		'tableParameters' => array()
	);
	public $income_ranges = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'income' => array('type' => 'string', 'null' => true, 'default' => null),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $ips = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'ip' => array('type' => 'string', 'null' => true, 'default' => null),
		'host' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'city_id' => array('type' => 'integer', 'null' => true),
		'state_id' => array('type' => 'integer', 'null' => true),
		'country_id' => array('type' => 'integer', 'null' => true),
		'timezone_id' => array('type' => 'integer', 'null' => true),
		'latitude' => array('type' => 'float', 'null' => true),
		'longitude' => array('type' => 'float', 'null' => true),
		'user_agent' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'ips_city_id_idx' => array('unique' => false, 'column' => 'city_id'),
			'ips_country_id_idx' => array('unique' => false, 'column' => 'country_id'),
			'ips_state_id_idx' => array('unique' => false, 'column' => 'state_id'),
			'ips_timezone_id_idx' => array('unique' => false, 'column' => 'timezone_id')
		),
		'tableParameters' => array()
	);
	public $languages = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'iso2' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 5),
		'iso3' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 5),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'languages_name_idx' => array('unique' => false, 'column' => 'name')
		),
		'tableParameters' => array()
	);
	public $links = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true),
		'menu_id' => array('type' => 'integer', 'null' => true),
		'title' => array('type' => 'string', 'null' => true, 'default' => null),
		'class' => array('type' => 'string', 'null' => true, 'default' => null),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'link' => array('type' => 'string', 'null' => true, 'default' => null),
		'target' => array('type' => 'string', 'null' => true, 'default' => null),
		'rel' => array('type' => 'string', 'null' => true, 'default' => null),
		'status' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'lft' => array('type' => 'integer', 'null' => true),
		'rght' => array('type' => 'integer', 'null' => true),
		'visibility_roles' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'params' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'updated' => array('type' => 'datetime', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'links_class_idx' => array('unique' => false, 'column' => 'class'),
			'links_lft_idx' => array('unique' => false, 'column' => 'lft'),
			'links_menu_id_idx' => array('unique' => false, 'column' => 'menu_id'),
			'links_parent_id_idx' => array('unique' => false, 'column' => 'parent_id'),
			'links_rght_idx' => array('unique' => false, 'column' => 'rght')
		),
		'tableParameters' => array()
	);
	public $menus = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true, 'default' => null),
		'alias' => array('type' => 'string', 'null' => true, 'default' => null),
		'class' => array('type' => 'string', 'null' => true, 'default' => null),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'status' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'weight' => array('type' => 'integer', 'null' => true),
		'link_count' => array('type' => 'integer', 'null' => true),
		'params' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'updated' => array('type' => 'datetime', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'menus_alias_key' => array('unique' => true, 'column' => 'alias'),
			'menus_class_idx' => array('unique' => false, 'column' => 'class')
		),
		'tableParameters' => array()
	);
	public $message_contents = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'subject' => array('type' => 'string', 'null' => true, 'default' => null),
		'message' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'admin_suspend' => array('type' => 'boolean', 'null' => true),
		'is_system_flagged' => array('type' => 'boolean', 'null' => true),
		'detected_suspicious_words' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'text_resource' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $messages = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'other_user_id' => array('type' => 'integer', 'null' => true),
		'root' => array('type' => 'integer', 'null' => true),
		'freshness_ts' => array('type' => 'datetime', 'null' => true, 'default' => 'now()'),
		'depth' => array('type' => 'integer', 'null' => true),
		'materialized_path' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 256),
		'parent_message_id' => array('type' => 'integer', 'null' => true),
		'message_content_id' => array('type' => 'integer', 'null' => true),
		'message_folder_id' => array('type' => 'integer', 'null' => true),
		'is_sender' => array('type' => 'boolean', 'null' => true),
		'is_starred' => array('type' => 'boolean', 'null' => true),
		'is_read' => array('type' => 'boolean', 'null' => true),
		'is_deleted' => array('type' => 'boolean', 'null' => true),
		'is_archived' => array('type' => 'boolean', 'null' => true),
		'is_communication' => array('type' => 'boolean', 'null' => true),
		'size' => array('type' => 'integer', 'null' => true),
		'path' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'contest_id' => array('type' => 'integer', 'null' => true),
		'contest_status_id' => array('type' => 'integer', 'null' => true),
		'contest_user_id' => array('type' => 'integer', 'null' => true),
		'is_private' => array('type' => 'boolean', 'null' => true),
		'is_auto' => array('type' => 'boolean', 'null' => true),
		'is_activity' => array('type' => 'boolean', 'null' => true),
		'contest_user_rating_id' => array('type' => 'integer', 'null' => true),
		'is_child_replied' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'messages_contest_id_idx' => array('unique' => false, 'column' => 'contest_id'),
			'messages_contest_status_id_idx' => array('unique' => false, 'column' => 'contest_status_id'),
			'messages_contest_user_id_idx' => array('unique' => false, 'column' => 'contest_user_id'),
			'messages_contest_user_rating_id_idx' => array('unique' => false, 'column' => 'contest_user_rating_id'),
			'messages_message_content_id_idx' => array('unique' => false, 'column' => 'message_content_id'),
			'messages_message_folder_id_idx' => array('unique' => false, 'column' => 'message_folder_id'),
			'messages_other_user_id_idx' => array('unique' => false, 'column' => 'other_user_id'),
			'messages_parent_message_id_idx' => array('unique' => false, 'column' => 'parent_message_id'),
			'messages_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $meta = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'model' => array('type' => 'string', 'null' => true, 'default' => null),
		'foreign_key' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'value' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'weight' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $money_transfer_accounts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'payment_gateway_id' => array('type' => 'integer', 'null' => true),
		'account' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'is_default' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'money_transfer_accounts_payment_gateway_id_idx' => array('unique' => false, 'column' => 'payment_gateway_id'),
			'money_transfer_accounts_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $nodes = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'title' => array('type' => 'string', 'null' => true, 'default' => null),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null),
		'body' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'excerpt' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'status' => array('type' => 'boolean', 'null' => true),
		'mime_type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'comment_status' => array('type' => 'integer', 'null' => true, 'default' => '1'),
		'comment_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'promote' => array('type' => 'boolean', 'null' => true),
		'path' => array('type' => 'string', 'null' => true, 'default' => null),
		'terms' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'sticky' => array('type' => 'boolean', 'null' => true),
		'lft' => array('type' => 'integer', 'null' => true),
		'rght' => array('type' => 'integer', 'null' => true),
		'visibility_roles' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'updated' => array('type' => 'datetime', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true),
		'meta_keywords' => array('type' => 'string', 'null' => true, 'default' => null),
		'meta_description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'nodes_parent_id_idx' => array('unique' => false, 'column' => 'parent_id'),
			'nodes_slug_idx' => array('unique' => false, 'column' => 'slug'),
			'nodes_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $nodes_taxonomies = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'node_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'taxonomy_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'nodes_taxonomies_node_id_idx' => array('unique' => false, 'column' => 'node_id'),
			'nodes_taxonomies_taxonomy_id_idx' => array('unique' => false, 'column' => 'taxonomy_id')
		),
		'tableParameters' => array()
	);
	public $payment_gateway_settings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'payment_gateway_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 256),
		'type' => array('type' => 'string', 'null' => true, 'default' => null),
		'options' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'test_mode_value' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'live_mode_value' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'payment_gateway_settings_payment_gateway_id_idx' => array('unique' => false, 'column' => 'payment_gateway_id')
		),
		'tableParameters' => array()
	);
	public $payment_gateways = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'display_name' => array('type' => 'string', 'null' => true, 'default' => null),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'gateway_fees' => array('type' => 'float', 'null' => true),
		'transaction_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'payment_gateway_setting_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'is_test_mode' => array('type' => 'boolean', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true),
		'is_mass_pay_enabled' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $persistent_logins = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'series' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'token' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'expires' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'persistent_logins_ip_id_idx' => array('unique' => false, 'column' => 'ip_id'),
			'persistent_logins_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $pricing_days = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'no_of_days' => array('type' => 'integer', 'null' => true),
		'global_price' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'is_active' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'pricing_days_no_of_days_idx' => array('unique' => false, 'column' => 'no_of_days')
		),
		'tableParameters' => array()
	);
	public $pricing_packages = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'global_price' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'participant_commision' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'maximum_entry_allowed' => array('type' => 'integer', 'null' => true),
		'features' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'pricing_packages_name_idx' => array('unique' => false, 'column' => 'name')
		),
		'tableParameters' => array()
	);
	public $regions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'alias' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'block_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'regions_alias_key' => array('unique' => true, 'column' => 'alias')
		),
		'tableParameters' => array()
	);
	public $relationships = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'relationship' => array('type' => 'string', 'null' => true, 'default' => null),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $resources = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'folder_name' => array('type' => 'string', 'null' => true, 'default' => null),
		'contest_count' => array('type' => 'integer', 'null' => true),
		'contest_user_count' => array('type' => 'integer', 'null' => true),
		'revenue' => array('type' => 'float', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $roles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250),
		'parent_id' => array('type' => 'integer', 'null' => true),
		'lft' => array('type' => 'integer', 'null' => true),
		'rght' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'roles_lft_idx' => array('unique' => false, 'column' => 'lft'),
			'roles_name_idx' => array('unique' => false, 'column' => 'name'),
			'roles_parent_id_idx' => array('unique' => false, 'column' => 'parent_id'),
			'roles_rght_idx' => array('unique' => false, 'column' => 'rght')
		),
		'tableParameters' => array()
	);
	public $setting_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'plugin_name' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'setting_categories_name_idx' => array('unique' => false, 'column' => 'name'),
			'setting_categories_parent_id_idx' => array('unique' => false, 'column' => 'parent_id')
		),
		'tableParameters' => array()
	);
	public $settings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'setting_category_id' => array('type' => 'integer', 'null' => true),
		'setting_category_parent_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'value' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 8),
		'options' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'label' => array('type' => 'string', 'null' => true, 'default' => null),
		'order' => array('type' => 'integer', 'null' => true),
		'plugin_name' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'settings_name_idx' => array('unique' => false, 'column' => 'name'),
			'settings_setting_category_id_idx' => array('unique' => false, 'column' => 'setting_category_id'),
			'settings_setting_category_parent_id_idx' => array('unique' => false, 'column' => 'setting_category_parent_id')
		),
		'tableParameters' => array()
	);
	public $site_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 265),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'site_categories_slug_idx' => array('unique' => false, 'column' => 'slug')
		),
		'tableParameters' => array()
	);
	public $social_contact_details = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250),
		'facebook_user_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150),
		'twitter_user_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150),
		'social_contact_count' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'social_contact_details_facebook_user_id_idx' => array('unique' => false, 'column' => 'facebook_user_id'),
			'social_contact_details_twitter_user_id_idx' => array('unique' => false, 'column' => 'twitter_user_id')
		),
		'tableParameters' => array()
	);
	public $social_contacts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'social_source_id' => array('type' => 'integer', 'null' => true),
		'social_contact_detail_id' => array('type' => 'integer', 'null' => true),
		'social_user_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'social_contacts_social_contact_detail_id_idx' => array('unique' => false, 'column' => 'social_contact_detail_id'),
			'social_contacts_social_source_id_idx' => array('unique' => false, 'column' => 'social_source_id'),
			'social_contacts_social_user_id_idx' => array('unique' => false, 'column' => 'social_user_id'),
			'social_contacts_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $spam_filters = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'other_user_id' => array('type' => 'integer', 'null' => true),
		'content' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'subject' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'spam_filters_other_user_id_idx' => array('unique' => false, 'column' => 'other_user_id'),
			'spam_filters_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $states = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'country_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45),
		'code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 8),
		'adm1code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 4),
		'is_approved' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'states_country_id_idx' => array('unique' => false, 'column' => 'country_id')
		),
		'tableParameters' => array()
	);
	public $submission_fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'submission_id' => array('type' => 'integer', 'null' => true),
		'form_field' => array('type' => 'string', 'null' => true, 'default' => null),
		'response' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'submission_fields_submission_id_idx' => array('unique' => false, 'column' => 'submission_id')
		),
		'tableParameters' => array()
	);
	public $submissions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'contest_type_id' => array('type' => 'integer', 'null' => true),
		'contest_id' => array('type' => 'integer', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true),
		'ip' => array('type' => 'integer', 'null' => true),
		'email' => array('type' => 'string', 'null' => true, 'default' => null),
		'page' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'submissions_contest_id_idx' => array('unique' => false, 'column' => 'contest_id'),
			'submissions_contest_type_id_idx' => array('unique' => false, 'column' => 'contest_type_id')
		),
		'tableParameters' => array()
	);
	public $subscriptions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'is_subscribed' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'unsubscribed_on' => array('type' => 'date', 'null' => true),
		'ip_id' => array('type' => 'integer', 'null' => true),
		'invite_hash' => array('type' => 'string', 'null' => true, 'default' => null),
		'site_state_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'is_sent_private_beta_mail' => array('type' => 'boolean', 'null' => true),
		'is_social_like' => array('type' => 'boolean', 'null' => true),
		'is_invite' => array('type' => 'boolean', 'null' => true),
		'invite_user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'is_email_verified' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'subscriptions_email_idx' => array('unique' => false, 'column' => 'email'),
			'subscriptions_invite_user_id_idx' => array('unique' => false, 'column' => 'invite_user_id'),
			'subscriptions_ip_id_idx' => array('unique' => false, 'column' => 'ip_id'),
			'subscriptions_site_state_id_idx' => array('unique' => false, 'column' => 'site_state_id'),
			'subscriptions_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $sudopay_ipn_logs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'ip' => array('type' => 'integer', 'null' => true),
		'post_variable' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $sudopay_payment_gateways = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'sudopay_gateway_name' => array('type' => 'string', 'null' => true, 'default' => null),
		'sudopay_gateway_id' => array('type' => 'integer', 'null' => true),
		'sudopay_payment_group_id' => array('type' => 'integer', 'null' => true),
		'sudopay_gateway_details' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'days_after_amount_paid' => array('type' => 'integer', 'null' => true),
		'is_marketplace_supported' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'sudopay_payment_gateways_sudopay_gateway_id_idx' => array('unique' => false, 'column' => 'sudopay_gateway_id'),
			'sudopay_payment_gateways_sudopay_payment_group_id_idx' => array('unique' => false, 'column' => 'sudopay_payment_group_id')
		),
		'tableParameters' => array()
	);
	public $sudopay_payment_gateways_users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'sudopay_payment_gateway_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'sudopay_payment_gateways_users_sudopay_payment_gateway_id_idx' => array('unique' => false, 'column' => 'sudopay_payment_gateway_id'),
			'sudopay_payment_gateways_users_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $sudopay_payment_groups = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'sudopay_group_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200),
		'thumb_url' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'sudopay_payment_groups_sudopay_group_id_idx' => array('unique' => false, 'column' => 'sudopay_group_id')
		),
		'tableParameters' => array()
	);
	public $sudopay_transaction_logs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'amount' => array('type' => 'float', 'null' => true),
		'payment_id' => array('type' => 'integer', 'null' => true),
		'class' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'foreign_id' => array('type' => 'integer', 'null' => true),
		'sudopay_pay_key' => array('type' => 'string', 'null' => true, 'default' => null),
		'merchant_id' => array('type' => 'integer', 'null' => true),
		'gateway_id' => array('type' => 'integer', 'null' => true),
		'gateway_name' => array('type' => 'string', 'null' => true, 'default' => null),
		'status' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'payment_type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'buyer_id' => array('type' => 'integer', 'null' => true),
		'buyer_email' => array('type' => 'string', 'null' => true, 'default' => null),
		'buyer_address' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'sudopay_transaction_logs_buyer_id_idx' => array('unique' => false, 'column' => 'buyer_id'),
			'sudopay_transaction_logs_class_idx' => array('unique' => false, 'column' => 'class'),
			'sudopay_transaction_logs_foreign_id_idx' => array('unique' => false, 'column' => 'foreign_id'),
			'sudopay_transaction_logs_gateway_id_idx' => array('unique' => false, 'column' => 'gateway_id'),
			'sudopay_transaction_logs_merchant_id_idx' => array('unique' => false, 'column' => 'merchant_id'),
			'sudopay_transaction_logs_payment_id_idx' => array('unique' => false, 'column' => 'payment_id')
		),
		'tableParameters' => array()
	);
	public $taxonomies = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true),
		'term_id' => array('type' => 'integer', 'null' => true),
		'vocabulary_id' => array('type' => 'integer', 'null' => true),
		'lft' => array('type' => 'integer', 'null' => true),
		'rght' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'taxonomies_parent_id_idx' => array('unique' => false, 'column' => 'parent_id'),
			'taxonomies_term_id_idx' => array('unique' => false, 'column' => 'term_id'),
			'taxonomies_vocabulary_id_idx' => array('unique' => false, 'column' => 'vocabulary_id')
		),
		'tableParameters' => array()
	);
	public $terms = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true, 'default' => null),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'updated' => array('type' => 'datetime', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'terms_slug_key' => array('unique' => true, 'column' => 'slug'),
			'terms_slug_idx' => array('unique' => false, 'column' => 'slug')
		),
		'tableParameters' => array()
	);
	public $timezones = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'code' => array('type' => 'string', 'null' => true, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'gmt_offset' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10),
		'dst_offset' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10),
		'raw_offset' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10),
		'hasdst' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $transaction_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'is_credit' => array('type' => 'boolean', 'null' => true),
		'is_credit_to_admin' => array('type' => 'boolean', 'null' => true),
		'message' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'message_for_admin' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'transaction_variables' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $transactions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'foreign_id' => array('type' => 'integer', 'null' => true),
		'class' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 25),
		'transaction_type_id' => array('type' => 'integer', 'null' => true),
		'amount' => array('type' => 'float', 'null' => true),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'payment_gateway_id' => array('type' => 'integer', 'null' => true),
		'gateway_fees' => array('type' => 'float', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'transactions_class_idx' => array('unique' => false, 'column' => 'class'),
			'transactions_foreign_id_idx' => array('unique' => false, 'column' => 'foreign_id'),
			'transactions_payment_gateway_id_idx' => array('unique' => false, 'column' => 'payment_gateway_id'),
			'transactions_transaction_type_id_idx' => array('unique' => false, 'column' => 'transaction_type_id'),
			'transactions_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $translations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'language_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'lang_text' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'is_translated' => array('type' => 'boolean', 'null' => true),
		'is_google_translate' => array('type' => 'boolean', 'null' => true),
		'is_verified' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'translations_language_id_idx' => array('unique' => false, 'column' => 'language_id')
		),
		'tableParameters' => array()
	);
	public $types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true, 'default' => null),
		'alias' => array('type' => 'string', 'null' => true, 'default' => null),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'format_show_author' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'format_show_date' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'comment_status' => array('type' => 'integer', 'null' => true, 'default' => '1'),
		'comment_approve' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'comment_spam_protection' => array('type' => 'boolean', 'null' => true),
		'comment_captcha' => array('type' => 'boolean', 'null' => true),
		'params' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'plugin' => array('type' => 'string', 'null' => true, 'default' => null),
		'updated' => array('type' => 'datetime', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'types_alias_key' => array('unique' => true, 'column' => 'alias')
		),
		'tableParameters' => array()
	);
	public $types_vocabularies = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'type_id' => array('type' => 'integer', 'null' => true),
		'vocabulary_id' => array('type' => 'integer', 'null' => true),
		'weight' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'types_vocabularies_type_id_idx' => array('unique' => false, 'column' => 'type_id'),
			'types_vocabularies_vocabulary_id_idx' => array('unique' => false, 'column' => 'vocabulary_id')
		),
		'tableParameters' => array()
	);
	public $upload_hosters = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'upload_service_id' => array('type' => 'integer', 'null' => true),
		'upload_service_type_id' => array('type' => 'integer', 'null' => true),
		'total_upload_count' => array('type' => 'integer', 'null' => true),
		'total_upload_error_count' => array('type' => 'integer', 'null' => true),
		'total_upload_filesize' => array('type' => 'integer', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'upload_hosters_upload_service_id_idx' => array('unique' => false, 'column' => 'upload_service_id'),
			'upload_hosters_upload_service_type_id_idx' => array('unique' => false, 'column' => 'upload_service_type_id')
		),
		'tableParameters' => array()
	);
	public $upload_service_settings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'upload_service_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'value' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'upload_service_settings_upload_service_id_idx' => array('unique' => false, 'column' => 'upload_service_id')
		),
		'tableParameters' => array()
	);
	public $upload_service_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'upload_service_types_slug_idx' => array('unique' => false, 'column' => 'slug')
		),
		'tableParameters' => array()
	);
	public $upload_services = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20),
		'total_quota' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'total_upload_count' => array('type' => 'integer', 'null' => true),
		'total_upload_filesize' => array('type' => 'integer', 'null' => true),
		'total_upload_error_count' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'upload_services_slug_idx' => array('unique' => false, 'column' => 'slug')
		),
		'tableParameters' => array()
	);
	public $upload_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $uploads = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'upload_service_type_id' => array('type' => 'integer', 'null' => true),
		'upload_service_id' => array('type' => 'integer', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'contest_user_id' => array('type' => 'integer', 'null' => true),
		'upload_status_id' => array('type' => 'integer', 'null' => true),
		'video_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'vimeo_video_id' => array('type' => 'string', 'null' => true, 'default' => null),
		'youtube_video_id' => array('type' => 'string', 'null' => true, 'default' => null),
		'vimeo_thumbnail_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'youtube_thumbnail_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'video_title' => array('type' => 'string', 'null' => true, 'default' => null),
		'filesize' => array('type' => 'integer', 'null' => true),
		'failure_message' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'uploads_contest_user_id_idx' => array('unique' => false, 'column' => 'contest_user_id'),
			'uploads_upload_service_id_idx' => array('unique' => false, 'column' => 'upload_service_id'),
			'uploads_upload_service_type_id_idx' => array('unique' => false, 'column' => 'upload_service_type_id'),
			'uploads_upload_status_id_idx' => array('unique' => false, 'column' => 'upload_status_id'),
			'uploads_user_id_idx' => array('unique' => false, 'column' => 'user_id'),
			'uploads_vimeo_video_id_idx' => array('unique' => false, 'column' => 'vimeo_video_id'),
			'uploads_youtube_video_id_idx' => array('unique' => false, 'column' => 'youtube_video_id')
		),
		'tableParameters' => array()
	);
	public $user_add_wallet_amounts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'amount' => array('type' => 'float', 'null' => true),
		'payment_gateway_id' => array('type' => 'integer', 'null' => true),
		'is_success' => array('type' => 'boolean', 'null' => true),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'sudopay_gateway_id' => array('type' => 'integer', 'null' => true),
		'sudopay_payment_id' => array('type' => 'integer', 'null' => true),
		'sudopay_pay_key' => array('type' => 'string', 'null' => true, 'default' => null),
		'sudopay_revised_amount' => array('type' => 'float', 'null' => true),
		'sudopay_token' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'user_add_wallet_amounts_payment_gateway_id_idx' => array('unique' => false, 'column' => 'payment_gateway_id'),
			'user_add_wallet_amounts_sudopay_gateway_id_idx' => array('unique' => false, 'column' => 'sudopay_gateway_id'),
			'user_add_wallet_amounts_sudopay_payment_id_idx' => array('unique' => false, 'column' => 'sudopay_payment_id'),
			'user_add_wallet_amounts_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $user_cash_withdrawals = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'withdrawal_status_id' => array('type' => 'integer', 'null' => true),
		'amount' => array('type' => 'float', 'null' => true),
		'remark' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'commission_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'payment_gateway_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'user_cash_withdrawals_payment_gateway_id_idx' => array('unique' => false, 'column' => 'payment_gateway_id'),
			'user_cash_withdrawals_user_id_idx' => array('unique' => false, 'column' => 'user_id'),
			'user_cash_withdrawals_withdrawal_status_id_idx' => array('unique' => false, 'column' => 'withdrawal_status_id')
		),
		'tableParameters' => array()
	);
	public $user_favorites = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'user_favorite_id' => array('type' => 'integer', 'null' => true),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'user_favorites_ip_id_idx' => array('unique' => false, 'column' => 'ip_id'),
			'user_favorites_user_favorite_id_idx' => array('unique' => false, 'column' => 'user_favorite_id'),
			'user_favorites_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $user_flag_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250),
		'user_flag_count' => array('type' => 'integer', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'user_flag_categories_name_idx' => array('unique' => false, 'column' => 'name'),
			'user_flag_categories_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $user_flags = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'other_user_id' => array('type' => 'integer', 'null' => true),
		'user_flag_category_id' => array('type' => 'integer', 'null' => true),
		'message' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'user_flags_ip_id_idx' => array('unique' => false, 'column' => 'ip_id'),
			'user_flags_other_user_id_idx' => array('unique' => false, 'column' => 'other_user_id'),
			'user_flags_user_flag_category_id_idx' => array('unique' => false, 'column' => 'user_flag_category_id'),
			'user_flags_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $user_logins = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'user_login_ip_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'user_agent' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'user_logins_user_id_idx' => array('unique' => false, 'column' => 'user_id'),
			'user_logins_user_login_ip_id_idx' => array('unique' => false, 'column' => 'user_login_ip_id')
		),
		'tableParameters' => array()
	);
	public $user_notifications = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'is_contest_canceled_alert_to_participant' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_winner_selected_alert_to_participant' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_contest_completed_alert_to_participant' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_contest_amount_paid_alert_to_participant' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_entry_eliminated_alert_to_participant' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_entry_withdrawn_alert_to_participant' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_entry_lost_alert_to_participant' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_new_contest_entry_alert_to_contestholder' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_cancel_withdraw_entry_alert_to_participant' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_eliminate_entry_cancel_alert_to_participant' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_request_refund_reject_alert_to_contestholder' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_notification_for_new_message' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_payment_pending_alert_to_participant' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_activity_alert_to_contestholder' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_entry_deleted_alert_to_participant' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_contest_created_alert_to_participant' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'user_notifications_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $user_openids = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'openid' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'user_openids_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $user_profiles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'language_id' => array('type' => 'integer', 'null' => true),
		'first_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'last_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'middle_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'gender_id' => array('type' => 'integer', 'null' => true),
		'dob' => array('type' => 'date', 'null' => true),
		'about_me' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'address' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500),
		'city_id' => array('type' => 'integer', 'null' => true),
		'state_id' => array('type' => 'integer', 'null' => true),
		'country_id' => array('type' => 'integer', 'null' => true),
		'zip_code' => array('type' => 'string', 'null' => true),
		'education_id' => array('type' => 'integer', 'null' => true),
		'employment_id' => array('type' => 'integer', 'null' => true),
		'income_range_id' => array('type' => 'integer', 'null' => true),
		'relationship_id' => array('type' => 'integer', 'null' => true),
		'message_page_size' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'message_signature' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'user_profiles_city_id_idx' => array('unique' => false, 'column' => 'city_id'),
			'user_profiles_country_id_idx' => array('unique' => false, 'column' => 'country_id'),
			'user_profiles_education_id_idx' => array('unique' => false, 'column' => 'education_id'),
			'user_profiles_employment_id_idx' => array('unique' => false, 'column' => 'employment_id'),
			'user_profiles_gender_id_idx' => array('unique' => false, 'column' => 'gender_id'),
			'user_profiles_income_range_id_idx' => array('unique' => false, 'column' => 'income_range_id'),
			'user_profiles_language_id_idx' => array('unique' => false, 'column' => 'language_id'),
			'user_profiles_relationship_id_idx' => array('unique' => false, 'column' => 'relationship_id'),
			'user_profiles_state_id_idx' => array('unique' => false, 'column' => 'state_id'),
			'user_profiles_user_id_idx' => array('unique' => false, 'column' => 'user_id')
		),
		'tableParameters' => array()
	);
	public $user_views = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'user_id' => array('type' => 'integer', 'null' => true),
		'viewing_user_id' => array('type' => 'integer', 'null' => true),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'user_views_ip_id_idx' => array('unique' => false, 'column' => 'ip_id'),
			'user_views_user_id_idx' => array('unique' => false, 'column' => 'user_id'),
			'user_views_viewing_user_id_idx' => array('unique' => false, 'column' => 'viewing_user_id')
		),
		'tableParameters' => array()
	);
	public $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'role_id' => array('type' => 'integer', 'null' => true),
		'username' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 60),
		'password' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'available_wallet_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'commission_paid_amount' => array('type' => 'float', 'null' => true),
		'total_amount_withdrawn' => array('type' => 'float', 'null' => true),
		'website' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'image' => array('type' => 'string', 'null' => true, 'default' => null),
		'bio' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'timezone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'contest_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_user_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_user_own_count' => array('type' => 'integer', 'null' => true),
		'total_amount_deposited' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'total_site_revenue_as_participant' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'participant_total_earned_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'contest_user_won_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_files_expectation_count' => array('type' => 'integer', 'null' => true),
		'contest_user_eliminated_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_user_withdrawn_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_user_active_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_user_lost_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'total_site_revenue_as_contest_holder' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'contest_payment_pending_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_pending_approval_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_open_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_rejected_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_request_for_cancellation_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_canceled_by_admin_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_judging_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_pending_action_to_admin_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_winner_selected_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_winner_selected_by_admin_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_change_requested_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_change_completed_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_expecting_deliverables_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_completed_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_paid_to_participant_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_request_for_refund_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'contest_expired_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'user_openid_count' => array('type' => 'integer', 'null' => true),
		'user_login_count' => array('type' => 'integer', 'null' => true),
		'user_view_count' => array('type' => 'integer', 'null' => true),
		'contest_follower_count' => array('type' => 'integer', 'null' => true),
		'total_withdraw_request_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'total_ratings' => array('type' => 'integer', 'null' => true),
		'rating_count' => array('type' => 'integer', 'null' => true),
		'average_rating' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'blocked_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'available_balance_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'is_paid' => array('type' => 'boolean', 'null' => true),
		'is_email_confirmed' => array('type' => 'boolean', 'null' => true),
		'is_active' => array('type' => 'boolean', 'null' => true),
		'is_agree_terms_conditions' => array('type' => 'boolean', 'null' => true),
		'is_openid_register' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_facebook_register' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_twitter_register' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_google_register' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_yahoo_register' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_linkedin_register' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_affiliate_user' => array('type' => 'boolean', 'null' => true),
		'facebook_user_id' => array('type' => 'integer', 'null' => true),
		'facebook_access_token' => array('type' => 'string', 'null' => true, 'default' => null),
		'twitter_user_id' => array('type' => 'integer', 'null' => true),
		'twitter_access_key' => array('type' => 'string', 'null' => true, 'default' => null),
		'twitter_access_token' => array('type' => 'string', 'null' => true, 'default' => null),
		'twitter_avatar_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'google_user_id' => array('type' => 'string', 'null' => true, 'default' => null),
		'google_access_token' => array('type' => 'string', 'null' => true, 'default' => null),
		'googleplus_user_id' => array('type' => 'string', 'null' => true, 'default' => null),
		'is_googleplus_register' => array('type' => 'integer', 'null' => true),
		'is_googleplus_connected' => array('type' => 'boolean', 'null' => true),
		'googleplus_contacts_count' => array('type' => 'integer', 'null' => true),
		'googleplus_avatar_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'yahoo_user_id' => array('type' => 'string', 'null' => true, 'default' => null),
		'yahoo_access_token' => array('type' => 'string', 'null' => true, 'default' => null),
		'linkedin_user_id' => array('type' => 'string', 'null' => true, 'default' => null),
		'linkedin_access_token' => array('type' => 'string', 'null' => true, 'default' => null),
		'linkedin_avatar_url' => array('type' => 'string', 'null' => true, 'default' => null),
		'openid_user_id' => array('type' => 'string', 'null' => true, 'default' => null),
		'is_facebook_connected' => array('type' => 'boolean', 'null' => true),
		'is_twitter_connected' => array('type' => 'boolean', 'null' => true),
		'is_google_connected' => array('type' => 'boolean', 'null' => true),
		'is_yahoo_connected' => array('type' => 'boolean', 'null' => true),
		'is_linkedin_connected' => array('type' => 'boolean', 'null' => true),
		'cookie_hash' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50),
		'cookie_time_modified' => array('type' => 'datetime', 'null' => true),
		'signup_ip_id' => array('type' => 'integer', 'null' => true),
		'last_login_ip_id' => array('type' => 'integer', 'null' => true),
		'last_logged_in_time' => array('type' => 'datetime', 'null' => true),
		'mobile_app_time_modified' => array('type' => 'datetime', 'null' => true),
		'iphone_last_request' => array('type' => 'datetime', 'null' => true),
		'iphone_latitude' => array('type' => 'float', 'null' => true),
		'iphone_longitude' => array('type' => 'float', 'null' => true),
		'mobile_app_hash' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100),
		'iphone_last_access' => array('type' => 'datetime', 'null' => true),
		'fb_friends_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'twitter_followers_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'linkedin_contacts_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'google_contacts_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'yahoo_contacts_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'is_skipped_fb' => array('type' => 'boolean', 'null' => true),
		'is_skipped_twitter' => array('type' => 'boolean', 'null' => true),
		'is_skipped_google' => array('type' => 'boolean', 'null' => true),
		'is_skipped_yahoo' => array('type' => 'boolean', 'null' => true),
		'is_skipped_linkedin' => array('type' => 'boolean', 'null' => true),
		'user_avatar_source_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'referred_by_user_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'referred_by_user_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'referred_contest_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'total_commission_pending_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'total_commission_canceled_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'total_commission_completed_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'commission_line_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'commission_withdraw_request_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'pwd_reset_token' => array('type' => 'string', 'null' => true, 'default' => null),
		'pwd_reset_requested_date' => array('type' => 'datetime', 'null' => true),
		'is_idle' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'is_contest_posted' => array('type' => 'boolean', 'null' => true),
		'is_entry_posted' => array('type' => 'boolean', 'null' => true),
		'is_engaged' => array('type' => 'boolean', 'null' => true),
		'site_state_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'sudopay_gateway_id' => array('type' => 'integer', 'null' => true),
		'sudopay_receiver_account_id' => array('type' => 'integer', 'null' => true),
		'sudopay_revised_amount' => array('type' => 'float', 'null' => true),
		'sudopay_token' => array('type' => 'string', 'null' => true, 'default' => null),
		'invite_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'activity_message_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'security_question_id' => array('type' => 'integer', 'null' => true),
		'security_answer' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'users_facebook_user_id_idx' => array('unique' => false, 'column' => 'facebook_user_id'),
			'users_google_user_id_idx' => array('unique' => false, 'column' => 'google_user_id'),
			'users_googleplus_user_id_idx' => array('unique' => false, 'column' => 'googleplus_user_id'),
			'users_last_login_ip_id_idx' => array('unique' => false, 'column' => 'last_login_ip_id'),
			'users_linkedin_user_id_idx' => array('unique' => false, 'column' => 'linkedin_user_id'),
			'users_openid_user_id_idx' => array('unique' => false, 'column' => 'openid_user_id'),
			'users_referred_by_user_id_idx' => array('unique' => false, 'column' => 'referred_by_user_id'),
			'users_role_id_idx' => array('unique' => false, 'column' => 'role_id'),
			'users_signup_ip_id_idx' => array('unique' => false, 'column' => 'signup_ip_id'),
			'users_site_state_id_idx' => array('unique' => false, 'column' => 'site_state_id'),
			'users_sudopay_gateway_id_idx' => array('unique' => false, 'column' => 'sudopay_gateway_id'),
			'users_sudopay_receiver_account_id_idx' => array('unique' => false, 'column' => 'sudopay_receiver_account_id'),
			'users_twitter_user_id_idx' => array('unique' => false, 'column' => 'twitter_user_id'),
			'users_user_avatar_source_id_idx' => array('unique' => false, 'column' => 'user_avatar_source_id'),
			'users_yahoo_user_id_idx' => array('unique' => false, 'column' => 'yahoo_user_id')
		),
		'tableParameters' => array()
	);
	public $validation_rules = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'rule' => array('type' => 'string', 'null' => true, 'default' => null),
		'message' => array('type' => 'string', 'null' => true, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $vocabularies = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true, 'default' => null),
		'alias' => array('type' => 'string', 'null' => true, 'default' => null),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'required' => array('type' => 'boolean', 'null' => true),
		'multiple' => array('type' => 'boolean', 'null' => true),
		'tags' => array('type' => 'boolean', 'null' => true),
		'plugin' => array('type' => 'string', 'null' => true, 'default' => null),
		'weight' => array('type' => 'integer', 'null' => true),
		'updated' => array('type' => 'datetime', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'vocabularies_alias_key' => array('unique' => true, 'column' => 'alias')
		),
		'tableParameters' => array()
	);
	public $withdrawal_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'user_cash_withdrawal_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);
	public $security_questions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45),
		'is_active' => array('type' => 'boolean', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id'),
			'security_questions_slug_idx' => array('unique' => false, 'column' => 'slug'),
		),
		'tableParameters' => array()
	);
}
