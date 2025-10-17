<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace WolfSellers\ReferralManagement\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use WolfSellers\ReferralManagement\Setup\Patch\Data\InsertReferralStatusCodes;

/**
* Patch is mechanism, that allows to do atomic upgrade data changes
*/
class InsertReferralInitialData implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface $moduleDataSetup
     */
    private $moduleDataSetup;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * Do Upgrade
     *
     * @return void
     */
    public function apply()
    {
        /**
         * Fill table referral
         */
        $data = [
            ["Carlos", "Méndez", "carlos.mendez1@example.com", "+5215512345678"],
            ["Ana", "Rodríguez", "ana.rodriguez2@example.com", "15567890123"],
            ["Luis", "Hernández", "luis.hernandez3@example.com", "15532123456"],
            ["Sofía", "Torres", "sofia.torres4@example.com", "15511122233"],
            ["Diego", "García", "diego.garcia5@example.com", "15598765432"],
            ["Valeria", "Pérez", "valeria.perez6@example.com", "15523344556"],
            ["Juan", "Martínez", "juan.martinez7@example.com", "15588776655"],
            ["Isabella", "López", "isabella.lopez8@example.com", "15544433322"],
            ["Miguel", "Ramírez", "miguel.ramirez9@example.com", "+12025550123"],
            ["Fernanda", "Sánchez", "fernanda.sanchez10@example.com", "15512233445"]
        ];

        $binds = [];
        foreach ($data as $row) {
            $binds[] = [
                'first_name' => $row[0],
                'last_name' => $row[1],
                'email' => $row[2],
                'telephone' => $row[3],
                'customer_id' => 1 // roni_cost@example.com always exists as first customer
            ];
        }
        if (!empty($binds)) {
            $this->moduleDataSetup->getConnection()->insertMultiple(
                $this->moduleDataSetup->getTable('referral'),
                $binds
            );
        }
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [
            InsertReferralStatusCodes::class
        ];
    }
}
