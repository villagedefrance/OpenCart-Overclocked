<?php
class ControllerCommonNotification extends Controller {

	protected function index() {
		$this->data['title'] = $this->document->getTitle();

		$this->language->load('common/notification');

		$this->data['text_notification'] = $this->language->get('text_notification');
		$this->data['text_order'] = $this->language->get('text_order');
		$this->data['text_pending_status'] = $this->language->get('text_pending_status');
		$this->data['text_complete_status'] = $this->language->get('text_complete_status');
		$this->data['text_return'] = $this->language->get('text_return');
		$this->data['text_customer'] = $this->language->get('text_customer');
		$this->data['text_online'] = $this->language->get('text_online');
		$this->data['text_deleted'] = $this->language->get('text_deleted');
		$this->data['text_approval'] = $this->language->get('text_approval');
		$this->data['text_product'] = $this->language->get('text_product');
		$this->data['text_stock'] = $this->language->get('text_stock');
		$this->data['text_low_stock'] = $this->language->get('text_low_stock');
		$this->data['text_review'] = $this->language->get('text_review');
		$this->data['text_affiliate'] = $this->language->get('text_affiliate');

		$this->data['order'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['customer'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['product'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['affiliate'] = $this->url->link('sale/affiliate', 'token=' . $this->session->data['token'], 'SSL');

		// Menu Icons
		$this->data['icons'] = $this->config->get('config_admin_menu_icons');

		// Preferences
		$notifications = $this->config->get('config_notifications');

		$notification_pending = $this->config->get('config_notification_pending');
		$notification_complete = $this->config->get('config_notification_complete');
		$notification_return = $this->config->get('config_notification_return');
		$notification_online = $this->config->get('config_notification_online');
		$notification_deleted = $this->config->get('config_notification_deleted');
		$notification_approval = $this->config->get('config_notification_approval');
		$notification_stock = $this->config->get('config_notification_stock');
		$notification_low = $this->config->get('config_notification_low');
		$notification_review = $this->config->get('config_notification_review');
		$notification_affiliate = $this->config->get('config_notification_affiliate');

		if ($notifications) {
			if (!$notification_pending && !$notification_complete && !$notification_return && !$notification_online && !$notification_deleted && !$notification_approval && !$notification_stock && !$notification_low && !$notification_review && !$notification_affiliate) {
				$this->data['notifications'] = false;
			} else {
				$this->data['notifications'] = true;
			}
		} else {
			$this->data['notifications'] = false;
		}

		if (!$notification_pending && !$notification_complete && !$notification_return) {
			$this->data['notification_order'] = false;
		} else {
			$this->data['notification_order'] = true;
		}

		$this->data['notification_pending'] = $notification_pending;
		$this->data['notification_complete'] = $notification_complete;
		$this->data['notification_return'] = $notification_return;

		if (!$notification_online && !$notification_deleted && !$notification_approval) {
			$this->data['notification_customer'] = false;
		} else {
			$this->data['notification_customer'] = true;
		}

		$this->data['notification_online'] = $notification_online;
		$this->data['notification_deleted'] = $notification_deleted;
		$this->data['notification_approval'] = $notification_approval;

		if (!$notification_stock && !$notification_low && !$notification_review) {
			$this->data['notification_product'] = false;
		} else {
			$this->data['notification_product'] = true;
		}

		$this->data['notification_stock'] = $notification_stock;
		$this->data['notification_low'] = $notification_low;
		$this->data['notification_review'] = $notification_review;

		$this->data['notification_affiliate'] = $notification_affiliate;

		// Orders
		$this->load->model('sale/order');

		if ($notification_pending) {
			$pending_status_total = $this->model_sale_order->getTotalOrders(array('filter_order_status_id' => $this->config->get('config_order_status_id')));
		} else {
			$pending_status_total = 0;
		}

		$this->data['pending_status_total'] = $pending_status_total;

		$this->data['pending_status'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&filter_order_status_id=' . $this->config->get('config_order_status_id'), 'SSL');

		if ($notification_complete) {
			$complete_status_total = $this->model_sale_order->getTotalOrders(array('filter_order_status_id' => $this->config->get('config_complete_status_id')));
		} else {
			$complete_status_total = 0;
		}

		$this->data['complete_status_total'] = $complete_status_total;

		$this->data['complete_status'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&filter_order_status_id=' . $this->config->get('config_complete_status_id'), 'SSL');

		// Returns
		if ($this->config->get('config_return_disable')) {
			$this->data['allow_return'] = false;
		} else {
			$this->data['allow_return'] = true;
		}

		$this->load->model('sale/return');

		if ($notification_return) {
			$return_total = $this->model_sale_return->getTotalReturns(array('filter_return_status_id' => $this->config->get('config_return_status_id')));
		} else {
			$return_total = 0;
		}

		$this->data['return_total'] = $return_total;

		$this->data['return'] = $this->url->link('sale/return', 'token=' . $this->session->data['token'], 'SSL');

		// Customers
		if ($this->config->get('config_customer_online')) {
			$this->data['allow_online'] = true;
		} else {
			$this->data['allow_online'] = false;
		}

		$this->load->model('report/customer');

		if ($notification_online) {
			$online_total = $this->model_report_customer->getTotalCustomersOnline();
		} else {
			$online_total = 0;
		}

		$this->data['online_total'] = $online_total;

		$this->data['online'] = $this->url->link('report/customer_online', 'token=' . $this->session->data['token'], 'SSL');

		$this->load->model('sale/customer');

		if ($notification_deleted) {
			$deleted_total = $this->model_sale_customer->getTotalCustomersDeleted(0);
		} else {
			$deleted_total = 0;
		}

		$this->data['deleted_total'] = $deleted_total;

		$this->data['deleted'] = $this->url->link('report/customer_deleted', 'token=' . $this->session->data['token'], 'SSL');

		if ($notification_approval) {
			$customer_total = $this->model_sale_customer->getTotalCustomers(array('filter_approved' => false));
		} else {
			$customer_total = 0;
		}

		$this->data['customer_total'] = $customer_total;

		$this->data['customer_approval'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&filter_approved=0', 'SSL');

		// Products
		$this->load->model('catalog/product');

		if ($notification_stock) {
			$product_total = $this->model_catalog_product->getTotalProducts(array('filter_quantity' => 0, 'filter_status' => 1));
		} else {
			$product_total = 0;
		}

		$this->data['product_total'] = $product_total;

		$this->data['product_outstock'] = $this->url->link('report/product_quantity', 'token=' . $this->session->data['token'] . '&filter_quantity=0&filter_status=1', 'SSL');

		if ($notification_low) {
			$product_total_low = $this->model_catalog_product->getTotalLowStockProducts();
		} else {
			$product_total_low = 0;
		}

		$this->data['product_total_low'] = $product_total_low;

		$this->data['product_lowstock'] = $this->url->link('report/product_quantity', 'token=' . $this->session->data['token'] . '&filter_status=1', 'SSL');

		// Reviews
		if ($this->config->get('config_review_status')) {
			$this->data['allow_review'] = true;
		} else {
			$this->data['allow_review'] = false;
		}

		$this->load->model('catalog/review');

		if ($notification_review) {
			$review_total = $this->model_catalog_review->getTotalReviews(array('filter_status' => false));
		} else {
			$review_total = 0;
		}

		$this->data['review_total'] = $review_total;

		$this->data['review'] = $this->url->link('catalog/review', 'token=' . $this->session->data['token'] . '&sort=r.status&order=ASC', 'SSL');

		// Affiliates
		if ($this->config->get('config_affiliate_disable')) {
			$this->data['allow_affiliate'] = false;
		} else {
			$this->data['allow_affiliate'] = true;
		}

		$this->load->model('sale/affiliate');

		if ($notification_affiliate) {
			$affiliate_total = $this->model_sale_affiliate->getTotalAffiliates(array('filter_approved' => false));
		} else {
			$affiliate_total = 0;
		}

		$this->data['affiliate_total'] = $affiliate_total;

		$this->data['affiliate_approval'] = $this->url->link('sale/affiliate', 'token=' . $this->session->data['token'] . '&filter_approved=0', 'SSL');

		// Notification totals
		$this->data['alerts_complete'] = number_format($complete_status_total + $online_total);
		$this->data['alerts_attention'] = number_format($pending_status_total + $product_total_low + $deleted_total + $review_total);
		$this->data['alerts_warning'] = number_format($return_total + $customer_total + $product_total + $affiliate_total);

		$this->template = 'common/notification.tpl';
		$this->render();
	}
}
