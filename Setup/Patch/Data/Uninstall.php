<?php
/**
 * Refer to LICENSE.txt distributed with the Temando Shipping module for notice of license
 */
namespace MagentoEse\TemandoUninstall\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Setup\SchemaSetupInterface;
use MagentoEse\TemandoUninstall\Setup\TemandoRmaSetupSchema as RmaSetupSchema;
use MagentoEse\TemandoUninstall\Setup\TemandoSetupData as SetupData;
use MagentoEse\TemandoUninstall\Setup\TemandoSetupSchema as SetupSchema;
use Magento\Catalog\Model\Product;

class Uninstall implements DataPatchInterface{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /** @var SchemaSetupInterface  */
    private $setup;

    /**
     * Uninstall constructor.
     * @param EavSetupFactory $eavSetupFactory
     * @param SchemaSetupInterface $setup
     */
    public function __construct(EavSetupFactory $eavSetupFactory, SchemaSetupInterface $setup)
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->setup = $setup;
    }


    public function apply()
    {
        /** @var \Magento\Framework\Module\Setup $uninstaller */
        $uninstaller = $this->setup;

        $defaultConnection = $uninstaller->getConnection(ResourceConnection::DEFAULT_CONNECTION);
        $checkoutConnection = $uninstaller->getConnection(SetupSchema::CHECKOUT_CONNECTION_NAME);
        $salesConnection = $uninstaller->getConnection(SetupSchema::SALES_CONNECTION_NAME);

        $salesConnection->dropTable(SetupSchema::TABLE_ORDER);

        $checkoutConnection->dropTable(SetupSchema::TABLE_QUOTE_COLLECTION_POINT);
        $checkoutConnection->dropTable(SetupSchema::TABLE_COLLECTION_POINT_SEARCH);
        $checkoutConnection->dropTable(SetupSchema::TABLE_ORDER_COLLECTION_POINT);

        $checkoutConnection->dropTable(SetupSchema::TABLE_QUOTE_PICKUP_LOCATION);
        $checkoutConnection->dropTable(SetupSchema::TABLE_PICKUP_LOCATION_SEARCH);
        $checkoutConnection->dropTable(SetupSchema::TABLE_ORDER_PICKUP_LOCATION);

        $checkoutConnection->dropTable(SetupSchema::TABLE_CHECKOUT_ADDRESS);

        $salesConnection->dropTable(SetupSchema::TABLE_SHIPMENT);
        $defaultConnection->dropTable(RmaSetupSchema::TABLE_RMA_SHIPMENT);
        $defaultConnection->dropTable(SetupSchema::TABLE_PRODUCT_ATTRIBUTE_MAPPING);

        $eavSetup = $this->eavSetupFactory->create();
        $eavSetup->removeAttribute(Product::ENTITY, SetupData::ATTRIBUTE_CODE_HEIGHT);
        $eavSetup->removeAttribute(Product::ENTITY, SetupData::ATTRIBUTE_CODE_WIDTH);
        $eavSetup->removeAttribute(Product::ENTITY, SetupData::ATTRIBUTE_CODE_LENGTH);

        $eavSetup->removeAttribute(Product::ENTITY, SetupData::ATTRIBUTE_CODE_PACKAGING_TYPE);
        $eavSetup->removeAttribute(Product::ENTITY, SetupData::ATTRIBUTE_CODE_PACKAGING_ID);
        $eavSetup->removeAttribute(Product::ENTITY, SetupData::ATTRIBUTE_CODE_COUNTRY_OF_ORIGIN);
        $eavSetup->removeAttribute(Product::ENTITY, SetupData::ATTRIBUTE_CODE_HS_CODE);

        $configTable = $uninstaller->getTable('core_config_data');
        $defaultConnection->delete($configTable, "`path` LIKE 'carriers/temando/%'");
    }

    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
