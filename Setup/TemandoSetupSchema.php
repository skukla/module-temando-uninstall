<?php

namespace MagentoEse\TemandoUninstall\Setup;


class TemandoSetupSchema
{
    const CHECKOUT_CONNECTION_NAME = 'checkout';
    const SALES_CONNECTION_NAME = 'sales';

    const TABLE_SHIPMENT = 'temando_shipment';
    const TABLE_ORDER = 'temando_order';
    const TABLE_CHECKOUT_ADDRESS = 'temando_checkout_address';

    const TABLE_COLLECTION_POINT_SEARCH = 'temando_collection_point_search';
    const TABLE_QUOTE_COLLECTION_POINT = 'temando_quote_collection_point';
    const TABLE_ORDER_COLLECTION_POINT = 'temando_order_collection_point';

    const TABLE_PICKUP_LOCATION_SEARCH = 'temando_pickup_location_search';
    const TABLE_QUOTE_PICKUP_LOCATION = 'temando_quote_pickup_location';
    const TABLE_ORDER_PICKUP_LOCATION = 'temando_order_pickup_location';

    const TABLE_PRODUCT_ATTRIBUTE_MAPPING = 'temando_product_attribute_mapping';

}
