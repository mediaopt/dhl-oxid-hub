<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace Mediaopt\DHL\cli;


use Mediaopt\DHL\Adapter\DHLAdapter;
use Mediaopt\DHL\Adapter\GKVCreateShipmentOrderRequestBuilder;
use Mediaopt\DHL\Api\GKV\Response\CreateShipmentOrderResponse;
use Mediaopt\DHL\Application\Model\Order;
use Mediaopt\DHL\Model\MoDHLLabel;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Registry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Mediaopt GmbH
 */
class CreateLabels extends Command
{

    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     */
    protected function configure()
    {
        $this
            ->setName('mo:dhl:create-labels')
            ->addOption('paid', null, null, 'Only create labels for paid orders')
            ->setDescription('Create labels for DHL shipments.');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return void
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseErrorException
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        if (!$orderIds = $this->getOrderIds()) {
            return;
        }
        $this->handleCreationResponse($this->callCreation($orderIds));
    }

    /**
     * @param string[] $orderIds
     * @return CreateShipmentOrderResponse
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function callCreation(array $orderIds)
    {
        $request = Registry::get(GKVCreateShipmentOrderRequestBuilder::class)->build($orderIds);
        return Registry::get(DHLAdapter::class)->buildGKV()->createShipmentOrder($request);
    }

    /**
     * @param CreateShipmentOrderResponse $response
     * @throws \Exception
     */
    protected function handleCreationResponse(CreateShipmentOrderResponse $response)
    {
        $createdLabels = 0;
        foreach ($response->getCreationState() as $creationState) {
            $statusInformation = $creationState->getLabelData()->getStatus();
            $order = \oxNew(Order::class);
            $order->load($creationState->getSequenceNumber());
            if ($errors = $statusInformation->getErrors()) {
                $this->output->writeln($this->translate('MO_DHL__BATCH_ERROR_CREATION_ERROR', [$order->getFieldData('oxordernr'), implode(' ', $errors)]));
                continue;
            }
            $label = MoDHLLabel::fromOrderAndCreationState($order, $creationState);
            $label->save();
            $createdLabels++;
        }
        $this->output->writeln($this->translate('MO_DHL__BATCH_LABELS_CREATED', [$createdLabels]));
    }

    /**
     * @return string[]
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseErrorException
     */
    protected function getOrderIds()
    {
        $select =
            ' SELECT oxorder.OXID FROM oxorder '
            . ' LEFT JOIN mo_dhl_labels mdl ON oxorder.OXID = mdl.orderId '
            . ' WHERE mdl.OXID IS NULL AND MO_DHL_PROCESS <> \'\' '
            . ($this->input->getOption('paid') ? ' AND oxpaid <> "0000-00-00 00:00:00"' : '');
        $db = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC);
        $orderIds = $db->getCol($select);
        $this->output->writeln($this->translate('MO_DHL__BATCH_ORDERS_FOUND', [count($orderIds), 'status']));
        return $orderIds;
    }

    /**
     * @param string $text
     * @param array  $params
     * @return string
     */
    protected function translate(string $text, array $params = []): string
    {
        $message = Registry::getLang()->translateString($text);
        $message = sprintf($message, ...$params);
        return $message;
    }
}
